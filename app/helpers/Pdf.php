<?php
// ============================================================
// Pdf — minimal, dependency-free PDF writer
//
// Why this exists: Composer is not available on this deployment and no PDF
// library is vendored. This produces a valid PDF 1.4 file using only the 14
// standard Type1 fonts (which every reader has built in, so nothing needs
// embedding) plus zlib for stream compression.
//
// Scope is deliberately narrow — text, rules, boxes and page flow. That is
// all an offer letter needs. It is not a general HTML-to-PDF engine.
// ============================================================

class Pdf {

    // A4 at 72 dpi, the PDF default user space unit.
    private const PAGE_W = 595.28;
    private const PAGE_H = 841.89;

    private float $marginX = 56.0;
    private float $marginTop = 56.0;
    private float $marginBottom = 64.0;

    /** @var string[] Content streams, one per page. */
    private array $pages = [];
    private string $buf = '';
    private float $y;

    /**
     * When false, drawing below the bottom margin will NOT start a new page.
     * Needed for absolutely-positioned furniture like the letterhead and the
     * page footer, which legitimately sit outside the text column.
     */
    private bool $autoBreak = true;

    private string $title;

    public function __construct(string $title = 'Document') {
        $this->title = $title;
        $this->y     = self::PAGE_H - $this->marginTop;
    }

    // ── Geometry ─────────────────────────────────────────────────────────

    private function contentWidth(): float {
        return self::PAGE_W - (2 * $this->marginX);
    }

    public function y(): float {
        return $this->y;
    }

    public function moveTo(float $y): void {
        $this->y = $y;
    }

    /**
     * Advance down the page.
     */
    public function gap(float $points): void {
        $this->y -= $points;
        $this->breakIfNeeded();
    }

    private function breakIfNeeded(float $needed = 0.0): void {
        if (!$this->autoBreak) {
            return;
        }
        if ($this->y - $needed < $this->marginBottom) {
            $this->newPage();
        }
    }

    /**
     * Temporarily disable automatic page breaks, for absolutely-positioned
     * content such as the letterhead band and the footer.
     */
    public function setAutoBreak(bool $enabled): void {
        $this->autoBreak = $enabled;
    }

    public function newPage(): void {
        if ($this->buf !== '') {
            $this->pages[] = $this->buf;
            $this->buf     = '';
        }
        $this->y = self::PAGE_H - $this->marginTop;
    }

    // ── Text ─────────────────────────────────────────────────────────────

    /**
     * Draw a single line of text at an explicit x offset.
     *
     * @param string $font One of: helvetica, helvetica-bold, times, times-bold,
     *                     times-italic, courier.
     */
    public function text(
        string $text,
        float $size = 10.5,
        string $font = 'helvetica',
        ?float $x = null,
        ?array $rgb = null
    ): void {
        $x = $x ?? $this->marginX;
        $this->breakIfNeeded($size * 1.2);

        $this->buf .= "BT\n";
        $this->buf .= '/' . $this->fontKey($font) . ' ' . $this->num($size) . " Tf\n";
        if ($rgb) {
            $this->buf .= $this->colorOp($rgb);
        }
        $this->buf .= $this->num($x) . ' ' . $this->num($this->y) . " Td\n";
        $this->buf .= '(' . $this->escape($text) . ") Tj\n";
        $this->buf .= "ET\n";
        if ($rgb) {
            $this->buf .= "0 0 0 rg\n";
        }
    }

    /**
     * Draw right-aligned text.
     */
    public function textRight(string $text, float $size = 10.5, string $font = 'helvetica', ?array $rgb = null): void {
        $w = $this->widthOf($text, $size, $font);
        $this->text($text, $size, $font, self::PAGE_W - $this->marginX - $w, $rgb);
    }

    /**
     * Draw centred text.
     */
    public function textCenter(string $text, float $size = 10.5, string $font = 'helvetica', ?array $rgb = null): void {
        $w = $this->widthOf($text, $size, $font);
        $this->text($text, $size, $font, ($this->pageWidth() - $w) / 2, $rgb);
    }

    public function pageWidth(): float {
        return self::PAGE_W;
    }

    /**
     * Word-wrap a paragraph into the content width and advance past it.
     */
    public function paragraph(
        string $text,
        float $size = 10.5,
        string $font = 'helvetica',
        float $leading = 1.55,
        ?float $width = null
    ): void {
        $width = $width ?? $this->contentWidth();
        $lineH = $size * $leading;

        foreach ($this->wrap($text, $size, $font, $width) as $line) {
            $this->breakIfNeeded($lineH);
            $this->text($line, $size, $font);
            $this->y -= $lineH;
        }
    }

    /**
     * Split text into lines that fit $width. Respects existing newlines.
     *
     * @return string[]
     */
    private function wrap(string $text, float $size, string $font, float $width): array {
        $out = [];

        foreach (preg_split('/\r\n|\r|\n/', $text) ?: [] as $block) {
            $block = trim($block);
            if ($block === '') {
                $out[] = '';
                continue;
            }

            $line = '';
            foreach (explode(' ', $block) as $word) {
                $probe = $line === '' ? $word : $line . ' ' . $word;

                if ($this->widthOf($probe, $size, $font) <= $width) {
                    $line = $probe;
                    continue;
                }

                if ($line !== '') {
                    $out[] = $line;
                }

                // A single word longer than the line — hard-split it.
                while ($this->widthOf($word, $size, $font) > $width && mb_strlen($word) > 1) {
                    $cut = mb_strlen($word);
                    while ($cut > 1 && $this->widthOf(mb_substr($word, 0, $cut), $size, $font) > $width) {
                        $cut--;
                    }
                    $out[] = mb_substr($word, 0, $cut);
                    $word  = mb_substr($word, $cut);
                }
                $line = $word;
            }

            if ($line !== '') {
                $out[] = $line;
            }
        }

        return $out;
    }

    // ── Vector primitives ────────────────────────────────────────────────

    /**
     * Horizontal rule across the content width.
     */
    public function rule(float $thickness = 0.6, ?array $rgb = null): void {
        $this->breakIfNeeded(4);
        $rgb = $rgb ?? [0.80, 0.82, 0.85];
        $this->buf .= $this->colorOp($rgb, true);
        $this->buf .= $this->num($thickness) . " w\n";
        $this->buf .= $this->num($this->marginX) . ' ' . $this->num($this->y) . " m\n";
        $this->buf .= $this->num(self::PAGE_W - $this->marginX) . ' ' . $this->num($this->y) . " l\nS\n";
        $this->buf .= "0 0 0 RG\n";
    }

    /**
     * Filled rectangle. $y is the BOTTOM edge.
     */
    public function rect(float $x, float $y, float $w, float $h, array $rgb): void {
        $this->buf .= $this->colorOp($rgb);
        $this->buf .= $this->num($x) . ' ' . $this->num($y) . ' '
            . $this->num($w) . ' ' . $this->num($h) . " re f\n";
        $this->buf .= "0 0 0 rg\n";
    }

    /**
     * A full-width band behind the current line, used for the letterhead.
     */
    public function band(float $height, array $rgb): void {
        $this->rect(0, $this->y - $height, self::PAGE_W, $height, $rgb);
    }

    /**
     * Two-column label/value row, as used for the offer summary block.
     */
    public function row(string $label, string $value, float $size = 10.0, float $labelWidth = 130.0): void {
        $lineH = $size * 1.7;
        $this->breakIfNeeded($lineH);
        $this->text($label, $size, 'helvetica', $this->marginX, [0.42, 0.45, 0.50]);

        // Value may wrap within its remaining column.
        $valueX     = $this->marginX + $labelWidth;
        $valueWidth = self::PAGE_W - $this->marginX - $valueX;
        $lines      = $this->wrap($value, $size, 'helvetica-bold', $valueWidth);

        $first = true;
        foreach ($lines as $line) {
            if (!$first) {
                $this->y -= $size * 1.4;
                $this->breakIfNeeded($size * 1.4);
            }
            $this->text($line, $size, 'helvetica-bold', $valueX);
            $first = false;
        }

        $this->y -= $lineH;
    }

    // ── Font metrics ─────────────────────────────────────────────────────

    /**
     * Map a friendly font name to the resource key used in the page dict.
     */
    private function fontKey(string $font): string {
        return match (strtolower($font)) {
            'helvetica-bold' => 'F2',
            'times'          => 'F3',
            'times-bold'     => 'F4',
            'times-italic'   => 'F5',
            'courier'        => 'F6',
            default          => 'F1',
        };
    }

    /**
     * Approximate string width in points.
     *
     * Full AFM tables would be overkill here, so this uses per-character
     * width classes for the Helvetica/Times families. It is accurate enough
     * for wrapping and alignment in a letter; Courier is exact because it is
     * monospaced.
     */
    public function widthOf(string $text, float $size, string $font = 'helvetica'): float {
        $font = strtolower($font);

        if ($font === 'courier') {
            return mb_strlen($text) * 0.600 * $size;
        }

        $bold  = str_contains($font, 'bold');
        $serif = str_contains($font, 'times');
        $units = 0.0;

        $len = mb_strlen($text);
        for ($i = 0; $i < $len; $i++) {
            $ch = mb_substr($text, $i, 1);
            $units += $this->charWidth($ch, $serif, $bold);
        }

        return $units * $size;
    }

    private function charWidth(string $ch, bool $serif, bool $bold): float {
        // Width classes expressed as a fraction of the font size.
        if ($ch === ' ') {
            return $serif ? 0.250 : 0.278;
        }
        if (str_contains('ijltI.,;:!|\'`', $ch)) {
            return $serif ? 0.280 : 0.255;
        }
        if (str_contains('fr()[]{}/\\-', $ch)) {
            return $serif ? 0.333 : 0.333;
        }
        if (str_contains('0123456789', $ch)) {
            return $serif ? 0.500 : 0.556;
        }
        if (str_contains('MW', $ch)) {
            return $serif ? 0.889 : 0.889;
        }
        if (str_contains('mw', $ch)) {
            return $serif ? 0.778 : 0.833;
        }
        if (ctype_upper($ch)) {
            return $serif ? ($bold ? 0.700 : 0.667) : ($bold ? 0.722 : 0.667);
        }
        // Lower-case and everything else.
        return $serif ? ($bold ? 0.520 : 0.480) : ($bold ? 0.556 : 0.520);
    }

    // ── Low-level encoding ───────────────────────────────────────────────

    /**
     * PDF numbers must use a dot, regardless of locale.
     */
    private function num(float $n): string {
        return rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.') ?: '0';
    }

    private function colorOp(array $rgb, bool $stroke = false): string {
        [$r, $g, $b] = $rgb;
        return $this->num($r) . ' ' . $this->num($g) . ' ' . $this->num($b)
            . ($stroke ? " RG\n" : " rg\n");
    }

    /**
     * Escape a string for a PDF literal and fold it to WinAnsi.
     */
    private function escape(string $s): string {
        $s = $this->toWinAnsi($s);
        return str_replace(['\\', '(', ')', "\r"], ['\\\\', '\\(', '\\)', ''], $s);
    }

    /**
     * The standard fonts are single-byte. Convert UTF-8 to CP1252 and replace
     * the typographic characters our templates actually use so an en dash or a
     * curly quote never renders as mojibake.
     */
    private function toWinAnsi(string $s): string {
        $map = [
            "\u{2018}" => "'", "\u{2019}" => "'",
            "\u{201C}" => '"', "\u{201D}" => '"',
            "\u{2013}" => '-', "\u{2014}" => '-',
            "\u{2026}" => '...', "\u{00A0}" => ' ',
            "\u{20B9}" => 'INR ', "\u{2022}" => '-',
            "\u{00D7}" => 'x',  "\u{2192}" => '->',
        ];
        $s = strtr($s, $map);

        $converted = @iconv('UTF-8', 'CP1252//TRANSLIT', $s);
        if ($converted === false) {
            $converted = preg_replace('/[^\x20-\x7E]/', '', $s) ?? '';
        }

        return $converted;
    }

    // ── Output ───────────────────────────────────────────────────────────

    /**
     * Assemble the document and return the raw PDF bytes.
     */
    public function output(): string {
        if ($this->buf !== '') {
            $this->pages[] = $this->buf;
            $this->buf     = '';
        }
        if (!$this->pages) {
            $this->pages[] = '';
        }

        $pageCount = count($this->pages);

        // Object numbering:
        //   1 Catalog, 2 Pages, 3..8 Fonts,
        //   then per page: Page dict + Contents stream.
        $fontBase    = 3;
        $firstPageId = $fontBase + 6;

        $objects = [];

        $kids = [];
        for ($i = 0; $i < $pageCount; $i++) {
            $kids[] = ($firstPageId + ($i * 2)) . ' 0 R';
        }

        $objects[1] = "<< /Type /Catalog /Pages 2 0 R >>";
        $objects[2] = "<< /Type /Pages /Count {$pageCount} /Kids [" . implode(' ', $kids) . '] >>';

        $fonts = [
            'Helvetica',
            'Helvetica-Bold',
            'Times-Roman',
            'Times-Bold',
            'Times-Italic',
            'Courier',
        ];
        foreach ($fonts as $i => $base) {
            $objects[$fontBase + $i] =
                "<< /Type /Font /Subtype /Type1 /BaseFont /{$base} /Encoding /WinAnsiEncoding >>";
        }

        $fontRes = [];
        foreach ($fonts as $i => $unused) {
            $fontRes[] = '/F' . ($i + 1) . ' ' . ($fontBase + $i) . ' 0 R';
        }
        $resources = '<< /Font << ' . implode(' ', $fontRes) . ' >> >>';

        foreach ($this->pages as $i => $stream) {
            $pageId     = $firstPageId + ($i * 2);
            $contentsId = $pageId + 1;

            $objects[$pageId] = '<< /Type /Page /Parent 2 0 R '
                . '/MediaBox [0 0 ' . $this->num(self::PAGE_W) . ' ' . $this->num(self::PAGE_H) . '] '
                . '/Resources ' . $resources . ' '
                . "/Contents {$contentsId} 0 R >>";

            $compressed = function_exists('gzcompress') ? gzcompress($stream, 9) : false;

            if ($compressed !== false) {
                $objects[$contentsId] = '<< /Length ' . strlen($compressed)
                    . " /Filter /FlateDecode >>\nstream\n" . $compressed . "\nendstream";
            } else {
                $objects[$contentsId] = '<< /Length ' . strlen($stream)
                    . " >>\nstream\n" . $stream . "\nendstream";
            }
        }

        ksort($objects);

        // Serialise with a cross-reference table.
        $pdf     = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offsets = [];

        foreach ($objects as $id => $body) {
            $offsets[$id] = strlen($pdf);
            $pdf .= "{$id} 0 obj\n{$body}\nendobj\n";
        }

        $maxId     = max(array_keys($objects));
        $xrefStart = strlen($pdf);

        $pdf .= 'xref' . "\n" . '0 ' . ($maxId + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($id = 1; $id <= $maxId; $id++) {
            $pdf .= isset($offsets[$id])
                ? sprintf("%010d 00000 n \n", $offsets[$id])
                : "0000000000 65535 f \n";
        }

        $docId = strtoupper(bin2hex(random_bytes(16)));

        $pdf .= "trailer\n<< /Size " . ($maxId + 1) . " /Root 1 0 R "
            . '/Info << /Title (' . $this->escape($this->title) . ') '
            . '/Producer (' . $this->escape(COMPANY_LEGAL_NAME . ' Portal') . ') '
            . '/CreationDate (D:' . date('YmdHis') . "+05'30') >> "
            . "/ID [<{$docId}> <{$docId}>] >>\n";
        $pdf .= "startxref\n{$xrefStart}\n%%EOF";

        return $pdf;
    }

    /**
     * Stream the PDF to the browser as a download.
     */
    public function download(string $filename): never {
        $bytes = $this->output();

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($bytes));
        header('Cache-Control: private, no-store, max-age=0');
        header('X-Content-Type-Options: nosniff');
        echo $bytes;
        exit;
    }
}

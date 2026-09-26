<?php
// ============================================================
// OfferLetter — composes the internship offer letter PDF
//
// Kept separate from Pdf so the writer stays generic and the letter wording
// lives in one obvious place. Generated on demand, so it always reflects the
// current record rather than a stale stored file.
// ============================================================

require_once __DIR__ . '/Pdf.php';

class OfferLetter {

    // Brand colours, matching the site (#22c55e on near-black).
    private const ECO   = [0.133, 0.773, 0.369];
    private const INK   = [0.07, 0.09, 0.12];
    private const MUTED = [0.42, 0.45, 0.50];

    /**
     * Build the offer letter for one application row.
     *
     * @param array $app Joined row: application + intern + track fields.
     */
    public static function build(array $app): Pdf {
        $refNo   = (string) ($app['offer_letter_no'] ?: $app['ref_no']);
        $name    = (string) $app['intern_name'];
        $track   = (string) $app['track_title'];
        $weeks   = (int) ($app['duration_weeks'] ?? 8);
        $stipend = (string) ($app['stipend_text'] ?? 'Performance based');
        $mode    = (string) ($app['mode'] ?? 'Remote / Hybrid');

        $issued  = !empty($app['approved_at']) ? strtotime((string) $app['approved_at']) : time();
        $start   = !empty($app['start_date'])
            ? strtotime((string) $app['start_date'])
            : strtotime('+14 days', $issued);
        $end     = strtotime("+{$weeks} weeks", $start);

        $pdf = new Pdf('Internship Offer Letter - ' . $refNo);

        self::letterhead($pdf);
        self::meta($pdf, $refNo, $issued);
        self::salutation($pdf, $name, $track);
        self::summary($pdf, $track, $weeks, $start, $end, $stipend, $mode);
        self::terms($pdf, $weeks);
        self::signature($pdf);
        self::footer($pdf);

        return $pdf;
    }

    /**
     * Suggested download filename.
     */
    public static function filename(array $app): string {
        $slug = preg_replace('/[^A-Za-z0-9]+/', '_', (string) $app['intern_name']) ?? 'candidate';
        $slug = trim($slug, '_') ?: 'candidate';
        $ref  = preg_replace('/[^A-Za-z0-9\-]/', '', (string) ($app['offer_letter_no'] ?: $app['ref_no'])) ?? '';
        return 'Offer_Letter_' . $slug . '_' . $ref . '.pdf';
    }

    // ── Sections ─────────────────────────────────────────────────────────

    private static function letterhead(Pdf $pdf): void {
        // Absolutely positioned: suppress page breaks while drawing it.
        $pdf->setAutoBreak(false);

        // Dark band across the top carrying the company identity.
        $pdf->moveTo(841.89);
        $pdf->band(96, self::INK);

        $pdf->moveTo(841.89 - 40);
        $pdf->text(strtoupper(COMPANY_LEGAL_NAME), 19, 'helvetica-bold', 56, [1, 1, 1]);

        $pdf->moveTo(841.89 - 58);
        $pdf->text('Building Sustainable Digital Futures', 9.5, 'helvetica', 56, self::ECO);

        $pdf->moveTo(841.89 - 74);
        $pdf->text(COMPANY_ADDRESS, 8.5, 'helvetica', 56, [0.62, 0.65, 0.70]);

        // Right-hand contact block inside the band.
        $pdf->moveTo(841.89 - 44);
        $pdf->textRight(COMPANY_EMAIL, 8.5, 'helvetica', [0.75, 0.78, 0.82]);
        $pdf->moveTo(841.89 - 58);
        $pdf->textRight(COMPANY_PHONE, 8.5, 'helvetica', [0.75, 0.78, 0.82]);

        // Thin accent line under the band.
        $pdf->rect(0, 841.89 - 99, 595.28, 3, self::ECO);

        $pdf->moveTo(841.89 - 140);
        $pdf->setAutoBreak(true);
    }

    private static function meta(Pdf $pdf, string $refNo, int $issued): void {
        $pdf->text('Ref: ' . $refNo, 9.5, 'helvetica-bold');
        $pdf->textRight('Date: ' . date('d F Y', $issued), 9.5, 'helvetica');
        $pdf->gap(20);

        $pdf->text('INTERNSHIP OFFER LETTER', 14, 'helvetica-bold');
        $pdf->gap(8);
        $pdf->rule(0.8, self::ECO);
        $pdf->gap(19);
    }

    private static function salutation(Pdf $pdf, string $name, string $track): void {
        $pdf->text('Dear ' . $name . ',', 11, 'helvetica-bold');
        $pdf->gap(17);

        $pdf->paragraph(
            'Congratulations. Following our review of your application and profile, we are pleased to '
            . 'offer you an internship with ' . COMPANY_LEGAL_NAME . ' in the ' . $track . ' track. '
            . 'Your application stood out and we would be glad to have you work with our engineering team.',
            10.5
        );
        $pdf->gap(7);
    }

    private static function summary(
        Pdf $pdf,
        string $track,
        int $weeks,
        int $start,
        int $end,
        string $stipend,
        string $mode
    ): void {
        $pdf->text('Offer Details', 11, 'helvetica-bold');
        $pdf->gap(6);
        $pdf->rule(0.5);
        $pdf->gap(18);

        $pdf->row('Position',    $track . ' Intern');
        $pdf->row('Duration',    $weeks . ' weeks');
        $pdf->row('Start Date',  date('d F Y', $start));
        $pdf->row('End Date',    date('d F Y', $end));
        $pdf->row('Work Mode',   $mode);
        $pdf->row('Stipend',     $stipend);
        $pdf->row('Reporting To', OFFER_SIGNATORY . ', ' . OFFER_SIGNATORY_TITLE);

        $pdf->gap(8);
    }

    private static function terms(Pdf $pdf, int $weeks): void {
        $pdf->text('Terms of the Internship', 11, 'helvetica-bold');
        $pdf->gap(6);
        $pdf->rule(0.5);
        $pdf->gap(18);

        $terms = [
            'This internship is a learning engagement of ' . $weeks . ' weeks and does not by itself '
                . 'constitute an offer of permanent employment.',
            'You are expected to treat all project material, source code, client information and internal '
                . 'documentation as strictly confidential, both during and after the internship.',
            'Work you produce during the internship in the course of assigned tasks remains the '
                . 'intellectual property of ' . COMPANY_LEGAL_NAME . '.',
            'A certificate of completion will be issued on satisfactory completion of the full term and '
                . 'the assigned deliverables.',
            'Either party may end the engagement with prior written notice of seven days.',
        ];

        $i = 1;
        foreach ($terms as $term) {
            $pdf->paragraph($i . '.  ' . $term, 10, 'helvetica', 1.45);
            $pdf->gap(4);
            $i++;
        }

        $pdf->gap(4);
        $pdf->paragraph(
            'To accept this offer, please reply to ' . COMPANY_EMAIL . ' confirming your acceptance and '
            . 'your availability for the start date above.',
            10.5
        );
        $pdf->gap(16);
    }

    private static function signature(Pdf $pdf): void {
        // Keep the signature block intact rather than orphaning it.
        if ($pdf->y() < 150) {
            $pdf->newPage();
            $pdf->gap(30);
        }

        $pdf->text('With best regards,', 10.5);
        $pdf->gap(30);

        $pdf->rule(0.6);
        $pdf->gap(14);
        $pdf->text(OFFER_SIGNATORY, 11, 'helvetica-bold');
        $pdf->gap(14);
        $pdf->text(OFFER_SIGNATORY_TITLE, 9.5, 'helvetica', null, self::MUTED);
        $pdf->gap(13);
        $pdf->text(COMPANY_LEGAL_NAME, 9.5, 'helvetica', null, self::MUTED);
    }

    private static function footer(Pdf $pdf): void {
        // Sits below the text column by design.
        $pdf->setAutoBreak(false);

        $pdf->moveTo(58);
        $pdf->rule(0.5);
        $pdf->moveTo(44);
        $pdf->textCenter(
            COMPANY_LEGAL_NAME . '  |  ' . COMPANY_ADDRESS . '  |  ' . COMPANY_EMAIL,
            7.8,
            'helvetica',
            self::MUTED
        );
        $pdf->moveTo(33);
        $pdf->textCenter(
            'This is a system-generated letter issued through the Ecotech Services internship portal.',
            7.4,
            'helvetica',
            [0.58, 0.61, 0.66]
        );
    }
}

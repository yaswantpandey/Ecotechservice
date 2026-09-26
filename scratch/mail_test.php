<?php
// ============================================================
// SMTP self-test — run from the command line, never over the web.
//
//   php scratch/mail_test.php you@example.com
//
// Reads credentials from .env only. Prints no secret values: the password is
// reported as a length and nothing else, so output is safe to paste or share.
// ============================================================

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This diagnostic is CLI-only.\n");
}

require_once __DIR__ . '/../config/config.php';

$to = $argv[1] ?? SMTP_FROM;

echo "=== Ecotech SMTP self-test ===\n\n";

// ── Configuration (no secrets echoed) ────────────────────────────────────
$rows = [
    'SMTP_HOST'       => SMTP_HOST,
    'SMTP_PORT'       => (string) SMTP_PORT,
    'SMTP_ENCRYPTION' => SMTP_ENCRYPTION . (SMTP_ENCRYPTION === 'ssl' ? '  (implicit TLS / SMTPS)' : '  (STARTTLS)'),
    'SMTP_USER'       => SMTP_USER,
    'SMTP_FROM'       => SMTP_FROM,
    'SMTP_FROM_NAME'  => SMTP_FROM_NAME,
    'MAIL_ENABLED'    => MAIL_ENABLED ? 'true' : 'false',
];
foreach ($rows as $k => $v) {
    printf("  %-16s %s\n", $k, $v);
}

// Report only whether the password looks set — never its value.
$pwLen         = strlen((string) SMTP_PASS);
$isPlaceholder = str_contains((string) SMTP_PASS, 'your_') || $pwLen === 0;
printf("  %-16s %s\n\n", 'SMTP_PASS', $isPlaceholder
    ? 'NOT SET (still the placeholder) — fix this in .env'
    : "set, {$pwLen} characters");

$problems = [];

if ($isPlaceholder) {
    $problems[] = 'SMTP_PASS is still the placeholder value in .env.';
}
if (!MAIL_ENABLED) {
    $problems[] = 'MAIL_ENABLED is false, so the portal will not send mail.';
}
if ((int) SMTP_PORT === 465 && SMTP_ENCRYPTION !== 'ssl') {
    $problems[] = 'Port 465 requires SMTP_ENCRYPTION=ssl.';
}
if ((int) SMTP_PORT === 587 && SMTP_ENCRYPTION !== 'tls') {
    $problems[] = 'Port 587 requires SMTP_ENCRYPTION=tls.';
}
if (str_contains(SMTP_HOST, 'gmail') && !str_contains(SMTP_USER, 'gmail')) {
    $problems[] = 'SMTP_HOST is Gmail but SMTP_USER is not a Gmail address — '
        . 'for contact@yaswant.co.in use smtp.hostinger.com.';
}

if ($problems) {
    echo "Configuration problems found:\n";
    foreach ($problems as $p) {
        echo "  [!] {$p}\n";
    }
    echo "\n";
}

// ── TCP reachability ─────────────────────────────────────────────────────
echo "Connecting to " . SMTP_HOST . ':' . SMTP_PORT . " ... ";
$start  = microtime(true);
$socket = @fsockopen(
    (SMTP_ENCRYPTION === 'ssl' ? 'ssl://' : '') . SMTP_HOST,
    (int) SMTP_PORT,
    $errNo,
    $errStr,
    10
);

if (!$socket) {
    echo "FAILED\n";
    echo "  {$errStr} (code {$errNo})\n";
    echo "\n  The host is unreachable. Check the hostname, the port, and whether\n";
    echo "  your network or host firewall blocks outbound SMTP.\n";
    exit(1);
}

$ms     = round((microtime(true) - $start) * 1000);
$banner = trim((string) fgets($socket, 512));
fclose($socket);
echo "OK ({$ms} ms)\n";
echo "  Server banner: {$banner}\n\n";

if ($isPlaceholder) {
    echo "Stopping before the send test: no real password is configured yet.\n";
    echo "Put the new password in .env as SMTP_PASS, then run this again.\n";
    exit(1);
}

// ── Authenticated send ───────────────────────────────────────────────────
require_once ROOT_PATH . '/app/helpers/Security.php';
require_once ROOT_PATH . '/app/helpers/Helpers.php';
require_once ROOT_PATH . '/app/helpers/Mailer.php';

echo "Sending a test message to {$to} ...\n\n";

$ok = Mailer::send(
    $to,
    'SMTP Test',
    'Ecotech portal SMTP test',
    '<p style="margin:0 0 16px;">This is a test message from the Ecotech Services '
    . 'internship portal.</p><p style="margin:0;">If you are reading it, outbound '
    . 'email is working and application and status-change notifications will be delivered.</p>'
);

if ($ok) {
    echo "RESULT: sent successfully. Check the inbox for {$to}.\n";
    exit(0);
}

echo "RESULT: the send failed.\n";
echo "The specific SMTP error was written to logs/error.log — check the last line:\n\n";
echo "  Get-Content logs\\error.log -Tail 5\n\n";
echo "Common causes:\n";
echo "  - Wrong password, or the mailbox password was rotated\n";
echo "  - Wrong port/encryption pair (use 465+ssl or 587+tls)\n";
echo "  - SMTP_FROM does not match an address the mailbox is allowed to send as\n";
exit(1);

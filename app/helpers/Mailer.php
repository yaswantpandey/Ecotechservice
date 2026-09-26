<?php
// ============================================================
// Mailer — portal notification emails
//
// Wraps PHPMailer so controllers never deal with SMTP. Every send is
// best-effort: a failure is logged and swallowed so a bad credential or an
// unreachable SMTP host can never stop a candidate submitting an application
// or an admin updating a status.
//
// NOTE: SMTP_USER / SMTP_PASS in .env are placeholders on this install.
// Until real values are set, sends will fail and be logged to logs/error.log.
// ============================================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

class Mailer {

    /**
     * Send an HTML email. Returns true only on a confirmed send.
     */
    public static function send(
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlBody,
        ?string $replyTo = null
    ): bool {
        if (!MAIL_ENABLED) {
            return false;
        }

        if (!Security::validEmail($toEmail)) {
            error_log('Mailer: refusing to send to invalid address.');
            return false;
        }

        $autoload = ROOT_PATH . '/vendor/autoload.php';
        if (!file_exists($autoload)) {
            error_log('Mailer: vendor/autoload.php missing, email skipped.');
            return false;
        }
        require_once $autoload;

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            // 465 needs implicit TLS (SMTPS); 587 needs STARTTLS. Sending the
            // wrong one makes the connection hang or fail outright.
            $mail->SMTPSecure = SMTP_ENCRYPTION === 'ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = (int) SMTP_PORT;
            $mail->CharSet    = 'UTF-8';
            $mail->Timeout    = 12; // do not hang a page request on SMTP

            $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
            $mail->addAddress($toEmail, $toName !== '' ? $toName : $toEmail);
            if ($replyTo && Security::validEmail($replyTo)) {
                $mail->addReplyTo($replyTo);
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = self::wrap($subject, $htmlBody);
            $mail->AltBody = trim(html_entity_decode(strip_tags($htmlBody), ENT_QUOTES, 'UTF-8'));

            $mail->send();
            return true;
        } catch (MailerException $e) {
            error_log('Mailer error (' . $subject . '): ' . $e->getMessage());
            return false;
        } catch (Throwable $e) {
            error_log('Mailer unexpected error: ' . $e->getMessage());
            return false;
        }
    }

    // ── Portal notifications ─────────────────────────────────────────────

    /**
     * Welcome email after successful registration.
     */
    public static function welcome(string $email, string $name): bool {
        $body = '<p style="margin:0 0 16px;">Hello ' . Security::e($name) . ',</p>'
            . '<p style="margin:0 0 16px;">Your ' . Security::e(COMPANY_LEGAL_NAME)
            . ' internship account is ready. You can now browse the available tracks and submit an '
            . 'application with your resume.</p>'
            . self::button(url('internships'), 'Browse Internships')
            . '<p style="margin:16px 0 0;color:#94a3b8;font-size:13px;">'
            . 'You can track the progress of every application from your dashboard at any time.</p>';

        return self::send($email, $name, 'Welcome to ' . COMPANY_LEGAL_NAME . ' Internships', $body);
    }

    /**
     * Confirmation that an application was received.
     */
    public static function applicationReceived(
        string $email,
        string $name,
        string $track,
        string $refNo
    ): bool {
        $body = '<p style="margin:0 0 16px;">Hello ' . Security::e($name) . ',</p>'
            . '<p style="margin:0 0 16px;">We have received your application for the <strong>'
            . Security::e($track) . '</strong> internship track.</p>'
            . self::detailTable([
                'Reference'  => $refNo,
                'Track'      => $track,
                'Status'     => 'Pending review',
                'Submitted'  => date('d M Y, g:i a'),
            ])
            . '<p style="margin:16px 0 16px;">Our team will review it and update the status on your '
            . 'dashboard. Please quote the reference above in any correspondence.</p>'
            . self::button(url('internships/dashboard'), 'View Your Dashboard');

        return self::send($email, $name, 'Application received - ' . $refNo, $body);
    }

    /**
     * Status change notification. Approval gets its own wording plus a nudge
     * to download the offer letter.
     */
    public static function statusChanged(
        string $email,
        string $name,
        string $track,
        string $refNo,
        string $status,
        string $note = ''
    ): bool {
        $label = statusLabel($status);

        $intro = match ($status) {
            'approved'     => 'Congratulations. Your application has been <strong>approved</strong>. '
                              . 'Your official offer letter is ready to download from your dashboard.',
            'shortlisted'  => 'Good news — you have been <strong>shortlisted</strong>. '
                              . 'We will be in touch with the next steps shortly.',
            'under_review' => 'Your application is now <strong>under review</strong> by our team.',
            'rejected'     => 'After careful consideration we are unable to take your application '
                              . 'forward on this occasion. We genuinely appreciate the time you invested '
                              . 'and encourage you to apply for a future track.',
            'withdrawn'    => 'Your application has been marked as withdrawn.',
            default        => 'The status of your application has been updated.',
        };

        $rows = [
            'Reference'  => $refNo,
            'Track'      => $track,
            'New Status' => $label,
        ];
        if ($note !== '') {
            $rows['Note from the team'] = $note;
        }

        $body = '<p style="margin:0 0 16px;">Hello ' . Security::e($name) . ',</p>'
            . '<p style="margin:0 0 16px;">' . $intro . '</p>'
            . self::detailTable($rows)
            . self::button(
                url('internships/dashboard'),
                $status === 'approved' ? 'Download Offer Letter' : 'View Your Dashboard'
            );

        return self::send($email, $name, 'Application ' . $label . ' - ' . $refNo, $body);
    }

    /**
     * Internal alert to the company inbox when a new application lands.
     */
    public static function adminAlert(string $name, string $track, string $refNo, string $email): bool {
        $body = '<p style="margin:0 0 16px;">A new internship application has been submitted.</p>'
            . self::detailTable([
                'Reference' => $refNo,
                'Candidate' => $name,
                'Email'     => $email,
                'Track'     => $track,
                'Submitted' => date('d M Y, g:i a'),
            ])
            . self::button(url('admin/applications'), 'Open Admin Panel');

        return self::send(
            SMTP_FROM,
            SMTP_FROM_NAME,
            '[Internship] New application - ' . $track . ' (' . $refNo . ')',
            $body,
            $email
        );
    }

    // ── Presentation ─────────────────────────────────────────────────────

    /**
     * Shared dark email shell matching the site palette.
     */
    private static function wrap(string $heading, string $inner): string {
        $company = Security::e(COMPANY_LEGAL_NAME);

        return '<div style="background:#030712;padding:28px 16px;font-family:Inter,Arial,sans-serif;">'
            . '<div style="max-width:600px;margin:0 auto;background:#111827;border:1px solid rgba(255,255,255,0.08);'
            . 'border-radius:14px;overflow:hidden;">'
            . '<div style="padding:22px 28px;border-bottom:1px solid rgba(255,255,255,0.08);">'
            . '<div style="font-size:17px;font-weight:700;color:#f9fafb;letter-spacing:0.2px;">' . $company . '</div>'
            . '<div style="font-size:12px;color:#22c55e;margin-top:3px;">Internship Programme</div>'
            . '</div>'
            . '<div style="padding:28px;color:#d1d5db;font-size:14px;line-height:1.65;">'
            . '<h2 style="margin:0 0 18px;font-size:17px;color:#f9fafb;font-weight:600;">'
            . Security::e($heading) . '</h2>'
            . $inner
            . '</div>'
            . '<div style="padding:16px 28px;border-top:1px solid rgba(255,255,255,0.08);'
            . 'color:#6b7280;font-size:11px;line-height:1.6;">'
            . $company . ' &middot; ' . Security::e(COMPANY_ADDRESS) . '<br>'
            . Security::e(COMPANY_EMAIL) . ' &middot; ' . Security::e(COMPANY_PHONE)
            . '</div></div></div>';
    }

    /**
     * Key/value detail table.
     */
    private static function detailTable(array $rows): string {
        $html = '<table style="width:100%;border-collapse:collapse;'
            . 'background:#0c111a;border-radius:10px;overflow:hidden;">';

        foreach ($rows as $label => $value) {
            $html .= '<tr>'
                . '<td style="padding:10px 14px;color:#6b7280;font-size:12px;width:38%;'
                . 'border-bottom:1px solid rgba(255,255,255,0.05);vertical-align:top;">'
                . Security::e((string) $label) . '</td>'
                . '<td style="padding:10px 14px;color:#f9fafb;font-size:13px;font-weight:600;'
                . 'border-bottom:1px solid rgba(255,255,255,0.05);">'
                . Security::e((string) $value) . '</td>'
                . '</tr>';
        }

        return $html . '</table>';
    }

    /**
     * Call-to-action button.
     */
    private static function button(string $href, string $label): string {
        return '<p style="margin:20px 0 0;">'
            . '<a href="' . Security::e($href) . '" '
            . 'style="display:inline-block;background:#22c55e;color:#ffffff;text-decoration:none;'
            . 'padding:11px 22px;border-radius:9px;font-size:13px;font-weight:600;">'
            . Security::e($label) . '</a></p>';
    }
}

<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as MailerException;

class ContactController extends BaseController {

    public function index(): void {
        $this->view('contact', [
            'pageTitle'       => 'Contact Us — Start Your Digital Project | ' . APP_NAME,
            'metaDescription' => 'Connect with Ecotech Service to discuss custom web engineering, cybersecurity audits, mobile apps, or digital marketing. Quick turnaround and dedicated support.',
            'metaKeywords'    => 'contact ecotech service, hire web developers, cybersecurity audit quote, web development inquiry, contact software team lucknow',
            'canonicalPath'   => 'contact',
        ]);
    }

    public function send(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('contact'));
        }

        $this->validateCsrf();

        $name = Security::sanitize($_POST['name'] ?? '');
        $email = Security::sanitize($_POST['email'] ?? '');
        $phone = Security::sanitize($_POST['phone'] ?? '');
        $subject = Security::sanitize($_POST['subject'] ?? '');
        $message = Security::sanitize($_POST['message'] ?? '');

        $errors = [];
        if (strlen($name) < 2) {
            $errors[] = 'Please enter your full name.';
        }
        if (!Security::validEmail($email)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if (strlen($subject) < 3) {
            $errors[] = 'Please enter a subject.';
        }
        if (strlen($message) < 10) {
            $errors[] = 'Message must be at least 10 characters.';
        }

        if ($errors) {
            setFlash('error', implode(' ', $errors));
            redirect(url('contact'));
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $stmt = $this->db->prepare(
            "INSERT INTO contacts (name, email, phone, subject, message, ip_address)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$name, $email, $phone, $subject, $message, $ip]);

        $this->sendEmail($name, $email, $phone, $subject, $message);

        setFlash('success', 'Thank you! Your message has been received. We will get back to you shortly.');
        redirect(url('contact'));
    }

    private function sendEmail(string $name, string $email, string $phone, string $subject, string $message): void {
        $vendorAutoload = ROOT_PATH . '/vendor/autoload.php';
        if (!file_exists($vendorAutoload)) {
            return;
        }
        require_once $vendorAutoload;

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = SMTP_ENCRYPTION === 'ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
            $mail->addAddress(SMTP_FROM, SMTP_FROM_NAME);
            $mail->addReplyTo($email, $name);

            $mail->isHTML(true);
            $mail->Subject = "[Ecotech Contact] {$subject}";
            $mail->Body = $this->emailTemplate($name, $email, $phone, $subject, $message);
            $mail->AltBody = strip_tags($message);

            $mail->send();
        } catch (MailerException) {
            error_log('Mailer error: contact form email not sent.');
        }
    }

    private function emailTemplate(
        string $name,
        string $email,
        string $phone,
        string $subject,
        string $message
    ): string {
        $e = fn($v) => Security::e($v);
        return <<<HTML
        <div style="font-family:Inter,Arial,sans-serif;max-width:600px;margin:0 auto;background:#0f1a0f;color:#e5f0e5;padding:32px;border-radius:12px;">
          <h2 style="color:#22c55e;margin-bottom:8px;">New Contact Form Submission</h2>
          <p style="color:#94a3b8;margin-top:0;">Ecotech Service - Contact Alert</p>
          <table style="width:100%;border-collapse:collapse;margin-top:24px;">
            <tr><td style="padding:8px 0;color:#94a3b8;width:120px;">Name</td><td style="padding:8px 0;color:#e5f0e5;font-weight:600;">{$e($name)}</td></tr>
            <tr><td style="padding:8px 0;color:#94a3b8;">Email</td><td style="padding:8px 0;color:#22c55e;">{$e($email)}</td></tr>
            <tr><td style="padding:8px 0;color:#94a3b8;">Phone</td><td style="padding:8px 0;color:#e5f0e5;">{$e($phone ?: 'N/A')}</td></tr>
            <tr><td style="padding:8px 0;color:#94a3b8;">Subject</td><td style="padding:8px 0;color:#e5f0e5;">{$e($subject)}</td></tr>
          </table>
          <div style="margin-top:16px;padding:16px;background:#1a2e1a;border-radius:8px;border-left:4px solid #22c55e;">
            <p style="margin:0;color:#e5f0e5;">{$e($message)}</p>
          </div>
          <p style="color:#475569;font-size:12px;margin-top:24px;">This message was submitted via the Ecotech Service contact form.</p>
        </div>
        HTML;
    }
}

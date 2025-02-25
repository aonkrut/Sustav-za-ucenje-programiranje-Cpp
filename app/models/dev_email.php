<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require BASE_PATH . 'vendor/autoload.php'; 
class Email extends Model {

    protected $mailer;
    protected $fromEmail;
    protected $fromName;

    public function __construct($fromEmail = null, $fromName = null) {
        $this->mailer = new PHPMailer(true); // Create a new PHPMailer instance

        // Set default "from" email and name if provided
        if ($fromEmail) {
            $this->setFrom($fromEmail, $fromName);
        }

        // Configure PHPMailer (SMTP settings, etc.)
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.zoho.eu'; // Replace with your SMTP server
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'info@salabahter.eu'; // SMTP username
        $this->mailer->Password = 'Salabahter3!'; // SMTP password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // $this->mailer->Port = 587; // SMTP port
        $mail->Port = 465;
    }

    public function setFrom($email, $name = null) {
        $this->fromEmail = $email;
        $this->fromName = $name;
        $this->mailer->setFrom($email, $name);
    }

    public function send($toEmail, $subject, $templatePath, $data) {
        try {
            // Load the HTML template
            $message = file_get_contents($templatePath);

            // Replace placeholders with actual data
            foreach ($data as $key => $value) {
                $message = str_replace('{' . strtoupper($key) . '}', $value, $message);
            }

            // Set email details
            $this->mailer->addAddress($toEmail);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $message;

            // Send the email
            $this->mailer->send();

            return true;
        } catch (Exception $e) {
            // Handle errors
            error_log('Message could not be sent. Mailer Error: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }
}

// $email = new Email('sender@example.com', 'Sender Name');
// $data = [
//     'name' => 'John',
//     'surname' => 'Doe',
//     'code' => '12345',
//     'link' => 'https://example.com',
//     'text' => 'Welcome to our service!',
//     'description' => 'This is a description'
// ];
// $email->send('recipient@example.com', 'Welcome Email', 'path/to/template.html', $data);

<?php

require FULL_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require FULL_PATH . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require FULL_PATH . '/vendor/phpmailer/phpmailer/src/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Email {

	  private $mailer;
  	 private $data;

    public function __construct() {
        $this->mailer = new PHPMailer(true); // True for exceptions
	$this->setupMailSettings();
    }

    private function setupMailSettings() {
        // Configure mailer settings
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.zoho.eu'; // Replace with your SMTP server
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'info@salabahter.eu'; // SMTP username
        $this->mailer->Password = 'Salabahter3!'; // SMTP password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587; // SMTP port
       //	$this->$mailer->Port = 465;
    }

    protected function replacePlaceholders($body, $data) {
        foreach ($data as $key => $value) {
            $body = str_replace('{' . $key . '}', $value, $body);
        }
        return $body;
    }


    public function send($to, $subject, $body, $altBody = '', $data) {
        try {
		$this->mailer->setFrom('info@salabahter.eu', 'Spcpp BETA');
		   $body = $this->replacePlaceholders($body, $data);
            $this->mailer->addAddress($to);
	    $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
	    $this->mailer->AltBody = $altBody;



            if(!$this->mailer->send()){
    		// echo 'Message could not be sent. Mailer Error: ' . $this->mailer->ErrorInfo; //TODO HR treba slziti da se v bazu upisuju errori od mail senda
		} else {
    		//echo 'Message has been sent';
		}
            return true;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$thisr->mailer->ErrorInfo}";
            return 'email_send_error';
        }
    }

}


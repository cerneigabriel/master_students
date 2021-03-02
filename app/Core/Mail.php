<?php

namespace MasterStudents\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {
    public $mail;

    public function __construct($email = "web") {
        $this->mail = new PHPMailer(true);

        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host = Config::get("mail.emails.{$email}.host");
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Config::get("mail.emails.{$email}.username");
        $this->mail->Password = Config::get("mail.emails.{$email}.password");
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = Config::get("mail.emails.{$email}.port");
        
        $this->mail->setFrom(Config::get("mail.emails.{$email}.email"), Config::get("mail.emails.{$email}.name"));

        return $this->mail;
    }
}
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');

class Inf_phpmailer extends CI_PHPMailer {

    function __construct() {
        parent::__construct();
    }

    public function send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mail_body, $mail_altbody, $mail_type = "normal", $smtp_data = array(), $attachments = array()) {

        if ($mail_type == "smtp") {
            $this->IsSMTP(); // we are going to use SMTP
            $this->SMTPAuth = $smtp_data['SMTPAuth']; // enabled SMTP authentication
            $this->SMTPSecure = $smtp_data['SMTPSecure'];  // prefix for secure protocol to connect to the server
            $this->Host = $smtp_data['Host'];      // setting SMTP server
            $this->Port = $smtp_data['Port'];                   // SMTP port to connect to GMail
            $this->Username = $smtp_data['Username'];  // user email address
            $this->Password = $smtp_data['Password'];            // password in GMail
            $this->Timeout = $smtp_data['Timeout']; // The SMTP server timeout in seconds.
            if (isset($smtp_data['SMTPDebug'])) {
                $this->SMTPDebug = $smtp_data['SMTPDebug'];
            }
            $this->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        } else {
            $this->isSendmail();
        }

        $this->setFrom($mail_from['email'], $mail_from['name']);  //Who is sending the email
        $this->addReplyTo($mail_reply_to['email'], $mail_reply_to['name']);  //email address that receives the response
        $this->Subject = $mail_subject;
        $this->Body = $mail_body;
        $this->AltBody = $mail_altbody;
        $this->AddAddress($mail_to['email'], $mail_to['name']); // Who is addressed the email to

        if (count($attachments)) {
            foreach ($attachments AS $attachment) {
                $this->AddAttachment("$attachment");      // some attached files
            }
        }

        if (SEND_EMAIL && DEMO_STATUS == 'no') {
            if (!$this->Send()) {
                $data["status"] = false;
                $data["ErrorInfo"] = "Error: " . $this->ErrorInfo;
            } else {
                $data["status"] = true;
            }
        } else {
            $data["status"] = true;
        }

        $this->clearAllRecipients();
        $this->clearBCCs();
        $this->clearCCs();
        $this->clearAddresses();
        $this->clearReplyTos();
        $this->clearAttachments();
        $this->clearCustomHeaders();

        return $data;
    }

}

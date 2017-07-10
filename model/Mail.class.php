<?php
  require_once 'PHPMailer/PHPMailerAutoload.php';
  require_once '../config.php';

  class Mail {
    // To send email to clients
    var $adress;
    var $adressName;

    var $subject;
    var $messageInHTML;
    var $message;

    var $mail;

    function __construct() {
      // Set the default settings for phpmailer
      $this->mail = new PHPMailer;

      // $this->mail->SMTPDebug = 3;                               // Enable verbose debug output

      $this->mail->isSMTP();                                      // Set mailer to use SMTP
      $this->mail->Host = $GLOBALS['config']['base_url']['mail-host'];  // Specify main and backup SMTP servers
      $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
      $this->mail->Username = $GLOBALS['config']['base_url']['mail-userName'];                 // SMTP username
      $this->mail->Password = $GLOBALS['config']['base_url']['mail-password'];                           // SMTP password
      $this->mail->SMTPSecure = $GLOBALS['config']['base_url']['mail-SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
      $this->mail->Port = $GLOBALS['config']['base_url']['mail-port'];                                    // TCP port to connect to

      $this->mail->setFrom($GLOBALS['config']['base_url']['mail-sendFormAdress'], $GLOBALS['config']['base_url']['mail-senderName']);
      $this->mail->isHTML(true);                                  // Set email format to HTML
    }

    /**
     * Triggers the phpmailer classs to send the mail
     * @return [string] [If it succeded or failed]
     */
    public function sendMail() {
      // Sends the mail
      $this->mail->addAddress($this->adress, $this->adressName);

      $this->mail->Subject = $this->subject;
      $this->mail->Body    = $this->messageInHTML;
      $this->mail->AltBody = $this->message;
      // Sets the mail content

      if(!$this->mail->send()) {
          return("Failed " . $this->mail->ErrorInfo);
      } else {
          return('Succes');
      }
    }
  }
?>

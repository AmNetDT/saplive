<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function Sendmail($to = array(), $attachmentArray = array()){

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'secure.emailsrvr.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'Mobiletrader';                 // SMTP username
        $mail->Password = 'P@ssword';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('mobiletrader@greatbrandsng.com', 'Mobile Trader');
       // $mail->addAddress('psalem@greatbrandsng.com', 'Philip Salem');     // Add a recipient
        $mail->addAddress('softwaredeveloper2.ho@greatbrandsng.com', 'Kolapo Babawale');     // Add a recipient
        //set other recipients
        if(is_array($to) && count($to)>0){
            foreach($to as $to1){
                if($to1 == 'psalem@greatbrandsng.com'){
                    continue;
                }
                $mail->addCC($to1);
            }
        }
        
        //$mail->addBCC('bcc@example.com');

        //Attachments
        if(is_array($attachmentArray) && count($attachmentArray)>0){
            foreach($attachmentArray as $attachmentArray1){
                $mail->addAttachment($attachmentArray1);
            }
        }

        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Escalated Mail from the CRO';
        $mail->Body    = '<p>Dear All,</p><p></p><br><br>
        Please,  find attached the <b>Call Center Summary for the $unit</b> for today.</p><br><br>
        <p>Regards,</p><br><br>
        <p><b>Mobile Trader</b></p>';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

}


?>
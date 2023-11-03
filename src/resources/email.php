<?php 

require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * The function `sendEmailSMTP` sends an email using SMTP with the provided sender, recipient, subject,
 * body, and configuration parameters.
 * 
 * @param $sender The email address of the sender.
 * @param $senderName The name of the sender of the email.
 * @param $recipient The recipient parameter is the email address of the person who will receive the
 * email.
 * @param $recipientName The recipient's name.
 * @param $subject The subject of the email that will be sent.
 * @param $body The `` parameter is the content of the email that will be sent. It can be plain
 * text or HTML code. In the provided code, if a `` array is passed as an argument, the
 * `` variable will be overwritten with HTML code generated from the template array. Otherwise
 * @param $config The `` parameter is an array that contains the configuration settings for the
 * SMTP server. It includes the following keys:
 * @param $template The "template" parameter is an optional array that contains the title and content of
 * the email template. If provided, the function will use this template to generate the email body. If
 * not provided, the function will use the "body" parameter as the email body directly.
 */
function sendEmailSMTP($sender, $senderName, $recipient, $recipientName, $subject, $body, $config,$template = []) {

    $mail = new PHPMailer(true);
    try {

        if($template != []){
            $body = '<div style="padding:70px 0 70px 0;">
                <table width="600" height="auto" cellpadding="0" cellspacing="0" style="background-color:white; border:3px solid #e351c5; border-radius:3px !important;">
                <tr>
                    <td width="600" height="auto" style="padding:36px 48px; display:block; margin: 0px auto;background:#d0ffef;">
                    <h1 style="color:#e351c5; font-size:30px; line-height:150%; font-weight:300; margin:0; text-align:left;">'.$template['title'].'</h1>
                    </td>
                </tr>
                <tr>
                    <td width="600" style="color:#e351c5; font-size:14px; line-height:150%; text-align:left; padding:48px;">
                    <p style="margin:0 0 16px;color:#e351c5;">'.$template['content'].'</p>
                    </td>
                </tr>
                <tr>
                    <td width="600" style="padding:0 48px 48px 48px; color:#707070; font-family:Arial; font-size:12px; line-height:125%; text-align:center;">
                    <p style="color:#29cf98">Pricture @ 2023</p>
                    </td>
                </tr>
                </table>
            </div>';
        }
        

        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = $config['port'];

        $mail->setFrom($sender, $senderName);
        $mail->addAddress($recipient, $recipientName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        if($mail->send()){
            echo 1;
        }else{
            echo "email failed";
        }
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
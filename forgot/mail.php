<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'PHPMailer-master/src/Exception.php';
  require 'PHPMailer-master/src/PHPMailer.php';
  require 'PHPMailer-master/src/SMTP.php';

function send_mail($recipient, $subject, $code, $expiry_time, $uid)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "enter your email here";
    $mail->Password = "enter you email password here";

    $mail->IsHTML(true);
    $mail->AddAddress($recipient, "Esteemed customer");
    $mail->SetFrom("enter your email address here", "Password reset verification OTP");
    $mail->Subject = $subject;

    $content = '
        <html>
        <head>
        </head>
        <body style="min-height: 100vh; background-color:#171717;display: flex;">
          <div style="font-family: Arial, Helvetica, sans-serif;margin: auto;height: 400px; width: 500px;">
             <div style="margin: 50px auto;width: 70%;padding: 20px 0;">
               <div style="border-bottom: 2px solid #eee;">
                 <a href="" style="font-size: 1.2rem; color: #5b21b6; text-decoration: none;font-weight: 600;">Inner Circle Inc.</a>
                </div>
                <form style="padding: 20px; background-color:black;">
                    <p style="font-size: 1.1em; color:#e2e8f0;">Hello Dear, ' .$uid. ' </p>
                    <p style="color: #e2e8f0;">Thank you for choosing Inner Circle Inc.</p>
                    <p style="color:#e2e8f0;">Use the following OTP to reset your password.</p>
                    <h2 style="margin-left: 49%;background-color: #18181b; width: max-content;padding: 0 10px;color: #facc15; border-radius: 4px;">'. $code . '</h2>
                    <p style="color:#e2e8f0;">Your OTP will expire before;</p>
                    <h3 style="margin-left:49%; background-color:#18181b; width:max-content;padding:0 10px; color:#facc15; border-radius:4px;">' . $expiry_time . '</h3>
                   <p style="font-size: 1.0rem;color: #f8fafc;">Regards, <br />Inner Circle Inc.</p>
                </form>
              </div>
          </div>   
        </body>
      </html>';

    $mail->MsgHTML($content);

    if(!$mail->Send()) {
        echo "Error while sending Email.";
        return false;
    } else {
        return true;
    }
}


?>
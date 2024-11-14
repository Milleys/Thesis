<?php
session_start();
$_SESSION["Username"] = "wil";
$_SESSION["Email"] = "johnwilsonlorin1@gmail.com";

require 'backend/vendor/phpmailer/phpmailer/src/Exception.php';
require 'backend/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'backend/vendor/phpmailer/phpmailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'backend/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;  //SMTP::DEBUG_SERVER to show client                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'wilsonlorin12@gmail.com';                     //SMTP username
    $mail->Password   = 'apvc svqh puqv ybll';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('wilsonlorin12@gmail.com', 'NO reply');
    $mail->addAddress($_SESSION['Email'], $_SESSION['Username']);     //Add a recipient
    $mail->addReplyTo('wilsonlorin12@gmail.com', 'Information');
 
   

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Collaborative Note-Taking';
    $mail->Body    = '<!doctype html>
    <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    
    <head>
    <meta charset="utf-8" />
    <meta content="width=device-width" name="viewport" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta content="telephone=no,address=no,email=no,date=no,url=no" name="format-detection" />
    <title>Template</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Inter:400" rel="stylesheet" type="text/css">
    <!--[if mso]>
                <style>
                    * {
                        font-family: sans-serif !important;
                    }
                </style>
            <![endif]-->
    <!--[if !mso]><!-->
    <!-- <![endif]-->
    <style>
    html {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    * {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
    }
    td {
        vertical-align: top;
        mso-table-lspace: 0pt !important;
        mso-table-rspace: 0pt !important;
    }
    a {
        text-decoration: none;
    }
    img {
        -ms-interpolation-mode:bicubic;
    }
    @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
        u ~ div .email-container {
            min-width: 320px !important;
        }
    }
    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
        u ~ div .email-container {
            min-width: 375px !important;
        }
    }
    @media only screen and (min-device-width: 414px) {
        u ~ div .email-container {
            min-width: 414px !important;
        }
    }
    </style>
    <!--[if gte mso 9]>
            <xml>
                <o:OfficeDocumentSettings>
                    <o:AllowPNG/>
                    <o:PixelsPerInch>96</o:PixelsPerInch>
                </o:OfficeDocumentSettings>
            </xml>
            <![endif]-->
    <style>
    @media only screen and (max-device-width: 1303px), only screen and (max-width: 1303px) {
    
        .eh {
            height:auto !important;
        }
        .desktop {
            display: none !important;
            height: 0 !important;
            margin: 0 !important;
            max-height: 0 !important;
            overflow: hidden !important;
            padding: 0 !important;
            visibility: hidden !important;
            width: 0 !important;
        }
        .mobile {
            display: block !important;
            width: auto !important;
            height: auto !important;
            float: none !important;
        }
        .email-container {
            width: 100% !important;
            margin: auto !important;
        }
        .stack-column,
        .stack-column-center {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            direction: ltr !important;
        }
        .wid-auto {
            width:auto !important;
        }
    
        .table-w-full-mobile {
            width: 100%;
        }
    
        
        
    
        .mobile-center {
            text-align: center;
        }
    
        .mobile-center > table {
            display: inline-block;
            vertical-align: inherit;
        }
    
        .mobile-left {
            text-align: left;
        }
    
        .mobile-left > table {
            display: inline-block;
            vertical-align: inherit;
        }
    
        .mobile-right {
            text-align: right;
        }
    
        .mobile-right > table {
            display: inline-block;
            vertical-align: inherit;
        }
    
    }
    
    </style>
    </head>
    
    <body width="100%" style="background-color:#e5e5e5;margin:0;padding:0!important;mso-line-height-rule:exactly;">
    <div style="background-color:#e5e5e5">
    <!--[if gte mso 9]>
                    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                    <v:fill type="tile" color="#e5e5e5"/>
                    </v:background>
                    <![endif]-->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td valign="top" align="center">
    <table bgcolor="#ffffff" style="margin:0 auto;" align="center" id="brick_container" cellspacing="0" cellpadding="0" border="0" width="1304" class="email-container">
    <tr>
    <td width="1304">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="1304" style="background-color:#ffffff;  " bgcolor="#ffffff">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="268">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="268" align="center" style="vertical-align: middle; height:76px; background-color:#ffffff;  " bgcolor="#ffffff">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td height="8" style="height:8px; min-height:8px; line-height:8px;"></td>
    </tr>
    <tr>
    <td style="vertical-align: middle;" width="268" align="center"><img src="https://plugin.markaimg.com/public/cc46c3cc/R5OPsLWrHvEXYqac7P4iKYiRUp7fA4.png" width="268" border="0" style="width: 100%;
            border-radius:8px; height: auto; display: block;"></td>
    </tr>
    <tr>
    <td height="8" style="height:8px; min-height:8px; line-height:8px;"></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td>
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="1291">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="1243" align="center" style="vertical-align: middle; height:260px; background-color:#ffffff;   padding-left:24px; padding-right:24px;" bgcolor="#ffffff">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td height="24" style="height:24px; min-height:24px; line-height:24px;"></td>
    </tr>
    <tr>
    <td align="center">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td style="vertical-align: middle;" width="552">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="552" align="center" style="vertical-align: middle;  ">
    <table class="table-w-full-mobile" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td style="vertical-align: middle;" width="264" class="stack-column-center" align="center"><img src="https://plugin.markaimg.com/public/cc46c3cc/0CTi0Ucap3RFIOm09YwcVbdi5QMGEe.png" width="264" border="0" style="width: 100%;
            border-radius:8px; height: auto; display: block;"></td>
    <td class="stack-column-center" height="24" style="width:24px; min-width:24px; height:24px; min-height:24px;" width="24"> </td>
    <td style="vertical-align: middle;" align="center" width="48%" class="stack-column-center">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="100%">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <div style="line-height:24px;text-align:left;"><span style="color:#63eb33;font-weight:600;font-family:Inter,Arial,sans-serif;font-size:16px;line-height:24px;text-align:left;">Hi '.$name.'! Welcome to CoNotes</span></div>
    </td>
    </tr>
    <tr>
    <td height="12" style="height:12px; min-height:12px; line-height:12px;"></td>
    </tr>
    <tr>
    <td width="100%">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <div style="line-height:24px;text-align:left;"><span style="color:#667085;font-family:Inter,Arial,sans-serif;font-size:15px;line-height:24px;text-align:left;">CoNotes is the ultimate solution for your note-taking needs. Our user-friendly interface, powerful features, and cloud-based access ensure you can focus on what matters most – your notes.</span></div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td height="24" style="height:24px; min-height:24px; line-height:24px;"></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td width="100%">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="100%" style="vertical-align: middle; height:24px; background-color:#ffffff;   padding-left:24px; padding-right:24px;" bgcolor="#ffffff">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td height="12" style="height:12px; min-height:12px; line-height:12px;"></td>
    </tr>
    <tr>
    <td style="vertical-align: middle;" width="1256">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="1256">
    <table cellpadding="0" cellspacing="0" height="1" width="100%" style="line-height:1px;height:1px!important; border-width: 0px 0px 1px 0px; border-color:#e0e0e0; border-style:solid; border-collapse:separate !important;margin:0 auto;text-align:center;">
    <tr>
    <td> </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td height="12" style="height:12px; min-height:12px; line-height:12px;"></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td>
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="1291">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="1243" align="center" style="vertical-align: middle; height:152px; background-color:#ffffff;   padding-left:24px; padding-right:24px;" bgcolor="#ffffff">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td height="24" style="height:24px; min-height:24px; line-height:24px;"></td>
    </tr>
    <tr>
    <td style="vertical-align: middle;" width="100%">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td width="100%" align="center">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td align="center">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr>
    <td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="24"><img src="https://plugin.markaimg.com/public/cc46c3cc/9ho5dIvvOM8WbEPDBJ96Hp8YhZtK09.png" width="24" border="0" style="min-width:24px; width:24px;
             height: auto; display: block;"></td>
    <td style="width:16px; min-width:16px;" width="16"></td>
    <td width="24"><img src="https://plugin.markaimg.com/public/cc46c3cc/pXLFJkNUl9vD4AICmHSro0Je6g3ZME.png" width="24" border="0" style="min-width:24px; width:24px;
             height: auto; display: block;"></td>
    <td style="width:16px; min-width:16px;" width="16"></td>
    <td width="24"><img src="https://plugin.markaimg.com/public/cc46c3cc/gWlJXGT1ZGrEpCbCwdWV8qtSUXeiCT.png" width="24" border="0" style="min-width:24px; width:24px;
             height: auto; display: block;"></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td height="16" style="height:16px; min-height:16px; line-height:16px;"></td>
    </tr>
    <tr>
    <td width="100%">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <div style="line-height:24px;text-align:center;"><span style="color:#667085;font-weight:600;font-family:Inter,Arial,sans-serif;font-size:16px;line-height:24px;text-align:center;">CoNotes</span></div>
    </td>
    </tr>
    <tr>
    <td height="4" style="height:4px; min-height:4px; line-height:4px;"></td>
    </tr>
    <tr>
    <td>
    <div style="line-height:24px;text-align:center;"><span style="color:#667085;font-family:Inter,Arial,sans-serif;font-size:15px;line-height:24px;text-align:center;">Collaborative Note-Taking</span></div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td height="24" style="height:24px; min-height:24px; line-height:24px;"></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </div>
    </body>
    
    </html>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    $_SESSION['verified'] = 1;
    echo '<script type="text/javascript">'; 
    echo 'window.location.href = "login.php";';
    echo '</script>';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
















?>

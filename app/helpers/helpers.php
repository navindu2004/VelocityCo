<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Category;
use App\Models\SubCategory;


/**SEND EMAIL FUNCTION USING PHPMAILER LIBRARY */
if(!function_exists('sendEmail') ){
    function sendEmail($mailConfig){
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        //$mail->SMTPSecure = env('EMAIL_ENCRYPTION');
        $mail->Port = env('MAIL_PORT');
        $mail->setFrom($mailConfig['mail_from_email'],$mailConfig['mail_from_name']);
        $mail->addAddress($mailConfig['mail_recipient_email'],$mailConfig['mail_recipient_name']);
        $mail->isHTML(true);
        $mail->Subject = $mailConfig['mail_subject'];
        $mail->Body = $mailConfig['mail_body'];
        if($mail->send()){
            return true;
        } else{
            return false;
        }
    }
}


//FRONTEND::
/**GET FRONT END CATEGORIES */
if( !function_exists('get_categories') ){
    function get_categories(){
        $categories = Category::with('subcategories')->orderBy('ordering','asc')->get();
        return !empty($categories) ? $categories : [];
    }
}
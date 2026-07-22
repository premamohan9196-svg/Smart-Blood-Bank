<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// ================= APPROVED EMAIL =================

function sendApprovalEmail($toEmail, $patientName){

    $mail = new PHPMailer(true);

    try{

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'premamohan9196@gmail.com';
        $mail->Password = 'yotbcapwcufgvyrn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('premamohan9196@gmail.com', 'Smart Blood Donation System');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Blood Request Approved';

        $mail->Body = "
        <h2>Blood Request Approved</h2>
        <p>Hello <b>$patientName</b>,</p>
        <p>Your blood request has been <b style='color:green;'>Approved</b>.</p>
        <p>Thank you for using the Smart Blood Donation Management System.</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e){
        return false;
    }
}

// ================= REJECTED EMAIL =================

function sendRejectEmail($toEmail, $patientName){

    $mail = new PHPMailer(true);

    try{

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'premamohan9196@gmail.com';
        $mail->Password = 'yotbcapwcufgvyrn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('premamohan9196@gmail.com', 'Smart Blood Donation System');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Blood Request Rejected';

        $mail->Body = "
        <h2>Blood Request Rejected</h2>
        <p>Hello <b>$patientName</b>,</p>
        <p>We are sorry.</p>
        <p>Your blood request has been <b style='color:red;'>Rejected</b>.</p>
        <p>Please contact the administrator for more information.</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e){
        return false;
    }
}

//=========================repay msg========================
function sendReplyEmail($toEmail, $subject, $message){

    $mail = new PHPMailer(true);

    try{

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'premamohan9196@gmail.com';
        $mail->Password = 'yotbcapwcufgvyrn';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('premamohan9196@gmail.com', 'Smart Blood Donation System');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;

        $mail->Body = "
        <h2>Reply from Smart Blood Donation System</h2>

        <p>$message</p>

        <br>

        <p>Thank you.</p>
        ";

        $mail->send();

        return true;

    }catch(Exception $e){

        die('Mailer Error: '.$mail->ErrorInfo);
        return false;

    }

}
?>
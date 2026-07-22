<?php
session_start();
include "config.php";
include "send_email.php";

if(isset($_POST['send'])){

    $email = $_POST['email'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($result->num_rows > 0){

        $otp = rand(100000,999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        $conn->query("UPDATE users SET otp='$otp', otp_expiry='$expiry' WHERE email='$email'");

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try{

            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true;
            $mail->Username='premamohan9196@gmail.com';
            $mail->Password='yotbcapwcufgvyrn';
            $mail->SMTPSecure='tls';
            $mail->Port=587;

            $mail->setFrom('premamohan9196@gmail.com','Smart Blood Donation System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject='Password Reset OTP';
            $mail->Body="<h2>Your OTP is: <b>$otp</b></h2><p>This OTP is valid for 5 minutes.</p>";

            $mail->send();

            $_SESSION['reset_email'] = $email;

            echo "<script>
            alert('OTP Sent Successfully');
            window.location='verify_otp.php';
            </script>";

        }catch(Exception $e){
            echo "<script>alert('Email Sending Failed');</script>";
        }

    }else{
        echo "<script>alert('Email Not Found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:#f5f5f5;
}

.box{
width:400px;
margin:100px auto;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 0 15px gray;
}
</style>

</head>

<body>

<div class="box">

<h2 class="text-center text-danger">Forgot Password</h2>

<form method="POST">

<input type="email"
name="email"
class="form-control"
placeholder="Enter Registered Email"
required>

<br>

<button class="btn btn-danger w-100"
name="send">
Send OTP
</button>

</form>

</div>

</body>
</html>
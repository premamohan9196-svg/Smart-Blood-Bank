<?php
session_start();
include "config.php";

if(!isset($_SESSION['reset_email'])){
    header("Location: forgot_password.php");
    exit();
}

if(isset($_POST['reset'])){

    $email = $_SESSION['reset_email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn->query("UPDATE users SET password='$password', otp=NULL, otp_expiry=NULL WHERE email='$email'");

    unset($_SESSION['reset_email']);

    echo "<script>
    alert('Password Reset Successful');
    window.location='login.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>

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

<h2 class="text-center text-danger">Reset Password</h2>

<form method="POST">

<input type="password"
name="password"
class="form-control"
placeholder="Enter New Password"
required>

<br>

<button class="btn btn-danger w-100"
name="reset">
Reset Password
</button>

</form>

</div>

</body>
</html>
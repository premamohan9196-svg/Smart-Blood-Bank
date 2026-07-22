<?php
session_start();
include 'config.php';

$error = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Get user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        // Verify hashed password
        if(password_verify($password, $user['password'])){

            $_SESSION['email'] = $user['email'];

            header("Location: dashboard.php");
            exit();

        }else{

            $error = "Invalid Email or Password!";

        }

    }else{

        $error = "Invalid Email or Password!";

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>User Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
margin:0;
padding:0;
background:linear-gradient(135deg,#8B0000,#111827);
font-family:Arial,sans-serif;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.login-box{
width:400px;
background:#1e293b;
padding:35px;
border-radius:15px;
box-shadow:0 0 20px rgba(0,0,0,.5);
}

.login-box h2{
text-align:center;
color:#ff4d6d;
margin-bottom:25px;
}

.form-control{
margin-bottom:15px;
height:48px;
}

.btn-login{
width:100%;
background:#dc3545;
color:#fff;
border:none;
height:48px;
font-size:17px;
}

.btn-login:hover{
background:#b02a37;
}

.register-link{
text-align:center;
margin-top:15px;
}

.register-link a{
color:#0dcaf0;
text-decoration:none;
display:block;
margin-top:6px;
}

.error{
background:#f8d7da;
color:#842029;
padding:10px;
border-radius:6px;
margin-bottom:15px;
text-align:center;
}

.footer{
text-align:center;
color:#ccc;
margin-top:20px;
font-size:13px;
}

</style>

</head>

<body>

<div class="login-box">

<h2>🩸 User Login</h2>

<?php
if($error!=""){
echo "<div class='error'>$error</div>";
}
?>

<form method="POST">

<input
type="email"
name="email"
class="form-control"
placeholder="Enter Email"
required>

<input
type="password"
name="password"
class="form-control"
placeholder="Enter Password"
required>

<button
type="submit"
name="login"
class="btn btn-login">
Login
</button>

</form>

<div class="register-link">

<a href="register.php">Register Here</a>

<a href="forgot_password.php">Forgot Password?</a>

<a href="index.php">Home</a>

</div>

<div class="footer">

© 2026 Smart Blood Donation Management System

<br>

Developed by <b>Gopalakrishnan M</b>

</div>

</div>

</body>
</html>
<?php
session_start();
include "../config.php";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    }else{
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:linear-gradient(135deg,#8B0000,#111827);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    width:380px;
    background:#1e293b;
    padding:35px;
    border-radius:15px;
    box-shadow:0 0 20px rgba(0,0,0,.5);
    text-align:center;
}

.login-box h2{
    color:#ff4d6d;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:8px;
    font-size:16px;
}

button{
    width:100%;
    padding:12px;
    background:#dc3545;
    color:white;
    border:none;
    border-radius:8px;
    font-size:17px;
    cursor:pointer;
}

button:hover{
    background:#b02a37;
}

.error{
    color:#ff8080;
    margin-bottom:15px;
    font-weight:bold;
}

.footer{
    margin-top:20px;
    color:#ccc;
    font-size:13px;
}
</style>

</head>
<body>

<div class="login-box">

<h2>🩸 Admin Login</h2>

<?php
if(isset($error)){
    echo "<div class='error'>$error</div>";
}
?>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>

<div class="footer">
© 2026 Smart Blood Donation Management System <br>
Developed by <b> Gopalakrishnan M</b>
</div>

</div>

</body>
</html>
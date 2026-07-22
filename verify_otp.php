<?php

session_start();

include "config.php";


if(!isset($_SESSION['verify_email'])){

    header("Location: register.php");
    exit();

}



if(isset($_POST['verify'])){


    $email=$_SESSION['verify_email'];

    $otp=$_POST['otp'];



    if($otp == $_SESSION['otp']){


        // Insert User After OTP Verification


        $stmt=$conn->prepare("

        INSERT INTO users
        (fullname,email,phone,city,blood_group,password,otp,is_verified)

        VALUES(?,?,?,?,?,?,?,1)

        ");



        $stmt->bind_param(

        "sssssss",

        $_SESSION['fullname'],
        $_SESSION['email'],
        $_SESSION['phone'],
        $_SESSION['city'],
        $_SESSION['blood_group'],
        $_SESSION['password'],
        $_SESSION['otp']

        );



        if($stmt->execute()){



            unset($_SESSION['fullname']);
            unset($_SESSION['email']);
            unset($_SESSION['phone']);
            unset($_SESSION['city']);
            unset($_SESSION['blood_group']);
            unset($_SESSION['password']);
            unset($_SESSION['otp']);
            unset($_SESSION['verify_email']);



            echo "

            <script>

            alert('Registration Successful');

            window.location='login.php';

            </script>

            ";


            exit();



        }else{


            echo "

            <script>
            alert('Registration Failed');
            </script>

            ";


        }



    }

    else{


        echo "

        <script>

        alert('Invalid OTP');

        </script>

        ";


    }


}


?>



<!DOCTYPE html>
<html>

<head>

<title>Verify OTP</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">



<style>


body{

background:linear-gradient(135deg,#8B0000,#111827);

height:100vh;

display:flex;

align-items:center;

justify-content:center;

font-family:Arial;

}



.box{

width:400px;

background:white;

padding:35px;

border-radius:15px;

box-shadow:0 0 20px black;

}



h2{

text-align:center;

color:#dc3545;

margin-bottom:25px;

}



</style>


</head>


<body>


<div class="box">


<h2>🩸 Verify OTP</h2>



<form method="POST">


<input type="text"
name="otp"
class="form-control"
placeholder="Enter OTP"
maxlength="6"
required>



<br>


<button class="btn btn-danger w-100"
name="verify">

Verify OTP

</button>



</form>


</div>


</body>

</html>
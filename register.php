<?php

session_start();

include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';


$error="";


if(isset($_POST['register'])){


    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $blood_group = trim($_POST['blood_group']);
    $password = $_POST['password'];



    // Check Email Already Exists

    $check=$conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s",$email);
    $check->execute();

    $result=$check->get_result();



    if($result->num_rows>0){


        $error="Email already registered!";


    }

    else{


        // Password Hash

        $hashed_password=password_hash($password,PASSWORD_DEFAULT);



        // Generate OTP

        $otp=rand(100000,999999);



        // Store temporary data

        $_SESSION['fullname']=$fullname;
        $_SESSION['email']=$email;
        $_SESSION['phone']=$phone;
        $_SESSION['city']=$city;
        $_SESSION['blood_group']=$blood_group;
        $_SESSION['password']=$hashed_password;
        $_SESSION['otp']=$otp;



        // Send OTP Mail


        $mail=new PHPMailer(true);



        try{


            $mail->isSMTP();

            $mail->Host="smtp.gmail.com";

            $mail->SMTPAuth=true;


            $mail->Username="premamohan9196@gmail.com";

            $mail->Password="yotbcapwcufgvyrn";


            $mail->SMTPSecure="tls";

            $mail->Port=587;



            $mail->setFrom(
                "premamohan9196@gmail.com",
                "Smart Blood Donation System"
            );



            $mail->addAddress($email);



            $mail->isHTML(true);



            $mail->Subject="Email Verification OTP";



            $mail->Body="

            <div style='font-family:Arial'>

            <h2 style='color:red'>
            Smart Blood Donation System
            </h2>

            <p>Hello <b>$fullname</b>,</p>

            <p>Your Verification OTP is:</p>

            <h1 style='color:#dc3545'>
            $otp
            </h1>

            <p>
            Enter this OTP to complete registration.
            </p>

            </div>

            ";



            $mail->send();



            $_SESSION['verify_email']=$email;



            echo "

            <script>

            alert('OTP sent successfully');

            window.location='verify_otp.php';

            </script>

            ";


            exit();



        }


        catch(Exception $e){


            $error="OTP Mail sending failed: ".$mail->ErrorInfo;


        }


    }


}


?>



<!DOCTYPE html>

<html>

<head>

<title>User Registration</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>


body{

background:linear-gradient(135deg,#8B0000,#111827);

height:100vh;

display:flex;

justify-content:center;

align-items:center;

font-family:Arial;

}



.register-box{

width:430px;

background:#1e293b;

padding:35px;

border-radius:15px;

box-shadow:0 0 20px #000;

}



h2{

text-align:center;

color:#ff4d6d;

margin-bottom:25px;

}



.form-control,.form-select{

margin-bottom:15px;

height:48px;

}



.btn-register{

width:100%;

height:48px;

background:#dc3545;

color:white;

border:none;

}



.error{

background:#f8d7da;

color:#842029;

padding:10px;

border-radius:5px;

text-align:center;

margin-bottom:15px;

}



</style>


</head>


<body>



<div class="register-box">


<h2>🩸 User Registration</h2>



<?php

if($error!=""){

echo "<div class='error'>$error</div>";

}

?>



<form method="POST">


<input type="text"
name="fullname"
class="form-control"
placeholder="Full Name"
required>



<input type="email"
name="email"
class="form-control"
placeholder="Email Address"
required>



<input type="text"
name="phone"
class="form-control"
placeholder="Phone Number"
maxlength="10"
required>



<input type="text"
name="city"
class="form-control"
placeholder="City"
required>



<select name="blood_group" class="form-select" required>


<option value="">Select Blood Group</option>

<option>A+</option>
<option>A-</option>
<option>B+</option>
<option>B-</option>
<option>O+</option>
<option>O-</option>
<option>AB+</option>
<option>AB-</option>


</select>



<input type="password"
name="password"
class="form-control"
placeholder="Password"
required>



<button name="register"
class="btn btn-register">

Register

</button>



</form>



</div>


</body>

</html>
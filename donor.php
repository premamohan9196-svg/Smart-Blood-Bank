<?php
session_start();
include 'config.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['save'])){

$blood_group=$_POST['blood_group'];
$age=$_POST['age'];
$gender=$_POST['gender'];
$address=$_POST['address'];
$city=$_POST['city'];
$last_donation=$_POST['last_donation'];

$email=$_SESSION['email'];

$user=$conn->query("SELECT * FROM users WHERE email='$email'");
$data=$user->fetch_assoc();
$user_id=$data['id'];

$sql="INSERT INTO donors(user_id,blood_group,age,gender,address,city,last_donation)
VALUES('$user_id','$blood_group','$age','$gender','$address','$city','$last_donation')";

if($conn->query($sql)){
echo "<script>alert('Donor Registered Successfully'); window.location='dashboard.php';</script>";
}else{
echo "Error : ".$conn->error;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Become a Blood Donor</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:linear-gradient(135deg,#8B0000,#111827);
    font-family:Arial,sans-serif;
}

.card{
    max-width:650px;
    margin:40px auto;
    background:#1e293b;
    color:white;
    border:none;
    border-radius:15px;
    box-shadow:0 0 20px rgba(0,0,0,.5);
}

.card-header{
    background:#dc3545;
    color:white;
    text-align:center;
    font-size:28px;
    font-weight:bold;
    border-radius:15px 15px 0 0 !important;
}

.form-control,
.form-select{
    margin-bottom:15px;
}

.btn-custom{
    width:48%;
}

.footer{
    text-align:center;
    color:#ccc;
    margin-top:20px;
}
</style>

</head>
<body>

<div class="container">

<div class="card">

<div class="card-header">
🩸 Blood Donor Registration
</div>

<div class="card-body">

<form method="POST">
    <label class="form-label">Name</label>
<input type="text" name="name" class="form-control" required>

<label class="form-label">Blood Group</label>
<select name="blood_group" class="form-select" required>
<option>A+</option>
<option>A-</option>
<option>B+</option>
<option>B-</option>
<option>AB+</option>
<option>AB-</option>
<option>O+</option>
<option>O-</option>
</select>  



<label class="form-label">Age</label>
<input type="number" name="age" class="form-control" required>

<label class="form-label">Gender</label>
<select name="gender" class="form-select">
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>

<label class="form-label">Address</label>
<textarea name="address" class="form-control" rows="3"></textarea>

<label class="form-label">City</label>
<input type="text" name="city" class="form-control" required>

<label class="form-label">Last Donation Date</label>
<input type="date" name="last_donation" class="form-control">

<div class="d-flex justify-content-between mt-4">

<a href="dashboard.php" class="btn btn-secondary btn-custom">
⬅ Back
</a>

<button type="submit" name="save" class="btn btn-danger btn-custom">
🩸 Register Donor
</button>

</div>

</form>

</div>

</div>

<div class="footer">
© 2026 Smart Blood Donation Management System <br>
Developed by Gopal B.Sc Computer Science Student
</div>

</div>

</body>
</html>
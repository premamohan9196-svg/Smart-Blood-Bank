<?php
session_start();
include "config.php";

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$sql = $conn->query("
SELECT users.fullname,
       donors.blood_group,
       donors.last_donation
FROM donors
INNER JOIN users
ON donors.user_id = users.id
WHERE users.email='$email'
");

$data = $sql->fetch_assoc();

if(!$data){
    die("No donor record found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Donor Certificate</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f5;
    font-family:'Segoe UI',sans-serif;
}

.certificate{
    width:900px;
    margin:40px auto;
    background:white;
    padding:60px;
    border:12px solid #dc3545;
    border-radius:20px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.3);
}

.logo img{
    width:120px;
    height:120px;
    object-fit:contain;
}

.title{
    color:#dc3545;
    font-size:42px;
    font-weight:bold;
    margin-top:10px;
}

.subtitle{
    font-size:22px;
    margin-top:20px;
}

.name{
    font-size:42px;
    font-weight:bold;
    color:#111827;
    margin:30px 0;
}

.info{
    font-size:22px;
    margin:15px;
}

.signature{
    margin-top:70px;
    display:flex;
    justify-content:space-between;
}

.sign{
    text-align:center;
}

.line{
    width:220px;
    border-top:2px solid #000;
    margin-bottom:8px;
}

.btn-area{
    text-align:center;
    margin-bottom:40px;
}

.btn{
    margin:5px;
}

</style>

</head>

<body>

<div class="certificate">

<div class="logo">
    <img src="images/image.png" alt="Blood Bank Logo">
</div>

<div class="title">
Smart Blood Donation Management System
</div>

<hr>

<h2>
Certificate of Appreciation
</h2>

<p class="subtitle">
This Certificate is Proudly Presented To
</p>

<div class="name">
<?php echo htmlspecialchars($data['fullname']); ?>
</div>

<p class="subtitle">
For the noble act of voluntarily donating blood and helping save lives.
</p>

<div class="info">
<b>Blood Group :</b>
<?php echo htmlspecialchars($data['blood_group']); ?>
</div>

<div class="info">
<b>Donation Date :</b>
<?php echo htmlspecialchars($data['last_donation']); ?>
</div>

<div class="signature">

<div class="sign">
<div class="line"></div>
Donor
</div>

<div class="sign">
<div class="line"></div>
Authorized Signature
</div>

</div>

</div>

<div class="btn-area">

<a href="certificate_pdf.php" class="btn btn-danger btn-lg">
📄 Download PDF
</a>

<a href="dashboard.php" class="btn btn-primary btn-lg">
⬅ Back to Dashboard
</a>

</div>

</body>
</html>
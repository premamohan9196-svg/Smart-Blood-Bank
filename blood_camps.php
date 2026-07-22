<?php
session_start();
include "config.php";

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

// Automatically update camp status
$conn->query("
UPDATE blood_camps
SET status='Expired'
WHERE STR_TO_DATE(CONCAT(camp_date,' ',camp_time),
'%Y-%m-%d %H:%i:%s') < NOW()
");

$conn->query("
UPDATE blood_camps
SET status='Upcoming'
WHERE STR_TO_DATE(CONCAT(camp_date,' ',camp_time),
'%Y-%m-%d %H:%i:%s') >= NOW()
");

// Show only upcoming camps to users
$result = $conn->query("
SELECT * FROM blood_camps
WHERE status='Upcoming'
ORDER BY camp_date ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blood Donation Camps</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:linear-gradient(135deg,#8b0000,#b30000,#3b0a18);
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    color:#fff;
}

.container{
    padding-top:40px;
    padding-bottom:40px;
}

.page-title{
    font-size:40px;
    font-weight:bold;
    text-align:center;
    margin-bottom:40px;
    color:#fff;
    text-shadow:0 3px 10px rgba(0,0,0,.4);
}

.card{
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,.15);
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 15px 35px rgba(0,0,0,.35);
    transition:.4s;
    margin-bottom:30px;
}

.card:hover{
    transform:translateY(-10px) scale(1.02);
    box-shadow:0 25px 45px rgba(220,53,69,.45);
}

.card-body{
    padding:25px;
}

.card-title{
    color:#ff4d6d;
    font-size:26px;
    font-weight:bold;
    margin-bottom:20px;
}

.card p{
    color:#f1f5f9;
    margin-bottom:10px;
    font-size:16px;
}

.card p b{
    color:#fff;
}

.badge{
    padding:10px 18px;
    font-size:14px;
    border-radius:30px;
}

.btn-back{
    display:inline-block;
    margin-top:25px;
    background:#dc3545;
    color:#fff;
    text-decoration:none;
    padding:12px 30px;
    border-radius:10px;
    font-weight:bold;
    transition:.3s;
}

.btn-back:hover{
    background:#b91c1c;
    color:#fff;
    transform:translateY(-3px);
}

.no-camp{
    background:rgba(255,255,255,.08);
    border-radius:15px;
    padding:30px;
    text-align:center;
    font-size:22px;
    color:#fff;
}
</style>
</head>

<body>

<div class="container mt-5">

<h2 class="page-title">
🩸 Upcoming Blood Donation Camps
</h2>

<div class="row">

<?php if($result->num_rows>0){ ?>

<?php while($row=$result->fetch_assoc()){ ?>

<div class="col-lg-6">

<div class="card">

<div class="card-body">

<h3 class="card-title">
🩸 <?php echo $row['camp_name']; ?>
</h3>

<p><b>📅 Date :</b> <?php echo $row['camp_date']; ?></p>

<p><b>⏰ Time :</b> <?php echo $row['camp_time']; ?></p>

<p><b>📍 Location :</b> <?php echo $row['location']; ?></p>

<p><b>👨 Organizer :</b> <?php echo $row['organizer']; ?></p>

<p><b>📝 Description :</b><br>
<?php echo $row['description']; ?>
</p>

<span class="badge bg-success">
🟢 Upcoming
</span>

</div>

</div>

</div>

<?php } ?>

<?php } else { ?>

<div class="col-12">

<div class="no-camp">
🚫 No Upcoming Blood Donation Camps Available.
</div>

</div>

<?php } ?>

</div>

<a href="dashboard.php" class="btn btn-primary">
⬅ Back Dashboard
</a>

</div>

</body>
</html>
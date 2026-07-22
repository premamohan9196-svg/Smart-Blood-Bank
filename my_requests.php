<?php
session_start();
include "config.php";

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$result = $conn->query("SELECT * FROM blood_requests WHERE email='$email' ORDER BY request_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{
    background:linear-gradient(135deg,#8B0000,#b30000,#3b0a18);
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
}

.container{
    max-width:1000px;
}

.card{
    margin-top:40px;
    border:none;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 15px 35px rgba(0,0,0,.4);
}

.card-header{
    background:#dc3545;
    color:#fff;
    text-align:center;
    font-size:28px;
    font-weight:bold;
    padding:18px;
}

.card-body{
    background:#1e293b;
}

.table{
    color:#fff;
    margin-bottom:0;
}

.table thead{
    background:#dc3545;
}

.table thead th{
    color:#fff;
    text-align:center;
}

.table tbody td{
    text-align:center;
    vertical-align:middle;
}

.table tbody tr:hover{
    background:#334155;
}

.btn-back{
    background:#dc3545;
    color:#fff;
    padding:10px 25px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
    transition:.3s;
}

.btn-back:hover{
    background:#b91c1c;
    color:#fff;
    transform:translateY(-2px);
}

footer{
    color:#fff;
    text-align:center;
    margin-top:25px;
}
</style>
<title>My Blood Requests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<div class="card-header">
🩸 My Blood Requests
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>
<tr>
<th>S.No</th>
<th>Blood Group</th>
<th>Units</th>
<th>Hospital</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php
$sn=1;

while($row=$result->fetch_assoc()){
?>

<tr>

<td><?php echo $sn++; ?></td>

<td>
<span class="fw-bold text-danger">
<?php echo $row['blood_group']; ?>
</span>
</td>

<td><?php echo $row['units']; ?></td>

<td><?php echo $row['hospital']; ?></td>

<td>

<?php
if($row['status']=="Approved"){
    echo "<span class='badge bg-success fs-6'>✅ Approved</span>";
}
elseif($row['status']=="Rejected"){
    echo "<span class='badge bg-danger fs-6'>❌ Rejected</span>";
}
else{
    echo "<span class='badge bg-warning text-dark fs-6'>⏳ Pending</span>";
}
?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div class="text-center mt-4">

<a href="dashboard.php" class="btn btn-primary">
⬅ Back Dashboard
</a>

</div>

</div>

</div>

<footer class="mt-4">
© 2026 Smart Blood Donation Management System
</footer>

</div>

</body>
</html>
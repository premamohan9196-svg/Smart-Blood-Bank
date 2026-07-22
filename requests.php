<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM blood_requests");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blood Requests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#0f172a;
}

.card{
    background:#1e293b;
    border:none;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,.4);
}

.card-header{
    background:#dc3545;
    color:white;
    text-align:center;
    font-size:28px;
    font-weight:bold;
    border-radius:15px 15px 0 0 !important;
}

.table{
    color:white;
}

.table thead{
    background:#dc3545;
}

.table thead th{
    color:white;
    text-align:center;
}

.table td{
    text-align:center;
    vertical-align:middle;
}

.table tbody tr:hover{
    background:#334155;
}

.btn-dashboard{
    background:#0d6efd;
    color:white;
    border:none;
    padding:10px 25px;
    border-radius:8px;
    text-decoration:none;
}

.btn-dashboard:hover{
    background:#0b5ed7;
    color:white;
}

footer{
    color:#ccc;
    text-align:center;
    margin-top:25px;
}
</style>

</head>
<body>

<div class="container py-5">

<div class="card">

<div class="card-header">
🩸 Blood Request Management
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>
<th>ID</th>
<th>Patient Name</th>
<th>Blood Group</th>
<th>Units</th>
<th>Hospital</th>
<th>City</th>
<th>Contact</th>
<th>Status</th>
</tr>

</thead>

<tbody>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['request_id']; ?></td>
<td><?php echo $row['patient_name']; ?></td>
<td><strong><?php echo $row['blood_group']; ?></strong></td>
<td><?php echo $row['units']; ?></td>
<td><?php echo $row['hospital']; ?></td>
<td><?php echo $row['city']; ?></td>
<td><?php echo $row['contact']; ?></td>

<td>

<?php
if($row['status']=="Pending"){
    echo "<span class='badge bg-warning text-dark'>Pending</span>";
    echo "<br><br>";
    echo "<a href='approve.php?id=".$row['request_id']."' class='btn btn-success btn-sm'>Approve</a>";
}else{
    echo "<span class='badge bg-success'>Approved</span>";
}
?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div class="text-center mt-4">

<a href="dashboard.php" class="btn-dashboard">
⬅ Back to Dashboard
</a>

</div>

</div>

</div>

<footer>
© 2026 Smart Blood Donation Management System <br>
Developed by <b> Gopalakrishnan M</b>
</footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
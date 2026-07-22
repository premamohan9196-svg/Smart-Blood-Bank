<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM blood_camps ORDER BY camp_date DESC");


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
    background:#0f172a;
    font-family:'Segoe UI',sans-serif;
}

/* Card */

.card{
    background:#1e293b;
    border:none;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.4);
}

.card-header{
    background:linear-gradient(90deg,#dc3545,#b91c1c);
    color:white;
    text-align:center;
    font-size:28px;
    font-weight:bold;
    padding:18px;
}

/* Table */

.table{
    color:white;
    margin-bottom:0;
}

.table thead{
    background:#dc3545;
}

.table thead th{
    color:white;
    text-align:center;
    vertical-align:middle;
}

.table td{
    text-align:center;
    vertical-align:middle;
}

.table tbody tr:hover{
    background:#334155;
    transition:.3s;
}

/* Buttons */

.btn-warning{
    color:#000;
    font-weight:bold;
}

.btn-warning:hover{
    transform:translateY(-2px);
}

.btn-danger:hover{
    transform:translateY(-2px);
}

.btn-back{
    display:inline-block;
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:12px 28px;
    border-radius:10px;
    font-weight:600;
    transition:.3s;
}

.btn-back:hover{
    background:#1d4ed8;
    color:white;
    transform:translateY(-3px);
}

/* Footer */

footer{
    text-align:center;
    color:#cbd5e1;
    margin-top:30px;
    padding:15px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="card">

<div class="card-header">
🩸 Blood Donation Camps
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>
<th>S.NO</th>
<th>Camp Name</th>
<th>Date</th>
<th>Time</th>
<th>Location</th>
<th>Organizer</th>
<th>Description</th>
<th>Status</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php
$sn = 1;

while($row = $result->fetch_assoc()){
?>

<tr>

<td><?php echo $sn++; ?></td>

<td><strong><?php echo $row['camp_name']; ?></strong></td>

<td><?php echo date("d M Y", strtotime($row['camp_date'])); ?></td>

<td><?php echo $row['camp_time']; ?></td>

<td><?php echo $row['location']; ?></td>

<td><?php echo $row['organizer']; ?></td>

<td style="max-width:250px;">
<?php echo $row['description']; ?>
</td>

<td>

<?php

if(strtotime($row['camp_date']) < strtotime(date("Y-m-d"))){

    echo "<span class='badge bg-danger'>Expired</span>";

}else{

    echo "<span class='badge bg-success'>Upcoming</span>";

}

?>

</td>


<td>

<a href="edit_camp.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm mb-2 w-100">
✏ Edit
</a>

<a href="delete_camp.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm w-100"
onclick="return confirm('Delete this camp?')">
🗑 Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div class="text-center mt-4">

<a href="dashboard.php" class="btn-back">
⬅ Back to Dashboard
</a>

</div>

</div>

</div>

<footer>

© 2026 Smart Blood Donation Management System <br>
Developed by <b>Gopalakrishnan M</b>

</footer>

</div>

</body>
</html>
<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM feedback ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Feedback Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
<style>
body{
    background:#0f172a;
    font-family:'Segoe UI',sans-serif;
}

.card{
    background:#1e293b;
    border:none;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,.4);
}

.card-header{
    background:#dc3545;
    color:#fff;
    font-size:28px;
    font-weight:bold;
    text-align:center;
    border-radius:15px 15px 0 0 !important;
}

.table{
    color:#fff;
    margin-bottom:0;
}

.table thead{
    background:#dc3545;
}

.table thead th{
    text-align:center;
    color:#fff;
}

.table tbody td{
    text-align:center;
    vertical-align:middle;
}

.table tbody tr:hover{
    background:#334155;
}

.rating{
    color:#FFD700;
    font-size:18px;
}

.btn-dashboard{
    background:#0d6efd;
    color:white;
    border:none;
    padding:10px 25px;
    border-radius:8px;
    text-decoration:none;
    transition:.3s;
}

.btn-dashboard:hover{
    background:#0b5ed7;
    color:white;
}

footer{
    text-align:center;
    color:#cbd5e1;
    margin-top:25px;
}
</style>

<div class="container py-5">

<div class="card">

<div class="card-header">
⭐ User Feedback Management
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>
<tr>
<th>S.No</th>
<th>Name</th>
<th>Email</th>
<th>Rating</th>
<th>Feedback</th>
<th>Date</th>
</tr>
</thead>

<tbody>



<?php
$sn = 1;
while($row = $result->fetch_assoc()){
?>

<tr>

<td><?php echo $sn++; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['email']; ?></td>

<td class="rating">
<?php
for($i=1;$i<=$row['rating'];$i++){
    echo "⭐";
}
?>
</td>

<td><?php echo $row['message']; ?></td>

<td><?php echo $row['created_at']; ?></td>

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
Developed by <b>Gopalakrishnan M</b>
</footer>

</div>

</body>
</html>
<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact Messages</title>

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
    box-shadow:0 10px 25px rgba(0,0,0,.4);
    overflow:hidden;
}

/* Header */

.card-header{
    background:linear-gradient(90deg,#dc3545,#b91c1c);
    color:#fff;
    font-size:28px;
    font-weight:bold;
    text-align:center;
    padding:18px;
}

/* Table */

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

.btn-primary{
    background:#2563eb;
    border:none;
}

.btn-primary:hover{
    background:#1d4ed8;
}

.btn-danger:hover{
    background:#b91c1c;
}

.btn-back{
    background:#2563eb;
    color:white;
    padding:12px 28px;
    border-radius:10px;
    text-decoration:none;
    display:inline-block;
    transition:.3s;
}

.btn-back:hover{
    background:#1d4ed8;
    color:white;
    transform:translateY(-3px);
}

td{
    word-break:break-word;
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
📩 Contact Messages
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>
<th>S.NO</th>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Date</th>
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

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['subject']; ?></td>

<td style="max-width:250px;">
<?php echo $row['message']; ?>
</td>

<td><?php echo $row['created_at']; ?></td>

<td>

<a href="reply_message.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm mb-2 w-100">
➤ Reply
</a>

<a href="mailto:<?php echo $row['email']; ?>">
<?php echo $row['email']; ?>
</a>

echo date("d M Y h:i A", strtotime($row['created_at']));

<a href="delete_message.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm w-100"
onclick="return confirm('Delete this message?')">
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
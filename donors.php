<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$sql = "SELECT donors.donor_id, users.fullname, users.phone, donors.blood_group, donors.city
        FROM donors
        INNER JOIN users ON donors.user_id = users.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registered Blood Donors</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#0f172a;
    color:#fff;
}

.header{
    background:#dc3545;
    padding:20px;
    text-align:center;
    font-size:28px;
    font-weight:bold;
}

.container{
    width:95%;
    margin:30px auto;
}

.back-btn{
    display:inline-block;
    margin-bottom:20px;
    padding:10px 18px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
}

.back-btn:hover{
    background:#1d4ed8;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#1e293b;
    border-radius:10px;
    overflow:hidden;
}

th{
    background:#dc3545;
    padding:15px;
}

td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #374151;
}

tr:hover{
    background:#334155;
}

.edit-btn,
.delete-btn{
    padding:8px 15px;
    color:white;
    text-decoration:none;
    border-radius:5px;
    margin:0 3px;
}

.edit-btn{
    background:#0d6efd;
}

.edit-btn:hover{
    background:#0b5ed7;
}

.delete-btn{
    background:#dc3545;
}

.delete-btn:hover{
    background:#bb2d3b;
}

footer{
    margin-top:40px;
    background:#111827;
    text-align:center;
    padding:15px;
}
</style>

</head>
<body>

<div class="header">
🩸 Registered Blood Donors
</div>

<div class="container">

<a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

<table>

<tr>
<th>Name</th>
<th>Phone</th>
<th>Blood Group</th>
<th>City</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['fullname']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><b><?php echo $row['blood_group']; ?></b></td>
<td><?php echo $row['city']; ?></td>

<td>
<a class="edit-btn" href="edit_donor.php?id=<?php echo $row['donor_id']; ?>">✏ Edit</a>

<a class="delete-btn"
href="delete_donor.php?id=<?php echo $row['donor_id']; ?>"
onclick="return confirm('Are you sure you want to delete this donor?')">
🗑 Delete
</a>
</td>

</tr>

<?php } ?>

</table>

</div>

<footer>
© 2026 Smart Blood Donation Management System <br>
Developed by <b> Gopalakrishnan M</b>
</footer>

</body>
</html>
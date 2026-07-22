<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['search']) && $_GET['search']!=""){

    $search = $_GET['search'];

    $result = $conn->query("SELECT * FROM users
    WHERE fullname LIKE '%$search%'
    OR email LIKE '%$search%'
    ORDER BY id DESC");

}else{

    $result = $conn->query("SELECT * FROM users ORDER BY id DESC");

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Users</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#0f172a;
    color:#fff;
    font-family:'Segoe UI',sans-serif;
}

.container{
    margin-top:40px;
}

.page-title{
    background:linear-gradient(90deg,#dc3545,#b91c1c);
    padding:15px;
    border-radius:12px;
    text-align:center;
    font-size:30px;
    font-weight:bold;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,.3);
}

.search-box{
    background:#1e293b;
    padding:20px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,.3);
    margin-bottom:25px;
}

.form-control{
    background:#0f172a;
    color:white;
    border:1px solid #475569;
}

.form-control::placeholder{
    color:#94a3b8;
}

.form-control:focus{
    background:#0f172a;
    color:#fff;
    border-color:#dc3545;
    box-shadow:none;
}

.btn-search{
    background:#dc3545;
    color:white;
    font-weight:bold;
}

.btn-search:hover{
    background:#b91c1c;
    color:white;
}

.table-box{
    background:#1e293b;
    padding:20px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,.3);
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
    vertical-align:middle;
    text-align:center;
}

.table tbody tr:hover{
    background:#334155;
}

.profile-img{
    width:60px;
    height:60px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #dc3545;
}

.btn-delete{
    background:#dc3545;
    border:none;
}

.btn-delete:hover{
    background:#b91c1c;
}

.btn-back{
    margin-top:25px;
    background:#2563eb;
    color:white;
    padding:10px 25px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
}

.btn-back:hover{
    background:#1d4ed8;
    color:white;
}
</style>

</head>

<body>

<div class="container mt-5">

<h2 class="page-title">
👥 Manage Users
</h2>

<form method="GET" class="mb-3">

<div class="search-box">

<form method="GET">

<div class="input-group">

<input
type="text"
name="search"
class="form-control"
placeholder="🔍 Search by Name or Email">

<button class="btn btn-search">
Search
</button>

</div>

</form>

</div>
</form>

<div class="table-box">

<table class="table table-bordered table-hover">

<thead>

<tr>
<th>S.NO</th>
<th>Photo</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
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

<td>
<img src="../uploads/<?php echo $row['profile_photo']; ?>"
class="profile-img">
</td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['phone']; ?></td>
<td>
<a href="delete_user.php?id=<?php echo $row['id']; ?>"
class="btn btn-delete btn-sm"
onclick="return confirm('Delete this user?')">
🗑 Delete
</a>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
<br><br>

<a href="dashboard.php" class="btn-back">
⬅ Back to Dashboard
</a>



</body>
</html>
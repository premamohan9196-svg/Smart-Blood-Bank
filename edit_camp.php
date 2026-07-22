<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: view_camps.php");
    exit();
}

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM blood_camps WHERE id='$id'");

if($result->num_rows==0){
    die("Camp not found");
}

$row = $result->fetch_assoc();

if(isset($_POST['update'])){

    $camp_name  = $_POST['camp_name'];
    $camp_date  = $_POST['camp_date'];
    $camp_time  = $_POST['camp_time'];
    $location   = $_POST['location'];
    $organizer  = $_POST['organizer'];
    $description= $_POST['description'];

    $conn->query("UPDATE blood_camps SET
    camp_name='$camp_name',
    camp_date='$camp_date',
    camp_time='$camp_time',
    location='$location',
    organizer='$organizer',
    description='$description'
    WHERE id='$id'");

    echo "<script>
    alert('Camp Updated Successfully');
    window.location='view_camps.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Camp</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#0f172a;
}

.card{
margin-top:40px;
border:none;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,.4);
}

.card-header{
background:#dc3545;
color:white;
font-size:28px;
font-weight:bold;
text-align:center;
}

.btn-save{
background:#dc3545;
color:white;
}

.btn-save:hover{
background:#b91c1c;
color:white;
}

</style>

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card">

<div class="card-header">
✏ Edit Blood Camp
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Camp Name</label>
<input type="text" name="camp_name" class="form-control"
value="<?php echo $row['camp_name']; ?>" required>
</div>

<div class="mb-3">
<label>Date</label>
<input type="date" name="camp_date" class="form-control"
value="<?php echo $row['camp_date']; ?>" required>
</div>

<div class="mb-3">
<label>Time</label>
<input type="time" name="camp_time" class="form-control"
value="<?php echo $row['camp_time']; ?>" required>
</div>

<div class="mb-3">
<label>Location</label>
<input type="text" name="location" class="form-control"
value="<?php echo $row['location']; ?>" required>
</div>

<div class="mb-3">
<label>Organizer</label>
<input type="text" name="organizer" class="form-control"
value="<?php echo $row['organizer']; ?>" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" rows="4"><?php echo $row['description']; ?></textarea>
</div>

<button type="submit" name="update" class="btn btn-save">
💾 Update Camp
</button>

<a href="view_camps.php" class="btn btn-secondary">
⬅ Back
</a>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
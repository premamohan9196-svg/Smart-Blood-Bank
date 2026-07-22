<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['save'])){

    $camp_name = $_POST['camp_name'];
    $camp_date = $_POST['camp_date'];
    $camp_time = $_POST['camp_time'];
    $location = $_POST['location'];
    $organizer = $_POST['organizer'];
    $description = $_POST['description'];

    $sql = "INSERT INTO blood_camps(camp_name,camp_date,camp_time,location,organizer,description)
            VALUES('$camp_name','$camp_date','$camp_time','$location','$organizer','$description')";

    if($conn->query($sql)){
        echo "<script>alert('Blood Camp Added Successfully');</script>";
    }else{
        echo "<script>alert('Error');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Blood Camp</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#0f172a;
    color:white;
}
.box{
    width:700px;
    margin:40px auto;
    background:#1e293b;
    padding:30px;
    border-radius:15px;
}
</style>

</head>

<body>

<div class="box">

<h2 class="text-center text-danger mb-4">
🩸 Add Blood Donation Camp
</h2>

<form method="POST">

<input type="text" name="camp_name" class="form-control mb-3" placeholder="Camp Name" required>

<input type="date" name="camp_date" class="form-control mb-3" required>

<input type="time" name="camp_time" class="form-control mb-3" required>

<input type="text" name="location" class="form-control mb-3" placeholder="Location" required>

<input type="text" name="organizer" class="form-control mb-3" placeholder="Organizer Name" required>

<textarea name="description" class="form-control mb-3" rows="4" placeholder="Description"></textarea>

<button type="submit" name="save" class="btn btn-danger w-100">
Save Camp
</button>

</form>

<br>

<div class="text-center mt-4">
<a href="dashboard.php" class="btn-dashboard">
⬅ Back to Dashboard
</a>
</div>
</div>

</body>
</html>
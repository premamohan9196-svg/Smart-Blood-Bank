<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: donors.php");
    exit();
}

$id = (int)$_GET['id'];

if(isset($_POST['update'])){

    $blood_group = $_POST['blood_group'];
    $city = $_POST['city'];

    $conn->query("UPDATE donors SET blood_group='$blood_group', city='$city' WHERE donor_id='$id'");

    echo "<script>alert('Donor Updated Successfully');window.location='donors.php';</script>";
}

$result = $conn->query("SELECT * FROM donors WHERE donor_id='$id'");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Donor</title>

<style>
body{
    font-family:Arial,sans-serif;
    background:#0f172a;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    width:400px;
    background:#1e293b;
    color:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 0 15px rgba(0,0,0,.5);
}

h2{
    text-align:center;
    color:#dc3545;
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:5px;
}

input,select{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:none;
    font-size:16px;
}

button{
    width:100%;
    margin-top:20px;
    padding:12px;
    background:#dc3545;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#b02a37;
}

.back{
    display:block;
    text-align:center;
    margin-top:15px;
    color:#fff;
    text-decoration:none;
}
</style>

</head>
<body>

<div class="box">

<h2>🩸 Edit Donor</h2>

<form method="POST">

<label>Blood Group</label>

<select name="blood_group">
<?php
$groups=["A+","A-","B+","B-","AB+","AB-","O+","O-"];
foreach($groups as $g){
    $selected=($row['blood_group']==$g)?"selected":"";
    echo "<option value='$g' $selected>$g</option>";
}
?>
</select>

<label>City</label>

<input type="text" name="city" value="<?php echo $row['city']; ?>" required>

<button type="submit" name="update">Update Donor</button>

<a href="donors.php" class="back">⬅ Back to Donors</a>

</form>

</div>

</body>
</html>
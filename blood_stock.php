<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include "config.php";

$search = "";

if(isset($_GET['blood_group'])){
    $search = $_GET['blood_group'];

    if($search != ""){
        $result = $conn->query("SELECT * FROM blood_stock WHERE blood_group='$search'");
    }else{
        $result = $conn->query("SELECT * FROM blood_stock ORDER BY blood_group");
    }
}else{
    $result = $conn->query("SELECT * FROM blood_stock ORDER BY blood_group");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Blood Stock</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0f172a;
    color:white;
}

.container{
    margin-top:40px;
}

.card{
    background:#1e293b;
    border:none;
    border-radius:15px;
}

.table{
    color:white;
}

.table thead{
    background:#dc3545;
}

.btn-danger{
    border-radius:8px;
}

</style>

</head>

<body>

<div class="container">

<div class="card p-4">

<h2 class="text-center text-danger mb-4">
🩸 Blood Stock
</h2>

<form method="GET" class="row mb-4">

<div class="col-md-6">

<select name="blood_group" class="form-select">

<option value="">All Blood Groups</option>

<?php
$groups=["A+","A-","B+","B-","AB+","AB-","O+","O-"];

foreach($groups as $g){
    $selected=($search==$g)?"selected":"";
    echo "<option value='$g' $selected>$g</option>";
}
?>

</select>

</div>

<div class="col-md-6">

<button class="btn btn-danger">
Search
</button>

<a href="blood_stock.php" class="btn btn-secondary">
Reset
</a>

</div>

</form>

<table class="table table-bordered table-hover">

<thead>

<tr>
<th>S.No</th>
<th>Blood Group</th>
<th>Available Units</th>
</tr>

</thead>

<tbody>

<?php

$sn=1;

while($row=$result->fetch_assoc()){

?>

<tr>

<td><?php echo $sn++; ?></td>

<td><?php echo $row['blood_group']; ?></td>

<td>

<?php

if($row['units']<=5){

echo "<span class='badge bg-danger'>{$row['units']} Units</span>";

}else{

echo "<span class='badge bg-success'>{$row['units']} Units</span>";

}

?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<div class="text-center mt-4">

<a href="dashboard.php" class="btn btn-primary">
⬅ Back Dashboard
</a>

</div>

</div>

</div>

</body>
</html>
<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM blood_stock WHERE id='$id'");
$row = $result->fetch_assoc();

if(isset($_POST['update'])){

    $units = $_POST['units'];

    $conn->query("UPDATE blood_stock SET units='$units' WHERE id='$id'");

    echo "<script>
    alert('Blood Stock Updated Successfully');
    window.location='blood_stock.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Update Blood Stock</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card p-4 shadow">

<h2 class="text-center text-danger">
🩸 Update Blood Stock
</h2>

<form method="POST">

<div class="mb-3">

<label>Blood Group</label>

<input
type="text"
class="form-control"
value="<?php echo $row['blood_group']; ?>"
readonly>

</div>

<div class="mb-3">

<label>Available Units</label>

<input
type="number"
name="units"
class="form-control"
value="<?php echo $row['units']; ?>"
required>

</div>

<button
type="submit"
name="update"
class="btn btn-success">
Update Stock
</button>

<a href="blood_stock.php"
class="btn btn-secondary">
Back
</a>

</form>

</div>

</div>

</body>
</html>
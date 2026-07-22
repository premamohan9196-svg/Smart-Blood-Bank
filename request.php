<?php
include "config.php";

if(isset($_POST['request'])){

    $patient_name = $_POST['patient_name'];
    $blood_group = $_POST['blood_group'];
    $units = $_POST['units'];
    $hospital = $_POST['hospital'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO blood_requests
    (patient_name,blood_group,units,hospital,city,contact)
    VALUES
    ('$patient_name','$blood_group','$units','$hospital','$city','$contact')";

    if($conn->query($sql)){
        echo "<script>alert('Blood Request Submitted Successfully');
        window.location='dashboard.php';</script>";
    }else{
        echo "<script>alert('Error!');</script>";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Blood Request</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>


<div class="container mt-5">

<h2 class="text-center text-danger">🩸 Emergency Blood Request</h2>

<form method="POST" class="card p-4 shadow mt-4">

<div class="mb-3">
<label class="form-label">Patient Name</label>
<input type="text" name="patient_name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Blood Group</label>
<select name="blood_group" class="form-select" required>
<option>A+</option>
<option>A-</option>
<option>B+</option>
<option>B-</option>
<option>AB+</option>
<option>AB-</option>
<option>O+</option>
<option>O-</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Units Required</label>
<input type="number" name="units" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Hospital Name</label>
<input type="text" name="hospital" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">City</label>
<input type="text" name="city" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Contact Number</label>
<input type="text" name="contact" class="form-control" required>
</div>

<button type="submit" name="request" class="btn btn-danger">
Submit Request
</button>

</form>

</div>

<?php include "footer.php"; ?>

</body>
</html>
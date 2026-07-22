<?php
include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Blood</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

<div class="container mt-5">

<h2 class="text-center text-danger">🩸 Search Blood Donors</h2>

<form method="GET" class="row g-3 justify-content-center mt-4">

<div class="col-md-4">
<select name="blood_group" class="form-select">
<option value="">Select Blood Group</option>
<option value="A+">A+</option>
<option value="A-">A-</option>
<option value="B+">B+</option>
<option value="B-">B-</option>
<option value="AB+">AB+</option>
<option value="AB-">AB-</option>
<option value="O+">O+</option>
<option value="O-">O-</option>
</select>
</div>

<div class="col-md-2">
<button type="submit" class="btn btn-danger mt-100">Search</button> <a href="dashboard.php"  class="btn btn-danger mt-100">Back</a>
</div>


</form>

<hr>

<?php

if(isset($_GET['blood_group'])){

    $blood = $_GET['blood_group'];

    $sql = "SELECT users.fullname, users.phone, donors.city
            FROM donors
            INNER JOIN users ON donors.user_id = users.id
            WHERE donors.blood_group='$blood'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){

        echo "<table class='table table-bordered table-striped table-hover mt4'>";
        echo "<tr>
                <th>Name</th>
                <th>Phone</th>
                <th>City</th>
              </tr>";

        while($row = $result->fetch_assoc()){

            echo "<tr>";
            echo "<td>".$row['fullname']."</td>";
            echo "<td>".$row['phone']."</td>";
            echo "<td>".$row['city']."</td>";
            echo "</tr>";

        }

        echo "</table>";

    } else {

        echo "<h3>No Donors Found</h3>";
        

    }

}

?>

</div>

</body>
</html>
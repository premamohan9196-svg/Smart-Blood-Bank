<?php
session_start();

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

include "config.php";

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$message = "";

if(isset($_POST['update'])){

    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $blood_group = trim($_POST['blood_group']);

    $photo = $user['profile_photo'];

    if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error']==0){

        $filename = time()."_".basename($_FILES['profile_photo']['name']);

        $target = "uploads/".$filename;

        $ext = strtolower(pathinfo($filename,PATHINFO_EXTENSION));

        $allow = ['jpg','jpeg','png','webp'];

        if(in_array($ext,$allow)){

            move_uploaded_file($_FILES['profile_photo']['tmp_name'],$target);

            $photo = $filename;

        }
    }

    $update = $conn->prepare("UPDATE users
    SET fullname=?, phone=?, city=?, blood_group=?, profile_photo=?
    WHERE email=?");

    $update->bind_param(
        "ssssss",
        $fullname,
        $phone,
        $city,
        $blood_group,
        $photo,
        $email
    );

    if($update->execute()){

        echo "<script>
        alert('Profile Updated Successfully');
        window.location='dashboard.php';
        </script>";
        exit();

    }else{

        $message="Profile Update Failed";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="dashboard.css">

</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-7">

<div class="card shadow-lg border-0 rounded-4">

<div class="card-header bg-danger text-white text-center">

<h3>
<i class="bi bi-person-circle"></i>
Edit Profile
</h3>

</div>

<div class="card-body p-4">

<?php
if($message!=""){
echo "<div class='alert alert-danger'>$message</div>";
}
?>

<form method="POST" enctype="multipart/form-data">

<div class="text-center mb-4">

<img
src="uploads/<?php echo !empty($user['profile_photo']) ? $user['profile_photo'] : 'default.png'; ?>"
class="rounded-circle shadow"
width="140"
height="140"
style="object-fit:cover;">

</div>

<div class="mb-3">

<label class="form-label">
Full Name
</label>

<input
type="text"
name="fullname"
class="form-control"
value="<?php echo htmlspecialchars($user['fullname']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Email
</label>

<input
type="email"
class="form-control"
value="<?php echo htmlspecialchars($user['email']); ?>"
readonly>

</div>

<div class="mb-3">

<label class="form-label">
Phone Number
</label>

<input
type="text"
name="phone"
class="form-control"
value="<?php echo htmlspecialchars($user['phone']); ?>">

</div>

<div class="mb-3">

<label class="form-label">
City
</label>

<input
type="text"
name="city"
class="form-control"
value="<?php echo htmlspecialchars($user['city']); ?>">

</div>

<div class="mb-3">

<label class="form-label">
Blood Group
</label>

<select
name="blood_group"
class="form-select">

<?php

$groups=[
"A+","A-",
"B+","B-",
"O+","O-",
"AB+","AB-"
];

foreach($groups as $g){

$selected=($user['blood_group']==$g) ? "selected" : "";

echo "<option value='$g' $selected>$g</option>";

}

?>

</select>

</div>

<div class="mb-4">

<label class="form-label">
Profile Photo
</label>

<input
type="file"
name="profile_photo"
class="form-control">

</div>

                <!-- Update Button -->

                <div class="text-center mt-4">

                    <button type="submit" name="update"
                        class="btn btn-danger btn-lg px-5">

                        <i class="bi bi-check-circle-fill"></i>

                        Update Profile

                    </button>

                    <a href="dashboard.php"
                        class="btn btn-secondary btn-lg px-5 ms-2">

                        <i class="bi bi-x-circle-fill"></i>

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
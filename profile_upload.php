<?php
session_start();

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

include "config.php";

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT profile_photo FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$message="";
$type="";

if(isset($_POST['upload'])){

    if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error']==0){

        $allowed = ["jpg","jpeg","png","webp"];

        $ext = strtolower(pathinfo($_FILES['profile_photo']['name'],PATHINFO_EXTENSION));

        if(in_array($ext,$allowed)){

            if(!is_dir("uploads")){
                mkdir("uploads");
            }

            $filename = time()."_".basename($_FILES['profile_photo']['name']);

            $target = "uploads/".$filename;

            if(move_uploaded_file($_FILES['profile_photo']['tmp_name'],$target)){

                if(!empty($user['profile_photo']) &&
                   $user['profile_photo']!="default.png" &&
                   file_exists("uploads/".$user['profile_photo'])){

                    unlink("uploads/".$user['profile_photo']);
                }

                $update=$conn->prepare("UPDATE users SET profile_photo=? WHERE email=?");
                $update->bind_param("ss",$filename,$email);

                if($update->execute()){

                    echo "<script>
                    alert('Profile Photo Updated Successfully');
                    window.location='dashboard.php';
                    </script>";
                    exit();

                }else{

                    $message="Database Update Failed";
                    $type="danger";

                }

            }else{

                $message="Image Upload Failed";
                $type="danger";

            }

        }else{

            $message="Only JPG, JPEG, PNG and WEBP allowed";
            $type="warning";

        }

    }else{

        $message="Please Select an Image";
        $type="warning";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Upload Profile Photo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="dashboard.css">

</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-6">

<div class="card shadow-lg border-0 rounded-4">

<div class="card-header bg-danger text-white text-center">

<h3>

<i class="bi bi-camera-fill"></i>

Upload Profile Photo

</h3>

</div>

<div class="card-body p-4">

<?php if($message!=""){ ?>

<div class="alert alert-<?php echo $type; ?>">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST" enctype="multipart/form-data">

<div class="text-center mb-4">

<img
id="preview"
src="uploads/<?php echo !empty($user['profile_photo']) ? $user['profile_photo'] : 'default.png'; ?>"
class="rounded-circle shadow"
width="180"
height="180"
style="object-fit:cover;border:5px solid #dc3545;">

</div>

<div class="mb-4">

<label class="form-label">

Choose Profile Photo

</label>

<input
type="file"
name="profile_photo"
id="profile_photo"
class="form-control"
accept="image/*"
required>

</div>

<div class="text-center">

<button
type="submit"
name="upload"
class="btn btn-danger btn-lg px-5">

<i class="bi bi-cloud-arrow-up-fill"></i>

Upload Photo

</button>

<a
href="dashboard.php"
class="btn btn-secondary btn-lg px-5 ms-2">

<i class="bi bi-arrow-left-circle"></i>

Back

</a>

</div>

</form>

</div>

</div>

</div>

</div>

<script>

// Image Preview

document.getElementById("profile_photo").addEventListener("change",function(e){

const file=e.target.files[0];

if(file){

const reader=new FileReader();

reader.onload=function(event){

document.getElementById("preview").src=event.target.result;

}

reader.readAsDataURL(file);

}

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
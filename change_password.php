<?php
session_start();

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

include "config.php";

$email = $_SESSION['email'];

$message = "";
$type = "";

if(isset($_POST['change'])){

    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if(password_verify($current,$user['password'])){

        if($new == $confirm){

            $hash = password_hash($new,PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password=? WHERE email=?");
            $update->bind_param("ss",$hash,$email);

            if($update->execute()){

                $message = "Password Changed Successfully!";
                $type = "success";

            }else{

                $message = "Something went wrong!";
                $type = "danger";

            }

        }else{

            $message = "New Password and Confirm Password do not match!";
            $type = "danger";

        }

    }else{

        $message = "Current Password is Incorrect!";
        $type = "danger";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Change Password</title>

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

<i class="bi bi-shield-lock-fill"></i>

Change Password

</h3>

</div>

<div class="card-body p-4">

<?php if($message!=""){ ?>

<div class="alert alert-<?php echo $type; ?>">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Current Password

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-lock-fill"></i>

</span>

<input
type="password"
name="current_password"
class="form-control"
placeholder="Enter Current Password"
required>

</div>

</div>

<div class="mb-3">

<label class="form-label">

New Password

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-key-fill"></i>

</span>

<input
type="password"
name="new_password"
class="form-control"
placeholder="Enter New Password"
required>

</div>

</div>

<div class="mb-4">

<label class="form-label">

Confirm New Password

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-check-circle-fill"></i>

</span>

<input
type="password"
name="confirm_password"
class="form-control"
placeholder="Confirm New Password"
required>

</div>

</div>

                <div class="text-center mt-4">

                    <button
                        type="submit"
                        name="change"
                        class="btn btn-danger btn-lg px-5">

                        <i class="bi bi-shield-check"></i>

                        Change Password

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
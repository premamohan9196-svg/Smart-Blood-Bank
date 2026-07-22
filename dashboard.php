<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include "config.php";

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* Dashboard Counts */

$totalUsers = $conn->query("SELECT COUNT(*) total FROM users")->fetch_assoc()['total'];

$totalDonors = $conn->query("SELECT COUNT(*) total FROM donors")->fetch_assoc()['total'];

$totalRequests = $conn->query("SELECT COUNT(*) total FROM blood_requests")->fetch_assoc()['total'];

$a = $conn->query("SELECT COUNT(*) total FROM donors WHERE blood_group='A+'")->fetch_assoc()['total'];

$b = $conn->query("SELECT COUNT(*) total FROM donors WHERE blood_group='B+'")->fetch_assoc()['total'];

$o = $conn->query("SELECT COUNT(*) total FROM donors WHERE blood_group='O+'")->fetch_assoc()['total'];

$ab = $conn->query("SELECT COUNT(*) total FROM donors WHERE blood_group='AB+'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>User Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="dashboard.css">

</head>

<body>

<!-- ================= TOPBAR ================= -->

<nav class="topbar">

<div class="container d-flex justify-content-between align-items-center">

<div class="logo">

🩸 Smart Blood Bank

</div>

<div class="d-flex align-items-center">

<img src="uploads/<?php echo !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : 'default.png'; ?>"
class="profile-img">

<div class="ms-3">

<h6 class="m-0 text-white">

<?php echo htmlspecialchars($user['fullname']); ?>

</h6>

<small class="text-light">

<?php echo htmlspecialchars($user['email']); ?>

</small>

</div>

<a href="logout.php" class="btn btn-light btn-sm ms-4">

<i class="bi bi-box-arrow-right"></i>

Logout

</a>

</div>

</div>

</nav>

<div class="container py-5">

<!-- ================= WELCOME CARD ================= -->

<div class="welcome-card">

<div class="row align-items-center">

<div class="col-lg-8">

<h2>

Welcome Back,
<?php echo htmlspecialchars($user['fullname']); ?> 👋

</h2>

<p>

Manage your profile, become a donor, search blood and save lives.

</p>

<div class="mt-4">

<a href="edit_profile.php"
class="btn btn-danger">

<i class="bi bi-pencil-square"></i>

Edit Profile

</a>

<a href="change_password.php"
class="btn btn-outline-dark ms-2">

<i class="bi bi-lock-fill"></i>

Change Password

</a>

</div>

</div>

<div class="col-lg-4 text-center">

<img src="uploads/<?php echo !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : 'default.png'; ?>"
class="welcome-img">

</div>

</div>

</div>

<!-- ================= OVERVIEW ================= -->

<div class="row mt-5 g-4">

<div class="col-md-4">

<div class="count-card">

<h6>Total Users</h6>

<h2 class="counter">

<?php echo $totalUsers; ?>

</h2>

</div>

</div>

<div class="col-md-4">

<div class="count-card">

<h6>Total Donors</h6>

<h2 class="counter">

<?php echo $totalDonors; ?>

</h2>

</div>

</div>

<div class="col-md-4">

<div class="count-card">

<h6>Blood Requests</h6>

<h2 class="counter">

<?php echo $totalRequests; ?>

</h2>

</div>

</div>

</div>

<!-- ================= PROFILE DETAILS ================= -->

<h3 class="mt-5 mb-4">
<i class="bi bi-person-circle text-danger"></i>
My Profile
</h3>

<div class="row g-4">

<div class="col-md-3">

<div class="info-card">

<i class="bi bi-envelope-fill icon"></i>

<h6>Email</h6>

<p>

<?php
echo !empty($user['email'])
? htmlspecialchars($user['email'])
: "Not Available";
?>

</p>

</div>

</div>

<div class="col-md-3">

<div class="info-card">

<i class="bi bi-telephone-fill icon"></i>

<h6>Phone</h6>

<p>

<?php
echo !empty($user['phone'])
? htmlspecialchars($user['phone'])
: "Not Updated";
?>

</p>

</div>

</div>

<div class="col-md-3">

<div class="info-card">

<i class="bi bi-geo-alt-fill icon"></i>

<h6>City</h6>

<p>

<?php
echo !empty($user['city'])
? htmlspecialchars($user['city'])
: "Not Updated";
?>

</p>

</div>

</div>

<div class="col-md-3">

<div class="info-card">

<i class="bi bi-heart-pulse-fill icon"></i>

<h6>Blood Group</h6>

<p>

<?php
echo !empty($user['blood_group'])
? htmlspecialchars($user['blood_group'])
: "Not Updated";
?>

</p>

</div>

</div>

</div>


<!-- ================= QUICK ACTIONS ================= -->

<h3 class="mt-5 mb-4">

<i class="bi bi-lightning-charge-fill text-danger"></i>

Quick Actions

</h3>

<div class="row g-4">

<div class="col-lg-4">

<a href="donor.php" class="action-card">

<i class="bi bi-heart-pulse-fill"></i>

<h4>Become Donor</h4>

<p>

Register yourself as a blood donor and help save lives.

</p>

</a>

</div>

<div class="col-lg-4">

<a href="search.php" class="action-card">

<i class="bi bi-search"></i>

<h4>Search Blood</h4>

<p>

Search blood donors based on blood group and city.

</p>

</a>

</div>

<div class="col-lg-4">

<a href="request.php" class="action-card">

<i class="bi bi-hospital-fill"></i>

<h4>Blood Request</h4>

<p>

Create an emergency blood request instantly.

</p>

</a>

</div>

</div>


<!-- ================= BLOOD GROUP COUNTS ================= -->

<h3 class="mt-5 mb-4">

<i class="bi bi-bar-chart-fill text-danger"></i>

Blood Availability

</h3>

<div class="row g-4">

<div class="col-md-3 col-6">

<div class="count-card">

<h5>🩸 A+</h5>

<h2 class="counter">

<?php echo $a; ?>

</h2>

</div>

</div>

<div class="col-md-3 col-6">

<div class="count-card">

<h5>🩸 B+</h5>

<h2 class="counter">

<?php echo $b; ?>

</h2>

</div>

</div>

<div class="col-md-3 col-6">

<div class="count-card">

<h5>🩸 O+</h5>

<h2 class="counter">

<?php echo $o; ?>

</h2>

</div>

</div>

<div class="col-md-3 col-6">

<div class="count-card">

<h5>🩸 AB+</h5>

<h2 class="counter">

<?php echo $ab; ?>

</h2>

</div>

</div>

</div>

<!-- ================= RECENT ACTIVITY ================= -->

<h3 class="mt-5 mb-4">
<i class="bi bi-clock-history text-danger"></i>
Recent Activity
</h3>

<div class="card shadow border-0 rounded-4">

<div class="card-body">

<ul class="list-group list-group-flush">

<li class="list-group-item">
✅ Welcome to Smart Blood Donation System
</li>

<li class="list-group-item">
👤 Profile Created Successfully
</li>

<li class="list-group-item">
🩸 Become a Blood Donor and Save Lives
</li>

<li class="list-group-item">
🔍 Search Blood Donors Anytime
</li>

<li class="list-group-item">
🏥 Send Emergency Blood Requests
</li>

</ul>

</div>

</div>

<!-- ================= HEALTH TIPS ================= -->

<h3 class="mt-5 mb-4">
<i class="bi bi-heart-pulse-fill text-danger"></i>
Health Tips
</h3>

<div class="row g-4">

<div class="col-md-4">

<div class="info-card">

<i class="bi bi-cup-hot-fill icon"></i>

<h5>Drink Water</h5>

<p>
Drink plenty of water before and after donating blood.
</p>

</div>

</div>

<div class="col-md-4">

<div class="info-card">

<i class="bi bi-egg-fried icon"></i>

<h5>Healthy Food</h5>

<p>
Eat iron-rich foods like spinach, eggs, fruits and vegetables.
</p>

</div>

</div>

<div class="col-md-4">

<div class="info-card">

<i class="bi bi-person-walking icon"></i>

<h5>Take Rest</h5>

<p>
Avoid heavy work and take proper rest after donating blood.
</p>

</div>

</div>

</div>

<!-- ================= EMERGENCY BANNER ================= -->

<div class="mt-5">

<div class="welcome-card text-center">

<h2>
🚑 Need Blood Urgently?
</h2>

<p class="mt-3">

Create an emergency blood request and reach nearby donors instantly.

</p>

<a href="request.php" class="btn btn-light btn-lg mt-3">

<i class="bi bi-hospital-fill"></i>

Request Blood

</a>

</div>

</div>

<div class="card shadow border-0 rounded-4 mt-5">

    <div class="card-body">

        <h4 class="mb-4">
            📊 Blood Availability Chart
        </h4>

        <div style="height:350px;">

            <canvas
                id="bloodChart"
                data-a="<?php echo $a; ?>"
                data-b="<?php echo $b; ?>"
                data-o="<?php echo $o; ?>"
                data-ab="<?php echo $ab; ?>">
            </canvas>

        </div>

    </div>

</div>
<!-- ================= LOGOUT ================= -->

<div class="text-center mt-5">

<a href="logout.php" class="btn btn-danger btn-lg">

<i class="bi bi-box-arrow-right"></i>

Logout

</a>

</div>

</div>

<!-- ================= FOOTER ================= -->

<footer class="text-center py-4 mt-5">

<hr>

<p class="text-muted mb-1">

© <?php echo date("Y"); ?> Smart Blood Donation Management System

</p>

<p class="text-muted">

Developed by <strong>Gopalakrishnan M</strong>

</p>



</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="dashboard.js"></script>

</body>
</html>
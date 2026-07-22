<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

/* ===========================
   BLOOD GROUP CHART DATA
=========================== */

$bloodChart = $conn->query("
SELECT blood_group, COUNT(*) AS total
FROM donors
GROUP BY blood_group
");

$labels = [];
$data = [];

while($chart = $bloodChart->fetch_assoc()){

    $labels[] = $chart['blood_group'];
    $data[] = $chart['total'];

}


/* ===========================
   DASHBOARD STATISTICS
=========================== */

$totalUsers = $conn->query("SELECT COUNT(*) total FROM users")->fetch_assoc()['total'];

$totalDonors = $conn->query("SELECT COUNT(*) total FROM donors")->fetch_assoc()['total'];

$totalRequests = $conn->query("SELECT COUNT(*) total FROM blood_requests")->fetch_assoc()['total'];

$totalApproved = $conn->query("SELECT COUNT(*) total FROM blood_requests WHERE status='Approved'")->fetch_assoc()['total'];

$totalPending = $conn->query("SELECT COUNT(*) total FROM blood_requests WHERE status='Pending'")->fetch_assoc()['total'];

$totalStock = $conn->query("SELECT SUM(units) total FROM blood_stock")->fetch_assoc()['total'];

$totalFeedback = $conn->query("SELECT COUNT(*) total FROM feedback")->fetch_assoc()['total'];

$totalMessages = $conn->query("SELECT COUNT(*) total FROM contact_messages")->fetch_assoc()['total'];

$totalCamps = $conn->query("SELECT COUNT(*) total FROM blood_camps")->fetch_assoc()['total'];

/* ===========================
   RECENT DONORS
=========================== */

$recentDonors = $conn->query("
SELECT users.fullname,
       donors.blood_group,
       donors.last_donation
FROM donors
INNER JOIN users
ON donors.user_id = users.id
ORDER BY donors.donor_id DESC
LIMIT 5
");

/* ===========================
   LOW STOCK
=========================== */

$lowStock = $conn->query("
SELECT *
FROM blood_stock
WHERE units<=5
ORDER BY units ASC
");

/* ===========================
   RECENT REQUESTS
=========================== */

$recentRequests = $conn->query("
SELECT patient_name,blood_group,status
FROM blood_requests
ORDER BY request_id DESC
LIMIT 5
");
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="style.css">

</head>

<body>

<?php include "sidebar.php"; ?>

<?php include "header.php"; ?>

<div class="main-content">

<div class="header">
🩸 Smart Blood Donation Management System
</div>

<div class="container">

<div class="text-center mb-4">
<h4>Welcome Admin 👋</h4>
<p><?php echo date("d-m-Y h:i A"); ?></p>
</div>


<?php

$low = $conn->query("
SELECT COUNT(*) AS total
FROM blood_stock
WHERE units <= 5
");

$lowCount = $low->fetch_assoc()['total'];

if($lowCount > 0){
?>

<div class="alert alert-danger text-center shadow mb-4">

<b>⚠ Warning!</b>

<?php echo $lowCount; ?> Blood Group(s) are running Low on Stock.

</div>

<?php
}
?>

<!-- ================= DASHBOARD CARDS ================= -->

<div class="row g-4">

<div class="col-md-3">
<div class="card bg-blue">
<div class="card-body">
<h5>👥 Users</h5>
<h2 class="counter"><?php echo $totalUsers; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-green">
<div class="card-body">
<h5>🩸 Donors</h5>
<h2 class="counter"><?php echo $totalDonors; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-red">
<div class="card-body">
<h5>📋 Requests</h5>
<h2 class="counter"><?php echo $totalRequests; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-orange">
<div class="card-body">
<h5>🩸 Blood Units</h5>
<h2 class="counter"><?php echo $totalStock; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-success">
<div class="card-body">
<h5>✅ Approved</h5>
<h2 class="counter"><?php echo $totalApproved; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-warning text-dark">
<div class="card-body">
<h5>⏳ Pending</h5>
<h2 class="counter"><?php echo $totalPending; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-purple">
<div class="card-body">
<h5>🏥 Blood Camps</h5>
<h2 class="counter"><?php echo $totalCamps; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card bg-pink">
<div class="card-body">
<h5>⭐ Feedback</h5>
<h2 class="counter"><?php echo $totalFeedback; ?></h2>
</div>
</div>
</div>

<div class="col-md-12">
<div class="card bg-darkblue">
<div class="card-body">
<h5>💬 Contact Messages</h5>
<h2 class="counter"><?php echo $totalMessages; ?></h2>
</div>
</div>
</div>

</div>

<div class="row mt-5">

<div class="col-lg-6">

<div class="card">

<div class="card-header bg-danger text-white">
🩸 Blood Group Distribution
</div>

<div class="card-body">

<canvas id="bloodChart"></canvas>

</div>

</div>

</div>

<div class="col-lg-6">

<div class="card">

<div class="card-header bg-primary text-white">
📈 Monthly Donations
</div>

<div class="card-body">

<canvas id="donationChart"></canvas>

</div>

</div>

</div>

</div>

<div class="row mt-5">

<div class="col-lg-12">

<div class="card">

<div class="card-header bg-success text-white">
🩸 Recent Blood Donors
</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead>

<tr>
<th>Name</th>
<th>Blood Group</th>
<th>Last Donation</th>
</tr>

</thead>

<tbody>

<?php while($donor = $recentDonors->fetch_assoc()){ ?>

<tr>

<td><?php echo $donor['fullname']; ?></td>

<td>
<span class="badge bg-danger">
<?php echo $donor['blood_group']; ?>
</span>
</td>

<td><?php echo $donor['last_donation']; ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<!-- ================= QUICK ACTION ================= -->


<!-- ================= LOW STOCK ================= -->

<div class="row mt-5">

<div class="col-md-6">

<div class="card bg-dark">

<div class="card-header bg-danger text-center">

🩸 Low Blood Stock Alert

</div>

<div class="card-body">

<table class="table table-bordered table-dark">

<tr>

<th>Blood Group</th>

<th>Units</th>

</tr>

<?php
if($lowStock->num_rows>0){

while($row=$lowStock->fetch_assoc()){
?>

<tr>

<td><?php echo $row['blood_group']; ?></td>

<td>

<span class="badge bg-danger">

<?php echo $row['units']; ?> Units

</span>

</td>

</tr>

<?php
}

}else{

echo "<tr>

<td colspan='2' class='text-center text-success'>

✅ No Low Stock

</td>

</tr>";

}
?>

</table>

</div>

</div>

</div>

<!-- ================= RECENT REQUESTS ================= -->

<div class="col-md-6">

<div class="card bg-dark">

<div class="card-header bg-primary text-center">

📋 Recent Blood Requests

</div>

<div class="card-body">

<table class="table table-bordered table-dark">

<tr>

<th>Patient</th>

<th>Blood</th>

<th>Status</th>

</tr>

<?php

while($req=$recentRequests->fetch_assoc()){

?>

<tr>

<td><?php echo $req['patient_name']; ?></td>

<td><?php echo $req['blood_group']; ?></td>

<td>

<?php

if($req['status']=="Approved"){

echo "<span class='badge bg-success'>Approved</span>";

}else{

echo "<span class='badge bg-warning text-dark'>Pending</span>";

}

?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</div>

<!-- ================= FOOTER ================= -->

<footer>

<hr style="border-color:#475569;">

<h5 style="color:#dc3545;">

🩸 Smart Blood Donation Management System

</h5>

<p>

Admin Panel - Blood Bank Management

</p>

<p>

© 2026 All Rights Reserved

</p>

<p>

Developed by <b>Gopalakrishnan M</b>

</p>

</footer>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// Blood Group Chart

const ctx = document.getElementById('bloodChart');

new Chart(ctx,{

type:'doughnut',

data:{

labels:<?php echo json_encode($labels); ?>,

datasets:[{

data:<?php echo json_encode($data); ?>,

backgroundColor:[
'#dc3545',
'#2563eb',
'#16a34a',
'#f59e0b',
'#7c3aed',
'#ec4899',
'#0ea5e9',
'#64748b'
]

}]

},

options:{
responsive:true,
plugins:{
legend:{
position:'bottom'
}
}

}

});

// Monthly Chart

const ctx2=document.getElementById('donationChart');

new Chart(ctx2,{

type:'bar',

data:{

labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],

datasets:[{

label:'Donations',

data:[5,8,10,12,15,18,20,16,14,12,10,8],

backgroundColor:'#dc3545'

}]

},

options:{
responsive:true
}

});

// Counter Animation

const counters=document.querySelectorAll('.counter');

counters.forEach(counter=>{

const updateCounter=()=>{

const target=parseInt(counter.dataset.target||counter.textContent);

const current=parseInt(counter.textContent);

const increment=Math.ceil(target/50);

if(current<target){

counter.textContent=Math.min(current+increment,target);

setTimeout(updateCounter,20);

}

};

counter.dataset.target=counter.textContent;

counter.textContent="0";

updateCounter();

});

</script>
</body>

</html>
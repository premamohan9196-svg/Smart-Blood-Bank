<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reports</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0f172a;
    font-family:'Segoe UI',sans-serif;
}

.card{
    margin-top:60px;
    border:none;
    border-radius:18px;
    background:#1e293b;
    box-shadow:0 12px 25px rgba(0,0,0,.4);
}

.card-header{
    background:#dc3545;
    color:#fff;
    font-size:28px;
    font-weight:bold;
    text-align:center;
    border-radius:18px 18px 0 0 !important;
    padding:18px;
}

.card-body{
    padding:35px;
}

label{
    color:#fff;
    font-weight:600;
    margin-bottom:8px;
}

.form-select{
    height:55px;
    border-radius:10px;
    border:1px solid #ced4da;
}

.form-select:focus{
    border-color:#dc3545;
    box-shadow:0 0 10px rgba(220,53,69,.4);
}

.btn-report{
    width:100%;
    padding:14px;
    background:#dc3545;
    color:#fff;
    border:none;
    border-radius:10px;
    font-size:18px;
    font-weight:bold;
    transition:.3s;
}

.btn-report:hover{
    background:#b91c1c;
    transform:translateY(-3px);
}

.btn-back{
    display:block;
    width:100%;
    margin-top:15px;
    padding:12px;
    text-align:center;
    background:#0d6efd;
    color:white;
    text-decoration:none;
    border-radius:10px;
    transition:.3s;
}

.btn-back:hover{
    background:#0b5ed7;
    color:white;
}

footer{
    text-align:center;
    color:#cbd5e1;
    margin-top:30px;
    padding:20px;
}

</style>

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-6">

<div class="card">

<div class="card-header">
📄 Download PDF Reports
</div>

<div class="card-body">

<form action="report.php" method="GET">

<div class="mb-4">

<label>Select Report</label>

<select name="type" class="form-select" required>

<option value="">-- Select Report --</option>

<option value="users">👥 Users Report</option>

<option value="donors">🩸 Donors Report</option>

<option value="requests">📋 Blood Requests Report</option>

<option value="stock">🩸 Blood Stock Report</option>

<option value="camps">🏕 Blood Camps Report</option>

<option value="feedback">⭐ Feedback Report</option>

</select>

</div>

<button type="submit" class="btn-report">
📄 Generate PDF Report
</button>

<a href="dashboard.php" class="btn-back">
⬅ Back to Dashboard
</a>

</form>

</div>

</div>

<footer>

© 2026 Smart Blood Donation Management System <br>
Developed by <b>Gopalakrishnan M</b>

</footer>

</div>

</div>

</div>

</body>
</html>
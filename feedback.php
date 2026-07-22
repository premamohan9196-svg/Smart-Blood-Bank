<?php
session_start();
include "config.php";

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$user = $conn->query("SELECT fullname FROM users WHERE email='$email'");
$data = $user->fetch_assoc();

$fullname = $data['fullname'];

if(isset($_POST['submit'])){

    $rating = $_POST['rating'];
    $message = $_POST['message'];

    $sql = "INSERT INTO feedback(fullname,email,rating,message)
            VALUES('$fullname','$email','$rating','$message')";

    if($conn->query($sql)){
        echo "<script>alert('Thank you for your Feedback!');</script>";
    }else{
        echo "<script>alert('Error');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

   <style>
body{
    background:linear-gradient(135deg,#8B0000,#b30000,#3b0a18);
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
}

.box{
    max-width:650px;
    margin:60px auto;
    background:#1e293b;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 20px 45px rgba(0,0,0,.45);
}

.box-header{
    background:#dc3545;
    color:#fff;
    text-align:center;
    padding:20px;
    font-size:30px;
    font-weight:bold;
}

.box-body{
    padding:30px;
}

label{
    color:#fff;
    font-weight:600;
    margin-bottom:6px;
}

.form-control,
.form-select,
textarea{
    background:#111827;
    color:#fff;
    border:1px solid #555;
}

.form-control:focus,
.form-select:focus,
textarea:focus{
    background:#111827;
    color:#fff;
    border-color:#dc3545;
    box-shadow:0 0 10px rgba(220,53,69,.4);
}

.form-control::placeholder{
    color:#bbb;
}

.btn-submit{
    width:100%;
    background:#dc3545;
    color:#fff;
    font-weight:bold;
    padding:12px;
    border:none;
    border-radius:10px;
    transition:.3s;
}

.btn-submit:hover{
    background:#b91c1c;
    transform:translateY(-2px);
}

.btn-back{
    display:inline-block;
    background:#0d6efd;
    color:#fff;
    padding:10px 25px;
    text-decoration:none;
    border-radius:10px;
    transition:.3s;
}

.btn-back:hover{
    background:#0b5ed7;
    color:#fff;
}

footer{
    text-align:center;
    color:#fff;
    margin-top:25px;
}
</style>
</head>

<body>


<div class="container">

<div class="box">

<div class="box-header">
⭐ Feedback Form
</div>

<div class="box-body">

<form method="POST">

<div class="mb-3">
<label>👤 Name</label>
<input type="text"
class="form-control"
value="<?php echo $fullname; ?>"
readonly>
</div>

<div class="mb-3">
<label>📧 Email</label>
<input type="email"
class="form-control"
value="<?php echo $email; ?>"
readonly>
</div>

<div class="mb-3">
<label>⭐ Rating</label>

<select name="rating" class="form-select" required>
<option value="">Select Rating</option>
<option value="5">⭐⭐⭐⭐⭐ Excellent</option>
<option value="4">⭐⭐⭐⭐ Good</option>
<option value="3">⭐⭐⭐ Average</option>
<option value="2">⭐⭐ Poor</option>
<option value="1">⭐ Very Poor</option>
</select>

</div>

<div class="mb-3">
<label>💬 Your Feedback</label>

<textarea
name="message"
class="form-control"
rows="5"
placeholder="Write your feedback here..."
required></textarea>

</div>

<button
type="submit"
name="submit"
class="btn-submit">
⭐ Submit Feedback
</button>

<div class="text-center mt-3">
<a href="dashboard.php" class="btn-back">
⬅ Back to Dashboard
</a>
</div>

</form>

</div>

</div>

<footer>
© 2026 Smart Blood Donation Management System
</footer>

</div>

</body>
</html>
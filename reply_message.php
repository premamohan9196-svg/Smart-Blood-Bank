<?php
session_start();
include "../config.php";
include "../send_email.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM contact_messages WHERE id='$id'");
$row = $result->fetch_assoc();

if(isset($_POST['reply'])){

    $email = $row['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if(sendReplyEmail($email,$subject,$message)){
        echo "<script>alert('Reply Sent Successfully');window.location='messages.php';</script>";
    }else{
        echo "<script>alert('Email Sending Failed');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Reply Message</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f5f5f5;
}

.box{
    width:600px;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 0 15px gray;
}
</style>

</head>

<body>

<div class="box">

<h2 class="text-center text-danger">📧 Reply to User</h2>

<form method="POST">

<div class="mb-3">
<label>Email</label>
<input type="email" class="form-control"
value="<?php echo $row['email']; ?>" readonly>
</div>

<div class="mb-3">
<label>Subject</label>
<input type="text"
name="subject"
class="form-control"
placeholder="Enter Subject"
required>
</div>

<div class="mb-3">
<label>Reply Message</label>
<textarea
name="message"
class="form-control"
rows="6"
placeholder="Type your reply..."
required></textarea>
</div>

<button type="submit"
name="reply"
class="btn btn-success">
Send Reply
</button>

<a href="messages.php"
class="btn btn-secondary">
Back
</a>

</form>

</div>

</body>
</html>
<?php
session_start();
include "../config.php";
include "../send_email.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // Get request details
    $result = $conn->query("SELECT * FROM blood_requests WHERE request_id='$id'");
    $row = $result->fetch_assoc();

    $email = $row['email'];
    $patientName = $row['patient_name'];

    // Reject request
    $conn->query("UPDATE blood_requests SET status='Rejected' WHERE request_id='$id'");

    // Send Reject Email
    if(sendRejectEmail($email, $patientName)){
        echo "<script>
        alert('Request Rejected & Email Sent Successfully!');
        window.location='requests.php';
        </script>";
    }else{
        echo "<script>
        alert('Request Rejected, but Email could not be sent!');
        window.location='requests.php';
        </script>";
    }

    exit();
}
?>
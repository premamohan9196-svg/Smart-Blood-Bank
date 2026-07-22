<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // Get donor details
    $sql = $conn->query("
    SELECT *
    FROM donors
    WHERE donor_id='$id'
    ");

    $row = $sql->fetch_assoc();

    if($row['status']=="Approved"){
        echo "<script>
        alert('Donor already approved!');
        window.location='donors.php';
        </script>";
        exit();
    }

    $bloodGroup = $row['blood_group'];

    // Increase blood stock
    $conn->query("
    UPDATE blood_stock
    SET units = units + 1
    WHERE blood_group='$bloodGroup'
    ");

    // Update donor status
    $conn->query("
    UPDATE donors
    SET status='Approved'
    WHERE donor_id='$id'
    ");

    echo "<script>
    alert('✅ Donor Approved Successfully');
    window.location='donors.php';
    </script>";
    exit();
}

header("Location: donors.php");
exit();
?>
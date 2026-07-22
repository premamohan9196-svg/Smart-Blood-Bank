<?php
session_start();
include "../config.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $conn->query("UPDATE blood_requests SET status='Approved' WHERE request_id='$id'");

}

header("Location: requests.php");
exit();
?>
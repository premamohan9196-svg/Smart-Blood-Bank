<?php
include "../config.php";

$id = $_GET['id'];

$conn->query("DELETE FROM donors WHERE donor_id='$id'");

header("Location: donors.php");
exit();
?>
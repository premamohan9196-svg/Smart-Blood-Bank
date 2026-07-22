<?php
require('../fpdf/fpdf.php');
include("../config.php");

$type = $_GET['type'] ?? 'requests';
$search = $_GET['search'] ?? "";
$blood_group = $_GET['blood_group'] ?? "";
$status = $_GET['status'] ?? "";
$from_date = $_GET['from_date'] ?? "";
$to_date = $_GET['to_date'] ?? "";

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,'Smart Blood Donation Management System',0,1,'C');

$pdf->SetFont('Arial','B',14);

switch($type){

case "users":

$pdf->Cell(190,10,"Users Report",0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,10,"S.No",1);
$pdf->Cell(20,10,"ID",1);
$pdf->Cell(55,10,"Name",1);
$pdf->Cell(60,10,"Email",1);
$pdf->Cell(40,10,"Phone",1);

$pdf->Ln();

$pdf->SetFont('Arial','',9);

$result=$conn->query("SELECT * FROM users");

$sn=1;

while($row=$result->fetch_assoc()){

$pdf->Cell(15,10,$sn++,1);
$pdf->Cell(20,10,$row['id'],1);
$pdf->Cell(55,10,$row['fullname'],1);
$pdf->Cell(60,10,$row['email'],1);
$pdf->Cell(40,10,$row['phone'],1);

$pdf->Ln();

}

$pdf->Output();
exit();

case "donors":

$pdf->Cell(190,10,"Donors Report",0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,10,"S.No",1);
$pdf->Cell(20,10,"ID",1);
$pdf->Cell(45,10,"Name",1);
$pdf->Cell(25,10,"Blood",1);
$pdf->Cell(15,10,"Age",1);
$pdf->Cell(20,10,"Gender",1);
$pdf->Cell(25,10,"City",1);
$pdf->Cell(25,10,"Last Donation",1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);

$result = $conn->query("
SELECT donors.*, users.fullname
FROM donors
LEFT JOIN users
ON donors.user_id = users.id
");
$sn=1;

while($row=$result->fetch_assoc()){

$pdf->Cell(15,10,$sn++,1);
$pdf->Cell(20,10,$row['donor_id'],1);
$pdf->Cell(45,10,$row['fullname'],1);
$pdf->Cell(25,10,$row['blood_group'],1);
$pdf->Cell(15,10,$row['age'],1);
$pdf->Cell(20,10,$row['gender'],1);
$pdf->Cell(25,10,$row['city'],1);
$pdf->Cell(25,10,$row['last_donation'],1);

$pdf->Ln();

}

$pdf->Output();
exit();

case "stock":

$pdf->Cell(190,10,"Blood Stock Report",0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(20,10,"S.No",1);
$pdf->Cell(70,10,"Blood Group",1);
$pdf->Cell(70,10,"Units",1);

$pdf->Ln();

$pdf->SetFont('Arial','',10);

$result=$conn->query("SELECT * FROM blood_stock");

$sn=1;

while($row=$result->fetch_assoc()){

$pdf->Cell(20,10,$sn++,1);
$pdf->Cell(70,10,$row['blood_group'],1);
$pdf->Cell(70,10,$row['units'],1);

$pdf->Ln();

}

$pdf->Output();
exit();

case "camps":

$pdf->Cell(190,10,"Blood Camps Report",0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,10,"S.No",1);
$pdf->Cell(45,10,"Camp Name",1);
$pdf->Cell(30,10,"Date",1);
$pdf->Cell(25,10,"Time",1);
$pdf->Cell(75,10,"Location",1);

$pdf->Ln();

$pdf->SetFont('Arial','',8);

$result = $conn->query("SELECT * FROM blood_camps");

$sn=1;

while($row=$result->fetch_assoc()){

$pdf->Cell(15,10,$sn++,1);
$pdf->Cell(45,10,$row['camp_name'],1);
$pdf->Cell(30,10,$row['camp_date'],1);
$pdf->Cell(25,10,$row['camp_time'],1);
$pdf->Cell(75,10,$row['location'],1);

$pdf->Ln();

}

$pdf->Output();
exit();


case "feedback":

$pdf->Cell(190,10,"Feedback Report",0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,10,"S.No",1);
$pdf->Cell(20,10,"ID",1);
$pdf->Cell(45,10,"Name",1);
$pdf->Cell(80,10,"Feedback",1);
$pdf->Cell(30,10,"Rating",1);

$pdf->Ln();

$pdf->SetFont('Arial','',8);

$result = $conn->query("SELECT * FROM feedback");

$sn = 1;

while($row = $result->fetch_assoc()){

    $pdf->Cell(15,10,$sn++,1);
    $pdf->Cell(20,10,$row['id'],1);
    $pdf->Cell(45,10,$row['fullname'],1);
    $pdf->Cell(80,10,substr($row['message'],0,40),1);
    $pdf->Cell(30,10,$row['rating'],1);

    $pdf->Ln();
}

$pdf->Output();
exit();


default:

$pdf->Cell(190,10,"Blood Requests Report",0,1,'C');

$pdf->Ln(5);

$total=$conn->query("SELECT COUNT(*) total FROM blood_requests")->fetch_assoc()['total'];
$approved=$conn->query("SELECT COUNT(*) total FROM blood_requests WHERE status='Approved'")->fetch_assoc()['total'];
$pending=$conn->query("SELECT COUNT(*) total FROM blood_requests WHERE status='Pending'")->fetch_assoc()['total'];
$rejected=$conn->query("SELECT COUNT(*) total FROM blood_requests WHERE status='Rejected'")->fetch_assoc()['total'];

$pdf->SetFont('Arial','B',11);

$pdf->Cell(190,8,"Total Requests : $total",0,1);
$pdf->Cell(190,8,"Approved : $approved",0,1);
$pdf->Cell(190,8,"Pending : $pending",0,1);
$pdf->Cell(190,8,"Rejected : $rejected",0,1);

$pdf->Ln(5);

$pdf->SetFont('Arial','B',9);

$pdf->Cell(15,10,"S.No",1);
$pdf->Cell(18,10,"ID",1);
$pdf->Cell(35,10,"Patient",1);
$pdf->Cell(18,10,"Blood",1);
$pdf->Cell(15,10,"Units",1);
$pdf->Cell(40,10,"Hospital",1);
$pdf->Cell(20,10,"City",1);
$pdf->Cell(29,10,"Status",1);

$pdf->Ln();

$sql="SELECT * FROM blood_requests WHERE 1=1";

if($search!=""){
$sql.=" AND patient_name LIKE '%$search%'";
}

if($blood_group!=""){
$sql.=" AND blood_group='$blood_group'";
}

if($status!=""){
$sql.=" AND status='$status'";
}

if($from_date!="" && $to_date!=""){
$sql.=" AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'";
}

$result=$conn->query($sql);

$pdf->SetFont('Arial','',8);

$sn=1;

while($row=$result->fetch_assoc()){

$pdf->Cell(15,10,$sn++,1);
$pdf->Cell(18,10,$row['request_id'],1);
$pdf->Cell(35,10,$row['patient_name'],1);
$pdf->Cell(18,10,$row['blood_group'],1);
$pdf->Cell(15,10,$row['units'],1);
$pdf->Cell(40,10,$row['hospital'],1);
$pdf->Cell(20,10,$row['city'],1);
$pdf->Cell(29,10,$row['status'],1);

$pdf->Ln();

}

$pdf->Output();
exit();

}
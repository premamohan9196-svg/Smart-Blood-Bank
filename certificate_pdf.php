<?php
session_start();
include "config.php";
require("fpdf/fpdf.php");

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$sql = $conn->query("
SELECT users.fullname,
       donors.user_id,
       donors.blood_group,
       donors.last_donation,
       donors.certificate_id
FROM donors
INNER JOIN users
ON donors.user_id = users.id
WHERE users.email='$email'
");

$data = $sql->fetch_assoc();
if(empty($data['certificate_id'])){

    $certificateId = "CERT-".date("Y")."-".str_pad(rand(1,9999),4,"0",STR_PAD_LEFT);

    $conn->query("
    UPDATE donors
    SET certificate_id='$certificateId'
    WHERE user_id=".$data['user_id']);

}else{

    $certificateId = $data['certificate_id'];

}
if(!$data){
    die("No donor record found.");
}

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

/* ================= BORDER ================= */

$pdf->SetDrawColor(220,53,69);
$pdf->SetLineWidth(2);
$pdf->Rect(10,10,277,190);

$pdf->SetLineWidth(0.5);
$pdf->Rect(15,15,267,180);

/* ================= WATERMARK ================= */

$pdf->SetFont('Arial','B',50);
$pdf->SetTextColor(245,245,245);
$pdf->Text(100,110,"BLOOD DONOR");

/* ================= LOGO ================= */

$pdf->Image("images/image.png",132,16,16);

/* ================= TITLE ================= */

$pdf->SetY(35);

$pdf->SetTextColor(220,53,69);

$pdf->SetFont('Arial','B',21);
$pdf->Cell(0,10,"SMART BLOOD DONATION MANAGEMENT SYSTEM",0,1,'C');

$pdf->SetFont('Arial','B',17);
$pdf->Cell(0,10,"CERTIFICATE OF APPRECIATION",0,1,'C');

$pdf->Ln(8);

/* ================= CONTENT ================= */

$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Arial','',16);
$pdf->Cell(0,10,"This Certificate is Proudly Presented To",0,1,'C');

$pdf->Ln(4);

$pdf->SetFont('Arial','B',28);
$pdf->Cell(0,14,$data['fullname'],0,1,'C');

$pdf->Ln(2);

$pdf->SetFont('Arial','I',14);
$pdf->SetTextColor(180,0,0);
$pdf->Cell(0,8,'"Every Drop Counts... Thank You For Saving Lives!"',0,1,'C');

$pdf->Ln(5);

$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Arial','',15);
$pdf->Cell(0,10,
'For the noble act of voluntarily donating blood and helping save lives.',
0,1,'C');

$pdf->Ln(10);

/* ================= DETAILS ================= */

$pdf->Ln(8);

$pdf->SetFont('Arial','B',14);

$pdf->Cell(90,8,"Blood Group : ".$data['blood_group'],1,0,'L');

$pdf->Cell(90,10,"Donation Date : ".$data['last_donation'],0,0,'C');

$pdf->Cell(90,10,"ID : ".$certificateId,0,1,'R');

$pdf->Cell(90,8,"Generated : ".date("d-m-Y"),0,1,'C');

/* ================= SIGNATURE ================= */

$pdf->SetY(160);

$pdf->Cell(90,10,"__________________",0,0,'C');

$pdf->Cell(95,10,"",0,0);

$pdf->Cell(90,10,"__________________",0,1,'C');

$pdf->Cell(90,8,"Donor Signature",0,0,'C');

$pdf->Cell(95,8,"",0,0);

$pdf->Cell(90,8,"Authorized Signature",0,1,'C');

/* ================= FOOTER ================= */

$pdf->SetY(175);

$pdf->SetFont('Arial','I',11);

$pdf->SetTextColor(120,120,120);

$pdf->Cell(0,8,"Thank you for saving lives through your generous blood donation.",0,1,'C');

/* ================= OUTPUT ================= */

$pdf->Output("D","Blood_Donation_Certificate.pdf");

?>
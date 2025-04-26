<?php
require_once('vendor/autoload.php');
include 'config/db.php';

use TCPDF;

$payroll_id = $_GET['id'];

$database = new Database();
$db = $database->connect();

$query = "SELECT * FROM payroll WHERE id = :payroll_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':payroll_id', $payroll_id);
$stmt->execute();
$payroll = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$payroll) {
    echo "Payroll record not found.";
    exit();
}

$user_id = $payroll['user_id'];
$query = "SELECT * FROM users WHERE id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Create new PDF instance
$pdf = new TCPDF();
$pdf->AddPage();

// Set document title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Payslip', 0, 1, 'C');

// Employee information
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Employee Name: ' . $user['first_name'] . ' ' . $user['last_name'], 0, 1);
$pdf->Cell(0, 10, 'Position: ' . $user['position'], 0, 1);
$pdf->Cell(0, 10, 'Pay Period: ' . $payroll['pay_period'], 0, 1);

// Payroll details
$pdf->Cell(0, 10, 'Hours Worked: ' . $payroll['hours_worked'], 0, 1);
$pdf->Cell(0, 10, 'Hourly Rate: $' . $payroll['hourly_rate'], 0, 1);
$pdf->Cell(0, 10, 'Total Pay: $' . $payroll['total_pay'], 0, 1);

// Output the PDF
$pdf->Output('payslip_' . $payroll_id . '.pdf', 'D'); // 'D' for download
?>

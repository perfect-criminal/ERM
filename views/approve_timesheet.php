<?php
session_start();
include 'config/db.php';
include 'models/Timesheet.php';
include 'models/User.php';
include 'models/Payroll.php';

if (!isset($_GET['id'])) {
    echo "No timesheet selected.";
    exit();
}

$timesheet_id = $_GET['id'];
$database = new Database();
$db = $database->connect();

// Initialize Timesheet and Payroll models
$timesheet = new Timesheet($db);
$user = new User($db);
$payroll = new Payroll($db);

// Get timesheet and user data
$timesheet->id = $timesheet_id;
$timesheet_data = $timesheet->getTimesheetById();
$user->id = $timesheet_data['user_id'];
$user_data = $user->getUserData();

// Payroll Calculation
$hours_worked = $timesheet_data['hours_worked'];
$hourly_rate = $user_data['hourly_rate'];  // Assuming hourly rate is stored in user profile
$total_pay = $hours_worked * $hourly_rate;

// Create payroll record
$payroll->user_id = $user_data['id'];
$payroll->pay_period = date('Y-m', strtotime($timesheet_data['created_at']));
$payroll->hours_worked = $hours_worked;
$payroll->hourly_rate = $hourly_rate;
$payroll->total_pay = $total_pay;

if ($timesheet->approve() && $payroll->create()) {
    echo "Timesheet approved and payroll recorded successfully!";
    header('Location: supervisor_dashboard.php');
} else {
    echo "Failed to approve timesheet or record payroll.";
}
?>

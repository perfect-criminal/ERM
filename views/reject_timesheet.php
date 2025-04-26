<?php
session_start();
include 'config/db.php';
include 'models/Timesheet.php';

if (!isset($_GET['id'])) {
    echo "No timesheet selected.";
    exit();
}

$timesheet_id = $_GET['id'];
$database = new Database();
$db = $database->connect();
$timesheet = new Timesheet($db);

$timesheet->id = $timesheet_id;
if ($timesheet->reject()) {
    echo "Timesheet rejected successfully!";
    header('Location: supervisor_dashboard.php');
} else {
    echo "Failed to reject timesheet.";
}
?>

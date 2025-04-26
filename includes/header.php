<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Include DB connection and User model
include 'config/db.php';
include 'models/User.php';

$database = new Database();
$db = $database->connect();
$user = new User($db);
$user->id = $_SESSION['user_id'];

// Fetch user data
$user->getUserData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<header>
    <h1>Welcome, <?php echo $user->name; ?></h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="submit_timesheet.php">Submit Timesheet</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/../../config/db.php';

$database = new Database();
$db = $database->connect();

// Fetch user's timesheets
$user_id = $_SESSION['user_id'];
$query = "SELECT t.id, j.title AS job_title, t.hours_worked, t.status, t.submitted_at, t.supervisor_comment 
          FROM timesheets t
          JOIN jobs j ON t.job_id = j.id
          WHERE t.user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch available jobs for timesheet submission
$query_jobs = "SELECT id, title FROM jobs WHERE id NOT IN (SELECT job_id FROM timesheets WHERE user_id = :user_id)";
$stmt_jobs = $db->prepare($query_jobs);
$stmt_jobs->bindParam(':user_id', $user_id);
$stmt_jobs->execute();
$jobs = $stmt_jobs->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <!-- Add your CSS here -->
</head>
<body>
<h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>

<!-- Timesheet Submission Form -->
<h2>Submit a New Timesheet</h2>
<form action="submit_timesheet.php" method="POST">
    <label for="job_id">Job</label>
    <select name="job_id" id="job_id" required>
        <?php foreach ($jobs as $job): ?>
            <option value="<?php echo $job['id']; ?>"><?php echo $job['title']; ?></option>
        <?php endforeach; ?>
    </select>
    <label for="hours_worked">Hours Worked</label>
    <input type="number" name="hours_worked" id="hours_worked" required min="0" step="0.01">
    <button type="submit">Submit</button>
</form>

<!-- Timesheet Report -->
<h2>Your Timesheet Report</h2>
<table>
    <tr>
        <th>Job Title</th>
        <th>Hours Worked</th>
        <th>Status</th>
        <th>Submitted At</th>
        <th>Supervisor Comment</th>
    </tr>
    <?php foreach ($timesheets as $timesheet): ?>
        <tr>
            <td><?php echo $timesheet['job_title']; ?></td>
            <td><?php echo $timesheet['hours_worked']; ?></td>
            <td><?php echo $timesheet['status']; ?></td>
            <td><?php echo $timesheet['submitted_at']; ?></td>
            <td><?php echo $timesheet['supervisor_comment']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Balance Calculation Form -->
<h2>Unpaid Timesheet Balance</h2>
<form action="calculate_balance.php" method="POST">
    <label for="start_date">Start Date</label>
    <input type="date" name="start_date" id="start_date">
    <label for="end_date">End Date</label>
    <input type="date" name="end_date" id="end_date">
    <label for="job_filter">Job</label>
    <select name="job_filter" id="job_filter">
        <option value="">All Jobs</option>
        <?php foreach ($jobs as $job): ?>
            <option value="<?php echo $job['id']; ?>"><?php echo $job['title']; ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Calculate</button>
</form>
</body>
</html>

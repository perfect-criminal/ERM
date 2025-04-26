<?php
session_start();
if ($_SESSION['role'] !== 'employee') {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';

$database = new Database();
$db = $database->connect();

// Fetch submitted timesheets for the logged-in user
$stmt = $db->prepare("SELECT * FROM timesheets WHERE user_id = :user_id ORDER BY submitted_at DESC");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h2>My Timesheets</h2>

<form method="GET" action="">
    <label for="filter_date">Filter by Date (optional):</label><br>
    <input type="date" id="filter_date" name="filter_date"><br><br>

    <input type="submit" value="Filter">
</form>

<table border="1">
    <thead>
    <tr>
        <th>Date Submitted</th>
        <th>Job</th>
        <th>Hours Worked</th>
        <th>Status</th>
        <th>Comments</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($timesheets as $timesheet): ?>
        <tr>
            <td><?= htmlspecialchars($timesheet['submitted_at']) ?></td>
            <td><?= $timesheet['job_id'] ? 'Job #' . $timesheet['job_id'] : 'Unscheduled' ?></td>
            <td><?= htmlspecialchars($timesheet['hours_worked']) ?></td>
            <td><?= htmlspecialchars($timesheet['status']) ?></td>
            <td><?= htmlspecialchars($timesheet['supervisor_comment']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

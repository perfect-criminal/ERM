<?php
session_start();
include 'config/db.php';
include 'models/Timesheet.php';

if (isset($_POST['submit_timesheet'])) {
    $user_id = $_SESSION['user_id']; // From session
    $job_id = $_POST['job_id'];
    $hours = $_POST['hours'];

    $database = new Database();
    $db = $database->connect();
    $timesheet = new Timesheet($db);

    $timesheet->user_id = $user_id;
    $timesheet->job_id = $job_id;
    $timesheet->hours_worked = $hours;
    $timesheet->status = 'submitted'; // Initial status

    if ($timesheet->submit()) {
        echo "Timesheet submitted successfully!";
    } else {
        echo "Failed to submit timesheet.";
    }
}
?>

<form action="submit_timesheet.php" method="post">
    <input type="number" name="job_id" placeholder="Job ID" required><br>
    <input type="number" name="hours" placeholder="Hours Worked" required><br>
    <button type="submit" name="submit_timesheet">Submit Timesheet</button>
</form>

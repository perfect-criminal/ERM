<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

$database = new Database();
$db = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = $_POST['job_id'] ?? null;
    $hoursWorked = $_POST['hours_worked'] ?? null;
    $comment = $_POST['comment'] ?? '';
    $date = $_POST['date'] ?? date('Y-m-d');

    if ($hoursWorked && $date) {
        $stmt = $db->prepare("INSERT INTO timesheets (user_id, job_id, hours_worked, submitted_at, supervisor_comment)
                              VALUES (:user_id, :job_id, :hours_worked, :submitted_at, :comment)");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':job_id' => $jobId ?: null,
            ':hours_worked' => $hoursWorked,
            ':submitted_at' => $date,
            ':comment' => $comment
        ]);
        echo "<p>Timesheet submitted!</p>";
    } else {
        echo "<p>Please fill in all required fields.</p>";
    }
}
?>

<h3>Submit Timesheet</h3>
<form method="POST">
    <label>Date:</label><br>
    <input type="date" name="date" value="<?= date('Y-m-d') ?>" required><br><br>

    <label>Job ID (Leave blank if unscheduled):</label><br>
    <input type="text" name="job_id"><br><br>

    <label>Hours Worked:</label><br>
    <input type="number" step="0.1" name="hours_worked" required><br><br>

    <label>Comment:</label><br>
    <textarea name="comment"></textarea><br><br>

    <input type="submit" value="Submit">
</form>

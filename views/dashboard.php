<?php
include 'includes/header.php';
?>

<h2>Your Timesheets</h2>
<?php
// Fetch submitted timesheets for the employee
$query = "SELECT * FROM timesheets WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($timesheets) {
    echo '<table>';
    echo '<tr><th>Job ID</th><th>Hours Worked</th><th>Status</th><th>Action</th></tr>';
    foreach ($timesheets as $timesheet) {
        echo '<tr>';
        echo '<td>' . $timesheet['job_id'] . '</td>';
        echo '<td>' . $timesheet['hours_worked'] . '</td>';
        echo '<td>' . ucfirst($timesheet['status']) . '</td>';
        echo '<td>';
        if ($timesheet['status'] == 'submitted') {
            echo '<a href="submit_timesheet.php?reject=' . $timesheet['id'] . '">Reject</a>';
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>You have no submitted timesheets yet.</p>';
}
?>

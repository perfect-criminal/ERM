<?php
include 'includes/header.php';

// Check if the logged-in user is a supervisor
if ($user->role != 'supervisor') {
    echo "Access Denied!";
    exit();
}
?>

<h2>Approve Timesheets</h2>
<?php
// Fetch all submitted timesheets for approval
$query = "SELECT * FROM timesheets WHERE status = 'submitted' ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($timesheets) {
    echo '<table>';
    echo '<tr><th>Employee</th><th>Job ID</th><th>Hours Worked</th><th>Status</th><th>Action</th></tr>';
    foreach ($timesheets as $timesheet) {
        $employee_query = "SELECT name FROM users WHERE id = :user_id";
        $employee_stmt = $db->prepare($employee_query);
        $employee_stmt->bindParam(':user_id', $timesheet['user_id']);
        $employee_stmt->execute();
        $employee = $employee_stmt->fetch(PDO::FETCH_ASSOC);

        echo '<tr>';
        echo '<td>' . $employee['name'] . '</td>';
        echo '<td>' . $timesheet['job_id'] . '</td>';
        echo '<td>' . $timesheet['hours_worked'] . '</td>';
        echo '<td>' . ucfirst($timesheet['status']) . '</td>';
        echo '<td>';
        echo '<a href="approve_timesheet.php?id=' . $timesheet['id'] . '">Approve</a>';
        echo ' | ';
        echo '<a href="reject_timesheet.php?id=' . $timesheet['id'] . '">Reject</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No timesheets are pending approval.</p>';
}
?>

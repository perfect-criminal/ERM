<?php
include 'includes/header.php';
include 'config/db.php';

$database = new Database();
$db = $database->connect();

$query = "SELECT * FROM payroll ORDER BY pay_period DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$payrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h2>Payroll Records</h2>';

if ($payrolls) {
    echo '<table>';
    echo '<tr><th>User ID</th><th>Pay Period</th><th>Hours Worked</th><th>Hourly Rate</th><th>Total Pay</th><th>Action</th></tr>';
    foreach ($payrolls as $payroll) {
        echo '<tr>';
        echo '<td>' . $payroll['user_id'] . '</td>';
        echo '<td>' . $payroll['pay_period'] . '</td>';
        echo '<td>' . $payroll['hours_worked'] . '</td>';
        echo '<td>' . $payroll['hourly_rate'] . '</td>';
        echo '<td>' . $payroll['total_pay'] . '</td>';
        echo '<td><a href="view_payroll.php?id=' . $payroll['id'] . '">View</a> | <a href="delete_payroll.php?id=' . $payroll['id'] . '">Delete</a></td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No payroll records found.</p>';
}
?>

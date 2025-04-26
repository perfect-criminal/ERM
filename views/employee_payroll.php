<?php
include 'includes/header.php';

echo '<h2>Your Payroll Records</h2>';

$query = "SELECT * FROM payroll WHERE user_id = :user_id ORDER BY pay_period DESC";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$payrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($payrolls) {
    echo '<table>';
    echo '<tr><th>Pay Period</th><th>Hours Worked</th><th>Hourly Rate</th><th>Total Pay</th></tr>';
    foreach ($payrolls as $payroll) {
        echo '<tr>';
        echo '<td>' . $payroll['pay_period'] . '</td>';
        echo '<td>' . $payroll['hours_worked'] . '</td>';
        echo '<td>' . $payroll['hourly_rate'] . '</td>';
        echo '<td>' . $payroll['total_pay'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No payroll records available.</p>';
}
?>

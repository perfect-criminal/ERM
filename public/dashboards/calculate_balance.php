<?php
session_start();
if ($_SESSION['role'] !== 'employee') {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';

$database = new Database();
$db = $database->connect();

// Check if filter is set
$filterDate = $_GET['filter_date'] ?? null;
$filterJob = $_GET['filter_job'] ?? null;

// Construct query to calculate balance
$query = "SELECT t.*, j.title AS job_title, j.category_id 
          FROM timesheets t
          LEFT JOIN jobs j ON t.job_id = j.id
          WHERE t.user_id = :user_id AND t.status = 'submitted'";

$params = [':user_id' => $_SESSION['user_id']];

if ($filterDate) {
    $query .= " AND t.submitted_at = :filter_date";
    $params[':filter_date'] = $filterDate;
}

if ($filterJob) {
    $query .= " AND j.category_id = :filter_job";
    $params[':filter_job'] = $filterJob;
}

$stmt = $db->prepare($query);
$stmt->execute($params);

$timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate balance (total unpaid hours and earnings)
$totalHours = 0;
foreach ($timesheets as $timesheet) {
    $totalHours += $timesheet['hours_worked'];
}

$balance = $totalHours * 20;  // Assuming a rate of $20 per hour

?>

<h2>Check My Balance</h2>

<form method="GET" action="">
    <label for="filter_date">Filter by Date (optional):</label><br>
    <input type="date" id="filter_date" name="filter_date"><br><br>

    <label for="filter_job">Filter by Job Category (optional):</label><br>
    <select id="filter_job" name="filter_job">
        <option value="">Select a Job Category</option>
        <?php
        // Fetch available job categories
        $stmt = $db->query("SELECT * FROM job_categories");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categories as $category):
            ?>
            <option value="<?= $category['id'] ?>" <?= $filterJob == $category['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($category['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Filter">
</form>

<p>Total Unpaid Hours: <?= $totalHours ?></p>
<p>Estimated Balance (Total Hours x $20): $<?= number_format($balance, 2) ?></p>

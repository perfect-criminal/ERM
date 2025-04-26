<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

switch ($_SESSION['role']) {
    case 'admin':
        header("Location: dashboards/admin_dashboard.php");
        break;
    case 'supervisor':
        header("Location: dashboards/supervisor_dashboard.php");
        break;
    case 'employee':
        header("Location: dashboards/employee_dashboard.php");
        break;
    default:
        echo "Invalid role.";
}
exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<h2>Welcome to the Dashboard</h2>
<p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

<a href="logout.php">Logout</a>
</body>
</html>

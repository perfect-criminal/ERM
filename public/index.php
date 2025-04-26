<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Composer Autoloader
require_once __DIR__ . '/../config/db.php';       // Database Connection
require_once __DIR__ . '/../includes/helpers.php';// (optional) Helper functions
require_once __DIR__ . '/../Controllers/TimesheetController.php';
session_start();

// Router logic
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'submit-timesheet':
        $controller = new TimesheetController($db);
        $controller->showForm();
        break;

    case 'save-timesheet':
        $controller = new TimesheetController($db);
        $controller->save();
        break;

    default:
        echo "<h2>Welcome to ERM System</h2>";
        echo "<p><a href='?page=submit-timesheet'>Submit Timesheet</a></p>";
}
var_dump(class_exists('App\\Controllers\\TimesheetController'));
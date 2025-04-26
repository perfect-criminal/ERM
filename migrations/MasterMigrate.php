<?php
include 'config/db.php';
include 'Migration.php';

$database = new Database();
$db = $database->connect();

$migration = new Migration($db);

// Run migrations
require_once 'migrations/create_users_table.php';
require_once 'migrations/create_payroll_table.php';
require_once 'migrations/create_timesheets_table.php';
require_once 'migrations/create_job_categories_table.php';
require_once 'migrations/create_user_job_category_table.php';

echo "All migrations applied successfully.";
?>

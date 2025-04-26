<?php
include 'config/db.php';
include 'Migration.php';

$database = new Database();
$db = $database->connect();

$migration = new Migration($db);

// Create job_categories table
$query = "
    CREATE TABLE IF NOT EXISTS job_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT
    )
";

$migration->apply($query);
?>

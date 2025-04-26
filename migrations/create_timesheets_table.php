<?php
include 'config/db.php';
include 'Migration.php';

$database = new Database();
$db = $database->connect();

$migration = new Migration($db);

// Create timesheets table
$query = "
    CREATE TABLE IF NOT EXISTS timesheets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        job_category_id INT NOT NULL,
        start_time DATETIME NOT NULL,
        end_time DATETIME NOT NULL,
        total_hours DECIMAL(5,2) NOT NULL,
        status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )
";

$migration->apply($query);
?>

<?php
include 'config/db.php';
include 'Migration.php';

$database = new Database();
$db = $database->connect();

$migration = new Migration($db);

// Create payroll table
$query = "
    CREATE TABLE IF NOT EXISTS payroll (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        pay_period DATE NOT NULL,
        hours_worked DECIMAL(5,2) NOT NULL,
        hourly_rate DECIMAL(10,2) NOT NULL,
        total_pay DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )
";

$migration->apply($query);
?>

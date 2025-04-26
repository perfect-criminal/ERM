<?php
include 'config/db.php';
include 'Migration.php';

$database = new Database();
$db = $database->connect();

$migration = new Migration($db);

// Create user_job_category table (many-to-many relation)
$query = "
    CREATE TABLE IF NOT EXISTS user_job_category (
        user_id INT NOT NULL,
        job_category_id INT NOT NULL,
        PRIMARY KEY (user_id, job_category_id),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (job_category_id) REFERENCES job_categories(id)
    )
";

$migration->apply($query);
?>

<?php
require_once __DIR__ . '/../config/db.php';

$database = new Database();
$db = $database->connect();

$email = 'emp@erm.com';
$name = 'Employee User';
$plainPassword = 'admin123';
$passwordHash = password_hash($plainPassword, PASSWORD_DEFAULT);

$query = "INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, 'employee')";
$stmt = $db->prepare($query);
$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':password_hash' => $passwordHash
]);

echo "Employee  user created.";
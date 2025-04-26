<?php
session_start();
require_once __DIR__ . '/../config/db.php'; // Include DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and password from POST
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';


    // Connect to the database
    $database = new Database();
    $db = $database->connect();

    // Prepare and execute query to fetch user by email
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";

    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                // Success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                header('Location: dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Invalid email or password.';
            }
        } else {
            $_SESSION['error'] = 'Invalid email or password.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
    }

    header('Location: login.php');
    exit();
}

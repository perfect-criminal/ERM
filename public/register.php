<?php
require_once __DIR__ . '/../config/db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data (username and password)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password using password_hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an insert query to add the user to the database
    $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error registering user.";
    }
}
?>

<!-- HTML Form to register a new user -->
<form action="register.php" method="POST">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Register">
</form>

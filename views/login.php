<?php
session_start();
include 'config/db.php';
include 'models/User.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->connect();
    $user = new User($db);

    $user->email = $email;
    $user->password = $password;

    if ($user->authenticate()) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->role;
        header('Location: dashboard.php'); // Redirect to dashboard
    } else {
        echo "Invalid credentials";
    }
}
?>
<form action="login.php" method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
</form>

<?php
// Start session to use session variables
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<h2>Login Page</h2>

<?php
// Display error message if login fails
if (isset($_SESSION['error'])) {
    echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>

<form action="login_process.php" method="POST">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>



</body>
</html>

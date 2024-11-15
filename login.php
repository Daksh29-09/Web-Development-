<?php
session_start();

// Path to JSON file
$jsonFile = 'users.json';

// Initialize users array from JSON
$users = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate login
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

        <!-- Login Form -->
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <!-- Link to Signup Page -->
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        <a href="forgot.html">Forgot password?</a>
    </div>
</body>
</html>

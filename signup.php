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

    // Check if user already exists
    if (isset($users[$username])) {
        $error = "User already exists!";
    } else {
        // Add new user to users array
        $users[$username] = ['password' => $password];
        file_put_contents($jsonFile, json_encode($users, JSON_PRETTY_PRINT));
        $_SESSION['username'] = $username;
        header("Location: login.php"); // Redirect to login page after successful signup
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

        <!-- Signup Form -->
        <form action="signup.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>

        <!-- Link to Login Page -->
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>

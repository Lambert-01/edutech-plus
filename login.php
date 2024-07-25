<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_password'] = $user['password'];
		requre once "process_signup";
        header('Location: dashboard.php');
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduTech+</title>
    <link rel="stylesheet" href="edutech+.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="EduTech+ Logo">
        </div>
        <nav>
            <ul>
                <li><a href="edutech.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="service.html">Services</a></li>
                <li><a href="online-courses.html">Online Courses</a></li>
                <li><a href="login.php">Log In</a></li>
                <li><a href="signup.html">Sign Up</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Log In</h2>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Log In</button>
        </form>
        <p>Don't have an account? <a href="signup.html">Sign Up</a></p>
    </main>
</body>
</html>

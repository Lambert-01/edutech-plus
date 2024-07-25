<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edutech";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$classroom_name = $_POST['classroom_name'];
$classroom_date = $_POST['classroom_date'];
$classroom_time = $_POST['classroom_time'];
$classroom_link = $_POST['classroom_link'];
$user_id = $_SESSION['user_id'];

// Insert new virtual classroom into the database
$sql = $conn->prepare("INSERT INTO virtual_classrooms (user_id, name, date, time, link) VALUES (?, ?, ?, ?, ?)");
if ($sql === false) {
    die('MySQL prepare error: ' . htmlspecialchars($conn->error));
}
$sql->bind_param("issss", $user_id, $classroom_name, $classroom_date, $classroom_time, $classroom_link);
if ($sql->execute()) {
    header("Location: dashboard.php");
} else {
    echo "Error: " . $sql->error;
}

$conn->close();
?>

<?php
// Database connection details
$servername = "localhost"; // Replace with your server name if different
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "edutech"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the email input
    $subscriber_email = filter_var($_POST["subscriber-email"], FILTER_SANITIZE_EMAIL);

    // Check if email is valid
    if (!filter_var($subscriber_email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Prepare SQL statement to insert data
    $sql = "INSERT INTO subscribe (email) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $subscriber_email);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to index.html on success
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

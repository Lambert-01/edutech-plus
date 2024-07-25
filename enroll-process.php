<?php
// enroll-process.php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    // Validate form data (you can add more validation as needed)
    if (empty($name) || empty($email) || empty($course)) {
        echo "All fields are required.";
        exit;
    }

    // Save the data to a database (example using MySQLi)
    $servername = "localhost";
    $username = "your_db_username";
    $password = "your_db_password";
    $dbname = "your_db_name";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO enrollments (name, email, course) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $course);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Enrollment successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Optionally, send a confirmation email to the user
    $to = $email;
    $subject = "Enrollment Confirmation";
    $message = "Hello $name,\n\nYou have successfully enrolled in the $course course.\n\nThank you!";
    $headers = "From: no-reply@yourdomain.com";

    if (mail($to, $subject, $message, $headers)) {
        echo " A confirmation email has been sent to $email.";
    } else {
        echo " Failed to send confirmation email.";
    }
} else {
    echo "Invalid request.";
}
?>
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if a file was uploaded
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($_FILES['profile_photo']['name']);
    
    // Check if the file is an image
    $file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
    $valid_types = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (in_array($file_type, $valid_types)) {
        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $upload_file)) {
            // Update the database with the new profile photo path
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
            
            $sql = $conn->prepare("UPDATE users SET profile_photo=? WHERE id=?");
            $sql->bind_param("si", $upload_file, $user_id);
            
            if ($sql->execute()) {
                // Update session variable
                $_SESSION['user_profile_photo'] = $upload_file;
                header("Location: learners-dashboard.php");
                exit();
            } else {
                echo "Error updating profile photo.";
            }
            
            $conn->close();
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "Invalid file type.";
    }
} else {
    echo "No file uploaded or there was an upload error.";
}
?>

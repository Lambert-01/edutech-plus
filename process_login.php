<?php
session_start();

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
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Determine the table to query based on the role
    $table = $role === 'teacher' ? 'teachers' : 'users';

    // Prepare statement to fetch user from the appropriate table
    $sql = $conn->prepare("SELECT * FROM $table WHERE email=?");

    if ($sql === false) {
        die("Prepare failed: " . $conn->error);
    }

    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start session
                $_SESSION['user_id'] = $user['id'];

                // Set the user's name in the session based on the role
                if ($role === 'teacher') {
                    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                } else {
                    $_SESSION['user_name'] = $user['name'];
                }

                // Redirect user based on their role
                switch ($role) {
                    case 'student':
                        header("Location: learners-dashboard.php");
                        break;
                    case 'teacher':
                        header("Location: teachers.php");
                        break;
                    case 'admin':
                        header("Location: admin.php");
                        break;
                    default:
                        echo "Invalid role.";
                        break;
                }
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that email.";
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }
} else {
    echo "Please fill in all required fields.";
}

$conn->close();
?>
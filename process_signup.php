<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost"; // Change if different
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "edutech"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Determine if the signup is for a student or teacher
    if (isset($_POST['role']) && $_POST['role'] == 'teacher') {
        // Process teacher signup
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = $_POST['phone'];
        $qualification = $_POST['qualification'];
        $specialization = $_POST['specialization'];
        $experience = $_POST['experience'];
        $bio = $_POST['bio'];
        $resumePath = isset($_FILES['resume']['name']) ? $_FILES['resume']['name'] : ''; // Handle file upload
        $termsAccepted = isset($_POST['terms']) ? 1 : 0;

        // Insert data into teachers table
        $sql = "INSERT INTO teachers (first_name, last_name, email, password, phone, qualification, specialization, experience, bio, resume_path, terms_accepted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssssssi", $firstName, $lastName, $email, $password, $phone, $qualification, $specialization, $experience, $bio, $resumePath, $termsAccepted);

        if ($stmt->execute()) {
            // Send welcome email
            $to = $email;
            $subject = "Welcome to EduTech+";
            $message = "Hello $firstName $lastName,\n\nThank you for signing up with EduTech+.";
            $headers = "From: no-reply@edutechplus.com";
            mail($to, $subject, $message, $headers);

            echo "Teacher signup successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();

    } else {
        // Process student signup
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $nationality = $_POST['nationality'];
        $dob = $_POST['dob'];
        $profilePhoto = ''; // Handle file upload if needed
        $termsAccepted = isset($_POST['terms']) ? 1 : 0;

        // Insert data into users table
        $sql = "INSERT INTO users (name, email, password, gender, phone, nationality, dob, profile_photo, terms_accepted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssssssis", $name, $email, $password, $gender, $phone, $nationality, $dob, $profilePhoto, $termsAccepted);

        if ($stmt->execute()) {
            // Send welcome email
            $to = $email;
            $subject = "Welcome to EduTech+";
            $message = "Hello $name,\n\nThank you for signing up with EduTech+.";
            $headers = "From: no-reply@edutechplus.com";
            mail($to, $subject, $message, $headers);

            echo "Student signup successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<?php
session_start();
require_once 'db_config.php'; // Ensure this file correctly sets up the $conn variable for database connection

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit();
}

// Initialize variables
$user = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'profile_photo' => '',
    'nationality' => '',
    'dob' => ''
];

// Check if email is in session
$userEmail = $_SESSION['user_email'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle file upload
    $profilePhoto = $user['profile_photo']; // Default to current photo

    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_photo']['tmp_name'];
        $fileName = $_FILES['profile_photo']['name'];
        $fileSize = $_FILES['profile_photo']['size'];
        $fileType = mime_content_type($fileTmpPath);
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define allowed file extensions and size
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        if (in_array($fileExtension, $allowedExtensions) && in_array($fileType, $allowedMimeTypes) && $fileSize <= $maxFileSize) {
            $uploadDir = 'img/profile_pictures/';
            $newFileName = $userEmail . '_' . time() . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $profilePhoto = $newFileName;
            } else {
                echo "Error moving the uploaded file. Please check permissions and directory path.";
                exit();
            }
        } else {
            echo "Invalid file type or size.";
            exit();
        }
    } else {
        if ($_FILES['profile_photo']['error'] !== UPLOAD_ERR_NO_FILE) {
            echo "File upload error: " . $_FILES['profile_photo']['error'];
            exit();
        }
    }

    // Update user information in the database
    $query = "UPDATE users SET name = ?, email = ?, phone = ?, profile_photo = ?, nationality = ?, dob = ? WHERE email = ?";
    if ($stmt = $conn->prepare($query)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $nationality = $_POST['nationality'];
        $dob = $_POST['dob'];

        $stmt->bind_param('sssssss', $name, $email, $phone, $profilePhoto, $nationality, $dob, $userEmail);
        if ($stmt->execute()) {
            // Update session data
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_phone'] = $phone;
            $_SESSION['user_profile_photo'] = $profilePhoto;
            $_SESSION['user_nationality'] = $nationality;
            $_SESSION['user_dob'] = $dob;

            // Redirect with success status
            header('Location: learners-profile.php?status=success');
            exit();
        } else {
            echo "Database update failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Database preparation failed: " . $conn->error;
    }
    $conn->close();
    exit();
}

// Fetch user information
$query = "SELECT name, email, phone, profile_photo, nationality, dob FROM users WHERE email = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('s', $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Database preparation failed: " . $conn->error;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Favicon -->
    <link href="img/educa.png" rel="icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - EduTech+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.com/libraries/font-awesome" rel="stylesheet">
    <style>
        /* Your CSS styles here */
        body {
            background-color: #fafafa;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: #fff;
            border-bottom: 1px solid #eaeaea;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        header .logo img {
            width: 120px;
        }

        header .settings-panel a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
            margin-left: 15px;
        }

        header .settings-panel a:hover {
            color: #0056b3;
        }

        main.edit-profile {
            text-align: left;
        }

        main.edit-profile h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #007bff;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .form-group img {
            border-radius: 5px;
            max-width: 120px;
            margin-top: 10px;
            display: block;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #aaa;
        }

        footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="img/educa.png" alt="EduTech+ Logo">
            </div>
            <div class="settings-panel">
                <a href="learners-dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
            </div>
        </header>
        <main class="edit-profile">
            <h1>Edit Profile</h1>
            <?php if (isset($_GET['status'])): ?>
                <?php if ($_GET['status'] == 'success'): ?>
                    <div class="alert alert-success">Profile updated successfully!</div>
                <?php elseif ($_GET['status'] == 'error'): ?>
                    <div class="alert alert-danger">Error updating profile. Please try again.</div>
                <?php endif; ?>
            <?php endif; ?>
            <form action="learners-profile.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="profile_photo">Profile Photo:</label>
                    <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                    <?php if (!empty($user['profile_photo'])): ?>
                        <img src="img/profile_pictures/<?php echo htmlspecialchars($user['profile_photo']); ?>"
                            alt="Profile Photo">
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="nationality">Nationality:</label>
                    <input type="text" class="form-control" id="nationality" name="nationality"
                        value="<?php echo htmlspecialchars($user['nationality'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" class="form-control" id="dob" name="dob"
                        value="<?php echo htmlspecialchars($user['dob'] ?? ''); ?>" required>
                </div>
                <button type="submit" class="btn">Update Profile</button>
            </form>
        </main>
        <footer>
            <p>&copy; 2024 EduTech+. All rights reserved.</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.com/libraries/font-awesome"></script>
</body>

</html>
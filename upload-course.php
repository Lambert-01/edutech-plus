<?php
// Database connection
$servername = "localhost";
$username = "root"; // Use your MySQL username
$password = ""; // Use your MySQL password
$dbname = "edutech";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instructor = $_POST['instructor'];
    $duration = $_POST['duration'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO courses (title, description, instructor, duration, category, image_url) VALUES ('$title', '$description', '$instructor', '$duration', '$category', '$image_url')";

    if ($conn->query($sql) === TRUE) {
        echo "New course added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
</head>
<body>
    <h1>Add New Course</h1>
    <form action="courses.php" method="POST">
        <label for="title">Course Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="instructor">Instructor:</label>
        <input type="text" id="instructor" name="instructor" required><br><br>

        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" required><br><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br><br>

        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url"><br><br>

        <input type="submit" value="Add Course">
    </form>
</body>
</html>

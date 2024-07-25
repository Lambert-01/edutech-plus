<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTech+ Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
     <!-- Favicon -->
    <link href="img/educa.png" rel="icon">
    <!-- Include a UI framework like Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        
        
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="img/educa.png" alt="EduTech+ Logo" height="40">
            EduTech+ Admin Dashboard
        </a>
        <div class="ml-auto d-flex align-items-center">
            <div class="profile mr-3">
                <?php
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

                // Prepare and execute query to retrieve admin information
                $stmt = $conn->prepare("SELECT name, photo FROM admin WHERE email = ?");
                $stmt->bind_param("s", $email);
                $email = "nlambert833@gmail.com";
                $stmt->execute();
                $stmt->bind_result($name, $photo);

                if ($stmt->fetch()) {
                    echo "<img src='" . htmlspecialchars($photo, ENT_QUOTES, 'UTF-8') . "' alt='Profile Photo'>";
                    echo "<span class='ml-2 text-white'><strong>" . $name . "</strong></span>";
                    

                } 
                else {
                    echo "0 results";
                }

                $stmt->close();
                $conn->close();
                ?>
            </div>
            <button onclick="location.href='logout.php'" class="btn btn-outline-light mr-2">Logout</button>
            <button onclick="location.href='change_profile.php'" class="btn btn-outline-light">Change Profile</button>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#user-management">
                                <i class="fas fa-users"></i>
                                User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#course-management">
                                <i class="fas fa-book"></i>
                                Course Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#course-analytics">
                                <i class="fas fa-chart-line"></i>
                                Course Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#user-engagement">
                                <i class="fas fa-chart-bar"></i>
                                User Engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#notifications">
                                <i class="fas fa-bell"></i>
                                Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#content-management">
                                <i class="fas fa-file-alt"></i>
                                Content Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#support-feedback">
                                <i class="fas fa-life-ring"></i>
                                Support & Feedback
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">
                                <i class="fas fa-home"></i>
                                EduTech+ Home
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard Overview</h1>
                </div>

             <!-- Analytics Dashboard Section -->
<section id="analytics-dashboard" class="mb-4">
    <h2 class="gold-text">Analytics Dashboard</h2>

    <div class="row">
        <!-- User Metrics -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">User Metrics</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Number of registered users: <span class="badge badge-primary">1000</span></li>
                        <li class="list-group-item">Active users: <span class="badge badge-success">800</span></li>
                        <li class="list-group-item">New sign-ups: <span class="badge badge-info">200</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Course Metrics -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Course Metrics</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Number of courses offered: <span class="badge badge-primary">50</span></li>
                        <li class="list-group-item">Popular courses: <span class="badge badge-success">Introduction to Programming</span></li>
                        <li class="list-group-item">Course completion rates: <span class="badge badge-info">75%</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Revenue Metrics -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Revenue Metrics</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Income generated: <span class="badge badge-primary">$50,000</span></li>
                        <li class="list-group-item">Subscription plans overview: <span class="badge badge-success">Premium: $30/month</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Engagement Metrics -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Engagement Metrics</h3>
                    <ul class="list-group">
                        <li class="list-group-item">User activity: <span class="badge badge-primary">High</span></li>
                        <li class="list-group-item">Interaction with courses: <span class="badge badge-success">Active</span></li>
                        <li class="list-group-item">Forum participation: <span class="badge badge-info">Moderate</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Animated Graphs -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">User Growth</h3>
                    <div class="chart-container">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Course Completion Rates</h3>
                    <div class="chart-container">
                        <canvas id="courseCompletionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Analytics Dashboard Section -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js initialization for User Growth
    var ctx1 = document.getElementById('userGrowthChart').getContext('2d');
    var userGrowthChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'User Growth',
                data: [120, 190, 300, 500, 200, 300, 400],
                backgroundColor: 'rgba(255, 215, 0, 0.2)',
                borderColor: 'rgba(255, 215, 0, 1)',
                borderWidth: 1,
                tension: 0.4 // Smooth curves
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 2000,
                easing: 'easeInOutBounce'
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart.js initialization for Course Completion Rates
    var ctx2 = document.getElementById('courseCompletionChart').getContext('2d');
    var courseCompletionChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Completion Rates (%)',
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: 'rgba(255, 215, 0, 0.2)',
                borderColor: 'rgba(255, 215, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 2000,
                easing: 'easeInOutBounce'
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<style>
    .gold-border {
        border: 2px solid gold;
    }

    .gold-text {
        color: gold;
        text-align: center;
        margin-bottom: 20px;
    }

    .badge {
        font-size: 1em;
    }

    .card-title {
        font-size: 1.5em;
        color: gold;
    }

    .chart-container {
        position: relative;
        height: 40vh;
        width: 100%;
    }

    .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>


               <!-- Course Management Section -->
<section id="course-management" class="mb-4">
    <h2>Course Management</h2>
    <div id="upload-course">
        <h3>Upload a New Course</h3>
        <form id="course-upload-form" enctype="multipart/form-data" action="admin/upload_course.php" method="POST">
            <div class="form-group">
                <label for="course-title">Course Title</label>
                <input type="text" class="form-control" id="course-title" name="title" placeholder="Enter Course Title" required>
            </div>
            <div class="form-group">
                <label for="course-description">Course Description</label>
                <textarea class="form-control" id="course-description" name="description" rows="3" placeholder="Enter Course Description"></textarea>
            </div>
            <div class="form-group">
                <label for="course-instructor">Instructor</label>
                <input type="text" class="form-control" id="course-instructor" name="instructor" placeholder="Enter Instructor Name" required>
            </div>
            <div class="form-group">
                <label for="course-duration">Duration</label>
                <input type="text" class="form-control" id="course-duration" name="duration" placeholder="Enter Course Duration" required>
            </div>
            <div class="form-group">
                <label for="course-category">Category</label>
                <input type="text" class="form-control" id="course-category" name="category" placeholder="Enter Course Category" required>
            </div>
            <div class="form-group">
                <label for="course-image-url">Image URL</label>
                <input type="text" class="form-control" id="course-image-url" name="image_url" placeholder="Enter Image URL">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Upload</button>
        </form>
    </div>

    <div id="view-courses" class="mt-4">
        <h3>View All Courses</h3>
        <a href="courses.php" class="btn btn-secondary">View Courses</a>
    </div>
</section>

                    <hr>

                    <h3>Manage Existing Courses</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course Title</th>
                                    <th>Uploaded By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Introduction to Python Programming</td>
                                    <td>Admin</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Web Development Basics</td>
                                    <td>Admin</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                <!-- Additional courses can be dynamically added here from the database -->
                            </tbody>
                        </table>
                    </div>
                </section>
                <!-- End Course Management Section -->

                 <!-- Course Analytics Section -->
<section id="course-analytics" class="mb-4">
    <h2>Course Analytics</h2>
    
    <div class="row">
        <!-- Course Completion Rates -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Completion Rates</h3>
                    <p>Percentage of users who completed each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-success">75%</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-success">80%</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Enrollment Numbers -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Enrollment Numbers</h3>
                    <p>Total enrollments for each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-primary">2000</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-primary">1500</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Average Time to Completion -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Average Time to Completion</h3>
                    <p>Average time (in hours) taken by users to complete each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-info">10 hours</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-info">12 hours</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Course Ratings and Reviews -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Course Ratings and Reviews</h3>
                    <p>Average ratings and number of reviews for each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-warning">4.5 stars</span> (200 reviews)</li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-warning">4.7 stars</span> (150 reviews)</li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Engagement Metrics -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Engagement Metrics</h3>
                    <p>Average engagement metrics for each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-primary">High</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-primary">Moderate</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quiz/Assessment Performance -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Quiz/Assessment Performance</h3>
                    <p>Average scores in quizzes and assessments for each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-success">85%</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-success">88%</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- User Demographics -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">User Demographics</h3>
                    <p>Demographic details of users enrolled in each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-info">Age 18-25: 60%, Male: 70%</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-info">Age 25-35: 50%, Female: 65%</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Feedback and Comments -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Feedback and Comments</h3>
                    <p>User feedback and comments for each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-success">"Great course!"</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-success">"Very informative."</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Drop-off Points -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Drop-off Points</h3>
                    <p>Sections where users most commonly stop progressing in each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-danger">Mid-term project</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-danger">Module 3: CSS Basics</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Revenue Per Course -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Revenue Per Course</h3>
                    <p>Revenue generated from each course:</p>
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming: <span class="badge badge-primary">$10,000</span></li>
                        <li class="list-group-item">Web Development Basics: <span class="badge badge-primary">$8,500</span></li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Course Analytics Section -->
<!-- User Management Section -->
<section id="user-management" class="mb-4">
    <h2>User Management</h2>
    
    <div class="row">
        <!-- User List and Search -->
        <div class="col-md-12 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">User List</h3>
                    <input type="text" class="form-control mb-3" placeholder="Search Users">
                    <ul class="list-group">
                        <li class="list-group-item">John Doe</li>
                        <li class="list-group-item">Jane Smith</li>
                        <!-- Additional users can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- User Profiles -->
        <div class="col-md-12 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">User Profiles</h3>
                    <p>View detailed profiles of users:</p>
                    <!-- Placeholder for user profile details -->
                </div>
            </div>
        </div>

        <!-- User Roles and Permissions -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">User Roles and Permissions</h3>
                    <p>Manage different roles and permissions:</p>
                    <!-- Placeholder for roles and permissions management -->
                </div>
            </div>
        </div>

        <!-- User Activity and Engagement -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">User Activity and Engagement</h3>
                    <p>Track user login frequency, course engagement, and completion rates:</p>
                    <!-- Placeholder for user activity tracking -->
                </div>
            </div>
        </div>

        <!-- User Feedback and Support Requests -->
<div class="col-md-12 mb-4">
    <div class="card gold-border">
        <div class="card-body">
            <h3 class="card-title">User Feedback and Support Requests</h3>
            <p>View and manage user feedback and support requests:</p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Subscription Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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

                        // SQL query to fetch all subscribers
                        $sql_subscribers = "SELECT email, subscription_date FROM subscribe";
                        $result_subscribers = $conn->query($sql_subscribers);

                        // Check if there are rows returned
                        if ($result_subscribers === false) {
                            echo "Error retrieving subscribers: " . $conn->error;
                        } else {
                            if ($result_subscribers->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result_subscribers->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['subscription_date'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No subscribers found</td></tr>";
                            }
                        }

                        // Close connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

        <!-- User Enrollment Management -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">User Enrollment Management</h3>
                    <p>Enroll or unenroll users in courses:</p>
                    <!-- Placeholder for enrollment management -->
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Account Status</h3>
                    <p>Activate, deactivate, or delete user accounts:</p>
                    <!-- Placeholder for account status management -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End User Management Section -->

<!-- Content Management Section -->
<section id="content-management" class="mb-4">
    <h2>Content Management</h2>
    
    <div class="row">
        <!-- Course List and Search -->
        <div class="col-md-12 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Course List</h3>
                    <input type="text" class="form-control mb-3" placeholder="Search Courses">
                    <ul class="list-group">
                        <li class="list-group-item">Introduction to Python Programming</li>
                        <li class="list-group-item">Web Development Basics</li>
                        <!-- Additional courses can be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Course Creation and Editing -->
        <div class="col-md-12 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Course Creation and Editing</h3>
                    <button class="btn btn-primary">Add New Course</button>
                    <p>Manage course details:</p>
                    <!-- Placeholder for course creation and editing -->
                </div>
            </div>
        </div>

        <!-- Content Upload and Management -->
        <div class="col-md-12 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Content Upload and Management</h3>
                    <button class="btn btn-primary">Upload New Content</button>
                    <p>Manage course materials:</p>
                    <!-- Placeholder for content upload and management -->
                </div>
            </div>
        </div>

        <!-- Content Scheduling -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Content Scheduling</h3>
                    <p>Schedule content release dates and times:</p>
                    <!-- Placeholder for content scheduling -->
                </div>
            </div>
        </div>

        <!-- Course Categorization and Tagging -->
        <div class="col-md-6 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Course Categorization and Tagging</h3>
                    <p>Organize courses into categories and add tags:</p>
                    <!-- Placeholder for categorization and tagging -->
                </div>
            </div>
        </div>

        <!-- Course Analytics -->
        <div class="col-md-12 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Course Analytics</h3>
                    <p>View detailed analytics for each course:</p>
                    <!-- Placeholder for course analytics -->
                </div>
            </div>
        </div>

        <!-- Content Approval Workflow -->
        <div class="col-md-12 mb-4">
            <div class="card gold-border">
                <div class="card-body">
                    <h3 class="card-title">Content Approval Workflow</h3>
                    <p>Implement a workflow for reviewing and approving new content:</p>
                    <!-- Placeholder for content approval workflow -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Content Management Section -->

            </main>
        </div>
    </div>

    <!-- JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

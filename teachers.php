<?php
// Start the session with output buffering to avoid issues with headers
ob_start();
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Get user details from the session
$user_id = $_SESSION['user_id'];

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

// Fetch teacher details from the teachers table
$sql = $conn->prepare("SELECT * FROM teachers WHERE id=?");
if ($sql === false) {
    die('MySQL prepare error: ' . htmlspecialchars($conn->error));
}
$sql->bind_param("i", $user_id);
$sql->execute();
$result = $sql->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Store user details in session for reuse
    $_SESSION['user_name'] = $user['name'] ?? 'N/A';
    $_SESSION['user_email'] = $user['email'] ?? 'N/A';
    $_SESSION['user_gender'] = $user['gender'] ?? 'N/A';
    $_SESSION['user_phone'] = $user['phone'] ?? 'N/A';
    $_SESSION['user_nationality'] = $user['nationality'] ?? 'N/A';
    $_SESSION['user_dob'] = $user['dob'] ?? 'N/A';
    $_SESSION['user_profile_photo'] = $user['profile_photo'] ?? 'default.jpg'; // default image if not set
} else {
    echo "Error fetching user details.";
    exit();
}

$conn->close();
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - EduTech+</title>

    <!-- Favicon -->
    <link href="img/educa.png" rel="icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Font Awesome (Icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS (Animate On Scroll) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <style>
        /* Sidebar Styles */
        #accordionSidebar {
            background-color: #4e73df;
            color: #fff;
        }

        .sidebar-brand-icon {
            width: 40px;
        }

        .sidebar-brand-text {
            font-size: 1.2rem;
        }

        .nav-item .nav-link {
            color: #fff;
        }

        .nav-item .nav-link.active {
            background-color: #2e59d9;
        }

        /* Content Styles */
        #content {
            padding: 20px;
        }

        .content-section {
            display: none;
            padding: 20px;
            border-radius: 8px;
            background-color: #f8f9fc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .content-section h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .content-section p {
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Topbar Styles */
        .navbar-nav .nav-link {
            color: #858796;
        }

        .navbar-nav .nav-link:hover {
            color: #000;
        }

        /* Footer Styles */
        .sticky-footer {
            background-color: #4e73df;
            color: #fff;
        }

        .sticky-footer .container {
            text-align: center;
        }

        /* Google Sign-In Button */
        .g-signin2 {
            margin-top: 20px;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <img src="img/educa.png" alt="EduTech+ Icon" style="width: 30px;">
                </div>
                <div class="sidebar-brand-text mx-3">EduTech+</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Items -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="profile">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="course-management">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Course Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="student-management">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Student Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="assignments">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Assignments & Assessments</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="communication">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Communication</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="analytics">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="calendar">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="resource-library">
                    <i class="fas fa-fw fa-bookmark"></i>
                    <span>Resource Library</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="virtual-classrooms">
                    <i class="fas fa-fw fa-chalkboard-teacher"></i>
                    <span>Virtual Classrooms</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="settings">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="feedback-support">
                    <i class="fas fa-fw fa-comment-dots"></i>
                    <span>Feedback & Support</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-file-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    New Assignment
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    New Student Registration
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-comments fa-sm fa-fw mr-2 text-gray-400"></i>
                                    New Message
                                </a>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo htmlspecialchars($_SESSION['user_profile_photo']); ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="edit-profile.php">
                                    <i class="fas fa-user-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Edit Profile
                                </a>
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>

                    <!-- Google Sign-In Button -->
                    <div class="g-signin2" data-onsuccess="onSignIn"></div>

                    <!-- Content Sections -->
                    <div id="dashboard" class="content-section">
                        <h2>Dashboard</h2>
                        <p>This is your dashboard where you can manage your courses, students, and more.</p>
                    </div>

                    <div id="profile" class="content-section">
                        <h2>Profile</h2>
                        <p>Name: <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                        <p>Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                        <p>Gender: <?php echo htmlspecialchars($_SESSION['user_gender']); ?></p>
                        <p>Phone: <?php echo htmlspecialchars($_SESSION['user_phone']); ?></p>
                        <p>Nationality: <?php echo htmlspecialchars($_SESSION['user_nationality']); ?></p>
                        <p>Date of Birth: <?php echo htmlspecialchars($_SESSION['user_dob']); ?></p>
                        <p><img src="<?php echo htmlspecialchars($_SESSION['user_profile_photo']); ?>" alt="Profile Photo" class="img-thumbnail" style="width: 150px;"></p>
                    </div>

                    <div id="course-management" class="content-section">
                        <h2>Course Management</h2>
                        <p>Manage your courses here.</p>
                    </div>

                    <div id="student-management" class="content-section">
                        <h2>Student Management</h2>
                        <p>Manage your students here.</p>
                    </div>

                    <div id="assignments" class="content-section">
                        <h2>Assignments & Assessments</h2>
                        <p>Manage assignments and assessments here.</p>
                    </div>

                    <div id="communication" class="content-section">
                        <h2>Communication</h2>
                        <p>Communicate with students and other teachers here.</p>
                    </div>

                    <div id="analytics" class="content-section">
                        <h2>Analytics</h2>
                        <p>View analytics and reports here.</p>
                    </div>

                    <div id="calendar" class="content-section">
                        <h2>Calendar</h2>
                        <p>View and manage your calendar here.</p>
                    </div>

                    <div id="resource-library" class="content-section">
                        <h2>Resource Library</h2>
                        <p>Access and manage resources here.</p>
                    </div>

                    <div id="virtual-classrooms" class="content-section">
                        <h2>Virtual Classrooms</h2>
                        <p>Manage virtual classrooms here.</p>
                    </div>

                    <div id="settings" class="content-section">
                        <h2>Settings</h2>
                        <p>Adjust your settings here.</p>
                    </div>

                    <div id="feedback-support" class="content-section">
                        <h2>Feedback & Support</h2>
                        <p>Provide feedback or get support here.</p>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright">
                        <span>EduTech+ © 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Sign-In API -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- AOS (Animate On Scroll) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <!-- Custom scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Activate the selected content section
            var navLinks = document.querySelectorAll('.nav-link');
            var sections = document.querySelectorAll('.content-section');

            navLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    var target = this.getAttribute('data-target');
                    sections.forEach(function (section) {
                        if (section.id === target) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });

            // Google Sign-In
            window.onSignIn = function (googleUser) {
                var profile = googleUser.getBasicProfile();
                console.log('ID: ' + profile.getId());
                console.log('Name: ' + profile.getName());
                console.log('Image URL: ' + profile.getImageUrl());
                console.log('Email: ' + profile.getEmail());
            };
        });
    </script>

</body>

</html>

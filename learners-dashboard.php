<?php
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

// Fetch user details from the database
$sql = $conn->prepare("SELECT * FROM users WHERE id = ?");
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduTech+</title>

    <!-- Favicon -->
    <link href="img/educa.png" rel="icon">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Font Awesome (Icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS (Animate On Scroll) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        .profile-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-card .card-header {
            background: #f8f9fc;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
        }

        .profile-card .btn {
            margin: 5px 0;
        }

        .profile-info {
            background: #f8f9fc;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-info h4 {
            margin-bottom: 10px;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Sidebar Styling */
        #accordionSidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            height: 100%;
            margin: 0;
            padding: 0;
            width: 250px;
            background-color: #4e73df;
            overflow-y: auto;
        }

        .sidebar-dark .nav-link {
            color: #fff;
        }

        .sidebar-dark .nav-link:hover {
            background-color: #2e59d9;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .sidebar-brand-icon {
            margin-right: 10px;
        }

        .sidebar-card {
            padding: 10px;
            background: #f8f9fc;
            border-radius: 5px;
        }

        /* Topbar Styling */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e3e6f0;
        }

        .topbar .navbar-nav .nav-item .nav-link {
            color: #5a5c69;
        }

        /* Content Wrapper */
        #content-wrapper {
            margin-left: 250px;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="learners-dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="img/educa.png" alt="EduTech+" style="width: 40px; height: 40px;">
                </div>
                <div class="sidebar-brand-text mx-3">EduTech+</div>
            </a>
            <!-- Sidebar Navigation -->
            <hr class="sidebar-divider my-0">
            <li class="nav-item"><a class="nav-link" href="#" data-target="dashboard"><i
                        class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <hr class="sidebar-divider">
            <li class="nav-item"><a class="nav-link" href="#" data-target="profile"><i
                        class="fas fa-fw fa-user"></i><span>Profile</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#" data-target="courses"><i
                        class="fas fa-fw fa-book"></i><span>My Courses</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#" data-target="assignments"><i
                        class="fas fa-fw fa-tasks"></i><span>Assignments</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#" data-target="grades"><i
                        class="fas fa-fw fa-graduation-cap"></i><span>Grades</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#" data-target="messages"><i
                        class="fas fa-fw fa-envelope"></i><span>Messages</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#" data-target="settings"><i
                        class="fas fa-fw fa-cogs"></i><span>Settings</span></a></li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline"><button class="rounded-circle border-0"
                    id="sidebarToggle"></button></div>
            <div class="sidebar-card d-none d-lg-flex">
                <p class="text-center mb-2"><strong>EduTech+</strong> Upgrade to premium for more features!</p><a
                    class="btn btn-success btn-sm" href="upgrade.html">Upgrade Now!</a>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i
                            class="fa fa-bars"></i></button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/profile_pictures/<?php echo htmlspecialchars($_SESSION['user_profile_photo']); ?>"
                                    alt="Profile Picture">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.html">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="settings.html">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
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
                    <h1 class="h3 mb-4 text-gray-800">Welcome to Your Dashboard</h1>

                    <!-- Content Sections -->
                    <div id="dashboard" class="content-section active">
                        <h4>Dashboard</h4>
                        <p>Overview of your activities and progress.</p>
                    </div>
                    <div id="profile" class="content-section">
                        <h4>Profile</h4>
                        <div class="profile-card card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Your Profile</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="profile-picture img-fluid mb-3"
                                        src="img/profile_pictures/<?php echo htmlspecialchars($_SESSION['user_profile_photo']); ?>"
                                        alt="Profile Picture">
                                    <h4 class="font-weight-bold"><?php echo htmlspecialchars($_SESSION['user_name']); ?>
                                    </h4>
                                    <p class="text-muted"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                                    <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>
                                </div>
                                <div class="profile-info">
                                    <h4>Additional Information</h4>
                                    <p><strong>Gender:</strong>
                                        <?php echo htmlspecialchars($_SESSION['user_gender']); ?></p>
                                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION['user_phone']); ?>
                                    </p>
                                    <p><strong>Nationality:</strong>
                                        <?php echo htmlspecialchars($_SESSION['user_nationality']); ?></p>
                                    <p><strong>Date of Birth:</strong>
                                        <?php echo htmlspecialchars($_SESSION['user_dob']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="courses" class="content-section">
                        <h4>My Courses</h4>
                        <p>List of courses you are enrolled in.</p>
                    </div>
                    <div id="assignments" class="content-section">
                        <h4>Assignments</h4>
                        <p>Manage and view your assignments.</p>
                    </div>
                    <div id="grades" class="content-section">
                        <h4>Grades</h4>
                        <p>Check your grades and academic performance.</p>
                    </div>
                    <div id="messages" class="content-section">
                        <h4>Messages</h4>
                        <p>View and manage your messages.</p>
                    </div>
                    <div id="settings" class="content-section">
                        <h4>Settings</h4>
                        <p>Configure your account settings.</p>
                    </div>
                </div>
                <!-- End Page Content -->
            </div>
            <!-- End Main Content -->
        </div>
        <!-- End Content Wrapper -->
    </div>
    <!-- End Wrapper -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Sidebar link click event handler
        document.querySelectorAll('#accordionSidebar .nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');

                // Hide all content sections
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });

                // Show the target content section
                document.getElementById(targetId).classList.add('active');
            });
        });
    </script>
</body>

</html>
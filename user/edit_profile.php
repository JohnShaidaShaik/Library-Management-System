<?php
session_start();

// Database Connection
$connection = mysqli_connect("localhost", "root", "", "ims");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$name = $email = $mobile = $address = "";

// Check if user is logged in
if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];

    // Fetch the user's data using a prepared statement
    $query = "SELECT name, email, mobile, address FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $address = $row['address'];
    } else {
        echo "Failed to fetch user details.";
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    echo "User not logged in.";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="bootstrap-4.4.1/js/jquery_latest.js"></script>
    <script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
            <span style="color: white"><strong>Welcome: <?php echo $_SESSION['name']; ?></strong></span>
            <span style="color: white"><strong>Email: <?php echo $_SESSION['email']; ?></strong></span>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="view_profile.php">View Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav><br>

    <!-- Page Header -->
    <marquee>This is a library management system. Library opens at 8:00 AM and closes at 8:00 PM</marquee>
    <center><h4>Edit Profile</h4></center><br>

    <!-- Edit Profile Form -->
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form action="update.php" method="post" enctype="multipart/form-data">
                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>

                <!-- Email Field (Hidden) -->
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                <!-- Mobile Field -->
                <div class="form-group">
                    <label for="mobile">Mobile:</label>
                    <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($mobile); ?>" required>
                </div>

                <!-- Address Field -->
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea rows="3" cols="40" name="address" class="form-control" required><?php echo htmlspecialchars($address); ?></textarea>
                </div>

                <!-- Profile Image Upload -->
                <div class="form-group">
                    <label for="images">Profile Image:</label>
                    <input type="file" name="images" class="form-control">
                </div>

                <!-- Submit Button -->
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>
</html>

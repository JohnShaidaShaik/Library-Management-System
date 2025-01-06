<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$connection = mysqli_connect("localhost", "root", "", "ims");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all registered users
$query = "SELECT name, email, mobile, address, images FROM users";
$query_run = mysqli_query($connection, $query);

if (!$query_run) {
    die("Query failed: " . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Registered Users</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="user_dashboard.php">Library Management System (LMS)</a>
            </div>
            <font style="color: white">
                <span><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
            </font>
            <font style="color: white">
                <span><strong>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></strong></span>
            </font>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">View Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav><br>
    <span><marquee>This is library management system. Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    <center><h4>Registered Users Detail</h4><br></center>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form>
                <table class="table table-bordered" width="900px" style="text-align: center">
                    <tr>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Image</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        $name = htmlspecialchars($row['name']);
                        $email = htmlspecialchars($row['email']);
                        $mobile = htmlspecialchars($row['mobile']);
                        $address = htmlspecialchars($row['address']);
                        $image = htmlspecialchars($row['images']);
                    ?>
                        <tr>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $mobile; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $address; ?></td>
                            <td>
                                <?php if (!empty($image)) { ?>
                                    <img src="../uploads/<?php echo $image; ?>" alt="User Image" style="width: 100px; height: 100px;">
                                <?php } else { ?>
                                    <span>No Image</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
</body>
</html>

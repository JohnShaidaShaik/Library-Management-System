<?php
  require("functions.php");
  session_start();

  # Fetch data from the database
  $connection = mysqli_connect("localhost", "root", "");
  $db = mysqli_select_db($connection, "ims");
  $name = "";
  $email = "";
  $mobile = "";
  $query = "SELECT * FROM admins WHERE email = '$_SESSION[email]'";
  $query_run = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($query_run)) {
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Author</title>
  <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
  <script type="text/javascript" src="../bootstrap-4.4.1/js/jquery_latest.js"></script>
  <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
      </div>
      <span style="color: white;"><strong>Welcome: <?php echo $_SESSION['name']; ?></strong></span>
      <span style="color: white;"><strong>Email: <?php echo $_SESSION['email']; ?></strong></span>
      <ul class="nav navbar-nav navbar-right">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="">View Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Edit Profile</a>
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

  <!-- Secondary Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
      <ul class="nav navbar-nav navbar-center">
        <li class="nav-item">
          <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_dashboard.php">Home</a>
        </li>
      </ul>
    </div>
  </nav><br>

  <!-- Marquee Message -->
  <span><marquee>This is library management system. Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>

  <!-- Manage Author Section -->
  <center><h4>Manage Author</h4><br></center>

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address</th>
            <th>Images</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $query = "SELECT * FROM users";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
          ?>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['mobile']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['address']; ?></td>
              <td><?php echo $row['images']; ?></td>
              <td><button class="btn"><a href="delete_user.php?aid=<?php echo $row['id']; ?>">Delete</a></button></td>
            </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-2"></div>
  </div>

</body>
</html>

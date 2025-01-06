<?php
session_start();

// Database connection
$connection = mysqli_connect("localhost", "root", "", "ims");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['update'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email']; // Hidden email field
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $image_path = ""; // Default empty path for images

    // Check if a new image is uploaded
    if (isset($_FILES['images']) && $_FILES['images']['error'] == 0) {
        $image_name = $_FILES['images']['name'];
        $image_tmp_name = $_FILES['images']['tmp_name'];
        $image_folder = "uploads/" . uniqid() . "_" . basename($image_name);

        // Validate file type (only images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['images']['type'], $allowed_types)) {
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $image_path = $image_folder;
            } else {
                echo "<script>alert('Failed to upload the image.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid file type. Please upload a JPG, PNG, or GIF image.'); window.history.back();</script>";
            exit;
        }
    }

    // Update the database with prepared statements
    if ($image_path != "") {
        // Update with image
        $query = "UPDATE users SET name = ?, mobile = ?, address = ?, images = ? WHERE email = ?";
    } else {
        // Update without image
        $query = "UPDATE users SET name = ?, mobile = ?, address = ? WHERE email = ?";
    }

    if ($stmt = mysqli_prepare($connection, $query)) {
        if ($image_path != "") {
            mysqli_stmt_bind_param($stmt, "sssss", $name, $mobile, $address, $image_path, $email);
        } else {
            mysqli_stmt_bind_param($stmt, "ssss", $name, $mobile, $address, $email);
        }

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Profile updated successfully!'); window.location.href = 'user_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating profile: " . mysqli_error($connection) . "'); window.history.back();</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error preparing the statement: " . mysqli_error($connection) . "'); window.history.back();</script>";
    }
}

mysqli_close($connection);
?>

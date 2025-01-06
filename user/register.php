<?php
$connection = mysqli_connect("localhost", "root", "", "ims");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);

    // Handle file upload
    $image_name = $_FILES['images']['name'];
    $image_temp = $_FILES['images']['tmp_name'];
    $image_folder = "uploads/" . $image_name;

    // Check if uploads directory exists, if not create it
    if (!file_exists("uploads")) {
        mkdir("uploads", 0777, true);
    }

    // Move uploaded file to the uploads directory
    if (move_uploaded_file($image_temp, $image_folder)) {
        $query = "INSERT INTO users (name, email, password, mobile, address, images) 
                  VALUES ('$name', '$email', '$password', '$mobile', '$address', '$image_name')";

        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            echo "<script>
                    alert('Registration successful...You may log in now!');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error in registration. Please try again.');
                    window.location.href = 'register.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Image upload failed. Please try again.');
                window.location.href = 'register.php';
              </script>";
    }
}
?>

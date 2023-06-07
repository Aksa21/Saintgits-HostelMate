<?php
session_start();

// Retrieve the std_id from the session variable
$stf_id = $_SESSION['stf_id'];

// Assuming you have established a database connection
$conn = new mysqli('localhost', 'root', '', 'hostel');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uploadDir = 'C:\xampp\htdocs\mini\uploads/';

if (!is_dir($uploadDir)) {
    // Directory doesn't exist, create it
    mkdir($uploadDir, 0777, true);
} elseif (!is_writable($uploadDir)) {
    // Directory exists, but doesn't have write permissions
    die("Upload directory is not writable. Please set appropriate permissions.");
}

// Get the updated profile data from the form submission
$name = $_POST['name'];
$email = $_POST['email'];
$mob = $_POST['mob'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$image_path = '';

// Check if an image file was uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_type = $_FILES['image']['type'];

    // Specify the directory to which the image will be uploaded
    $imgDir = "uploads/";

    // Generate a unique filename for the uploaded image
    $image_path = $imgDir . uniqid() . '_' . $image_name;

    // Move the uploaded image to the specified directory
    if (move_uploaded_file($image_tmp, $image_path)) {
        // Image moved successfully, update the image path in the database
        $query = "UPDATE staff_details SET image='$image_path' WHERE stf_id='$stf_id'";

        if ($conn->query($query) !== TRUE) {
            echo "Error updating image path in the database: " . $conn->error;
        }
    } else {
        echo "Error uploading image: Failed to move the uploaded file.";
    }
}

// Update the profile data in the std_details table based on the std_id
$query = "UPDATE staff_details SET name='$name',email='$email',mob='$mob', dob='$dob',  address='$address' WHERE stf_id='$stf_id'";

if ($conn->query($query) === TRUE) {
    // Profile updated successfully, redirect to the profile page
    header("Location: stfprofile.php");
    exit();
} else {
    // Error occurred while updating the profile, handle the error
    echo "Error updating profile: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

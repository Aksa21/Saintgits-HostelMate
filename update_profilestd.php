<?php
session_start();

// Retrieve the std_id from the session variable
$std_id = $_SESSION['std_id'];

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
$room_no = $_POST['room_no'];
$admission_no = $_POST['admission_no'];
$program = $_POST['program'];
$branch = $_POST['branch'];
$guardian = $_POST['guardian'];
$guardian_mob = $_POST['guardian_mob'];
$address = $_POST['address'];
$mob = $_POST['mob'];
$dob = $_POST['dob'];
$pin = $_POST['pin'];
$email = $_POST['email'];
$food_type = $_POST['food_type'];
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
        $query = "UPDATE std_details SET image='$image_path' WHERE std_id='$std_id'";

        if ($conn->query($query) !== TRUE) {
            echo "Error updating image path in the database: " . $conn->error;
        }
    } else {
        echo "Error uploading image: Failed to move the uploaded file.";
    }
}

// Update the profile data in the std_details table
$query = "UPDATE std_details SET name='$name', room_no='$room_no', admission_no='$admission_no', program='$program', branch='$branch', guardian='$guardian', guardian_mob='$guardian_mob', address='$address', mob='$mob', dob='$dob', pin='$pin', email='$email', food_type='$food_type' WHERE std_id='$std_id'";

if ($conn->query($query) === TRUE) {
    // Profile updated successfully, redirect to the profile page
    header("Location: stdprofile.php");
    exit();
} else {
    // Error occurred while updating the profile, handle the error
    echo "Error updating profile: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

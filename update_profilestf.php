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

// Get the updated profile data from the form submission
$name = $_POST['name'];
$email = $_POST['email'];
$mob = $_POST['mob'];
$dob = $_POST['dob'];
$address = $_POST['address'];

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

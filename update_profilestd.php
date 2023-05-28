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

// Update the profile data in the std_details table based on the std_id
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

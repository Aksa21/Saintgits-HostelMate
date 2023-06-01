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

// Retrieve the leave ID from the submitted form
$leaveId = $_POST['leaveId'];

// Delete the leave request from the leave_history table
$query = "DELETE FROM leave_history WHERE id = '$leaveId' AND std_id = '$std_id'";
$result = $conn->query($query);

if ($result) {
    header("Location: stdstat.php");
    exit();
} else {
    echo "Error deleting leave request: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

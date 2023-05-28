<?php
session_start();

// Assuming you have established a database connection
$conn = new mysqli('localhost', 'root', '', 'hostel');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['accept_leave'])) {
    $id = $_POST['leave_id'];
    $status = 'Accepted';

    // Update leave request status to Accepted
    $updateQuery = "UPDATE leave_history SET status = '$status' WHERE id = '$id'";
    $conn->query($updateQuery);
    $removeQuery = "DELETE FROM leave_requests WHERE id = '$id'";
    $conn->query($removeQuery);

} elseif (isset($_POST['reject_leave'])) {
    $id = $_POST['leave_id'];
    $status = 'Rejected';

    // Update leave request status to Rejected
    $updateQuery = "UPDATE leave_history SET status = '$status' WHERE id = '$id'";
    $conn->query($updateQuery);
    $removeQuery = "DELETE FROM leave_requests WHERE id = '$id'";
    $conn->query($removeQuery);
    
}

// Close the database connection
$conn->close();

// Redirect back to the leave requests page
header("Location: stfleave.php");
exit();
?>

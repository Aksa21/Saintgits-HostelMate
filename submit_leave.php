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

// Retrieve the leave request data from the POST variables
$fromDate = $_POST['from_date'];
$toDate = $_POST['to_date'];
$reason = $_POST['reason'];

// Prepare and execute the SQL statement to insert the leave request
$query = "INSERT INTO leave_requests (std_id, from_date, to_date, reason) VALUES ('$std_id', '$fromDate', '$toDate', '$reason')";
if ($conn->query($query) === TRUE) {
    // Get the last inserted leave_id
    $id = $conn->insert_id;
    
    // Prepare and execute the SQL statement to insert into leave_history
    $query1 = "INSERT INTO leave_history (id, std_id, from_date, to_date, reason) VALUES ('$id', '$std_id', '$fromDate', '$toDate', '$reason')";
    if ($conn->query($query1) === TRUE) {
        header("Location: stdleave.php");
        exit();
    } else {
        echo "Error: " . $query1 . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>

<?php
// Assuming you have established a database connection
$conn = new mysqli('localhost', 'root', '', 'hostel');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted and the 'present' array is present in $_POST
if (isset($_POST['present'])) {
    $presentStudents = $_POST['present'];

    // Loop through the selected students and update their attendance status to 'Present'
    foreach ($presentStudents as $stdId) {
        $currentDate = date('Y-m-d');
        $updateQuery = "UPDATE attendance SET status = 'Present' WHERE std_id = '$stdId' AND date = '$currentDate'";
        $conn->query($updateQuery);
    }
    
    // Redirect to the attendance page or show a success message
    header("Location: stfatdnce.php");
    exit();
}

$conn->close();
?>

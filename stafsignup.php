<?php
// Retrieve the form data from the frontend
//$stf_id = $_POST['stf_id'];
if (isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['mob']) && isset($_POST['dob']) && isset($_POST['address'])) {
$name = $_POST['name'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$mob = $_POST['mob'];
$dob = $_POST['dob'];
$address = $_POST['address'];
}
// Create a connection
$conn = new mysqli('localhost', 'root', '', 'hostel');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
  $stmt = $conn->prepare("INSERT INTO staff_details(name,gender,email,mob,dob,address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name,$gender,$email,$mob,$dob,$address);
    $stmt->execute();
    $stmt->close();
    echo "Connection established";
    $conn->close();
}
header("Location: password.html");
exit;
?>
<?php
// Retrieve the form data from the frontend
//$stf_id = $_POST['stf_id'];
if (isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['mob']) && isset($_POST['dob']) && isset($_POST['address'])&& isset($_POST['password'])) {
$name = $_POST['name'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$mob = $_POST['mob'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$password=$_POST['password'];
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
    $stf_id=$stmt->insert_id;
    $stmt->close();
    $stmt2 = $conn->prepare("INSERT INTO staff (email,stf_id,password) VALUES (?, ?, ?)");
    $stmt2->bind_param("sis",$email,$stf_id,$password);
    $stmt2->execute();
    $stmt2->close();
    echo "Connection established";
    $conn->close();
}
header("Location: Home.html");
exit;
?>
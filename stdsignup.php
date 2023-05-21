<?php
// Retrieve the form data from the frontend
//$stf_id = $_POST['stf_id'];
if (isset($_POST['name']) && isset($_POST['room_no']) && isset($_POST['admission_no']) && isset($_POST['program']) && isset($_POST['branch']) && isset($_POST['guardian']) && isset($_POST['guardian_mob']) && isset($_POST['address']) && isset($_POST['mob']) && isset($_POST['dob']) && isset($_POST['pin']) && isset($_POST['email']) && isset($_POST['food_type']) && isset($_POST['password'])) {
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
$password=$_POST['password'];
}
// Create a connection
$conn = new mysqli('localhost', 'root', '', 'hostel');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    $stmt = $conn->prepare("INSERT INTO std_details(name, room_no, admission_no, program, branch, guardian, guardian_mob, address, mob, dob, pin, email, food_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssssssss", $name,$room_no,$admission_no,$program,$branch,$guardian,$guardian_mob,$address,$mob,$dob,$pin,$email,$food_type);
    $stmt->execute();
    $std_id=$stmt->insert_id;
    $stmt->close();
    $stmt2 = $conn->prepare("INSERT INTO student (email,std_id,password) VALUES (?, ?, ?)");
    $stmt2->bind_param("sis",$email,$std_id,$password);
    $stmt2->execute();
    $stmt2->close();
    echo "Connection established";
    $conn->close();
}
header("Location: Home.html");
exit;
?>
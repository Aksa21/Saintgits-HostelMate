<?php
$uploadDir = 'C:\xampp\htdocs\mini\uploads/';

if (!is_dir($uploadDir)) {
    // Directory doesn't exist, create it
    mkdir($uploadDir, 0777, true);
} elseif (!is_writable($uploadDir)) {
    // Directory exists, but doesn't have write permissions
    die("Upload directory is not writable. Please set appropriate permissions.");
}

// Retrieve the form data from the frontend
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

// Check if the email already exists in the table
$conn = new mysqli('localhost', 'root', '', 'hostel');
$existingEmailQuery = "SELECT email FROM student WHERE email = ?";
$stmt = $conn->prepare($existingEmailQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$numRows = $stmt->num_rows;
$stmt->close();

if ($numRows > 0) {
    echo '<script>alert("Email already exists. Please choose a different email."); window.history.back();</script>';
    exit;
}

// Check if an image file was uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_type = $_FILES['image']['type'];

    // Specify the directory to which the image will be uploaded
    $image_directory = "uploads/";

    // Generate a unique filename for the uploaded image
    $image_path = $image_directory . uniqid() . '_' . $image_name;

    // Move the uploaded image to the specified directory
    move_uploaded_file($image_tmp, $image_path);
} else {
    // Default image path if no image was uploaded
    $image_path = "";
}

}
// Create a connection
$conn = new mysqli('localhost', 'root', '', 'hostel');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    $stmt = $conn->prepare("INSERT INTO std_details(name, room_no, admission_no, program, branch, guardian, guardian_mob, address, mob, dob, pin, email, food_type, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssssssssss", $name,$room_no,$admission_no,$program,$branch,$guardian,$guardian_mob,$address,$mob,$dob,$pin,$email,$food_type,$image_path);
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
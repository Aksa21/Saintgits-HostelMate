<?php
/*
if($_POST)
{
    $username = $_POST['email'];
    $password1 = $_POST['password'];
    $conn = new mysqli('localhost', 'root', '', 'hostel');
    $query = "SELECT password FROM student WHERE email = '$username' and password='$password1'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==1)
    {
        session_start();
        $_SESSION['hostel']='true';
        header("Location: stdhome.html");
    }
    else{
        echo 'Invalid username or password';
    }
}*/

if ($_POST) {
    $username = $_POST['email'];
    $password1 = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'hostel');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement with a placeholder for username
    $stmt = $conn->prepare("SELECT password FROM student WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch the password from the result set
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Verify the password
        if ($password1 === $storedPassword) {
            session_start();
            $_SESSION['hostel'] = true;
            header("Location: stdhome.html");
            exit();
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Invalid username or password';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}


?>

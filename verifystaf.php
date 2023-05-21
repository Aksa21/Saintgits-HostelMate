<?php
session_start();
if ($_POST) {
    $username = $_POST['email'];
    $password1 = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'hostel');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement with a placeholder for username
    $stmt = $conn->prepare("SELECT password, stf_id FROM staff WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch the password and std_id from the result set
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $stf_id = $row['stf_id'];

        // Verify the password
        if ($password1 === $storedPassword) {
            // Set the 'std_id' value in the session
            $_SESSION['stf_id'] = $stf_id;

            header("Location: staffhome.php");
            exit();
        } else {
            echo 'Invalid username or password';
            header("Location: stafflgn.html");
            exit();
        }
    } else {
        echo 'Invalid username or password';
        header("Location: stafflgn.html");
        
    }
    $stmt->close();

    // Close the database connection
    $conn->close();
}

?>

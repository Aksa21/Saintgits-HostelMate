<?php
session_start();

// Retrieve the stf_id from the session variable
$stf_id = $_SESSION['stf_id'];

// Assuming you have established a database connection
$conn = new mysqli('localhost', 'root', '', 'hostel');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the name from the staff_details table based on the stf_id
$query = "SELECT name FROM staff_details WHERE stf_id = '$stf_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Name found, fetch and store it in a variable
    $row = $result->fetch_assoc();
    $name = $row['name'];
} else {
    // Name not found, handle the error
    $name = "Unknown";
}

// Retrieve leave requests from students
$leaveQuery = "SELECT std_details.name AS student_name, std_details.room_no, leave_requests.* FROM leave_requests 
                INNER JOIN std_details ON leave_requests.std_id = std_details.std_id";
$leaveResult = $conn->query($leaveQuery);

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <div class="row ">
        <div class="stdhead">
            <h3 class="stdtag" style="float: left;">SaintgitsHostelMate</h3>
            <a href="logout.php" style="color: white; float: right; margin-top: 10px; margin-right: 5%;"><u>Logout</u></a>
        </div>
    </div>
    <div class="row">
        <div class="stfreg1">
            <h3 class="stdtag">Home</h3>
        </div>
    </div>
    <div class="row ">
        <div class="col-3">
            <img src="icon1.png" class="img-fluid1">
            <h5 style="padding-left:27%; color: rgb(32, 32, 50); padding-top: 1%; font-weight: bold; background: whitesmoke; " ><?php echo $name; ?></h5>

            <form action="staffhome.php">
                <button class="stfbtn" style="color: rgb(32, 32, 50);">Home</button>
            </form>
            <form action="stfprofile.php">
                <button class="stfbtn" style="color: rgb(32, 32, 50);">Profile</button>
            </form>
            <form action="stfleave.php">
                <button class="stfbtn" style="color: rgb(32, 32, 50);">Leave Request</button>
            </form>
            <form action="stfatdnce.php">
                <button class="stfbtn" style="color: rgb(32, 32, 50);">Attendance</button>
            </form>
            <form action="stfreport.php">
                <button class="stfbtn" style="color: rgb(32, 32, 50);">Report</button>
            </form>
            <form action="stfstock.php">
                <button class="stfbtn" style="color: rgb(32, 32, 50);">Stock</button>
            </form>
            <form action="stfremainder.php">
                <button class="stfbtn" style="color: rgb(32, 32, 50);">Remainder</button>
            </form>
        </div>
            
        <div class="col-9">
            <?php
                if ($leaveResult->num_rows > 0) {
                    echo '<table class="leave-table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Name</th>';
                    echo '<th>Room No</th>';
                    echo '<th>From</th>';
                    echo '<th>To</th>';
                    echo '<th>Reason</th>';
                    echo '<th>Action</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    
                    while ($row = $leaveResult->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['student_name'] . '</td>';
                        echo '<td>' . $row['room_no'] . '</td>';
                        echo '<td>' . $row['from_date'] . '</td>';
                        echo '<td>' . $row['to_date'] . '</td>';
                        echo '<td>' . $row['reason'] . '</td>';
                        echo '<td>';
                        echo '<form method="POST" action="update_leave.php">';
                        echo '<input type="hidden" name="leave_id" value="' . $row['id'] . '">';
                        echo '<button type="submit" name="accept_leave" style="color:white; background-color: rgb(33, 33, 74);  ">Accept</button>';
                        echo '<button type="submit" name="reject_leave" style="color:white; background-color: rgb(33, 33, 74); margin-left: 2%; ">Reject</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo 'No leave requests found.';
                }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

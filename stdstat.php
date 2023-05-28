
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

// Fetch the name from the std_details table based on the std_id
$query = "SELECT name FROM std_details WHERE std_id = '$std_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Name found, fetch and store it in a variable
    $row = $result->fetch_assoc();
    $name = $row['name'];
} else {
    // Name not found, handle the error
    $name = "Unknown";
}

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
<body>
        <div class="row ">
            <div class="stdhead">
                <h3 class="stdtag">SaintgitsHostelMate</h3>
            </div>
        </div>
        <div class="row">
            <div class="stfreg1">
                <h3 class="stdtag">Leave Status</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <img src="icon1.png" class="img-fluid">
                <br>
                <h5 style="padding-left:29%; color: rgb(32, 32, 50); padding-top: 0%; font-weight: bold; background: whitesmoke;  " ><?php echo $name; ?></h5>

                <form action="stdhome.php">
                    <button class="stdbtn" style="color: rgb(32, 32, 50);">Home</button>
                </form>
                <form action="stdprofile.php">
                    <button class="stdbtn" style="color: rgb(32, 32, 50);">Profile</button>
                </form>
                <form action="stdleave.php">
                    <button class="stdbtn" style="color: rgb(32, 32, 50);">Apply Leave</button>
                </form>
                <form action="stdstat.php">
                    <button class="stdbtn" style="color: rgb(32, 32, 50);">Leave Status</button>
                </form>
            </div>
            <div class="col-9">
                <?php
                // Assuming you have established a database connection
                $conn = new mysqli('localhost', 'root', '', 'hostel');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch leave requests for the current student from the leave_requests table
                $query = "SELECT * FROM leave_history WHERE std_id = '$std_id'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    // Leave requests found, display them in a table
                    echo '<table class="leave-table">';
                    echo '<tr>';
                    echo '<th>From</th>';
                    echo '<th>To</th>';
                    echo '<th>Reason</th>';
                    echo '<th>Status</th>';
                    echo '</tr>';

                    while ($row = $result->fetch_assoc()) {
                        $fromDate = $row['from_date'];
                        $toDate = $row['to_date'];
                        $reason = $row['reason'];
                        $status = $row['status'];

                        echo '<tr>';
                        echo '<td>' . $fromDate . '</td>';
                        echo '<td>' . $toDate . '</td>';
                        echo '<td>' . $reason . '</td>';
                        echo '<td>' . $status . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    // No leave requests found
                    echo '<p>No leave requests found.</p>';
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>

        </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

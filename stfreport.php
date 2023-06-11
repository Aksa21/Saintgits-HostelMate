<?php
session_start();

// Retrieve the std_id from the session variable
$stf_id = $_SESSION['stf_id'];

// Assuming you have established a database connection
$conn = new mysqli('localhost', 'root', '', 'hostel');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the name from the staff_details table based on the stf_id
$query = "SELECT name,image FROM staff_details WHERE stf_id = '$stf_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Name found, fetch and store it in a variable
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $image1 = $row['image'];
} else {
    // Name not found, handle the error
    $name = "Unknown";
    $image1 ='';
}

// Get the current date
$currentDate = date('Y-m-d');

// Fetch the total absent count
$selectAbsentQuery = "SELECT COUNT(*) AS totalAbsent FROM attendance WHERE status = 'Absent' and date= '$currentDate'";
$absentResult = $conn->query($selectAbsentQuery);
$row = $absentResult->fetch_assoc();
$totalAbsent = $row['totalAbsent'];

// Fetch the total present count
$selectPresentQuery = "SELECT COUNT(*) AS totalPresent FROM attendance WHERE status = 'Present' and date= '$currentDate'";
$presentResult = $conn->query($selectPresentQuery);
$row = $presentResult->fetch_assoc();
$totalPresent = $row['totalPresent'];

// Fetch the not marked students' information
$query = "SELECT std_id, room_no, name, mob FROM std_details WHERE std_id IN (SELECT std_id FROM attendance WHERE date = '$currentDate' AND status!='Present' AND status!='Absent')";
$result1 = $conn->query($query);

// ...

// Check if a report for the current date already exists
$checkReportQuery = "SELECT id FROM report WHERE date = '$currentDate'";
$checkReportResult = $conn->query($checkReportQuery);

if ($checkReportResult->num_rows == 0) {
    // Insert the total absent and present counts into the report table if the report for the current date doesn't already exist
    $insertQuery = "INSERT INTO report (date, total_absent, total_present) VALUES ('$currentDate', '$totalAbsent', '$totalPresent')";
    $result2 = $conn->query($insertQuery);
} else {
    // Update the values of total absent and present for the current date
    $updateQuery = "UPDATE report SET total_absent = '$totalAbsent', total_present = '$totalPresent' WHERE date = '$currentDate'";
    $result2 = $conn->query($updateQuery);
}

// ...


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
            <h3 class="stdtag">Report</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <?php if (!empty($image1)) { ?>
                <img src="<?php echo $image1; ?>" class="img-fluid1">
            <?php }else{?>
                <img src="icon1.png" class="img-fluid1">
            <?php } ?>
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
            <br>
            <h4 style="color: rgb(33, 33, 74); padding-left: 35%; background-color: whitesmoke; font-weight:bold;"><?php echo "Report of ". $currentDate ?></h4>
            <br>
            <h6 style="color: rgb(33, 33, 74); padding-left: 5%; background-color: whitesmoke;  "><?php echo "Total Students Absent : " . $totalAbsent . "<br><br>";
                echo "Total Students Present : " . $totalPresent . "<br>";?>
            </h6> 
            <br>
            <br>
            <h5 style="color: rgb(33, 33, 74); padding-left: 5%; background-color: whitesmoke; font-weight: bold; ">Students whose attendance were not given :</h5>
            <br>

            <?php if ($result1->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Room No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result1->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['room_no']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['mob']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No students found.</p>
            <?php endif; ?>
            <br>
            <br>
            <h5 style="color: rgb(33, 33, 74); padding-left: 5%; background-color: whitesmoke; font-weight: bold; ">Meal Count :</h5>
            <br>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="Date">Date:</label>
                    <input type="date" class="form-control" id="Date" name="Date">
                </div>
                <button type="submit" style="color:white; margin-left: 40%; background-color: rgb(33, 33, 74); width: 15%; ">Submit</button>
            </form>
            <?php
                $conn = new mysqli('localhost', 'root', '', 'hostel');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['Date'])) {
                        $date = $_POST['Date'];
                
                        // Fetch the count of students with accepted leave on the given date
                        $vegLeaveQuery = "SELECT COUNT(*) AS veg_leave_count FROM leave_history l 
                                          INNER JOIN std_details s ON l.std_id = s.std_id
                                          WHERE '$date' >= l.from_date AND '$date' < l.to_date AND l.status = 'accepted' AND s.food_type='Veg'";
                
                        $vegLeaveResult = $conn->query($vegLeaveQuery);
                        $row = $vegLeaveResult->fetch_assoc();
                        $vegLeaveCount = $row['veg_leave_count'];
                
                        $nonVegLeaveQuery = "SELECT COUNT(*) AS nonveg_leave_count FROM leave_history l 
                                             INNER JOIN std_details s ON l.std_id = s.std_id
                                             WHERE '$date' >= l.from_date AND '$date' < l.to_date AND l.status = 'accepted' AND s.food_type='Non-Veg'";
                
                        $nonVegLeaveResult = $conn->query($nonVegLeaveQuery);
                        $row = $nonVegLeaveResult->fetch_assoc();
                        $nonVegLeaveCount = $row['nonveg_leave_count'];
                
                        $vegQuery = "SELECT COUNT(*) AS veg_count FROM std_details WHERE food_type='Veg'";
                        $vegResult = $conn->query($vegQuery);
                        $row = $vegResult->fetch_assoc();
                        $vegCount = $row['veg_count'];
                
                        $nonVegQuery = "SELECT COUNT(*) AS nonveg_count FROM std_details WHERE food_type='Non-Veg'";
                        $nonVegResult = $conn->query($nonVegQuery);
                        $row = $nonVegResult->fetch_assoc();
                        $nonVegCount = $row['nonveg_count'];
                
                        $totalVeg = $vegCount - $vegLeaveCount;
                        $totalNonVeg = $nonVegCount - $nonVegLeaveCount;
                
                        echo "<br><br/><p style=' color:  rgb(33, 33, 74); margin-left: 5% ' >Date: $date</p>";
                        echo "<p style=' color:  rgb(33, 33, 74); margin-left: 5% '>Number of students with non-veg meals: $totalNonVeg</p>";
                        echo "<p style=' color:  rgb(33, 33, 74); margin-left: 5% '>Number of students with veg meals: $totalVeg</p>";
                    } else {
                        echo "Date is not provided.";
                    }
                }
                
                $conn->close();
                ?>
                <br>
                <br>
                <form action="download_report.php" method="POST">
                    <input type="hidden" name="currentDate" value="<?php echo $currentDate; ?>">
                    <button type="submit" value="Download Report" style="color:white; margin-left: 40%; background-color: rgb(33, 33, 74); width: 25%; ">Download Daily Report</button>
                </form>
                <br>
                <br>
                <br>
                <form action="download_month.php" method="POST">
                    <input type="hidden" name="currentDate" value="<?php echo $currentDate; ?>">
                    <button type="submit" value="Download Report" style="color:white; margin-left: 40%; background-color: rgb(33, 33, 74); width: 25%; ">Download Monthly Report</button>
                </form>

        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
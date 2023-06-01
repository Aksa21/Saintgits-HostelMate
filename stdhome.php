
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
                <h3 class="stdtag" style="float: left;">SaintgitsHostelMate</h3>
                <a href="logout.php" style="color: white; float: right; margin-top: 10px; margin-right: 5%;"><u>Logout</u></a>
            </div>
        </div>
        <div class="row">
            <div class="stfreg1">
                <h3 class="stdtag">Home</h3>
            </div>
        </div>
        <div class="row no-gutters">
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
                <h2 style="padding-left:20%; color: rgb(32, 32, 50); padding-top: 20%; font-weight: bold; " >Welcome <?php echo $name; ?>,</h2>
            </div>
        </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

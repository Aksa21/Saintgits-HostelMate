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
$query = "SELECT * FROM staff_details WHERE stf_id = '$stf_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Name found, fetch and store it in a variable
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $gender = $row['gender'];
    $email = $row['email'];
    $mob = $row['mob'];
    $dob = $row['dob'];
    $address = $row['address'];
} else {
    // Name not found, handle the error
    $name = "Unknown";
    $gender = "";
    $email = "";
    $mob = "";
    $dob = "";
    $address = "";
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
            <h3 class="stdtag">Profile</h3>
        </div>
    </div>
    <div class="row no-gutters">
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
        <form class="regform1" action="update_profilestf.php" method="post">
        <br>
        <br>
        <div class="form-row">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $name; ?>" required readOnly>
        </div>


        <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>" required readOnly>
        </div>
        
        <div class="form-row">
            <label for="mob">Mobile:</label>
            <input type="text" name="mob" value="<?php echo $mob; ?>" required readOnly > 
        </div>
        
        <div class="form-row">
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo $dob; ?>" required readOnly>
        </div>
        
        <div class="form-row">
            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo $address; ?>" required readOnly>
        </div>
        <br><br>
        <button id="editBtn" style="color:white; margin-left: 45%; background-color: rgb(33, 33, 74); width: 15%; ">Edit</button>
        <button id="saveBtn" style="display: none; color:white; margin-left: 45%; background-color: rgb(33, 33, 74); width: 15%;  ">Save</button>
        
        </form>  
        </div>
    </div>
    <script>
    // Edit button click event
    document.getElementById("editBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent form submission

        var form = document.querySelector(".regform1");
        var fields = form.querySelectorAll("input, select");
        for (var i = 0; i < fields.length; i++) {
            fields[i].readOnly = false;
        }
        document.getElementById("editBtn").style.display = "none";
        document.getElementById("saveBtn").style.display = "block";
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
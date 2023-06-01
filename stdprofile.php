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
$query = "SELECT * FROM std_details WHERE std_id = '$std_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Name found, fetch and store it in a variable
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $room_no = $row['room_no'];
    $admission_no = $row['admission_no'];
    $program = $row['program'];
    $branch = $row['branch'];
    $guardian = $row['guardian'];
    $guardian_mob = $row['guardian_mob'];
    $address = $row['address'];
    $mob = $row['mob'];
    $dob = $row['dob'];
    $pin = $row['pin'];
    $email = $row['email'];
    $food_type = $row['food_type'];
} else {
    // Name not found, handle the error
    $name = "Unknown";
    $room_no = "";
    $admission_no = "";
    $program = "";
    $branch = "";
    $guardian = "";
    $guardian_mob = "";
    $address = "";
    $mob = "";
    $dob = "";
    $pin = "";
    $email = "";
    $food_type = "";
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
<div class="row ">
    <div class="col-3">
        <img src="icon1.png" class="img-fluid1">
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
        <form action="update_profilestd.php" method="POST">
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Room No.</th>
                    <td><input type="text" name="room_no" value="<?php echo $room_no; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Admission No.</th>
                    <td><input type="text" name="admission_no" value="<?php echo $admission_no; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Program</th>
                    <td><input type="text" name="program" value="<?php echo $program; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Branch</th>
                    <td><input type="text" name="branch" value="<?php echo $branch; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Guardian</th>
                    <td><input type="text" name="guardian" value="<?php echo $guardian; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Guardian Mobile</th>
                    <td><input type="text" name="guardian_mob" value="<?php echo $guardian_mob; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><input type="text" name="address" value="<?php echo $address; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td><input type="text" name="mob" value="<?php echo $mob; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td><input type="text" name="dob" value="<?php echo $dob; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Pin</th>
                    <td><input type="text" name="pin" value="<?php echo $pin; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="text" name="email" value="<?php echo $email; ?>" readonly></td>
                </tr>
                <tr>
                    <th>Food Type</th>
                    <td>
                        <select name="food_type" <?php if (isset($_POST['edit'])) echo "readonly"; ?>>
                            <option value="Veg" <?php if ($food_type == 'Veg') echo "selected"; ?>>Veg</option>
                            <option value="Non-Veg" <?php if ($food_type == 'Non-Veg') echo "selected"; ?>>Non-Veg</option>
                        </select>
                    </td>
                </tr>
            </table>
            <button id="editBtn" style="color:white; margin-left: 45%; background-color: rgb(33, 33, 74); width: 15%; ">Edit</button>
            <button id="saveBtn" style="display: none; color:white; margin-left: 45%; background-color: rgb(33, 33, 74); width: 15%;  ">Save</button>
        </form>
    </div>
    <script>
    // Edit button click event
    document.getElementById("editBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent form submission

        var form = document.querySelector(".table");
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
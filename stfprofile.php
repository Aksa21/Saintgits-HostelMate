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
    $image1 = $row['image'];
} else {
    // Name not found, handle the error
    $name = "Unknown";
    $gender = "";
    $email = "";
    $mob = "";
    $dob = "";
    $address = "";
    $image1 = '';
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
            <form id="profileForm" action="update_profilestf.php" method="post" enctype="multipart/form-data">
                <br>
                <br>
                <table class="table table-striped">
                    <tr>
                        <th>Name:</th>
                        <td>
                            <input type="text" name="name" value="<?php echo $name; ?>" required readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>
                            <input type="email" name="email" value="<?php echo $email; ?>" required readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>Mobile:</th>
                        <td>
                            <input type="text" name="mob" value="<?php echo $mob; ?>" required readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th>
                        <td>
                            <input type="date" name="dob" value="<?php echo $dob; ?>" required readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>
                            <input type="text" name="address" value="<?php echo $address; ?>" required readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>Photo:</th>
                        <td>
                            <input type="file" name="image" accept="image/*">
                            <?php if (!empty($image1)) { ?>
                                <br>
                                <img src="<?php echo $image1; ?>" style="height: 5%; width: 5%;">
                            <?php } ?>
                        </td>
                    </tr>
                </table>         
                <br><br>
                <button id="editBtn" type="button" style="color:white; margin-left: 45%; background-color: rgb(33, 33, 74); width: 15%;">Edit</button>
                <button id="saveBtn" type="submit" style="display: none; color:white; margin-left: 45%; background-color: rgb(33, 33, 74); width: 15%;">Save</button>
            </form>  
        </div>
    </div>
    <script>
    // Edit button click event
    document.getElementById("editBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent form submission

        var form = document.getElementById("profileForm");
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

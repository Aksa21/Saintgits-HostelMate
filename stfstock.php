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

// Retrieve the stock details from the stock table
$query = "SELECT stock_id, item_name, quantity FROM stock";
$result1 = $conn->query($query);

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
            <h3 class="stdtag">Stock</h3>
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
            <form method="post">
                <div class="button-container">
                    <button type="submit" name="viewStock">View Current Stock</button>
                    <button type="submit" name="addNewStock">Add New Stock</button>
                    <button type="submit" name="addExistingStock">Add To Existing Stock</button>
                    <button type="submit" name="removeStock">Remove Quantity</button>
                </div>
            </form>
            <br>
            <?php
                if (isset($_POST['viewStock'])) {
                    if ($result1->num_rows > 0) {
                        echo '
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Stock ID</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>';
                        // Loop through each row of the result set
                        while ($row = $result1->fetch_assoc()) {
                            $stockId = $row['stock_id'];
                            $itemName = $row['item_name'];
                            $quantity = $row['quantity'];

                            // Output the stock details in a table row
                            echo "<tr>";
                            echo "<td>$stockId</td>";
                            echo "<td>$itemName</td>";
                            echo "<td>$quantity</td>";
                            echo "</tr>";
                        }
                        echo '
                            </tbody>
                        </table>';
                    }
                } elseif (isset($_POST['addNewStock'])) {
                    // Display the form for adding new stock
                    echo '
                    <form method="post" class=regform>
                        <br><br>
                        <div class="form-row">
                        <label for="stockId">Stock ID:</label>
                        <input type="text" id="stockId" name="stockId" required>
                        </div>
                        <div class="form-row">
                        <label for="itemName">Item Name:</label>
                        <input type="text" id="itemName" name="itemName" required>
                        </div>
                        <div class="form-row">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" required>
                        </div>
                        <br><br>
                        <button type="submit" name="submitNewStock" style="color:white; margin-left: 40%; background-color: rgb(33, 33, 74); width: 15%; ">Submit</button>
                    </form>';
                } elseif (isset($_POST['submitNewStock'])) {
                    // Assuming you have established a database connection
                    $conn = new mysqli('localhost', 'root', '', 'hostel');
            
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    // Code to handle adding new stock when the form is submitted
                    $stockId = $_POST['stockId'];
                    $itemName = $_POST['itemName'];
                    $quantity = $_POST['quantity'];
                    
                    // Check if the stock ID already exists
                    $checkQuery = "SELECT stock_id FROM stock WHERE stock_id = '$stockId'";
                    $checkResult = $conn->query($checkQuery);
            
                    if ($checkResult->num_rows > 0) {
                        echo "Error adding stock: Stock ID already exists";
                    } else {
                        // Insert the new stock into the stock table
                        $insertQuery = "INSERT INTO stock (stock_id, item_name, quantity) VALUES ('$stockId', '$itemName', '$quantity')";
            
                        if ($conn->query($insertQuery) === TRUE) {
                            echo "Stock added successfully";
                        } else {
                            echo "Error adding stock: " . $conn->error;
                        }
                    }
                    // Close the database connection
                    $conn->close();
                } elseif (isset($_POST['addExistingStock'])) {
                    // Display the form for adding new stock
                    echo '
                    <form method="post" class=regform>
                        <br><br>
                        <div class="form-row">
                        <label for="stockId">Stock ID:</label>
                        <input type="text" id="stockId" name="stockId" required>
                        </div>
                        <div class="form-row">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" required>
                        </div>
                        <br><br>
                        <button type="submit" name="submitStock" style="color:white; margin-left: 40%; background-color: rgb(33, 33, 74); width: 15%; ">Submit</button>
                    </form>';
                } elseif (isset($_POST['submitStock'])) {
                    // Assuming you have established a database connection
                    $conn = new mysqli('localhost', 'root', '', 'hostel');
            
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    // Code to handle adding new stock when the form is submitted
                    $stockId = $_POST['stockId'];
                    $quantity = $_POST['quantity'];
                    
                    /// Check if the stock ID exists in the stock table
                    $checkQuery = "SELECT stock_id, quantity FROM stock WHERE stock_id = '$stockId'";
                    $checkResult = $conn->query($checkQuery);
                    
                    if ($checkResult->num_rows > 0) {
                        // Stock ID exists, update the quantity of the existing stock
                        $row = $checkResult->fetch_assoc();
                        $existingQuantity = $row['quantity'];
                
                        if ($existingQuantity === NULL) {
                            // If the existing quantity is NULL, set it to the new quantity
                            $updateQuery = "UPDATE stock SET quantity = '$quantity' WHERE stock_id = '$stockId'";
                        } else {
                            // If the existing quantity is not NULL, add the new quantity to it
                            $newQuantity = $existingQuantity + $quantity;
                            $updateQuery = "UPDATE stock SET quantity = '$newQuantity' WHERE stock_id = '$stockId'";
                        }
                
                        if ($conn->query($updateQuery) === TRUE) {
                            echo "Existing stock quantity updated successfully";
                        } else {
                            echo "Error updating existing stock quantity: " . $conn->error;
                        }
                    }  else {
                        // Stock ID does not exist, display an error message
                        echo "Error adding existing stock: Stock ID does not exist";
                    }
                    // Close the database connection
                    $conn->close();
                } elseif (isset($_POST['removeStock'])) {
                    // Display the form for adding new stock
                    echo '
                    <form method="post" class=regform>
                        <br><br>
                        <div class="form-row">
                        <label for="stockId">Stock ID:</label>
                        <input type="text" id="stockId" name="stockId" required>
                        </div>
                        <div class="form-row">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" required>
                        </div>
                        <br><br>
                        <button type="submit" name="subtractStock" style="color:white; margin-left: 40%; background-color: rgb(33, 33, 74); width: 15%; ">Submit</button>
                    </form>';
                } elseif (isset($_POST['subtractStock'])) {
                    // Assuming you have established a database connection
                    $conn = new mysqli('localhost', 'root', '', 'hostel');
                
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                
                    // Code to handle removing stock quantity when the form is submitted
                    $stockId = $_POST['stockId'];
                    $quantity = $_POST['quantity'];
                
                    // Check if the stock ID exists in the stock table
                    $checkQuery = "SELECT stock_id, quantity FROM stock WHERE stock_id = '$stockId'";
                    $checkResult = $conn->query($checkQuery);
                
                    if ($checkResult->num_rows > 0) {
                        // Stock ID exists, update the quantity of the existing stock
                        $row = $checkResult->fetch_assoc();
                        $existingQuantity = $row['quantity'];
                
                        if ($existingQuantity === NULL) {
                            echo "Error removing stock quantity: Stock ID exists but quantity is NULL";
                        } else {
                            // Check if the quantity to be removed is greater than the existing quantity
                            if ($quantity > $existingQuantity) {
                                echo "Error removing stock quantity: Quantity to be removed exceeds the existing quantity";
                            } else {
                                // Calculate the new quantity after removing
                                $newQuantity = $existingQuantity - $quantity;
                
                                // Update the stock quantity
                                $updateQuery = "UPDATE stock SET quantity = '$newQuantity' WHERE stock_id = '$stockId'";
                
                                if ($conn->query($updateQuery) === TRUE) {
                                    echo "Stock quantity removed successfully";
                                } else {
                                    echo "Error removing stock quantity: " . $conn->error;
                                }
                            }
                        }
                    } else {
                        // Stock ID does not exist, display an error message
                        echo "Error removing stock quantity: Stock ID does not exist";
                    }
                
                    // Close the database connection
                    $conn->close();
                }
                
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

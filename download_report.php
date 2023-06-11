<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have established a database connection
    $conn = new mysqli('localhost', 'root', '', 'hostel');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the current date from the POST data
    $currentDate = $_POST['currentDate'];

    // Function to generate and download the attendance report
    function downloadAttendanceReport($conn, $currentDate)
    {
        // Fetch the student details and their attendance status for the given date
        $query = "SELECT std_details.room_no, std_details.name, attendance.status FROM std_details
              INNER JOIN attendance ON std_details.std_id = attendance.std_id
              WHERE attendance.date = '$currentDate'";
        $result = $conn->query($query);

        // Create a CSV file and write the data into it
        $filename = "attendance_report_$currentDate.csv";
        $file = fopen($filename, 'w');
        fputcsv($file, ['Room_no','Name', 'Attendance Status']);

        while ($row = $result->fetch_assoc()) {
            fputcsv($file, [$row['room_no'], $row['name'], $row['status']]);
        }
        fclose($file);

        // Set appropriate headers for the download
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Read the file and output it to the browser
        readfile($filename);

        // Remove the temporary file
        unlink($filename);
    }

    // Call the function to download the attendance report
    downloadAttendanceReport($conn, $currentDate);

    $conn->close();
} else {
    // Redirect to the main page if accessed directly
    header("Location: index.php");
    exit();
}

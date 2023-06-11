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

    // Function to generate and download the monthly attendance report
    function downloadMonthlyReport($conn, $currentDate)
    {
        // Extract the year and month from the current date
        $year = date('Y', strtotime($currentDate));
        $month = date('m', strtotime($currentDate));

        // Get the total number of days in the given month
        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Fetch the student details and their attendance for the given month
        $query = "SELECT std_details.room_no, std_details.name, attendance.date, attendance.status
                  FROM std_details
                  LEFT JOIN attendance ON std_details.std_id = attendance.std_id AND
                                         YEAR(attendance.date) = '$year' AND MONTH(attendance.date) = '$month'
                  ORDER BY std_details.room_no, std_details.name, attendance.date";
        $result = $conn->query($query);

        // Create a CSV file and write the data into it
        $filename = "monthly_report_$year-$month.csv";
        $file = fopen($filename, 'w');

        // Generate the column headers with the dates of the month
        $columnHeaders = ['Room No', 'Name'];
        for ($day = 1; $day <= $numDays; $day++) {
            $columnHeaders[] = $day;
        }
        fputcsv($file, $columnHeaders);

        $previousRoomNo = null;
        $previousName = null;
        $attendanceData = array_fill(1, $numDays, ''); // Initialize the attendance data array

        while ($row = $result->fetch_assoc()) {
            $roomNo = $row['room_no'];
            $name = $row['name'];
            $date = date('j', strtotime($row['date']));
            $status = $row['status'];

            // Check if the student or room has changed
            if ($previousRoomNo !== $roomNo || $previousName !== $name) {
                // Write the attendance data for the previous student or room
                if ($previousRoomNo !== null && $previousName !== null) {
                    fputcsv($file, array_merge([$previousRoomNo, $previousName], $attendanceData));
                }

                // Reset the attendance data for the new student or room
                $attendanceData = array_fill(1, $numDays, '');
            }

            // Update the attendance data array with the status for the corresponding date
            if (!empty($date)) {
                $attendanceData[$date] = $status;
            }

            $previousRoomNo = $roomNo;
            $previousName = $name;
        }

        // Write the attendance data for the last student or room
        if ($previousRoomNo !== null && $previousName !== null) {
            fputcsv($file, array_merge([$previousRoomNo, $previousName], $attendanceData));
        }

        fclose($file);
        // Set appropriate headers for file download
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Read the file and output its contents
        readfile($filename);

        // Delete the file from the server
        unlink($filename);
    }
    // Call the function to generate and download the monthly attendance report
    downloadMonthlyReport($conn, $currentDate);
        
    // Close the database connection
    $conn->close();
    }    
    
?>
        
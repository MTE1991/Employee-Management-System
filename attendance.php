<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set PHP timezone
date_default_timezone_set('Asia/Dhaka');

// Connect to the database
$mysqli = new mysqli("localhost", "admin", "2002", "empDB");

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Set MySQL timezone
$mysqli->query("SET time_zone = '+06:00'");

// Initialize variables
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeName = $_POST['employee_name'];
    $action = $_POST['action'];
    
    // Get current date and time
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');

    // Find EmployeeID based on Employee Name
    $nameParts = explode(' ', $employeeName);
    $firstName = $nameParts[0];
    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

    $query = "SELECT EmployeeID, ShiftID FROM Employee WHERE FirstName = ? AND LastName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employeeID = $row['EmployeeID'];
        $shiftID = $row['ShiftID'];

        if ($action === 'check_in') {
            // Insert a new attendance record
            $insertQuery = "INSERT INTO Attendance (EmployeeID, ShiftID, Datetime, CheckInTime, Status, WorkingHours) 
                            VALUES (?, ?, ?, ?, 'Present', 0)";
            $stmt = $mysqli->prepare($insertQuery);
            $stmt->bind_param("iiss", $employeeID, $shiftID, $currentDate, $currentTime);
            if ($stmt->execute()) {
                $message = "Check-in successful for $employeeName at $currentTime.";
            } else {
                $message = "Error: " . $mysqli->error;
            }
        } elseif ($action === 'check_out') {
            // Update the existing attendance record with CheckOutTime and calculate WorkingHours
            $updateQuery = "UPDATE Attendance 
                SET CheckOutTime = ?, 
                    WorkingHours = TIMESTAMPDIFF(MINUTE, CONCAT(Datetime, ' ', CheckInTime), CONCAT(Datetime, ' ', ?)) / 60
                WHERE EmployeeID = ? AND Datetime = ?";
            $stmt = $mysqli->prepare($updateQuery);
            $stmt->bind_param("ssis", $currentTime, $currentTime, $employeeID, $currentDate);
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $message = "Check-out successful for $employeeName at $currentTime.";
            } else {
                $message = "Error: Could not check out. Have you checked in today?";
            }
        }
    } else {
        $message = "Employee not found. Please check the name.";
    }
    $stmt->close();
}
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Attendance Management</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="attendance.php" method="POST">
            <div>
                <label for="employee_name">Employee Name:</label>
                <input type="text" id="employee_name" name="employee_name" placeholder="Enter Full Name" required>
            </div>
            <div>
                <button type="submit" name="action" value="check_in" class="button">Check In</button>
                <button type="submit" name="action" value="check_out" class="button">Check Out</button>
            </div>
        </form>
    </div>
</body>
</html>

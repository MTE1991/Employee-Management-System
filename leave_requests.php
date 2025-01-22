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

// Initialize variables
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeName = $_POST['employee_name'];
    $leaveType = $_POST['leave_type'];
    $startDate = $_POST['start_date']; // YYYY-MM-DD format from input
    $endDate = $_POST['end_date']; // YYYY-MM-DD format from input
    $reason = $_POST['reason'];

    // Find EmployeeID based on Employee Name
    $nameParts = explode(' ', $employeeName);
    $firstName = $nameParts[0];
    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

    $query = "SELECT EmployeeID FROM Employee WHERE FirstName = ? AND LastName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employeeID = $row['EmployeeID'];

        // Insert leave request into EmployeeLeave table
        $insertQuery = "INSERT INTO EmployeeLeave (EmployeeID, LeaveType, StartDate, EndDate, LeaveStatus, Reason)
                        VALUES (?, ?, ?, ?, 'Pending', ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $stmt->bind_param("issss", $employeeID, $leaveType, $startDate, $endDate, $reason);

        if ($stmt->execute()) {
            $message = "Leave request submitted successfully.";
        } else {
            $message = "Error: " . $mysqli->error;
        }
    } else {
        $message = "Employee not found. Please check the name.";
    }
    $stmt->close();
}

// Fetch leave applications for display
$leaveApplications = [];
if (!empty($_GET['employee_name'])) {
    $employeeName = $_GET['employee_name'];
    $nameParts = explode(' ', $employeeName);
    $firstName = $nameParts[0];
    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

    $query = "SELECT EL.EmployeeID, EL.LeaveType, EL.StartDate, EL.EndDate, EL.LeaveStatus, EL.Reason 
              FROM EmployeeLeave AS EL
              JOIN Employee AS E ON EL.EmployeeID = E.EmployeeID
              WHERE E.FirstName = ? AND E.LastName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $leaveApplications[] = $row;
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
    <title>Leave Requests</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Leave Requests</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        
        <!-- Form to Apply for Leave -->
        <h2>Apply for Leave</h2>
        <form action="leave_requests.php" method="POST">
            <div>
                <label for="employee_name">Employee Name:</label>
                <input type="text" id="employee_name" name="employee_name" placeholder="Enter Full Name" required>
            </div>
            <br>
            <div>
                <label for="leave_type">Leave Type:</label>
                <select id="leave_type" name="leave_type" required>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Casual Leave">Casual Leave</option>
                    <option value="Paid Leave">Paid Leave</option>
                </select>
            </div>
            <br>
            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <br>
            <div>
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <br>
            <div>
                <label for="reason">Reason:</label>
                <br>
                <textarea id="reason" name="reason" required></textarea>
            </div>
            <br>
            <button type="submit" class="button">Submit Leave Request</button>
        </form>
        
        <!-- Display Leave Applications -->
        <h2>View Leave Applications</h2>
        <form action="leave_requests.php" method="GET">
            <div>
                <label for="employee_name_view">Employee Name:</label>
                <input type="text" id="employee_name_view" name="employee_name" placeholder="Enter Full Name" required>
                <button type="submit" class="button">View Leaves</button>
            </div>
        </form>

        <?php if (!empty($leaveApplications)): ?>
            <table border="1">
                <tr>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Reason</th>
                </tr>
                <?php foreach ($leaveApplications as $leave): ?>
                    <tr>
                        <td><?php echo $leave['LeaveType']; ?></td>
                        <td><?php echo $leave['StartDate']; ?></td>
                        <td><?php echo $leave['EndDate']; ?></td>
                        <td><?php echo $leave['LeaveStatus']; ?></td>
                        <td><?php echo $leave['Reason']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (isset($_GET['employee_name'])): ?>
            <p>No leave applications found for the given employee.</p>
        <?php endif; ?>
    </div>
</body>
</html>

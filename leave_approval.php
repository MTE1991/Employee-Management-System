<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Restrict access for non-admin users
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    header('Location: index.php'); // Redirect to homepage or another page
    exit;
}

// Connect to the database
$mysqli = new mysqli("localhost", "admin", "2002", "empDB");

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle Leave Approval or Rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeID = $_POST['employee_id'];
    $startDate = $_POST['start_date'];
    $leaveStatus = $_POST['leave_status'];

    // Update the EmployeeLeave table with the new status
    $query = "UPDATE EmployeeLeave SET LeaveStatus = ? WHERE EmployeeID = ? AND StartDate = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sis", $leaveStatus, $employeeID, $startDate);

    if ($stmt->execute()) {
        $message = "Leave request has been " . strtolower($leaveStatus) . ".";
    } else {
        $message = "Error: Could not update leave request. " . $mysqli->error;
    }
    $stmt->close();
}

// Fetch pending leave requests
$query = "SELECT e.FirstName, e.LastName, el.EmployeeID, el.LeaveType, el.StartDate, el.EndDate, el.Reason 
          FROM EmployeeLeave el 
          JOIN Employee e ON el.EmployeeID = e.EmployeeID
          WHERE el.LeaveStatus = 'Pending'";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Approval</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Leave Approval</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['FirstName'] . " " . $row['LastName']; ?></td>
                            <td><?php echo $row['LeaveType']; ?></td>
                            <td><?php echo $row['StartDate']; ?></td>
                            <td><?php echo $row['EndDate']; ?></td>
                            <td><?php echo $row['Reason']; ?></td>
                            <td>
                                <form action="leave_approval.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="employee_id" value="<?php echo $row['EmployeeID']; ?>">
                                    <input type="hidden" name="start_date" value="<?php echo $row['StartDate']; ?>">
                                    <button type="submit" name="leave_status" value="Approved" class="button">Approve</button>
                                </form>
                                <form action="leave_approval.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="employee_id" value="<?php echo $row['EmployeeID']; ?>">
                                    <input type="hidden" name="start_date" value="<?php echo $row['StartDate']; ?>">
                                    <button type="submit" name="leave_status" value="Rejected" class="button">Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pending leave requests.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$mysqli->close();
?>

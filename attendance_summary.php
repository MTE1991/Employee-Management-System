<?php
// Database connection
$servername = "localhost";
$username = "mtekleel";
$password = "2002";
$database = "empDB";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch attendance data
$query = "
    SELECT 
        A.EmployeeID,
        E.FirstName,
        E.LastName,
        A.ShiftID,
        A.Datetime,
        A.CheckInTime,
        A.CheckOutTime,
        A.Status,
        A.WorkingHours
    FROM Attendance A
    JOIN Employee E ON A.EmployeeID = E.EmployeeID
    ORDER BY A.Datetime DESC
";

$result = $conn->query($query);

if (!$result) {
    die("Error fetching attendance data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Summary</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Attendance Summary</h1>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Shift ID</th>
                <th>Date</th>
                <th>Check-In Time</th>
                <th>Check-Out Time</th>
                <th>Status</th>
                <th>Working Hours</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['EmployeeID']; ?></td>
                    <td><?php echo $row['FirstName']; ?></td>
                    <td><?php echo $row['LastName']; ?></td>
                    <td><?php echo $row['ShiftID']; ?></td>
                    <td><?php echo $row['Datetime']; ?></td>
                    <td><?php echo $row['CheckInTime']; ?></td>
                    <td><?php echo $row['CheckOutTime']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td><?php echo $row['WorkingHours']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>

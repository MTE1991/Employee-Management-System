<link rel="stylesheet" type="text/css" href="styles.css">

<?php
// Error Reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "admin";
$password = "2002"; // Replace with your actual password
$database = "empDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get shift data
$shift_sql = "SELECT * FROM Shift";
$shift_result = $conn->query($shift_sql);

// Display shift data
echo "<h2>Shift Data</h2>";
if ($shift_result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Shift ID</th>
                <th>Shift Name</th>
                <th>Starts At</th>
                <th>Ends At</th>
                <th>Length (hours)</th>
            </tr>";
    while($row = $shift_result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["ShiftID"] . "</td>
                <td>" . $row["ShiftName"] . "</td>
                <td>" . $row["StartTime"] . "</td>
                <td>" . $row["EndTime"] . "</td>
                <td>" . $row["ShiftDuration"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No shift records found.";
}

// Close the connection
$conn->close();
?>

<br><a href="index.php" class="button">Back to Home</a>

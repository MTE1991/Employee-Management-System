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
$shift_sql = "SELECT * FROM Department";
$shift_result = $conn->query($shift_sql);

// Display shift data
echo "<h2>Departments</h2>";
if ($shift_result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Department</th>
                <th>Manager ID</th>
            </tr>";
    while($row = $shift_result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["DepartmentName"] . "</td>
                <td>" . $row["ManagerID"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No department records found.";
}

// Close the connection
$conn->close();
?>

<br><a href="index.php" class="button">Back to Home</a>

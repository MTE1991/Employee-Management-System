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

// Get the employee ID from the query string
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Query to get shift data for the specific employee
    $shift_sql = "SELECT * FROM Shift NATURAL JOIN Employee WHERE EmployeeID = $employee_id";
    $shift_result = $conn->query($shift_sql);

    // Check if any shift data exists for the employee
    echo "<!DOCTYPE html><html lang='en'><head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Shift Data for Employee $employee_id</title>
            <link rel='stylesheet' type='text/css' href='styles.css'>
          </head><body>";

    echo "<h2>Shift Data for Employee ID: $employee_id</h2>";

    if ($shift_result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Employee ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Shift Name</th>
                    <th>Starts At</th>
                    <th>Ends At</th>
                    <th>Length (hours)</th>
                </tr>";
        while($row = $shift_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["EmployeeID"] . "</td>
                    <td>" . $row["FirstName"] . "</td>
                    <td>" . $row["LastName"] . "</td>
                    <td>" . $row["ShiftName"] . "</td>
                    <td>" . $row["StartTime"] . "</td>
                    <td>" . $row["EndTime"] . "</td>
                    <td>" . $row["ShiftDuration"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No shift records found for this employee.";
    }

    // Close the connection
    $conn->close();

} else {
    echo "Please provide a valid employee ID.";
}
?>

<br><a href="index.php" class="button">Back to Home</a>
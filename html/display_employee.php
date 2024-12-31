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

// Query to get employee data
$employee_sql = "SELECT * FROM Employee";
$employee_result = $conn->query($employee_sql);

// Display employee data
echo "<h2>Employee Data</h2>";
if ($employee_result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name
                <th>Position</th>
            </tr>";
    while($row = $employee_result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["EmployeeID"] . "</td>
                <td>" . $row["FirstName"] . "</td>
                <td>" . $row["LastName"] . "</td>
                <td>" . $row["Position"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No employee records found.";
}

// Close the connection
$conn->close();
?>

<br><a href="index.php" class="button">Back to Home</a>

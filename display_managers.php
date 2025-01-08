<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "mtekleel";
$password = "2002"; // Replace with your actual password
$database = "empDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the managers for each department
$sql = "SELECT DepartmentName, ManagerID, FirstName, LastName 
        FROM Employee JOIN Department
        ON Employee.EmployeeID = Department.ManagerID
        ";

$result = $conn->query($sql);

echo "<!DOCTYPE html><html lang='en'><head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Managers by Department</title>
        <link rel='stylesheet' type='text/css' href='styles.css'>
      </head><body>";

echo "<div class='container'>
        <h1>Managers by Department</h1>";

// Check if the query returned any results
if ($result->num_rows > 0) {
    $current_department = null;
    
    while ($row = $result->fetch_assoc()) {
        // If department has changed, display a new section for the department
        if ($current_department != $row["DepartmentName"]) {
            if ($current_department != null) {
                echo "</ul>"; // Close previous department's list
            }
            $current_department = $row["DepartmentName"];
            echo "<h2>Department: $current_department</h2>";
            echo "<ul>";
        }

        // Display manager's name
        echo "<li>" . $row["FirstName"] . " " . $row["LastName"] . "</li>";
    }
    echo "</ul>"; // Close the last department's list
} else {
    echo "<p>No managers found in any department.</p>";
}

// Close the connection
$conn->close();

echo "<br><a href='index.php' class='button'>Back to Home</a></div></body></html>";
?>

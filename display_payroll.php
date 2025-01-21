<?php
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeID = $_POST['employeeID'];
    $sql = "SELECT e.FirstName, e.LastName, e.Position,
                 p.SalaryMonth, p.BasicSalary, p.Bonus, 
                 p.Deductions, p.NetSalary, p.PaymentDate
            FROM Payroll p
            JOIN Employee e ON p.EmployeeID = e.EmployeeID
            WHERE e.EmployeeID = $employeeID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $salaryData = $result->fetch_assoc();
    } else {
        $salaryData = null;
    }
}

echo "<!DOCTYPE html><html lang='en'><head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Employee Salary Details</title>
        <link rel='stylesheet' type='text/css' href='styles.css'>
      </head><body>";

echo "<div class='container'>
        <h1>Salary Details for Employee</h1>
        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>
            <label for='employeeID'>Enter Employee ID:</label>
            <input type='number' id='employeeID' name='employeeID' required>
            <button type='submit' class='button'>View Salary</button>
        </form>";

if (isset($salaryData)) {
    if ($salaryData) {
        echo "<h2>Salary Details for Employee ID: $employeeID</h2>
              <table>
                <tr><th>First Name</th><td>" . $salaryData['FirstName'] . "</td></tr>
                <tr><th>Last Name</th><td>" . $salaryData['LastName'] . "</td></tr>
                <tr><th>Position</th><td>" . $salaryData['Position'] . "</td></tr>
                <tr><th>Salary Month</th><td>" . $salaryData['SalaryMonth'] . "</td></tr>
                <tr><th>Basic Salary</th><td>" . $salaryData['BasicSalary'] . "</td></tr>
                <tr><th>Bonus</th><td>" . $salaryData['Bonus'] . "</td></tr>
                <tr><th>Deductions</th><td>" . $salaryData['Deductions'] . "</td></tr>
                <tr><th>Net Salary</th><td>" . $salaryData['NetSalary'] . "</td></tr>
                <tr><th>Payment Date</th><td>" . $salaryData['PaymentDate'] . "</td></tr>
              </table>";
    } else {
        echo "<p>No salary record found for Employee ID: $employeeID</p>";
    }
}

echo "<br><a href='index.php' class='button'>Back to Home</a></div></body></html>";

$conn->close();
?>

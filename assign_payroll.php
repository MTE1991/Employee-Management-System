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

$servername = "localhost";
$username = "admin"; // Replace with your username
$password = "2002"; // Replace with your password
$database = "empDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeID = intval($_POST['employeeID']);
    $salaryMonth = $conn->real_escape_string($_POST['monthlySalary']);
    $bonus = floatval($_POST['bonus']);
    $deductions = floatval($_POST['deductions']);
    $paymentDate = $conn->real_escape_string($_POST['paymentDate']);

    // Fetch the basic salary from the Employee table
    $result = $conn->query("SELECT Salary FROM Employee WHERE EmployeeID = $employeeID");
    if ($result && $row = $result->fetch_assoc()) {
        $expectedSalary = floatval($row['Salary']);
        $basicSalary = floatval($_POST['basicSalary']);

        // Validate that the Basic Salary matches the stored Salary
        if ($basicSalary !== $expectedSalary) {
            die("Error: Basic Salary does not match the employee's monthly salary.");
        }

        $netSalary = $basicSalary + $bonus - $deductions;

        // Insert data into the Payroll table
        $sql = "INSERT INTO Payroll (EmployeeID, SalaryMonth, BasicSalary, Bonus, Deductions, NetSalary, PaymentDate)
                VALUES ($employeeID, '$salaryMonth', $basicSalary, $bonus, $deductions, $netSalary, '$paymentDate')";

        if ($conn->query($sql) === TRUE) {
            $message = "Payroll assigned successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Error: Employee not found!";
    }
}

// Fetch Employee table data
$employee_result = $conn->query("SELECT EmployeeID, FirstName, LastName, Position, Salary FROM Employee");

if (!$employee_result) {
    die("Error fetching Employee data: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Payroll</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Function to update Basic Salary based on Employee selection
        function updateSalary() {
            const employeeSelect = document.getElementById('employeeID');
            const basicSalaryInput = document.getElementById('basicSalary');
            const monthlySalaryInput = document.getElementById("monthlySalary");
            const salaryData = JSON.parse(employeeSelect.options[employeeSelect.selectedIndex].dataset.salary);
            basicSalaryInput.value = salaryData;
            monthlySalaryInput.value = salaryData;
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Assign Payroll to Employee</h1>
    <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="employeeID">Employee:</label>
        <select id="employeeID" name="employeeID" required onchange="updateSalary()">
            <option value="" disabled selected>Select an Employee</option>
            <?php while ($row = $employee_result->fetch_assoc()): ?>
                <option value="<?php echo $row['EmployeeID']; ?>" data-salary="<?php echo $row['Salary']; ?>">
                    <?php echo $row['FirstName'] . " " . $row['LastName'] . " - " . $row['Position']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="basicSalary">Basic Salary:</label>
        <input type="number" id="basicSalary" name="basicSalary" required><br>

        <label for="monthlySalary">Monthly Salary:</label>
        <input type="number" id="monthlySalary" name="monthlySalary" readonly required><br>
        
        <label for="bonus">Bonus:</label>
        <input type="number" step="0.01" id="bonus" name="bonus"><br>
        
        <label for="deductions">Deductions:</label>
        <input type="number" step="0.01" id="deductions" name="deductions"><br>
        
        <label for="paymentDate">Payment Date:</label>
        <input type="date" id="paymentDate" name="paymentDate" required><br>
        
        <button type="submit" class="button">Assign Payroll</button>
        <a href="index.php" class="button">Back to Home</a>
    </form>
    <br>
    <h2>Employees with unassigned Payroll</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Basic Salary</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Re-fetch employee data for display
            $employee_result = $conn->query(
                "SELECT E.EmployeeID, E.FirstName, E.LastName, E.Position, E.Salary
                FROM Employee E
                LEFT JOIN Payroll P ON E.EmployeeID = P.EmployeeID
                WHERE P.PayrollID IS NULL
            ");
            while ($row = $employee_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['EmployeeID']; ?></td>
                    <td><?php echo $row['FirstName']; ?></td>
                    <td><?php echo $row['LastName']; ?></td>
                    <td><?php echo $row['Position']; ?></td>
                    <td><?php echo $row['Salary']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
</div>
</body>
</html>

<?php 
$conn->close();
?>

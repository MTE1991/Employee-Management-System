<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);
    $dateOfBirth = $conn->real_escape_string($_POST['dateOfBirth']);
    $hireDate = $conn->real_escape_string($_POST['hireDate']);
    $position = $conn->real_escape_string($_POST['position']);
    $salary = $conn->real_escape_string($_POST['salary']);
    $departmentID = intval($_POST['departmentID']);
    $shiftID = intval($_POST['shiftID']);

    // Insert data into the Employee table
    $sql = "INSERT INTO Employee (FirstName, LastName, Email, PhoneNumber, DateOfBirth, HireDate, Position, Salary, DepartmentID, ShiftID) 
            VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$dateOfBirth', '$hireDate', '$position', '$salary', $departmentID, $shiftID)";

    if ($conn->query($sql) === TRUE) {
        $message = "New employee added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch Shift table data
$shift_result = $conn->query("SELECT * FROM Shift");
if (!$shift_result) {
    die("Error fetching Shift data: " . $conn->error);
}

// Fetch Department data
$dept_result = $conn->query("SELECT * FROM Department ORDER BY DepartmentID");
if (!$dept_result) {
    die("Error fetching Department data: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Add New Employee</h1>
    <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required><br>
        
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br>
        
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>
        
        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber"><br>
        
        <label for="dateOfBirth">Date of Birth:</label>
        <input type="date" id="dateOfBirth" name="dateOfBirth" required><br>
        
        <label for="hireDate">Hire Date:</label>
        <input type="date" id="hireDate" name="hireDate" required><br>
        
        <label for="position">Position:</label>
        <input type="text" id="position" name="position" required><br>
        
        <label for="salary">Salary:</label>
        <input type="number" step="0.01" id="salary" name="salary" required><br>
        
        <label for="departmentID">Department ID:</label>
        <input type="number" id="departmentID" name="departmentID" required><br>
        
        <label for="shiftID">Shift ID:</label>
        <input type="number" id="shiftID" name="shiftID" required><br>
        
        <button type="submit" class="button">Add Employee</button>
        <a href="index.php" class="button">Back to Home</a>
    </form>
    <br>
    <h2>Available Shifts</h2>
    <table>
        <thead>
            <tr>
                <th>Shift ID</th>
                <th>Shift Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $shift_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['ShiftID']; ?></td>
                    <td><?php echo $row['ShiftName']; ?></td>
                    <td><?php echo $row['StartTime']; ?></td>
                    <td><?php echo $row['EndTime']; ?></td>
                    <td><?php echo $row['ShiftDuration']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h2>Departments</h2>
    <table>
        <thead>
            <tr>
                <th>Department ID</th>
                <th>Department Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $dept_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['DepartmentID']; ?></td>
                    <td><?php echo $row['DepartmentName']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

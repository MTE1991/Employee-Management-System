<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Employee and Shift Data</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Welcome to the Employee Management System</h1>
    <p><h2>Select an option to view the data</h2></p>
    <a href="display_employee.php" class="button">View Employee Data</a>
    <a href="display_shift.php" class="button">View Shift Data</a>
    <a href="display_dept.php" class="button">View Departments</a>
    
    <!-- Form to select employee and view their shift data -->
    <h2>View Shift Data for a Specific Employee</h2>
    <form action="display_emp_shift.php" method="GET">
        <input type="number" name="employee_id" placeholder="Enter Employee ID" required min="1">
        <button type="submit" class="button">View Shift Data for Employee</button>
    </form>

    <!-- View the managers of each department -->
    <a href="display_managers.php" class="button">View Managers by Department</a>
</div>

</body>
</html>

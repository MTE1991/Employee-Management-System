-- 1. Leave Requests
SELECT EmployeeID FROM Employee WHERE FirstName = ? AND LastName = ?;

INSERT INTO EmployeeLeave (EmployeeID, LeaveType, StartDate, EndDate, LeaveStatus, Reason)
VALUES (?, ?, ?, ?, 'Pending', ?);

SELECT EL.EmployeeID, EL.LeaveType, EL.StartDate, EL.EndDate, EL.LeaveStatus, EL.Reason 
FROM EmployeeLeave AS EL
JOIN Employee AS E ON EL.EmployeeID = E.EmployeeID
WHERE E.FirstName = ? AND E.LastName = ?;

-- 2. Leave Approval
UPDATE EmployeeLeave SET LeaveStatus = ? WHERE EmployeeID = ? AND StartDate = ?;

SELECT e.FirstName, e.LastName, el.EmployeeID, el.LeaveType, el.StartDate, el.EndDate, el.Reason 
FROM EmployeeLeave el 
JOIN Employee e ON el.EmployeeID = e.EmployeeID
WHERE el.LeaveStatus = 'Pending';

-- 3. Display Shift
SELECT * FROM Shift;

-- 4. Display Payroll
SELECT e.FirstName, e.LastName, e.Position,
        p.BasicSalary, p.Bonus, 
        p.Deductions, p.NetSalary, p.PaymentDate
FROM Payroll p
JOIN Employee e ON p.EmployeeID = e.EmployeeID
WHERE e.EmployeeID = $employeeID;

-- 5. Display Managers
SELECT DepartmentName, ManagerID, FirstName, LastName 
FROM Employee JOIN Department
ON Employee.EmployeeID = Department.ManagerID;

-- 6. Display Employee Infos
SELECT * FROM Employee;

-- 7. Display Shift of an Employee
SELECT * FROM Shift NATURAL JOIN Employee WHERE EmployeeID = $employee_id;

-- 8. Display the Departments
SELECT * FROM Department;

-- 9. Attendance entry
SELECT EmployeeID, ShiftID FROM Employee WHERE FirstName = ? AND LastName = ?;

SELECT * FROM Attendance WHERE EmployeeID = ? AND Datetime = ?;

INSERT INTO Attendance (EmployeeID, ShiftID, Datetime, CheckInTime, Status, WorkingHours) 
VALUES (?, ?, ?, ?, 'Present', 0);

UPDATE Attendance 
SET CheckOutTime = ?, WorkingHours = TIMESTAMPDIFF(MINUTE, CONCAT(Datetime, ' ', CheckInTime), CONCAT(Datetime, ' ', ?)) / 60
WHERE EmployeeID = ? AND Datetime = ?;

-- 10. Attendance Summary
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
ORDER BY A.CheckOutTime DESC;

-- 11. Assigning Payroll
SELECT Salary FROM Employee WHERE EmployeeID = $employeeID;

INSERT INTO Payroll (EmployeeID, SalaryMonth, BasicSalary, Bonus, Deductions, NetSalary, PaymentDate)
VALUES ($employeeID, '$salaryMonth', $basicSalary, $bonus, $deductions, $netSalary, '$paymentDate');

-- 12. Displaying Employees with unassigned Payroll info
SELECT E.EmployeeID, E.FirstName, E.LastName, E.Position, E.Salary
FROM Employee E
LEFT JOIN Payroll P ON E.EmployeeID = P.EmployeeID
WHERE P.PayrollID IS NULL;

-- 13. Adding new Employee info
INSERT INTO Employee (FirstName, LastName, Email, PhoneNumber, DateOfBirth, HireDate, Position, Salary, DepartmentID, ShiftID) 
VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$dateOfBirth', '$hireDate', '$position', '$salary', $departmentID, $shiftID);

SELECT * FROM Shift;
SELECT * FROM Department ORDER BY DepartmentID;


CREATE TABLE EmployeeLeave (
    EmployeeID INT,
    LeaveType VARCHAR(20),
    StartDate TIMESTAMP,
    EndDate TIMESTAMP,
    LeaveStatus VARCHAR(20),
    Reason TEXT,
    PRIMARY KEY (EmployeeID, StartDate),
    FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID)
);

INSERT INTO EmployeeLeave (EmployeeID, LeaveType, StartDate, EndDate, LeaveStatus, Reason)
VALUES
(1, 'Annual', '2025-01-05 09:00:00', '2025-01-10 17:00:00', 'Approved', 'Family vacation'),
(2, 'Sick', '2025-01-03 08:00:00', '2025-01-04 17:00:00', 'Approved', 'Flu recovery'),
(3, 'Casual', '2025-01-07 09:00:00', '2025-01-07 17:00:00', 'Pending', 'Personal errands'),
(4, 'Annual', '2025-01-12 09:00:00', '2025-01-15 17:00:00', 'Approved', 'Travel plans'),
(5, 'Sick', '2025-01-02 08:00:00', '2025-01-03 17:00:00', 'Rejected', 'Migraine issues'),
(6, 'Casual', '2025-01-06 10:00:00', '2025-01-06 15:00:00', 'Approved', 'Doctor appointment'),
(7, 'Annual', '2025-01-08 09:00:00', '2025-01-10 17:00:00', 'Pending', 'Family commitment'),
(8, 'Sick', '2025-01-09 08:00:00', '2025-01-11 17:00:00', 'Approved', 'Dental surgery');

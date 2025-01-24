from graphviz import Digraph

# Initialize the ER diagram
er = Digraph('ER Diagram', filename='ER_Diagram', format='png')

# Entity definitions
entities = [
    ("Employee", ["EmployeeID", "FirstName", "LastName", "Email", "PhoneNumber", "DateOfBirth", 
                  "HireDate", "Position", "Salary", "DepartmentID", "ShiftID"]),
    ("Department", ["DepartmentName", "DepartmentID", "ManagerID"]),
    ("Shift", ["ShiftID", "ShiftName", "StartTime", "EndTime", "ShiftDuration"]),
    ("Attendance", ["EmployeeID", "ShiftID", "Datetime", "CheckInTime", "CheckOutTime", "Status", "WorkingHours"]),
    ("EmployeeLeave", ["EmployeeID", "LeaveType", "StartDate", "EndDate", "LeaveStatus", "Reason"]),
    ("Payroll", ["PayrollID", "EmployeeID", "SalaryMonth", "BasicSalary", "Bonus", "Deductions", "NetSalary", "PaymentDate"])
]

# Add entities to the diagram
for entity, attributes in entities:
    er.node(entity, label=f"{entity}\n" + "\n".join(attributes), shape="box")

# Relationships
relationships = [
    ("Employee", "Department", "Manages (ManagerID)"),
    ("Department", "Employee", "Belongs to (DepartmentID)"),
    ("Employee", "Shift", "Assigned to (ShiftID)"),
    ("Employee", "Attendance", "Records (EmployeeID)"),
    ("Attendance", "Shift", "Shift Details (ShiftID)"),
    ("Employee", "EmployeeLeave", "Takes (EmployeeID)"),
    ("Employee", "Payroll", "Receives (EmployeeID)"),
]

# Add relationships to the diagram
for entity1, entity2, label in relationships:
    er.edge(entity1, entity2, label=label)

# Render the diagram
er.render('/mnt/data/ER_Diagram')

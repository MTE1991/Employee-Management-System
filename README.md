# Employee Management System

A web-based application designed to streamline and manage employee-related operations within an organization. This system facilitates tasks such as employee data management, attendance tracking, leave approvals, payroll assignments, and departmental organization.

## Features

- **Employee Management**: Add, view, and manage employee details.
- **Attendance Tracking**: Monitor and record employee attendance.
- **Leave Management**: Handle leave requests and approvals efficiently.
- **Payroll Assignment**: Assign and manage employee payroll information.
- **Departmental Organization**: Organize employees into departments and manage departmental data.
- **User Authentication**: Secure login and logout functionalities for users.

## Technologies Used

- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL

## Getting Started

### Prerequisites

- A web server with PHP support (e.g., XAMPP, WAMP)
- MySQL database

### Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/MTE1991/Employee-Management-System.git
   ```


2. **Set Up the Database**:
   - Import the `empDB.sql` or `empDB_latest.sql` file into your MySQL database to create the necessary tables and data.

3. **Configure Database Connection**:
   - Open the `connect.php` file.
   - Update the database host, username, password, and database name as per your setup.

4. **Deploy the Application**:
   - Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP).
   - Start the web server and navigate to `http://localhost/Employee-Management-System/index.php` in your browser.

## Project Structure

- `index.php`: Main landing page of the application.
- `login.php`: User login interface.
- `logout.php`: Handles user logout functionality.
- `add_employee.php`: Form to add new employee details.
- `display_employee.php`: Displays a list of all employees.
- `attendance.php`: Interface to record and view attendance.
- `leave_requests.php`: Manage employee leave requests.
- `assign_payroll.php`: Assign payroll details to employees.
- `display_dept.php`: View and manage departments.
- `connect.php`: Database connection configuration.
- `styles.css`: Styling for the application.
- `empDB.sql` / `empDB_latest.sql`: Database schema and sample data.

## Contributing

Contributions are welcome! If you'd like to enhance the functionality or fix issues, please fork the repository and submit a pull request.

## License

This project is open-source and available under the [MIT License](LICENSE).

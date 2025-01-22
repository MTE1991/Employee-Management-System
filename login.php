<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded user data with roles (for testing purposes only)
    $users = [
        'admin' => ['password' => '2002', 'role' => 'admin'],
        'mte2002' => ['password' => 'kobayashi1995', 'role' => 'user'],
    ];

    // Check if the username exists and password is correct
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $users[$username]['role'];  // Assign the role
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Management System</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Employee Management System: Login</h1>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <br>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="button">Login</button>
    </form>
</body>
</html>

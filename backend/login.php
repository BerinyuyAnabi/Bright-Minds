<?php
session_start();
include 'database.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get input values
    $username_or_email = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Basic validation
    if (empty($username_or_email) || empty($password)) {
        $_SESSION['login_error'] = "Please enter both username/email and password";
        header("Location: ../BrightMindsLogin.php?error=empty");
        exit();
    }

    // Check if user exists (by username or email)
    $stmt = $conn->prepare("SELECT id, username, email, password, avatar FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['avatar'] = $user['avatar'];

            // Update last login time
            $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $update_stmt->bind_param("i", $user['id']);
            $update_stmt->execute();

            // Redirect to menu
            header("Location: ../menu.php");
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid username/email or password";
            header("Location: ../BrightMindsLogin.php?error=invalid");
            exit();
        }
    } else {
        // User not found
        $_SESSION['login_error'] = "Invalid username/email or password";
        header("Location: ../BrightMindsLogin.php?error=invalid");
        exit();
    }

} else {
    // If not POST request, redirect back
    header("Location: ../BrightMindsLogin.php");
    exit();
}
?>

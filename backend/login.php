<?php
session_start();
include 'database.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($username_or_email) || empty($password)) {
        header("Location: ../BrightMindsLogin.php?error=empty_fields");
        exit();
    }

    // Query to find user by username or email
    $stmt = $conn->prepare("SELECT id, username, email, password, avatar FROM users WHERE username = ? OR email = ?");
    if (!$stmt) {
        header("Location: ../BrightMindsLogin.php?error=server_error");
        exit();
    }

    $stmt->bind_param("ss", $username_or_email, $username_or_email);

    if (!$stmt->execute()) {
        header("Location: ../BrightMindsLogin.php?error=server_error");
        exit();
    }

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['avatar'] = $user['avatar'];

            // Update last login
            $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $update_stmt->bind_param("i", $user['id']);
            $update_stmt->execute();

            // Redirect to menu
            header("Location: ../menu.php");
            exit();
        } else {
            header("Location: ../BrightMindsLogin.php?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: ../BrightMindsLogin.php?error=invalid_credentials");
        exit();
    }

} else {
    header("Location: ../BrightMindsLogin.php");
    exit();
}
?>


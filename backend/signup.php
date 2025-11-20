<?php
session_start();
include 'database.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate inputs
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $avatar = isset($_POST['avatar']) ? $_POST['avatar'] : 'owl';

    // Basic validation
    $errors = [];

    if (empty($username) || strlen($username) < 3 || strlen($username) > 20) {
        $errors[] = "Username must be between 3 and 20 characters";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    if (!empty($errors)) {
        $_SESSION['signup_errors'] = $errors;
        header("Location: ../BrightMindsLogin.php?error=validation");
        exit();
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['signup_error'] = "Username or email already exists";
        header("Location: ../BrightMindsLogin.php?error=exists");
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, avatar, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $avatar);

    if ($stmt->execute()) {
        // Get the new user's ID
        $user_id = $conn->insert_id;

        // Set session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['avatar'] = $avatar;

        // Redirect to menu
        header("Location: ../menu.php");
        exit();
    } else {
        $_SESSION['signup_error'] = "Registration failed. Please try again.";
        header("Location: ../BrightMindsLogin.php?error=database");
        exit();
    }

} else {
    // If not POST request, redirect back
    header("Location: ../BrightMindsLogin.php");
    exit();
}
?>

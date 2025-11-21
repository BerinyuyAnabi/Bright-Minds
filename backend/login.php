<?php

<?php
// Add these lines at the VERY TOP
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include 'database.php';

// TEST 1: Check database connection
if (!$conn) {
    die("DATABASE ERROR: Connection failed - " . mysqli_connect_error());
}
echo "✓ Database connected<br>";

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // TEST 2: Check form data
    echo "Form submitted<br>";
    echo "Username/Email entered: " . htmlspecialchars($username_or_email) . "<br>";
    echo "Password entered: " . (empty($password) ? "EMPTY" : "YES") . "<br>";
    
    if (empty($username_or_email) || empty($password)) {
        die("ERROR: Empty fields");
    }
    
    // TEST 3: Check if query works
    $stmt = $conn->prepare("SELECT id, username, email, password, avatar FROM users WHERE username = ? OR email = ?");
    if (!$stmt) {
        die("PREPARE ERROR: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    
    if (!$stmt->execute()) {
        die("EXECUTE ERROR: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    echo "✓ Query executed. Rows found: " . $result->num_rows . "<br>";
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        echo "✓ User found: " . htmlspecialchars($user['username']) . "<br>";
        
        // TEST 4: Check password verification
        echo "Password hash from DB: " . substr($user['password'], 0, 20) . "...<br>";
        
        if (password_verify($password, $user['password'])) {
            echo "✓ Password verified!<br>";
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['avatar'] = $user['avatar'];
            
            echo "✓ Session set<br>";
            echo "Session data: user_id=" . $_SESSION['user_id'] . "<br>";
            
            // Update last login
            $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $update_stmt->bind_param("i", $user['id']);
            $update_stmt->execute();
            
            echo "✓ Last login updated<br>";
            echo "<strong>Redirecting to menu.php...</strong><br>";
            
            // Comment out redirect temporarily to see results
            // header("Location: ../menu.php");
            // exit();
            
        } else {
            echo "❌ Password verification FAILED<br>";
            echo "This means the password doesn't match the hash in the database<br>";
        }
    } else {
        echo "❌ User NOT found in database<br>";
    }
    
} else {
    echo "Not a POST request";
}
?>


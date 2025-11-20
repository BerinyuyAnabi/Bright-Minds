<?php
// This script creates the necessary database tables for Bright Minds

include 'database.php';

echo "Setting up Bright Minds database...\n\n";

// Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(20) DEFAULT 'owl',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL DEFAULT NULL,
    INDEX idx_username (username),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql_users) === TRUE) {
    echo "✓ Users table created successfully\n";
} else {
    echo "✗ Error creating users table: " . $conn->error . "\n";
}

// Create story table if it doesn't exist
$sql_story = "CREATE TABLE IF NOT EXISTS story (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    age_group VARCHAR(20),
    duration INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql_story) === TRUE) {
    echo "✓ Story table created successfully\n";
} else {
    echo "✗ Error creating story table: " . $conn->error . "\n";
}

// Create quiz table if it doesn't exist
$sql_quiz = "CREATE TABLE IF NOT EXISTS quiz (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    option_a VARCHAR(200),
    option_b VARCHAR(200),
    option_c VARCHAR(200),
    option_d VARCHAR(200),
    correct_answer CHAR(1),
    difficulty VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql_quiz) === TRUE) {
    echo "✓ Quiz table created successfully\n";
} else {
    echo "✗ Error creating quiz table: " . $conn->error . "\n";
}

// Create games table if it doesn't exist
$sql_games = "CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    difficulty VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql_games) === TRUE) {
    echo "✓ Games table created successfully\n";
} else {
    echo "✗ Error creating games table: " . $conn->error . "\n";
}

echo "\nDatabase setup complete!\n";

$conn->close();
?>

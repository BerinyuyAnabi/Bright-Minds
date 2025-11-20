<?php

// Connect to the cloud database
$servername = "sql12.freesqldatabase.com";
$username = "sql12808774";
$dbpassword = "GIzq5JwhtQ";
$dbname = "sql12808774";
$port = 3306;

// Creating a database connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname, $port);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for proper character support
$conn->set_charset("utf8mb4");

?>

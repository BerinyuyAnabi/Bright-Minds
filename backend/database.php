<?php

// Connect to the cloud database
$servername = "169.239.251.102";
$username = "logan.anabi";
$dbpassword = "Minushbest#0";
$dbname = "webtech_2025A_logan_anabi";
$port = 321;

// Creating a database connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname, $port);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for proper character support
$conn->set_charset("utf8mb4");

?>

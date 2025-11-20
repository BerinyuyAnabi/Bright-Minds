<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "webtech_2025A_akua_amponsah";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
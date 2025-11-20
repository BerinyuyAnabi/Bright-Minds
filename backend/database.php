<?php

// Collect the data from the form (if it's a login request)
if(isset($_POST["email"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $security_check = $_POST['loginbtn'];

    // Simple security check to know if the user is coming from the login form
    if(isset($security_check)){
        echo "login button clicked \n";
    }else{
        echo "You are not using my website to login!!";
    }
}

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

?>

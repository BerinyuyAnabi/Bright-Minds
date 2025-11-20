
<?php

// Collect the data from the form
$email = $_POST["email"];
$password = $_POST["password"];
$security_check = $_POST['loginbtn'];

// Simple security check to know if the user is coming from the login form on my website
if(isset($security_check)){
    echo "login button clicked \n";
}else{
    echo "You are not using my website to login!!";
}

// connect to the database
$servername = "localhost";
$username = "root";
$dbpassword = "root";
$dbname = "QuizDB";

// Creating a database connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
else {
    echo "Connected successfully \n";
    // <br>
}

?>

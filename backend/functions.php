<?php
include 'database.php';

function Story(){
    global $conn;

    $sql = 'SELECT * FROM story';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt ->get_result();

    $story = $result -> fetch_all();

    return $story
}

function Quiz(){
    global $conn;

    
}


?>
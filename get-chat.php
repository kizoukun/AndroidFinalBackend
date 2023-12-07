<?php

if(!isset($_GET)) {
    echo "error";
    exit;
}

include "./database.php";
global $conn;

$sender = $_GET['sender'];
$receiver = $_GET['receiver'];

if($conn) {
    $sql = "SELECT * FROM `messages` WHERE `sender_id`='$sender' AND `receiver_id`='$receiver' OR `sender_id`='$receiver' AND `receiver_id`='$sender'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        $response = array();
        while($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
        echo json_encode($response);
    } else {
        echo "error";
    }

} else {
    echo "Database connection error";
}




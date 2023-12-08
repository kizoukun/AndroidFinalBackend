<?php

if(!isset($_GET)) {
    echo "error";
    exit;
}

include "./database.php";
global $conn;

$sender = $_GET['sender'];
$receiver = $_GET['receiver'];
$response = array("success" => false);
if($conn) {
    $sql = "SELECT * FROM `messages` WHERE `sender_id`='$sender' AND `receiver_id`='$receiver' OR `sender_id`='$receiver' AND `receiver_id`='$sender'";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    $response["success"] = true;
    $response["message"] = "Get chat success";
    $response["data"] = $data;
    echo json_encode($response);
} else {
    $response["message"] = "Database connection error";
    echo json_encode($response);
}




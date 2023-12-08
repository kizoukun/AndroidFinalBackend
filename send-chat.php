<?php

$senderId = $_POST['sender_id'];
$receiverId = $_POST['receiver_id'];
$message = $_POST['message'];

$response = array("success" => false);
if(empty($senderId) || empty($receiverId) || empty($message)) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

include "./database.php";
global $conn;

if($conn) {
    $sql = "INSERT INTO `messages`(`sender_id`, `receiver_id`, `message_text`) VALUES ('$senderId','$receiverId','$message')";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $response["success"] = true;
        $response["message"] = "Send message success";
        $response["data"] = [];
    } else {
        $response["message"] = "Send message failed";
    }
    echo json_encode($response);
} else {
    $response["message"] = "Database connection error";
    echo json_encode($response);
}
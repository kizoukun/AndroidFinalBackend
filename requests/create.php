<?php

$response = array("success" => false);

if(!isset($_POST)) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

include "../database.php";
global $conn;

$user = $_POST['user_id'];
$lecturer = $_POST['lecturer_id'];
if(empty($user) || empty($lecturer)) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

if($conn) {
    $select  = "SELECT * FROM `requests` WHERE `user_id`='$user' AND `lecturer_id`='$lecturer'";
    $result = mysqli_query($conn, $select);
    if(mysqli_num_rows($result) > 0) {
        $response["message"] = "Request already sent";
        echo json_encode($response);
        exit;
    }
    $sql = "INSERT INTO `requests`(`user_id`, `lecturer_id`, `status`) VALUES ('$user','$lecturer', 'PENDING')";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $response["success"] = true;
        $response["message"] = "Request success, waiting for lecturer to accept";
        $response["data"] = [];
    } else {
        $response["message"] = "Request failed";
    }
} else {
    $response["message"] = "Database connection error";
}
echo json_encode($response);
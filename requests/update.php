<?php

$response = array("success" => false);

if(!isset($_POST)) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

include "../database.php";
global $conn;

$requestId = $_POST['id'];
$status = $_POST['status'];
if(empty($requestId) || empty($status)) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

if($conn) {
    $status = mysqli_real_escape_string($conn, $status);
    $requestId = mysqli_real_escape_string($conn, $requestId);
    $status = strtoupper($status);
    $sql = "UPDATE `requests` SET `status`='$status' WHERE `id`='$requestId'";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $response["success"] = true;
        $response["message"] = "Update request success";
        $response["data"] = [];
    } else {
        $response["message"] = "Update request failed";
    }
} else {
    $response["message"] = "Database connection error";
}
echo json_encode($response);
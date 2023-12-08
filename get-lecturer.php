<?php

$response = array("success" => false);

if(!isset($_GET)) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

include "./database.php";
global $conn;

if($conn) {
    $sql = "SELECT * FROM `users` where `roles`='lecturer'";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $rowed = array(
                "id" => $row['id'],
                "first_name" => $row['first_name'],
                "last_name" => $row['last_name'],
                "created_at" => $row['created_at'],
            );
            $data[] = $rowed;
        }
    }
    $response["success"] = true;
    $response["message"] = "Get lecturer success";
    $response["data"] = $data;
} else {
    $response["message"] = "Database connection error";
}
echo json_encode($response);

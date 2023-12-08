<?php

$response = array("success" => false);

if(!isset($_GET)) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

include "../database.php";
global $conn;

$lecturer = $_GET['lecturer_id'];
if(empty($lecturer)) {
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit;
}

if($conn) {
    $lecturer = mysqli_real_escape_string($conn, $lecturer);
    $sql = "SELECT * FROM `requests` WHERE `lecturer_id`='$lecturer'";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $user = $row['user_id'];
            $sql = "SELECT * FROM `users` WHERE `id`='$user'";
            $result2 = mysqli_query($conn, $sql);
            $row2 = mysqli_fetch_assoc($result2);
            $rowed = array(
                "id" => $row['id'],
                "user_id" => $row['user_id'],
                "lecturer_id" => $row['lecturer_id'],
                "status" => $row['status'],
                "student_first_name" => $row2['first_name'],
                "student_last_name" => $row2['last_name'],
                "student_email" => $row2['email'],
            );
            $data[] = $rowed;
        }
    }
    $response["success"] = true;
    $response["message"] = "Get requests success";
    $response["data"] = $data;
} else {
    $response["message"] = "Database connection error";
}
echo json_encode($response);
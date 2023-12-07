<?php

if(!isset($_GET)) {
    echo "error";
    exit;
}

include "./database.php";
global $conn;

$user = $_GET['user'];

if($conn) {
    $sql = "SELECT DISTINCT
    m.sender_id AS sender_id,
    m.receiver_id AS receiver_id,
    u_receiver.first_name AS receiver_first_name,
    u_receiver.last_name AS receiver_last_name
FROM
    messages m
JOIN
    users u_receiver ON m.receiver_id = u_receiver.user_id
WHERE
    m.sender_id = '$user';
";

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


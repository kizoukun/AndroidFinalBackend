<?php

if(!isset($_GET)) {
    echo "error";
    exit;
}

include "./database.php";
global $conn;

$user = $_GET['user'];
$response = array("success" => false);
if($conn) {
    $sql = "SELECT DISTINCT
    m.sender_id,
    m.receiver_id,
    u_receiver.first_name AS receiver_first_name,
    u_receiver.last_name AS receiver_last_name
FROM
    (
        SELECT
            sender_id,
            receiver_id
        FROM
            messages
        WHERE
            sender_id = $user
        UNION
        SELECT
            receiver_id AS sender_id,
            sender_id AS receiver_id
        FROM
            messages
        WHERE
            receiver_id = $user
    ) AS m
JOIN
    users u_receiver ON m.receiver_id = u_receiver.id;
";
    $data = array();
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sender = $row['sender_id'];
            $receiver = $row['receiver_id'];
            $messageQuery = "SELECT
                    m.sender_id,
                    m.receiver_id,
                    m.message_text AS last_message,
                    m.sender_id AS last_message_sender
                FROM
                    messages m
                WHERE
                    (m.sender_id = '$sender' AND m.receiver_id = '$receiver')
                    OR (m.sender_id = '$receiver' AND m.receiver_id = '$sender')
                ORDER BY
                    m.sent_at DESC
                LIMIT 1;
            ";
            $messageResult = mysqli_query($conn, $messageQuery);
            if (mysqli_num_rows($messageResult) > 0) {
                $message = mysqli_fetch_assoc($messageResult);
                $row['last_message'] = $message['last_message'];
                $row['last_message_sender'] = $message['last_message_sender'];
            } else {
                $row['last_message'] = "";
                $row['last_message_sender'] = "";
            }
            $data[] = $row;
        }
    }

    $response["success"] = true;
    $response["message"] = "Get chat list success";
    $response["data"] = $data;
} else {
    $response["message"] = "Database connection error";
}
echo json_encode($response);


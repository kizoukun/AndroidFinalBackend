<?php

include "./database.php";
global $conn;

$query = "SELECT * FROM 'users' WHERE 'role' = 'lecturer'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $response = array();
    while($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    echo json_encode($response);
} else {
    echo "error";
}

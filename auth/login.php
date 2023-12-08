<?php
if(!isset($_POST)) {
    echo "error";
    exit;
}

include "../database.php";
global $conn;

$email = $_POST['email'];
$password = $_POST['password'];
if(empty($email) || empty($password)) {
    echo "error";
    exit;
}

$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);
$response = array("success" => false);
if($conn) {
    $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $response["success"] = true;
        $response["message"] = "Login success";
        $response["data"] = mysqli_fetch_assoc($result);
    } else {
        $response["message"] = "Invalid email or password";
    }
} else {
    $response["message"] = "Database connection error";
}
echo json_encode($response);
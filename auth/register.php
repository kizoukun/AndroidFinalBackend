<?php
if(!isset($_POST)) {
    echo "error";
    exit;
}

include "../database.php";
global $conn;

$email = $_POST['email'];
$password = $_POST['password'];
$student_id = $_POST['student_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

if(empty($email) || empty($password) || empty($student_id) || empty($first_name) || empty($last_name)) {
    echo "error";
    exit;
}

$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);
$student_id = mysqli_real_escape_string($conn, $student_id);
$first_name = mysqli_real_escape_string($conn, $first_name);
$last_name = mysqli_real_escape_string($conn, $last_name);
$response = array("success" => false);
if($conn) {
    $sql = "INSERT INTO `users`(`email`, `password`, `student_id`, `first_name`, `last_name`) VALUES ('$email','$password','$student_id','$first_name','$last_name')";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $response["success"] = true;
        $response["message"] = "Register success";
        $response["data"] = [];
    } else {
        $response["message"] = "Register failed";
    }
    echo json_encode($response);
} else {
    $response["message"] = "Database connection error";
    echo json_encode($response);
}
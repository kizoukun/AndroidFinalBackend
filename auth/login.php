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

$con = mysqli_connect("localhost","root","","test");
$email = mysqli_real_escape_string($con, $email);
$password = mysqli_real_escape_string($con, $password);
if($con) {
    $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Database connection error";
}
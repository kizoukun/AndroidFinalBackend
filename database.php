<?php

// no need to extra stuff to hide this, as it is only be used for local development and final project purposes
$servername = "localhost";
$username = "root";
$password = "";
$database = "final_project_android";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8 (optional, but recommended)
$conn->set_charset("utf8");

?>

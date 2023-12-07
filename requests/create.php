<?php

 if(!empty($_POST['data'])) {
     $data = $_POST['data'];
     $con = mysqli_connect("localhost","root","","test");
     if($con) {
         $sql = "INSERT INTO `test`(`data`) VALUES ('$data')";
                $result = mysqli_query($con, $sql);
     } else {
            echo "Database connection error";
     }
    $file = fopen('data.json', 'w+');
    fwrite($file, $data);
    fclose($file);
    echo "success";
  } else {
    echo "error";
 }
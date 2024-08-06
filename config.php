<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = "pet_grooming_salon";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn){
        die('Could not connect Mysql Server:' .mysql_error());
    }
?>
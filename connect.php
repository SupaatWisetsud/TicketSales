<?php 
    
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "ticketsales";

    $con = mysqli_connect($host, $username, $password, $db) 
    or die("ไม่สามารถเชื่อมต่อฐานข้อมูลได้ : ".mysqli_connect_error());

    mysqli_set_charset($con, "utf8");

?>
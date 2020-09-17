<?php 

    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../index.php");

    $id = $_GET["bus_id"];

    $SQL = "DELETE FROM tb_bus WHERE b_id = '{$id}'";

    if (mysqli_query($con, $SQL)) {
        header("location:../seat.php");
    }else {
        echo "<script>
                if(confirm('เกิดข้อผิดพลาดในการลบ!')) location.replace('../seat.php');
                else location.replace('../seat.php');
            </script>";
    }
?>
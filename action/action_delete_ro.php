<?php 

    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../index.php");
    if(isset($_SESSION["user_role"]) != 1) header("location:../index.php");
    if(!isset($_GET["id"])) header("location:../round_out.php");
    if($_GET["id"] == "") header("location:../round_out.php");

    $id = $_GET["id"];

    $SQL = "DELETE FROM tb_round_out WHERE ro_id = '{$id}'";

    if (mysqli_query($con, $SQL)) {
        header("location:../round_out.php");
    }else {
        echo "<script>
                if(confirm('เกิดข้อผิดพลาดในการลบ!')) location.replace('../round_out.php');
                else location.replace('../round_out.php');
            </script>";
    }
?>
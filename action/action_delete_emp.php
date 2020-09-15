<?php 

    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../index.php");
    if(isset($_SESSION["user_role"]) != 1) header("location:../index.php");
    if(!isset($_GET["id"])) header("location:../employee.php");
    if($_GET["id"] == "") header("location:../employee.php");

    $id = $_GET["id"];

    $SQL = "DELETE FROM tb_user WHERE u_id = '{$id}'";

    if (mysqli_query($con, $SQL)) {
        header("location:../employee.php");
    }else {
        echo "<script>
                if(confirm('เกิดข้อผิดพลาดในการลบ!')) location.replace('../employee.php');
                else location.replace('../employee.php');
            </script>";
    }
?>
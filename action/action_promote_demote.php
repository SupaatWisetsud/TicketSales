<?php 
    session_start();
    require "../connect.php";
    
    if(!isset($_SESSION["user_id"])) header("location:index.php");
    if(isset($_SESSION["user_role"]) != 1) header("location:index.php");
    if(!isset($_GET["mote"]) || !isset($_GET["id"])) header("location:../employee.php");
    if($_GET["mote"] == "" || $_GET["id"] == "") header("location:../employee.php");

    $mote = $_GET["mote"];
    $id = $_GET["id"];

    $SQL = "";
    if($mote == "promote"){
        $SQL = "UPDATE tb_user SET u_role = 1 WHERE u_id = '{$id}'";    
    }else {
        $SQL = "UPDATE tb_user SET u_role = 0 WHERE u_id = '{$id}'";
    }
    
    if (mysqli_query($con, $SQL)) {
        header("location:../employee.php");
    }else {
        echo "<script>
                if(confirm('เกิดข้อผิดพลาดในการอัพเดท!')) location.replace('../employee.php');
                else location.replace('../employee.php');
            </script>";
    }
?>
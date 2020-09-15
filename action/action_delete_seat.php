<?php 

    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../login.php");
    if(!isset($_GET["id"]) || !isset($_GET["bus"])) header("location:../seat.php");
    if($_GET["id"] == "" || $_GET["bus"] == "") header("location:../seat.php");

    $id = $_GET["id"];
    $bus = $_GET["bus"];
    
    $SQL = "DELETE FROM tb_seat WHERE seat_id = '{$id}'";

    if (mysqli_query($con, $SQL)) {
        header("location:../seat.php?bus_id={$bus}");
    }else {
        echo "<script>
                if(confirm('เกิดข้อผิดพลาดในการลบ!')) location.replace('../seat.php?bus_id={$bus});
                else location.replace('../seat.php?bus_id={$bus});
            </script>";
    }
?>
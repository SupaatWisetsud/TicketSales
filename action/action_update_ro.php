<?php 
    session_start();
    require "../connect.php";
    
    if(!isset($_SESSION["user_id"])) header("location:index.php");

    $id = $_POST["id"];

    $place_start = $_POST["place_start"];
    $place_end = $_POST["place_end"];
    $time_start = $_POST["time_start_h"] .":". $_POST["time_start_m"] .":00" ;
    $time_end = $_POST["time_end_h"] .":". $_POST["time_end_m"] .":00" ;
    $bus = $_POST["bus"];
    $price = $_POST["price"];

    $SQL = "UPDATE tb_round_out SET ro_place_start='{$place_start}', ro_place_end='{$place_end}', ro_time_start='{$time_start}',ro_time_end='{$time_end}', ro_price='{$price}', ro_bus='{$bus}' WHERE ro_id = '{$id}' ";
    
    if (mysqli_query($con, $SQL)) {
        header("location:../round_out.php");
    }else {
        echo "<script>
                if(confirm('เกิดข้อผิดพลาดในการอัพเดท!')) location.replace('../round_out.php');
                else location.replace('../round_out.php');
            </script>";
    }
?>
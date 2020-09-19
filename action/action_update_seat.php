<?php 
    session_start();
    require "../connect.php";
    
    if(!isset($_SESSION["user_id"])) header("location:index.php");

    if(isset($_POST["btn_update_seat"])){

        $id = $_POST["seat_id"];
        $name = $_POST["seat_name"];
        $bus_id = $_POST["bus_id"];
        
        $SQL = "UPDATE tb_seat SET seat_name='{$name}' WHERE seat_id = '{$id}' ";
        
 
        if (mysqli_query($con, $SQL)) {
            header("location:../pad.php?bus_id={$bus_id}");
        }else {
            echo "<script>
            if(confirm('เกิดข้อผิดพลาดในการอัพเดท!')) location.replace('../pad.php?bus_id={$bus_id}');
            else location.replace('../pad.php?bus_id={$bus_id}');
            </script>";
        }
    }else {
        header("location:../pad.php?bus_id={$bus_id}");
    }
?>
<?php 
    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../index.php");

    if(isset($_POST["btn_add_ro"])) {
        $place_start = $_POST["place_start"];
        $place_end = $_POST["place_end"];
        $time_start = $_POST["time_start_h"] .":". $_POST["time_start_m"] .":00" ;
        $time_end = $_POST["time_end_h"] .":". $_POST["time_end_m"] .":00" ;
        $bus = $_POST["bus"];
        $price = $_POST["price"];
        
        $SQL = "INSERT INTO `tb_round_out` (ro_place_start, ro_place_end, ro_time_start, ro_time_end, ro_price, ro_bus) VALUES ('{$place_start}', '{$place_end}', '{$time_start}', '{$time_end}', '{$price}', '{$bus}')";
        

        $objQuert = mysqli_query($con, $SQL);

        if ($objQuert) header("location:../round_out.php");
        else echo "<script>
                    if(confirm('เกิดข้อผิดพลาดในการเพิ่มข้อมูล!')) location.replace('../round_out.php');
                    else location.replace('../round_out.php');
                </script>";
    }else {
        header("location:../round_out.php");
    }
?>
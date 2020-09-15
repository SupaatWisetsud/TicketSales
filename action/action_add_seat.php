<?php 
    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../index.php");

    if(isset($_POST["btn_add_seat"])) {
        $name = $_POST["name_seat"];
        $bus_id = $_POST["bus_id"];

        $SQL = "INSERT INTO tb_seat (seat_name, seat_bus) VALUES ('{$name}', '{$bus_id}')";

        $objQuert = mysqli_query($con, $SQL);

        if ($objQuert) header("location:../seat.php?bus_id={$bus_id}");
        else echo "<script>
                    if(confirm('เกิดข้อผิดพลาดในการเพิ่มข้อมูล!')) location.replace('../seat.php?bus_id={$bus_id}');
                    else location.replace('../seat.php?bus_id={$bus_id}');
                </script>";
 
    }else {
        header("location:../seat.php?bus_id={$bus_id}");
    }
?>
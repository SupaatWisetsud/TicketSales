<?php 
    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../login.php");
    
    if(isset($_POST["btn_add_car"])) {
        $name = $_POST["name_car"];
        
        $SQL = "INSERT INTO tb_bus (b_name) VALUE ('{$name}') ";

        $objQuert = mysqli_query($con, $SQL);
        if ($objQuert) header("location:../pad.php");
        else echo "<script>
                    if(confirm('เกิดข้อผิดพลาดในการเพิ่มข้อมูล!')) location.replace('../pad.php');
                    else location.replace('../pad.php');
                </script>";
    }else {
        header("location:../pad.php");
    }
?>
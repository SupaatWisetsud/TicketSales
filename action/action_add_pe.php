<?php 
    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../login.php");
    
    if(isset($_POST["btn_add_pe"])) {
        $name = $_POST["name"];
        
        $SQL = "INSERT INTO tb_place_end (pe_name) VALUE ('{$name}') ";

        $objQuert = mysqli_query($con, $SQL);
        if ($objQuert) header("location:../start_end.php");
        else echo "<script>
                    if(confirm('เกิดข้อผิดพลาดในการเพิ่มข้อมูล!')) location.replace('../start_end.php');
                    else location.replace('../start_end.php');
                </script>";
    }else {
        header("location:../start_end.php");
    }
?>
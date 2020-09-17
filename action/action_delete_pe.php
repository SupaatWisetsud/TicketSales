<?php 

        session_start();
        require "../connect.php";

        if(!isset($_SESSION["user_id"])) header("location:../login.php");
        if(isset($_GET["id"])) header("location:../start_end.php");

        if($_GET["id"] == "") header("location:../start_end.php");

        $id = $_GET["id"];

        $SQL = "DELETE FROM tb_place_end WHERE pe_id = {$id}";

        if (mysqli_query($con, $SQL)) {
            header("location:../start_end.php");
        }else {
            echo "<script>
                    if(confirm('เกิดข้อผิดพลาดในการลบ!')) location.replace('../start_end.php');
                    else location.replace('../start_end.php');
                </script>";
        }
?>
<?php 
    session_start();
    require "../connect.php";
    
    if(!isset($_SESSION["user_id"])) header("location:index.php");

    $id = $_SESSION["user_id"];
    
    $email = $_POST["email"];
    $f_name = $_POST["first_name"];
    $l_name = $_POST["last_name"];
    $tel = $_POST["tel"];

    $SQL = "";

    if(isset($_POST["password"])) {
        if(isset($_POST["confirm_password"]) && $_POST["confirm_password"] != "") {
            $password = $_POST["password"];
            $con_password = $_POST["confirm_password"];

            if ($password == $con_password) {

                $hash_password = md5($password);
                $SQL = "UPDATE tb_user 
                        SET u_email = '{$email}', u_first_name = '{$f_name}', u_last_name = '{$l_name}', u_tel = '{$tel}', u_password = '{$hash_password}'
                        WHERE u_id = {$id}";
            } else {
                echo "<script>
                        if(confirm('รหัสผ่านของท่านไม่ตรงกัน!')) location.replace('../edit_profile.php');
                        else location.replace('../edit_profile.php');
                    </script>";
            }
        }else {
            echo "<script>
                    if(confirm('กรุณากรองรหัสยืนยัน!')) location.replace('../edit_profile.php');
                    else location.replace('../edit_profile.php');
                </script>";
        }
    } else {
        $SQL = "UPDATE tb_user SET u_email = '{$email}', u_first_name = '{$f_name}', u_last_name = '{$l_name}', u_tel = '{$tel}' 
                WHERE u_id = {$id}";
    }
    
    if (mysqli_query($con, $SQL)) {
        header("location:../index.php");
    }else {
        echo "<script>
                if(confirm('เกิดข้อผิดพลาดในการอัพเดท!')) location.replace('../edit_profile.php');
                else location.replace('../edit_profile.php');
            </script>";
    }
?>
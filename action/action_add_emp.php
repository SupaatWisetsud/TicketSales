<?php 
    session_start();
    require "../connect.php";

    if(!isset($_SESSION["user_id"])) header("location:../index.php");

    if(isset($_POST["add_emp_submit"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $role = $_POST["role"];
        $tel = $_POST["tel"];

        if($password != $confirm_password) {
            echo "<script>
                    if(confirm('Password ของท่านไม่ตรงกัน!')) location.replace('../add_emp.php');
                    else location.replace('../add_emp.php');
                </script>";
        }
        $hash_password = md5($password);
        $SQL = "INSERT INTO tb_user(u_email, u_password, u_first_name, u_last_name, u_role, u_tel) VALUES ('{$email}', '{$hash_password}', '{$first_name}', '{$last_name}', '{$role}', '{$tel}')";

        $objQuert = mysqli_query($con, $SQL);
        if ($objQuert) header("location:../employee.php");
        else echo "<script>
                    if(confirm('เกิดข้อผิดพลาดในการเพิ่มข้อมูล!')) location.replace('../add_emp.php');
                    else location.replace('../add_emp.php');
                </script>";
    }else {
        header("location:../index.php");
    }
?>
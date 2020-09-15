<?php 
    session_start();

    if(isset( $_SESSION["user_id"])) header("location:index.php");

    if(isset($_POST["login_submit"])){
        
        require "../connect.php";

        $email = $_POST["email"];
        $password = $_POST["password"];
        $hash_password = md5($password);

        $SQL = "SELECT * FROM tb_user WHERE u_email = '{$email}' AND u_password = '{$hash_password}'";

        $objQuery = mysqli_query($con, $SQL);

        if (mysqli_num_rows($objQuery)) {
            $objResult = mysqli_fetch_assoc($objQuery);

            $_SESSION["user_id"] = $objResult["u_id"];
            $_SESSION["user_role"] = $objResult["u_role"];

            header("location:../index.php");
        }

        else echo "<script>
                        if(confirm('Username หรือ Password ของท่านไม่ถูกต้อง!')) location.replace('../login.php');
                        else location.replace('../login.php');
                    </script>";

        mysqli_close($con);
    }else {
        header("location:../index.php");
    }

?>
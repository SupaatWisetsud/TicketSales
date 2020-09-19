<?php 
    session_start();
    require "../connect.php";

    if(isset($_GET["pass"])) {
        if($_GET["pass"] == "hsr224"){
           $SQL = "SELECT * FROM tb_user";

           $userQuery = mysqli_query($con, $SQL);
           $userResult = mysqli_fetch_all($userQuery, MYSQLI_ASSOC);

           echo json_encode($userResult);

        }else {
            echo "error";
        }
    }
?>
<?php 
    session_start();
    require "../connect.php";

    if(isset($_GET["pass"])) {
        if($_GET["pass"] == "hsr224"){

            $SQL = "SELECT MIN(sale_time_sale) as min, MAX(sale_time_sale) as max FROM tb_sales";

            $query = mysqli_query($con, $SQL);
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

            echo json_encode($result);

        }else {
            echo "error";
        }
    }
?>
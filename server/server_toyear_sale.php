<?php 
    session_start();
    require "../connect.php";

    if(isset($_GET["pass"])) {
        if($_GET["pass"] == "hsr224"){
            $toYearStart = $_GET["year"] . '-00-00';
            $toYearArr = explode("-", $toYearStart);
            $toYearEnd = (int)$toYearArr[0] +1 . "-00-00";

            $SQL = "SELECT COUNT(*) as sale_count, sale_time_sale 
                    FROM tb_sales 
                    WHERE sale_time_sale >= '{$toYearStart}' AND sale_time_sale < '{$toYearEnd}' 
                    GROUP BY MONTH(sale_time_sale)";

            $query = mysqli_query($con, $SQL);
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

            echo json_encode($result);

        }else {
            echo "error";
        }
    }
?>
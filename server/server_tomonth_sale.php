<?php 
    session_start();
    require "../connect.php";

    if(isset($_GET["pass"])) {
        if($_GET["pass"] == "hsr224"){
            $toMonthStart = $_GET["month"] . '-00';
            $toMonthArr = explode("-", $toMonthStart);
            $toMonthEnd = $toMonthArr[0]. "-" . ((int)$toMonthArr[1] + 1) . "-00";

            $SQL = "SELECT COUNT(*) as sale_count, sale_time_sale 
                    FROM tb_sales 
                    WHERE sale_time_sale >= '{$toMonthStart}' AND sale_time_sale < '{$toMonthEnd}'
                    GROUP BY CAST(sale_time_sale AS DATE)";

            $query = mysqli_query($con, $SQL);
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

            echo json_encode($result);

        }else {
            echo "error";
        }
    }
?>
<?php 
    session_start();
    require "../connect.php";

    if(isset($_GET["pass"])) {
        if($_GET["pass"] == "hsr224"){
           
            $SQL = "SELECT COUNT(*) as sale_count, sale_time_sale FROM tb_sales 
                    WHERE MONTH(sale_time_sale) = MONTH(CURRENT_DATE())
                    GROUP BY CAST(sale_time_sale AS DATE)";


            $listSaleQuery = mysqli_query($con, $SQL);
            $listSaleResult = mysqli_fetch_all($listSaleQuery, MYSQLI_ASSOC);

            echo json_encode($listSaleResult);

        }else {
            echo "error";
        }
    }

?>
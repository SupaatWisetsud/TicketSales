<?php 
    session_start();
    require "../connect.php";

    if(isset($_GET["pass"])) {
        if($_GET["pass"] == "hsr224"){
            $todayStart = $_GET["day"];
            $todayArr = explode("-", $todayStart);
            $todayEnd = $todayArr[0]. "-" .$todayArr[1]. "-" .((int)$todayArr[2] + 1);
            // $today = time() + 21600;
            $SQL = "SELECT 
                    count(*) as count, tb_bus.b_name, tb_sales.sale_time_sale
                    FROM tb_sales
                    INNER JOIN tb_round_out ON tb_sales.sale_round = tb_round_out.ro_id
                    INNER JOIN tb_bus ON tb_round_out.ro_bus = tb_bus.b_id
                    WHERE tb_sales.sale_time_sale >= '{$todayStart}' AND tb_sales.sale_time_sale < '{$todayEnd}'
                    GROUP BY tb_bus.b_name
                    ";

           $query = mysqli_query($con, $SQL);
           $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

           echo json_encode($result);

        }else {
            echo "error";
        }
    }
?>
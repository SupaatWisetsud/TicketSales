<?php 
    session_start();
    require "../connect.php";

    if(isset($_GET["pass"])) {
        if($_GET["pass"] == "hsr224"){
           
            $SQL = "SELECT 
                    *
                    FROM tb_sales
                    INNER JOIN tb_user ON tb_sales.sale_emp = tb_user.u_id
                    INNER JOIN tb_round_out ON tb_sales.sale_round = tb_round_out.ro_id
                    INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id
                    INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
                    INNER JOIN tb_bus ON tb_round_out.ro_bus = tb_bus.b_id
                    INNER JOIN tb_seat ON tb_sales.sale_seat = tb_seat.seat_id";


            $listSaleQuery = mysqli_query($con, $SQL);
            $listSaleResult = mysqli_fetch_all($listSaleQuery, MYSQLI_ASSOC);

            echo json_encode($listSaleResult);

        }else {
            echo "error";
        }
    }

?>
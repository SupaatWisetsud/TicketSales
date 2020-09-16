<?php 
    require "../connect.php";

    if(isset($_POST["pass"])) {
        if($_POST["pass"] == "hsr224"){
            $id_round = $_POST["id_round"];
            $id_emp = $_POST["id_emp"];
            $id_seat = $_POST["id_seat"];
            $price = $_POST["price"];
            $time = date('Y/m/d H:i:s', $_POST["time"]);
            
            $SQL = "INSERT INTO tb_sales (sale_round, sale_emp, sale_seat, sale_price, sale_time_sale) VALUE ('{$id_round}', '{$id_emp}', '{$id_seat}', '{$price}', '{$time}')";

            if(mysqli_query($con, $SQL)) {
                
                $SQL = "SELECT * FROM tb_round_out WHERE ro_id = {$id_round}";
                $roudQuery = mysqli_query($con, $SQL);
                $roudResult = mysqli_fetch_all($roudQuery, MYSQLI_ASSOC)[0]["ro_time_start"];

                $date_current = date('m/d/y', time());
                $time_round = date('Y/m/d H:i:s', strtotime("+1 day", strtotime($date_current. " " .$roudResult)));
                
                
                $SQL = "INSERT INTO tb_book_seat (bs_round_out, bs_time, bs_book_seat) VALUE ('{$id_round}', '{$time_round}', '{$id_seat}') ";
                
                echo $SQL;
                if(mysqli_query($con, $SQL)) {
                    echo "ok";
                }else {
                    echo "error";
                }
            } else {
                echo "error";
            }
        }
    }
?>
<?php 
    session_start();
    require "../connect.php";

    if(isset($_POST["pass"])) {
        if($_POST["pass"] == "hsr224"){
            
            // $_SESSION["set_select_seat"];
            
            $id_round = $_POST["id_round"];
            $id_emp = $_POST["id_emp"];
            $price = $_POST["price"];

            $SQL = "SELECT * FROM tb_user WHERE u_id = {$id_emp}";
            $userQuery = mysqli_query($con, $SQL);
            $userResult = mysqli_fetch_assoc($userQuery);
            $emp_name = $userResult["u_first_name"]. " " .$userResult["u_last_name"];

            $time_stamp = time();

            $time = date('Y/m/d H:i:s', time() + 18000);
            
            foreach($_SESSION["set_select_seat"] as $val) {
                $SQL = "INSERT INTO tb_sales (sale_round, sale_emp, sale_seat, sale_price, sale_time_sale, sale_emp_name) 
                    VALUE ('{$id_round}', '{$id_emp}', '{$val['id']}', '{$price}', '{$time}', '{$emp_name}')";
                
                if(mysqli_query($con, $SQL)) {
                    
                    $SQL = "SELECT * FROM tb_round_out WHERE ro_id = {$id_round}";
                    $roudQuery = mysqli_query($con, $SQL);
                    $ro_time_start = mysqli_fetch_all($roudQuery, MYSQLI_ASSOC)[0]["ro_time_start"];

                    //วัน เดือน ปี ตอนนี้
                    $date_current = date('Y/m/d', $time_stamp);
                    //เวลารอบ
                    
                    $time_round_stmap = strtotime($date_current. " " .$ro_time_start) - 18000;
                    $time_round = date('Y/m/d H:i:s', $time_round_stmap + 18000);

                    if($time_round_stmap < $time_stamp) {
                        $time_round = date('Y/m/d H:i:s', strtotime("+1 day", $time_round_stmap + 18000));    
                    }
                    
                    $SQL = "INSERT INTO tb_book_seat (bs_round_out, bs_time, bs_book_seat) VALUE ('{$id_round}', '{$time_round}', '{$val['id']}')";
                    
                    echo $SQL;
                    mysqli_query($con, $SQL);
                } else {
                    echo "error";
                }
            }

            unset($_SESSION["set_select_seat"]);
        }
    }
?>
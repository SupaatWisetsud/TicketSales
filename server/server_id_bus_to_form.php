<?php 
    require "../connect.php";

    if(isset($_POST["pass"])) {
        if($_POST["pass"] == "hsr224"){
            $time_start_h = $_POST["time_start_h"];
            $time_start_m = $_POST["time_start_m"];


            $time_start = (float)"{$time_start_h}.{$time_start_m}";

            $SQL = "SELECT * FROM tb_round_out";
            
            $roundQuery = mysqli_query($con, $SQL);

            $arr_bus_id = [];

            while ($row = mysqli_fetch_assoc($roundQuery)) {
                $ro_time_start = (float)explode(":", $row["ro_time_start"])[0] . "." .explode(":", $row["ro_time_start"])[1];

                if(isset($_POST["id"])) {
                    if($_POST["id"] != $row["ro_id"]) {
                        if($time_start < $ro_time_start + 0.5 && $time_start > $ro_time_start - 0.5) {
                            array_push($arr_bus_id, $row["ro_bus"]);
                        }    
                    }
                }else {
                    if($time_start < $ro_time_start + 1 && $time_start > $ro_time_start - 1) {
                        array_push($arr_bus_id, $row["ro_bus"]);
                    }
                }

            }

            $arr_bus_id = array_unique($arr_bus_id);

            $SQL = "SELECT * FROM tb_bus WHERE b_id ";

            
            if(isset($arr_bus_id[0])) {
                $SQL .= "NOT IN (";
                foreach($arr_bus_id as $val){
                    $SQL .= $val.",";
                }
                $SQL = substr($SQL, 0, -1);
                $SQL .= ")";
            }

            
            $busQuery = mysqli_query($con, $SQL);
            $busResult = mysqli_fetch_all($busQuery, MYSQLI_ASSOC);
            echo json_encode($busResult);
            
           
            // echo $SQL;
        }
    }
    // echo "ok";
?>
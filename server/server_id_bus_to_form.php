<?php 
    require "../connect.php";

    if(isset($_POST["pass"])) {
        if($_POST["pass"] == "hsr224"){
            $time_start_h = $_POST["time_start_h"];
            $time_start_m = $_POST["time_start_m"];
            $time_end_h = $_POST["time_end_h"];
            $time_end_m = $_POST["time_end_m"];

            $time_start = (float)"{$time_start_h}.{$time_start_m}";
            $time_end = (float)"{$time_end_h}.{$time_end_m}";

            $SQL = "SELECT * FROM tb_round_out";
            $roundQuery = mysqli_query($con, $SQL);

            $arr_bus_id = [];

            while ($row = mysqli_fetch_assoc($roundQuery)) {
                $ro_time_start = (float)explode(":", $row["ro_time_start"])[0] . "." .explode(":", $row["ro_time_start"])[1];
                $ro_time_end = (float)explode(":", $row["ro_time_end"])[0] . "." .explode(":", $row["ro_time_end"])[1];

                if ($ro_time_start < $ro_time_end) {
                    //วัดในระยะช่วงได้
                    if(
                        ($time_start >= $ro_time_start && $time_start <= $ro_time_end) 
                        || ($time_end >= $ro_time_start && $time_end <= $ro_time_end)
                        || ($ro_time_start >= $time_start && $ro_time_start <= $time_end)
                        || ($ro_time_end >= $time_start && $ro_time_end <= $time_end)
                    ) {
                        //ถ้าช่วงเวลาชนกันจะได้เป็น จริง
                        array_push($arr_bus_id, $row["ro_bus"]);
                    } 

                }else {
                    //วัดในระยะช่วงไม่ได้
                    if (
                        ($time_start >= $ro_time_start || $time_start <= $ro_time_end)
                        || ($time_end >= $ro_time_start || $time_end <= $ro_time_end)
                        || ($ro_time_start >= $time_start || $ro_time_start <= $time_end)
                        || ($ro_time_end >= $time_start || $ro_time_end <= $time_end)
                    ) {
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
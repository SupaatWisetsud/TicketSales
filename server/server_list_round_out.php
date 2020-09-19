<?php 
    session_start();
    require "../connect.php";

    if(isset($_GET["pass"])) {
        if($_GET["pass"] == "hsr224"){
           $SQL = "SELECT * FROM tb_round_out 
                    INNER JOIN tb_bus ON tb_round_out.ro_bus = tb_bus.b_id
                    INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
                    INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id";

           $roundQuery = mysqli_query($con, $SQL);
           $roundResult = mysqli_fetch_all($roundQuery, MYSQLI_ASSOC);

           $SQL = "SELECT * FROM tb_round_out 
                    INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
                    INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
                    GROUP BY ro_place_start, ro_place_end";

            $groupRoundQuery = mysqli_query($con, $SQL);
            $groupRoundResult = mysqli_fetch_all($groupRoundQuery, MYSQLI_ASSOC);

            $new_arr = array();

            $i = 0;
            foreach($groupRoundResult as $group) {
                
                $new_arr[$i]["round"] =  $group['ps_name']. " - " .$group['pe_name'];
                                
                $list_arr = array();

                foreach($roundResult as $round) {    
                    if($round["ro_place_start"] == $group["ro_place_start"] && $round["ro_place_end"] == $group["ro_place_end"]) {
                        array_push($list_arr, $round);
                    }
                }
                
                $new_arr[$i]["list"] = $list_arr;

                $i++;
            }

           echo json_encode($new_arr);

        }else {
            echo "error";
        }
    }
?>
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

           echo json_encode($roundResult);

        }else {
            echo "error";
        }
    }
?>
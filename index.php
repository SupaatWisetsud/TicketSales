<?php
session_start();
require "connect.php";

if (!isset($_SESSION["user_id"])) header("location:login.php");

$id = $_SESSION["user_id"];
$role = $_SESSION["user_role"];

$SQL = "SELECT * FROM tb_user WHERE u_id = '{$id}'";

$objQuery = mysqli_query($con, $SQL);
if (!mysqli_num_rows($objQuery)) header("location:login.php");

$user = mysqli_fetch_assoc($objQuery);

$SQL = "SELECT * FROM tb_round_out 
            INNER JOIN tb_bus ON tb_round_out.ro_bus = tb_bus.b_id
            INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
            INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id ORDER BY ro_time_start";

if (isset($_GET["btn_search"])) {
    $start = $_GET["search_start"];
    $end = $_GET["search_end"];
    
    if (trim($start) != "0" && trim($end) != "0") {
        $SQL = "SELECT * FROM tb_round_out 
            INNER JOIN tb_bus ON tb_round_out.ro_bus = tb_bus.b_id
            INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
            INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id 
            WHERE ro_place_start = '{$start}' && ro_place_end = '{$end}' ";
    }
    // echo $SQL;
    // exit;
}

$rountQuery = mysqli_query($con, $SQL);

if (isset($_GET["bus_id"]) && isset($_GET["ro_id"])) {

    $time_current = date('m/d/Y H:i:s', time());
    // explode()
    $SQL = "SELECT * FROM tb_book_seat WHERE bs_round_out = {$_GET["ro_id"]}";
    $bookSeatQuery = mysqli_query($con, $SQL);
    $bookSeatResult = mysqli_fetch_all($bookSeatQuery, MYSQLI_ASSOC);

    foreach ($bookSeatResult as $key => $val) {
        $timestamp_round = strtotime($val["bs_time"]) - 21600;
        $timestamp_current = strtotime($time_current);

        if ($timestamp_current > $timestamp_round) {

            $SQL = "DELETE FROM tb_book_seat WHERE bs_time LIKE '{$val["bs_time"]}'";
            mysqli_query($con, $SQL);
        }
    }
}

$SQL = "SELECT COUNT(*) as bs_count_round, bs_round_out FROM `tb_book_seat` GROUP BY bs_round_out";
$count_round = mysqli_query($con, $SQL);


$SQL = "SELECT * FROM tb_round_out 
        INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
        INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
        GROUP BY ro_place_start, ro_place_end";

if (isset($_GET["btn_search"])) {
    $start = $_GET["search_start"];
    $end = $_GET["search_end"];
    if (trim($start) != "0" && trim($end) != "0") {
        $SQL = "SELECT * FROM tb_round_out 
                INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
                INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
                WHERE ro_place_start = '{$start}' && ro_place_end = '{$end}' 
                GROUP BY ro_place_start, ro_place_end";
    }
}
$groupPlaceQuery = mysqli_query($con, $SQL);

if(isset($_GET["clean_seant"])){
    unset($_SESSION["set_select_seat"]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ticket Sales</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="node_modules\@fortawesome\fontawesome-free\css\all.min.css">

    <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />
</head>

<body class="skin-blue" >

    <input type="hidden" id="user" name="user" value="<?= $user['u_first_name'] .' '. $user['u_last_name'] ?>">
    <?php 
        if(isset($_GET['ro_id']) && isset($_GET['select_seat']) && isset($_GET['price']) && isset($_GET['bus_id'])){

            $SQL = "SELECT * FROM tb_round_out 
                    INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
                    INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
                    INNER JOIN tb_bus ON tb_round_out.ro_bus = tb_bus.b_id WHERE ro_id = {$_GET['ro_id']}";
            
            $sale_sendQuery = mysqli_query($con, $SQL);
            $sale_sendResult = mysqli_fetch_assoc($sale_sendQuery);

            $SQL = "SELECT * FROM tb_sales ORDER BY sale_id DESC LIMIT 1";
            $sale_idQuery = mysqli_query($con, $SQL);
            $sale_idResult = mysqli_fetch_assoc($sale_idQuery);
            
            if(!isset($sale_idResult['sale_id'])) {
                $sale_idResult['sale_id'] = 0;
            }
            echo "
            <input type='hidden' id='txt_ro_id' value='{$sale_sendResult['ro_id']}'>
            <input type='hidden' id='txt_user_id' value='{$_SESSION['user_id']}'>
            <input type='hidden' id='txt_price' value='{$sale_sendResult['ro_price']}'>
            <input type='hidden' id='txt_bus_id' value='{$sale_sendResult['b_id']}'>
            <input type='hidden' id='txt_bus_name' value='{$sale_sendResult['b_name']}'>
            <input type='hidden' id='txt_time_start' value='{$sale_sendResult['ro_time_start']}'>
            <input type='hidden' id='txt_ps_name' value='{$sale_sendResult['ps_name']}'>
            <input type='hidden' id='txt_pe_name' value='{$sale_sendResult['pe_name']}'>
            <input type='hidden' id='txt_sale_id' value='{$sale_idResult['sale_id']}'>
            ";
        }
    ?>

    <!-- header logo: style can be found in header.less -->
    <header class="header" id="body-header">
        <a href="index.php" class="logo">
            <img src="svg/parking_ticket.svg" width="35px" height="35px"/>บริษัทแสงสมชัย
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span> <?= $user["u_first_name"] . " " . $user["u_last_name"] ?>  </span>
                            <i class="fas fa-angle-down" style="font-size: 14px;margin-left: 5px;"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="img/user1.png" class="img-circle" alt="User Image" />
                                <p>
                                    คุณ <?= $user["u_first_name"] . " " . $user["u_last_name"] ?>
                                </p>
                                <small>สถานะ : <?= $role == 1 ? "ผู้ดูแล" : "พนักงาน" ?> </small>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="edit_profile.php" class="btn btn-default btn-flat"><i class="fas fa-male"></i> โปรไฟล์</a>
                                </div>
                                <div class="pull-right">
                                    <a href="logout.php" class="btn btn-default btn-flat"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left" id="body-content">
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="img/user1.png" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>คุณ <?= $user["u_first_name"] . " " . $user["u_last_name"] ?> </p>
                        <div>
                            <i class="fas fa-circle" style="font-size: 12px;color:#58D68D"></i>
                            <?= $role == 1 ? "ผู้ดูแล" : "พนักงาน" ?>
                        </div>
                    </div>
                </div>

                <?php require "navigation.php" ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 style="color: #616161;">
                    <i class="fas fa-home"></i>
                    หน้าหลัก
                    <small>Control panel</small>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- search form -->
                <form method="GET">
                    <div class="row">
                        <div class="col-md-7" style="margin-bottom: 5px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" name="search_start">
                                        <option value="0"></option>
                                        <?php
                                        $SQL = "SELECT * FROM tb_place_start";
                                        $place_start = mysqli_query($con, $SQL);
                                        $id_search_start = 0;
                                        $id_search_end = 0;

                                        if (isset($_GET["btn_search"])) {
                                            $id_search_start = $_GET["search_start"];
                                            $id_search_end = $_GET["search_end"];
                                        }

                                        while ($row = mysqli_fetch_assoc($place_start)) :
                                        ?>
                                            <option <?= $id_search_start == $row['ps_id'] ? "selected" : null ?> value="<?= $row['ps_id'] ?>"><?= $row["ps_name"] ?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1" style="display: flex; justify-content: center; align-items: center;">
                                    <i style="font-size:32px;color:#616161" class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" name="search_end">
                                        <option value="0"></option>
                                        <?php
                                        $SQL = "SELECT * FROM tb_place_end";
                                        $place_end = mysqli_query($con, $SQL);
                                        while ($row = mysqli_fetch_assoc($place_end)) :
                                        ?>
                                            <option <?= $id_search_end == $row['pe_id'] ? "selected" : null ?> value="<?= $row['pe_id'] ?>"><?= $row["pe_name"] ?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" name="clean_seant">
                                <div class="col-md-3">
                                    <button type="submit" name="btn_search" class="btn btn-primary">
                                        <i class="fas fa-search" style="font-size: 14px;"></i> ค้นหา
                                    </button>
                                    <a href="index.php?clean_seant" class="btn btn-warning">
                                        <i class="fas fa-undo-alt" style="font-size: 14px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-6">
                        <div style="margin-top: 15px;">
                                <?php 
                                    
                                    $rountResult = mysqli_fetch_all($rountQuery, MYSQLI_ASSOC);
                                    $seat_count_round = mysqli_fetch_all($count_round, MYSQLI_ASSOC);
                                    while($rowGroup = mysqli_fetch_assoc($groupPlaceQuery)){
                                ?>
                                    <h4 style="color: #616161;"><b><?= $rowGroup['ps_name']. " - " .$rowGroup['pe_name'] ?></b></h4>
                                            
                                    <div style="overflow-x: auto;">
                                    <table class="table text-center" >
                                        <thead style="background-color: #52BE80; color: white;">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">ต้นทาง</th>
                                                <th scope="col">เวลาออก</th>
                                                <th scope="col">ปลายทาง</th>
                                                <th scope="col">รถ</th>
                                                <th scope="col">ราคา</th>
                                                <th scope="col">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody style="color: #616161;">
                                            <?php 
                                                $i = 1;
                                               
                                                foreach ($rountResult as $row) {
                                                    // print_r($row);
                                                    // exit;
                                                    if($row["ro_place_start"] == $rowGroup["ro_place_start"]&&$row["ro_place_end"] == $rowGroup["ro_place_end"]) {
                                                        
                                                        $SQL = "SELECT COUNT(*) FROM tb_seat WHERE seat_bus = {$row['b_id']}";
                                                        $count_seat_in_bus = mysqli_fetch_row(mysqli_query($con, $SQL))[0];
                                                        
                                                        $check_full_seat = false;
                                                        foreach($seat_count_round as $check_seat){
                                                            if($check_seat["bs_round_out"] == $row["ro_id"] && $check_seat["bs_count_round"] == $count_seat_in_bus){
                                                                $check_full_seat = true;
                                                            }
                                                        }

                                            ?>

                                                    <tr class="<?= $_GET['ro_id'] == $row['ro_id'] ? 'select-row-seat' : null ?>">
                                                        <th scope="row"><?= $i ?></th>
                                                        <td><?= $row["ps_name"] ?></td>
                                                        <td><?= $row["ro_time_start"] ?></td>
                                                        <td><?= $row["pe_name"] ?></td>
                                                        <td><?= $row["b_name"]. " - " .$row["b_id"] ?></td>
                                                        <td><?= $row["ro_price"] ?></td>
                                                        <td><p class="label <?= $check_full_seat? 'label-danger':'label-success'?>"><?= $check_full_seat? 'เต็ม!':'ว่าง' ?></p></td>
                                                        <td>
                                                            <?php
                                                            $pach_search = isset($_GET["btn_search"]) ? "&search_start={$_GET['search_start']}&search_end={$_GET['search_end']}&btn_search=" : null
                                                            ?>
                                                            <a href="<?= "?clean_seant&ro_id=". $row['ro_id'] . "&bus_id=" . $row['b_id'] . "&price=" . $row["ro_price"] ?><?= $pach_search ?>">
                                                                <button class="btn btn-primary">
                                                                    <i class="far fa-check-circle" style="font-size: 15px;"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    }
                                                    $i++;
                                                }
                                            ?>
                                        
                                        </tbody>
                                    </table>
                                    </div>
                                <?php
                                    };
                                ?>
                               
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box-seat">
                            <div class="row" style="box-sizing: border-box; padding-left: 35px;display: flex;justify-content: space-between;">
                                <div style="flex: 1;">
                                    <p style="font-weight: bold;font-size: 18px;color:#616161"><i class="fas fa-swatchbook"></i> ที่นั้ง</p>
                                </div>
                                <?php 
                                    if(isset($_GET["ro_id"])){
                                        $SQL = "SELECT * FROM tb_round_out
                                        INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
                                        INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
                                        WHERE ro_id = {$_GET['ro_id']}";

                                        $get_place_start_end_query = mysqli_query($con, $SQL);
                                        $get_place_start_end_result = mysqli_fetch_assoc($get_place_start_end_query);

                                        echo "<div style='flex: 1;'>
                                                <p style='color:#616161;font-weight: bold;text-align: end;font-size: 18px;padding-right: 40px;'>{$get_place_start_end_result['ps_name']} - {$get_place_start_end_result['pe_name']}</p>
                                            </div>";
                                    }
                                ?>
                            </div>
                            <div class="box-seat-list" style="overflow-x: hidden;overflow-y: auto;">
                                <div class="row"">
                                    <?php

                                    if (isset($_GET["bus_id"]) && isset($_GET["ro_id"])) {
                                        $bus_id = $_GET["bus_id"];
                                        
                                        if (isset($_GET["select_seat"])) {
                                            if(!isset($_SESSION["set_select_seat"][$_GET["select_seat"]])){
                                                $_SESSION["set_select_seat"][$_GET["select_seat"]]["id"] = $_GET["select_seat"];
                                                $_SESSION["set_select_seat"][$_GET["select_seat"]]["name"] = $_GET["seat_name"];
                                            }else {
                                                unset($_SESSION["set_select_seat"][$_GET["select_seat"]]);
                                            }
                                            
                                        };
                                        

                                        $SQL = "SELECT * FROM tb_seat WHERE seat_bus = {$bus_id} ";
                                        $seatQuery = mysqli_query($con, $SQL);

                                        $pach_search = isset($_GET["btn_search"]) ? "&search_start={$_GET['search_start']}&search_end={$_GET['search_end']}&btn_search=" : null;

                                        $SQL = "SELECT * FROM tb_book_seat WHERE bs_round_out = {$_GET['ro_id']}";
                                        $bookSeatQuery = mysqli_query($con, $SQL);
                                        $bookSeatResult = mysqli_fetch_all($bookSeatQuery, MYSQLI_ASSOC);


                                        while ($row = mysqli_fetch_assoc($seatQuery)) {

                                            $book_seat_status = false;

                                            foreach ($bookSeatResult as $key => $value) {
                                                if ($value["bs_book_seat"] == $row["seat_id"]) {
                                                    $book_seat_status = true;
                                                }
                                            }

                                            if ($book_seat_status) {
                                    
                                                echo "<div class='col-md-3 col-sm-6 box-seat-item'>
                                                        <img src='svg/seat2.svg' class='box-seat-item-image status-red'>
                                                        <p class='label label-danger' style='margin-top: 8px;'>{$row["seat_name"]}</p>
                                                    </div>";
                                            
                                            } else { 

                                                if(isset($_SESSION["set_select_seat"][$row["seat_id"]])) {
                                                    echo "
                                                    <a href='?ro_id={$_GET['ro_id']}&bus_id={$_GET['bus_id']}&select_seat={$row['seat_id']}&price={$_GET['price']}$pach_search&seat_name'>
                                                        <div class='col-md-3 col-sm-6 box-seat-item select-box-seat'> 
                                                            <img src='svg/seat2.svg' class='box-seat-item-image'>
                                                            <p class='label label-success' style='margin-top: 8px;' >{$row['seat_name']}</p>
                                                        </div>
                                                    </a>";
                                                }else {
                                                    echo "
                                                    <a href='?ro_id={$_GET['ro_id']}&bus_id={$_GET['bus_id']}&seat_name={$row['seat_name']}&select_seat={$row['seat_id']}&price={$_GET['price']}$pach_search'>
                                                        <div class='col-md-3 col-sm-6 box-seat-item'> 
                                                            <img src='svg/seat2.svg' class='box-seat-item-image'>
                                                            <p class='label label-success' style='margin-top: 8px;' >{$row['seat_name']}</p>
                                                        </div>
                                                    </a>";
                                                }
                                                
                                                // $select_seat == $row["seat_id"] ? 'select-box-seat' : null

                                            }
                                        };
                                    } else {
                                    ?>
                                        <div class=" text-center" style="display: flex; justify-content: center; align-items: center;height: 350px;">
                                            <p>...กรุณาเลือกรอบที่ต้องการเดินทาง...</p>
                                        </div>
                                <?php
                                    }
                                ?>

                            </div>
                        </div>

                        <div class="box-seat-footer">
                            <!-- <div class="group-detail-index">
                                <h3></h3>
                                <h3>
                                    ราคา : &emsp;<?= isset($_GET["price"]) ? $_GET["price"] : 0 ?> &emsp; ฿
                                </h3>
                            </div> -->
                            <div class="group-btn-index" style="margin-top: 25px;">
                                <?php
                                $btn_sale = false;
                                if (isset($_GET['ro_id']) && isset($_GET['bus_id']) && isset($_GET['select_seat']) && isset($_GET['price'])) {
                                    $btn_sale = true;
                                }
                                ?>
                                <button 
                                    onclick="sale('printableArea')" 
                                    class="btn btn-success" 
                                    style="margin-right: 5px;" <?= !$btn_sale ? "disabled" : null ?>
                                >
                                    <i class="fas fa-clipboard-check" style="font-size: 14px;color:white;"></i>
                                    ขายตั๋ว
                                </button>
                                <a href="index.php?clean_seant">
                                    <button class="btn btn-danger">
                                        <i class="far fa-window-close" style="font-size: 14px;color:white;"></i>
                                        ยกเลิก
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->

    </div><!-- ./wrapper -->
    <?php 
        if(isset($_SESSION["set_select_seat"])) {
            foreach ($_SESSION["set_select_seat"] as $value) {
                echo "
                <input type='hidden' class='set_select_seat_id' value='{$value['id']}'>
                <input type='hidden' class='set_select_seat_name' value='{$value['name']}'>
                ";
            }
        }
    ?>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>
    <script src="js/printIndex.js" type="text/javascript"></script>

</body>
</html>

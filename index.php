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
            INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id";


if(isset($_GET["btn_search"])) {
    $start = $_GET["search_start"];
    $end = $_GET["search_end"];

    $SQL = "SELECT * FROM tb_round_out 
            INNER JOIN tb_bus ON tb_round_out.ro_bus = tb_bus.b_id
            INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
            INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id 
            WHERE ro_place_start = '{$start}' && ro_place_end = '{$end}' ";
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
    
    $get_time_current_round = false;
    if(isset($bookSeatResult[0])){
        $get_time_current_round = $bookSeatResult[0]["bs_time"]; 
    }
    
    if ($get_time_current_round != false) {
        $timestamp_round = strtotime($get_time_current_round) - 18000;
        $timestamp_current = strtotime($time_current);

        if ($timestamp_current > $timestamp_round) {
            $SQL = "DELETE FROM tb_book_seat WHERE bs_round_out = {$_GET["ro_id"]}";
            mysqli_query($con, $SQL);
        }
    }

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
    <!-- font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />

</head>

<body class="skin-blue">


    <input type="hidden" id="txt_ro_id" value="<?= $_GET['ro_id'] ?>">
    <input type="hidden" id="txt_user_id" value="<?= $_GET['user_id'] ?>">
    <input type="hidden" id="txt_select_seat" value="<?= $_GET['select_seat'] ?>">
    <input type="hidden" id="txt_price" value="<?= $_GET['price'] ?>">

    <div id="printableArea" style="display: none;">
        <h1>Print me</h1>
    </div>
    <!-- header logo: style can be found in header.less -->
    <header class="header">
        <a href="index.php" class="logo">
            Ticket Sales
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
                            <i class="glyphicon glyphicon-user"></i>
                            <span> <?= $user["u_first_name"] . " " . $user["u_last_name"] ?> <i class="caret"></i></span>
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
                                    <a href="#" class="btn btn-default btn-flat">โปรไฟล์</a>
                                </div>
                                <div class="pull-right">
                                    <a href="logout.php" class="btn btn-default btn-flat">ออกจากระบบ</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
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
                            <i class="fa fa-circle text-success"></i>
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
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- search form -->
                <form method="GET">
                <div class="row">
                    <div class="col-md-6" style="margin-bottom: 5px;">
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control" name="search_start">
                                    <option value="0"></option>
                                    <?php 
                                        $SQL = "SELECT * FROM tb_place_start";
                                        $place_start = mysqli_query($con, $SQL);
                                        $id_search_start = 0;
                                        $id_search_end = 0;

                                        if (isset($_GET["btn_search"])){
                                            $id_search_start = $_GET["search_start"];
                                            $id_search_end = $_GET["search_end"];
                                        }

                                        while($row=mysqli_fetch_assoc($place_start)):
                                    ?>
                                            <option <?= $id_search_start == $row['ps_id']? "selected":null ?> value="<?= $row['ps_id'] ?>"><?= $row["ps_name"] ?></option>
                                    <?php 
                                        endwhile;
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-1" style="display: flex; justify-content: center; align-items: center;">
                            <i class="fas fa-angle-double-right"></i>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="search_end">
                                    <option value="0"></option>
                                    <?php 
                                        $SQL = "SELECT * FROM tb_place_end";
                                        $place_end = mysqli_query($con, $SQL);
                                        while($row=mysqli_fetch_assoc($place_end)):
                                    ?>
                                            <option <?= $id_search_end == $row['pe_id']? "selected":null ?> value="<?= $row['pe_id'] ?>"><?= $row["pe_name"] ?></option>
                                    <?php 
                                        endwhile;
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3"> 
                                <button type="submit" name="btn_search" class="btn btn-primary">
                                    ค้นหา
                                </button>
                                <a href="index.php" class="btn btn-warning">reset</a>
                            </div>
                        </div>
                    </div>
                </div>
                </form>

                <div class="row">
                    <div class="col-md-6">
                        <div style="overflow-x: auto;">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Place Start</th>
                                        <th scope="col">Time Start</th>
                                        <th scope="col">Place End</th>
                                        <th scope="col">Time End</th>
                                        <th scope="col">Bus</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1; 
                                        while($row = mysqli_fetch_assoc($rountQuery)): 
                                    ?>
                                    <tr  class="<?= $_GET['ro_id'] == $row['ro_id'] ? 'select-row-seat' : null ?>">
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $row["ps_name"] ?></td>
                                        <td><?= $row["ro_time_start"] ?></td>
                                        <td><?= $row["pe_name"] ?></td>
                                        <td><?= $row["ro_time_end"] ?></td>
                                        <td><?= $row["b_name"] ?></td>
                                        <td><?= $row["ro_price"] ?></td>
                                        <td><?= "ว่าง" ?></td>
                                        <td>
                                            <?php 
                                                $pach_search = isset($_GET["btn_search"])? "&search_start={$_GET['search_start']}&search_end={$_GET['search_end']}&btn_search=":null
                                            ?>
                                            <a href="<?= "?ro_id=".$row['ro_id']."&bus_id=".$row['b_id']."&price=".$row["ro_price"] ?><?= $pach_search?>">
                                                <button class="btn btn-primary">เลือก</button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                        $i++; 
                                        endwhile;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box-seat">
                            <div class="row" style="text-align: center;">
                                <h3>ที่นั้ง</h3>
                            </div>
                            <div class="box-seat-list" style="overflow-x: hidden;overflow-y: auto;" >
                                <div class="row"">
                                    <?php 

                                        if(isset($_GET["bus_id"]) && isset($_GET["ro_id"])){
                                            $bus_id = $_GET["bus_id"];
                                            $select_seat = 0;
                                            if(isset($_GET["select_seat"])) $select_seat = $_GET["select_seat"];

                                            $SQL = "SELECT * FROM tb_seat WHERE seat_bus = {$bus_id} ";
                                            $seatQuery = mysqli_query($con, $SQL);

                                            $pach_search = isset($_GET["btn_search"])? "&search_start={$_GET['search_start']}&search_end={$_GET['search_end']}&btn_search=":null;

                                            $SQL = "SELECT * FROM tb_book_seat WHERE bs_round_out = {$_GET['ro_id']}";
                                            $bookSeatQuery = mysqli_query($con, $SQL);
                                            $bookSeatResult = mysqli_fetch_all($bookSeatQuery, MYSQLI_ASSOC);

                                            
                                            while($row = mysqli_fetch_assoc($seatQuery)):
                                                
                                                $book_seat_status = false;

                                                foreach ($bookSeatResult as $key => $value) {
                                                    if ($value["bs_book_seat"] == $row["seat_id"]){
                                                        $book_seat_status = true;
                                                    }
                                                }

                                                if($book_seat_status){
                                    ?>
                                            
                                                
                                                <div class="col-md-3 col-sm-6 box-seat-item">
                                                    <img src="svg/seat.svg" class="box-seat-item-image status-red">
                                                    <p class="status_red"><?= $row["seat_name"] ?></p>
                                                </div>
                                                <?php } else {?>
                                                <a href="<?= "?ro_id=".$_GET["ro_id"]."&bus_id=".$_GET["bus_id"]."&select_seat=".$row["seat_id"]."&price=".$_GET["price"].$pach_search ?>">
                                                    <div class="col-md-3 col-sm-6 box-seat-item <?= $select_seat == $row["seat_id"]? 'select-box-seat':null ?>">
                                                        <img src="svg/seat.svg" class="box-seat-item-image">
                                                        <p class="status_green""><?= $row["seat_name"] ?></p>
                                                    </div>
                                                </a>
                                    <?php 
                                                }
                                            endwhile;
                                        }else {
                                    ?>
                                            <div class="text-center">
                                                <p>...กรุณาเลือกรอบที่ต้องการเดินทาง...</p>
                                            </div>
                                    <?php
                                        }
                                    ?>

                                </div >
                            </div>
                        </div>

                        <div class="box-seat-footer">
                            <div class="group-detail-index">
                                <h3>ราคา :</h3>
                                <h3><?= isset($_GET["price"])? $_GET["price"]:0 ?> ฿</h3>
                            </div>
                            <div class="group-btn-index">
                                <?php 
                                    $btn_sale = false;
                                    if (isset($_GET['ro_id']) && isset($_GET['bus_id']) && isset($_GET['select_seat']) && isset($_GET['price'])) {
                                        $btn_sale = true;
                                    }
                                ?>
                                <button onclick="printDiv('printableArea')" class="btn btn-success" style="margin-right: 5px;" <?= !$btn_sale? "disabled":null?> >
                                    ขายตั๋ว
                                </button>
                                <button class="btn btn-danger">ยกเลิก</button>
                            </div>
                        </div>

                    </div>
                </div>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>

</body>

</html>
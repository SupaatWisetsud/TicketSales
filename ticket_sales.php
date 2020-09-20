<?php
session_start();
require "connect.php";

if (!isset($_SESSION["user_id"])) header("location:login.php");
if (!isset($_SESSION["user_role"])) header("location:index.php");
if ($_SESSION["user_role"] != 1) header("location:index.php");

$id = $_SESSION["user_id"];
$role = $_SESSION["user_role"];

$SQL = "SELECT * FROM tb_user WHERE u_id = '{$id}'";

$objQuery = mysqli_query($con, $SQL);
if (!mysqli_num_rows($objQuery)) header("location:login.php");
$user = mysqli_fetch_assoc($objQuery);

$SQL = "SELECT 
        COUNT(tb_sales.sale_round) as sale_count,
        tb_place_start.ps_name,
        tb_round_out.ro_time_start,
        tb_place_end.pe_name,
        tb_round_out.ro_price
        FROM tb_sales
        INNER JOIN tb_round_out ON tb_sales.sale_round = tb_round_out.ro_id
        INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id
        INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
        GROUP BY sale_round 
        ORDER BY sale_count DESC
        LIMIT 5";

$topQuery = mysqli_query($con, $SQL);

$page = 1;
$limit = 8;

if (isset($_GET["page"])) {
    $page = (int)$_GET["page"];
}
if (isset($_GET["limit"])) {
    $limit = (int)$_GET["limit"];
}

$SQL = "SELECT COUNT(*) FROM tb_sales ";
$count_sale = mysqli_fetch_row(mysqli_query($con, $SQL))[0];

$count_page = ceil($count_sale / $limit);

$SQL = "SELECT 
        *
        FROM tb_sales
        INNER JOIN tb_user ON tb_sales.sale_emp = tb_user.u_id
        INNER JOIN tb_round_out ON tb_sales.sale_round = tb_round_out.ro_id
        INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id
        INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
        INNER JOIN tb_bus ON tb_round_out.ro_bus = tb_bus.b_id
        INNER JOIN tb_seat ON tb_sales.sale_seat = tb_seat.seat_id
        ORDER BY tb_sales.sale_time_sale DESC
        LIMIT " . ($page - 1) * $limit . "," . $limit;

$listSaleQuery = mysqli_query($con, $SQL);

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
    <link rel="stylesheet" href="node_modules\@fortawesome\fontawesome-free\css\all.min.css">

    <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />

    <style>
        @media print {
            #navigation_sales, 
            #print_report,
            #show_count_page {
                display:none;
            }
            #title_chart {
                display: block !important;
            }
            #myChartLine {
                width: 100% !important;
            }
            #show_count_page_print {
                display: block !important;
            }
        }

        /* #title_chart {
            display: none;
        } */
    </style>
</head>

<body class="skin-blue" style="color: #616161;">
    <!-- header logo: style can be found in header.less -->
    <header class="header">
        <a href="index.php" class="logo">
            <img src="svg/parking_ticket.svg" width="35px" height="35px" />Ticket Sales
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
                            <span> <?= $user["u_first_name"] . " " . $user["u_last_name"] ?></span>
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
                            <i class="fas fa-circle" style="font-size: 12px;color:#58D68D"></i>
                            <?= $role == 1 ? "ผู้ดูแล" : "พนักงาน" ?>
                        </div>
                    </div>
                </div>

                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->

                <?php require "navigation.php" ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <i class="fas fa-ticket-alt"></i> รายงานการขายตั๋ว
                    <small>Control panel</small>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content container">

                <div class="row">
                    <!-- show page -->
                    <div id="show_count_page">
                        <div class="col-md-4">
                            <div class="box-chart" style="background-color: #7E8987;">
                                <?php
                                $SQL = "SELECT COUNT(*) FROM tb_sales";
                                $countSaleQuery = mysqli_query($con, $SQL);
                                $countSale = mysqli_fetch_row($countSaleQuery);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><i class="fas fa-ticket-alt"></i> จำนวนการขายตั๋ว</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <h3><?= $countSale[0] ?> ตั๋ว</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box-chart" style="background-color: #C2CFB2;">
                                <?php
                                $SQL = "SELECT SUM(sale_price) FROM tb_sales";
                                $countPriceQuery = mysqli_query($con, $SQL);
                                $countPrice = mysqli_fetch_row($countPriceQuery);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><i class="fas fa-clipboard-list"></i> ยอดการขาย</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <h3><?= $countPrice[0] ?> ฿</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <button class="btn btn-warning" id="print_report" onclick="printReport()">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>
                
                <!-- show in print -->
                <div class="row" id="show_count_page_print" style="display: none;">
                    <div style="padding-left: 25px;display: flex; justify-content: space-between;">
                        <h1 style=" font-weight: bold;">Ticket Sales</h1>
                        <p><?= date('m/d/Y H:i:s', time()) ?></p>
                    </div>
                    <div style="padding-left: 20px;margin-top: 1%;">
                        <?php
                        $SQL = "SELECT COUNT(*) FROM tb_sales";
                        $countSaleQuery = mysqli_query($con, $SQL);
                        $countSale = mysqli_fetch_row($countSaleQuery);
                        ?>
                        <div class="row" style="display: flex; padding-left: 25px;">
                            <div style="flex: 1;">
                                <h4 style="margin-right: 80px;"><i class="fas fa-ticket-alt"></i> จำนวนการขายตั๋ว</h4>
                            </div>
                            <div style="flex: 1;justify-content: end; align-items: flex-end;">
                                <h4><?= $countSale[0] ?> ตั๋ว</h4>
                            </div>
                        </div>
                        <?php
                        $SQL = "SELECT SUM(sale_price) FROM tb_sales";
                        $countPriceQuery = mysqli_query($con, $SQL);
                        $countPrice = mysqli_fetch_row($countPriceQuery);
                        ?>
                        <div class="row" style="display: flex; padding-left: 25px;">
                            <div style="flex: 1;">
                                <h4 style="margin-right: 80px;"><i class="fas fa-clipboard-list"></i> ยอดการขาย</h4>
                            </div>
                            <div style="flex: 1;justify-content: end; align-items: flex-end;">
                                <h4><?= $countPrice[0] ?> ฿</h4>
                            </div>
                        </div>
                    </div>
                </div>

                    

                <div class="row">
                    <div class="col-md-6">
                        <?php 
                            $month = [
                                "มกราคม (January)",
                                "กุมภาพันธ์ (February)",
                                "มีนาคม (March)",
                                "เมษายน (April)",
                                "พฤษภาคม (May)",
                                "มิถุนายน (June)",
                                "กรกฎาคม (July)",
                                "สิงหาคม (August)",
                                "กันยายน (September)",
                                "ตุลาคม (October)",
                                "พฤศจิกายน (November)",
                                "ธันวาคม (December)"
                            ]
                        ?>
                        <div id="title_chart" style="display: none;text-align: center;border: 1px solid #333;margin-top: 5%;">
                            <h4 style="font-weight: bold;">กราฟแสดงยอดการขายในเดือน <?= $month[(int)date('m') - 1] ?></h4>
                        </div>
                        <div class="chart" style="border: 1px solid #333; border-radius: 5px;">
                            <canvas id="myChartLine" width="400" height="250"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="chart">
                            <h4 style="font-weight: bold;"> <i class="fab fa-hotjar" style="color: red;"></i> 5 อันดับรอบที่ขายดี</h4>
                            <div class="box-table-chart">
                                <div style="overflow-y: auto;">
                                    <table class="table table-striped text-center">
                                        <thead style="background-color: #4B4A67;color: white;">
                                            <tr>
                                                <th>No.</th>
                                                <th>รอบออก</th>
                                                <th>เวลาออก</th>
                                                <th>รอบถึง</th>
                                                <th>ราคา</th>
                                                <th>จำนวนยอดขาย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($topQuery)) :
                                            ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $row["ps_name"] ?></td>
                                                    <td><?= $row["ro_time_start"] ?></td>
                                                    <td><?= $row["pe_name"] ?></td>
                                                    <td><?= $row["ro_price"] ?></td>
                                                    <td><?= $row["sale_count"] ?></td>
                                                </tr>
                                            <?php
                                                $i++;
                                            endwhile;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3 style="font-weight: bold;"> <i class="far fa-list-alt"></i> รายการขายตั๋ว</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-table-chart">
                            <div style="overflow-y: auto;">
                                <table class="table table-striped text-center" id="list_sale_table">
                                    <thead style="background-color: #4B4A67; color:white">
                                        <tr>
                                            <th>No.</th>
                                            <th>รอบออก</th>
                                            <th>เวลาออก</th>
                                            <th>รอบถึง</th>
                                            <th>ที่นั้ง</th>
                                            <th>รถ</th>
                                            <th>ผู้ขายตั๋ว</th>
                                            <th>ราคา</th>
                                            <th>วันที่/เดือน/ปี</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($listSaleQuery)) : ?>
                                            <tr>
                                                <td><?= $row["sale_id"] ?></td>
                                                <td><?= $row["ps_name"] ?></td>
                                                <td><?= $row["ro_time_start"] ?></td>
                                                <td><?= $row["pe_name"] ?></td>
                                                <td><?= $row["seat_name"] ?></td>
                                                <td><?= $row["b_name"]. " - " .$row["b_id"] ?></td>
                                                <td><?= $row["u_first_name"] . " " . $row["u_last_name"] ?></td>
                                                <td><?= $row["sale_price"] ?></td>
                                                <td><?= $row["sale_time_sale"] ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <nav aria-label="Page navigation" id="navigation_sales">
                                        <ul class="pagination">
                                            <?php
                                            $page_current = 1;
                                            if (isset($_GET["page"])) $page_current = (int)$_GET["page"];
                                            for ($i = 1; $i <= $count_page; $i++) :
                                            ?>
                                                <li class="page-item <?= $page_current == $i ? 'active' : null ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php endfor; ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <!-- add new calendar event modal -->


    <!-- jQuery 2.0.2 -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>

    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>
    <!-- <script src="js/round_out.js" type="text/javascript"></script> -->
    <script src="js/printChart.js" type="text/javascript"></script>
    <script src="node_modules/chart.js/dist/Chart.min.js"></script>
</body>

</html>

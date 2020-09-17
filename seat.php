<?php
session_start();
require "connect.php";

if (!isset($_SESSION["user_id"])) header("location:login.php");

$id = $_SESSION["user_id"];
$role = $_SESSION["user_role"];

$SQL = "SELECT * FROM tb_user WHERE u_id = '{$id}'";

$objQuery = mysqli_query($con, $SQL);
$user = mysqli_fetch_assoc($objQuery);

$SQL = "SELECT * FROM tb_bus ";
$busQuery = mysqli_query($con, $SQL);


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
    <!-- Theme style -->
    <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />

</head>

<body class="skin-blue">
    <!-- header logo: style can be found in header.less -->
    <header class="header">
        <a href="index.php" class="logo">
            <img src="svg/parking_ticket.svg" width="35px" height="35px"/>Ticket Sales
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
                    <i class="fas fa-shuttle-van"></i> รถ / ที่นั้ง
                    <small>Control panel</small>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content" style="min-height: 500px;">

                <div id="myModal" class="modal">
                    <div class="modal-content-seat">
                        <a href="?bus_id=<?=$_GET['bus_id']?>"><span class="close">&times;</span></a>
                        <div class="text-center">
                            <h3>เพิ่มที่นั้ง</h3>
                        </div>
                        <form action="action/action_add_seat.php" method="POST">
                            <input type="hidden" name="bus_id" value="<?= $_GET['bus_id'] ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="name_seat" class="form-control" placeholder="กรุณาใส่ชื่อที่นั้ง" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right" style="margin-top: 15px;">
                                    <button type="submit" name="btn_add_seat" class="btn btn-success"> <i class="fas fa-plus"></i> เพิ่ม</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div id="myModalcar" class="modal">
                    <div class="modal-content-seat">
                        <span class="close">&times;</span>
                        <div class="text-center">
                            <h3> เพิ่มรถโดยสาร</h3>
                        </div>
                        <form action="action/action_add_car.php" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="name_car" class="form-control" placeholder="กรุณาใส่ชื่อหรือประเภทของรถ" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right" style="margin-top: 15px;">
                                    <button type="submit" name="btn_add_car" class="btn btn-success"><i class="fas fa-plus"></i> เพิ่ม</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <div style="text-align: center; position: relative;">
                                <h3 ><i class="fas fa-shuttle-van"></i> รถโดยสาร</h3>
                            </div>
                            <div style="position: absolute;top: 5px;right: 5px;">
                                <button id="btn-add-car" class="btn btn-success"> <i class="fas fa-plus"></i> เพิ่มรถโดยสาร</button>
                            </div>
                            <table class="table text-center" style="margin-top: 15px;">
                                <thead>
                                    <tr>
                                        <th scope="col"> <i class="fas fa-sort-numeric-down"></i> #</th>
                                        <th scope="col"><i class="fab fa-ideal"></i> ไอดี</th>
                                        <th scope="col"><i class="fas fa-calendar-week"></i> ชื่อ/ประเภท</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($busQuery)) :
                                    ?>
                                        <tr class="<?= $_GET['bus_id'] == $row['b_id'] ? 'select-row-seat' : null ?>">
                                            <th scope="row"><?= $i ?></th>
                                            <td><?= $row["b_id"] ?></td>
                                            <td><?= $row["b_name"] ?></td>
                                            <td>
                                                <a href="?bus_id=<?= $row["b_id"] ?>">
                                                    <button class="btn btn-primary"><i class="fas fa-check-circle"></i></button>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="action/action_delete_car.php?bus_id=<?= $row["b_id"] ?>">
                                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
                    <div class="col-md-8">

                        <div class="box">
                            <div style="text-align: center; position: relative;">
                                <h3><i class="fas fa-chair"></i> ที่นั้ง</h3>
                            </div>
                            <div style="position: absolute;top: 10px;right: 10px;">
                                <button id="myBtn" class="btn btn-success" <?= !isset($_GET["bus_id"]) ? "disabled" : null ?>><i class="fas fa-plus"></i> เพิ่มที่นั้ง</button>
                            </div>
                            <table class="table text-center" style="margin-top: 15px;">
                                <thead>
                                    <tr>
                                        <th scope="col"> <i class="fas fa-sort-numeric-down"></i> #</th>
                                        <th scope="col"><i class="fab fa-ideal"></i> ไอดี</th>
                                        <th scope="col"><i class="fas fa-calendar-week"></i> ชื่อที่นั้ง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $edit = false;
                                    $edit_id = 0;
                                    if (isset($_GET["edit"]) && isset($_GET["seat_id"])) {
                                        $edit = true;
                                        $edit_id = $_GET["seat_id"];
                                    };
                                    if (isset($_GET["bus_id"])) {
                                        $bus_id = $_GET["bus_id"];

                                        $SQL = "SELECT * FROM tb_seat WHERE seat_bus = '{$bus_id}' ";

                                        $seatQuery = mysqli_query($con, $SQL);
                                        while ($row = mysqli_fetch_assoc($seatQuery)) :
                                            if($edit && $edit_id == $row["seat_id"]){
                                    ?>
                                             <tr>
                                                <form action="action/action_update_seat.php" method="POST">
                                                    <input type="hidden" name="bus_id" value="<?= $bus_id ?>">
                                                    <input type="hidden" name="seat_id" value="<?= $row["seat_id"] ?>">
                                                    <th scope="row"><?= $i ?></th>
                                                    <td><?= $row["seat_id"] ?></td>
                                                    <td style="width: 30%;">
                                                        <input type="text" class="form-control" name="seat_name" value="<?= $row['seat_name'] ?>">
                                                    </td>
                                                    <td>
                                                        <button type="submit" name="btn_update_seat" class="btn btn-primary"><i class="fas fa-pen-alt"></i></button>
                                                    </td>
                                                </form>
                                                    <td>
                                                        <a href="?bus_id=<?= $bus_id ?>">
                                                            <button class="btn btn-danger"><i class="fas fa-slash"></i></button>
                                                        </a>
                                                    </td>
                                            </tr>

                                            <?php
                                                }else {
                                            ?>
                                            
                                            <tr>
                                                <th scope="row"><?= $i ?></th>
                                                <td><?= $row["seat_id"] ?></td>
                                                <td><?= $row["seat_name"] ?></td>
                                                <td>
                                                    <a href="?edit=1&bus_id=<?= $_GET['bus_id'] ?>&seat_id=<?= $row['seat_id'] ?>">
                                                        <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="action/action_delete_seat.php?id=<?= $row['seat_id'] ?>&bus=<?= $bus_id ?>">
                                                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                    </a>
                                                </td>
                                            </tr>
                                           
                                    <?php
                                            }
                                            $i++;
                                        endwhile;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <!-- add new calendar event modal -->


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>
    <script src="js/seat.js" type="text/javascript"></script>
</body>

</html>
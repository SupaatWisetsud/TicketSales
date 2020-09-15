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
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />

</head>

<body class="skin-blue">
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
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content" style="min-height: 500px;">

                <div id="myModal" class="modal container">

          
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
                                    <button type="submit" name="btn_add_seat" class="btn btn-success">เพิ่ม</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <div style="text-align: center;">
                                <h3>Bus</h3>
                            </div>
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Select</th>
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
                                                    <button class="btn btn-success">Select</button>
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
                                <h3>Seat</h3>
                            </div>
                            <div style="position: absolute;top: 10px;right: 10px;">
                                <button id="myBtn" class="btn btn-primary" <?= !isset($_GET["bus_id"]) ? "disabled" : null ?>>เพิ่มที่นั้ง</button>
                            </div>
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
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
                                                        <button type="submit" name="btn_update_seat" class="btn btn-primary">Update</button>
                                                    </td>
                                                </form>
                                                    <td>
                                                        <a href="?bus_id=<?= $bus_id ?>">
                                                            <button class="btn btn-danger">Cancel</button>
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
                                                        <button class="btn btn-warning">Edit</button>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="action/action_delete_seat.php?id=<?= $row['seat_id'] ?>&bus=<?= $bus_id ?>">
                                                        <button class="btn btn-danger">Delete</button>
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


    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- jQuery UI 1.10.3 -->
    <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <!-- AdminLTE App -->
    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>
    <script src="js/index.js" type="text/javascript"></script>
</body>

</html>
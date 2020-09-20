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

$SQL = "SELECT * FROM tb_place_start";

if(isset($_SESSION["seach_ps"])) {
    $SQL = "SELECT * FROM tb_place_start WHERE ps_name LIKE '%{$_SESSION['seach_ps']}%'";
}

$psQuery = mysqli_query($con, $SQL);

$SQL = "SELECT * FROM tb_place_end";

if(isset($_SESSION["seach_pe"])) {
    $SQL = "SELECT * FROM tb_place_end WHERE pe_name LIKE '%{$_SESSION['seach_pe']}%'";
}

$peQuery = mysqli_query($con, $SQL);

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

</head>

<body class="skin-blue" style="color: #616161;">
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
                    <i class="fas fa-users"></i> ต้นทาง / ปลายทาง
                    <small>Control panel</small>
                </h1>
                <!-- .breadcrumb -->
            </section>

            <!-- Main content -->
            <section class="content">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="box" style="padding: 10px;">

                            <!-- header -->
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 style="font-weight: bold;"><i class="fas fa-train"></i> ต้นทาง</h4>
                                </div>
                                <div class="col-md-8">
                                    <form action="action/action_add_ps.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-6" style="padding: 0px;">
                                                <input type="text" name="name" class="form-control" placeholder="กรุณาใส่ชื่อสถานที่">
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-success" name="btn_add_ps" style="width: 100%;"><i class="fas fa-plus"></i> เพิ่ม</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-primary" name="btn_seach_ps" style="width: 100%;"><i class="fas fa-search" style="font-size: 14px;"></i> ค้นหา</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped text-center" style="margin-top: 10px;box-sizing: border-box;">
                                        <thead class="thead-dark" style="background-color: #4B4A67;color:white">
                                            <tr>
                                                <th scope="col">
                                                    <i class="fas fa-sort-numeric-down"></i>
                                                    No.
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-signature"></i>
                                                    ชื่อสถานที่
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 1;
                                                while($row = mysqli_fetch_assoc($psQuery)): 
                                            ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $row["ps_name"] ?></td>
                                                    <td>
                                                        <a href="action/action_delete_ps.php?id=<?= $row["ps_id"] ?>">
                                                            <button class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
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


                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box" style="padding: 10px;">
            
                            <!-- header -->
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 style="font-weight: bold;"><i class="fas fa-tram"></i> ปลายทาง</h4>
                                </div>
                                <div class="col-md-8">
                                    <form action="action/action_add_pe.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-6" style="padding: 0px;">
                                                <input type="text" name="name" class="form-control" placeholder="กรุณาใส่ชื่อสถานที่">
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-success" name="btn_add_pe" style="width: 100%;"><i class="fas fa-plus"></i> เพิ่ม</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-primary" name="btn_seach_pe" style="width: 100%;"><i class="fas fa-search" style="font-size: 14px;"></i> ค้นหา</ิ>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped text-center" style="margin-top: 10px;box-sizing: border-box;">
                                        <thead class="thead-dark" style="background-color: #4B4A67;color:white">
                                            <tr>
                                                <th scope="col">
                                                    <i class="fas fa-sort-numeric-down"></i>
                                                    No.
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-signature"></i>
                                                    ชื่อสถานที่
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 1;
                                                while($row = mysqli_fetch_assoc($peQuery)): 
                                            ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $row["pe_name"] ?></td>
                                                    <td>
                                                        <a href="action/action_delete_pe.php?id=<?= $row["pe_id"] ?>">
                                                            <button class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
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
                            
                        </div>
                    </div>
                </div>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>


</body>

</html>
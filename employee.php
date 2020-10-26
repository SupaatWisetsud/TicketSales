<?php
session_start();
require "connect.php";

if (!isset($_SESSION["user_id"])) header("location:login.php");
if ($_SESSION["user_role"] != 1) header("location:login.php");

$id = $_SESSION["user_id"];
$role = $_SESSION["user_role"];

$SQL = "SELECT * FROM tb_user WHERE u_id = '{$id}'";

$objQuery = mysqli_query($con, $SQL);
if (!mysqli_num_rows($objQuery)) header("location:login.php");

$user = mysqli_fetch_assoc($objQuery);

$SQL = "SELECT * FROM tb_user WHERE u_id != '{$id}'";

$objUserAll = mysqli_query($con, $SQL);

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

<body class="skin-blue">
    <!-- header logo: style can be found in header.less -->
    <header class="header">
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
                <h1 style="color: #616161;">
                    <i class="fas fa-users"></i> พนักงาน
                    <small>Control panel</small>
                </h1>
                <!-- .breadcrumb -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container" style="margin-bottom: 10px;">
                    <a href="add_emp.php">
                        <button class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            เพิ่มลูกจ้าง
                        </button>
                    </a>
                    <!-- print -->
                    <button class="btn btn-warning" onclick="listUser()">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
                <div class="container" style="overflow-x: auto;">
                    <table class="table table-striped text-center" style="margin-top: 10px;box-sizing: border-box;">
                        <thead class="thead-dark" style="background-color: #4B4A67;color:white">
                            <tr>
                                <th scope="col">
                                    <i class="fas fa-sort-numeric-down"></i>
                                    No.
                                </th>
                                <th scope="col">
                                    <i class="fas fa-envelope-square"></i>
                                    อีเมลล์
                                </th>
                                <th scope="col">
                                    <i class="fas fa-signature"></i>
                                    ชื่อ - นามสกุล
                                </th>
                                <th scope="col">
                                    <i class="fas fa-signature"></i>
                                    ที่อยู่
                                </th>
                                <th scope="col">
                                    <i class="fas fa-shield-alt"></i>
                                    สถานะใช้งาน
                                </th>
                                <th scope="col">
                                    <i class="fas fa-tty"></i>
                                    เบอร์ติดต่อ
                                </th>
                            </tr>
                        </thead>
                        <tbody style="color: #616161;">
                            <?php while($row = mysqli_fetch_assoc($objUserAll)): ?>
                                <tr>
                                    <th scope="row"><?= $row["u_id"]?></th>
                                    <td><?= $row["u_email"]?></td>
                                    <td><?= $row["u_first_name"] ." ". $row["u_last_name"] ?></td>
                                    <td style="width: 175px;word-wrap: break-word;"><?= $row["u_address"] ?></td>
                                    <td><?= $row["u_role"] == 0? "<p class='label label-warning'>ลูกจ้าง</p>":"<p class='label label-success'>ผู้ดูแล</p>" ?></td>
                                    <td><?= $row["u_tel"]?></td>
                                    <td>
                                        <a href="action/action_delete_emp.php?id=<?= $row["u_id"] ?>">
                                            <button class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="action/action_promote_demote.php?mote=<?= $row["u_role"] == 1? "demote":"promote"?>&id=<?= $row["u_id"] ?>">
                                            <button class="btn <?= $row["u_role"] == 0? "btn-warning":"btn-dark"?>">
                                                <?= $row["u_role"] == 0? "เพิ่มสิทธิ์":"ลดสิทธิ์"?>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

<div style="font-weight: 900;justify-content: space-between;"></div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>
    <script src="js/printEmp.js" type="text/javascript"></script>


</body>

</html>
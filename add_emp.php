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
            <section class="content-header" style="display: flex;">
                <a href="employee.php"><i class="fas fa-arrow-left" style="margin-right: 5px; font-size: 24px; color:#616161"></i></a>
                <h1 style="color: #616161;">
                    <i class="fas fa-users"></i> เพิ่มลูกจ้าง
                </h1>
            </section>

            <!-- Main content -->
            <section class="content container content_add_emp" style="color: #616161;">
                <form class="form_add_emp" action="action/action_add_emp.php" method="POST">
                    <div class="form_title" ><i class="fab fa-wpforms"></i> กรอกข้อมูลลูกจ้าง</div>
                    <div class="form-group">
                        <label for="email"> <i class="fas fa-envelope-square"></i> อีเมลล์</label>
                        <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" required autofocus>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="password"> <i class="fas fa-key"></i> รหัสผ่าน</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password"> <i class="fas fa-unlock-alt"></i> ยืนยันรหัสผ่าน </label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="first_name"><i class="fas fa-signature"></i> ชื่อ</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="last_name"><i class="fas fa-file-signature"></i> นามสกุล</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="text_area"> <i class="fas fa-address-card"></i> ที่อยู่ </label>
                        <textarea name="address" class="form-control" id="text_area" rows="3" placeholder="Address" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="first_name"><i class="fas fa-shield-alt"></i> สิทธิ์การใช้งาน</label>
                        <select class="form-control" name="role">
                            <option value="0">ลูกจ้าง</option>
                            <option value="1">ผู้ดูแล</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tel"><i class="fas fa-tty"></i> เบอร์โทรติดต่อ</label>
                        <input type="text" name="tel" class="form-control" maxlength="10" placeholder="Tel" required>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" name="add_emp_submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            เพิ่ม
                        </button>
                        <button type="reset" class="btn btn-danger">
                            <i class="fas fa-undo-alt"></i>
                            รีเซ็ต
                        </button>
                    </div>
                </form>

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
    <!-- AdminLTE App -->
    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>

</body>

</html>
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

$objQuery = mysqli_query($con, $SQL);

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


            <!-- The Modal -->
            <div id="myModal" class="modal container">

                <?php 
                    $placeStartQuery = mysqli_query($con, "SELECT * FROM tb_place_start");
                    $placeEndQuery = mysqli_query($con, "SELECT * FROM tb_place_end");
                    $busQuery = mysqli_query($con, "SELECT * FROM tb_bus");
                ?>
                <!-- Modal content -->
                <div class="modal-content">

                    <span class="close">&times;</span>
                    <h3>เพิ่มรอบรถ</h3>

                    <form action="action/action_add_ro.php" method="POST">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <h4>Place Start</h4>
                                <select class="form-control" name="place_start">
                                    <?php while ($row = mysqli_fetch_assoc($placeStartQuery)) : ?>
                                        <option value="<?= $row["ps_id"] ?>"><?= $row["ps_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4>Place End</h4>
                                <select class="form-control" name="place_end">
                                    <?php while ($row = mysqli_fetch_assoc($placeEndQuery)) : ?>
                                        <option value="<?= $row["pe_id"] ?>"><?= $row["pe_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <h4>Time Start</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">ชั่วโมง</p>
                                        <select class="form-control" name="time_start_h">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i <= 24; $i++) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">นาที</p>
                                        <select class="form-control" name="time_start_m">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i <= 60; $i++) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Time End</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">ชั่วโมง</p>
                                        <select class="form-control" name="time_end_h">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i <= 24; $i++) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">นาที</p>
                                        <select class="form-control" name="time_end_m">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i <= 60; $i++) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4>Bus</h4>
                                <select class="form-control" name="bus">
                                    <?php while ($row = mysqli_fetch_assoc($busQuery)) : ?>
                                        <option value="<?= $row["b_id"] ?>"><?= $row["b_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4>Price</h4>
                                <input type="number" name="price" class="form-control" placeholder="Price">
                            </div>
                        </div>

                        <div style="margin-top: 15px; text-align: end;">
                            <button type="submit" name="btn_add_ro" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            
            
            <?php 
                if(isset($_GET["edit"])){
                    $id = $_GET["id"];
                    $ps_id = $_GET["ps_id"];
                    $pe_id = $_GET["pe_id"];

                    $time_start = $_GET["time_start"];
                    $time_start_h = explode(":",$time_start)[0];
                    $time_start_m = explode(":",$time_start)[1];

                    $time_end = $_GET["time_end"];
                    $time_end_h = explode(":",$time_end)[0];
                    $time_end_m = explode(":",$time_end)[1];

                    $bus_id = $_GET["bus_id"];
                    $price = $_GET["price"];
                    
                    $placeStartQuery = mysqli_query($con, "SELECT * FROM tb_place_start");
                    $placeEndQuery = mysqli_query($con, "SELECT * FROM tb_place_end");
                    $busQuery = mysqli_query($con, "SELECT * FROM tb_bus");
                
            ?>
            <div id="myModal" class="modal container" style="display: block;">
                <!-- Modal content -->
                <div class="modal-content">

                    <a href="round_out.php"><span class="close">&times;</span></a>
                    <h3>แก้ไขรอบรถ</h3>

                    <form action="action/action_update_ro.php" method="POST">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <h4>Place Start</h4>
                                <select class="form-control" name="place_start">
                                    <?php while ($row = mysqli_fetch_assoc($placeStartQuery)) : ?>
                                        <option <?= $ps_id == $row["ps_id"]? "selected":null ?> value="<?= $row["ps_id"] ?>"><?= $row["ps_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4>Place End</h4>
                                <select class="form-control" name="place_end">
                                    <?php while ($row = mysqli_fetch_assoc($placeEndQuery)) : ?>
                                        <option <?= $pe_id == $row["pe_id"]? "selected":null ?> value="<?= $row["pe_id"] ?>"><?= $row["pe_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <h4>Time Start</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">ชั่วโมง</p>
                                        <select class="form-control" name="time_start_h">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option <?= $time_start_h == "0".$i? "selected":null ?> value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i <= 24; $i++) : ?>
                                                <option <?= $time_start_h == $i? "selected":null ?> value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">นาที</p>
                                        <select class="form-control" name="time_start_m">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option <?= $time_start_m == "0".$i? "selected":null ?> value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i <= 60; $i++) : ?>
                                                <option <?= $time_start_m == $i? "selected":null ?> value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Time End</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">ชั่วโมง</p>
                                        <select class="form-control" name="time_end_h">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option <?= $time_end_h == "0".$i? "selected":null ?> value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i <= 24; $i++) : ?>
                                                <option <?= $time_end_h == $i? "selected":null ?> value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">นาที</p>
                                        <select class="form-control" name="time_end_m">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option <?= $time_end_m == "0".$i? "selected":null ?> value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i <= 60; $i++) : ?>
                                                <option <?= $time_end_m == $i? "selected":null ?> value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4>Bus</h4>
                                <select class="form-control" name="bus">
                                    <?php while ($row = mysqli_fetch_assoc($busQuery)) : ?>
                                        <option <?= $bus_id == $row["b_id"]? "selected":null ?> value="<?= $row["b_id"] ?>"><?= $row["b_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4>Price</h4>
                                <input type="number" value="<?= $price ?>" name="price" class="form-control" placeholder="Price">
                            </div>
                        </div>

                        <div style="margin-top: 15px; text-align: end;">
                            <button type="submit" name="btn_add_ro" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
            <?php 
                }
            ?>

            <!-- Main content -->
            <section class="content container">
                <div class="add_ro" style="margin-bottom: 5px;">
                    <button id="myBtn" class="btn btn-primary">เพิ่มรอบรถ</button>
                </div>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Place Start</th>
                            <th scope="col">Place End</th>
                            <th scope="col">Time Start</th>
                            <th scope="col">Time End</th>
                            <th scope="col">Bus</th>
                            <th scope="col">Price</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($objQuery)) :
                        ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $row["ps_name"] ?></td>
                                <td><?= $row["pe_name"] ?></td>
                                <td><?= $row["ro_time_start"] ?></td>
                                <td><?= $row["ro_time_end"] ?></td>
                                <td><?= $row["b_name"] ?></td>
                                <td><?= $row["ro_price"] ?></td>
                                <td>
                                    <a href="?edit=1&id=<?= $row["ro_id"] ?>&ps_id=<?= $row["ps_id"] ?>&pe_id=<?= $row["pe_id"] ?>&time_start=<?= $row["ro_time_start"] ?>&time_end=<?= $row["ro_time_end"] ?>&bus_id=<?= $row["b_id"] ?>&price=<?= $row["ro_price"] ?>">
                                        <button class="btn btn-warning">แก้ไข</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="action/action_delete_ro.php?id=<?= $row["ro_id"] ?>">
                                        <button class="btn btn-danger">ลบ</button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        endwhile;
                        ?>
                    </tbody>
                </table>

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
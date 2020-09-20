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

$objQuery = mysqli_query($con, $SQL);

$SQL = "SELECT * FROM tb_round_out 
        INNER JOIN tb_place_start ON tb_round_out.ro_place_start = tb_place_start.ps_id 
        INNER JOIN tb_place_end ON tb_round_out.ro_place_end = tb_place_end.pe_id
        GROUP BY ro_place_start, ro_place_end";

$groupRoundQuery = mysqli_query($con, $SQL);


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
            <section class="content-header">
                <h1 style="color:#616161">
                    <i class="fas fa-table"></i> ตารางรอบรถ
                    <small>Control panel</small>
                </h1>
            </section>


            <!-- The Modal -->
            <div id="myModal" class="modal container">

                <?php 
                    $placeStartQuery = mysqli_query($con, "SELECT * FROM tb_place_start");
                    $placeEndQuery = mysqli_query($con, "SELECT * FROM tb_place_end");
                    $busQuery = mysqli_query($con, "SELECT * FROM tb_bus");
                ?>
                <!-- Modal content -->
                <div class="modal-content" style="color:#616161">

                    <span class="close">&times;</span>
                    <h3><i class="fas fa-plus"></i> เพิ่มรอบรถ</h3>

                    <form action="action/action_add_ro.php" method="POST">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <h4><i class="fas fa-parking"></i> ต้นทาง</h4>
                                <select class="form-control" name="place_start">
                                    <?php while ($row = mysqli_fetch_assoc($placeStartQuery)) : ?>
                                        <option value="<?= $row["ps_id"] ?>"><?= $row["ps_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4><i class="fab fa-mendeley"></i> ปลายทาง</h4>
                                <select class="form-control" name="place_end">
                                    <?php while ($row = mysqli_fetch_assoc($placeEndQuery)) : ?>
                                        <option value="<?= $row["pe_id"] ?>"><?= $row["pe_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4 style="margin-bottom: 15px;"><i class="fas fa-hourglass-start"></i> เวลาออกเดินทาง</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">ชั่วโมง</p>
                                        <select class="form-control" name="time_start_h" id="time_start_h" onchange="changeTime()">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i < 24; $i++) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">นาที</p>
                                        <select class="form-control" name="time_start_m" id="time_start_m" onchange="changeTime()">
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
                                <h4><i class="fas fa-car"></i> รถ</h4>
                                <select class="form-control" name="bus" id="bus">
                                    <?php while ($row = mysqli_fetch_assoc($busQuery)) : ?>
                                        <option value="<?= $row["b_id"] ?>"><?= $row["b_name"]. " - " .$row["b_id"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4> <i class="fas fa-tags"></i> ราคา</h4>
                                <input type="number" name="price" class="form-control" placeholder="Price">
                            </div>
                        </div>

                        <div style="margin-top: 15px; text-align: end;">
                            <button type="submit" name="btn_add_ro" class="btn btn-success"><i class="fas fa-plus"></i> เพิ่ม</button>
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

                    $bus_id = $_GET["bus_id"];
                    $price = $_GET["price"];
                    
                    $placeStartQuery = mysqli_query($con, "SELECT * FROM tb_place_start");
                    $placeEndQuery = mysqli_query($con, "SELECT * FROM tb_place_end");
                    $busQuery = mysqli_query($con, "SELECT * FROM tb_bus");

            
                    echo "<input type='hidden' id='e_ro_id' value='$id'>"
                
            ?>
            <div id="myModal" class="modal container" style="display: block;">
                <!-- Modal content -->
                <div class="modal-content" style="color: #616161;">

                    <a href="round_out.php"><span class="close">&times;</span></a>
                    <h3><i class="fas fa-edit"></i> แก้ไขรอบรถ</h3>

                    <form action="action/action_update_ro.php" method="POST">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <h4><i class="fas fa-parking"></i> ต้นทาง</h4>
                                <select class="form-control" name="place_start">
                                    <?php while ($row = mysqli_fetch_assoc($placeStartQuery)) : ?>
                                        <option <?= $ps_id == $row["ps_id"]? "selected":null ?> value="<?= $row["ps_id"] ?>"><?= $row["ps_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4><i class="fab fa-mendeley"></i> ปลายทาง</h4>
                                <select class="form-control" name="place_end">
                                    <?php while ($row = mysqli_fetch_assoc($placeEndQuery)) : ?>
                                        <option <?= $pe_id == $row["pe_id"]? "selected":null ?> value="<?= $row["pe_id"] ?>"><?= $row["pe_name"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4><i class="fas fa-hourglass-start"></i> เวลาออกเดินทาง</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">ชั่วโมง</p>
                                        <select class="form-control" name="time_start_h" id="time_start_h2" onchange="changeTime2()">
                                            <?php for ($i = 0; $i <= 9; $i++) : ?>
                                                <option <?= $time_start_h == "0".$i? "selected":null ?> value="<?= "0" . $i ?>"><?= "0" . $i ?></option>
                                            <?php endfor; ?>
                                            <?php for ($i = 10; $i < 24; $i++) : ?>
                                                <option <?= $time_start_h == $i? "selected":null ?> value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="margin-left: 3px; margin-bottom: 0;">นาที</p>
                                        <select class="form-control" name="time_start_m" id="time_start_m2" onchange="changeTime2()">
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
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4><i class="fas fa-car"></i> รถ</h4>
                                <select class="form-control" name="bus" id="bus2">
                                    <?php while ($row = mysqli_fetch_assoc($busQuery)) : ?>
                                        <option <?= $bus_id == $row["b_id"]? "selected":null ?> value="<?= $row["b_id"] ?>"><?= $row["b_name"]. " - " .$row["b_id"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <h4><i class="fas fa-tags"></i> ราคา</h4>
                                <input type="number" value="<?= $price ?>" name="price" class="form-control" placeholder="Price">
                            </div>
                        </div>

                        <div style="margin-top: 15px; text-align: end;">
                            <button type="submit" name="btn_add_ro" class="btn btn-warning"><i class="fas fa-edit"></i> แก้ไข</button>
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
                    <button id="myBtn" class="btn btn-success"> <i class="fas fa-plus"></i> เพิ่มรอบรถ</button>
                    
                    <button class="btn btn-warning" onclick="listRound()">
                        <i class="fas fa-print"></i>
                    </button>
                </div>

                <?php 
                    $rountResult = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
                    while($rowGroup = mysqli_fetch_assoc($groupRoundQuery)):
                ?>
                <!-- table round -->
                <h4 style="color: #616161;margin-bottom: 0px;margin-top: 15px;"><b><?= $rowGroup['ps_name']. " - " .$rowGroup['pe_name'] ?></b></h4>
                <div style="overflow-x: auto;">
                <table class="table table-striped text-center" style="margin-top: 15px;">
                    <thead class="thead-dark" style="background-color: #4B4A67;color:white">
                        <tr>
                            <th scope="col">
                                <i class="fas fa-sort-numeric-down"></i> No.
                            </th>
                            <th scope="col"> <i class="fas fa-parking"></i> ต้นทาง</th>
                            <th scope="col"> <i class="fab fa-mendeley"></i> ปลายทาง</th>
                            <th scope="col"> <i class="fas fa-hourglass-start"></i> เวลาเดินทาง</th>
                            <th scope="col"> <i class="fas fa-car"></i> รถ</th>
                            <th scope="col"> <i class="fas fa-tags"></i> ราคา</th>
                        </tr>
                    </thead>
                    <tbody style="color: #616161;">
                        <?php
                        $i = 1;
                        foreach ($rountResult as $row) {
                            if($row["ro_place_start"] == $rowGroup["ro_place_start"]&&$row["ro_place_end"] == $rowGroup["ro_place_end"]) {
                        ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $row["ps_name"] ?></td>
                                <td><?= $row["pe_name"] ?></td>
                                <td><?= $row["ro_time_start"] ?></td>
                                <td><?= $row["b_name"]. " - " .$row["b_id"] ?></td>
                                <td><?= $row["ro_price"] ?></td>
                                <td>
                                    <a href="?edit=1&id=<?= $row["ro_id"] ?>&ps_id=<?= $row["ps_id"] ?>&pe_id=<?= $row["pe_id"] ?>&time_start=<?= $row["ro_time_start"] ?>&bus_id=<?= $row["b_id"] ?>&price=<?= $row["ro_price"] ?>">
                                        <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                    </a>
                                </td>
                                <td>
                                    <a href="action/action_delete_ro.php?id=<?= $row["ro_id"] ?>">
                                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
                <!-- end table round -->
                <?php 
                    endwhile;
                ?>
                        
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <!-- add new calendar event modal -->


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/AdminLTE/app2.js" type="text/javascript"></script>
    <script src="js/round_out.js" type="text/javascript"></script>
</body>

</html>

<script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");

    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function () {
    modal.style.display = "block";
    };

    span.onclick = function () {
    modal.style.display = "none";
    };

    window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    };
</script>

<script>
    function listRound() {
        var xhr = new XMLHttpRequest();
        xhr.open ("GET", "server/server_list_round_out.php?pass=hsr224");
        xhr.onreadystatechange = responseXHR;
        xhr.send(null);

        function responseXHR(){
            if ( xhr.readyState == 4 )
            {
                console.log(JSON.parse(xhr.responseText));
                print(JSON.parse(xhr.responseText))
            }
        }

    }


    function print(list) {
        var mywindow = window.open('', '', 'height=600,width=900');
        var d = new Date();
        var genarataPrint = `
            <html>
                <head>
                    <style>
                    </style>
                </head>
                <body style="padding:0px;margin:0px">
                    <div style="margin-top:10px; width: 100%">
                        <div style="margin-top:10px; width: 100%">
                            <div style="display:flex;justify-content: space-between;">
                                <p style="font-weight: bold;font-size:34px">Ticket Sales</p>
                                <p>${d.getDate() + "/" + d.getMonth() + "/" + d.getFullYear()}</p>
                            </div>
                            <p style="font-weight: bold;font-size:24px;">รายการรอบรถ</p>
                        </div>
                    </div>
        `;
        
        for(let n = 0; n < list.length; n++) {
            genarataPrint += `
                    <div style=" margin-top:5%;border:2px solid #333; padding: 5px">
                        <h3 style="margin:0px;padding:0px">${list[n].round}</h3>
                    </div>
                    <table style="width:100%;text-align:center;" >
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ไอดี</th>
                                <th>ต้นทาง</th>
                                <th>ปลายทาง</th>
                                <th>เวลาเดินทาง</th>
                                <th>รถ</th>
                                <th>ราคา</th>
                            </tr>
                        </thead>
                        <tbody>  
            `;
            
            for(let x = 0; x < list[n].list.length; x++) {
                genarataPrint += `
                    <tr>
                        <td>${x + 1}</td>
                        <td>${list[n].list[x].ro_id}</td>
                        <td>${list[n].list[x].ps_name}</td>
                        <td>${list[n].list[x].pe_name}</td>
                        <td>${list[n].list[x].ro_time_start}</td>
                        <td>${list[n].list[x].b_name} - ${list[n].list[x].b_id}</td>
                        <td>${list[n].list[x].ro_price}</td>
                    </tr>
                `
            }

            genarataPrint += `
                        </tbody>
                    </table>
            `;

        }

        genarataPrint += `
                </body>
            </html>
        `;
        
        
        mywindow.document.write(genarataPrint);
        mywindow.document.close();
        mywindow.focus();
        mywindow.print();
        
        var mediaQueryList = mywindow.matchMedia('print');
        
        mediaQueryList.addEventListener("change",function(mql) {
            if (!mql.matches) {
                mywindow.close(); 
            }
        });
    }
</script>
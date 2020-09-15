<?php 
    $url = $_SERVER['REQUEST_URI'];
    // /TicketSales/view/employee.php
    $currentIndex = !strpos($url, "employee") 
                    && !strpos($url, "round_out") 
                    && !strpos($url, "seat") 
                    && !strpos($url, "ticket_sales")
                    && !strpos($url, "add_emp")
?>
<ul class="sidebar-menu">
    <?php if ($role == 1) { ?>
    <!-- admin -->
    <li class="<?= $currentIndex? 'active':null ?>">
        <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>หน้าหลัก</span>
        </a>
    </li>
    <li class="<?= strpos($url, "employee") || strpos($url, "add_emp")? 'active':null?>">
        <a href="employee.php">
            <i class="fa fa-dashboard"></i> <span>พนักงาน</span>
        </a>
    </li>

    <li class="<?= strpos($url, "round_out")? 'active':null?>">
        <a href="round_out.php">
            <i class="fa fa-dashboard"></i> <span>ตารางรอบรถ</span>
        </a>
    </li>

    <li class="<?= strpos($url, "seat")? 'active':null?>">
        <a href="seat.php">
            <i class="fa fa-dashboard"></i> <span>ที่นั้ง</span>
        </a>
    </li>

    <li class="<?= strpos($url, "ticket_sales")? 'active':null?>">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>รายงานการขายตั๋ว</span>
        </a>
    </li>
    <?php 
        } else {
    ?>
    <!-- emp -->
    <li class="<?= $currentIndex? 'active':null ?>">
        <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>หน้าหลัก</span>
        </a>
    </li>

    <li class="<?= strpos($url, "round_out")? 'active':null?>">
        <a href="round_out.php">
            <i class="fa fa-dashboard"></i> <span>ตารางรอบรถ</span>
        </a>
    </li>

    <li class="<?= strpos($url, "seat")? 'active':null?>">
        <a href="seat.php">
            <i class="fa fa-dashboard"></i> <span>ที่นั้ง</span>
        </a>
    </li>
    <?php } ?>
</ul>
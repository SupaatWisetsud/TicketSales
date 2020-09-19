<?php 
    $url = $_SERVER['REQUEST_URI'];
    // /TicketSales/view/employee.php
    $currentIndex = !strpos($url, "employee") 
                    && !strpos($url, "round_out") 
                    && !strpos($url, "pad") 
                    && !strpos($url, "ticket_sales")
                    && !strpos($url, "add_emp")
                    && !strpos($url, "start_end")
                    && !strpos($url, "edit_profile")
?>
<ul class="sidebar-menu">
    <?php if ($role == 1) { ?>
    <!-- admin -->
    <li class="<?= $currentIndex? 'active':null ?>">
        <a href="index.php">
            <i class="fas fa-tachometer-alt" style="font-size: 14px;"></i>
            <span> หน้าหลัก</span>
        </a>
    </li>
    <li class="<?= strpos($url, "employee") || strpos($url, "add_emp")? 'active':null?>">
        <a href="employee.php">
            <i class="fas fa-user-friends" style="font-size: 14px;"></i>
            <span> พนักงาน</span>
        </a>
    </li>

    <li class="<?= strpos($url, "round_out")? 'active':null?>">
        <a href="round_out.php">
            <i class="fas fa-table" style="font-size: 14px;"></i>
            <span> ตารางรอบรถ</span>
        </a>
    </li>

    <li class="<?= strpos($url, "start_end")? 'active':null?>">
        <a href="start_end.php">
            <i class="fas fa-car" style="font-size: 14px;"></i>
            <span> ต้นทาง / ปลายทาง</span>
        </a>
    </li>

    <li class="<?= strpos($url, "pad")? 'active':null?>">
        <a href="pad.php">
            <i class="fas fa-chair" style="font-size: 14px;"></i>
            <span> ที่นั้ง</span>
        </a>
    </li>

    <li class="<?= strpos($url, "ticket_sales")? 'active':null?>">
        <a href="ticket_sales.php">
            <i class="fas fa-pager" style="font-size: 14px;"></i>
            <span> รายงานการขายตั๋ว</span>
        </a>
    </li>
    <?php 
        } else {
    ?>
    <!-- emp -->
    <li class="<?= $currentIndex? 'active':null ?>">
        <a href="index.php">
            <i class="fas fa-tachometer-alt" style="font-size: 14px;"></i>
            <span>หน้าหลัก</span>
        </a>
    </li>

    <li class="<?= strpos($url, "round_out")? 'active':null?>">
        <a href="round_out.php">
            <i class="fas fa-table" style="font-size: 14px;"></i>
            <span>ตารางรอบรถ</span>
        </a>
    </li>
    
    <li class="<?= strpos($url, "start_end")? 'active':null?>">
        <a href="start_end.php">
            <i class="fas fa-car" style="font-size: 14px;"></i>
            <span> ต้นทาง / ปลายทาง</span>
        </a>
    </li>

    <li class="<?= strpos($url, "pad")? 'active':null?>">
        <a href="pad.php">
            <i class="fas fa-chair" style="font-size: 14px;"></i>
            <span>ที่นั้ง</span>
        </a>
    </li>
    <?php } ?>
</ul>
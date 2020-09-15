CREATE TABLE `tb_user` (
  `u_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `u_email` varchar(70) NOT NULL,
  `u_password` varchar(280) NOT NULL,
  `u_first_name` varchar(180) NOT NULL,
  `u_last_name` varchar(80) NOT NULL,
  `u_role` int NOT NULL DEFAULT 0,
  `u_tel` varchar(10) NOT NULL
);

-- สถานที่
CREATE TABLE `tb_place_start` (
    `ps_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `ps_name` varchar(80) NOT NULL 
)

CREATE TABLE `tb_place_end` (
    `pe_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `pe_name` varchar(80) NOT NULL 
)

-- รถบัส
CREATE TABLE `tb_bus` (
    `b_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `b_name` varchar(80) NOT NULL
)

-- รอบที่ออก
CREATE TABLE `tb_round_out` (
    `ro_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `ro_place_start` int NOT NULL, 
    `ro_place_end` int NOT NULL,
    `ro_time_start` time (0) NOT NULL,
    `ro_time_end` time (0),
    `ro_price` int NOT NULL DEFAULT 0,
    `ro_bus` int not null,
    FOREIGN KEY (ro_place_start) REFERENCES tb_place_start(ps_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ro_place_end) REFERENCES tb_place_end(pe_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ro_bus) REFERENCES tb_bus(b_id) ON UPDATE CASCADE ON DELETE CASCADE
)

CREATE TABLE `tb_seat` (
    `seat_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `seat_name` varchar(10) NOT NULL,
    `seat_bus` int NOT NULL,
    `seat_status` varchar(1) DEFAULT '0',
    FOREIGN KEY (seat_bus) REFERENCES tb_bus(b_id) ON UPDATE CASCADE ON DELETE CASCADE
)

CREATE TABLE `tb_sales` (
    `sale_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `sale_round` int NOT NULL,
    `sale_emp` int NOT NULL,
    `sale_seat` int not null,
    `sale_price` int not null DEFAULT 0,
    FOREIGN KEY (sale_emp) REFERENCES tb_user(u_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (sale_round) REFERENCES tb_round_out(ro_id) ON UPDATE CASCADE ON DELETE CASCADE
)


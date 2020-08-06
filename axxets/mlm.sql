SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+05:30";

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `session` char(32) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `last_login` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `email`, `session`, `ip`, `last_login`) VALUES
(1, 'Admin', 'admin', '$2y$10$wO2UnL9grzC2HrzFFL8CLOluwPzknWT.MdzmJuAOKAjwhPDaqug4e', 'mlm@hotmail.com', '9c441fcc5df251e0b7b6270ec8851def', '127.0.0.1', 1513013830);

DROP TABLE IF EXISTS `admin_expense`;
CREATE TABLE `admin_expense` (
  `id` int(11) NOT NULL,
  `expense_name` varchar(200) NOT NULL,
  `amount` decimal(7,2) NOT NULL,
  `detail` varchar(200) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `ad_title` varchar(200) NOT NULL,
  `ad_html` text NOT NULL,
  `level_earning` varchar(500) DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `type` enum('html','url') NOT NULL DEFAULT 'url'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `ad_user`;
CREATE TABLE `ad_user` (
  `id` int(11) NOT NULL,
  `ad_id` varchar(20) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `coupon` varchar(20) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `coupon_cat` varchar(20) NOT NULL,
  `coupon_amt` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` enum('Used','Un-Used','Use Request') NOT NULL DEFAULT 'Un-Used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `coupon_categories`;
CREATE TABLE `coupon_categories` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL,
  `cat_description` varchar(1000) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `donations`;
CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(20) NOT NULL,
  `donation_amount` varchar(30) NOT NULL,
  `receiver_id` varchar(20) NOT NULL,
  `time` int(11) NOT NULL,
  `trid` varchar(200) NOT NULL,
  `tdate` date DEFAULT NULL,
  `status` enum('Sent','Accepted','Waiting') NOT NULL DEFAULT 'Sent',
  `donation_pack` int(11) NOT NULL,
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `donation_package`;
CREATE TABLE `donation_package` (
  `id` int(11) NOT NULL,
  `donation_level` int(11) NOT NULL,
  `plan_name` varchar(200) NOT NULL,
  `sponsor_income` varchar(30) DEFAULT NULL,
  `position_income` varchar(30) DEFAULT NULL,
  `donation_amount` varchar(30) DEFAULT '0',
  `donation_qty` int(11) NOT NULL,
  `expiry_duration` int(11) NOT NULL DEFAULT '2' COMMENT 'in days'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `earning`;
CREATE TABLE `earning` (
  `id` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `type` varchar(20) NOT NULL,
  `ref_id` varchar(20) NOT NULL DEFAULT 'N/A',
  `date` date NOT NULL,
  `pair_match` int(11) NOT NULL DEFAULT '0',
  `secret` varchar(15) NOT NULL DEFAULT '0',
  `status` enum('Paid','Pending') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `epin`;
CREATE TABLE `epin` (
  `id` int(11) NOT NULL,
  `epin` varchar(20) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `issue_to` varchar(20) NOT NULL,
  `generate_time` date NOT NULL,
  `generated_by` varchar(15) NOT NULL DEFAULT 'Admin',
  `transfer_by` varchar(20) DEFAULT NULL,
  `used_by` varchar(20) DEFAULT NULL,
  `transfer_time` date DEFAULT NULL,
  `used_time` date DEFAULT NULL,
  `status` enum('Used','Un-used') NOT NULL DEFAULT 'Un-used',
  `type` enum('Single Use','Multi Use') NOT NULL DEFAULT 'Single Use'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `fix_income`;
CREATE TABLE `fix_income` (
  `id` int(11) NOT NULL,
  `direct_income` varchar(100) DEFAULT NULL,
  `level_income` varchar(100) DEFAULT NULL,
  `binary_income` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `fix_income` (`id`, `direct_income`, `level_income`, `binary_income`) VALUES
(1, '0', '0', '0');

DROP TABLE IF EXISTS `flexible_income`;
CREATE TABLE `flexible_income` (
  `id` int(11) NOT NULL,
  `income_name` varchar(200) NOT NULL,
  `income_duration` int(11) NOT NULL DEFAULT '0' COMMENT 'within how many days he should achieve this',
  `A` int(11) NOT NULL DEFAULT '0',
  `B` int(11) NOT NULL DEFAULT '0',
  `C` int(11) NOT NULL DEFAULT '0',
  `D` int(11) NOT NULL DEFAULT '0',
  `E` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(11,2) NOT NULL,
  `based_on` enum('Member','PV') NOT NULL DEFAULT 'Member'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `franchisee`;
CREATE TABLE `franchisee` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `business_name` varchar(200) DEFAULT NULL,
  `country` varchar(150) NOT NULL,
  `state` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(300) NOT NULL,
  `last_login` date NOT NULL,
  `last_login_ip` varchar(50) NOT NULL DEFAULT '0:0:0:0',
  `session` char(32) NOT NULL,
  `status` enum('Active','Inactive','Terminated') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `franchisee_stock`;
CREATE TABLE `franchisee_stock` (
  `id` int(11) NOT NULL,
  `franchisee_id` varchar(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `available_qty` int(11) NOT NULL DEFAULT '0',
  `sold_qty` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `franchisee_stock_sale_bill`;
CREATE TABLE `franchisee_stock_sale_bill` (
  `id` int(11) NOT NULL,
  `stock_data` varchar(500) NOT NULL,
  `stock_data_price` varchar(500) DEFAULT NULL,
  `fran_id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `userid` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `gap_commission_setting`;
CREATE TABLE `gap_commission_setting` (
  `id` int(11) NOT NULL,
  `total_pv` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(11,2) NOT NULL,
  `income_name` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `investments`;
CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `userid` varchar(100) NOT NULL,
  `pack_id` varchar(20) NOT NULL,
  `amount` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Pending','Active','Expired') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `investment_pack`;
CREATE TABLE `investment_pack` (
  `id` int(11) NOT NULL,
  `pack_name` varchar(200) NOT NULL,
  `amount` varchar(40) DEFAULT NULL,
  `direct_income` varchar(20) NOT NULL DEFAULT '0',
  `level_income` varchar(100) NOT NULL DEFAULT '0',
  `matching_income` varchar(30) NOT NULL DEFAULT '0',
  `capping` varchar(30) NOT NULL DEFAULT '0',
  `roi` decimal(11,2) NOT NULL,
  `roi_frequency` int(11) NOT NULL DEFAULT '0',
  `roi_limit` int(11) NOT NULL DEFAULT '0',
  `based` enum('Percent','Fixed') NOT NULL DEFAULT 'Percent' COMMENT 'Calculation Based On'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `invoice_name` varchar(200) NOT NULL,
  `userid` varchar(20) NOT NULL DEFAULT 'N/A',
  `invoice_data` varchar(2000) NOT NULL COMMENT 'php array serialize, name=>amount=>tax',
  `invoice_data_tax` varchar(1000) NOT NULL,
  `invoice_data_qty` varchar(300) DEFAULT NULL,
  `company_address` varchar(300) NOT NULL,
  `bill_to_address` varchar(300) NOT NULL,
  `total_amt` decimal(11,2) NOT NULL DEFAULT '0.00',
  `paid_amt` decimal(11,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `user_type` varchar(40) NOT NULL DEFAULT 'Other'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `level`;
CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `level1` int(11) NOT NULL DEFAULT '0',
  `level2` int(11) NOT NULL DEFAULT '0',
  `level3` int(11) NOT NULL DEFAULT '0',
  `level4` int(11) NOT NULL DEFAULT '0',
  `level5` int(11) NOT NULL DEFAULT '0',
  `level6` int(11) NOT NULL DEFAULT '0',
  `level7` int(11) NOT NULL DEFAULT '0',
  `level8` int(11) NOT NULL DEFAULT '0',
  `level9` int(11) NOT NULL DEFAULT '0',
  `level10` int(11) NOT NULL DEFAULT '0',
  `level11` int(11) NOT NULL DEFAULT '0',
  `level12` int(11) NOT NULL DEFAULT '0',
  `level13` int(11) NOT NULL DEFAULT '0',
  `level14` int(11) NOT NULL DEFAULT '0',
  `level15` int(11) NOT NULL DEFAULT '0',
  `level16` int(11) NOT NULL DEFAULT '0',
  `level17` int(11) NOT NULL DEFAULT '0',
  `level18` int(11) NOT NULL DEFAULT '0',
  `level19` int(11) NOT NULL DEFAULT '0',
  `level20` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `level` (`id`, `userid`, `level1`, `level2`, `level3`, `level4`, `level5`, `level6`, `level7`, `level8`, `level9`, `level10`, `level11`, `level12`, `level13`, `level14`, `level15`, `level16`, `level17`, `level18`, `level19`, `level20`) VALUES
(1, '1001', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS `level_wise_income`;
CREATE TABLE `level_wise_income` (
  `id` int(11) NOT NULL,
  `income_name` varchar(200) NOT NULL,
  `income_duration` int(11) NOT NULL DEFAULT '0' COMMENT 'within how many days he should achieve this',
  `level_no` int(11) NOT NULL DEFAULT '1',
  `total_member` int(11) NOT NULL DEFAULT '1',
  `amount` decimal(11,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `log` text NOT NULL,
  `type` enum('Admin','User','Franchisee','Other') NOT NULL DEFAULT 'Admin',
  `ip` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `sponsor` varchar(20) NOT NULL,
  `position` varchar(20) NOT NULL,
  `signup_package` varchar(20) DEFAULT NULL,
  `epin` varchar(20) DEFAULT NULL,
  `address` varchar(400) NOT NULL,
  `join_time` date NOT NULL,
  `placement_leg` enum('A','B','C','D','E') NOT NULL DEFAULT 'A',
  `A` int(11) NOT NULL DEFAULT '0',
  `B` int(11) NOT NULL DEFAULT '0',
  `C` int(11) NOT NULL DEFAULT '0',
  `D` int(11) NOT NULL DEFAULT '0',
  `E` int(11) NOT NULL DEFAULT '0',
  `total_a` int(11) NOT NULL DEFAULT '0',
  `total_b` int(11) NOT NULL DEFAULT '0',
  `total_c` int(11) NOT NULL DEFAULT '0',
  `total_d` int(11) NOT NULL DEFAULT '0',
  `total_e` int(11) NOT NULL DEFAULT '0',
  `paid_a` int(11) NOT NULL DEFAULT '0',
  `paid_b` int(11) NOT NULL DEFAULT '0',
  `paid_c` int(11) NOT NULL DEFAULT '0',
  `paid_d` int(11) NOT NULL DEFAULT '0',
  `paid_e` int(11) NOT NULL DEFAULT '0',
  `rank` varchar(30) NOT NULL DEFAULT 'Member',
  `registration_ip` varchar(20) NOT NULL,
  `session` char(32) NOT NULL,
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(20) NOT NULL DEFAULT 'NA',
  `topup` decimal(11,2) NOT NULL DEFAULT '0.00',
  `mypv` int(11) NOT NULL DEFAULT '0',
  `total_a_pv` varchar(5) NOT NULL DEFAULT '0',
  `total_b_pv` varchar(5) NOT NULL DEFAULT '0',
  `total_c_pv` varchar(10) NOT NULL DEFAULT '0',
  `total_d_pv` varchar(10) NOT NULL DEFAULT '0',
  `total_e_pv` varchar(10) NOT NULL DEFAULT '0',
  `my_img` varchar(30) DEFAULT '' COMMENT ' ',
  `status` enum('Block','Active','Suspend','') NOT NULL DEFAULT 'Active',
  `total_a_matching_incm` varchar(11) NOT NULL DEFAULT '0',
  `total_b_matching_incm` varchar(11) NOT NULL DEFAULT '0',
  `total_c_matching_incm` varchar(11) NOT NULL DEFAULT '0',
  `total_d_matching_incm` varchar(15) NOT NULL DEFAULT '0',
  `total_e_matching_incm` varchar(15) NOT NULL DEFAULT '0',
  `my_business` varchar(10) NOT NULL DEFAULT '0',
  `total_a_investment` varchar(20) NOT NULL DEFAULT '0',
  `total_b_investment` varchar(20) NOT NULL DEFAULT '0',
  `paid_a_matching_incm` varchar(10) NOT NULL DEFAULT '0',
  `paid_b_matching_incm` varchar(10) NOT NULL DEFAULT '0',
  `secret` int(11) NOT NULL,
  `gift_level` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `member` (`id`, `name`, `email`, `phone`, `username`, `password`, `sponsor`, `position`, `signup_package`, `epin`, `address`, `join_time`, `placement_leg`, `A`, `B`, `C`, `D`, `E`, `total_a`, `total_b`, `total_c`, `total_d`, `total_e`, `paid_a`, `paid_b`, `paid_c`, `paid_d`, `paid_e`, `rank`, `registration_ip`, `session`, `last_login`, `last_login_ip`, `topup`, `mypv`, `total_a_pv`, `total_b_pv`, `total_c_pv`, `total_d_pv`, `total_e_pv`, `my_img`, `status`, `total_a_matching_incm`, `total_b_matching_incm`, `total_c_matching_incm`, `total_d_matching_incm`, `total_e_matching_incm`, `my_business`, `total_a_investment`, `total_b_investment`, `paid_a_matching_incm`, `paid_b_matching_incm`, `secret`, `gift_level`) VALUES
(1001, 'Master User', 'mlm@hotmail.com', '1010000', '1001', '$2y$10$bE/7nfOEdPWI3Lt09LBV4eji4f1Vc1CPi9nJdkAk/FNYYOgYjM2dK', '', '', '1', NULL, 'Demo Address', '1000-00-00', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Member', '', '4ea2eca0cdc89a8008f08a17118a4ff2', 1512229241, '127.0.0.1', '1.00', 0, '0', '0', '', '', '', NULL, 'Active', '0', '0', '', '', '', '0', '0', '0', '0', '0', 1, 1);

DROP TABLE IF EXISTS `member_profile`;
CREATE TABLE `member_profile` (
  `id` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `tax_no` varchar(20) NOT NULL DEFAULT 'N/A',
  `aadhar_no` varchar(20) NOT NULL DEFAULT 'NA',
  `bank_ac_no` varchar(60) DEFAULT '',
  `bank_name` varchar(200) DEFAULT '',
  `bank_ifsc` varchar(30) DEFAULT '',
  `bank_branch` varchar(70) DEFAULT '',
  `btc_address` varchar(70) DEFAULT '',
  `tcc_address` varchar(70) DEFAULT '',
  `nominee_name` varchar(120) NOT NULL DEFAULT 'NA',
  `nominee_add` varchar(300) NOT NULL DEFAULT 'NA',
  `nominee_relation` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gstin` varchar(20) NOT NULL DEFAULT 'NA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `member_profile` (`id`, `userid`, `tax_no`, `aadhar_no`, `bank_ac_no`, `bank_name`, `bank_ifsc`, `bank_branch`, `btc_address`, `tcc_address`, `nominee_name`, `nominee_add`, `nominee_relation`, `date_of_birth`, `gstin`) VALUES
(1, '1001', 'N/A', 'NA', 'NA', 'N/A', 'NA', 'NA', 'NA', 'NA', 'NA', 'NA', '', NULL, 'NA');

DROP TABLE IF EXISTS `other_wallet`;
CREATE TABLE `other_wallet` (
  `id` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `balance` decimal(11,2) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'Default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `other_wallet` (`id`, `userid`, `balance`, `type`) VALUES
(1, '1001', '0.00', 'Default');

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `category` varchar(20) NOT NULL,
  `prod_price` varchar(15) NOT NULL,
  `dealer_price` decimal(11,2) NOT NULL,
  `prod_desc` text NOT NULL,
  `pv` varchar(20) NOT NULL DEFAULT '0',
  `qty` int(10) NOT NULL DEFAULT '-1',
  `gst` decimal(11,2) NOT NULL,
  `image` varchar(200) NOT NULL,
  `show_on_regform` enum('Yes','No') NOT NULL DEFAULT 'No',
  `direct_income` decimal(11,2) DEFAULT '0.00',
  `level_income` varchar(200) DEFAULT NULL,
  `matching_income` decimal(11,2) DEFAULT '0.00',
  `capping` decimal(11,2) DEFAULT '0.00',
  `roi` decimal(11,2) DEFAULT '0.00',
  `roi_frequency` int(11) DEFAULT NULL,
  `roi_limit` int(11) DEFAULT NULL,
  `sold_qty` int(11) NOT NULL DEFAULT '0',
  `status` enum('Selling','Not-Selling') NOT NULL DEFAULT 'Selling'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL,
  `parent_cat` varchar(20) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `product_categories` (`id`, `cat_name`, `parent_cat`, `description`) VALUES
(1, 'Default Category', '', '<p>This is a default category.</p>\r\n');

DROP TABLE IF EXISTS `product_sale`;
CREATE TABLE `product_sale` (
  `id` int(11) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `userid` varchar(10) NOT NULL COMMENT 'who purchased the product',
  `status` enum('Completed','Processing') NOT NULL DEFAULT 'Processing',
  `franchisee_id` varchar(15) NOT NULL DEFAULT 'Admin',
  `cost` decimal(11,2) NOT NULL,
  `date` date NOT NULL,
  `deliver_date` date DEFAULT NULL,
  `tid` varchar(250) NOT NULL DEFAULT 'N/A',
  `qty` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(20) NOT NULL,
  `purchased_data` text NOT NULL,
  `bill_copy` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `supplier` varchar(200) DEFAULT NULL,
  `bill_amt` decimal(11,2) NOT NULL,
  `paid_amt` decimal(11,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `rank_system`;
CREATE TABLE `rank_system` (
  `id` int(11) NOT NULL,
  `rank_name` varchar(200) NOT NULL,
  `rank_duration` int(11) NOT NULL DEFAULT '0' COMMENT 'within how many days he should achieve this',
  `A` int(11) NOT NULL DEFAULT '0',
  `B` int(11) NOT NULL DEFAULT '0',
  `C` int(11) NOT NULL DEFAULT '0',
  `D` int(11) NOT NULL DEFAULT '0',
  `E` int(11) NOT NULL DEFAULT '0',
  `based_on` enum('Member','PV') NOT NULL DEFAULT 'Member'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `recharge_entry`;
CREATE TABLE `recharge_entry` (
  `id` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `service_type` enum('Mobile','DTH','Data Card','Utility Bill') NOT NULL DEFAULT 'Mobile',
  `recharge_no` varchar(40) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `time` int(11) NOT NULL,
  `status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending',
  `area` varchar(100) DEFAULT NULL,
  `operator` varchar(100) NOT NULL,
  `trnid` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `rewards`;
CREATE TABLE `rewards` (
  `id` int(11) NOT NULL,
  `reward_id` varchar(20) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Delivered','Pending') NOT NULL DEFAULT 'Pending',
  `paid_date` date NOT NULL,
  `tid` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `reward_setting`;
CREATE TABLE `reward_setting` (
  `id` int(11) NOT NULL,
  `reward_name` varchar(200) NOT NULL,
  `reward_duration` int(11) NOT NULL DEFAULT '0' COMMENT 'within how many days he should achieve this',
  `achievers` int(11) NOT NULL DEFAULT '0',
  `A` int(11) NOT NULL DEFAULT '0',
  `B` int(11) NOT NULL DEFAULT '0',
  `C` int(11) NOT NULL DEFAULT '0',
  `D` int(11) NOT NULL DEFAULT '0',
  `E` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `salary`;
CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `salary` decimal(11,2) NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `paydate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `staffs`;
CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `designtion` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(300) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `bank_detail` varchar(300) DEFAULT NULL,
  `pan` varchar(20) DEFAULT NULL,
  `aadhar` varchar(20) DEFAULT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '0:0:0:0',
  `last_login` date NOT NULL,
  `session` varchar(60) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `staff_designation`;
CREATE TABLE `staff_designation` (
  `id` int(11) NOT NULL,
  `des_title` varchar(200) NOT NULL,
  `des_permission` varchar(1000) NOT NULL,
  `payscale` decimal(11,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `survey`;
CREATE TABLE `survey` (
  `id` int(11) NOT NULL,
  `survey_name` varchar(200) NOT NULL,
  `question_answers` text NOT NULL,
  `level_earning` varchar(100) DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `type` enum('Hosted Survey','Third Party') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `survey_user`;
CREATE TABLE `survey_user` (
  `id` int(11) NOT NULL,
  `survey_id` varchar(20) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `data` text,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `tax_report`;
CREATE TABLE `tax_report` (
  `id` int(11) NOT NULL,
  `userid` varchar(10) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `payout_id` varchar(10) NOT NULL,
  `tax_amount` decimal(11,2) NOT NULL,
  `tax_percnt` varchar(10) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `ticket_title` varchar(300) NOT NULL,
  `ticket_detail` text NOT NULL,
  `userid` varchar(20) NOT NULL,
  `status` enum('Open','Waiting User Reply','Closed','Customer Reply') NOT NULL DEFAULT 'Open',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ticket_reply`;
CREATE TABLE `ticket_reply` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `msg_from` varchar(20) NOT NULL DEFAULT 'Admin',
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `gateway` varchar(20) NOT NULL,
  `time` int(11) NOT NULL,
  `transaction_id` varchar(150) NOT NULL DEFAULT 'NA',
  `status` enum('Completed','Processing','Failed') NOT NULL DEFAULT 'Completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `transfer_balance_records`;
CREATE TABLE `transfer_balance_records` (
  `id` int(11) NOT NULL,
  `transfer_from` varchar(10) NOT NULL,
  `transfer_to` varchar(10) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wallet`;
CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `balance` varchar(15) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT 'Default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `wallet` (`id`, `userid`, `balance`, `type`) VALUES
(1, '1001', '0', 'Default');

DROP TABLE IF EXISTS `withdraw_request`;
CREATE TABLE `withdraw_request` (
  `id` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `tax` decimal(11,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `status` enum('Paid','Un-Paid','Hold') NOT NULL DEFAULT 'Un-Paid',
  `paid_date` date DEFAULT NULL,
  `tid` varchar(200) DEFAULT NULL COMMENT 'Transaction ID or detail'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pending_wallet`;
CREATE TABLE `pending_wallet` (
  `id` int(11) NOT NULL,
  `userid` varchar(100) NOT NULL,
  `balance` varchar(20) NOT NULL,
  `status` enum('Paid','Pending') NOT NULL DEFAULT 'Pending',
  `txn_id` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `pending_wallet`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `admin_expense`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ad_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_id` (`ad_id`);

ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `userid` (`userid`);

ALTER TABLE `coupon_categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `donation_package`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `earning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `useird` (`userid`);

ALTER TABLE `epin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `epin` (`epin`),
  ADD KEY `issue_to` (`issue_to`);

ALTER TABLE `fix_income`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flexible_income`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `franchisee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `franchisee_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `franchisee_id` (`franchisee_id`);

ALTER TABLE `franchisee_stock_sale_bill`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gap_commission_setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `investment_pack`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `level`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

ALTER TABLE `level_wise_income`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE,
  ADD UNIQUE KEY `secret` (`secret`),
  ADD KEY `sponsor` (`sponsor`),
  ADD KEY `poisition` (`position`);

ALTER TABLE `member_profile`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `other_wallet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prod_name` (`prod_name`),
  ADD KEY `category` (`category`);

ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_sale`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rank_system`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `recharge_entry`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reward_setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `staff_designation`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `survey_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_id` (`survey_id`);

ALTER TABLE `tax_report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payout_id` (`payout_id`);

ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ticket_reply`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transfer_balance_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`transfer_from`);

ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

ALTER TABLE `withdraw_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`userid`);


ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `admin_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ad_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `coupon_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `donation_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `earning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `epin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `fix_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `flexible_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `franchisee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `franchisee_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `franchisee_stock_sale_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `gap_commission_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `investment_pack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48899;

ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `level_wise_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `member`
  MODIFY `secret` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `member_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `other_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `product_sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rank_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `recharge_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reward_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `staff_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `survey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `survey_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tax_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ticket_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `transfer_balance_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `withdraw_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `donations` ADD `file` VARCHAR(255) NULL AFTER `trid`;
ALTER TABLE `pending_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `member_profile`  ADD `id_proof` VARCHAR(200) NULL  AFTER `gstin`,  ADD `add_proof` VARCHAR(200) NULL  AFTER `id_proof`;
COMMIT;



<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `fanwe_deal_visit_log`;");
E_C("CREATE TABLE `fanwe_deal_visit_log` (
  `id` int(11) NOT NULL auto_increment,
  `deal_id` int(11) NOT NULL,
  `client_ip` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `deal_id` (`deal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=gbk");
E_D("replace into `fanwe_deal_visit_log` values('117','55','127.0.0.1','1352229137');");
E_D("replace into `fanwe_deal_visit_log` values('118','56','127.0.0.1','1352230070');");
E_D("replace into `fanwe_deal_visit_log` values('119','57','127.0.0.1','1352230830');");
E_D("replace into `fanwe_deal_visit_log` values('120','58','127.0.0.1','1352231514');");
E_D("replace into `fanwe_deal_visit_log` values('121','56','127.0.0.1','1352231651');");
E_D("replace into `fanwe_deal_visit_log` values('122','55','127.0.0.1','1352232299');");
E_D("replace into `fanwe_deal_visit_log` values('123','58','127.0.0.1','1352232420');");
E_D("replace into `fanwe_deal_visit_log` values('124','56','127.0.0.1','1352232590');");
E_D("replace into `fanwe_deal_visit_log` values('125','57','127.0.0.1','1352232717');");
E_D("replace into `fanwe_deal_visit_log` values('126','55','127.0.0.1','1352246374');");
E_D("replace into `fanwe_deal_visit_log` values('127','57','127.0.0.1','1352246699');");
E_D("replace into `fanwe_deal_visit_log` values('128','56','127.0.0.1','1352246710');");
E_D("replace into `fanwe_deal_visit_log` values('129','58','127.0.0.1','1352246719');");
E_D("replace into `fanwe_deal_visit_log` values('130','58','140.224.90.157','1353888322');");
E_D("replace into `fanwe_deal_visit_log` values('131','55','140.224.90.157','1353888330');");
E_D("replace into `fanwe_deal_visit_log` values('132','57','140.224.90.157','1353888339');");
E_D("replace into `fanwe_deal_visit_log` values('133','57','116.28.48.56','1361047640');");
E_D("replace into `fanwe_deal_visit_log` values('134','56','127.0.0.1','1364012515');");
E_D("replace into `fanwe_deal_visit_log` values('135','55','127.0.0.1','1364012843');");
E_D("replace into `fanwe_deal_visit_log` values('136','57','127.0.0.1','1364013380');");
E_D("replace into `fanwe_deal_visit_log` values('137','56','127.0.0.1','1364013647');");
E_D("replace into `fanwe_deal_visit_log` values('138','55','127.0.0.1','1364014145');");

require("../../inc/footer.php");
?>
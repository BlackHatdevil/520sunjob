<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `fanwe_log`;");
E_C("CREATE TABLE `fanwe_log` (
  `id` int(11) NOT NULL auto_increment,
  `log_info` text NOT NULL,
  `log_time` int(11) NOT NULL,
  `log_admin` int(11) NOT NULL,
  `log_ip` varchar(255) NOT NULL,
  `log_status` tinyint(1) NOT NULL,
  `module` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2395 DEFAULT CHARSET=gbk");
E_D("replace into `fanwe_log` values('2359','方维众筹添加成功','1352227067','1','127.0.0.1','1','IndexImage','insert');");
E_D("replace into `fanwe_log` values('2360','方维众筹添加成功','1352227077','1','127.0.0.1','1','IndexImage','insert');");
E_D("replace into `fanwe_log` values('2361','原创DIY桌面游戏《功夫》《黄金密码》期待您的支持更新成功','1352229024','1','127.0.0.1','1','Deal','update');");
E_D("replace into `fanwe_log` values('2362','原创DIY桌面游戏《功夫》《黄金密码》期待您的支持更新成功','1352229031','1','127.0.0.1','1','Deal','update');");
E_D("replace into `fanwe_log` values('2363','55_is_recommend启用成功','1352229046','1','127.0.0.1','1','Deal','toogle_status');");
E_D("replace into `fanwe_log` values('2394','admin登录成功','1364014964','1','127.0.0.1','1','Public','do_login');");

require("../../inc/footer.php");
?>
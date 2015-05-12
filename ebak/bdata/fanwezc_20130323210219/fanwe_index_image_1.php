<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `fanwe_index_image`;");
E_C("CREATE TABLE `fanwe_index_image` (
  `id` int(11) NOT NULL auto_increment,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=gbk");
E_D("replace into `fanwe_index_image` values('5','./public/attachment/201211/07/10/5099c97ad9f82.gif','http://vip.souho.net','1','更多极品商业源码,就在搜虎精品社区VIP服务：vip.souho.cc');");
E_D("replace into `fanwe_index_image` values('6','./public/attachment/201211/07/10/5099c984946c3.jpg','http://www.souho.net','2','搜虎精品社区www.souho.net|www.souho.cc提供本程序');");

require("../../inc/footer.php");
?>
<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `fanwe_user`;");
E_C("CREATE TABLE `fanwe_user` (
  `id` int(11) NOT NULL auto_increment,
  `user_name` varchar(255) NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `is_effect` tinyint(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `money` double(20,4) NOT NULL,
  `login_time` int(11) NOT NULL,
  `login_ip` varchar(50) NOT NULL,
  `province` varchar(10) NOT NULL,
  `city` varchar(10) NOT NULL,
  `password_verify` varchar(255) NOT NULL COMMENT '找回密码的验证号',
  `sex` tinyint(1) NOT NULL COMMENT '性别',
  `build_count` int(11) NOT NULL COMMENT '发起的项目数',
  `support_count` int(11) NOT NULL COMMENT '支持的项目数',
  `focus_count` int(11) NOT NULL COMMENT '关注的项目数',
  `integrate_id` int(11) NOT NULL,
  `intro` text NOT NULL COMMENT '个人简介',
  `ex_real_name` varchar(255) NOT NULL COMMENT '发布者真实姓名',
  `ex_account_info` text NOT NULL COMMENT '银行帐号等信息',
  `ex_contact` text NOT NULL COMMENT '联系方式',
  `code` varchar(255) NOT NULL,
  `sina_id` varchar(255) NOT NULL,
  `sina_token` varchar(255) NOT NULL,
  `sina_secret` varchar(255) NOT NULL,
  `sina_url` varchar(255) NOT NULL,
  `tencent_id` varchar(255) NOT NULL,
  `tencent_token` varchar(255) NOT NULL,
  `tencent_secret` varchar(255) NOT NULL,
  `tencent_url` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `is_effect` (`is_effect`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=gbk");
E_D("replace into `fanwe_user` values('17','fanwe','6714ccb93be0fda4e51f206b91b46358','1352227130','1352227130','1','97139915@qq.com','1200.0000','1352232219','127.0.0.1','福建','福州','','1','3','1','1','0','方维众筹 - http://zc.fanwe.cn','','','','','','','','','','','','');");
E_D("replace into `fanwe_user` values('18','fzmatthew','6714ccb93be0fda4e51f206b91b46358','1352229180','1352229180','1','fanwe@fanwe.com','980.0000','1352246617','127.0.0.1','北京','东城区','','1','0','3','1','0','爱旅行的猫，生活在路上','','','','','','','','','','','','');");
E_D("replace into `fanwe_user` values('19','test','098f6bcd4621d373cade4e832627b4f6','1352230142','1352230142','1','test@test.com','0.0000','1352232937','127.0.0.1','广东','江门','','0','0','10','0','0','','','','','','','','','','','','','');");

require("../../inc/footer.php");
?>
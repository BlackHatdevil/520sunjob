<?php
// +----------------------------------------------------------------------
// | Fanwe 方维o2o商业系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 云淡风轻(97139915@qq.com)
// +----------------------------------------------------------------------


require APP_ROOT_PATH.'app/Lib/app_init.php';


class App{		
	private $module_obj;
	//网站项目构造
	public function __construct(){		
		$module_name = $GLOBALS['module']."Module";
		$this->module_obj = new $module_name;
		$this->module_obj->$GLOBALS['action']();
	}
	
	public function __destruct()
	{
		unset($this);
	}
}
?>
<?php

class msettingsModule extends BaseModule
{
    public function get_all_settings()
    {		
        if(!$GLOBALS['user_info'])
            ajax_return(array("status"=>0));//未登录返回status为0;

        $region_pid = 0;
        $region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2 order by py asc");  //二级地址
        foreach($region_lv2 as $k=>$v)
        {
            if($v['name'] == $GLOBALS['user_info']['province'])
            {
                $region_lv2[$k]['selected'] = 1;
                $region_pid = $region_lv2[$k]['id'];
                break;
            }
        }
        $province = $region_lv2;


        if($region_pid>0)
        {
            $region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".$region_pid." order by py asc");  //三级地址
            foreach($region_lv3 as $k=>$v)
            {
                if($v['name'] == $GLOBALS['user_info']['city'])
                {
                    $region_lv3[$k]['selected'] = 1;
                    break;
                }
            }
            $city = $region_lv3;
        }

        $contact_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."user_contact where user_id = ".intval($GLOBALS['user_info']['id']));
        ajax_return(array("province"=>$province,"city"=>$city,"contact"=>$contact_list,"status"=>1));
    }

    public function switch_city(){
        $province_id = intval($_REQUEST['province_id']);  //province
        if($province_id>0){
            $region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".$province_id." order by py asc");  //获得城市
        }else{
            //如果没有选择省份需要吧城市置0,前端遇到index为0就return
            $region_lv3[0]['id'] = 0;
        }
        ajax_return($region_lv3);
    }

    //保存设定
    public function save_settings()
    {		
        if(!$GLOBALS['user_info'])
        {
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }

        if(!check_ipop_limit(get_client_ip(),"setting_save_index",5))
            ajax_return(array("status"=>0,"info"=>"提交太频繁！","url"=>""));

        require_once APP_ROOT_PATH."system/libs/user.php";

        $user_data = array();
        //省份和城市有点特殊，上传的是id必须重新获取名字
        $province_id=intval($_REQUEST['province']);
        if($province_id>0){
            $user_data['province'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."region_conf where id = ".$province_id);
        }else{
            $user_data['province'] = "";
        }
        $city_id=intval($_REQUEST['city']);
        if($city_id>0){
            $user_data['city'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."region_conf where id = ".$city_id);
        }else{
            $user_data['city'] = "";
        }

        $user_data['sex'] = intval($_REQUEST['sex']);
        $user_data['intro'] = strim($_REQUEST['intro']);
        $GLOBALS['db']->autoExecute(DB_PREFIX."user",$user_data,"UPDATE","id=".intval($GLOBALS['user_info']['id']));

        $GLOBALS['db']->query("delete from ".DB_PREFIX."user_contact where user_id = ".intval($GLOBALS['user_info']['id']));
        foreach($_REQUEST['contact'] as $k=>$v)
        {
            if($v!="")
            {
                $contact_data = array();
                $contact_data['user_id'] = intval($GLOBALS['user_info']['id']);
                $contact_data['contact'] = strim($v);
                $GLOBALS['db']->autoExecute(DB_PREFIX."user_contact",$contact_data);
            }
        }

        ajax_return(array("status"=>1,"info"=>"资料更新成功！"));
    }

    //用户更新密码
    public function save_password()
    {		
        $ajax = intval($_REQUEST['ajax']);
        if(!$GLOBALS['user_info'])
        {
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }

        if(!check_ipop_limit(get_client_ip(),"setting_save_password",5))
            ajax_return(array("status"=>0,"info"=>"提交太频繁！","url"=>""));

        $user_pwd = strim($_REQUEST['user_pwd']);
        $confirm_user_pwd = strim($_REQUEST['confirm_user_pwd']);
        if(strlen($user_pwd)<4)
        {
            ajax_return(array("status"=>0,"info"=>"密码不能小于四位！","url"=>""));
        }
        if($user_pwd!=$confirm_user_pwd)
        {
            ajax_return(array("status"=>1,"info"=>"确认密码不一致！","url"=>""));
        }

        require_once APP_ROOT_PATH."system/libs/user.php";
        $user_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user where id = ".intval($GLOBALS['user_info']['id']));
        $user_info['user_pwd'] = $user_pwd;
        save_user($user_info,"UPDATE");

        ajax_return(array("status"=>1,"info"=>"密码已经修改成功！建议退出重新登陆一下","url"=>""));
    }
}
?>

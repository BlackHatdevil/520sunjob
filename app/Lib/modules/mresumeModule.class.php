<?php
class mresumeModule extends BaseModule{
    public function get_resume(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        //获取所有的求职意向cate
        $intention_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_cate order by sort asc");
        $user_resume= $GLOBALS['db']->getROW("select * from ".DB_PREFIX."user_resume where user_id = ".intval($GLOBALS['user_info']['id']));
        //分割出
        $user_resume['intention']=explode("|",$user_resume['intention']);
        foreach($intention_list as $k=>$v){
            foreach($user_resume['intention'] as $k1=>$v1){
                if($v['id']==$v1){
                    //如果用户存在该意向就添加selected为1
                    $intention_list[$k]['selected']=1;
                }
            }
        }
        $contact_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."user_contact where user_id = ".intval($GLOBALS['user_info']['id']));
        ajax_return(array("contact"=>$contact_list,"status"=>1,"resume"=>$user_resume,"intention"=>$intention_list));
    }

    //编辑个人简历
    public function edit_resume(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }

        /*列出全部的intention即cate*/
        $intention_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_cate order by sort asc");
        //获取用户的resume
        $user_resume = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_resume where user_id = ".$GLOBALS['user_info']['id']);

        //分割出intention
        $user_resume['intention']=explode("|",$user_resume['intention']);
        //遍历对比用户的intention和所有intention(cate)
        foreach($intention_list as $k=>$v){
            foreach($user_resume['intention'] as $k1=>$v1){
                if($v['id']==$v1){
                    //如果用户存在该意向就添加selected为1
                    $intention_list[$k]['selected']=1;
                }
            }
        }
        $user_resume['create_time']=pass_date($user_resume['create_time']);
        ajax_return(array("status"=>1,"intention"=>$intention_list,"resume"=>$user_resume));
    }

    //保存新的简历
    public function save_resume(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        //循环获取求职意向id
        $data['intention'] = NULL;
        for($i=0;$i<count($_REQUEST['intention']);$i++){
            $data['intention'].=intval($_REQUEST['intention'][$i])."|";
        }
        $data['create_time']=NOW_TIME;
        $data['real_name']=trim($_REQUEST['real_name']);
        $data['height']=intval($_REQUEST['height']);
        $data['weight']=intval($_REQUEST['weight']);
        $data['birth']=trim($_REQUEST['birth']);
        $data['college']=trim($_REQUEST['college']);
        $data['introme']=trim($_REQUEST['introme']);
        $data['experience']=trim($_REQUEST['experience']);
        $GLOBALS['db']->autoExecute(DB_PREFIX."user_resume",$data,"UPDATE","user_id=".intval($GLOBALS['user_info']['id']));
        ajax_return(array("status"=>1,"info"=>"简历更新成功","url"=>""));
    }

    //读取学校
    public function search_get_college(){
        $kw=$_REQUEST['college'];
        $k_len=strlen($kw)/3;
        if($kw!=""&&$k_len>2)
        {		
            $college_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."college where school_name like '%".$kw."%'");
        }
        ajax_return($college_list);
    }

    //获取空余时间表
    public function show_freetime_table(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        $time_table = $GLOBALS['db']->getOne("select time_table from ".DB_PREFIX."user_resume where user_id = ".intval($GLOBALS['user_info']['id']));
        ajax_return(array("status"=>1,"time_table"=>$time_table));
    }
    //编辑空余时间表 
    public function edit_freetime(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        $data['time_table']=$_REQUEST['time_table'];
        $GLOBALS['db']->autoExecute(DB_PREFIX."user_resume",$data,"UPDATE","user_id=".intval($GLOBALS['user_info']['id']));
        ajax_return(array("status"=>1,"info"=>"保存成功！","url"=>""));//未登录返回status为0;
    }
}
?>

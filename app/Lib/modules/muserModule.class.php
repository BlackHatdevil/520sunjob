<?php
/*所有“m”开头的模块都是用于手机app数据传输的
 *程序员：devil
 *用户登陆注册模块2015-2-1
 * */
class muserModule extends BaseModule{
    //用户点击注册后写入数据库
    public function do_register(){
        //引入用户登陆的检测脚本
        require_once APP_ROOT_PATH."system/libs/user.php";

        //读取用户提交的信息保存在$user_data
        $user_data = $_POST;
        foreach($_POST as $k=>$v)
        {
            $user_data[$k] = strim($v);
        }	
        $user_data['is_effect'] = 1;

        //检测以及保存
        $res = save_user($user_data);


        //判断返回数据的可行性
        if($res['status'] == 1)//注册成功
        {
            $user_id = intval($res['data']);
            $user_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user where id = ".$user_id);

            //不用审核直接通过的
            if($user_info['is_effect']==1)
            {
                //手机端不自动登陆，ajax返回跳转
                ajax_return(array("status"=>1,"jump"=>"index.html"));
            }
            //如果用户需要审核
            else
            {
                ajax_return(array("status"=>0,"info"=>"请等待管理员审核"));
            }
        }
        else
        {
            $error = $res['data'];	
            if($error['field_name']=="user_name")
            {
                $data[] = array("type"=>"form_success","field"=>"email","info"=>"");	
                $field_name = "会员帐号";
            }
            if($error['field_name']=="email")
            {
                $data[] = array("type"=>"form_success","field"=>"user_name","info"=>"");
                $field_name = "电子邮箱";
            }

            if($error['error']==EMPTY_ERROR)
            {
                $error_info = "不能为空";
                $type = "form_tip";
            }
            if($error['error']==FORMAT_ERROR)
            {
                $error_info = "格式有误";
                $type="form_error";
            }
            if($error['error']==EXIST_ERROR)
            {
                $error_info = "已存在";
                $type="form_error";
            }

            $data[] = array("type"=>$type,"field"=>$error['field_name'],"info"=>$field_name.$error_info);	
            ajax_return(array("status"=>0,"data"=>$data,"info"=>""));			
        }
    }

    //用户登陆函数
    public function do_login(){
        //遍历上传的登陆账号和密码
        foreach($_POST as $k=>$v)
        {
            $_POST[$k] = strim($v);
        }
        $ajax = intval($_REQUEST['ajax']);
        //禁止非ajax请求
        if(!$ajax){
            return;
        }

        require_once APP_ROOT_PATH."system/libs/user.php";
        //检查是否反复登陆
        if(check_ipop_limit(get_client_ip(),"muser_dologin",5))
            $result = do_login_user($_POST['email'],$_POST['user_pwd']);
        else
            ajax_return(array("info"=>"提交太频繁！请稍等......","status"=>0));		

        //通过登陆验证
        if($result['status'])
        {	
            $s_user_info = es_session::get("user_info");
            //自动登录，保存cookie
            $user_data = $s_user_info;
            es_cookie::set("email",$user_data['email'],3600*24*30);			
            es_cookie::set("user_pwd",md5($user_data['user_pwd']."_EASE_COOKIE"),3600*24*30);
            //传回登陆成功数据
            $jump_url = "index.html";	
            $return['status'] = 1;
            $return['info'] = "登录成功";
            $return['jump'] = $jump_url;					
            ajax_return($return);
        }
        //登陆信息错误
        else
        {
            if($result['data'] == ACCOUNT_NO_EXIST_ERROR)
            {
                $err = "会员不存在！";
            }
            if($result['data'] == ACCOUNT_PASSWORD_ERROR)
            {
                $err = "账号或密码错误！";
            }
            $return['status'] = 0;
            $return['info'] = $err;
            ajax_return($return);
        }
    }

    //用户退出
    public function loginout(){		
        $ajax = intval($_REQUEST['ajax']);
        require_once APP_ROOT_PATH."system/libs/user.php";
        $result = loginout_user();
        if($result['status']){
            es_cookie::delete("email");
            es_cookie::delete("user_pwd");
            es_cookie::delete("hide_user_notify");
            if($ajax==1){
                $return['status'] = 1;
                $return['info'] = "登出成功";
                $return['data'] = $result['msg'];
                $return['jump'] = "index.html";	
                ajax_return($return);
            }
            else{
                return;
            }
        }
        else{
            if($ajax==1)
            {
                $return['status'] = 1;
                $return['info'] = "登出成功";
                $return['jump'] = "index.html";	
                ajax_return($return);
            }
            else
                return;
        }
    }
}
?>

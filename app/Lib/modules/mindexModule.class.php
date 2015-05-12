<?php
/*********************************************************************************
 *mobile主页的函数;
 *programmer:devil;
 *2015-2-4; 
 ************************************************************************************/

class mindexModule extends BaseModule{
    /*获取用户登陆信息*/
    public function get_login_info(){
        //初始化login状态
        $user_login['is_login']=0;

        //获取检查login信息
        if($GLOBALS['user_info']){
            //先获取全部
            $user_info=$GLOBALS['user_info'];
            $user_info['is_login']=1;
            $user_info['id']=intval($GLOBALS['user_info']['id']);
            $user_info['img']['middle']=get_user_avatar($GLOBALS['user_info']['id'],"middle");
            $user_info['img']['big']=get_user_avatar($GLOBALS['user_info']['id'],"big");
            $user_info['img']['small']=get_user_avatar($GLOBALS['user_info']['id'],"small");
            $user_info['user_name']=$GLOBALS['user_info']['user_name'];
            $user_info['email']=$GLOBALS['user_info']['email'];
        }
        else{
            $user_info['is_login']=0;
        }
        ajax_return($user_info);
    }
}
?>

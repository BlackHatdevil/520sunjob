<?php
/******************************************
 * mdealModule是移动端输出兼职的类
 * 程序员：devil
 * 修改日期:2015-2-10
 * ****************************************/

class mdealModule extends BaseModule
{
    public function show_deal_all()
    {
        $id = intval($_REQUEST['id']);
        //获取兼职信息
        $deal_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id = ".$id." and is_delete = 0 and (is_effect = 1 or (is_effect = 0 and user_id = ".intval($GLOBALS['user_info']['id'])."))");
        if(!$deal_info)
        {
            $return['status']=0;
            $return['info']="无法加载该条兼职⊙﹏⊙ </br>可能是被删除了哦~";
            ajax_return($return);
        }		

        //获取用户关注信息
        if($GLOBALS['user_info']){
            $focus_data = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_focus_log where deal_id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']));
            $sign_data = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_sign where deal_id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']));
        }else{
            $focus_data = false;
            $sign_data = false;
        }

        //处理获得的数据
        if($focus_data){
            $is_focus=1;
        }else{
            $is_focus=0;
        }
        if($sign_data){
            $is_sign=1;
        }else{
            $is_sign=0;
        }
        $deal_info['create_time']=pass_date($deal_info['create_time']);
        $deal_info['begin_time']=date("m月d日 h:i",$deal_info['begin_time']);
        $deal_info['end_time']=date("m月d日 h:i",$deal_info['end_time']);
        $deal_info['type'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id = ".$deal_info['cate_id']);

        if($deal_info['is_effect']==1)
        {
            log_deal_visit($deal_info['id']);
        }		

        if($deal_info['is_effect']==1)
            $deal_faq_list= $GLOBALS['db']->getAllCached("select * from ".DB_PREFIX."deal_faq where deal_id = ".$deal_info['id']." order by sort asc");
        else
            $deal_faq_list= $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_faq where deal_id = ".$deal_info['id']." order by sort asc");
        $GLOBALS['tmpl']->assign("deal_faq_list",$deal_faq_list);

        ajax_return(array("status"=>1,"deal_info"=>$deal_info,"deal_faq"=>$deal_faq_list,"is_focus"=>$is_focus,"is_sign"=>$is_sign));
    }

    //关注某个工作
    public function focus(){
        if(!$GLOBALS['user_info']){
            $data['status'] = 0;
        }
        else{
            $id = intval($_REQUEST['id']);
            $deal_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id = ".$id." and is_delete = 0 and is_effect = 1");
            if(!$deal_info){
                $data['status'] = 3;	
                $data['info'] = "工作不存在";
                ajax_return($data);
            }

            $focus_data = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_focus_log where deal_id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']));
            if($focus_data){
                $GLOBALS['db']->query("update ".DB_PREFIX."deal set focus_count = focus_count - 1 where id = ".$id." and is_effect = 1");
                if($GLOBALS['db']->affected_rows()>0){
                    $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_focus_log where id = ".$focus_data['id']);
                    $GLOBALS['db']->query("update ".DB_PREFIX."user set focus_count = focus_count - 1 where id = ".intval($GLOBALS['user_info']['id']));

                    //删除准备队列
                    $GLOBALS['db']->query("delete from ".DB_PREFIX."user_deal_notify where user_id = ".intval($GLOBALS['user_info']['id'])." and deal_id = ".$id);
                    $data['status'] = 2;	
                }	
                else{
                    $data['status'] = 3;	
                    $data['info'] = "工作未上线";
                }		
            }
            else{
                $GLOBALS['db']->query("update ".DB_PREFIX."deal set focus_count = focus_count + 1 where id = ".$id." and is_effect = 1");
                if($GLOBALS['db']->affected_rows()>0){
                    $focus_data['user_id'] = intval($GLOBALS['user_info']['id']);
                    $focus_data['deal_id'] = $id;
                    $focus_data['create_time'] = NOW_TIME;
                    $GLOBALS['db']->autoExecute(DB_PREFIX."deal_focus_log",$focus_data);
                    $GLOBALS['db']->query("update ".DB_PREFIX."user set focus_count = focus_count + 1 where id = ".intval($GLOBALS['user_info']['id']));

                    //关注工作成功，准备加入准备队列
                    if($deal_info['is_success'] == 0 && $deal_info['begin_time'] < NOW_TIME && ($deal_info['end_time']==0 || $deal_info['end_time']>NOW_TIME)){
                        //未成功的项止准备生成队列
                        $notify['user_id'] = $GLOBALS['user_info']['id'];
                        $notify['deal_id'] = $deal_info['id'];
                        $notify['create_time'] = NOW_TIME;
                        $GLOBALS['db']->autoExecute(DB_PREFIX."user_deal_notify",$notify,"INSERT","","SILENT");
                    }

                    $data['status'] = 1;
                }
                else{
                    $data['status'] = 3;
                    $data['info'] = "工作未上线";
                }
            }
        }
        ajax_return($data);
    }

    //报名
    public function sign(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没登陆,请登录后报名!","url"=>""));
        }

        $id = intval($_REQUEST['id']);

        //检查一下这个兼职是否存在
        $deal_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where is_delete = 0 and is_effect = 1 and id = ".$id);

        if(!$deal_info){
            ajax_return(array("status"=>0,"info"=>"找不到该兼职","url"=>""));
        }
        if($deal_info['is_success'] == 1 || $deal_info['end_time'] < NOW_TIME){
            ajax_return(array("status"=>0,"info"=>"此兼职已经结束招募,无法再申请","url"=>""));
        }

        $order_info['deal_id'] = $deal_info['id'];
        $order_info['post_id'] = $deal_info['user_id'];//发布者id
        $order_info['post_username'] = $deal_info['user_name'];//发布者姓名
        $order_info['user_id'] = intval($GLOBALS['user_info']['id']);
        $order_info['user_name'] = $GLOBALS['user_info']['user_name'];
        $order_info['deal_name'] = $deal_info['name'];
        $order_info['sign_status'] = 0;//申请状态0未同意
        $order_info['sign_time'] = NOW_TIME;//申请时间当前时间
        $order_info['agree_time'] = 0;//同意时间初始化0
        $order_info['employ_time'] = 0;//录用时间初始化0

        $count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_sign where deal_id = ".$order_info['deal_id']." and user_id = ".$order_info['user_id']);
        if($count>0){
            ajax_return(array("status"=>1,"info"=>"您已经报名了!","url"=>""));
        }
        //写入order表
        $GLOBALS['db']->query("update ".DB_PREFIX."deal set sign_count = sign_count + 1 where id = ".$id." and is_effect = 1");
        $GLOBALS['db']->autoExecute(DB_PREFIX."deal_sign",$order_info,"INSERT","SILENT");

        $order_id = $GLOBALS['db']->insert_id();
        if($order_id>0){
            ajax_return(array("status"=>1,"info"=>"已发送报名申请","url"=>""));
        }else{
            ajax_return(array("status"=>0,"info"=>"报名失败","url"=>""));
        }
    }
}
?>

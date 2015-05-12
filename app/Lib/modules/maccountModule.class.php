<?php
class maccountModule extends BaseModule{
    public function focus(){		
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        $limit = 10;

        $s = intval($_REQUEST['s']);
        if($s==3)
            $sort_field = " d.support_amount desc ";
        if($s==1)
            $sort_field = " d.support_count desc ";
        if($s==2)
            $sort_field = " d.support_amount - d.limit_price desc ";
        if($s==0)
            $sort_field = " d.end_time asc ";

        $f = intval($_REQUEST['f']);
        if($f==0)
            $cond = " 1=1 ";
        if($f==1)
            $cond = " d.begin_time < ".NOW_TIME." and (d.end_time = 0 or d.end_time > ".NOW_TIME.") ";
        if($f==2)
            $cond = " d.end_time <> 0 and d.end_time < ".NOW_TIME." and d.is_success = 1 "; //过期成功
        if($f==3)
            $cond = " d.end_time <> 0 and d.end_time < ".NOW_TIME." and d.is_success = 0 "; //过期失败

        $app_sql = " ".DB_PREFIX."deal_focus_log as dfl left join ".DB_PREFIX."deal as d on d.id = dfl.deal_id where dfl.user_id = ".intval($GLOBALS['user_info']['id']).
            " and d.is_effect = 1 and d.is_delete = 0 and ".$cond." ";

        $deal_list = $GLOBALS['db']->getAll("select d.*,dfl.id as fid from ".$app_sql." order by ".$sort_field." limit ".$limit);
        $deal_count = $GLOBALS['db']->getOne("select count(*) from ".$app_sql);

        foreach($deal_list as $k=>$v)
        {
            $deal_list[$k]['remain_days'] = floor(($v['end_time'] - NOW_TIME)/(24*3600));
            $deal_list[$k]['percent'] = round($v['support_amount']/$v['limit_price']*100);
        }
        ajax_return(array("deals"=>$deal_list,"status"=>1,"info"=>"","url"=>""));
    }

    //删除focus
    public function del_focus(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }

        $id = intval($_REQUEST['id']);
        $deal_id = $GLOBALS['db']->getOne("select deal_id from ".DB_PREFIX."deal_focus_log where id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']));
        $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_focus_log where id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']));
        $GLOBALS['db']->query("update ".DB_PREFIX."deal set focus_count = focus_count - 1 where id = ".intval($deal_id));
        $GLOBALS['db']->query("delete from ".DB_PREFIX."user_deal_notify where user_id = ".intval($GLOBALS['user_info']['id'])." and deal_id = ".$deal_id);
        ajax_return(array("status"=>1));
    }

    //查看用户报名的函数
    public function sign(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        $limit = 10;

        $sign_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_sign where user_id = ".intval($GLOBALS['user_info']['id'])." and is_delete = 0 order by sign_status asc limit ".$limit);

        foreach($sign_list as $k=>$v){
            $sign_list[$k]['sign_time'] = date("m月d日 h:i",$v['sign_time']);
            $sign_list[$k]['agree_time'] = date("m月d日 h:i",$v['agree_time']);
            $sign_list[$k]['employ_time'] = date("m月d日 h:i",$v['employ_time']);
            $sign_list[$k]['is_effect'] = 1;

            $deal_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id = ".$sign_list[$k]['deal_id']." and is_effect = 1 and is_delete = 0");
            //找不到deal标记失效
            if(!$deal_item)
                $sign_list[$k]['is_effect'] = 0;
            //如果状态已经是2
            if($v['sign_status']==2) continue;
            //若招聘已经结束
            if($deal_item['is_success'] == 1 || $deal_item['end_time'] < NOW_TIME){
                //未被同意
                if($sign_list[$k]['sign_status'] == 0) $sign_list[$k]['is_effect'] = 0;
                //已经被同意
                else {
                    $GLOBALS['db']->query("update ".DB_PREFIX."deal_sign set sign_status = 2 ,employ_time =".$deal_item['end_time']." where id = ".$sign_list[$k]['id']);//设置状态为2
                    $sign_list[$k]['sign_status'] = 2;
                }
            }
            unset($deal_item);
        }
        ajax_return(array("signs"=>$sign_list,"status"=>1,"info"=>"","url"=>""));
    }

    //显示所申请兼职的详情
    public function show_sign_deal(){
        $id = intval($_REQUEST['id']);
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        //获取兼职信息
        $sign_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_sign where id = ".$id." and is_delete = 0 and user_id = ".intval($GLOBALS['user_info']['id']));
        if(!$sign_info) ajax_return(array("status"=>3,"info"=>"你的申请已被删除或者不存在！"));
        $deal_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id = ".$sign_info['deal_id']." and is_delete = 0 and is_effect = 1");
        if(!$deal_info) ajax_return(array("status"=>3,"info"=>"该项工作已经不存在！"));

        //设置sign有效
        $sign_info['is_effect'] = 1;
        //过期
        if($deal_info['end_time'] < NOW_TIME || $deal_info['is_success'] == 1){
            //未同意
            if($sign_info['sign_status'] == 0)
                //则失效
                $sign_info['is_effect'] = 0;
        }
        //获取分类列表
        $cate = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id = ".$deal_info['cate_id']);
        //返回申请的信息和兼职的信息
        ajax_return(array("status"=>1,"sign"=>$sign_info,"deal"=>$deal_info,"cate"=>$cate));
    }

    //删除一条申请
    public function delete_sign(){
        $id = intval($_REQUEST['id']);
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        $sign_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_sign where user_id = ".intval($GLOBALS['user_info']['id'])." and id = ".$id);
        //状态为2表示已经录用
        if($sign_item['sign_status'] == 2){
            ajax_return(array("status"=>0,"info"=>"您已经被录用，请联系企业撤消申请！","url"=>""));
        }
        $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_sign where id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']));
        ajax_return(array("status"=>1,"info"=>"撤消成功","url"=>"sign.html"));
    }

    /*现任工作相关working*/

    //返回用户当前工作
    public function working(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"没有登陆！","url"=>"home.html"));//未登录返回status为0;
        }
        $limit = 10;
        $sign_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_sign where user_id = ".intval($GLOBALS['user_info']['id'])." and is_delete = 0 and sign_status >= 2 order by employ_time asc limit ".$limit);
        foreach($sign_list as $k=>$v){
            $sign_list[$k]['employ_time'] = date("m月d日 h:i",$v['employ_time']);
        }
        ajax_return(array("status"=>1,"info"=>"","works"=>$sign_list));
    }

    public function show_working_detail(){
        $id = $_REQUEST['id'];
        $sign_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_sign where user_id =".intval($GLOBALS['user_info']['id'])." and id=".$id." and is_delete=0 and sign_status >= 2");
        if(!$sign_item) ajax_return(array("status"=>0,"info"=>"申请的工作已经不存在","url"=>"working.html"));
        $deal_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id=".$sign_item['deal_id']);
        if(!$deal_item) ajax_return(array("status"=>0,"info"=>"工作已经不存在","url"=>"working.html"));

        $detail['name'] = $deal_item['name'];
        $detail['limit_price'] = $deal_item['limit_price'];
        $detail['pay_way'] = $deal_item['pay_way'];
        $detail['settlement'] = $deal_item['settlement'];
        $detail['workdays'] = $deal_item['workdays'];
        $detail['worktime'] = $deal_item['worktime'];
        $detail['location'] = $deal_item['location'];
        $detail['contact'] = $deal_item['contact'];
        $detail['description'] = $deal_item['description'];
        $detail['sign_status'] = $sign_item['sign_status'];
        $detail['employ_time'] = date("Y年m月d日",$sign_item['employ_time']);
        ajax_return(array("status"=>1,"detail"=>$detail,"url"=>""));
    }
}
?>

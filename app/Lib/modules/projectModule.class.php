<?php

require APP_ROOT_PATH.'app/Lib/page.php';
class projectModule extends BaseModule
{
    public function add()
    {			
        if(!$GLOBALS['user_info'])
            app_redirect(url("user#login"));

        $GLOBALS['tmpl']->assign("page_title","发起项目");
        $region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2 order by py asc");  //二级地址
        $GLOBALS['tmpl']->assign("region_lv2",$region_lv2);

        $cate_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_cate order by sort asc");
        $GLOBALS['tmpl']->assign("cate_list",$cate_list);

        $deal_image =  es_session::get("deal_image");
        $GLOBALS['tmpl']->assign("deal_image",$deal_image);

        $GLOBALS['tmpl']->display("project_add.html");
    }

    public function edit()
    {			
        if(!$GLOBALS['user_info'])
            app_redirect(url("user#login"));

        $id = intval($_REQUEST['id']);
        $deal_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id = ".$id." and is_effect = 0 and is_delete = 0 and user_id = ".intval($GLOBALS['user_info']['id']));
        if($deal_item)
        {
            $GLOBALS['tmpl']->assign("page_title",$deal_item['name']);


            $region_pid = 0;
            $region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2 order by py asc");  //二级地址
            foreach($region_lv2 as $k=>$v)
            {
                if($v['name'] == $deal_item['province'])
                {
                    $region_lv2[$k]['selected'] = 1;
                    $region_pid = $region_lv2[$k]['id'];
                    break;
                }
            }
            $GLOBALS['tmpl']->assign("region_lv2",$region_lv2);


            if($region_pid>0)
            {
                $region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".$region_pid." order by py asc");  //三级地址
                foreach($region_lv3 as $k=>$v)
                {
                    if($v['name'] == $deal_item['city'])
                    {
                        $region_lv3[$k]['selected'] = 1;
                        break;
                    }
                }
                $GLOBALS['tmpl']->assign("region_lv3",$region_lv3);
            }

            $deal_item['faq_list'] = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_faq where deal_id = ".$deal_item['id']." order by sort asc");
            $cate_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_cate order by sort asc");
            $GLOBALS['tmpl']->assign("cate_list",$cate_list);
            $GLOBALS['tmpl']->assign("deal_item",$deal_item);

            $GLOBALS['tmpl']->display("project_edit.html");
        }	
        else
        {
            app_redirect_preview();
        }		

    }


    public function save()
    {

        $ajax = intval($_REQUEST['ajax']);	
        if(!check_ipop_limit(get_client_ip(),"project_save",5))
            showErr("提交太频繁",$ajax,"");	

        if(!$GLOBALS['user_info'])
        {
            showErr("",$ajax,url("user#login"));
        }
        $id =  intval($_REQUEST['id']);

        $data['name'] = strim($_REQUEST['name']);
        if($data['name']=="")
        {
            showErr("请填写项目名称",$ajax,"");
        }
        if(msubstr($data['name'],0,25)!=$data['name'])
        {			
            showErr("项目名称不超过25个字",$ajax,"");
        }
        $data['cate_id'] = intval($_REQUEST['cate_id']);
        if($data['cate_id']==0)
        {
            showErr("请选择项目分类",$ajax,"");
        }
        $data['province'] = strim($_REQUEST['province']);
        if($data['province']=='')
        {
            showErr("请选择省份",$ajax,"");
        }
        $data['city'] = strim($_REQUEST['city']);
        if($data['city']=='')
        {
            showErr("请选择城市",$ajax,"");
        }
        $data['brief'] = strim($_REQUEST['brief']);

        require_once APP_ROOT_PATH."system/libs/words.php";	
        $data['tags'] = implode(" ",words::segment($data['name']));


        $data['description'] = replace_public(addslashes(trim(valid_tag($_REQUEST['description']))));	

        $data['limit_price'] = doubleval($_REQUEST['limit_price']);
        if($data['limit_price']<=0)
        {
            showErr("请输入正确的工资",$ajax,"");
        }
        $data['pay_way'] = strim($_REQUEST['pay_way']);
        if($data['pay_way']==""){
            showErr("请输入工资单位",$ajax,"");
        }
        $data['settlement'] = strim($_REQUEST['settlement']);
        if($data['settlement']==""){
            showErr("请输入工资结算方式",$ajax,"");
        }
        $data['deal_days'] = doubleval($_REQUEST['deal_days']);
        if($data['deal_days']<=0)
        {
            showErr("请输入正确的上线天数",$ajax,"");
        }
        $data['limit_applicant'] = intval($_REQUEST['limit_applicant']);
        if($data['limit_applicant']<=0){
            showErr("请输入正确的限制名额",$ajax,"");
        }
        /*新增的一些字段*/
        $data['job'] = intval($_REQUEST['job']);
        $data['company'] = strim($_REQUEST['company']);
        if($data['company']==""){
            showErr("请输入公司名称",$ajax,"");
        }
        if(msubstr($data['company'],0,25)!=$data['company'])
        {			
            showErr("公司名称不超过25个字",$ajax,"");
        }

        $data['if_interview'] = intval($_REQUEST['if_interview']);
        //只有当需要面试的时候才收集以下信息
        if($data['if_interview']==1){
            $data['interviewer'] = strim($_REQUEST['interviewer']);
            $data['interview_contact'] = strim($_REQUEST['interview_contact']);
            $data['interview_time'] = strim($_REQUEST['interview_time']);
            $data['interview_loc'] = strim($_REQUEST['interview_loc']);
        }

        $data['sex'] = intval($_REQUEST['sex']);

        $data['workdays'] = strim($_REQUEST['workdays']);
        if($data['workdays']=="")
        {
            showErr("请填写工作周期",$ajax,"");
        }
        if(msubstr($data['workdays'],0,50)!=$data['workdays'])
        {			
            showErr("工作周期不超过50个字",$ajax,"");
        }

        $data['worktime'] = strim($_REQUEST['worktime']);
        if($data['worktime']=="")
        {
            showErr("请填写工作时长",$ajax,"");
        }
        if(msubstr($data['worktime'],0,50)!=$data['worktime'])
        {			
            showErr("工作周期不超过50个字",$ajax,"");
        }

        $data['contact'] = strim($_REQUEST['contact']);
        if($data['contact']=="")
        {
            showErr("请填写工作联系方式",$ajax,"");
        }
        if(intval($data['contact'])!=$data['contact'])
        {			
            showErr("请填写正确的号码（数字）",$ajax,"");
        }

        $data['location'] = strim($_REQUEST['location']);
        if($data['location']=="")
        {
            showErr("请填写详细（县级市开始到路和门牌）工作地址",$ajax,"");
        }
        if(msubstr($data['location'],0,50)!=$data['location'])
        {			
            showErr("工作地址不超过50个字",$ajax,"");
        }



        if($id>0)
        {
            $savenext = intval($_REQUEST['savenext']);
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal",$data,"UPDATE","id=".$id,"SILENT");

            if($savenext==0)
            {
                showSuccess($id,$ajax,"");
            }
            else
            {
                showSuccess("",$ajax,url("project#add_item",array("id"=>$id)));
            }
        }
        else
        {
            $data['user_id'] = intval($GLOBALS['user_info']['id']);
            $data['user_name'] = $GLOBALS['user_info']['user_name'];
            $data['create_time'] = NOW_TIME;

            $savenext = intval($_REQUEST['savenext']);
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal",$data,"INSERT","","SILENT");
            $data_id = intval($GLOBALS['db']->insert_id());
            if($data_id==0)
            {
                showErr("保存失败，请联系管理员",$ajax,"");
            }
            else
            {
                if($savenext==0)
                {
                    showSuccess($data_id,$ajax,"");
                }
                else
                {
                    showSuccess("",$ajax,url("project#add_item",array("id"=>$data_id)));
                }
            }

        }		

    }

    public function del()
    {
        $ajax = intval($_REQUEST['ajax']);	


        if(!$GLOBALS['user_info'])
        {
            showErr("",$ajax,url("user#login"));
        }

        $id = intval($_REQUEST['id']);

        $GLOBALS['db']->query("delete from ".DB_PREFIX."deal where id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']." and is_effect = 0 and is_delete = 0"));
        if($GLOBALS['db']->affected_rows()>0)
        {
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_item where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_item_image where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_comment where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_faq where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_focus_log where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_log where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_pay_log where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_support_log where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_visit_log where deal_id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_sign where deal_id = ".$id);
            showSuccess("",$ajax,get_gopreview());
        }
        else
        {
            showErr("删除失败",$ajax);
        }
    }

    public function add_item()
    {			
        if(!$GLOBALS['user_info'])
            app_redirect(url("user#login"));			


        $id = intval($_REQUEST['id']);
        $deal_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where is_effect = 0 and is_delete = 0 and id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']));
        if($deal_item)
        {		

            $deal_item_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_item where deal_id = ".$deal_item['id']." order by price asc");
            $GLOBALS['tmpl']->assign("deal_item_list",$deal_item_list);

            $GLOBALS['tmpl']->assign("deal_item",$deal_item);
            $GLOBALS['tmpl']->assign("page_title","回报设置 - ".$deal_item['name']);
            $GLOBALS['tmpl']->display("project_add_item.html");
        }
        else
        {
            app_redirect_preview();
        }
    }

    public function edit_item()
    {			
        if(!$GLOBALS['user_info'])
            app_redirect(url("user#login"));			


        $id = intval($_REQUEST['id']);
        $item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_item where id = ".$id);
        $deal_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where is_effect = 0 and is_delete = 0 and id = ".$item['deal_id']." and user_id = ".intval($GLOBALS['user_info']['id']));
        if($deal_item&&$item)
        {		
            $deal_item_images = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_item_image where deal_id = ".$deal_item['id']." and deal_item_id = ".$item['id']);
            $GLOBALS['tmpl']->assign("deal_item_images",$deal_item_images);

            $GLOBALS['tmpl']->assign("deal_item",$deal_item);
            $GLOBALS['tmpl']->assign("item",$item);
            $GLOBALS['tmpl']->assign("page_title","回报设置 - ".$deal_item['name']);
            $GLOBALS['tmpl']->display("project_edit_item.html");
        }
        else
        {
            app_redirect_preview();
        }
    }

    public function del_item()
    {			
        $ajax = intval($_REQUEST['ajax']);	


        if(!$GLOBALS['user_info'])
        {
            showErr("",$ajax,url("user#login"));
        }		


        $id = intval($_REQUEST['id']);
        $item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_item where id = ".$id);
        $deal_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where is_effect = 0 and is_delete = 0 and id = ".$item['deal_id']." and user_id = ".intval($GLOBALS['user_info']['id']));
        if($deal_item&&$item)
        {		
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_item where id = ".$id);
            $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_item_image where deal_item_id = ".$id);
            showErr("",$ajax,get_gopreview());

        }
        else
        {
            showErr("删除失败",$ajax);
        }
    }

    public function save_deal_item()
    {
        $ajax = intval($_REQUEST['ajax']);	
        if(!$GLOBALS['user_info'])
        {
            showErr("",$ajax,url("user#login"));
        }

        $id = intval($_REQUEST['id']);

        $data['price'] = doubleval($_REQUEST['price']);
        if($data['price']<=0)
            showErr("请输入正确的价格",$ajax);

        $data['description'] = strim($_REQUEST['description']);
        $data['is_delivery'] = intval($_REQUEST['is_delivery']);
        $data['delivery_fee'] = doubleval($_REQUEST['delivery_fee']);
        $data['is_limit_user'] = intval($_REQUEST['is_limit_user']);
        $data['limit_user'] = intval($_REQUEST['limit_user']);
        $data['repaid_day'] = intval($_REQUEST['repaid_day']);
        $data['deal_id'] = intval($_REQUEST['deal_id']);

        if(count($_REQUEST['image'])>4)
        {
            showErr("图片不能超过四张",$ajax);
        }

        if($id==0)
        {
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal_item",$data,"INSERT","","SILENT");
            $result_id = intval($GLOBALS['db']->insert_id());
            if($result_id>0)
            {
                if(count($_REQUEST['image'])>=0)
                {
                    foreach($_REQUEST['image'] as $k=>$v)
                    {
                        $image_data['deal_id'] = $data['deal_id'];
                        $image_data['deal_item_id'] = $result_id;
                        $image_data['image'] = replace_public($v);
                        $GLOBALS['db']->autoExecute(DB_PREFIX."deal_item_image",$image_data);
                    }					
                }
                showSuccess("发布成功,等待审核",$ajax,get_gopreview());
            }
            else
            {
                showErr("保存失败",$ajax);
            }
        }
        else
        {
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal_item",$data,"UPDATE","id=".$id,"SILENT");
            if(count($_REQUEST['image'])>=0)
            {
                $GLOBALS['db']->query("delete from ".DB_PREFIX."deal_item_image where deal_item_id = ".$id);
                foreach($_REQUEST['image'] as $k=>$v)
                {
                    $image_data['deal_id'] = $data['deal_id'];
                    $image_data['deal_item_id'] = $id;
                    $image_data['image'] = replace_public(strim($v));
                    $GLOBALS['db']->autoExecute(DB_PREFIX."deal_item_image",$image_data);
                }					
            }
            showSuccess("保存成功",$ajax,get_gopreview());
        }

    }

    public function signers(){
        if(!$GLOBALS['user_info'])
            app_redirect(url("user#login"));	
        $id = intval($_REQUEST['id']);

        $page_size = ACCOUNT_PAGE_SIZE;
        $page = intval($_REQUEST['p']);
        if($page==0)
            $page = 1;
        $limit = (($page-1)*$page_size).",".$page_size;

        $deal = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id = ".$id);
        $sign_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_sign where deal_id = ".$id." and is_delete = 0 order by sign_time desc limit ".$limit);
        foreach($sign_list as $k=>$v)
        {
            if($sign_list[$k]['agree_time']!=="")
                $sign_list[$k]['agree_time'] = pass_date($v['agree_time']);
            $sign_list[$k]['sign_time'] = pass_date($v['sign_time']);
            $sign_list[$k]['limit_price'] = intval($v['limit_price']);
        }
        $sign_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_sign where deal_id = ".$id." and is_delete = 0");

        $page = new Page($sign_count,$page_size);   //初始化分页对象 		
        $p  =  $page->show();
        $GLOBALS['tmpl']->assign('pages',$p);
        $GLOBALS['tmpl']->assign('sign_list',$sign_list);
        $GLOBALS['tmpl']->assign('deal',$deal);
        $GLOBALS['tmpl']->display("project_signers.html");
    }
    //
    //切换同意状态的函数
    public function toggle_agree(){
        $ajax = intval($_REQUEST['ajax']);	
        if(!$GLOBALS['user_info'])
            app_redirect(url("user#login"));

        $id = intval($_REQUEST['id']);
        $sign_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_sign where id = ".$id." and is_delete = 0 and post_id = ".intval($GLOBALS['user_info']['id']));
        if($sign_item)
        {
            if($sign_item['sign_status'] == 0){
                $GLOBALS['db']->query("update ".DB_PREFIX."deal_sign set sign_status = 1 where id = ".$sign_item['id']);
                $GLOBALS['db']->query("update ".DB_PREFIX."deal_sign set agree_time = ".NOW_TIME." where id = ".$sign_item['id']);
            }
            else{
                $GLOBALS['db']->query("update ".DB_PREFIX."deal_sign set sign_status = 0 where id = ".$sign_item['id']);
                $GLOBALS['db']->query("update ".DB_PREFIX."deal_sign set agree_time = 0 where id = ".$sign_item['id']);
            }
            showSuccess("",$ajax,get_gopreview());
        }	
        else
        {
            app_redirect_preview();
        }		

    }

    //手动结束deal招聘
    public function success_deal(){
        $ajax = intval($_REQUEST['ajax']);	

        if(!$GLOBALS['user_info'])
        {
            showErr("",$ajax,url("user#login"));
        }

        $id = intval($_REQUEST['id']);

        $GLOBALS['db']->query("update ".DB_PREFIX."deal set is_success = 1 ,end_time = ".NOW_TIME." where id = ".$id." and user_id = ".intval($GLOBALS['user_info']['id']." and is_effect = 1 and is_delete = 0"));
        if($GLOBALS['db']->affected_rows()>0)
        {
            showSuccess("结束成功",$ajax,get_gopreview());
        }
        else
        {
            showErr("结束失败",$ajax);
        }
    }

}
?>

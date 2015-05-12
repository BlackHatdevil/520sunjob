<?php
/******************************************
 * mdealsModule是移动端输出兼职的类
 * 程序员：devil
 * 修改日期:2015-2-10
 * ****************************************/

class mdealsModule extends BaseModule
{
    //show_deals是载入deals页面时候执行的加载最新的deals所用
    public function show_deals()
    {		
        $amount = $_REQUEST['amount'];

        $select_cate = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_cate order by sort asc");
        //获得省份
        $region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2 order by py asc");
        $condition = " is_delete = 0 and is_effect = 1 "; 
        //接下来是根据用户定位获取的当前位置，可以保存在前端的localstorage中获取
        if($province!="")
            $condition.="and province=".$province;
        if($city!="")
            $condition.="and city=".$city;

        $deals_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal where ".$condition);
        $limit=$amount;

        $deal_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal where ".$condition." order by sort asc , create_time desc limit ".$limit);
        foreach($deal_list as $k=>$v)
        {
            $deal_list[$k]['create_time'] = pass_date($v['create_time']);
            $deal_list[$k]['limit_price'] = intval($v['limit_price']);
        }
        //初始化deals页面的时候需要省份，全部的最新deals(瀑布流限制)，还有分类
        ajax_return(array("deals"=>$deal_list,"province"=>$region_lv2,"cate"=>$select_cate,"count"=>$deals_count));
    }

    //用户操作后匹配筛选的deals
    public function filter_deals(){
        //加载更多的参数

        //分页三大参数
        $last = $_REQUEST['last'];//当前的 deals个数
        $amount = $_REQUEST['amount'];//要加载的的个数
        $count = $_REQUEST['count'];//上一次刷新计数

        //province_id指定城市
        $province_id = intval($_REQUEST['province_id']);  //province
        $cate_id = intval($_REQUEST['cate_id']);  //filter
        $city_id = intval($_REQUEST['city_id']);  //city
        //初始化省份城市
        $city = "";
        $province = "";

        //province用于筛选,千万注意这里的where后面跟的是id=，我这个白痴一开始是pid=，所以搜不出来！
        if($province_id>0){
            $province = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."region_conf where id = ".$province_id." order by py asc");  //获得城市
            $province=strim($province);
        }
        //city用于筛选
        if($city_id>0){
            $city = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."region_conf where id = ".$city_id." order by py asc");  //获得城市
            $city=strim($city);
        }
        //关键词用于筛选
        $kw = strim($_REQUEST['search']);    //搜索关键词

        //获取当前省份下的所有城市
        if($province_id > 0){
            $region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".$province_id." order by py asc");  //获得城市
        }
        else{
            //如果没有选择省份需要吧城市置0,前端遇到index为0就return
            $region_lv3[0]['id'] = 0;
        }

        $condition = " is_delete=0 and is_effect=1 "; 
        //递进筛选
        //注意下面这些带有中文字的必须要加上引号！！
        if($province!="")
            $condition.=" and province='$province'";
        if($city!="")
            $condition.=" and city='$city'";
        if($cate_id > 0)
            $condition.=" and cate_id=$cate_id";
        if($kw!="")
        {		
            $kws_div = div_str($kw);
            foreach($kws_div as $k=>$item)
            {

                $kws[$k] = str_to_unicode_string($item);
            }
            $ukeyword = implode(" ",$kws);
            $condition.=" and (match(name_match) against('".$ukeyword."'  IN BOOLEAN MODE) or match(tags_match) against('".$ukeyword."'  IN BOOLEAN MODE)  or name like '%".$kw."%') ";
        }

        $condition=strim($condition);
        //分页计数
        //计数
        $deals_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal where ".$condition);
        //判断前端是否已经有deals列出
        if($last!=0){
            //限制加载数目=当前个数+数据库多出来的个数,请求加载数目
            $limit = $last+($deals_count - $count).",".$amount;
        }else{
            $limit = $amount;
        }

        $deal_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal where ".$condition." order by sort asc , create_time desc limit ".$limit);
        if(!$deal_list){
            //找不到status就置为0,并且只返回城市
            ajax_return(array("city"=>$region_lv3,"status"=>"0","count"=>$deals_count));
        }
        foreach($deal_list as $k=>$v)
        {
            $deal_list[$k]['create_time'] = pass_date($v['create_time']);
            $deal_list[$k]['limit_price'] = intval($v['limit_price']);
        }
        //设置筛选状态为1
        ajax_return(array("deals"=>$deal_list,"city"=>$region_lv3,"status"=>"1","count"=>$deals_count));
    }

    //在主页点击的那个获取最新的兼职
    public function show_latest_deals(){
        //获得省份
        $region_lv2 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where region_level = 2 order by py asc");
        $condition = " is_delete = 0 and is_effect = 1 "; 
        $limit=10;
        //接下来是根据用户定位获取的当前位置，可以保存在前端的localstorage中获取
        if($province!="")
            $condition.="and province=".$province;
        if($city!="")
            $condition.="and city=".$city;

        $deal_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal where ".$condition." order by create_time desc limit ".$limit);
        $count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal where ".$condition);
        foreach($deal_list as $k=>$v)
        {
            $deal_list[$k]['create_time'] = pass_date($v['create_time']);
            $deal_list[$k]['limit_price'] = intval($v['limit_price']);
        }
        //初始化deals页面的时候需要省份，全部的最新deals(瀑布流限制)，还有分类
        ajax_return(array("deals"=>$deal_list,"province"=>$region_lv2,"cate"=>$select_cate,"count"=>$count));
    }

    public function filter_deals_latest(){
        //province_id指定城市
        $province_id = intval($_REQUEST['province_id']);  //province
        $city_id = intval($_REQUEST['city_id']);  //city
        //初始化省份城市
        $city = "";
        $province = "";

        //province用于筛选,千万注意这里的where后面跟的是id=，我这个白痴一开始是pid=，所以搜不出来！
        if($province_id>0){
            $province = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."region_conf where id = ".$province_id." order by py asc");  //获得城市
            $province=strim($province);
        }
        //city用于筛选
        if($city_id>0){
            $city = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."region_conf where id = ".$city_id." order by py asc");  //获得城市
            $city=strim($city);
        }

        //获取当前省份下的所有城市
        if($province_id > 0){
            $region_lv3 = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."region_conf where pid = ".$province_id." order by py asc");  //获得城市
        }
        else{
            //如果没有选择省份需要吧城市置0,前端遇到index为0就return
            $region_lv3[0]['id'] = 0;
        }

        $condition = " is_delete=0 and is_effect=1 "; 
        $limit=10;
        //递进筛选
        //注意下面这些带有中文字的必须要加上引号！！
        if($province!="")
            $condition.=" and province='$province'";
        if($city!="")
            $condition.=" and city='$city'";

        $condition=strim($condition);
        $deal_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal where ".$condition." order by create_time desc limit ".$limit);
        if(!$deal_list){
            //找不到status就置为0,并且只返回城市
            ajax_return(array("city"=>$region_lv3,"status"=>"0"));
        }
        foreach($deal_list as $k=>$v)
        {
            $deal_list[$k]['create_time'] = pass_date($v['create_time']);
            $deal_list[$k]['limit_price'] = intval($v['limit_price']);
        }
        //设置筛选状态为1
        ajax_return(array("deals"=>$deal_list,"city"=>$region_lv3,"status"=>"1"));
    }

    //获取用户可能感兴趣的职业
    public function interest_deals(){
        if(!$GLOBALS['user_info']){
            ajax_return(array("status"=>0,"info"=>"寻找有兴趣的工作前,请先登陆!"));
        }
        $intention = $GLOBALS['db']->getOne("select intention from ".DB_PREFIX."user_resume where user_id = ".$GLOBALS['user_info']['id']);
        if(!$intention){
            ajax_return(array("status"=>-1,"info"=>"简历不完善"));
        }

        $intention_arr=explode("|",$intention);
        foreach( $intention_arr as $k=>$v ){
            if($v!=""){
                //不是第一个就要加上'or'
                if($k!=0){
                    $condition.= " or ";
                }
                $condition.= "cate_id = $v";
            }
        }
        $sql = "select * from ".DB_PREFIX."deal where is_effect = 1 and is_delete = 0 and (".$condition.")";
        $deals = $GLOBALS['db']->getAll($sql);
        foreach($deals as $k=>$v)
        {
            $deals[$k]['create_time'] = pass_date($v['create_time']);
            $deals[$k]['limit_price'] = intval($v['limit_price']);
        }
        ajax_return(array("status"=>1,"deals"=>$deals));
    }
}
?>

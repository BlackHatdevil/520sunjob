<?php echo $this->fetch('inc/header.html'); ?> 
<?php
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/deal_list.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/deal_list.js";
$this->_var['dpagecss'][] = $this->_var['TMPL_REAL']."/css/account.css";
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['dpagecss'],
);
echo $k['name']($k['v']);
?>" />
<script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['dpagejs'],
  'c' => $this->_var['dcpagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
<div class="blank"></div>

<div class="shadow_bg">
    <div class="wrap white_box">
        <div class="page_title">
            我发布的招聘
        </div>
        <div class="switch_nav">
            <ul>
                <li class="current"><a href="<?php
echo parse_url_tag("u:account#project|"."".""); 
?>">我的招聘</a></li>
                <li><a href="<?php
echo parse_url_tag("u:account#project|"."".""); 
?>">我的员工</a></li>
                <!--
                <li><a href="<?php
echo parse_url_tag("u:account#index|"."".""); 
?>">我的申请</a></li>
                <li><a href="<?php
echo parse_url_tag("u:account#focus|"."".""); 
?>">我关注的招聘</a></li>
                <li><a href="<?php
echo parse_url_tag("u:account#credit|"."".""); 
?>">收支明细</a></li>
                -->
            </ul>
        </div>

        <!--
        <div class="blank"></div>		
        <?php echo $this->fetch('inc/money_box.html'); ?> 		
        -->

        <div class="full">
            <?php if ($this->_var['deal_list']): ?>
            <table class="data-table">
                <tr>
                    <th>项目名称</th>
                    <th width="50">状态</th>
                    <th width="200">操作</th>
                </tr>
                <?php $_from = $this->_var['deal_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'deal_item');if (count($_from)):
    foreach ($_from AS $this->_var['deal_item']):
?>
                <tr>
                    <td class="deal_name">
                        <div>
                            <a class="deal_title" href="<?php
echo parse_url_tag("u:deal#show|"."id=".$this->_var['deal_item']['id']."".""); 
?>" target="_blank" title="<?php echo $this->_var['deal_item']['name']; ?>"><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['deal_item']['name'],
  'b' => '0',
  'e' => '25',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?>
                            </a>
                            <?php if ($this->_var['deal_item']['job'] == 0): ?>
                            <span class="span_green">兼职</span>
                            <?php else: ?>
                            <span class="span_orange">全职</span>
                            <?php endif; ?>
                        </div>	
                        <div class="blank"></div>
                        <div class="info">
                            <div><a href="<?php
echo parse_url_tag("u:project#signers|"."id=".$this->_var['deal_item']['id']."".""); 
?>">已报名：<?php echo $this->_var['deal_item']['sign_count']; ?></a></div>
                            <div>保证工资：<?php echo $this->_var['deal_item']['limit_price']; ?>元/<?php echo $this->_var['deal_item']['pay_way']; ?></div>
                            <div>发布时间：<?php echo $this->_var['deal_item']['create_time']; ?></div>
                        </div>
                    </td>
                    <td>
                        <?php if ($this->_var['deal_item']['is_effect'] == 0): ?>
                        <div class="red">审核中</div>
                        <?php else: ?>
                        <?php if ($this->_var['deal_item']['is_success'] == 1): ?>
                        <div class="green">已结束</div>
                        <?php else: ?>
                        <?php if ($this->_var['deal_item']['end_time'] > $this->_var['now']): ?>
                        <div class="orange">招聘中</div>
                        <?php else: ?>
                        <div class="green">已结束</div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($this->_var['deal_item']['is_effect'] == 0): ?>
                        <!--未审核-->
                        <a href="<?php
echo parse_url_tag("u:project#edit|"."id=".$this->_var['deal_item']['id']."".""); 
?>">编辑招聘</a>
                        <a href="<?php
echo parse_url_tag("u:project#del|"."id=".$this->_var['deal_item']['id']."".""); 
?>" class="del_deal">删除</a>
                        <?php else: ?>
                        <?php if ($this->_var['deal_item']['is_success'] == 1): ?>
                        <!--结束-->
                        <a href="<?php
echo parse_url_tag("u:project#signers|"."id=".$this->_var['deal_item']['id']."".""); 
?>">查看求职者</a>
                        <?php else: ?>
                        <?php if ($this->_var['deal_item']['end_time'] > $this->_var['now']): ?>
                        <!--进行中-->
                        <a href="<?php
echo parse_url_tag("u:project#signers|"."id=".$this->_var['deal_item']['id']."".""); 
?>">查看求职者</a>
                        <div class="blank"></div>
                        <a href="<?php
echo parse_url_tag("u:project#success_deal|"."id=".$this->_var['deal_item']['id']."".""); 
?>" class="success_deal">标记结束(手动停止招聘)</a>
                        <div class="blank"></div>
                        <?php else: ?>
                        <!--结束-->
                        <a href="<?php
echo parse_url_tag("u:project#signers|"."id=".$this->_var['deal_item']['id']."".""); 
?>">查看求职者</a>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </td>

                </tr>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>

            <?php else: ?>
            <div class="empty_tip">
                从过创发布过任何招聘 <a href="<?php
echo parse_url_tag("u:project#add|"."".""); 
?>" class="linkgreen">立即发布一个工作</a>
            </div>
            <?php endif; ?>


        </div>
        <div class="blank"></div>
        <div class="pages"><?php echo $this->_var['pages']; ?></div>
        <div class="blank"></div>

    </div>
</div>
<div class="blank"></div>
<?php echo $this->fetch('inc/footer.html'); ?> 

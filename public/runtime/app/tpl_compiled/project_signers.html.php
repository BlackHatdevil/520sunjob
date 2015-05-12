<?php echo $this->fetch('inc/header.html'); ?> 
<?php
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/sign_list.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/sign_list.js";
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
            <?php echo $this->_var['deal']['name']; ?>
            <?php if ($this->_var['deal']['is_success'] == 1 || $this->_var['deal']['end_time'] < $this->_var['now']): ?>
            <font class="red">(已结束)</font>
            <?php endif; ?>
            <a href="<?php
echo parse_url_tag("u:account#project|"."id=".$this->_var['user_info']['id']."".""); 
?>" class="back"> << 返回招聘列表</a>
        </div>

        <div class="full">
            <?php if ($this->_var['sign_list']): ?>
            <table class="data-table">
                <tr>
                    <th>求职者</th>
                    <th width="50">状态</th>
                    <th width="200">操作</th>
                </tr>
                <?php $_from = $this->_var['sign_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sign_item');if (count($_from)):
    foreach ($_from AS $this->_var['sign_item']):
?>
                <tr>
                    <td class="deal_name">
                        <div>
                            <div>
                                <a href="<?php
echo parse_url_tag("u:deal#show|"."id=".$this->_var['sign_item']['user_id']."".""); 
?>" target="_blank" title="<?php echo $this->_var['sign_item']['user_name']; ?>"><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['sign_item']['user_name'],
  'b' => '0',
  'e' => '25',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?>
                                </a>
                            </div>
                            <div>申请时间：<?php echo $this->_var['sign_item']['sign_time']; ?></div>
                            <div>同意时间：<?php if ($this->_var['sign_item']['agree_time'] == 0): ?><font color="orange">未同意</font>
                                <?php else: ?><?php echo $this->_var['sign_item']['agree_time']; ?>
                                <?php endif; ?></div>
                        </div>	
                    </td>
                    <td>
                        <?php if ($this->_var['sign_item']['sign_status'] == 0): ?>
                        <div class="orange">未同意</div>
                        <?php else: ?>
                        <?php if ($this->_var['sign_item']['sign_status'] == 1): ?>
                        <div class="green">已同意</div>
                        <?php else: ?>
                        <?php if ($this->_var['sign_item']['sign_status'] == 2): ?>
                        <div class="green">已录用</div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($this->_var['deal']['is_effect'] == 0): ?>
                        <!--未审核-->
                        招聘审核中：无法操作
                        <?php else: ?>
                        <?php if ($this->_var['deal']['is_success'] == 1): ?>
                        <!--已结束-->
                        <a href="<?php
echo parse_url_tag("u:home#user_resume|"."id=".$this->_var['sign_item']['user_id']."".""); 
?>">查看TA的简历</a>
                        <div class="blank"></div>
                        <a href="#">解雇</a>
                        <?php if ($this->_var['sign_item']['sign_status'] == 1): ?>
                        <div class="blank"></div>
                        <a class="employ" href="<?php
echo parse_url_tag("u:project#employ|"."id=".$this->_var['sign_item']['id']."".""); 
?>">确认录用</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a class="employ" href="<?php
echo parse_url_tag("u:project#unemploy|"."id=".$this->_var['sign_item']['id']."".""); 
?>">不录用</a>
                        <?php endif; ?>
                        <?php else: ?>
                        <!--进行中-->
                        <?php if ($this->_var['deal']['end_time'] > $this->_var['now']): ?>
                        <a href="#">查看TA的简历</a>
                        <div class="blank"></div>
                        <?php if ($this->_var['sign_item']['sign_status'] == 1): ?>
                        <a class="toggle_agree" href="<?php
echo parse_url_tag("u:project#toggle_agree|"."id=".$this->_var['sign_item']['id']."".""); 
?>">不同意</a>
                        <?php else: ?>
                        <a class="toggle_agree" href="<?php
echo parse_url_tag("u:project#toggle_agree|"."id=".$this->_var['sign_item']['id']."".""); 
?>">同意</a>
                        <?php endif; ?>
                        <?php else: ?>
                        <!--已到期-->
                        <a href="#">查看TA的简历</a>
                        <div class="blank"></div>
                        <a href="#">解雇</a>
                        <?php if ($this->_var['sign_item']['sign_status'] == 1): ?>
                        <div class="blank"></div>
                        <a class="employ" href="<?php
echo parse_url_tag("u:project#employ|"."id=".$this->_var['sign_item']['id']."".""); 
?>">确认录用</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a class="employ" href="<?php
echo parse_url_tag("u:project#unemploy|"."id=".$this->_var['sign_item']['id']."".""); 
?>">不录用</a>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>

            <?php else: ?>
            <div class="empty_tip">
                尚没有报名参加这份工作！ <a href="<?php
echo parse_url_tag("u:project#signers|"."".""); 
?>" class="linkgreen">点击邀请会员报名</a>
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

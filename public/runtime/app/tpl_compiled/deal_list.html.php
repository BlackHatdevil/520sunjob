<?php $_from = $this->_var['deal_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'deal_item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['deal_item']):
?>
<div class="deal_item_box">
    <div class="deal_content_box">
        <a href="<?php
echo parse_url_tag("u:deal#show|"."id=".$this->_var['deal_item']['id']."".""); 
?>" title="<?php echo $this->_var['deal_item']['name']; ?>" class="deal_title"><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['deal_item']['name'],
  'b' => '0',
  'e' => '25',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?></a>
        <div class="blank"></div>
        <ul class="k_l">
            <li>
            <?php if ($this->_var['deal_item']['user_name'] == ''): ?><?php else: ?>
            <a href="<?php
echo parse_url_tag("u:home|"."id=".$this->_var['deal_item']['user_id']."".""); 
?>"><?php echo $this->_var['deal_item']['user_name']; ?></a>&nbsp;&nbsp;
            <?php endif; ?>
            <?php if ($this->_var['deal_item']['province'] != '' || $this->_var['deal_item']['city'] != ''): ?>
            (
            <?php if ($this->_var['deal_item']['province'] != ''): ?>
            <span><a href="<?php
echo parse_url_tag("u:deals|"."loc=".$this->_var['deal_item']['province']."".""); 
?>" title="<?php echo $this->_var['deal_item']['province']; ?>"><?php echo $this->_var['deal_item']['province']; ?></a></span>
            <?php endif; ?>
            <?php if ($this->_var['deal_item']['city'] != ''): ?>
            <span><a href="<?php
echo parse_url_tag("u:deals|"."loc=".$this->_var['deal_item']['city']."".""); 
?>" title="<?php echo $this->_var['deal_item']['city']; ?>"><?php echo $this->_var['deal_item']['city']; ?></a></span>
            <?php endif; ?>
            )
            <?php endif; ?>
            </li>
            <li>发布时间：<?php echo $this->_var['deal_item']['create_time']; ?></li>
            <li>薪资：<?php echo $this->_var['deal_item']['limit_price']; ?>元&nbsp;/&nbsp;<?php echo $this->_var['deal_item']['pay_way']; ?></li>
            <li class="short">面试：<?php if ($this->_var['deal_item']['if_interview'] == 1): ?>需要<?php else: ?>不需要<?php endif; ?></li>
            <li class="short">性别：<?php echo $this->_var['deal_item']['sex']; ?></li>
            <li class="short">名额：<?php echo $this->_var['deal_item']['sign_count']; ?>&nbsp;/&nbsp;<?php echo $this->_var['deal_item']['limit_applicant']; ?></li>
            <li class="short">浏览：<?php echo $this->_var['deal_item']['view_count']; ?></li>
        </ul>
        <div class="blank"></div>
    </div>
</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

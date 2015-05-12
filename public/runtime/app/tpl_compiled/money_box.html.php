<div class="money_box">
			<div class="credit_box">帐户余额 <span class="price"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['user_info']['money'],
  'p' => '2',
);
echo $k['name']($k['v'],$k['p']);
?></span> 元</div>
			<div class="blank"></div>
			<div class="incharge_tip">充值到<?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'SITE_NAME',
);
echo $k['name']($k['v']);
?>，方便支持项目！
			 <a href="<?php
echo parse_url_tag("u:account#incharge|"."".""); 
?>">立即充值</a>&nbsp;
			 <?php if ($this->_var['user_info']['money'] > 0): ?>
			 <a href="<?php
echo parse_url_tag("u:account#refund|"."".""); 
?>">我要提现</a>
			 <?php endif; ?>
			</div>
</div>
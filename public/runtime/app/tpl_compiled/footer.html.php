<div id="gotop"></div>
<div class="blank"></div>
<div class="footer">
	<div class="wrap">
		<div class="help_row">
			<a href="<?php
echo parse_url_tag("u:faq|"."".""); 
?>" title="常见问题">常见问题</a>
			<?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help');if (count($_from)):
    foreach ($_from AS $this->_var['help']):
?>
			 &nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $this->_var['help']['url']; ?>" title="<?php echo $this->_var['help']['title']; ?>"><?php echo $this->_var['help']['title']; ?></a>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
		<div class="license">
			<?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'SITE_LICENSE',
);
echo $k['name']($k['v']);
?>
		</div>
	</div>
</div>

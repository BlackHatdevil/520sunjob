<?php if ($this->_var['user_info']): ?>
	<a href="#" id="mymessage">消息</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="#" id="mycenter"><?php echo $this->_var['user_info']['user_name']; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;		
	<a href="<?php
echo parse_url_tag("u:user#loginout|"."".""); 
?>" title="登出" id="user_login_out">登出</a>
	
	<?php if ($this->_var['USER_NOTIFY_COUNT'] > 0 || $this->_var['USER_MESSAGE_COUNT'] > 0): ?>
	<?php if ($this->_var['HIDE_USER_NOTIFY'] == 0): ?>
	<div id="user_notify_tip" style="position:absolute; z-index:1; display:none;">		
		<div class="notify_tip_box" id="close_user_notify">
			<div class="close_user_notify"></div>
			<?php if ($this->_var['USER_NOTIFY_COUNT'] > 0): ?>
			<span><a href="<?php
echo parse_url_tag("u:notify|"."".""); 
?>">您有 <font><?php echo $this->_var['USER_NOTIFY_COUNT']; ?></font> 条新通知</a></span>
			<?php endif; ?>
			<?php if ($this->_var['USER_MESSAGE_COUNT'] > 0): ?>
			<span><a href="<?php
echo parse_url_tag("u:message|"."".""); 
?>">您有 <font><?php echo $this->_var['USER_MESSAGE_COUNT']; ?></font> 条新信息</a></span>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>

	<div id="mymessage_drop" style="position:absolute; display:none;">
		<div class="drop_box">
			<span><a href="<?php
echo parse_url_tag("u:news#fav|"."".""); 
?>">关注动态</a></span>
			<span><a href="<?php
echo parse_url_tag("u:comment|"."".""); 
?>">查看评论</a></span>
			<span><a href="<?php
echo parse_url_tag("u:message|"."".""); 
?>">查看私信</a></span>
			<span><a href="<?php
echo parse_url_tag("u:notify|"."".""); 
?>">查看通知</a></span>

		</div>
	</div>
	<div id="mycenter_drop" style="position:absolute; display:none;">
		<div class="drop_box">
			<span><a href="<?php
echo parse_url_tag("u:home|"."id=".$this->_var['user_info']['id']."".""); 
?>">我的主页</a></span>
			<span><a href="<?php
echo parse_url_tag("u:account|"."".""); 
?>">工作管理</a></span>
			<span><a href="<?php
echo parse_url_tag("u:settings|"."".""); 
?>">会员资料</a></span>

		</div>
	</div>
	
<?php else: ?>
	<a href="<?php
echo parse_url_tag("u:user#login|"."".""); 
?>" title="登录">企业登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;	
	<a href="<?php
echo parse_url_tag("u:user#register|"."".""); 
?>" title="注册">企业注册</a>&nbsp;&nbsp;			
    <!--
	<span class="api_login_tip" id="api_login_tip">使用其他帐号登录</span>
    -->
	
	<div id="api_login_tip_drop" style="position:absolute; display:none;">
		<div class="api_drop_box">
			<?php echo $this->_var['api_login']; ?>
		</div>
	</div>
<?php endif; ?>

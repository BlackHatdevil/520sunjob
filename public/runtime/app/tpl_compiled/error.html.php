<?php echo $this->fetch('inc/header.html'); ?> 
<?php if ($this->_var['stay'] == 0): ?>
<meta http-equiv="refresh" content="3;URL=<?php echo $this->_var['jump']; ?>" />
<?php endif; ?>
<div class="shadow_bg">
	<div class="wrap white_box"">
	
		<div class="page_title">
			错误
		</div>
		<div class="switch_nav" style="height:1px;"></div>				
					

							<div class="full msgbox">
								<p>
								<?php if ($this->_var['integrate_result']): ?>
								<?php echo $this->_var['integrate_result']; ?>
								<?php endif; ?>
								<?php echo $this->_var['msg']; ?>	
								</p>
								<div class="blank"></div>
								<?php if ($this->_var['stay'] == 0): ?>
								<div class="return_jump">								
									请点击此处直接 [<a href="<?php echo $this->_var['jump']; ?>">返回</a>] 或者等待三秒钟后自动跳转。		
								</div>
								<?php endif; ?>
							</div>


	</div>
</div>
					
<div class="blank"></div>
<?php echo $this->fetch('inc/footer.html'); ?> 
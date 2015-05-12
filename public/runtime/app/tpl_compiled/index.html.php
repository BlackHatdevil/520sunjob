<?php echo $this->fetch('inc/header.html'); ?> 
<?php
$this->_var['dpagecss'][] = $this->_var['TMPL_REAL']."/css/index.css";
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/index.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/index.js";
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/discover.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/discover.js";
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

<?php echo $this->fetch('inc/index_images.html'); ?>
<div class="blank"></div>

<div class="wrap">
    <div class="f_r">
        <form action="<?php
echo parse_url_tag("u:deals|"."".""); 
?>" method="post" id="header_search_form">
            <div class="header_seach tc">	
                <input type="button" value="搜索" class="seach_submit" id="header_submit" />
                <input type="text" id="header_keyword" name="k" value="<?php if ($this->_var['p_k'] != ''): ?><?php echo $this->_var['p_k']; ?><?php else: ?>搜索你想要的...<?php endif; ?>" class="seach_text">	
                <input type="hidden" name="redirect" value="1" />				
            </div>
        </form>	
    </div>

    <div class="blank"></div>
    <div class="blank"></div>
    <div class="blank"></div>
    <div class="blank"></div>
    <h2 class="index_titles">
        <a target="_blank" href="<?php
echo parse_url_tag("u:deals#show|"."".""); 
?>" class="titles_name">推荐兼职</a>
        <a target="_blank" href="<?php
echo parse_url_tag("u:deals#show|"."".""); 
?>" class="more f_r">
            <img src="<?php echo $this->_var['TMPL']; ?>/images/zxzx1.jpg" alt="兼职">
        </a>
    </h2>
    <div id="pin_box">
        <div class="tc">
            <ul class="tab-nav tc">
                <?php $_from = $this->_var['cate_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate_item');if (count($_from)):
    foreach ($_from AS $this->_var['cate_item']):
?>
                <li><a href="<?php
echo parse_url_tag("u:deals|"."id=".$this->_var['cate_item']['id']."".""); 
?>" title="<?php echo $this->_var['cate_item']['name']; ?>"><?php echo $this->_var['cate_item']['name']; ?></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <div class="blank"></div>
        <?php echo $this->fetch('inc/deal_list.html'); ?>
        <div class="blank"></div>
        <div class="blank"></div>
        <div class="blank"></div>
        <div class="blank"></div>
    </div>	
    <div class="blank"></div>
    <div id="pin_loading" rel="<?php
echo parse_url_tag("u:ajax#index|"."p=".$this->_var['current_page']."".""); 
?>">正在努力加载</div>	

</div>
<?php echo $this->fetch('inc/footer.html'); ?> 

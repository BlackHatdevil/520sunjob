<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="Generator" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php if ($this->_var['page_title'] != ''): ?><?php echo $this->_var['page_title']; ?> - <?php endif; ?><?php echo $this->_var['site_name']; ?> - <?php echo $this->_var['seo_title']; ?>-</title>
        <meta name="keywords" content="<?php echo $this->_var['seo_keyword']; ?>" />
        <meta name="description" content="<?php echo $this->_var['seo_description']; ?>" />
        <?php
        $this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/style.css";
        $this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/weebox.css";
        $this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/jquery-1.8.2.min.js";
        $this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/jquery.bgiframe.js";
        $this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/jquery.weebox.js";
        $this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/jquery.pngfix.js";
        $this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/lazyload.js";
        $this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/script.js";
        $this->_var['cpagejs'][] = $this->_var['TMPL_REAL']."/js/script.js";
        if(app_conf("APP_MSG_SENDER_OPEN")==1)
        {
        $this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/msg_sender.js";
        $this->_var['cpagejs'][] = $this->_var['TMPL_REAL']."/js/msg_sender.js";
        }
        if(HAS_DEAL_NOTIFY>0)
        {
        $this->_var['notifypagejs'][] = $this->_var['TMPL_REAL']."/js/notify_sender.js";
        $this->_var['cnotifypagejs'][] = $this->_var['TMPL_REAL']."/js/notify_sender.js";	
        }
        ?>
        <link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['pagecss'],
);
echo $k['name']($k['v']);
?>" />
        <script type="text/javascript">
            var APP_ROOT = '<?php echo $this->_var['APP_ROOT']; ?>';
            var LOADER_IMG = '<?php echo $this->_var['TMPL']; ?>/images/lazy_loading.gif';
            var ERROR_IMG = '<?php echo $this->_var['TMPL']; ?>/images/image_err.gif';
<?php if (app_conf ( "APP_MSG_SENDER_OPEN" ) == 1): ?>
var send_span = <?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'SEND_SPAN',
);
echo $k['name']($k['v']);
?>000;
<?php endif; ?>
        </script>
        <script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['pagejs'],
  'c' => $this->_var['cpagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
        <?php if (HAS_DEAL_NOTIFY > 0): ?>
        <script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['notifypagejs'],
  'c' => $this->_var['cnotifypagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
        <?php endif; ?>

    </head>

    <body>	
        <div class="header">
            <div class="login_tip">	
                <a href="<?php
echo parse_url_tag("u:index|"."".""); 
?>" class="version f_l">网站版本号：企业版[1.0]</a>
                <?php 
$k = array (
  'name' => 'login_tip',
);
echo $this->_hash . $k['name'] . '|' . base64_encode(serialize($k)) . $this->_hash;
?>
            </div>			

            <!--logo-->
            <div class="blank"></div>
            <div class="logo">
                <a class="link" href="<?php echo $this->_var['APP_ROOT']; ?>/">
                    <?php
                    $this->_var['logo_image'] = app_conf("SITE_LOGO");
                    ?>
                    <?php 
$k = array (
  'name' => 'load_page_png',
  'v' => $this->_var['logo_image'],
);
echo $k['name']($k['v']);
?>
                </a>
                <a href="" class="anounce">
                    <?php
                    $this->_var['anounce_image'] = app_conf("SITE_ANOUNCE");
                    ?>
                    <?php 
$k = array (
  'name' => 'load_page_png',
  'v' => $this->_var['anounce_image'],
);
echo $k['name']($k['v']);
?>
                </a>
            </div>

            <!--导航栏-->
            <div class="blank"></div>
            <ul class="main_nav">
                <div class="wrap">
                    <?php $_from = $this->_var['nav_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav_item');if (count($_from)):
    foreach ($_from AS $this->_var['nav_item']):
?>
                    <li <?php if ($this->_var['nav_item']['current'] == 1): ?>class="current"<?php endif; ?>>
                    <span>
                        <a href="<?php echo $this->_var['nav_item']['url']; ?>"  target="<?php if ($this->_var['nav_item']['blank'] == 1): ?>_blank<?php endif; ?>" title="<?php echo $this->_var['nav_item']['name']; ?>"><?php echo $this->_var['nav_item']['name']; ?></a>	
                    </span>		
                    </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
            </ul>
        </div>


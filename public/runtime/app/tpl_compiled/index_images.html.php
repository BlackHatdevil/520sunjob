<div id="index_images" class="index_images">		
    <div class="roll_box">
        <?php $_from = $this->_var['image_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'image_item');if (count($_from)):
    foreach ($_from AS $this->_var['image_item']):
?>
        <a href="<?php echo $this->_var['image_item']['url']; ?>" title="<?php echo $this->_var['image_item']['title']; ?>">
            <img src="<?php 
$k = array (
  'name' => 'get_spec_image',
  'v' => $this->_var['image_item']['image'],
  'w' => '1280',
  'h' => '300',
  'g' => '1',
);
echo $k['name']($k['v'],$k['w'],$k['h'],$k['g']);
?>"  alt="<?php echo $this->_var['image_item']['title']; ?>" />
        </a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>			
</div>

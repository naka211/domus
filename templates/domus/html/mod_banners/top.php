<?php
defined('_JEXEC') or die;
$baseurl = JUri::base();
$i = 0;
?>
<?php foreach ($list as $item){
	$imageurl = $item->params->get('imageurl');
?>
<?php $alt = $item->params->get('alt');?>
<?php $alt = $alt ? $alt : $item->name; ?>
<?php $alt = $alt ? $alt : JText::_('MOD_BANNERS_BANNER'); ?>
<div class="<?php if($i==0) echo 'active';?> item">
	<img src="<?php echo $baseurl . $imageurl;?>" alt="<?php echo $alt;?>">
</div>
<?php $i++;}?>

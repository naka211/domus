<?php
defined('_JEXEC') or die;
$baseurl = JUri::base();
$i = 0;
?>
<?php foreach ($list as $item){
	$imageurl = $item->params->get('imageurl');
?>

<div class="<?php if($i==0) echo 'active';?> item">
	<div class="col-md-5 img-left">
		<img class="img-responsive" src="<?php echo $baseurl . $imageurl;?>" alt="">
	</div>
	<div class="col-md-7">
		<h3><?php echo $item->params->get('alt');?></h3>
		<p><?php echo $item->description;?></p>
	</div>
</div>
<?php $i++;}?>

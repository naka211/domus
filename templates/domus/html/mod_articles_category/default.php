<?php
defined('_JEXEC') or die;
?>
<?php foreach ($list as $item){
	$image = json_decode($item->images);
?>
<div class="col-md-4 col-sm-6 list-tours-item">
	<a href="<?php echo $item->link; ?>">
		<div class="img-tour">
			<img class="img-responsive" src="<?php echo $image->image_intro;?>" alt="">
		</div>
		<h2><?php echo $item->title; ?></h2>
	</a>
	<?php echo $item->introtext; ?>
</div>
<?php }?>
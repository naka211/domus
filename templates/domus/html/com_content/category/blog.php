<?php
defined('_JEXEC') or die;
?>
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content content-article clearfix">  
			<div class="row">
				<div class="col-sm-12">
					<div class="top-description">
						<img src="<?php echo $this->category->params->get('image');?>">
						<div class="txt-desc">
							<h2><?php echo $this->category->title;?></h2>
							<?php echo $this->category->description;?>
						</div>
					</div> 
				</div> 
			</div> <!-- row --> 
			<div class="row">
				<div class="col-sm-12 list-article">
					<?php foreach ($this->intro_items as $key => &$item){
					$image = json_decode($item->images);?>
					<div class="each_article">
						<h4><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)); ?>"><?php echo $item->title;?></a></h4> 
						<a href="text.php" class="thumbnail_article"><img  src="<?php echo $image->image_intro;?>" alt="<?php echo $item->title;?>"></a>
						<?php echo $item->introtext;?>
						<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)); ?>" class="see_more">Se mere</a>
					</div><!-- each_article --> 
					<?php }?>
				</div><!-- list-article -->
			</div><!-- row -->
		</div><!--main-content -->
	</div><!--container-->
</section>
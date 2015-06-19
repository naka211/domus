<?php
defined('_JEXEC') or die;
?>
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content content-article clearfix">  
				<div class="row">
					<div class="col-sm-12">
						<h4><?php echo $this->escape($this->item->title); ?></h4> 
						<?php echo $this->item->text; ?>
					</div> 
				</div> <!-- row --> 
		</div><!--main-content -->
	</div><!--container-->
</section>
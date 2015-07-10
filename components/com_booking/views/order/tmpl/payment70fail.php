<?php
// no direct access
defined('_JEXEC') or die;
$order_id = JRequest::getVar('order_id');

$db = JFactory::getDBO();
$db->setQuery("SELECT first_name, last_name FROM #__booking WHERE id = ".$order_id);
$info = $db->loadObject();

?>
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content content-article clearfix">  
				<div class="row">
					<div class="col-sm-12">
						<h4>Payment fail</h4> 
						Dear, <?php echo $info->first_name.' '.$info->last_name;?><br><br>
						
						Order <?php echo sprintf('%05d',$order_id);?> isn't paid 30% yet.

						Yours sincerely,<br>
						The DomusHolidays Team
					</div> 
				</div> <!-- row --> 
		</div><!--main-content -->
	</div><!--container-->
</section>

<?php
// no direct access
defined('_JEXEC') or die;
$order_id = JRequest::getVar('order_id');

$db = JFactory::getDBO();
$db->setQuery("SELECT * FROM #__booking WHERE id = ".$order_id);
$info = $db->loadObject();

$house = simplexml_load_string($info->information);

$number_of_days_time = $info->checkout - $info->checkin;
$number_of_days = floor($number_of_days_time/(60*60*24));
?>
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content content-article clearfix">  
				<div class="row">
					<div class="col-sm-12">
						<h4>Paid successfully</h4>
						Dear, <?php echo $info->first_name.' '.$info->last_name;?><br><br>
						You paid successfully 100% for order <?php echo sprintf('%05d',$order_id);?>.<br><br>
						
						<strong>Booking Summary:</strong><br>
						Booking Number: <?php echo sprintf('%05d',$order_id);?><br>
						House name: <?php echo $house->name;?><br>
						From: <?php echo date("d-m-Y", $info->checkin);?> for <?php echo $number_of_days;?> days<br>
						Number of people: <?php echo $info->number_of_persons;?><br>
						Total price: <?php echo number_format($info->total_da, 2, ',', '.');?> DKK<br><br>
						
						Yours sincerely,<br>
						The DomusHolidays Team
					</div> 
				</div> <!-- row --> 
		</div><!--main-content -->
	</div><!--container-->
</section>

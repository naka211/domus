<?php
// no direct access
defined('_JEXEC') or die;
$orderId = JRequest::getVar('orderid');
$db = JFactory::getDBO();
$q = "SELECT * FROM #__booking WHERE id = ".$orderId;
$db->setQuery($q);
$order = $db->loadObject();
?>
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content tak-content clearfix"> 
			<div class="row">
				<div class="col-md-12">  
					<h4>Tak for din booking!</h4> 
					<h2>Booking-nr. <?php echo sprintf("%05d", $orderId);?></h2>
					<h2><?php echo $order->house_id;?></h2>
					<hr>
					<div class="customer_info">
						<div class="row">
							<div class="col-sm-12">
								<h6>Kundeoplysninger</h6> 
								<div class="eachRow">
									<label>Ankomst dato:</label><p><?php echo date("d/m/Y", $order->checkin);?></p>
								</div>
								<div class="eachRow">
									<label> Udrejse dato:</label><p><?php echo date("d/m/Y", $order->checkout);?></p>
								</div>
								<div class="eachRow">
									<label> Antal Personer:</label><p><?php echo $order->number_of_persons;?></p>
								</div>
								<div class="eachRow">
									<label> Fornavn:</label><p><?php echo $order->first_name;?></p>
								</div>
								<div class="eachRow">
									<label> Efternavn:</label><p><?php echo $order->last_name;?></p>
								</div>
								<div class="eachRow">
									<label> Adresse:</label><p><?php echo $order->address;?></p>
								</div>
								<div class="eachRow">
									<label> Postnr:</label><p><?php echo $order->zip;?></p>
								</div>
								<div class="eachRow">
									<label> By:</label><p><?php echo $order->city;?></p>
								</div>
								<div class="eachRow">
									<label> E-mail:</label><p><?php echo $order->email;?></p>
								</div>
								<div class="eachRow">
									<label> Telefon:</label><p><?php echo $order->phone;?></p>
								</div>
								<div class="eachRow">
									<label> Besked:</label><p><?php echo $order->comment;?></p>
								</div>  
							</div><!-- col-sm-12 -->
						</div> 
					</div><!-- customer_info -->
					<div class="tak_footer">
						<h3><strong>Tak for din bestilling! Din bestilling vil blive behandlet inden for 24 timer</strong></h3>
						<br/>
						<p style="font-size: 14px;"><b>Domus Holidays ApS</b><br/>
						Idrætsvej 62<br/>
						DK-2650 Hvidovre<br/>
						CVR-nr. 37311774<br>
						<a href="mailto:info@domusholidays.com"> info@domusholidays.com</a><br>
						<a href="www.domusholidays.com">www.domusholidays.com</a></p>
					</div><!-- tak_footer -->
					<div class="wrap_btn"> 
						<a href="index.php" class="btn">TIL FORSIDE</a>
					</div>

				</div> 
			</div><!--row-->   
			 
		</div><!--main-content -->
	</div><!--container-->
</section>
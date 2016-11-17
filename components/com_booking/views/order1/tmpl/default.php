<?php
// no direct access
defined('_JEXEC') or die;
JHTML::_('behavior.formvalidator');
$tmpl = JURI::base().'templates/domus/';
$session = JFactory::getSession();
$all = $session->get('all');
?>
<script>
$(document).ready(function(){
	$('input').on('change invalid', function() {
		var textfield = $(this).get(0);
		textfield.setCustomValidity('');
		
		if (!textfield.validity.valid) {
		  textfield.setCustomValidity('Udfyld dette felt');  
		}
	});  
});
</script>
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content orderbooking-content clearfix"> 
			<div class="row">
				<div class="col-md-12">  
					<h4>Ordre booking</h4>
					<a class="link_back" href="javascript:history.back();"><i class="fa fa-angle-double-left"></i> Tilbage</a>
					<div class="infomations"> 
						<div class="row">
							<div class="col-sm-6">
								<h2><?php echo $all['house_name'];?></h2>
								<div class="each_box_info"><label><?php echo $all['data'];?></label></div>
								<div class="each_box_info">
									<div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price"> <?php echo number_format($all['amountda'], 2, ',', '.');?> DKK</span></p>
									</div>
								</div>
							</div> <!-- col-sm-6 --> 
							<div class="col-sm-6">
								<div class="each_box_info"> 
									<div class="each_row row_house_booking">  
										<div class="row">
											<div class="col-sm-5">
												 <label><i class="fa fa-calendar"></i><span>Check in: </span><span><?php echo $all['start_date'];?></span></label>
											</div>
											<div class="col-sm-5">
												 <label><i class="fa fa-calendar"></i><span>Check ud: </span><span><?php echo $all['end_date'];?></span></label>
											</div>
										</div>
									</div><!-- row_house_booking -->
								</div>	
													 		 
							</div><!-- col-sm-6 -->
						</div>
					</div><!-- infomations -->
					<div class="customer_info">
						<div class="row">
							<div class="col-sm-6">
								<h4>Kundeoplysninger</h4> 
								<form action="index.php" method="post" class="form-validate">
									<div class="row rowAntal">
										<div class="col-xs-3">
											<div class="form-group"> 
												<label>Antal personer:</label> 
											</div>
										</div>
										<div class="col-xs-9">
											<div class="form-group"> 
												<select class="form-control" name="person"> 
													<?php for($i=1; $i<=20; $i++){?>
												  	<option value="<?php echo $i;?>"><?php echo $i;?></option>
												  	<?php }?>
												</select>
											</div>
										</div> 
									</div>
									<div class="form-group"> 
										<input type="text" class="form-control required" placeholder="Fornavn *" name="first_name">
									</div>
									<div class="form-group"> 
										<input type="text" class="form-control required" placeholder="Efternavn *" name="last_name">
									</div>  
									<div class="form-group"> 
										<input type="text" class="form-control required" placeholder="Adresse *" name="address">
									</div>
									<div class="row rowBy">
										<div class="col-xs-3">
											<div class="form-group"> 
												<input type="text" class="form-control required" placeholder="Postnr. *" name="zip">
											</div>
										</div>
										<div class="col-xs-9">
											<div class="form-group"> 
												<input type="text" class="form-control required" placeholder="By *" name="city">
											</div>
										</div>
									</div> 
									<div class="form-group"> 
										<input type="text" class="form-control required" placeholder="E-mail *" name="email">
									</div>
									<div class="form-group"> 
										<input type="text" class="form-control required" placeholder="Telefon *" name="phone">
									</div>
									<div class="form-group"> 
										<textarea rows="6" class="form-control" placeholder="Besked" name="comment"></textarea>  
									</div>
									<p>Felter markeret med * skal udfyldes</p>
									<div class="checkbox checkboxNyhedsbrev">
										<label>
										  <input type="checkbox" name="newsletter"> Jeg tilmelder mig Domus Holidays Nyhedsbrev</a>
										</label>
									 </div>
									<div class="checkbox checkboxAccepterer">
										<label>
										  <input type="checkbox" class="required"> Jeg accepterer <a href="handelsbetingelser.php" target="_blank">handelsbetingelser</a>
										</label>
									 </div>
									 <input type="submit" class="validate btn" value="SEND FORESPØRGSEL" />
									 <input type="hidden" name="option" value="com_booking" />
									 <input type="hidden" name="task" value="order.save_order" />
									 <input type="hidden" name="supplier" value="2" />
									<!--<a href="tak.php" class="btn">SEND FORESPØRGSEL</a>-->
								</form> 
							</div>
						</div>
					</div><!-- customer_info -->
				</div> 
			</div><!--row-->   
			 
		</div><!--main-content -->
	</div><!--container-->
</section>

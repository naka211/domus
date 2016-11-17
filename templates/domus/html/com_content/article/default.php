<?php
defined('_JEXEC') or die;
if($this->item->catid == 9){
	JHtml::_('behavior.formvalidator');
?>
<style>
.invalid {
    border-color: red !important;
}
</style>
<script src="<?php echo JURI::base();?>templates/domus/js/jquery.nouislider.all.min.js"></script>	
<script>
	$(document).ready(function(){
		$(".box_customer_info").hide();
		$(".btnOrderNow").click(function(e) {
			e.preventDefault();
			$(".box_customer_info").slideToggle('slow');
		});   			

		$( "#txtStartDate" ).datepicker({ 
			minDate: '0', 
			beforeShow : function()
			{
				jQuery( this ).datepicker('option','maxDate', jQuery('#txtEndDate').val() );
			},
			altFormat: "dd/mm/yy", 
			dateFormat: 'dd/mm/yy'
			
		});

		$( "#txtEndDate" ).datepicker({
			minDate: '0', 
			beforeShow : function()
			{
				jQuery( this ).datepicker('option','minDate', jQuery('#txtStartDate').val() );
			} , 
			altFormat: "dd/mm/yy", 
			dateFormat: 'dd/mm/yy'
			
		});

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
		<div class="main-content content-article clearfix">  
			<div class="row">
				<div class="col-sm-12">
					<h4><?php echo $this->escape($this->item->title); ?></h4> 
					<?php echo $this->item->text; ?>
				</div> 
			</div> <!-- row --> 
			
			<div class="row mt30">
				<div class="col-lg-12 text-center">
					<a href="#" class="btn btn-info btn-lg btnOrderNow">BESTIL NU!</a>
				</div>
			</div>
			<div class="row box_customer_info">
				<div class="col-md-12">
					<div class="customer_info">
						<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
								<h4>Kundeoplysninger</h4> 
								<form action="index.php" method="post" class="form-validate">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-6">
												<label style="color: #888;" for="">Ankomst dato</label>
												<input id="txtStartDate" name="startDate" type="text" class="form-control i_date required" placeholder="<?php echo date("d/m/Y");?>">
											</div>
											<div class="col-xs-6">
												<label style="color: #888;" for="">Udrejse dato</label>
												<input id="txtEndDate" name="endDate" type="text" class="form-control i_date required" placeholder="<?php echo date("d/m/Y");?>">
											</div>
										</div>
									</div>
									<div class="row rowAntal">
										<div class="col-xs-3">
											<div class="form-group"> 
												<label> Antal personer:</label> 
											</div>
										</div>
										<div class="col-xs-9">
											<div class="form-group"> 
												<select class="form-control required" name="quantity"> 
													<?php for($i=1; $i<=20; $i++){?>
													<option value="<?php echo $i;?>"><?php echo $i;?></option>
													<?php }?>
												</select>
											</div>
										</div> 
									</div>
									<div class="form-group"> 
										<input type="text" name="firstName" class="form-control required" placeholder="Fornavn *">
									</div>
									<div class="form-group"> 
										<input type="text" name="lastName" class="form-control required" placeholder="Efternavn *">
									</div>  
									<div class="form-group"> 
										<input type="text" name="address" class="form-control required" placeholder="Adresse *">
									</div>
									<div class="row rowBy">
										<div class="col-xs-3">
											<div class="form-group"> 
												<input type="text" name="zip" class="form-control required" placeholder="Postnr. *" maxlength="4">
											</div>
										</div>
										<div class="col-xs-9">
											<div class="form-group"> 
												<input type="text" name="city" class="form-control required" placeholder="By *">
											</div>
										</div>
									</div> 
									<div class="form-group"> 
										<input type="text" name="email" class="form-control required validate-email" placeholder="E-mail *">
									</div>
									<div class="form-group"> 
										<input type="text" name="phone" class="form-control required" placeholder="Telefon *">
									</div>
									<div class="form-group"> 
										<textarea rows="6" name="comment" class="form-control" placeholder="Besked"></textarea>  
									</div>
									<p>Felter markeret med * skal udfyldes</p>
									<div class="checkbox checkboxNyhedsbrev">
										<label>
										  <input type="checkbox" name="newsletter" value="1"> Jeg tilmelder mig Domus Holidays Nyhedsbrev</a>
										</label>
									 </div>
									<div class="checkbox checkboxAccepterer">
										<label>
										  <input type="checkbox" id="term" class="required"> Jeg accepterer <a href="index.php?option=com_content&view=article&id=1&Itemid=132" target="_blank">handelsbetingelser</a>
										</label>
									 </div>
									 <button type="submit" class="btn text-uppercase">Bekræft bestilling</button>
									<input type="hidden" name="option" value="com_booking">
									<input type="hidden" name="controller" value="home">
									<input type="hidden" name="task" value="saveOrder">
									<input type="hidden" name="houseName" value="<?php echo $this->escape($this->item->title); ?>">
								</form>

							</div>
						</div>
					</div><!-- customer_info -->
				</div> 
			</div><!--row-->
		</div><!--main-content -->
	</div><!--container-->
</section>
<?php } else {?>
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
</section>s
<?php }?>
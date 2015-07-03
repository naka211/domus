<?php
// no direct access
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/domus/';
$session = JFactory::getSession();
$all = $session->get('all');
$detail = simplexml_load_string($all['data']);
//print_r($detail);exit;
?>
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
								<h2><?php echo $detail->name;?></h2>
								<div class="wrap-icon-star">
								<?php for($i=1; $i<=$detail->stars; $i++){?>
								<i class="fa fa-star"></i>
								<?php }?>
								</div>
								<div class="each_box_info"><label><?php echo $detail->town;?> - <?php echo $detail->zone;?></label></div>
								<div class="each_box_info">
									<div class="each_row"><label>Property type:</label><span><?php echo $detail->proptype;?></span></div>
									<div class="each_row"><label>Sleeps:</label><span><?php echo $detail->minsleeps;?></span></div>
									<div class="each_row"><label>Double bedrooms:</label><span><?php echo $detail->doublebedrooms;?></span></div>
									<div class="each_row"><label>Bathrooms:</label><span><?php echo $detail->bathrooms;?></span></div>
								</div>
								<div class="each_box_info">
									<div class="each_row row_equipment">
										<label>Equipment: </label>
										<ul>
											<?php foreach($detail->amenities->amenity as $amenity){
											if($amenity->categories->category->name == "Equipment"){
											?>
											<li><?php echo $amenity->name;?></li>
											<?php }}?>
										</ul>
									</div> 
								</div>
								<div class="each_box_info">
									<div class="each_row row_equipment">
										<label>Services:</label>
										<ul>
											<?php foreach($detail->amenities->amenity as $amenity){
											if($amenity->categories->category->name == "Services"){
											?>
											<li><?php echo $amenity->name;?></li>
											<?php }}?>
										</ul>
									</div>
								</div>
								<div class="each_box_info">
									<div class="each_row row_equipment">
										<label>Activities:</label>
										<ul>
											<?php foreach($detail->amenities->amenity as $amenity){
											if($amenity->categories->category->name == "Activities"){
											?>
											<li><?php echo $amenity->name.': '.$amenity->value.' '. $amenity->metrics;?></li>
											<?php }}?>
										</ul>
									</div>
								</div>
								<div class="each_box_info">
									<div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from <?php echo number_format($all['amounteu'], 0, '', '.');?> EUR/WEEK (fra <?php echo number_format($all['amountda'], 2, ',', '.');?> DKK/UGE)</span></p>
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
								<div class="each_box_info">
									<div class="each_row">
										<label>Included in the price</label>
										<ul>
											<?php foreach($detail->extracost->included->price as $item){?>
											<li><?php echo $item->description;?></li> 
											<?php }?>
										</ul>
									</div> 
								</div>
								<div class="each_box_info">	
									<div class="each_row">
										<label>Extra costs to be paid on the spot</label>
										<ul>
											<?php foreach($detail->extracost->extra->price as $item){
												$value = '';
												if($item->rules != 3){
													if($item->rules == 2){
														if($item->value != '0.00'){
															$value = ': '.$item->value.' '.$item->currency;
														}
													} else if($item->rules == 0){
														$value = ': Upon consumption';
													}
													
											?>
											<li><?php echo $item->description.$value;?></li> 
											<?php }}?>
										</ul>

									</div> 
								</div>
								<div class="each_box_info">	
									<div class="each_row">
										<label>Optional extra services on request </label>
										<ul>
											<?php foreach($detail->extracost->extra->price as $item){
												$value = '';
												if($item->rules == 3){
													if($item->value != '0.00'){
														$value = ': '.$item->value.' '.$item->currency;
													}
											?>
											<li><?php echo $item->description.$value;?></li> 
											<?php }}?>  
										</ul>
									</div> 
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
										<input type="text" class="form-control" placeholder="Fornavn *">
									</div>
									<div class="form-group"> 
										<input type="text" class="form-control" placeholder="Efternavn *">
									</div>  
									<div class="form-group"> 
										<input type="text" class="form-control" placeholder="Adresse *">
									</div>
									<div class="row rowBy">
										<div class="col-xs-3">
											<div class="form-group"> 
												<input type="text" class="form-control" placeholder="Postnr. *">
											</div>
										</div>
										<div class="col-xs-9">
											<div class="form-group"> 
												<input type="text" class="form-control" placeholder="By *">
											</div>
										</div>
									</div> 
									<div class="form-group"> 
										<input type="text" class="form-control" placeholder="E-mail *">
									</div>
									<div class="form-group"> 
										<input type="text" class="form-control" placeholder="Telefon *">
									</div>
									<div class="form-group"> 
										<textarea rows="6" class="form-control" placeholder="Besked *"></textarea>  
									</div>
									<p>Felter markeret med * skal udfyldes</p>
									<div class="checkbox checkboxNyhedsbrev">
										<label>
										  <input type="checkbox"> Jeg tilmelder mig Domus Holidays Nyhedsbrev</a>
										</label>
									 </div>
									<div class="checkbox checkboxAccepterer">
										<label>
										  <input type="checkbox"> Jeg accepterer <a href="handelsbetingelser.php" target="_blank">handelsbetingelser</a>
										</label>
									 </div> 
									<a href="tak.php" class="btn">SEND FORESPØRGSEL</a>
								</form> 
							</div>
						</div>
					</div><!-- customer_info -->
				</div> 
			</div><!--row-->   
			 
		</div><!--main-content -->
	</div><!--container-->
</section>

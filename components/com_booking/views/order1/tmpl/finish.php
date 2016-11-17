<?php
// no direct access
defined('_JEXEC') or die;

$db = JFactory::getDBO();
$db->setQuery("SELECT * FROM #__booking WHERE id = ".JRequest::getVar('order_id'));
$info = $db->loadObject();

$detail = simplexml_load_string($info->information);
//print_r($detail);exit;
?>
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content tak-content clearfix"> 
			<div class="row">
				<div class="col-md-12">  
					<h4>Tak for din ordre</h4> 
					<p>Ordrenummer: <span><?php echo sprintf('%05d',$info->id);?></span><br/>
					En ordrebekræftelse vil blive sendt til <span><?php echo $info->email;?></span><br/>
					Har du spørgsmål, kan du kontakte os på +45 4162 8001 
					</p>
					<div class="infomations"> 
						<div class="row">
							 <div class="col-sm-12">
								<h2><?php echo $detail->name;?></h2>
								<div class="each_box_info"><label><?php echo $detail->town;?> - <?php echo $detail->zone;?></label></div>
								<div class="each_box_info">
									<div class="each_row"><label>Property type:</label><span><?php echo $detail->proptype;?></span></div>
									<div class="each_row"><label>Sleeps:</label><span><?php echo $detail->minsleeps;?></span></div>
									<div class="each_row"><label>Double bedrooms:</label><span><?php echo $detail->doublebedrooms;?></span></div>
									<div class="each_row"><label>Bathrooms:</label><span><?php echo $detail->bathrooms;?></span></div>
								</div>
								<div class="each_box_info"> 
									<div class="each_row row_house_booking">  
										<div class="row">
											<div class="col-sm-3">
												 <label><i class="fa fa-calendar"></i><span>Check in: </span><span><?php echo date('d-m-Y', $info->checkin);?></span></label>
											</div>
											<div class="col-sm-5">
												 <label><i class="fa fa-calendar"></i><span>Check ud: </span><span><?php echo date('d-m-Y', $info->checkout);?></span></label>
											</div>
										</div>
									</div><!-- row_house_booking -->
								</div>	
								<div class="each_box_info">
									<div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from <?php echo number_format((float)$info->total_eu, 0, '', '.');?> EUR/WEEK (fra <?php echo number_format((float)$info->total_da, 2, ',', '.');?> DKK/UGE)</span></p>
									</div>
								</div>
							 </div><!-- col-sm-12 -->
						</div>
					</div><!-- infomations -->
					<div class="customer_info">
						<div class="row">
							<div class="col-sm-12">
								<h6>Kundeoplysninger</h6> 
								<div class="eachRow">
									<label> Antal Personer:</label><p><?php echo $info->number_of_persons;?></p>
								</div>
								<div class="eachRow">
									<label> Fornavn:</label><p><?php echo $info->first_name;?></p>
								</div>
								<div class="eachRow">
									<label> Efternavn:</label><p><?php echo $info->last_name;?></p>
								</div>
								<div class="eachRow">
									<label> Adresse:</label><p><?php echo $info->address;?></p>
								</div>
								<div class="eachRow">
									<label> Postnr:</label><p><?php echo $info->zip;?></p>
								</div>
								<div class="eachRow">
									<label> By:</label><p><?php echo $info->city;?></p>
								</div>
								<div class="eachRow">
									<label> E-mail:</label><p><?php echo $info->email;?></p>
								</div>
								<div class="eachRow">
									<label> Telefon:</label><p><?php echo $info->phone;?></p>
								</div>
								<div class="eachRow">
									<label> Besked:</label><p><?php echo $info->comment;?></p>
								</div>  
							</div><!-- col-sm-12 -->
						</div> 
					</div><!-- customer_info -->
					<div class="tak_footer"> 
						<p>Vi vender hurtigt tilbage med endelig bekræftelse (inden for 48 timer), samt et link til betalingen</p>
						<br/>
						<p><b>Domus Holiday ApS</b><br/>
						 Idrætsvej 62<br/>
						 DK-2650 Hvidovre<br/>
						 Email: <a href="mailto:info@domusholidays.com"> info@domusholidays.com</a></p> 
					</div><!-- tak_footer -->
					<div class="wrap_btn"> 
						<a href="<?php echo JURI::base();?>" class="btn">TIL FORSIDE</a>
					</div>

				</div> 
			</div><!--row-->   
			 
		</div><!--main-content -->
	</div><!--container-->
</section>

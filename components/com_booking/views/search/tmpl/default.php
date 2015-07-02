<?php
// no direct access
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/domus/';
$params = json_decode($this->category->params);
$zones = simplexml_load_file('https://www.vacavilla.com/en/webservices/v1/service/searchformhelper/helperservice/zones_in_country/country/ITA/depth/1/api.xml');

if(JRequest::getVar('zone')){
	$subzones = simplexml_load_file('https://www.vacavilla.com/webservices/v1/service/searchformhelper/helperservice/subzones_in_zone/zone/'.JRequest::getVar('zone').'/depth/1/api.xml');
	if(JRequest::getVar('subzone')){
		$towns = simplexml_load_file('https://www.vacavilla.com/webservices/v1/service/searchformhelper/helperservice/towns_in_zone/zone/'.JRequest::getVar('subzone').'/api.xml');
	} else {
		$towns = simplexml_load_file('https://www.vacavilla.com/webservices/v1/service/searchformhelper/helperservice/towns_in_zone/zone/'.JRequest::getVar('zone').'/api.xml');
	}
}

if(JRequest::getVar('end_date')){
	$start_tmp = explode("-", JRequest::getVar('start_date'));
	$start_time = mktime(0, 0, 0, $start_tmp[1], $start_tmp[0], $start_tmp[2]);
	$end_tmp = explode("-", JRequest::getVar('end_date'));
	$end_time = mktime(0, 0, 0, $end_tmp[1], $end_tmp[0], $end_tmp[2]);
	
	$number_of_days_time = $end_time - $start_time;
	$number_of_days = floor($number_of_days_time/(60*60*24));
	
	$time_text = "from/".$start_tmp[0]."/".$start_tmp[1]."/".$start_tmp[2]."/nights/".$number_of_days."/";
}

$db = JFactory::getDBO();
$db->setQuery("SELECT value FROM #__settings WHERE id = 11");
$limit = $db->loadResult();
$db->setQuery("SELECT value FROM #__settings WHERE id = 10");
$rate = $db->loadResult();

if(JRequest::getVar('start')){
	$limit_text = "start/".JRequest::getVar('start')."/items/".$limit."/";
	$start_view = JRequest::getVar('start');
} else {
	$limit_text = "start/0/items/".$limit."/";
	$start_view = 1;
}

if(JRequest::getVar('zone')){
	if(JRequest::getVar('subzone')){
		if(JRequest::getVar('town')){
			$zone_text = "town/".JRequest::getVar('town')."/";
		} else {
			$zone_text = "zone/".JRequest::getVar('subzone')."/";
		}
	} else {
		$zone_text = "zone/".JRequest::getVar('zone')."/";
	}
	
} else {
	$zone_text = "";
}

$link = "https://www.vacavilla.com/webservices/v1/service/searchhouses/".$limit_text."/country/ITA/".$zone_text.$time_text."/data/description:1,pictures:1,prices:1/api.xml";
$houses = simplexml_load_file($link);
?>
<script src="<?php echo $tmpl;?>js/jquery.nouislider.all.min.js"></script> 
<script language="javascript">
$(document).ready(function(){
	$("#zone").change(function(e) {
		var zone = $("#zone").val();
		$("#subzone").attr("disabled","disabled");
		$('#subzone option[value!="0"]').remove();
		
		$("#town").attr("disabled","disabled");
		$('#town option[value!="0"]').remove();
		
		$.ajax({
			method: "POST",
			url: "<?php echo JURI::base();?>index.php?option=com_booking&task=home.getSubzone",
			data: { zone: zone }
		}).done(function( html ) {
			$("#subzone").append(html);
			$("#subzone").removeAttr("disabled");
		});
		
		$.ajax({
			method: "POST",
			url: "<?php echo JURI::base();?>index.php?option=com_booking&task=home.getTown",
			data: { subzone: zone }
		}).done(function( html ) {
			$("#town").append(html);
			$("#town").removeAttr("disabled");
		});
	});
	
	$("#subzone").change(function(e) {
		var subzone = $("#subzone").val();
		$("#town").attr("disabled","disabled");
		$('#town option[value!="0"]').remove();
		$.ajax({
			method: "POST",
			url: "<?php echo JURI::base();?>index.php?option=com_booking&task=home.getTown",
			data: { subzone: subzone }
		}).done(function( html ) {
			$("#town").append(html);
			$("#town").removeAttr("disabled");
		});
	});
	
	//Js for datepicker
	$( "#start_date" ).datepicker({
		"option"    :$.datepicker.regional[ "da" ],
		minDate: 0,
		onSelect: function(selected) {
		  	$( "#end_date" ).datepicker({
				"option"    :$.datepicker.regional[ "da" ],
				minDate: selected
			});
		}
	});
});
</script> 
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content clearfix"> 
			<div class="row">
				<div class="col-md-3 col-searchfilter"> 
					<div class="search-filter-left">
						<form action="index.php" method="get"> 
							<div class="each_wrapper wrap_option">
								<div class="option">
									<select class="form-control mb10" name="zone" id="zone">
										<option value="0">Any Region</option>
										<?php foreach($zones->zone as $item){?>
										<option value="<?php echo $item['code'];?>" <?php if($item['code'] == JRequest::getVar('zone')) echo 'selected';?>><?php echo $item->name;?></option>
										<?php }?>
									</select>
									<select class="form-control mb10" name="subzone" id="subzone">
										<option value="0">Any Town</option>
										<?php 
										if(JRequest::getVar('zone')){
										foreach($subzones->zone as $item){?>
										<option value="<?php echo $item['code'];?>" <?php if($item['code'] == JRequest::getVar('subzone')) echo 'selected';?>><?php echo $item->name;?></option>
										<?php }}?>
									</select>
								</div>
								<div class="option">
									<select class="form-control mb10" name="town" id="town">
										<option value="0">Any Area</option>
										<?php 
										if(JRequest::getVar('zone')){
										foreach($towns->town as $item){?>
										<option value="<?php echo $item;?>" <?php if($item == JRequest::getVar('town')) echo 'selected';?>><?php echo $item;?></option>
										<?php }}?>
									</select>
									<!--<select class="form-control" name="person">
										<option value="0">Person</option>
										<option value="Any" <?php if(JRequest::getVar('person')=='Any') echo 'selected';?>>Any</option>
										<?php for($i=2; $i<=30; $i++){?>
										<option value="<?php echo $i;?>" <?php if(JRequest::getVar('person')==$i) echo 'selected';?>><?php echo $i;?></option>
										<?php }?>
									</select>-->
								</div>
								<div class="option option_day">
									<input id="start_date" name="start_date" type="text" class="form-control date-input mb10" placeholder="Starting date" value="<?php echo JRequest::getVar('start_date');?>">
									<input id="end_date" name="end_date" type="text" class="form-control date-input" placeholder="Ending date" value="<?php echo JRequest::getVar('end_date');?>">
								</div>
							</div><!-- each_wrapper -->
							<?php /*?>
							<div class="each_wrapper wrap_checbox">
								<?php if($this->filters['apartment']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="apartment" value="1" <?php if(JRequest::getVar('apartment')) echo 'checked';?>> Apartment
									</label>
								</div>
								<?php }?>  
								<?php if($this->filters['independent_house']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="independent_house" value="1" <?php if(JRequest::getVar('independent_house')) echo 'checked';?>> Independent house
									</label>
								</div>
								<?php }?>
								<?php if($this->filters['villa']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="villa" value="1" <?php if(JRequest::getVar('villa')) echo 'checked';?>> Villa
									</label>
								</div>
								<?php }?>
								<?php if($this->filters['pet_allowed']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="pet_allowed" value="1" <?php if(JRequest::getVar('pet_allowed')) echo 'checked';?>> Pet allowed
									</label>
								</div>
								<?php }?>
								<?php if($this->filters['air_conditioning']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="air_conditioning" value="1" <?php if(JRequest::getVar('air_conditioning')) echo 'checked';?>> Air conditioning
									</label>
								</div>
								<?php }?>
								<?php if($this->filters['internet_access']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="internet_access" value="1" <?php if(JRequest::getVar('internet_access')) echo 'checked';?>> Internet access
									</label>
								</div>
								<?php }?>
								<?php if($this->filters['swimming_pool']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="swimming_pool" value="1" <?php if(JRequest::getVar('swimming_pool')) echo 'checked';?>> Swimming Pool
									</label>
								</div>
								<?php }?>
								<?php if($this->filters['golf_course']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="golf_course" value="1" <?php if(JRequest::getVar('golf_course')) echo 'checked';?>> Golf course
									</label>
								</div>
								<?php }?>
								<?php if($this->filters['tennis']){?>
								<div class="checkbox">
									<label>
									  <input type="checkbox" name="tennis" value="1" <?php if(JRequest::getVar('tennis')) echo 'checked';?>> Tennis
									</label>
								</div>
								<?php }?>
							</div> <!--  wrap_checbox -->         
							<script>  
							   $(function(){ 
								  $('#range-1').noUiSlider({
									 start: [ <?php echo JRequest::getVar('upper_value')?>, <?php echo JRequest::getVar('lower_value')?> ],
									 step: 500,
									 margin: 20,
									 connect: true,
									 direction: 'ltr',
									 orientation: 'horizontal',                                  
									 // Configure tapping, or make the selected range dragable.
									 behaviour: 'tap-drag',               
									 // Full number format support.
									 format: wNumb({
										mark: '',
										decimals: 0
									 }),                              
									 // Support for non-linear ranges by adding intervals.
									 range: {
										'min': 0,
										'max': 10000
									 }
								  }); 
								   // ruler
								   	$('#range-1').Link('upper').to($('#lower_value'));
									$('#range-1').Link('lower').to($('#upper_value'));
									
									$('#range-1').Link('upper').to($('.lb_max'), 'html');
									$('#range-1').Link('lower').to($('.lb_min'), 'html');
									
									$('#range-1').noUiSlider_pips({
										mode: 'values',
										values: [1000,2000,3000,4000, 5000,6000,7000,8000,9000],
										density: 10
									});
					
							   }); 
							</script>
							<div class="each_wrapper wrap-filter-price">
								<p>Pris(€) <span>(samlet)</span></p>
								<div class="range_price"><span class="lb_min">0</span> <span class="lb_max">10000</span></div> 
								<div id="range-1"></div> 
							</div>
							<input id="lower_value" name="lower_value" type="hidden">
							<input id="upper_value" name="upper_value" type="hidden">
							<?php */?>
							<input type="submit" class="btn btnSearch" value="Search" />
							<input type="hidden" name="option" value="com_booking" />
							<input type="hidden" name="view" value="search" />
						</form>
					</div><!--search-filter-left-->
				</div><!--col-searchfilter-->

				<div class="col-md-9 col-main">
					<?php if($this->category){?>
					<div class="top-description">
						<a href="index.php?option=com_content&view=category&id=<?php echo $this->category->id;?>"><img src="<?php echo $params->image;?>"></a>
						<div class="txt-desc">
							<h2><a href="index.php?option=com_content&view=category&id=<?php echo $this->category->id;?>"> <?php echo $this->category->title;?></a></h2>
							<?php echo $this->category->description;?> <a href="index.php?option=com_content&view=category&id=<?php echo $this->category->id;?>">see_more</a></p>
						</div>
					</div><!-- top-description -->
					<?php }?>
					<!--<h1>6 Holiday homes in Tuscany, Florence</h1> -->  
					 
					<div class="row search-results-nav">
					   <!--<div class="col-sm-4 nav-sort">
							<span>Sort By </span>   
							<select class="form-control">
								<option>Relevancy</option>
								<option>Rating</option>
								<option>Price</option>
								<option>Sleeps</option> 
							</select> 
					   </div>-->
					   <div class="col-sm-5 nav-btn">
						  <span>Displaying <strong class="liststart"><?php echo $start_view;?></strong> - <strong class="listend"><?php echo $start_view - 1 + count($houses->property);?></strong></span>
						  <?php if(JRequest::getVar('start')){
							$query = $_GET;
							$query['start'] = JRequest::getVar('start') - $limit;
							$query_result = http_build_query($query); 
							?>
						  <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>" class="btn btn-xs btn-prev"><i class="fa fa-arrow-left"></i> Prev </a> 
						  <?php }?>
						  <?php if(count($houses->property) == $limit){
							$query = $_GET;
							$query['start'] = JRequest::getVar('start') + $limit;
							$query_result = http_build_query($query);  
							?>
						  <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>" class="btn btn-xs btn-next">Next <i class="fa fa-arrow-right"></i> </a>
						  <?php }?>
					   </div>
					   <!--<div class="col-sm-3 text-right">
						  <a href="#popupMap_larger" class="btn btn-xs fancybox search-results-on-map"> <i class="fa fa-map-marker"></i>View on map </a> 
					   </div>-->
					</div><!-- search-results-nav -->

					<div class="list-items">
						<?php $i = 0; 
							foreach($houses->property as $house){
								$link = "index.php?option=com_booking&view=detail&id=".$house['id'];
								$day_price = $house->prices->price[0]->value;
								foreach($house->prices->price as $price){
									if((int)$day_price > (int)$price->value){
										$day_price = $price->value;
									}
								}
								$week_price_eu = number_format($day_price * 7, 0, ',', '.');
								$week_price_da = number_format($day_price * 7 * $rate, 2, ',', '.');
								
						?>
						<div class="each-result-item">
							<h2><a href="<?php echo $link;?>"><?php echo $house->name;?></a></h2>
							<div class="row">
							   <div class="col-sm-4 col-img">
								  <a href="<?php echo $link;?>" class="loader" title=""><img src="<?php echo $house->pictures->mainpicture['path'];?>" alt="<?php echo $house->pictures->mainpicture->description;?>"></a>
							   </div>
							   <div class="col-sm-8 col-txt"> 
									 <div class="info-top"><span><strong>Area:</strong> </span><?php echo $house->town;?> - <?php echo $house->zone;?> <a class="fancybox view-map" href="#popupMap_min<?php echo $i;?>"> <i class="fa fa-map-marker"></i>View Map</a></div>
									 <div id="popupMap_min<?php echo $i;?>" style="display:none;">
										<div class="wrap_popupMap_min">
											<iframe width="578" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $house->latitute.','.$house->longitude;?>&amp;z=13&amp;output=embed"></iframe>
										</div><!-- wrap_popupMap -->
									</div><!-- popupMap -->
									 <div class="info-top">
									 	<span><strong>Property type:</strong> </span><?php echo $house->proptype;?><br />
										<span><strong>Sleeps:</strong> </span><?php echo $house->minsleeps;?><br />
										<span><strong>Double bedrooms:</strong> </span><?php echo $house->doublebedrooms;?><br />
										<span><strong>Bathrooms:</strong> </span><?php echo $house->bathrooms;?><br />
									 </div>
									 <div class="info-top" style="font-size:20px;">from <?php echo $week_price_eu;?> EUR/WEEK (<?php echo $week_price_da;?> DKK/UGE)</div>
									 <p class="description"><?php echo $house->descriptions->description;?> <a href="<?php echo $link;?>" class="see_more">Se mere</a></p>
							   </div>
							</div>
						</div><!-- each-result-item -->
						<?php $i++;}?>
						
					</div><!--list-items--> 

					<div class="row search-results-nav">
					   <!--<div class="col-sm-4 nav-sort">
							<span>Sort By </span>   
							<select class="form-control">
								<option>Relevancy</option>
								<option>Rating</option>
								<option>Price</option>
								<option>Sleeps</option> 
							</select>
					   </div>-->
					   <div class="col-sm-5 nav-btn">
						  	<span>Displaying <strong class="liststart"><?php echo $start_view;?></strong> - <strong class="listend"><?php echo $start_view - 1 + count($houses->property);?></strong></span>
							<?php if(JRequest::getVar('start')){
							$query = $_GET;
							$query['start'] = JRequest::getVar('start') - $limit;
							$query_result = http_build_query($query); 
							?>
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>" class="btn btn-xs btn-prev"><i class="fa fa-arrow-left"></i> Prev </a> 
							<?php }?>
							<?php if(count($houses->property) == $limit){
							$query = $_GET;
							$query['start'] = JRequest::getVar('start') + $limit;
							$query_result = http_build_query($query);  
							?>
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>" class="btn btn-xs btn-next">Next <i class="fa fa-arrow-right"></i> </a>
							<?php }?>
					   </div>
					   <!--<div class="col-sm-3 text-right">
						  <a href="#popupMap_larger" class="btn btn-xs fancybox search-results-on-map"> <i class="fa fa-map-marker"></i>View on map </a> 
					   </div>-->
					</div><!-- search-results-nav -->

				</div><!-- col-main -->

			</div><!--row-->
		</div><!--main-content -->
	</div><!--container-->
</section>
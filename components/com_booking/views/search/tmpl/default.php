<?php
// no direct access
defined('_JEXEC') or die;

$myurl = JURI::current(). "?" . $_SERVER['QUERY_STRING'];
$tmpl = JURI::base().'templates/domus/';
$arrContextOptions=array(
	"ssl"=>array(
		"verify_peer"=>false,
		"verify_peer_name"=>false,
	),
);

$zones = simplexml_load_string(file_get_contents('https://www.vacavilla.com/en/webservices/v1/service/searchformhelper/helperservice/zones_in_country/country/ITA/depth/1/api.xml', false, stream_context_create($arrContextOptions)));

if(JRequest::getVar('zone')){
	$subzones = simplexml_load_string(file_get_contents('https://www.vacavilla.com/webservices/v1/service/searchformhelper/helperservice/subzones_in_zone/zone/'.JRequest::getVar('zone').'/depth/1/api.xml', false, stream_context_create($arrContextOptions)));
	if(JRequest::getVar('subzone')){
		$towns = simplexml_load_string(file_get_contents('https://www.vacavilla.com/webservices/v1/service/searchformhelper/helperservice/towns_in_zone/zone/'.JRequest::getVar('subzone').'/api.xml', false, stream_context_create($arrContextOptions)));
	} else {
		$towns = simplexml_load_string(file_get_contents('https://www.vacavilla.com/webservices/v1/service/searchformhelper/helperservice/towns_in_zone/zone/'.JRequest::getVar('zone').'/api.xml', false, stream_context_create($arrContextOptions)));
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
} else {
	$time_text = '';
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

if(JRequest::getVar('town')){
	$zone_text = "town/".JRequest::getVar('town')."/";
} else {
	if(JRequest::getVar('zone')){
		if(JRequest::getVar('subzone')){
			$zone_text = "zone/".JRequest::getVar('subzone')."/";
		} else {
			$zone_text = "zone/".JRequest::getVar('zone')."/";
		}
	} else {
		$zone_text = "";
	}
}

if(JRequest::getVar('person')){
	$person_text = "sleeps/".JRequest::getVar('person')."/";
} else {
	$person_text = "";
}

$amenities = array();
$house_type = 0;
$params = array();
if(JRequest::getVar('apartment')){
	$params[] = "user_pluginsmanager_pi1[proptype]=6";
	$house_type = 1;
}
if(JRequest::getVar('independent_house')){
	$params[] = "user_pluginsmanager_pi1[proptype]=1";
	$house_type = 2;
}
if(JRequest::getVar('villa')){
	$params[] = "user_pluginsmanager_pi1[proptype]=449";
	$house_type = 3;
}
$min = JRequest::getVar('upper_value', 0);
$max = JRequest::getVar('lower_value', 10000);
$params[] = "user_pluginsmanager_pi1[price_range]=".$min."-".$max;
$params_text = implode("&", $params);

if(JRequest::getVar('pet_allowed')){
	$amenities[] = 21;
}
if(JRequest::getVar('air_conditioning')){
	$amenities[] = 4;
}
if(JRequest::getVar('internet_access')){
	$amenities[] = 44;
}
if(JRequest::getVar('swimming_pool')){
	$amenities[] = 67;
}
if(JRequest::getVar('golf_course')){
	$amenities[] = 16;
}
if(JRequest::getVar('tennis')){
	$amenities[] = 37;
}
if($amenities){
	$amenities_text = '';
	foreach($amenities as $amenity){
		$amenities_text .= "amenities:".$amenity.",";
	}
} else {
	$amenities_text = '';
}

$link = "https://www.vacavilla.com/webservices/v1/service/searchhouses/".$limit_text."country/ITA/".$person_text.$zone_text.$time_text."data/description:1,".$amenities_text."pictures:1,prices:1/api.xml?".$params_text;
$houses = simplexml_load_string(file_get_contents($link, false, stream_context_create($arrContextOptions)));


// GotoItaly
if(empty(JRequest::getVar('start'))){
	$params1 = array();
	if(JRequest::getVar('zone')){
		foreach($zones->zone as $item){
			if($item['code'] == JRequest::getVar('zone')){
				$zone_name = (string)$item->name;
				break;
			}
		}
		$params1[] = "zone=".rawurlencode($zone_name);
	}
	if(JRequest::getVar('subzone')){
		foreach($subzones->zone as $item){
			if($item['code'] == JRequest::getVar('subzone')){
				$subzone_name = (string)$item->name;
				break;
			}
		}
		$params1[] = "subzone=".rawurlencode($subzone_name);
	}
	if(JRequest::getVar('town')){
		$params1[] = "town=".rawurlencode(JRequest::getVar('town'));
	}
	if($house_type){
		$params1[] = "house_type=".$house_type;
	}
	if(JRequest::getVar('pet_allowed')){
		$params1[] = 'pet_allowed=1';
	}
	if(JRequest::getVar('air_conditioning')){
		$params1[] = 'air_conditioning=1';
	}
	if(JRequest::getVar('internet_access')){
		$params1[] = 'internet_access=1';
	}
	if(JRequest::getVar('swimming_pool')){
		$params1[] = 'swimming_pool=1';
	}
	$params1[] = 'min='.$min;
	$params1[] = 'max='.$max;
	$params1_text = implode('&', $params1);
	$gti_link = 'http://go-to-italy.dk/index.php?option=com_houses&task=house.getHouses&'.$params1_text;
	$italy_houses = file_get_contents($gti_link, false, stream_context_create($arrContextOptions));
	$italy_houses = json_decode($italy_houses);
}
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
	
	$(".btn_seemore").click(function() {
		$('.article_detail').slideToggle('slow');
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
									<select class="form-control" name="person">
										<option value="0">Person</option>
										<option value="Any" <?php if(JRequest::getVar('person')=='Any') echo 'selected';?>>Any</option>
										<?php for($i=2; $i<=30; $i++){?>
										<option value="<?php echo $i;?>" <?php if(JRequest::getVar('person')==$i) echo 'selected';?>><?php echo $i;?></option>
										<?php }?>
									</select>
								</div>
								<div class="option option_day">
									<input id="start_date" name="start_date" type="text" class="form-control date-input mb10" placeholder="Starting date" value="<?php echo JRequest::getVar('start_date');?>">
									<input id="end_date" name="end_date" type="text" class="form-control date-input" placeholder="Ending date" value="<?php echo JRequest::getVar('end_date');?>">
								</div>
							</div><!-- each_wrapper -->
							
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
									 start: [ <?php echo JRequest::getVar('upper_value', 0)?>, <?php echo JRequest::getVar('lower_value', 10000)?> ],
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
							<input type="submit" class="btn btnSearch" value="Search" />
							<input type="hidden" name="option" value="com_booking" />
							<input type="hidden" name="view" value="search" />
						</form>
					</div><!--search-filter-left-->
				</div><!--col-searchfilter-->

				<div class="col-md-9 col-main">
					<?php if($this->article){
						$images = json_decode($this->article->images);
					?>
					<div class="top-description">
						<a href="index.php?option=com_content&view=article&id=<?php echo $this->article->id.'-'.$this->article->alias;?>"><img src="<?php echo $images->image_intro;?>"></a>
						<div class="txt-desc">
							<h2><a href="index.php?option=com_content&view=article&id=<?php echo $this->article->id.'-'.$this->article->alias;?>"> <?php echo $this->article->title;?></a></h2>
							<?php echo $this->article->introtext;?> <a href="javascript:void(0);" class="btn_seemore">Læs mere.... <i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i></a></p>
						</div>
					</div><!-- top-description -->
					<div class="article_detail" style="display: none;">
						<?php echo $this->article->fulltext;?>
						<p class="text-center"><a href="javascript:void(0);" class="btn_seemore"><i aria-hidden="true" class="fa fa-angle-double-up fa-3x"></i></a></p>
					</div>
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
						  <?php 
						  $link = preg_replace("/&start=(.+)/", "", $myurl);
						  if(JRequest::getVar('start')){
							  $prev = JRequest::getVar('start') - $limit;
							  $prev_link = $link."&start=".$prev;
							?>
						  <a href="<?php echo $prev_link; ?>" class="btn btn-xs btn-prev"><i class="fa fa-arrow-left"></i> Prev </a> 
						  <?php }?>
						  <?php if(count($houses->property) == $limit){
							  $next = JRequest::getVar('start') + $limit;
							  $next_link = $link."&start=".$next;
							?>
						  <a href="<?php echo $next_link; ?>" class="btn btn-xs btn-next">Next <i class="fa fa-arrow-right"></i> </a>
						  <?php }?>
					   </div>
					   <!--<div class="col-sm-3 text-right">
						  <a href="#popupMap_larger" class="btn btn-xs fancybox search-results-on-map"> <i class="fa fa-map-marker"></i>View on map </a> 
					   </div>-->
					</div><!-- search-results-nav -->

					<div class="list-items">
						<?php if($italy_houses){
							foreach($italy_houses as $house){
								if(JRequest::getVar('zone')){
									$zone = "&zone=".JRequest::getVar('zone');
								} else {
									$zone = "";
								}
								$link = "index.php?option=com_booking&view=detail1&id=".$house->id.$zone;
								if($house->type == 1) $house_type = "Apartment";
								if($house->type == 2) $house_type = "Independent house ";
								if($house->type == 3) $house_type = "Villa";
						?>
						<div class="each-result-item">
							<h2><a href="<?php echo $link;?>"><?php echo $house->name;?></a></h2>
							<div class="row">
							   <div class="col-sm-12 col-img">
								  <a href="<?php echo $link;?>" class="loader" title=""><img src="<?php echo $house->image1;?>" alt="<?php echo strip_tags($house->description);?>" class="img_tuscany_detail"></a>
								 <div class="info-top"><span><strong>Area:</strong> </span><?php echo $house->town;?> - <?php echo $house->subzone;?> - <?php echo $house->zone;?> <a class="fancybox view-map" href="#popupMap1_min<?php echo $house->id;?>"> <i class="fa fa-map-marker"></i>View Map</a></div>
								 <div id="popupMap1_min<?php echo $house->id;?>" style="display:none;">
									<div class="wrap_popupMap_min">
										<iframe width="578" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $house->latitude.','.$house->longitude;?>&amp;z=13&amp;output=embed"></iframe>
									</div><!-- wrap_popupMap -->
								</div><!-- popupMap -->
								<div class="info-top">
									<span><strong>Property type:</strong> </span><?php echo $house_type;?><br />
								 </div>
								 <div class="info-top" style="font-size:20px; margin:5px 0;">from <?php echo $house->price*7;?> DKK/UGE</div>
								 <p class="description"><?php echo implode(' ', array_slice(explode(' ', $house->description), 0, 40));?>... <a href="<?php echo $link;?>" class="see_more">Se mere</a></p>
							   </div>
							</div>
						</div><!-- each-result-item -->
						<?php }
						}?>
						<?php $i = 0; 
							foreach($houses->property as $house){
								if(JRequest::getVar('zone')){
									$zone = "&zone=".JRequest::getVar('zone');
								} else {
									$zone = "";
								}
								$link = "index.php?option=com_booking&view=detail&id=".$house['id'].$zone;
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
							   <div class="col-sm-12 col-img">
								  <a href="<?php echo $link;?>" class="loader" title=""><img src="<?php echo $house->pictures->mainpicture['path'];?>" alt="<?php echo $house->pictures->mainpicture->description;?>" class="img_tuscany_detail"></a>
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
								 <div class="info-top" style="font-size:20px; margin:5px 0;">from <?php echo $week_price_eu;?> EUR/WEEK (<?php echo $week_price_da;?> DKK/UGE)</div>
								 <p class="description"><?php echo implode(' ', array_slice(explode(' ', $house->descriptions->description), 0, 40));?>... <a href="<?php echo $link;?>" class="see_more">Se mere</a></p>
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
						  <?php 
						  $link = preg_replace("/&start=(.+)/", "", $myurl);
						  if(JRequest::getVar('start')){
							  $prev = JRequest::getVar('start') - $limit;
							  $prev_link = $link."&start=".$prev;
							?>
						  <a href="<?php echo $prev_link; ?>" class="btn btn-xs btn-prev"><i class="fa fa-arrow-left"></i> Prev </a> 
						  <?php }?>
						  <?php if(count($houses->property) == $limit){
							  $next = JRequest::getVar('start') + $limit;
							  $next_link = $link."&start=".$next;
							?>
						  <a href="<?php echo $next_link; ?>" class="btn btn-xs btn-next">Next <i class="fa fa-arrow-right"></i> </a>
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
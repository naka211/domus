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
					<h1>6 Holiday homes in Tuscany, Florence</h1>   
					 
					<div class="row search-results-nav">
					   <div class="col-sm-4 nav-sort">
							<span>Sort By </span>   
							<select class="form-control">
								<option>Relevancy</option>
								<option>Rating</option>
								<option>Price</option>
								<option>Sleeps</option> 
							</select> 
					   </div>
					   <div class="col-sm-5 nav-btn">
						  <span>Displaying <strong class="liststart">21</strong> - <strong class="listend">40</strong></span>
						  <a href="#" class="btn btn-xs btn-prev"><i class="fa fa-arrow-left"></i> Prev </a> 
						  <a href="#" class="btn btn-xs btn-next">Next <i class="fa fa-arrow-right"></i> </a>
					   </div>
					   <div class="col-sm-3 text-right">
						  <a href="#popupMap_larger" class="btn btn-xs fancybox search-results-on-map"> <i class="fa fa-map-marker"></i>View on map </a> 
					   </div>
					</div><!-- search-results-nav -->

					<div class="list-items">
						<div class="each-result-item">
							<h2><a href="tuscany-detail.php"> Agriturismo Il Sole</a></h2>
							<div class="row">
							   <div class="col-sm-4 col-img">
								  <a href="tuscany-detail.php" class="loader" title=""><img src="<?php echo $tmpl;?>img/tuscany-02.jpg"></a>
							   </div>
							   <div class="col-sm-8 col-txt"> 
									 <div class="info-top"><span>Area: </span>Firenze - Florence - Tuscany <a class="fancybox view-map" href="#popupMap_min"> <i class="fa fa-map-marker"></i>View Map</a></div>
									 <p class="description">Lovely apartment of about 45 m2, recently restored, located on the mezzanine floor of a building a few steps from the famous La Fenice Theatre and just 5 minutes walk from Piazza San Marco, but at the same time immersed in the quietness of the streets of Venice. The house has a living room used as a bedroom, kitchenette and bathroom with shower. The decor in typically Venetian style, is very welcoming and warm. The living room has a double bed, wardrobe with 2 doors, round table for two and a plasma TV ... <a href="tuscany-detail.php" class="see_more">Se mere</a></p>
							   </div>
							</div>
							<ul class="list-result-item-footer">
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">Il Limone</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from <span class="price_line_through">1.743</span> 1.484 EUR/WEEK (fra 21.500 DKK/UGE)</span></p>
								   </div> 
								   <ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
								   </ul> 
								   <a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li> 
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">La Melagrana</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from 1.484,00 EUR/Week (fra 21.500 DKK/UGE)</span></p>
								   </div> 
								   <ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
								   </ul> 
								   <a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li> 
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">Il Sole</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from <span class="price_line_through">1.743</span> 1.484 EUR/WEEK (fra 21.500 DKK/UGE)</span></p>
								   </div> 
									<ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
									</ul> 
									<a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li>  
							</ul>
						</div><!-- each-result-item -->
						<div class="each-result-item">
							<h2><a href="tuscany-detail.php">Le Beringhe</a></h2>
							<div class="row">
							   <div class="col-sm-4 col-img">
								  <a href="tuscany-detail.php" class="loader" title=""><img src="<?php echo $tmpl;?>img/tuscany-02.jpg"></a>
							   </div>
							   <div class="col-sm-8 col-txt"> 
									 <div class="info-top"><span>Area: </span>Firenze - Florence - Tuscany <a class="fancybox view-map" href="#popupMap_min"> <i class="fa fa-map-marker"></i>View Map</a></div>
									 <p class="description">Lovely apartment of about 45 m2, recently restored, located on the mezzanine floor of a building a few steps from the famous La Fenice Theatre and just 5 minutes walk from Piazza San Marco, but at the same time immersed in the quietness of the streets of Venice. The house has a living room used as a bedroom, kitchenette and bathroom with shower. The decor in typically Venetian style, is very welcoming and warm. The living room has a double bed, wardrobe with 2 doors, round table for two and a plasma TV ... <a href="tuscany-detail.php" class="see_more">Se mere</a></p>
							   </div>
							</div>
							<ul class="list-result-item-footer">
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">Il Limone</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from <span class="price_line_through">1.743</span> 1.484 EUR/WEEK (fra 21.500 DKK/UGE)</span></p>
								   </div> 
								   <ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
								   </ul> 
								   <a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li>  
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">Il Sole</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from 1.484,00 EUR/Week (fra 21.500 DKK/UGE)</span></p>
								   </div> 
								   <ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
								   </ul> 
								   <a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li>  
							</ul>
						</div><!-- each-result-item --> 
						<div class="each-result-item">
							<h2><a href="tuscany-detail.php">Le Rocche</a></h2>
							<div class="row">
							   <div class="col-sm-4 col-img">
								  <a href="tuscany-detail.php" class="loader" title=""><img src="<?php echo $tmpl;?>img/tuscany-02.jpg"></a>
							   </div>
							   <div class="col-sm-8 col-txt"> 
									 <div class="info-top"><span>Area: </span>Firenze - Florence - Tuscany <a class="fancybox view-map" href="#popupMap_min"> <i class="fa fa-map-marker"></i>View Map</a></div>
									 <p class="description">Lovely apartment of about 45 m2, recently restored, located on the mezzanine floor of a building a few steps from the famous La Fenice Theatre and just 5 minutes walk from Piazza San Marco, but at the same time immersed in the quietness of the streets of Venice. The house has a living room used as a bedroom, kitchenette and bathroom with shower. The decor in typically Venetian style, is very welcoming and warm. The living room has a double bed, wardrobe with 2 doors, round table for two and a plasma TV ... <a href="tuscany-detail.php" class="see_more">Se mere</a></p>
							   </div>
							</div>
							<ul class="list-result-item-footer">   
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">Casalerocche Ginestra</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from 1.484,00 EUR/Week (fra 21.500 DKK/UGE)</span></p>
								   </div> 
								   <ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
								   </ul> 
								   <a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li>  
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">Casalerocche Mimosa</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from <span class="price_line_through">1.743</span> 1.484 EUR/WEEK (fra 21.500 DKK/UGE)</span></p>
								   </div> 
								   <ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
								   </ul> 
								   <a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li>
							</ul>
						</div><!-- each-result-item -->
						<div class="each-result-item">
							<h2><a href="tuscany-detail.php">Eden</a></h2>
							<div class="row">
							   <div class="col-sm-4 col-img">
								  <a href="tuscany-detail.php" class="loader" title=""><img src="<?php echo $tmpl;?>img/tuscany-02.jpg"></a>
							   </div>
							   <div class="col-sm-8 col-txt"> 
									 <div class="info-top"><span>Area: </span>Firenze - Florence - Tuscany <a class="fancybox view-map" href="#popupMap_min"> <i class="fa fa-map-marker"></i>View Map</a></div>
									 <p class="description">Lovely apartment of about 45 m2, recently restored, located on the mezzanine floor of a building a few steps from the famous La Fenice Theatre and just 5 minutes walk from Piazza San Marco, but at the same time immersed in the quietness of the streets of Venice. The house has a living room used as a bedroom, kitchenette and bathroom with shower. The decor in typically Venetian style, is very welcoming and warm. The living room has a double bed, wardrobe with 2 doors, round table for two and a plasma TV ... <a href="tuscany-detail.php" class="see_more">Se mere</a></p>
							   </div>
							</div>
							<ul class="list-result-item-footer">   
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">Eden</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from <span class="price_line_through">1.743</span> 1.484 EUR/WEEK (fra 21.500 DKK/UGE)</span></p>
								   </div> 
								   <ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
								   </ul> 
								   <a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li>  
							</ul>
						</div><!-- each-result-item --> 
						<div class="each-result-item">
							<h2><a href="tuscany-detail.php">Medici</a></h2>
							<div class="row">
							   <div class="col-sm-4 col-img">
								  <a href="tuscany-detail.php" class="loader" title=""><img src="<?php echo $tmpl;?>img/tuscany-02.jpg"></a>
							   </div>
							   <div class="col-sm-8 col-txt"> 
									 <div class="info-top"><span>Area: </span>Firenze - Florence - Tuscany <a class="fancybox view-map" href="#popupMap_min"> <i class="fa fa-map-marker"></i>View Map</a></div>
									 <p class="description">Lovely apartment of about 45 m2, recently restored, located on the mezzanine floor of a building a few steps from the famous La Fenice Theatre and just 5 minutes walk from Piazza San Marco, but at the same time immersed in the quietness of the streets of Venice. The house has a living room used as a bedroom, kitchenette and bathroom with shower. The decor in typically Venetian style, is very welcoming and warm. The living room has a double bed, wardrobe with 2 doors, round table for two and a plasma TV ... <a href="tuscany-detail.php" class="see_more">Se mere</a></p>
							   </div>
							</div>
							<ul class="list-result-item-footer">   
								<li class="result-item-footer">
								   <h3><a href="tuscany-detail.php">Medici</a></h3>
								   <div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								   <div class="header-meta">
									  <p><i class="fa fa-tag"></i><span class="price">from 1.484,00 EUR/Week (fra 21.500 DKK/UGE)</span></p>
								   </div> 
								   <ul class="list-unstyled clearfix">
									  <li><span>Property type: </span>Apartment</li>
									  <li><span>Sleeps: </span>2</li>
									  <li><span>Double bedrooms: </span>1</li>
									  <li><span>Bathrooms: </span>1</li>
									  <li><span>Featured pool: </span>Shared pool</li>
								   </ul> 
								   <a href="tuscany-detail.php" class="btn btn-xs">VÆLG</a>
								</li>  
							</ul>
						</div><!-- each-result-item -->  
					</div><!--list-items--> 

					<div class="row search-results-nav">
					   <div class="col-sm-4 nav-sort">
							<span>Sort By </span>   
							<select class="form-control">
								<option>Relevancy</option>
								<option>Rating</option>
								<option>Price</option>
								<option>Sleeps</option> 
							</select>
					   </div>
					   <div class="col-sm-5 nav-btn">
						  <span>Displaying <strong class="liststart">21</strong> - <strong class="listend">40</strong></span>
						  <a href="#" class="btn btn-xs btn-prev"><i class="fa fa-arrow-left"></i> Prev </a> 
						  <a href="#" class="btn btn-xs btn-next">Next <i class="fa fa-arrow-right"></i> </a>
					   </div>
					   <div class="col-sm-3 text-right">
						  <a href="#popupMap_larger" class="btn btn-xs fancybox search-results-on-map"> <i class="fa fa-map-marker"></i>View on map </a> 
					   </div>
					</div><!-- search-results-nav -->

				</div><!-- col-main -->

			</div><!--row-->
		</div><!--main-content -->
	</div><!--container-->
</section>
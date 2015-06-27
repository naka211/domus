<?php
// no direct access
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/domus/';
$params = json_decode($this->category->params);
?>
<script src="<?php echo $tmpl;?>js/jquery.nouislider.all.min.js"></script>  
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content clearfix"> 
			<div class="row">
				<div class="col-md-3 col-searchfilter"> 
					<div class="search-filter-left">
						<form> 
							<div class="each_wrapper wrap_option">
								<div class="option">
									<select class="form-control mb10">
										<option>Any Region</option>
										<option>Tuscany</option>
										<option>Veneto</option>
										<option>Amalfi Coast</option>
										<option>Sicily</option>
										<option>Umbria</option>
										<option>Lake Garda and Lake Maggiore</option>
										<option>Lombardy</option>
										<option>Sardinia</option>
										<option>Liguria</option>
										<option>Lazio</option>
										<option>Marche</option>
										<option>Piedmont</option>
									</select>
									<select class="form-control mb10">
										<option>Any Town</option>
										<option>Tuscany</option>
										<option>Veneto</option>
										<option>Amalfi Coast</option>
										<option>Sicily</option>
										<option>Umbria</option>
										<option>Lake Garda and Lake Maggiore</option>
										<option>Lombardy</option>
										<option>Sardinia</option>
										<option>Liguria</option>
										<option>Lazio</option>
										<option>Marche</option>
										<option>Piedmont</option>
									</select>
								</div>
								<div class="option">
									<select class="form-control mb10">
										<option>Any Area</option>
										<option>Tuscany</option>
										<option>Veneto</option>
										<option>Amalfi Coast</option>
										<option>Sicily</option>
										<option>Umbria</option>
										<option>Lake Garda and Lake Maggiore</option>
										<option>Lombardy</option>
										<option>Sardinia</option>
										<option>Liguria</option>
										<option>Lazio</option>
										<option>Marche</option>
										<option>Piedmont</option>
									</select>
									<select class="form-control">
										<option>Person</option>
										<option>Anny</option>
										<option>1</option>
										<option>2 Coast</option>
										<option>....</option>
									</select>
								</div>
								<div class="option option_day">
									<input type="text" class="form-control date-input mb10" placeholder="Starting date">
									<input type="text" class="form-control date-input" placeholder="Ending date">
								</div>
							</div><!-- each_wrapper -->
							<div class="each_wrapper wrap_checbox">  
								<div class="checkbox">
									<label><input type="checkbox"> Apartment</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox"> Independent house</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox"> Villa</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox"> Pet allowed</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox"> Air conditioning</label>
								</div>
								<div class="checkbox ">
									<label><input type="checkbox"> Internet access</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox"> Swimming Pool</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox"> Golf course</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox"> Tennis</label>
								</div> 
							</div> <!--  wrap_checbox -->         
							<script>  
							   $(function(){ 
								  $('#range-1').noUiSlider({
									 start: [ 0, 10000 ],
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
									$('#range-1').noUiSlider_pips({
										mode: 'values',
										values: [1000, ,2000,3000,4000, 5000,6000,7000,8000,9000],
										density: 10
									});
					
							   }); 
							</script>
							<div class="each_wrapper wrap-filter-price">
								<p>Pris <span>(samlet)</span></p>
								<div class="range_price"><span class="lb_min">€0</span> <span class="lb_max">€10000</span></div> 
								<div id="range-1"></div> 
							</div>
						</form>
					</div><!--search-filter-left-->
				</div><!--col-searchfilter-->

				<div class="col-md-9 col-main">
					<div class="top-description">
						<a href="index.php?option=com_content&view=category&id=<?php echo $this->category->id;?>"><img src="<?php echo $params->image;?>"></a>
						<div class="txt-desc">
							<h2><a href="index.php?option=com_content&view=category&id=<?php echo $this->category->id;?>"> <?php echo $this->category->title;?></a></h2>
							<?php echo $this->category->description;?> <a href="index.php?option=com_content&view=category&id=<?php echo $this->category->id;?>">see_more</a></p>
						</div>
					</div><!-- top-description -->
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
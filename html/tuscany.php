<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('head.php'); ?> 
	<?php require_once('js.php'); ?>

    <!--jQuery for Filter Price slider-->
    <script src="js/jquery.nouislider.all.min.js"></script>  

</head>

<body id="page-top" class="under">

    <?php require_once('nav.php'); ?> 

    <section class="content clearfix">
    	<div class="container pad0">
    		<div class="main-content clearfix"> 
    			<div class="row">
	    			<div class="col-md-3 col-searchfilter"> 
	    				<?php require ('box-form-search-filter.php'); ?>
					</div><!--col-searchfilter-->

					<div class="col-md-9 col-main">
						<div class="top-description">
							<a href="article.php"><img src="img/tuscany-desc.jpg"></a>
							<div class="txt-desc">
								<h2><a href="article.php"> Tuscany</a></h2>
								<p>Tuscany is one of the main central Italian regions. The chief town is Florence. The other province chief towns are:  Lucca, Pisa, Siena, Livorno, Grosseto, Massa-Carrara, Arezzo, Pistoia and Prato.</p>
								<p>Tuscany is one of the most interesting region from a tourist point of view and one of the main world ... <a href="article.php">see_more</a></p>
							</div>
						</div><!-- top-description -->
						<h1>6 Holiday homes in Tuscany, Florence</h1>   
						 
						<div id="ppSearch_filter" style="display:none">
							<?php require ('box-form-search-filter-2.php'); ?> 
						</div><!--ppSearch_filter-->

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
						      <a class="btn btn-xs hidden-md hidden-lg pull-right fancybox_search_filter" href="#ppSearch_filter"><i class="fa fa-search"></i></a>
						   </div>
						</div><!-- search-results-nav -->

						<div class="list-items">
							<div class="each-result-item">
								<h2><a href="tuscany-detail.php"> Agriturismo Il Sole</a></h2>
								<div class="row">
								   <div class="col-sm-4 col-img">
								      <a href="tuscany-detail.php" class="loader" title=""><img src="img/tuscany-02.jpg"></a>
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
								      <a href="tuscany-detail.php" class="loader" title=""><img src="img/tuscany-02.jpg"></a>
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
								      <a href="tuscany-detail.php" class="loader" title=""><img src="img/tuscany-02.jpg"></a>
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
								      <a href="tuscany-detail.php" class="loader" title=""><img src="img/tuscany-02.jpg"></a>
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
								      <a href="tuscany-detail.php" class="loader" title=""><img src="img/tuscany-02.jpg"></a>
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

    <?php require_once('footer.php'); ?>

</body>
</html>

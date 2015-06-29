<?php
// no direct access
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/domus/';
$detail = simplexml_load_file('https://www.vacavilla.com/en/webservices/v1/service/viewhouse/data/description:1,amenities:1,pictures:1,prices:1,extraprices:1,calendar:1/house/'.JRequest::getVar('id').'/api.xml');
/*print_r($detail->extracost->included->price[1]);exit;*/
?>
<script type="text/javascript">
    $(document).ready(function () {  
        //Combine jCarousel with Image Display
        $('div#slideshow-carousel li a').hover(
            function () {                
                if (!$(this).has('span').length) {
                    $('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '0.9'});
                    $(this).stop(true, true).children('img').css({'opacity': '1.0'});
                }       
            },
            function () {                    
                $('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '0.9'});
                $('div#slideshow-carousel li a').each(function () {
                    if ($(this).has('span').length) $(this).children('img').css({'opacity': '1.0'});
                });                
            }
        ).click(function () {

                $('span.arrow').remove();        
            $(this).append('<span class="arrow"></span>');
            $('div#slideshow-main li').removeClass('active');        
            $('div#slideshow-main li.' + $(this).attr('rel')).addClass('active');   
                
            return false;
        });

     //jCarousel Plugin
        $('#carousel').jcarousel({
            vertical: true,
            scroll: 1,
            auto: 2,
            wrap: 'last',
            initCallback: mycarousel_initCallback
        }); 
        //Front page Carousel - Initial Setup
        // $('div#slideshow-carousel a img').css({'opacity': '0.5'});
        // $('div#slideshow-carousel a img:first').css({'opacity': '1.0'});
        // $('div#slideshow-carousel li a:first').append('<span class="arrow"></span>')
    });

    //$(".btn_zoom").attr("href", $("#slideshow-main li.active img").attr("src"));

//Carousel Tweaking
    function mycarousel_initCallback(carousel) {        
        // Pause autoscrolling if the user moves with the cursor over the clip.
        carousel.clip.hover(function() {
            carousel.stopAuto();
        }, function() {
            carousel.startAuto();
        });
    }   
</script>
<section class="content clearfix">
	<div class="container pad0">
		<div class="main-content detail-content clearfix"> 

			<!-- Begin slider -->
			<div class="pro_gallary">
				<div class="row">   
					<div id="slideshow-main" class="col-xs-9 col-sm-10">   
						<a rel="gallery1" href="#" class="btn_zoom fancybox"><i class="fa fa-search-plus"></i> Zoom</a>
						<ul>
							<li class="p1 active">
								<a rel="gallery1" href="<?php echo $tmpl;?>img/gallery_01_lg.jpg" class="fancybox">
									<img src="<?php echo $tmpl;?>img/gallery_01_lg.jpg"  alt=""/> 
								</a>
							</li>
							<li class="p2">
								<a rel="gallery1" href="<?php echo $tmpl;?>img/gallery_02_lg.jpg" class="fancybox">
									<img src="<?php echo $tmpl;?>img/gallery_02_lg.jpg"  alt=""/> 
								</a>
							</li>
							<li class="p3">
								<a rel="gallery1" href="<?php echo $tmpl;?>img/gallery_03_lg.jpg" class="fancybox">
									<img src="<?php echo $tmpl;?>img/gallery_03_lg.jpg" alt=""/> 
								</a>
							</li>
							<li class="p4">
								<a rel="gallery1" href="<?php echo $tmpl;?>img/gallery_04_lg.jpg" class="fancybox">
									<img src="<?php echo $tmpl;?>img/gallery_04_lg.jpg" alt=""/> 
								</a>
							</li>
							<li class="p5">
								<a rel="gallery1" href="<?php echo $tmpl;?>img/gallery_05_lg.jpg" class="fancybox">
									<img src="<?php echo $tmpl;?>img/gallery_05_lg.jpg" alt=""/> 
								</a>
							</li>
							<li class="p6">
								<a rel="gallery1" href="<?php echo $tmpl;?>img/gallery_06_lg.jpg" class="fancybox">
									<img src="<?php echo $tmpl;?>img/gallery_06_lg.jpg" alt=""/> 
								</a>
							</li> 
						</ul>                                       
					</div><!-- slideshow-main -->
							
					<div id="slideshow-carousel"  class="col-xs-3 col-sm-2">               
						  <ul id="carousel" class="jcarousel jcarousel-skin-tango">
							<li><a href="" rel="p1" ><img src="<?php echo $tmpl;?>img/gallery_01_lg.jpg" alt="#"/></a></li>
							<li><a href="#" rel="p2"><img src="<?php echo $tmpl;?>img/gallery_02_lg.jpg" alt="#"/></a></li>
							<li><a href="#" rel="p3"><img src="<?php echo $tmpl;?>img/gallery_03_lg.jpg" alt="#"/></a></li>
							<li><a href="#" rel="p4"><img src="<?php echo $tmpl;?>img/gallery_04_lg.jpg" alt="#"/></a></li>
							<li><a href="#" rel="p5"><img src="<?php echo $tmpl;?>img/gallery_05_lg.jpg" alt="#"/></a></li>
							<li><a href="#" rel="p6"><img src="<?php echo $tmpl;?>img/gallery_06_lg.jpg" alt="#"/></a></li> 
						  </ul>
					</div><!-- slideshow-carousel -->
				</div><!-- row -->
			</div><!--pro_gallary --> 
			<!-- End Slider -->

			<div class="features">
				<div class="row">
					<div class="col-md-12">  
						<h2>Property features</h2>
						<p><?php echo $detail->descriptions->description;?></p>	 
						<p><?php echo $detail->descriptions->interior;?></p>
						<p><?php echo $detail->descriptions->distances;?></p> 
					</div>
				</div><!--row-->
			</div><!--features -->  

			<div class="infomations"> 
				<div class="row">
					<div class="col-sm-6">
						<h2><?php echo $detail->name;?></h2>
						<div class="wrap-icon-star">
						<?php for($i=1; $i<=$detail->stars; $i++){?>
						<i class="fa fa-star"></i>
						<?php }?>
						</div>
						<div class="each_box_info"><label><?php echo $detail->town;?> - <?php echo $detail->zone;?> </label><a class="fancybox view-map" href="#popupMap_min"> <i class="fa fa-map-marker"></i>View Map</a></div>
						<div id="popupMap_min" style="display:none;">
							<div class="wrap_popupMap_min">
								<iframe width="578" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $detail->latitute.','.$detail->longitude;?>&amp;z=13&amp;output=embed"></iframe>
							</div><!-- wrap_popupMap -->
						</div><!-- popupMap -->
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
									<?php foreach($detail->amenities->amenity as $amenity){?>
									<li><?php echo $amenity->name;?></li>
									<?php }?>
								</ul>
							</div> 
						</div>
						<div class="each_box_info">
							<div class="each_row"><label>Activities:</label></div>
							<div class="each_row">
								<p><?php echo $detail->descriptions->interior;?></p>
								<p><?php echo $detail->descriptions->distances;?></p> 
							</div> 
						</div>
						<div class="each_box_info">
							<div class="header-meta">
							  <p><i class="fa fa-tag"></i><span class="price">from <span class="price_line_through">1.743</span> 1.484 EUR/WEEK (fra 21.500 DKK/UGE)</span></p>
							</div>
						</div>
					</div> <!-- col-sm-6 --> 
					<div class="col-sm-6">
						<div class="each_box_info"> 
							<div class="house-booking-form text-center alert-success alert">
								<p class="lead">Vælg datoer for tilgængelighed og priser</p>
								<hr>
								<form  class="book-house-form form-inline"> 
									<div class="row">
										<div class="col-xs-6">
											<div class="input-group ">
												<input type="text" class="form-control date-input" placeholder="Check in"> 
											</div>
										</div>
										<div class=" col-xs-6">
											<div class="input-group ">
												<input type="text" class="form-control date-input" placeholder="Check ud">
											</div>
										</div>
									</div>
								</form> 
							</div>  
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
									<li>Refundable deposit in cash (to be handed over on arrival) (per booking): 100,00 EUR</li> 
									<li>Possible tourist tax to be paid locally (price depending on each municipality).</li> 
								</ul>
							</div> 
						</div>
						<div class="each_box_info">	
							<div class="each_row">
								<label>Optional extra services on request </label>
								<ul>
									<li>Extra bed: children from 7 up to 12 per person/day: 25,00 EUR</li> 
									<li>Extra bed: children/adults over 13 years per person/day: 30,00 EUR</li>    
								</ul>
							</div> 
						</div>
						<a href="orderbooking.php" class="btn btn-lg btn-book">BOOK BOLIGEN <i class="fa fa-angle-double-right"></i></a>
					</div><!-- col-sm-6 -->
				</div>
			</div><!-- infomations -->  
			<div class="available_apartments">
				<h2>Ledige lejligheder i ejendommen</h2>
				<div class="row">
					<ul class="list_available">
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Rosa</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Ciclamino</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Ginestra</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>

						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Papavero</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Iris</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Magnolia</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li> 
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Girasole</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Panzé</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Margherita</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>  
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Glicine </a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Tulipano</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Mimos</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
						<li class="col-sm-6 col-md-4">
							<h3><a href="#">Casabianca Geranio</a></h3><div class="wrap-icon-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
							<ul class="list-unstyled clearfix"> 
							  <li><span>Sleeps: </span>2</li><li><span>Double bedrooms: </span>1</li><li><span>Bathrooms: </span>1</li> 
							</ul> 
						</li>
					</ul>
				</div>	
			</div><!-- available_apartments -->
		</div><!--main-content -->
	</div><!--container-->
</section>
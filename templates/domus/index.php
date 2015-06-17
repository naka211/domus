<?php 
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/'.$this->template.'/';
unset($this->_scripts[JURI::root(true).'/media/jui/js/jquery-noconflict.js']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="HandheldFriendly" content="true" />
	<meta name="apple-mobile-web-app-capable" content="YES" />

	<jdoc:include type="head" />
	
	<link rel="shortcut icon" href="<?php echo $tmpl;?>favicon.ico">
	<link rel="shortcut icon" href="<?php echo $tmpl;?>favicon.png">
	
	<!-- CSS -->
	<link href="<?php echo $tmpl;?>css/bootstrap.min.css" rel="stylesheet"> 
	<link href="<?php echo $tmpl;?>css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $tmpl;?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" /> 
	
	<link href="<?php echo $tmpl;?>css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
	<!-- CSS for Gallery detail page -->
	<link rel="stylesheet" type="text/css" href="<?php echo $tmpl;?>css/jquery.jcarousel.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $tmpl;?>css/skin.css" />
	
	<link href="<?php echo $tmpl;?>css/jquery.nouislider.css" rel="stylesheet">
	<link href="<?php echo $tmpl;?>css/jquery.nouislider.pips.min.css" rel="stylesheet">
	
	<link href="<?php echo $tmpl;?>css/style.css" rel="stylesheet">
	<link href="<?php echo $tmpl;?>css/style_mobile.css" rel="stylesheet">
	<link href="<?php echo $tmpl;?>css/hover.css" rel="stylesheet" media="all">  
	
	<!-- Custom Fonts -->
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->  

 	    
    <!-- jQuery   -->   
    
    <script src="<?php echo $tmpl;?>js/bootstrap.min.js"></script>
    <script src="<?php echo $tmpl;?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo $tmpl;?>js/jquery.ui.datepicker-da.js"></script>
    <!--<script src="<?php echo $tmpl;?>js/jquery.smartmenus.js"></script>  -->

    <!--jQuery for GALLERY detail page-->
    <script type="text/javascript" src="<?php echo $tmpl;?>js/jquery.jcarousel.pack.js"></script>

    <!--jQuery  for Popup FANCYBOX -->
    <script type="text/javascript" src="<?php echo $tmpl;?>fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript" src="<?php echo $tmpl;?>fancybox/source/helpers/jquery.fancybox-media.js"></script> 
 
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript">
	    $(document).ready(function(){
            //Get 'href' for button Zoom on detail-page
            $('.btn_zoom').click(function(){
                $(this).attr('href', $("#slideshow-main li.active img").attr("src"));
            });
	    	//Js for datepicker
            $( ".date-input" ).datepicker({
                "option"    :$.datepicker.regional[ "da" ]
            });

            // JS for POPUP Login
            $(".fancybox_search_filter").fancybox({  
                helpers : {
                    overlay : {
                        locked : false // try changing to true and scrolling around the page
                    }
                },
                 beforeShow: function(){
                  $(".fancybox-wrap").addClass('wrap_fancybox_search_filter');                  
                 }
            }); 

            // JS for POPUP MAP Iframe
            $(".fancybox").fancybox(); 

            // JS for Box Contact homepage
            $('.btnkontact, .closeContact').on('click', function(e) {
              $('.boxContact').toggleClass("show"); //you can list several class names 
              e.preventDefault();
            });  

            //JS for button Close cookie
            $('.btnClose').click(function(e) {
                e.preventDefault();
                jQuery('.cookies').toggle('slide');
            });

	    });
    </script>
</head>

<body id="page-top" class="index">

     <!--Navigation -->
	<nav class="navbar navbar-default navbar-fixed-top" id="fixedNav">
		<div class="container relative">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header page-scroll relative">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"></a>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="tuscany.php">Tuscany</a></li>
					<li><a href="tuscany.php">Venice</a></li>
					<li><a href="tuscany.php">Villas</a></li>
					<li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Other Destinations <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="map.php">Italy</a></li> 
						</ul>
					</li>
				</ul>
				<form role="search" class="navbar-form navbar-right">
					<div class="form-group search">
						<input type="text" placeholder="Søg efter by eller sted" class="form-control">
						<button type="submit" class="btn btnSearch"><i class="fa fa-search"></i></button>
					</div>
				</form>
			</div>
			<!-- /.navbar-collapse -->
			<div class="shadow"></div> 
		</div>
		<!-- /.container-fluid -->
	</nav>
	<div class="wrap_btnkontact">
		<div class="container">
			<a class="btnkontact" href="#">KONTAKT OS VIA E-MAIL</a> <!-- hvr-fade -->
		</div>
	</div>

    <section class="banner">
		<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
		   <!-- Carousel items -->
			<div class="carousel-inner">
				<div class="active item">
					<img src="<?php echo $tmpl;?>img/slider01.jpg" alt="">
				</div>
				<div class="item">
					<img src="<?php echo $tmpl;?>img/slider02.jpg" alt="">
				</div>
				<div class="item">
					<img src="<?php echo $tmpl;?>img/slider03.jpg" alt="">
				</div>
				<div class="container relative">
				<div class="main-search">
					<div class="row mb10">
						<div class="col-md-12">
							<h2>Find your italian villa in Tuscany and other regions</h2>
							<div class="form-inline">
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Apartment
									</label>
								</div>
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Independent house
									</label>
								</div>
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Villa
									</label>
								</div>
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Pet allowed
									</label>
								</div>
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Air conditioning
									</label>
								</div>
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Internet access
									</label>
								</div>
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Swimming Pool
									</label>
								</div>
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Golf course
									</label>
								</div>
								<div class="checkbox col-sm-5ths col-xs-6">
									<label>
									  <input type="checkbox"> Tennis
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
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
							
							<div class="option">
								<button type="submit" class="btn btnSearch hvr-grow">Søg</button>
							</div>
						</div>
					</div>
				</div>
			</div>
	
			</div>
			<!-- Carousel nav -->
			<a class="carousel-control left" href="#myCarousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="carousel-control right" href="#myCarousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	</section>

    <section class="content">
    	<div class="container pad0">
    		<div class="main-content clearfix">
    			<div class="box clearfix">
    				<div class="box-text">
    					<h2>Ask us, just as you would ask a friend...</h2>
	    				<p>We are an Italian Incoming Tour Operator, specialized in weekly holiday rentals in Tuscany, Umbria, the Amalfi Coast, Liguria, Lombardy, Veneto and Sicily. We offer villas and farmhouses with swimming pools in the countryside or on the coast, as well as apartments in the cities of Florence and Venice.</p>
    				</div>
    				<div class="box-text">
    					<h2>Ask us, just as you would ask a friend...</h2>
	    				<p>We are an Italian Incoming Tour Operator, specialized in weekly holiday rentals in Tuscany, Umbria, the Amalfi Coast, Liguria, Lombardy, Veneto and Sicily. We offer villas and farmhouses with swimming pools in the countryside or on the coast, as well as apartments in the cities of Florence and Venice.</p>
    				</div>
	    		</div>
	    		<div class="list-tours">
	    			<div class="row clearfix">
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="<?php echo $tmpl;?>img/img01.jpg" alt="">
	    						</div>
	    						<h2>Special Offers</h2>
	    					</a>
	    					<p>Are you looking for a last minute offer or a discount for 2 or 3 weeks long stay holiday? Take a look at our selection of italian villas for rent and apartments in promotion...</p>
	    				</div>
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="<?php echo $tmpl;?>img/img02.jpg" alt="">
	    						</div>
	    						<h2>Exclusive services</h2>
	    					</a>
	    					<p>Find out  all about the customized services we have created to make your holiday unique and made to measure, all the services can be requested directly...</p>
	    				</div>
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="<?php echo $tmpl;?>img/img03.jpg" alt="">
	    						</div>
	    						<h2>Art Cities</h2>
	    					</a>
	    					<p>Spend a  weekend or a holiday filled with beauty, Italy is the country with the largest artistic heritage in the world and we at VacaVilla have selected...</p>
	    				</div>
	    			</div>
	    			<div class="row">
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="<?php echo $tmpl;?>img/img01.jpg" alt="">
	    						</div>
	    						<h2>Special Offers</h2>
	    					</a>
	    					<p>Are you looking for a last minute offer or a discount for 2 or 3 weeks long stay holiday? Take a look at our selection of italian villas for rent and apartments in promotion...</p>
	    				</div>
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="<?php echo $tmpl;?>img/img02.jpg" alt="">
	    						</div>
	    						<h2>Exclusive services</h2>
	    					</a>
	    					<p>Find out  all about the customized services we have created to make your holiday unique and made to measure, all the services can be requested directly...</p>
	    				</div>
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="<?php echo $tmpl;?>img/img03.jpg" alt="">
	    						</div>
	    						<h2>Art Cities</h2>
	    					</a>
	    					<p>Spend a  weekend or a holiday filled with beauty, Italy is the country with the largest artistic heritage in the world and we at VacaVilla have selected...</p>
	    				</div>
	    			</div>
	    		</div>
    		</div>
    	</div>
    </section>

    <section class="info">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-3 pad0">
    				<a href="#">
	    				<span class="btnCircle hvr-fade"><i class="fa fa-home fa-1-5x"></i></span>
	    				<h6>Offer your Home</h6>
	    				<p>Do you have a vacation home to offer?</p>
    				</a>
    			</div>
    			<div class="col-md-3 pad0">
    				<a href="#">
	    				<span class="btnCircle hvr-fade"><i class="fa fa-exclamation fa-1-5x"></i></span>
	    				<h6>About us</h6>
	    				<p>Read more about VacaVilla’s Team</p>
    				</a>
    			</div>
    			<div class="col-md-3 pad0">
    				<a href="#">
	    				<span class="btnCircle hvr-fade"><i class="fa fa-map-marker fa-1-5x"></i></span>
	    				<h6>Contact us</h6>
	    				<p>If you need assistance contact our staff</p>
    				</a>
    			</div>
    			<div class="col-md-3 pad0">
    				<a href="#">
	    				<span class="btnCircle hvr-fade"><i class="fa fa-star fa-1-5x"></i></span>
	    				<h6>Exclusive services</h6>
	    				<p>Exclusive services for your holidays</p>
    				</a>
    			</div>
    		</div>
    	</div>
    </section>

    <section class="slider">
    	<div class="container">
    		<div id="myCarousel2" class="carousel slide" data-interval="3000" data-ride="carousel">
		       <!-- Carousel items -->
		        <div class="carousel-inner">
		            <div class="active item">
		                <div class="col-md-5 img-left">
	                		<img class="img-responsive" src="<?php echo $tmpl;?>img/img04.png" alt="">
	                	</div>
	                	<div class="col-md-7">
	                		<h3>Find billige villa og lejlighed på din<br> mobil eller tablet 1</h3>
	                		<p>Understøtter alle typer mobile enheder!</p>
	                	</div>
		            </div>
		            <div class="item">
		                <div class="col-md-5 img-left">
	                		<img class="img-responsive" src="<?php echo $tmpl;?>img/img04.png" alt="">
	                	</div>
	                	<div class="col-md-7">
	                		<h3>Find billige villa og lejlighed på din<br> mobil eller tablet 2</h3>
	                		<p>Understøtter alle typer mobile enheder!</p>
	                	</div>
		            </div>
		            <div class="item">
		                <div class="col-md-5 img-left">
	                		<img class="img-responsive" src="<?php echo $tmpl;?>img/img04.png" alt="">
	                	</div>
	                	<div class="col-md-7">
	                		<h3>Find billige villa og lejlighed på din<br> mobil eller tablet 3</h3>
	                		<p>Understøtter alle typer mobile enheder!</p>
	                	</div>
		            </div>
		        </div>
		        <!-- Carousel nav -->
		        <a class="carousel-control left" href="#myCarousel2" data-slide="prev">
		            <span class="arrow-left glyphicon-chevron-left"></span>
		        </a>
		        <a class="carousel-control right" href="#myCarousel2" data-slide="next">
		            <span class="arrow-right glyphicon-chevron-right"></span>
		        </a>
		    </div>
    	</div>
    </section>

    <section class="newsletter">
    	<div class="container">
    		<p>Få inspiration, nyheder og fantastiske priser. Send mig nyeste rejseinspiration, insidertips og gode priser fra Domus Holidays</p>
			<form class="form-inline">
				<div class="row">
					<div class="col-sm-3">
						 <div class="form-group">
						    <input type="email" class="form-control" placeholder="Fornavn *">
					  	</div> 
				  	</div>
				  	<div class="col-sm-3">
					  	<div class="form-group">
						    <input type="email" class="form-control" placeholder="Efternavn *">
					  	</div> 
				  	</div>
				  	<div class="col-sm-3">
					  	<div class="form-group">
						    <input type="email" class="form-control" placeholder="E-mail *">
					  	</div> 
				  	</div>
				  	<div class="col-sm-2">
						 <div class="form-group">
						    <button type="submit" class="btn">TILMELD</button>
					  	</div> 
				  	</div>  
				</div>
			</form> 
    	</div>
    </section>

    <div class="cookies">
    	<p>Domus Holidays anvender cookies til analyse og<br> genkendelse.</p>
    	<a class="btnClose" href="#">Luk</a>
    </div>

    <footer>
		<div class="footer-above">
			<div class="container">
				<div class="row">
				   <div class="col-md-3 col-xs-6 col-1">
						<h2>Home</h2>
						<ul>
							<li><a href="kontakt.php">Kontakt</a></li>
							<li><a href="handelsbetingelser.php">Handelsbetingelser</a></li>
							<li><a href="text.php">FAQ spørgsmål/svar!</a></li>
							<li><a href="text.php">Lande/Regions beskrivelser</a></li>
							<li><a href="om-os.php">Om os – hvem er vi?</a></li>
							<li><a href="text.php">Når du ankommer?</a></li>
							<li><a href="text.php">Når du rejser?</a></li>
							<li><a href="text.php">Billeje?</a></li>
							<li><a href="text.php">Fly?</a></li>
							<li><a href="text.php">Rejseforsikring?</a></li>
						</ul>
				   </div>
					<div class="col-md-3 col-xs-6 col-2">
						<h2>Destinations</h2>
						<ul>
							<li><a href="tuscany.php">Tuscany</a></li>
							<li><a href="#">Veneto</a></li>
							<li><a href="#">Amalfi Coast</a></li>
							<li><a href="#">Sicily</a></li>
							<li><a href="#">Lake Garda</a></li>
							<li><a href="#">Lombardy</a></li>
							<li><a href="#">Umbria</a></li>
							<li><a href="#">Liguria</a></li>
							<li><a href="#">Lazio</a></li>
							<li><a href="#">Marche</a></li>
						</ul>
					</div>
					<div class="col-md-3 col-xs-6 col-3">
						<h2>Domus Holidays </h2>
						<img src="<?php echo $tmpl;?>img/logo2.png" alt=""> 
						<p class="info_ft">
						Domus Holidays<br> 
						Idrætsvej 62<br>
						DK-2650 Hvidovre<br> </p>
	
						<p class="links_ft">
						<a href="mailto:info@domusholidays.com">info@domusholidays.com</a><br>
						<a href="http://www.domusholidays.com/">www.domusholidays.com </a></p>
	
					</div>
					<div class="col-md-3 col-xs-6 col-4">
						<h2>VI MODTAGER</h2>
						<img src="<?php echo $tmpl;?>img/cart.png" alt="">
						<a href="#"><img src="<?php echo $tmpl;?>img/face.png" alt=""></a>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-below">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<p>© 2015 Domus Holidays. All Rights Reserved. </p>
					</div>
				</div>
			</div>
		</div> 
	</footer>
	
	<div class="boxContact">
		<div class="boxContent text-center"><a href="#" class="closeContact" title="CLose"><i class="fa fa-close"></i></a>
			<h2>Har du brug for hjælp?</h2>
			<p>Udfyld formular, og vi kontakter dig hurtigst muligt!</p>
			<div class="formcontactMe">
				<div class="form-group">
					<input class="txtInput form-control" placeholder="Navn *">
				</div>
				<div class="form-group">
					<input class="txtInput form-control" placeholder="Telefon *">
				</div>
				<div class="form-group">
					<textarea class="form-control" placeholder="Besked"></textarea>
				</div>
				<a class="btn btnSend hvr-fade" href="#">SEND AFSTED!</a>
			</div><!-- formcontactMe -->
		</div><!--boxContent-->
	</div><!--boxContact-->
	
	<div id="popupMap_min" style="display:none;">
		<div class="wrap_popupMap_min">
			<iframe width="578" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=43.856076,10.64957&amp;z=13&amp;output=embed"></iframe>
		</div><!-- wrap_popupMap -->
	</div><!-- popupMap --> 
	
	<div id="popupMap_larger" style="display:none;">
		<div class="wrap_popupMap_larger">
			<img src="<?php echo $tmpl;?>img/map-02.jpg">
		 </div><!-- wrap_popupMap -->
	</div><!-- popupMap -->
	
	<div class="hidden-sm hidden-md hidden-lg wrap_btnkontact wrap_btnkontact_footer">
		<div class="container">
			<a class="btnkontact" href="#">KONTAKT OS VIA E-MAIL</a> <!-- hvr-fade -->
		</div>
	</div>


    <script> 
	  $(document).ready(function() {
	    $('#ppNewletter').fancybox().trigger('click'); 
	});
  </script>
    <div id="ppNewletter" style="display:none">
		 <div>
		 	<h4>Nyhedsbrev tilmelding</h4>
		 	<p>Få inspiration, nyheder og fantastiske priser. Send mig nyeste rejseinspiration, insidertips og gode priser fra Domus Holidays</p>
		 	<form>
		 		<div class="form-group">
				    <input type="email" class="form-control" placeholder="Fornavn *">
			  	</div> 
			  	<div class="form-group">
				    <input type="email" class="form-control" placeholder="Efternavn *">
			  	</div>
			  	<div class="form-group">
				    <input type="email" class="form-control" placeholder="E-mail *">
			  	</div>
			  	<p>Felter markeret med * skal udfyldes</p>
			  	<button type="submit" class="btn">TILMELD</button>
		 	</form>
		 </div>
	</div><!--ppSearch_filter-->

</body> 
</html>

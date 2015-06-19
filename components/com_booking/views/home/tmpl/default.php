<?php
// no direct access
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/domus/';
?>
<section class="banner">
	<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
	   <!-- Carousel items -->
		<div class="carousel-inner">
			{module Home Slider - Top}
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
			{modulepos content-bottom}
		</div>
	</div>
</section>

<section class="slider">
	<div class="container">
		<div id="myCarousel2" class="carousel slide" data-interval="3000" data-ride="carousel">
		   <!-- Carousel items -->
			<div class="carousel-inner">
				{module Home Slider - Bottom}
				<!--<div class="active item">
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
				</div>-->
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



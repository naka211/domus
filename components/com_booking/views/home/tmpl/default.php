<?php
// no direct access
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/domus/';
?>
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
<section class="banner">
	<div id="myCarousel" class="carousel slide" data-interval="11000" data-ride="carousel">
	   <!-- Carousel items -->
		<div class="carousel-inner">
			{module Home Slider - Top}
			<div class="container relative">
			<form action="index.php" method="get">
			<div class="main-search">
				<div class="row mb10">
					<div class="col-md-12">
						<h2>Find your italian villa in Tuscany and other regions</h2>
						<div class="form-inline">
							<?php if($this->filters['apartment']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="apartment" value="1"> Apartment
								</label>
							</div>
							<?php }?>
							<?php if($this->filters['independent_house']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="independent_house" value="1"> Independent house
								</label>
							</div>
							<?php }?>
							<?php if($this->filters['villa']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="villa" value="1"> Villa
								</label>
							</div>
							<?php }?>
							<?php if($this->filters['pet_allowed']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="pet_allowed" value="1"> Pet allowed
								</label>
							</div>
							<?php }?>
							<?php if($this->filters['air_conditioning']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="air_conditioning" value="1"> Air conditioning
								</label>
							</div>
							<?php }?>
							<?php if($this->filters['internet_access']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="internet_access" value="1"> Internet access
								</label>
							</div>
							<?php }?>
							<?php if($this->filters['swimming_pool']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="swimming_pool" value="1"> Swimming Pool
								</label>
							</div>
							<?php }?>
							<?php if($this->filters['golf_course']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="golf_course" value="1"> Golf course
								</label>
							</div>
							<?php }?>
							<?php if($this->filters['tennis']){?>
							<div class="checkbox col-sm-5ths col-xs-6">
								<label>
								  <input type="checkbox" name="tennis" value="1"> Tennis
								</label>
							</div>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="option">
							<?php 					   
					   		$arrContextOptions=array(
								"ssl"=>array(
									"verify_peer"=>false,
									"verify_peer_name"=>false,
								),
							);
							$des = simplexml_load_string(file_get_contents('https://www.vacavilla.com/en/webservices/v1/service/searchformhelper/helperservice/zones_in_country/country/ITA/depth/1/api.xml', false, stream_context_create($arrContextOptions)));
							
							?>
							<select class="form-control mb10" name="zone" id="zone">
								<option value="0">Any Region</option>
								<?php foreach($des->zone as $item){?>
								<option value="<?php echo $item['code'];?>"><?php echo $item->name;?></option>
								<?php }?>
							</select>
							<select class="form-control mb10" name="subzone" id="subzone">
								<option value="0">Any Town</option>
							</select>
						</div>
						<div class="option">
							<select class="form-control mb10" name="town" id="town">
								<option value="0">Any Area</option>
							</select>
							<select class="form-control" name="person">
								<option value="0">Person</option>
								<option value="Any">Any</option>
								<?php for($i=2; $i<=30; $i++){?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php }?>
							</select>
						</div>
						<div class="option option_day">
							<input id="start_date" name="start_date" type="text" class="form-control date-input mb10" placeholder="Starting date">
							<input id="end_date" name="end_date" type="text" class="form-control date-input" placeholder="Ending date">
						</div>
						
						<div class="option">
							<button type="submit" class="btn btnSearch hvr-grow">Søg</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="option" value="com_booking" />
		<input type="hidden" name="view" value="search" />
		</form>
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
					<h2>{article 13}{title}{/article}</h2>
					{article 13}{text}{/article}
				</div>
				<div class="box-text">
					<h2>{article 14}{title}{/article}</h4>
					{article 14}{text}{/article}
					{module AcyMailing Module Popup}
					<!--<form>
						<div class="form-group">
							<input type="email" placeholder="Navn *" class="form-control">
						</div> 
						<div class="form-group">
							<input type="email" placeholder="E-mail *" class="form-control">
						</div>
						<p>Felter markeret med * skal udfyldes</p>
						<button class="btn" type="submit">TILMELD</button>
					</form>-->
				</div>
			</div>
			<div class="list-tours">
				<div class="row clearfix">
					{module Homepage Articles}
				</div>
			</div>
		</div>
	</div>
</section>

<section class="info">
	<!--<div class="container">
		<div class="row">
			<div class="col-md-3 pad0">
				<a href="#">
					<span class="btnCircle hvr-fade"><i class="fa fa-home fa-1-5x"></i></span>
					<h6>Offer your Home</h6>
					<p>Do you have a vacation home to offer?</p>
				</a>
			</div>
			<div class="col-md-3 pad0">
				<a href="index.php?option=com_content&view=article&id=4&Itemid=135">
					<span class="btnCircle hvr-fade"><i class="fa fa-exclamation fa-1-5x"></i></span>
					<h6>About us</h6>
					<p>Read more about VacaVilla’s Team</p>
				</a>
			</div>
			<div class="col-md-3 pad0">
				<a href="index.php?option=com_contact&view=contact&id=1&Itemid=131">
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
	</div>-->
</section>
<?php /*?>
<section class="slider">
	<div class="container">
		<div id="myCarousel2" class="carousel slide" data-interval="3000" data-ride="carousel">
		   <!-- Carousel items -->
			<div class="carousel-inner">
				{module Home Slider - Bottom}
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
<?php */?>


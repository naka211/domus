<?php
// no direct access
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/domus/';
$arrContextOptions=array(
	"ssl"=>array(
		"verify_peer"=>false,
		"verify_peer_name"=>false,
	),
);
$detail = file_get_contents('http://go-to-italy.dk/demo/index.php?option=com_houses&task=house.getHouse&id='.JRequest::getVar('id'), false, stream_context_create($arrContextOptions));
//$detail = file_get_contents('http://localhost/gotoitaly/index.php?option=com_houses&task=house.getHouse&id='.JRequest::getVar('id'), false, stream_context_create($arrContextOptions));
$detail = json_decode($detail);
JFactory::getDocument()->setTitle($detail->name.' - Domus Holiday');
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
		
		//Js for datepicker
		
		$( "#start_date" ).datepicker({
			"option"    :$.datepicker.regional[ "da" ],
			minDate: 0,
			onSelect: function(selected, inst) {
				
				var arr = selected.split("-");
            	var date = new Date(arr[2]+"-"+arr[1]+"-"+arr[0]);
				var d = date.getDate();
				var m = date.getMonth();
				var y = date.getFullYear();
				var minEndDate = new Date(y, m, d + 7);
				
			
				$( "#end_date" ).datepicker({
					"option"    :$.datepicker.regional[ "da" ],
					minDate: minEndDate
				});
				$("#end_date").datepicker('setDate', minEndDate);
				
				$(".price").html('<img src="images/loading.gif" id="loading_image">');
				$.ajax({
					method: "POST",
					url: "<?php echo JURI::base();?>index.php?option=com_booking&task=detail.getPrice1",
					data: { start_date: $("#start_date").val(), end_date: $("#end_date").val(), id: <?php echo JRequest::getVar('id');?> }
				}).done(function( html ) {
					//$('#loading_image').hide();
					var data = jQuery.parseJSON(html);
					$(".price").html(data.text);
					$("#amountda").val(data.amount);
					$(".btn-book").show();
				});
			}
		});
		$('#loading_image').hide();
		$("#end_date").change(function(e) {
			$(".price").html('<img src="images/loading.gif" id="loading_image">');
			$.ajax({
				method: "POST",
				url: "<?php echo JURI::base();?>index.php?option=com_booking&task=detail.getPrice1",
				data: { start_date: $("#start_date").val(), end_date: $("#end_date").val(), id: <?php echo JRequest::getVar('id');?> }
			}).done(function( html ) {
				$('#loading_image').hide();
				var data = jQuery.parseJSON(html);
				$(".price").html(data.text);
				$("#amountda").val(data.amount);
				$(".btn-book").show();
			});
		});
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
						<a rel="gallery1" href="#" class="btn_zoom fancybox"><i class="fa fa-search-plus"></i> Se billeder</a>
						<ul>
							<li class="p1 active">
								<a rel="gallery1" href="<?php echo $detail->image1;?>" class="fancybox">
									<img src="<?php echo $detail->image1;?>"  alt=""/> 
								</a>
							</li>
							<?php 
							$p = 2;
							foreach($detail->images as $picture){?>
							<li class="p<?php echo $p;?>">
								<a rel="gallery1" href="<?php echo $picture;?>" class="fancybox">
									<img src="<?php echo $picture;?>"  alt="<?php echo strip_tags($picture->description);?>"/> 
								</a>
							</li>
							<?php $p++;}?>
						</ul>                                       
					</div><!-- slideshow-main -->
							
					<div id="slideshow-carousel"  class="col-xs-3 col-sm-2">               
						  <ul id="carousel" class="jcarousel jcarousel-skin-tango">
							<li><a href="" rel="p1" ><img src="<?php echo $detail->image1;?>" alt="<?php echo strip_tags($detail->description);?>"/></a></li>
							<?php 
							$p = 2;
							foreach($detail->images as $picture){?>
							<li><a href="#" rel="p<?php echo $p;?>"><img src="<?php echo $picture;?>" alt="<?php echo strip_tags($detail->description);?>"/></a></li>
							<?php $p++;}?>
						  </ul>
					</div><!-- slideshow-carousel -->
				</div><!-- row -->
			</div><!--pro_gallary --> 
			<!-- End Slider -->

			<div class="features">
				<div class="row">
					<div class="col-md-12">  
						<h2>Property features</h2>
						<p><?php echo $detail->features;?></p>	 
					</div>
				</div><!--row-->
			</div><!--features -->  

			<div class="infomations"> 
				<div class="row">
					<div class="col-sm-6">
						<h2><?php echo $detail->name;?></h2>
						<div class="each_box_info">
							<div class="header-meta">
							  <!--<p><i class="fa fa-tag"></i><span class="price">from <span class="price_line_through">1.743</span> 1.484 EUR/WEEK (fra 21.500 DKK/UGE)</span></p>-->
							  <p><i class="fa fa-tag"></i><span class="price"><!--<img id="loading_image" src="<?php echo JURI::base().'images/loading.gif';?>" />--></span></p>
							</div>
						</div>
					</div> <!-- col-sm-6 --> 
					<div class="col-sm-6">
						<div class="each_box_info"> 
							<div class="house-booking-form text-center alert-success alert">
								<p class="lead">Vælg datoer for tilgængelighed og priser</p>
								<hr>
								<form class="book-house-form form-inline" action="index.php" method="post" id="bookingForm"> 
									<div class="row">
										<div class="col-xs-6">
											<div class="input-group ">
												<input type="text" class="form-control date-input" placeholder="Check in" id="start_date" name="start_date"> 
											</div>
										</div>
										<div class=" col-xs-6">
											<div class="input-group ">
												<input type="text" class="form-control date-input" placeholder="Check ud" id="end_date" name="end_date">
											</div>
										</div>
									</div>
									<input type="hidden" name="id" value="<?php echo JRequest::getVar('id');?>" />
									<input type="hidden" name="amountda" id="amountda" value="" />
									<input type="hidden" name="amounteu" id="amounteu" value="0" />
									<input type="hidden" name="data" id="data" value="<?php echo $detail->features;?>" />
									<input type="hidden" name="house_name" value="<?php echo $detail->name;?>" />
									<input type="hidden" name="option" value="com_booking" />
									<input type="hidden" name="task" value="order.order1" />
								</form> 
							</div>  
						</div> 
						<a href="javascript:void(0);" onClick="document.getElementById('bookingForm').submit();" class="btn btn-lg btn-book" style="display:none;">BOOK BOLIGEN <i class="fa fa-angle-double-right"></i></a>
					</div><!-- col-sm-6 -->
				</div>
			</div><!-- infomations -->  
			
		</div><!--main-content -->
	</div><!--container-->
</section>
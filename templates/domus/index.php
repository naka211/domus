<?php 
defined('_JEXEC') or die;
$tmpl = JURI::base().'templates/'.$this->template.'/';
$session = JFactory::getSession();
//unset($this->_scripts[JURI::root(true).'/media/jui/js/jquery-noconflict.js']);
JHTML::_('behavior.formvalidator');
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
    <script src="<?php echo $tmpl;?>js/jquery-1.11.1.min.js"></script>
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

<body id="page-top" class="<?php if(JUri::getInstance()->toString() == JUri::base()){echo 'index';} else {echo 'under';}?>">

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
				<a class="navbar-brand" href=""></a>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="index.php?option=com_booking&view=search&zone=TOS">Tuscany</a></li>
					<li><a href="index.php?option=com_content&view=">Venice</a></li>
					<li><a href="tuscany.php">Villas</a></li>
					<li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Other Destinations <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?option=com_booking&view=map&Itemid=143">Italy</a></li> 
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

	<jdoc:include type="component" />
	<?php //print_r($session->get('notify'));exit;
	if($session->get('notify') != 1){?>
        <script language="javascript">
	$(document).ready(function() {
		$(".btnClose").click(function(event) {
			jQuery.post("<?php echo JURI::base().'index.php?option=com_booking&task=home.set_session'?>");
		});
	});
	</script>
    <div class="cookies">
    	<p>Domus Holidays anvender cookies til analyse og<br> genkendelse.</p>
    	<a class="btnClose" href="javascript:void(0);">Luk</a>
    </div>
	<?php }?>
	
    <footer>
		<div class="footer-above">
			<div class="container">
				<div class="row">
				   <div class="col-md-3 col-xs-6 col-1">
						<h2>Home</h2>
						{module Footer Menu}
				   </div>
					<div class="col-md-3 col-xs-6 col-2">
						<h2>Destinations</h2>
						<?php 
						$des = simplexml_load_file('https://www.vacavilla.com/en/webservices/v1/service/searchformhelper/helperservice/zones_in_country/country/ITA/depth/1/api.xml');
						?>
						<ul>
						<?php foreach($des->zone as $item){?>
							<li><a href="index.php?option=com_booking&view=search&zone=<?php echo $item['code'];?>"><?php echo $item->name;?></a></li>
						<?php }?>
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
				<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate">
				<div class="form-group"> 
					<input type="text" class="form-control required" placeholder="Navn *" name="jform[contact_name]">
				</div>
				<div class="form-group"> 
					<input type="text" class="form-control required" placeholder="E-mail *" name="jform[contact_email]">
				</div>
				<div class="form-group"> 
					<input type="text" class="form-control required" placeholder="Telefon *"  name="jform[contact_phone]">
				</div>
				<div class="form-group"> 
					<textarea  rows="7" class="form-control required" placeholder="Besked *"  name="jform[contact_message]"></textarea>  
				</div>
				<!--<a href="#" class="btn">SEND</a>-->
				<button class="btn btnSend hvr-fade btn-primary validate" type="submit">SEND AFSTED!</button>
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="id" value="1:domus" />
				<?php echo JHtml::_('form.token'); ?>
				</form>
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

	<?php if(JUri::getInstance()->toString() == JUri::base()){?>
    <script> 
	  $(document).ready(function() {
	    //$("#myModal").modal('show'); 
	});
  	</script>
	{module AcyMailing Module Popup}
	<?php }?>
</body> 
</html>

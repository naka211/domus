<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/src/js/jquery-1.11.1.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/src/js/bootstrap.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/src/js/jquery-ui-1.10.3.custom.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/src/js/jquery.ui.datepicker-da.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/src/js/jquery.jcarousel.pack.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/src/fancybox/source/jquery.fancybox.pack.js?v=2.1.5');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/src/fancybox/source/helpers/jquery.fancybox-media.js');

// Add Stylesheets
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/template.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/jquery-ui-1.10.3.custom.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/fancybox/source/jquery.fancybox.css?v=2.1.5');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/font-awesome.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/jquery.jcarousel.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/skin.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/jquery.nouislider.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/jquery.nouislider.pips.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/style.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/style_mobile.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/src/css/hover.css');

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
if ($this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span6";
}
elseif ($this->countModules('position-7') && !$this->countModules('position-8'))
{
	$span = "span9";
}
elseif (!$this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span9";
}
else
{
	$span = "span12";
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<?php // Use of Google Font ?>
	<?php if ($this->params->get('googleFont')) : ?>
		<link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName'); ?>' rel='stylesheet' type='text/css' />
		<style type="text/css">
			h1,h2,h3,h4,h5,h6,.site-title{
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName')); ?>', sans-serif;
			}
		</style>
	<?php endif; ?>
	<?php // Template color ?>
	<?php if ($this->params->get('templateColor')) : ?>
	<style type="text/css">
		body.site
		{
			border-top: 3px solid <?php echo $this->params->get('templateColor'); ?>;
			background-color: <?php echo $this->params->get('templateBackgroundColor'); ?>
		}
		a
		{
			color: <?php echo $this->params->get('templateColor'); ?>;
		}
		.navbar-inner, .nav-list > .active > a, .nav-list > .active > a:hover, .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover, .nav-pills > .active > a, .nav-pills > .active > a:hover,
		.btn-primary
		{
			background: <?php echo $this->params->get('templateColor'); ?>;
		}
		.navbar-inner
		{
			-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
			-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
			box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
		}
	</style>
	<?php endif; ?>
	<!--[if lt IE 9]>
		<script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script>
	<![endif]-->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
	    jQuery(document).ready(function(){
            //Get 'href' for button Zoom on detail-page
            jQuery('.btn_zoom').click(function(){
                jQuery(this).attr('href', jQuery("#slideshow-main li.active img").attr("src"));
            });
	    	//Js for datepicker
            jQuery( ".date-input" ).datepicker({
                "option"    :$.datepicker.regional[ "da" ]
            });

            // JS for POPUP Login
            jQuery(".fancybox_search_filter").fancybox({  
                helpers : {
                    overlay : {
                        locked : false // try changing to true and scrolling around the page
                    }
                },
                 beforeShow: function(){
                  jQuery(".fancybox-wrap").addClass('wrap_fancybox_search_filter');                  
                 }
            }); 

            // JS for POPUP MAP Iframe
            jQuery(".fancybox").fancybox(); 

            // JS for Box Contact homepage
            jQuery('.btnkontact, .closeContact').on('click', function(e) {
              jQuery('.boxContact').toggleClass("show"); //you can list several class names 
              e.preventDefault();
            });  

            //JS for button Close cookie
            jQuery('.btnClose').click(function(e) {
                e.preventDefault();
                jQuery('.cookies').toggle('slide');
            });

	    });
        </script>
</head>

<!--<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
?>">-->
<body id="page-top" class="index">
    <?php if ($this->countModules('main-menu')) : ?>
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
                <a class="navbar-brand" href="<?php echo JUri::root(); ?>"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <jdoc:include type="modules" name="main-menu" style="none" />
                <?php if ($this->countModules('search')) : ?>
                    <jdoc:include type="modules" name="search" style="none" />
                <?php endif; ?>
            </div>
            <!-- /.navbar-collapse -->
            <div class="shadow"></div> 
        </div>
        <!-- /.container-fluid -->
    </nav>
    <?php endif; ?>
    <div class="wrap_btnkontact">
        <div class="container">
            <a class="btnkontact" href="#">KONTAKT OS VIA E-MAIL</a> <!-- hvr-fade -->
        </div>
    </div>
    <?php if ($this->countModules('slider-top')) : ?>
        <jdoc:include type="modules" name="slider-top" style="xhtml" />
    <?php endif; ?>
    <section class="content">
    	<div class="container pad0">
    		<div class="main-content clearfix">
    			<div class="box clearfix">
                        <?php if ($this->countModules('content-top')) : ?>
                            <jdoc:include type="modules" name="content-top" style="xhtml" />
                        <?php endif; ?>
	    		</div>
	    		<div class="list-tours">
	    			<div class="row clearfix">
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="img/img01.jpg" alt="">
	    						</div>
	    						<h2>Special Offers</h2>
	    					</a>
	    					<p>Are you looking for a last minute offer or a discount for 2 or 3 weeks long stay holiday? Take a look at our selection of italian villas for rent and apartments in promotion...</p>
	    				</div>
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="img/img02.jpg" alt="">
	    						</div>
	    						<h2>Exclusive services</h2>
	    					</a>
	    					<p>Find out  all about the customized services we have created to make your holiday unique and made to measure, all the services can be requested directly...</p>
	    				</div>
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="img/img03.jpg" alt="">
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
	    							<img class="img-responsive" src="img/img01.jpg" alt="">
	    						</div>
	    						<h2>Special Offers</h2>
	    					</a>
	    					<p>Are you looking for a last minute offer or a discount for 2 or 3 weeks long stay holiday? Take a look at our selection of italian villas for rent and apartments in promotion...</p>
	    				</div>
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="img/img02.jpg" alt="">
	    						</div>
	    						<h2>Exclusive services</h2>
	    					</a>
	    					<p>Find out  all about the customized services we have created to make your holiday unique and made to measure, all the services can be requested directly...</p>
	    				</div>
	    				<div class="col-md-4 col-sm-6 list-tours-item">
	    					<a href="#">
	    						<div class="img-tour">
	    							<img class="img-responsive" src="img/img03.jpg" alt="">
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
                        <?php if ($this->countModules('content-bottom')) : ?>
                            <jdoc:include type="modules" name="content-bottom" style="xhtml" />
                        <?php endif; ?>
    		</div>
    	</div>
    </section>
    <?php if ($this->countModules('slider-bottom')) : ?>
        <jdoc:include type="modules" name="slider-bottom" style="xhtml" />
    <?php endif; ?>
    <?php if() { ?>
        
    <?php } ?>
	<!-- Body -->
	<div class="body">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
			<!-- Header -->
			<header class="header" role="banner">
				<div class="header-inner clearfix">
					<a class="brand pull-left" href="<?php echo $this->baseurl; ?>/">
						<?php echo $logo; ?>
						<?php if ($this->params->get('sitedescription')) : ?>
							<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</div>'; ?>
						<?php endif; ?>
					</a>
					<div class="header-search pull-right">
						<jdoc:include type="modules" name="position-0" style="none" />
					</div>
				</div>
			</header>
			<?php if ($this->countModules('position-1')) : ?>
				<nav class="navigation" role="navigation">
					<jdoc:include type="modules" name="position-1" style="none" />
				</nav>
			<?php endif; ?>
			<jdoc:include type="modules" name="banner" style="xhtml" />
			<div class="row-fluid">
				<?php if ($this->countModules('position-8')) : ?>
					<!-- Begin Sidebar -->
					<div id="sidebar" class="span3">
						<div class="sidebar-nav">
							<jdoc:include type="modules" name="position-8" style="xhtml" />
						</div>
					</div>
					<!-- End Sidebar -->
				<?php endif; ?>
				<main id="content" role="main" class="<?php echo $span; ?>">
					<!-- Begin Content -->
					<jdoc:include type="modules" name="position-3" style="xhtml" />
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<jdoc:include type="modules" name="position-2" style="none" />
					<!-- End Content -->
				</main>
				<?php if ($this->countModules('position-7')) : ?>
					<div id="aside" class="span3">
						<!-- Begin Right Sidebar -->
						<jdoc:include type="modules" name="position-7" style="well" />
						<!-- End Right Sidebar -->
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<footer class="footer" role="contentinfo">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
			<hr />
			<jdoc:include type="modules" name="footer" style="none" />
			<p class="pull-right">
				<a href="#top" id="back-top">
					<?php echo JText::_('TPL_PROTOSTAR_BACKTOTOP'); ?>
				</a>
			</p>
			<p>
				&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
			</p>
		</div>
	</footer>
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>

<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_banners
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_ROOT . '/components/com_banners/helpers/banner.php';
$baseurl = JUri::base();
$modparams = json_decode($module->params);
?>
<div class="bannergroup<?php echo $moduleclass_sfx ?>">
<?php if ($headerText) : ?>
	<?php echo $headerText; ?>
<?php endif; ?>
<?php if(JRequest::getVar('view')== 'featured'){ ?>
    <?php if($module->id == 95){?>
    <section class="banner">
        <div id="myCarousel" class="carousel slide" data-interval="<?php echo $modparams->cache_time; ?>" data-ride="carousel">
           <!-- Carousel items -->
            <div class="carousel-inner">
                <?php foreach ($list as $idx=>$item) : ?>
                <?php $imageurl = $item->params->get('imageurl');?>
                <div class="item<?php echo ($idx==0)?' active': ''; ?>">
                    <img src="<?php echo $baseurl . $imageurl;?>" alt="">
                </div>
                <?php endforeach; ?>
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
    <?php } ?>
    <?php if($module->id == 94){ ?>
    <section class="slider">
    	<div class="container">
    		<div id="myCarousel2" class="carousel slide" data-interval="<?php echo $modparams->cache_time; ?>" data-ride="carousel">
		       <!-- Carousel items -->
		        <div class="carousel-inner">
		            <?php foreach ($list as $idx=>$item) : ?>
                            <?php 
//                            $db = &JFactory::getDBO();
//                            $bid = $item->id;
//                            $sql = "SELECT `description` FROM `#__banners` WHERE '$bid'"; 
//                                    /*rlz1b_banners is your database name*/
//                            $db->setQuery($sql);
//                            $db->query();
//                            $res = $db->loadAssocList(); 
                            ?>
                            <?php $imageurl = $item->params->get('imageurl');?>
                            <?php $width = $item->params->get('width');?>
                            <?php $height = $item->params->get('height');?>
                            <div class="item<?php echo ($idx==0)?' active': ''; ?>"> 
                                <div class="col-md-5 img-left">
                                    <img class="img-responsive" src="<?php echo $baseurl . $imageurl;?>"/>
                                </div>
                                <div class="col-md-7">
                                    <h3><?php echo $item->params->get('alt'); ?></h3>
                                    <p><?php echo $item->description;//nl2br($res[0]['description']); ?></p>
                                </div>
                            </div> 
                            <?php endforeach; ?>
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
    <?php } ?>
<?php }else{ ?>
<?php foreach ($list as $item) : ?>
	<div class="banneritem">
		<?php $link = JRoute::_('index.php?option=com_banners&task=click&id=' . $item->id);?>
		<?php if ($item->type == 1) :?>
			<?php // Text based banners ?>
			<?php echo str_replace(array('{CLICKURL}', '{NAME}'), array($link, $item->name), $item->custombannercode);?>
		<?php else:?>
			<?php $imageurl = $item->params->get('imageurl');?>
			<?php $width = $item->params->get('width');?>
			<?php $height = $item->params->get('height');?>
			<?php if (BannerHelper::isImage($imageurl)) :?>
				<?php // Image based banner ?>
				<?php $alt = $item->params->get('alt');?>
				<?php $alt = $alt ? $alt : $item->name; ?>
				<?php $alt = $alt ? $alt : JText::_('MOD_BANNERS_BANNER'); ?>
				<?php if ($item->clickurl) :?>
					<?php // Wrap the banner in a link?>
					<?php $target = $params->get('target', 1);?>
					<?php if ($target == 1) :?>
						<?php // Open in a new window?>
						<a
							href="<?php echo $link; ?>" target="_blank"
							title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
							<img
								src="<?php echo $baseurl . $imageurl;?>"
								alt="<?php echo $alt;?>"
								<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
								<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
							/>
						</a>
					<?php elseif ($target == 2):?>
						<?php // Open in a popup window?>
						<a
							href="<?php echo $link;?>" onclick="window.open(this.href, '',
								'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');
								return false"
							title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
							<img
								src="<?php echo $baseurl . $imageurl;?>"
								alt="<?php echo $alt;?>"
								<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
								<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
							/>
						</a>
					<?php else :?>
						<?php // Open in parent window?>
						<a
							href="<?php echo $link;?>"
							title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
							<img
								src="<?php echo $baseurl . $imageurl;?>"
								alt="<?php echo $alt;?>"
								<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
								<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
							/>
						</a>
					<?php endif;?>
				<?php else :?>
					<?php // Just display the image if no link specified?>
					<img
						src="<?php echo $baseurl . $imageurl;?>"
						alt="<?php echo $alt;?>"
						<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
						<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
					/>
				<?php endif;?>
			<?php elseif (BannerHelper::isFlash($imageurl)) :?>
				<object
					classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
					codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
					<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
					<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
				>
					<param name="movie" value="<?php echo $imageurl;?>" />
					<embed
						src="<?php echo $imageurl;?>"
						loop="false"
						pluginspage="http://www.macromedia.com/go/get/flashplayer"
						type="application/x-shockwave-flash"
						<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
						<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
					/>
				</object>
			<?php endif;?>
		<?php endif;?>
		<div class="clr"></div>
	</div>
<?php endforeach; ?>
<?php } ?>
<?php if ($footerText) : ?>
	<div class="bannerfooter">
		<?php echo $footerText; ?>
	</div>
<?php endif; ?>
</div>


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

<div class="row">   
    <div id="slideshow-main" class="col-xs-9 col-sm-10">   
        <a rel="gallery1" href="#" class="btn_zoom fancybox"><i class="fa fa-search-plus"></i> Zoom</a>
        <ul>
            <li class="p1 active">
                <a rel="gallery1" href="img/gallery_01_lg.jpg" class="fancybox">
                    <img src="img/gallery_01_lg.jpg"  alt=""/> 
                </a>
            </li>
            <li class="p2">
                <a rel="gallery1" href="img/gallery_02_lg.jpg" class="fancybox">
                    <img src="img/gallery_02_lg.jpg"  alt=""/> 
                </a>
            </li>
            <li class="p3">
                <a rel="gallery1" href="img/gallery_03_lg.jpg"  class="fancybox">
                    <img src="img/gallery_03_lg.jpg" alt=""/> 
                </a>
            </li>
            <li class="p4">
                <a rel="gallery1" href="img/gallery_04_lg.jpg"  class="fancybox">
                    <img src="img/gallery_04_lg.jpg" alt=""/> 
                </a>
            </li>
            <li class="p5">
                <a rel="gallery1" href="img/gallery_05_lg.jpg"   class="fancybox">
                    <img src="img/gallery_05_lg.jpg" alt=""/> 
                </a>
            </li>
            <li class="p6">
                <a rel="gallery1" href="img/gallery_06_lg.jpg" class="fancybox">
                    <img src="img/gallery_06_lg.jpg" alt=""/> 
                </a>
            </li> 
        </ul>                                       
    </div><!-- slideshow-main -->
            
    <div id="slideshow-carousel"  class="col-xs-3 col-sm-2">               
          <ul id="carousel" class="jcarousel jcarousel-skin-tango">
            <li><a href="" rel="p1" ><img src="img/gallery_01_lg.jpg" alt="#"/></a></li>
            <li><a href="#" rel="p2"><img src="img/gallery_02_lg.jpg" alt="#"/></a></li>
            <li><a href="#" rel="p3"><img src="img/gallery_03_lg.jpg" alt="#"/></a></li>
            <li><a href="#" rel="p4"><img src="img/gallery_04_lg.jpg" alt="#"/></a></li>
            <li><a href="#" rel="p5"><img src="img/gallery_05_lg.jpg" alt="#"/></a></li>
            <li><a href="#" rel="p6"><img src="img/gallery_06_lg.jpg" alt="#"/></a></li> 
          </ul>
    </div><!-- slideshow-carousel -->
</div><!-- row -->


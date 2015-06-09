    
    <!-- jQuery   -->   
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/jquery.ui.datepicker-da.js"></script>
    <!--<script src="js/jquery.smartmenus.js"></script>  -->

    <!--jQuery for GALLERY detail page-->
    <script type="text/javascript" src="js/jquery.jcarousel.pack.js"></script>

    <!--jQuery  for Popup FANCYBOX -->
    <script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js"></script> 
 
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
                $('.cookies').toggle('slide');
            });

	    });
    </script>
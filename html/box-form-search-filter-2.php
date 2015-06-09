<div class="search-filter-left">
    <form> 
        <div class="each_wrapper wrap_option">
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
        </div><!-- each_wrapper -->
        <div class="each_wrapper wrap_checbox">  
            <div class="checkbox">
                <label><input type="checkbox"> Apartment</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Independent house</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Villa</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Pet allowed</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Air conditioning</label>
            </div>
            <div class="checkbox ">
                <label><input type="checkbox"> Internet access</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Swimming Pool</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Golf course</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Tennis</label>
            </div> 
        </div> <!--  wrap_checbox -->         
        <script>  
           $(function(){ 
              $('#range').noUiSlider({
                 start: [ 0, 10000 ],
                 step: 500,
                 margin: 20,
                 connect: true,
                 direction: 'ltr',
                 orientation: 'horizontal',                                  
                 // Configure tapping, or make the selected range dragable.
                 behaviour: 'tap-drag',               
                 // Full number format support.
                 format: wNumb({
                    mark: '',
                    decimals: 0
                 }),                              
                 // Support for non-linear ranges by adding intervals.
                 range: {
                    'min': 0,
                    'max': 10000
                 }
              }); 
               // ruler
                $('#range').noUiSlider_pips({
                    mode: 'values',
                    values: [1000, ,2000,3000,4000, 5000,6000,7000,8000,9000],
                    density: 10
                });

           }); 
        </script>
        <div class="each_wrapper wrap-filter-price">
            <p>Pris <span>(samlet)</span></p>
            <div class="range_price"><span class="lb_min">€0</span> <span class="lb_max">€10000</span></div> 
            <div id="range"></div> 
        </div>
        <a href="#" class="hidden-md hidden-lg btn btnSearch">Search</a>
    </form>
</div><!--search-filter-left-->
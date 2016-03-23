<?php
error_reporting(E_ALL-E_ALL);
//get current page url
global $wp;
$url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) ).'&';

$orders = array(
    'BestMatch' => 'Best Match',
    'StartTimeNewest' => 'Recently Listed',
    'EndTimeSoonest' => 'Ending Soon',
    'PricePlusShippingHighest' => 'Price Max',
    'PricePlusShippingLowest' => 'Price Min',
    'BidCountMost' => 'Highest Bids'
);
?>
<div class="search_wrap">
      <big>Buy On Ebay</big>
      <span>Search with big images and live price updates</span>
      <div class="search_widget search_box_wrapper">
           <form action="<?= $url ?>">                 
               <?php if(isset($_REQUEST['page_id'])){ ?>
                <input type="hidden" name="page_id" value="<?= $_REQUEST['page_id'] ?>" />
               <?php }?>
                <div class="keyword search_box">                
                    <div class="search_title">Keyword </div>               
                    <input type="text" name="keyword" value="<?= $_REQUEST['keyword']?$_REQUEST['keyword']:''; ?>"/>                
                </div>
               
                <!-- search result order by -->
                <div class="order search_box">
                    <div class="scontent">
                    <div class="search_title">Order</div>     
                    <select id="order" name="order">    
                    <?php
                    isset($_REQUEST['order'])?$order_key = $_REQUEST['order']:$order_key = 'BestMatch';
                    foreach ($orders as $key => $order) {
                        $key == $order_key?$selected = 'checked':$selected = '';
                        echo '<option value="' . $key . '" ' . $selected . '>' . $order . '</option>';
                    }
                    ?>
                    </select>    
                    </div>
                </div>  
                
                <!-- listing type --->
                <div class="listing-type search_box">
                    <div class="search_title heading">Listing</div>               
                    <div class="scontent">
                        <select id="listing_format" name="listing">
                            <option value="All" selected>All</option>               
                            <option value="Auction">Auction</option>               
                            <option value="FixedPrice">Buy It Now</option>                              
                        </select>
                        <?php if(!empty($_GET['listing'])){ ?>
                        <script>
                              jQuery('#listing_format').val('<?= $_GET['listing'] ?>');
                              jQuery('#order').val('<?= $_GET['order']; ?>');
                        </script>    
                        <?php } ?>
                    </div>
                </div>
                
                <!-- advance search options ------>
                <div class="advance_box">    
                    <div class="search_title heading">Advance Search Option</div>               
                    <div class="scontent">
                    <!-- seller -->    
                    <div class="seller">
                        <div class="sub-heading ">Seller </div>               
                        <div>
                            <input type="text" name="Seller" value="<?php echo isset($_REQUEST['Seller'])?$_REQUEST['Seller']:''?>" />            
                        </div>
                    </div>
                    <!-- price range --------->
                    <div class="price_range search_box_in">
                       <div class="sub-heading">Price Range</div>                              
                       <div class="input_box">
                       <input type="text" placeholder="MIN" name="MinPrice" value="<?php echo isset($_REQUEST['MinPrice'])?$_REQUEST['MinPrice']:''?>"/>
                       </div> 
                       <div class="sep">_</div>               
                       <div class="input_box">
                       <input type="text" placeholder="MAX" name="MaxPrice" value="<?php echo isset($_REQUEST['MaxPrice'])?$_REQUEST['MaxPrice']:''?>" />
                       </div>               
                    </div>
                    <!-- bid count ---> 
                    <div class="bid_count search_box_in">
                       <div class="sub-heading">Bid Count </div>               
                       <div class="input_box">
                       <input placeholder="MIN" type="text" name="MinBids" value="<?php echo isset($_REQUEST['MinBids'])?$_REQUEST['MinBids']:''?>" />
                       </div> 
                       <div class="sep">_</div>               
                       <div class="input_box">
                       <input placeholder="MAX" type="text" name="MaxBids" value="<?php echo isset($_REQUEST['MaxBids'])?$_REQUEST['MaxBids']:''?>" />
                       </div>               
                    </div> 
                    <!-- distance --->
                    <div class="distance search_box_in">
                       <div class="sub-heading">Distance </div>
                        <ul>
                           <li>
                            <?php if (!isset($_REQUEST['distance']) || (isset($_REQUEST['distance']) && $_REQUEST['distance'] == 'anywhere')) { ?>
                               <input type="radio" name="distance" value="anywhere" checked/>
                           <?php } else { ?>
                                <input type="radio" name="distance" value="anywhere" />
                            <?php } ?>                        
                            anywhere
                           </li>  
                           <li>                      
                               <input type="radio" name="distance" value="range" <?php echo (isset($_REQUEST['distance'])&& $_REQUEST['distance']=='range')?'checked':''?>/> within 
                                <?php $dist=array(10,20,50,100,200,500,750,1000,2000);?>
                                <select name="distance_miles">
                                    <?php  foreach ($dist as $miles){
                                        echo'<option value="'.$miles.'">'.$miles.' miles</option>';
                                    }?>                            
                                </select> of
                                <input type="text" value="<?= $_GET['buyerPostalCode'] ?>" name="buyerPostalCode" width="10"/>
                           </li>                    
                       </ul>           
                    </div><!-- distance -->  
                    </div>
                </div><!-- advance search options ------>
               
                <div class="submit-button">
                    <input type="submit" value="search" class="btn_submit"/>
                </div>
               
                <div class="clear"></div>
        </form>     
    </div><!-- search_widget ---->  
  </div><!-- search wrapper ---->  
<div class="clear"></div>
<script>
    jQuery('.advance_box .search_title').click(function(){
        jQuery('.advance_box').toggleClass('advance_box_hover');
    });
</script>

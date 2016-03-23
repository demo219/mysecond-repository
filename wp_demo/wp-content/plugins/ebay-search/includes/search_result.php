<?php 
    $keyword = '';
    $xmlfilter='';
    $verb = 'findItemsAdvanced';
    $app_version = "1.3.0";
    
    //keyword
    if(!isset ($_REQUEST['keyword'])){
        $keyword=$default_search_keyword;    
        $url.='keyword='.$default_search_keyword;
    }else{
        $keyword=urldecode($_REQUEST['keyword']);    
        $url.='keyword='.$_REQUEST['keyword'];
    }
    
    //listing
    if(isset($_REQUEST['listing'])){
       if("Auction" == $_REQUEST['listing']){
           $listing="<value>Auction</value>";
           $url.='&listing='.$_REQUEST['listing'];
       }elseif("FixedPrice" == $_REQUEST['listing']){
           $listing.='<value>FixedPrice</value>';
           $url.='&listing='.$_REQUEST['listing'];
       }else{
           $listing.='<value>All</value>';
       }
    }

    if(empty($listing)){
        $listing='<value>All</value>';
    }

    //order
    if(isset($_REQUEST['order']) && $_REQUEST['order']=='BidCountMost'){
        unset($_REQUEST['listing_fixedprice']);
        $listing="<value>Auction</value>";
    }


    //item filter
    $xmlfilter.="<itemFilter>
    <name>ListingType</name>".$listing."
    </itemFilter>";

    //price
    if(isset($_REQUEST['MinPrice']) && !empty($_REQUEST['MinPrice'])){
        $xmlfilter.="<itemFilter>
        <name>MinPrice</name>   
        <value>".$_REQUEST['MinPrice']."</value></itemFilter>";
        $url.='&MinPrice='.$_REQUEST['MinPrice'];
    }

    //distance
    if(isset($_REQUEST['distance']) && $_REQUEST['distance']=='range' && isset($_REQUEST['buyerPostalCode'])){
        $xmlfilter.='<buyerPostalCode>'.$_REQUEST['buyerPostalCode'].'</buyerPostalCode>';
        $xmlfilter.="<itemFilter><name>MaxDistance</name><value>".$_REQUEST['distance_miles']."</value></itemFilter>";
        $url.='&buyerPostalCode='.$_REQUEST['buyerPostalCode'].'&distance=range&distance_miles='.$_REQUEST['distance_miles'];
    }

    //max-price
    if(isset($_REQUEST['MaxPrice']) && !empty($_REQUEST['MaxPrice'])){
        $xmlfilter.="<itemFilter>
        <name>MaxPrice</name>   
        <value>".$_REQUEST['MaxPrice']."</value></itemFilter>";
        $url.='&MaxPrice='.$_REQUEST['MaxPrice'];
    }

    //max-bids & min-bids
    if(isset($_REQUEST['MinBids']) && !empty($_REQUEST['MinBids'])){
        $xmlfilter.="<itemFilter>
        <name>MinBids</name>   
        <value>".$_REQUEST['MinBids']."</value></itemFilter>";
        $url.='&MinBids='.$_REQUEST['MinBids'];
    }
    if(isset($_REQUEST['MaxBids']) && !empty($_REQUEST['MaxBids'])){
        $xmlfilter.="<itemFilter>
        <name>MaxBids</name>
        <value>".$_REQUEST['MaxBids']."</value></itemFilter>";
        $url.='&MaxBids='.$_REQUEST['MaxBids'];
    }
    
    //seller
    if(isset($_REQUEST['Seller']) && !empty($_REQUEST['Seller'])){
        $xmlfilter.="<itemFilter>
        <name>Seller</name>
        <value>".$_REQUEST['Seller']."</value></itemFilter>";
        $url.='&Seller='.$_REQUEST['Seller'];
    }
    
    //order
    if(isset($_REQUEST['order']) && !empty($_REQUEST['order'])){
        $xmlfilter.="<sortOrder>".$_REQUEST['order']."</sortOrder>";
        $url.='&order='.$_REQUEST['order'];
    }
    
    //category
    if(isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])){
        $url.='&category_id='.$_REQUEST['category_id'];
    }
    if (isset($_REQUEST['ebay_page'])){
        $page=$_REQUEST['ebay_page'];
    }

    $category_xml='';
    if(isset ($_REQUEST['category_id']))
    {
        $category_xml="<categoryId>".$_REQUEST['category_id']."</categoryId>";
    }
    
    //build header
    $headers = buildEbayHeaders($appID, $app_version, $siteID, $verb);

    //build request body
    $requestXmlBody = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $requestXmlBody .= "<findItemsAdvancedRequest xmlns=\"http://www.ebay.com/marketplace/search/v1/services\">\n";
    $requestXmlBody .= "<keywords>";
    $requestXmlBody .= $keyword;
    $requestXmlBody .= "</keywords>\n";
    $requestXmlBody .=$category_xml;
    $requestXmlBody .= $xmlfilter;
    $requestXmlBody .= "<paginationInput><entriesPerPage>40</entriesPerPage>\n
    <pageNumber>".$page."</pageNumber>\n 
    </paginationInput>\n";
    $requestXmlBody .= "<outputSelector>PictureURLLarge</outputSelector>  
    <outputSelector>PictureURLSuperSize</outputSelector><outputSelector>CategoryHistogram</outputSelector><outputSelector>ConditionHistogram</outputSelector>";
    $requestXmlBody .= "</findItemsAdvancedRequest>";

    //send request 
    $responseXml = sendHttpRequest($requestXmlBody, $serverUrl, $headers);
    
    //response to array
    $responseDoc = simplexml_load_string($responseXml);
    $data_arr = objectsIntoArray($responseDoc);

    //success
    if ($data_arr['ack']!='Success'){
        echo "Try again";
    } else {   
    if($data_arr['paginationOutput']['pageNumber']==$page){ ?>
           
            <div class="cat_count">
                <h1>Founds <?= number_format($data_arr['paginationOutput']['totalEntries']) ?> Results</h1>
            </div>    
                
            <?php if(is_array($data_arr['categoryHistogramContainer']['categoryHistogram'][0])){ ?>

            <div class="content category_list">

            <?php foreach ($data_arr['categoryHistogramContainer']['categoryHistogram'] as $cat_histro){ ?>

                <?php if(is_array($cat_histro)){  ?>
                
                    <div class="cat_list">
                        <a href="<?= $url.'&category_id='.$cat_histro['categoryId'] ?>">
                            <?= $cat_histro['categoryName'].'('.$cat_histro['count'].')' ?>
                        </a>
                    </div>
                    
                <?php } ?>

            <?php } ?>

            </div>

    <?php } else { 
        
        //if child categories exists
        if(is_array($data_arr['categoryHistogramContainer']['categoryHistogram']['childCategoryHistogram'][0])){  ?>          
        
        <!-- category list -->
        <div class="content category_list">
        <?php foreach ($data_arr['categoryHistogramContainer']['categoryHistogram']['childCategoryHistogram'] as $cat_histro){ ?>                    
            <div class="cat_list">
                <a href="<?= $url.'&category_id='.$cat_histro['categoryId'] ?>">
                    <?= $cat_histro['categoryName'].'('.$cat_histro['count'].')' ?>
                </a>
            </div><!-- category -->
        <?php }//foreach category in histogram ?>
        </div><!-- category list -->
                
        <?php }//if child categories exists
    }//if success ?>
    
    
    <!-------------- product container ------------------------->
    <div class="content" id="container">
    <?php 
    if(is_array($data_arr['searchResult']['item'])){
        foreach ($data_arr['searchResult']['item'] as $product){
            if($data_arr['searchResult']['@attributes']['count']==1){
                $product=$data_arr['searchResult']['item'];
            }//if only one product found
            ?>

            <div class="category">
                <a target="_blank" class="prod_image" href="<?php echo $product['viewItemURL'] ?>">     
                    <!-- product image --->
                    <?php
                    if (empty($product['pictureURLLarge'])) {
                        $image = $product['galleryURL'];
                    } else {
                        $image = $product['pictureURLLarge'];
                    }   
                    ?>
                    <img src="<?php echo $image; ?>" alt="" title=""/>          
                </a>

                <!-- product title -->
                <div class="title">
                   <a target="_blank" href="<?php echo $product['viewItemURL'] ?>">
                        <?php echo $product['title'] ?>
                    </a>
                </div>

                <!-- product detail -->
                <div class="detail">
                    
                    <!-- price -->
                    <span class="price">
                        <?php  echo $curr_code.number_format($product['sellingStatus']['currentPrice'],2); ?>
                    </span>
                    
                    <!-- bid count -->
                    <?php if(isset($product['sellingStatus']['bidCount'])){?>    
                        <span class="bids">
                            <?php echo $product['sellingStatus']['bidCount'];?> Bids
                        </span>
                    <?php }?>

                    <!-- time left -->
                    <?php $time_left=$product['listingInfo']['endTime'];  
                          $time_left=strtotime($time_left); ?>
                    
                    <span id="<?= $time_left ?>" time="<?= $time_left ?>" class="count-down"></span>
                    
                    <!-- ebay link -->
                    <a style="" id="by_<?php echo $time_left; ?>" target="_blank" class="buy_now" href="<?php echo $product['viewItemURL'] ?>"></a>

                </div><!-- detail -->

            </div><!-- product -->

        <?php
        if($data_arr['searchResult']['@attributes']['count']==1){
            exit;
        }        
    }//foreach products    
    
    }else{ ?>
       <div class="content"><b>No Result found</b></div>
    <?php }//success with 0 items ?>
    
    <br class="clear" />
    
    <?php }else{ ?>
        <div class='content'>No result founds</div>
    <?php }//success with 0 items
    } ?>

    <!-- pagination -->
    <div id="page-nav">         
        <a href="<?php echo  str_replace(" ", '+', $url); ?>&ebay_page=<?php echo $page+1; ?>"></a>    
    </div>
</div><!-- container -->        


<script type="text/javascript">
        
   $.noConflict();
    
    jQuery( document ).ready(function( $ ) {
 
    $(".count-down").kkcountdown({
        dayText		: 'd ',
        daysText 	: ' days ',
        hoursText	: ':',
        minutesText	: ':',
        secondsText	: '',
        displayZeroDays : false,                    
        addClass	: 'shadow',
        textAfterCount:'Sold'                    
    });
    
    var $container = $('#container');
 
    $container.imagesLoaded(function(){
      $container.masonry({
        itemSelector: '.category',
        cornerStampSelector: '.search_widget',
        isAnimated: false,
        isResizable: true,
        isFitWidth: true        
      });
    });
    
    $('.category').bind({
        hover: function (){
        $(this).addClass("hover");        
    },
    mouseleave:function () {        
        $(this).removeClass("hover");  }
    });                
    
    
    //infinity scroll jQuery
    $container.infinitescroll({
      navSelector  : '#page-nav',    // selector for the paged navigation
      nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
      itemSelector : '.category',     // selector for all items you'll retrieve      
      loading: {
          finishedMsg: 'No more pages to load.',
          img: '<?=  plugins_url('ebay-search/images/loading.gif'); ?>'
        }
      },
      
    // trigger Masonry as a callback
    function( newElements ) {
        // hide new items while they are loading
        var $newElems = $( newElements ).css({ opacity: 0 });
        
        // ensure that images load before adding to masonry layout
        $newElems.imagesLoaded(function(){
          // show elems now they're ready
          $newElems.animate({ opacity: 1 });
          $container.masonry( 'appended', $newElems, true );
        });
        
        $('.category').bind({
            hover: function (){
            $(this).addClass("hover");        
        },
        mouseleave:function () {        
            $(this).removeClass("hover");  }
        });                  
        
        $('.shadow').remove();     
        
        $(".count-down").kkcountdown({
                   dayText		: 'd ',
                    daysText 	: ' days ',
                    hoursText	: ':',
                    minutesText	: ':',
                    secondsText	: '',
                    displayZeroDays : false,                    
                    addClass	: 'shadow',
                    textAfterCount:'Sold'                    
        });       
                
      }//end of callback function 
          
    );//infinity scroll
    
    });//document ready
  
</script>

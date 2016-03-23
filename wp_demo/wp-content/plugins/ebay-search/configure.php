<?php
$options = get_option('ebay_options');
$customeId = $options['ebay_customeid'];
$geoTargeting = $options['ebay_geotargeting'];
$networkId = $options['ebay_networkid'];
$trackingId = $options['ebay_trackingid'];
$devID =  $options['ebay_devid'];
$appID = $options['ebay_appid'];
$certID = $options['ebay_certid'];
$default_search_keyword = $options['ebay_default_search_keyword'];
$siteID = $options['ebay_siteid'];
$page = 1;
$serverUrl = 'http://svcs.ebay.com/services/search/FindingService/v1';

$currencies = array(
    "EBAY-US"   => "$",
    "EBAY-DE"   => "&euro;",
    "EBAY-AT"   => "AUD",
    "EBAY-FR"   => "GBP",
    "EBAY-IE"   => "&#163;",
    "EBAY-IN"   => "&#8377;",
    "EBAY-PH"   => "P",
    "EBAY-AU"   => "&#8364;",
    "EBAY-CH"   => "&#8355;",
    "EBAY-ENCA" => "$",
    "EBAY-ES"   => "&#128;",
    //"EBAY-FR" 	=> "&#128;",
    "EBAY-FRBE" => "&#128;",
    "EBAY-FRCA" => "$",
    "EBAY-GB"   => "&#163;",
    "EBAY-HK"   => "$",
    "EBAY-IT"   => "&#128;",
    "EBAY-MOTOR"=> "$",
    "EBAY-MY"   => "MYR",
    "EBAY-NL"   => "ANG", 
    "EBAY-NLBE" => "EUR",
    "EBAY-PH" 	=> "&#8369;",
    "EBAY-PL" 	=> "Z:",
    "EBAY-SG"   => "$",
);

$curr_code = $currencies[$siteID];

?>
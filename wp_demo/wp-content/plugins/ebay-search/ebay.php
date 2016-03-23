<?php
/*
Plugin Name: eBay search
Plugin URI: http://www.i-quall.com
Description: A wordpress plugin for search items on ebay.Add [ebay] shortcode to any cms page to display products from ebay.
Version: 1.0
Author: Developers
Author URI: http://www.i-quall.com
*/

add_action( 'wp_enqueue_scripts', 'addEbayStyle' ); 

function addEbayStyle() {
    wp_register_style( 'ebay-style', plugins_url('css/stylesheet.css', __FILE__) );
    wp_enqueue_style( 'ebay-style' );
    wp_register_style( 'ebay-responsive-style', plugins_url('css/responsive.css', __FILE__) );
    wp_enqueue_style( 'ebay-responsive' );
    //jquery library
    wp_register_script( 'ebay_jquery', plugins_url('js/jquery-1.7.2.min.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'ebay_jquery' );
    //infinity scroll
    wp_register_script( 'ebay_infinity_scroll', plugins_url('js/jquery.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'ebay_infinity_scroll' );
    //masnory block 
    wp_register_script( 'ebay_masnory', plugins_url('js/jquery_1.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'ebay_masnory' );
    //timer count down
    wp_register_script( 'ebay_countdown', plugins_url('js/countdown.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'ebay_countdown' );
}
 
function displayProducts() { 
    require_once('configure.php');
    require_once('includes/ebay_functions.php');
    require_once('includes/search_form.php');
    require_once('includes/search_result.php');
}//displayForm

add_shortcode('ebay', 'displayProducts');


/*------------------------------------------
 *          Admin options
 * ------------------------------------------
 */
add_action('admin_menu', 'ebay_admin_add_page');

function ebay_admin_add_page() {
    add_options_page('eBay Setting', 'eBay API', 'manage_options', 'ebay', 'ebay_options_page');
}

function ebay_options_page() {
     require_once('includes/ebay_options.php');
} 

add_action('admin_init', 'plugin_admin_init');

function plugin_admin_init(){
    register_setting( 'ebay_options', 'ebay_options', 'ebay_options_validate' );
    
    //API basic options
    add_settings_section('ebay_main', 'eBay Basic API Settings', 'plugin_section_text', 'ebay');
    add_settings_field('ebay_devid', 'eBay devID', 'ebay_devid', 'ebay', 'ebay_main');
    add_settings_field('ebay_appid', 'eBay appID', 'ebay_appid', 'ebay', 'ebay_main');
    add_settings_field('ebay_certid', 'eBay certID', 'ebay_certid', 'ebay', 'ebay_main');
    add_settings_field('ebay_default_search_keyword', 'Default Search Keyword', 'ebay_default_keyword', 'ebay', 'ebay_main');
    add_settings_field('ebay_siteid', 'eBay siteID', 'ebay_siteid', 'ebay', 'ebay_main');
    
    //Affiliate
    add_settings_section('ebay_affiliate', 'eBay Affiliate Settings', '', 'ebay');
    add_settings_field('ebay_customeid', 'eBay customeID', 'ebay_customeid', 'ebay', 'ebay_affiliate');
    add_settings_field('ebay_geotargeting', 'eBay geotargeting', 'ebay_geotargeting', 'ebay', 'ebay_affiliate');
    add_settings_field('ebay_networkId', 'eBay networkID', 'ebay_networkid', 'ebay', 'ebay_affiliate');
    add_settings_field('ebay_trackingId', 'eBay trackingID', 'ebay_trackingid', 'ebay', 'ebay_affiliate');
    
}

function plugin_section_text() {
    echo '';
}

function ebay_devid(){
    $options = get_option('ebay_options');
    echo "<input class='regular-text ltr' id='ebay_devid' name='ebay_options[ebay_devid]' type='text' value='{$options['ebay_devid']}' />";
} 

function ebay_appid(){
    $options = get_option('ebay_options');
    echo "<input class='regular-text ltr' id='ebay_appid' name='ebay_options[ebay_appid]' type='text' value='{$options['ebay_appid']}' />";
}

function ebay_certid(){
    $options = get_option('ebay_options');
    echo "<input class='regular-text ltr' id='ebay_certid' name='ebay_options[ebay_certid]' type='text' value='{$options['ebay_certid']}' />";
}

function ebay_default_keyword(){
    $options = get_option('ebay_options');
    echo "<input class='regular-text ltr' id='ebay_default_search_keyword' name='ebay_options[ebay_default_search_keyword]' type='text' value='{$options['ebay_default_search_keyword']}' />";
}

function ebay_siteid(){
    $options = get_option('ebay_options');
    ?>
    <select id='ebay_siteid' name='ebay_options[ebay_siteid]'>
        <option>EBAY-AT</option>
        <option>EBAY-MY</option>
        <option>EBAY-AU</option>
        <option>EBAY-CH</option>
        <option>EBAY-DE</option>
        <option>EBAY-ENCA</option>
        <option>EBAY-ES</option>
        <option>EBAY-FR</option>
        <option>EBAY-FRBE</option>
        <option>EBAY-FRCA</option>
        <option>EBAY-GB</option>
        <option>EBAY-HK</option>
        <option>EBAY-IE</option>
        <option>EBAY-IN</option>
        <option>EBAY-IT</option>
        <option>EBAY-MOTOR</option>
        <option>EBAY-MY</option>
        <option>EBAY-NL</option>
        <option>EBAY-NLBE</option>
        <option>EBAY-PH</option>
        <option>EBAY-PL</option>
        <option>EBAY-SG</option>
        <option>EBAY-US</option>
    </select>
    <script>
        jQuery('#ebay_siteid').val('<?php echo $options['ebay_siteid']; ?>');
    </script>
<?php
}

function ebay_customeid(){
    $options = get_option('ebay_options');
    echo "<input  class='regular-text ltr' id='ebay_customeid' name='ebay_options[ebay_customeid]' type='text' value='{$options['ebay_customeid']}' />";
}

function ebay_geotargeting(){
    $options = get_option('ebay_options');
    echo "<input  class='regular-text ltr' id='ebay_geotargeting' name='ebay_options[ebay_geotargeting]' type='text' value='{$options['ebay_geotargeting']}' />";
}

function ebay_networkid(){
    $options = get_option('ebay_options');
    echo "<input  class='regular-text ltr' id='ebay_networkid' name='ebay_options[ebay_networkid]' type='text' value='{$options['ebay_networkid']}' />";
}

function ebay_trackingid(){
    $options = get_option('ebay_options');
    echo "<input class='regular-text ltr' id='ebay_trackingid' name='ebay_options[ebay_trackingid]' type='text' value='{$options['ebay_trackingid']}' />";
}

function ebay_options_validate($input){
    return $input;
}

register_uninstall_hook(__FILE__, 'ebay_uninstall_hook');

function ebay_uninstall_hook() { delete_option('ebay_options'); } 

?>

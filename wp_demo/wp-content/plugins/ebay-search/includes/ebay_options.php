<div class="wrap">
<h2>eBay API settings<br /><small>Options relating to ebay API request.</small></h2>


<form action="options.php" method="post">
    <?php settings_fields('ebay_options'); ?>
    <?php do_settings_sections('ebay'); ?>
    <br />
    <input name="Submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form>

</div>
 


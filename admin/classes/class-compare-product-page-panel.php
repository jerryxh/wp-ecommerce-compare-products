<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Product Page Panel
 *
 * Table Of Contents
 *
 * panel_manager()
 */
class WPEC_Compare_Product_Page_Panel{
	function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Compare Single Product Page Settings Successfully saved.', 'wpec_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Compare Single Product Page Settings Successfully reseted.', 'wpec_cp').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="wpec_compare_product_panel_container">
    	<div id="wpec_compare_product_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
                <li><a href="#single-product-page-settings" class="current"><?php _e('Single Product Page Settings', 'wpec_cp'); ?></a> | </li>
        		<li><a href="#single-product-page-button"><?php _e('Single Product Page Compare Button', 'wpec_cp'); ?></a> | </li>
                <li><a href="#single-product-page-view-compare"><?php _e('View Compare', 'wpec_cp'); ?></a> | </li>
				<li><a href="#compare-feature-fields"><?php _e('Single Product Page Compare Feature Fields', 'wpec_cp'); ?></a></li>
			</ul>
            <br class="clear">
            <div class="section" id="single-product-page-settings">
            	<?php WPEC_Compare_Product_Page_Settings::panel_page(); ?>
            </div>
            
            <div class="section" id="single-product-page-button">
                <?php WPEC_Compare_Product_Page_Button_Style::panel_page(); ?>
            </div>
            
            <div class="section" id="single-product-page-view-compare">
                <?php WPEC_Compare_Product_Page_View_Compare_Style::panel_page(); ?>
            </div>
            
            <div class="section" id="compare-feature-fields">
                <?php WPEC_Compare_Product_Page_Tab::panel_page(); ?>
            </div>
		</div>
        <div id="wpec_compare_product_upgrade_area"><?php echo WPEC_Compare_Functions::plugin_pro_notice(); ?></div>
	</div>
        <div style="clear:both;"></div>
            <p class="submit">
                <input type="submit" value="<?php _e('Save changes', 'wpec_cp'); ?>" class="button-primary" name="bt_save_settings" id="bt_save_settings">
				<input type="submit" name="bt_reset_settings" id="bt_reset_settings" class="button" value="<?php _e('Reset Settings', 'wpec_cp'); ?>"  />
        		<input type="hidden" id="last_tab" name="subtab" />
            </p>
    </form>
	<?php
	}
}
?>
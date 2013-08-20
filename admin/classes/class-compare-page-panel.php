<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Comparison Table Panel
 *
 * Table Of Contents
 *
 * panel_manager()
 */
class WPEC_Compare_Page_Panel
{
	public static function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Comparison Table Style Successfully saved.', 'wpec_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Comparison Table Style Successfully reseted.', 'wpec_cp').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="wpec_compare_product_panel_container">
    	<div id="wpec_compare_product_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
            	<li><a href="#table-global-settings" class="current"><?php _e('Global Settings', 'wpec_cp'); ?></a> | </li>
                <li><a href="#comparison-page-style"><?php _e('Page Style', 'wpec_cp'); ?></a> | </li>
            	<li><a href="#table-style"><?php _e('Table Style', 'wpec_cp'); ?></a> | </li>
                <li><a href="#table-content-style"><?php _e('Table Content Style', 'wpec_cp'); ?></a> | </li>
                <li><a href="#product-prices-style"><?php _e('Product Prices', 'wpec_cp'); ?></a> | </li>
                <li><a href="#addtocart-style"><?php _e('Add to Cart', 'wpec_cp'); ?></a> | </li>
                <li><a href="#checkout-style"><?php _e('Checkout Link', 'wpec_cp'); ?></a> | </li>
                <li><a href="#print-page"><?php _e('Print Page', 'wpec_cp'); ?></a> | </li>
                <li><a href="#close-window-button"><?php _e('Close Window Button', 'wpec_cp'); ?></a></li>
			</ul>
            <br class="clear">
            <div class="section" id="table-global-settings">
            	<?php WPEC_Compare_Comparison_Page_Global_Settings::panel_page(); ?>
            </div>
            
            <div class="section" id="comparison-page-style">
            	<?php WPEC_Compare_Page_Style::panel_page(); ?>
            </div>
            
            <div class="section" id="table-style">
            	<div class="pro_feature_fields">
            	<?php WPEC_Compare_Table_Row_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="table-content-style">
            	<div class="pro_feature_fields">
				<?php WPEC_Compare_Table_Content_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="product-prices-style">
            	<div class="pro_feature_fields">
				<?php WPEC_Compare_Price_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="addtocart-style">
            	<div class="pro_feature_fields">
				<?php WPEC_Compare_AddToCart_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="checkout-style">
            	<div class="pro_feature_fields">
				<?php WPEC_Compare_ViewCart_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="print-page">
            	<div class="pro_feature_fields">
				<?php WPEC_Compare_Print_Message_Style::panel_page(); ?>
                <?php WPEC_Compare_Print_Button_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="close-window-button">
                <div class="pro_feature_fields">
				<?php WPEC_Compare_Close_Window_Button_Style::panel_page(); ?>
                </div>
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
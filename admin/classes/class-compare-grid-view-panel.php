<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Grid View Panel
 *
 * Table Of Contents
 *
 * panel_manager()
 */
class WPEC_Compare_Grid_View_Panel
{
	public static function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Product Page Style Successfully saved.', 'wpec_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Product Page Style Successfully reseted.', 'wpec_cp').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="wpec_compare_product_panel_container">
    	<div id="wpec_compare_product_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
                <li><a href="#global-settings" class="current"><?php _e('Product Page Settings', 'wpec_cp'); ?></a> | </li>
                <li><a href="#product-page-button"><?php _e('Product Page Button', 'wpec_cp'); ?></a> | </li>
                <li><a href="#product-page-view-compare"><?php _e('View Compare', 'wpec_cp'); ?></a></li>
			</ul>
            <br class="clear">
            <div class="section" id="global-settings">
            	<?php WPEC_Compare_Grid_View_Settings::panel_page(); ?>
            </div>
            
            <div class="section" id="product-page-button">
            	<div class="pro_feature_fields">
                <?php WPEC_Compare_Grid_View_Button_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="product-page-view-compare">
            	<div class="pro_feature_fields">
                <?php WPEC_Compare_Grid_View_View_Compare_Style::panel_page(); ?>
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
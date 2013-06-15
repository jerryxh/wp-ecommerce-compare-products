<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Product Page Settings Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Product_Page_Tab{
	function get_settings_default() {
		$default_settings = array(			
			'disable_compare_featured_tab'	=> 0,
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		$wpec_compare_product_page_tab = get_option('wpec_compare_product_page_tab');
		if ( !is_array($wpec_compare_product_page_tab) ) $wpec_compare_product_page_tab = array();
		
		$default_settings = WPEC_Compare_Product_Page_Tab::get_settings_default();
		
		$wpec_compare_product_page_tab = array_merge($default_settings, $wpec_compare_product_page_tab);
		
		if ($reset) {
			update_option('wpec_compare_product_page_tab', $default_settings);
		} else {
			update_option('wpec_compare_product_page_tab', $wpec_compare_product_page_tab);
		}
				
	}
	
	function get_settings() {
		global $wpec_compare_product_page_tab;
		$wpec_compare_product_page_tab = get_option('wpec_compare_product_page_tab');
		if ( !is_array($wpec_compare_product_page_tab) ) $wpec_compare_product_page_tab = array();
		$default_settings = WPEC_Compare_Product_Page_Tab::get_settings_default();
		
		$wpec_compare_product_page_tab = array_merge($default_settings, $wpec_compare_product_page_tab);
		
		foreach ($wpec_compare_product_page_tab as $key => $value) {
			if (trim($value) == '') $wpec_compare_product_page_tab[$key] = $default_settings[$key];
			else $wpec_compare_product_page_tab[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $wpec_compare_product_page_tab;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$wpec_compare_product_page_tab = $_REQUEST['wpec_compare_product_page_tab'];
			
			if ( !isset($wpec_compare_product_page_tab['disable_compare_featured_tab']) ) $wpec_compare_product_page_tab['disable_compare_featured_tab'] = 1;
						
			update_option('wpec_compare_product_page_tab', $wpec_compare_product_page_tab);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Product_Page_Tab::set_settings_default(true);
		}
		
		$wpec_compare_product_page_tab = get_option('wpec_compare_product_page_tab');
		$default_settings = WPEC_Compare_Product_Page_Tab::get_settings_default();
		if ( !is_array($wpec_compare_product_page_tab) ) $wpec_compare_product_page_tab = $default_settings;
		else $wpec_compare_product_page_tab = array_merge($default_settings, $wpec_compare_product_page_tab);
		
		extract($wpec_compare_product_page_tab);
		
		?>
        <h3><?php _e('Activate / Deactivate', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="disable_compare_featured_tab"><?php _e('Compare Features Fields', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="wpec_compare_product_page_tab[disable_compare_featured_tab]" id="disable_compare_featured_tab" value="0" <?php checked ( $disable_compare_featured_tab, 0); ?> /> <?php _e('Check to activate the Compare features fields on Single Product pages.', 'wpec_cp'); ?></label></td>
                </tr>
            </tbody>
        </table>
        
        <h3><?php _e('Compare Feature Fields Function', 'wpec_cp'); ?></h3>
        <table class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for=""><?php _e('Show Compare Featured fields','wpec_cp'); ?></label></th>
                    <td class="forminp"><?php _e('To auto show and position the Product title and a list of the Compare features in your Themes single product pages use this function','wpec_cp'); ?> <br /><code>&lt;?php if(function_exists('wpec_show_compare_fields')) echo wpec_show_compare_fields(); ?&gt;</code>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
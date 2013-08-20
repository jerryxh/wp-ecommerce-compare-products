<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Grid View Settings Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Grid_View_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'grid_view_button_position'		=> 'above',
			'grid_view_button_below_padding'=> 10,
			'grid_view_button_above_padding'=> 10,
			'disable_grid_view_compare'		=> 0,
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$wpec_compare_grid_view_settings = get_option('wpec_compare_grid_view_settings');
		if ( !is_array($wpec_compare_grid_view_settings) ) $wpec_compare_grid_view_settings = array();
		
		$default_settings = WPEC_Compare_Grid_View_Settings::get_settings_default();
		
		$wpec_compare_grid_view_settings = array_merge($default_settings, $wpec_compare_grid_view_settings);
		
		if ($reset) {
			update_option('wpec_compare_grid_view_settings', $default_settings);
		} else {
			update_option('wpec_compare_grid_view_settings', $wpec_compare_grid_view_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpec_compare_grid_view_settings;
		$wpec_compare_grid_view_settings = get_option('wpec_compare_grid_view_settings');
		if ( !is_array($wpec_compare_grid_view_settings) ) $wpec_compare_grid_view_settings = array();
		$default_settings = WPEC_Compare_Grid_View_Settings::get_settings_default();
		
		$wpec_compare_grid_view_settings = array_merge($default_settings, $wpec_compare_grid_view_settings);
		
		foreach ($wpec_compare_grid_view_settings as $key => $value) {
			if (trim($value) == '') $wpec_compare_grid_view_settings[$key] = $default_settings[$key];
			else $wpec_compare_grid_view_settings[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $wpec_compare_grid_view_settings;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$wpec_compare_grid_view_settings = $_REQUEST['wpec_compare_grid_view_settings'];
			
			if ( !isset($wpec_compare_grid_view_settings['disable_grid_view_compare']) ) $wpec_compare_grid_view_settings['disable_grid_view_compare'] = 0;
						
			update_option('wpec_compare_grid_view_settings', $wpec_compare_grid_view_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Grid_View_Settings::set_settings_default(true);
		}
		
		$wpec_compare_grid_view_settings = get_option('wpec_compare_grid_view_settings');
		$default_settings = WPEC_Compare_Grid_View_Settings::get_settings_default();
		if ( !is_array($wpec_compare_grid_view_settings) ) $wpec_compare_grid_view_settings = $default_settings;
		else $wpec_compare_grid_view_settings = array_merge($default_settings, $wpec_compare_grid_view_settings);
		
		extract($wpec_compare_grid_view_settings);
		
		?>
        <h3><?php _e('Product Page Compare Button/Link Position', 'wpec_cp'); ?></h3>
        <p><?php _e('Configure how the Compare feature shows on the Default, Listing and Grid View layouts on your themes Product Page, Product Category and Product Tag Pages.', 'wpec_cp'); ?></p>
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label><?php _e('Button/Link Position relative to Add to Cart Button','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<div style="width:160px; float:left;"><label><input type="radio" name="wpec_compare_grid_view_settings[grid_view_button_position]" value="above" <?php if ( $grid_view_button_position == 'above') { echo 'checked="checked"';} ?> /> <?php _e('Above','wpec_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="grid_view_button_above_padding"><?php _e('Padding Bottom','wpec_cp'); ?></label></div> <input type="text" name="wpec_compare_grid_view_settings[grid_view_button_above_padding]" id="grid_view_button_above_padding" value="<?php esc_attr_e( stripslashes( $grid_view_button_above_padding ) ); ?>" size="3" /> px
                    	<div style="clear:both;"></div>
                    	<div style="width:160px; float:left;"><label><input type="radio" name="wpec_compare_grid_view_settings[grid_view_button_position]" value="below" <?php if ( $grid_view_button_position == 'below') { echo 'checked="checked"';} ?> /> <?php _e('Below','wpec_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="grid_view_button_below_padding"><?php _e('Padding Top','wpec_cp'); ?></label></div> <input type="text" name="wpec_compare_grid_view_settings[grid_view_button_below_padding]" id="grid_view_button_below_padding" value="<?php esc_attr_e( stripslashes( $grid_view_button_below_padding ) ); ?>" size="3" /> px
                        <div style="clear:both;"></div>
                    	<?php _e("Change position if Compare Button/Link does not show on Product Page.", 'wpec_cp'); ?>
                    </td>
                </tr>
			</tbody>
		</table>
        
        <h3><?php _e('Activate / Deactivate', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="disable_grid_view_compare"><?php _e('Product Page Compare', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="wpec_compare_grid_view_settings[disable_grid_view_compare]" id="disable_grid_view_compare" value="1" <?php if ( $disable_grid_view_compare == 1) { echo 'checked="checked"';} ?> /> <?php _e('Check to deactivate the Compare feature on Product Page Default, Listing or Grid View layout.', 'wpec_cp'); ?></label></td>
                </tr>
            </tbody>
        </table>
	<?php
	}
}
?>
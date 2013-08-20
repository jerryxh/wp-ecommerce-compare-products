<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Comparison Page Global Settings
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Comparison_Page_Global_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'open_compare_type'				=> 'new_page',
			
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$wpec_compare_comparison_page_global_settings = get_option('wpec_compare_comparison_page_global_settings');
		if ( !is_array($wpec_compare_comparison_page_global_settings) ) $wpec_compare_comparison_page_global_settings = array();
		
		$default_settings = WPEC_Compare_Comparison_Page_Global_Settings::get_settings_default();
		
		$wpec_compare_comparison_page_global_settings = array_merge($default_settings, $wpec_compare_comparison_page_global_settings);
		
		if ($reset) {
			update_option('wpec_compare_comparison_page_global_settings', $default_settings);
		} else {
			update_option('wpec_compare_comparison_page_global_settings', $wpec_compare_comparison_page_global_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpec_compare_comparison_page_global_settings;
		$wpec_compare_comparison_page_global_settings = get_option('wpec_compare_comparison_page_global_settings');
		if ( !is_array($wpec_compare_comparison_page_global_settings) ) $wpec_compare_comparison_page_global_settings = array();
		$default_settings = WPEC_Compare_Comparison_Page_Global_Settings::get_settings_default();
		
		$wpec_compare_comparison_page_global_settings = array_merge($default_settings, $wpec_compare_comparison_page_global_settings);
		
		foreach ($wpec_compare_comparison_page_global_settings as $key => $value) {
			if (trim($value) == '') $wpec_compare_comparison_page_global_settings[$key] = $default_settings[$key];
			else $wpec_compare_comparison_page_global_settings[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $wpec_compare_comparison_page_global_settings;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			update_option('product_compare_id', $_REQUEST['product_compare_id']);
			update_option('wpec_compare_logo', $_REQUEST['wpec_compare_logo']);
			$wpec_compare_comparison_page_global_settings = $_REQUEST['wpec_compare_comparison_page_global_settings'];
									
			update_option('wpec_compare_comparison_page_global_settings', $wpec_compare_comparison_page_global_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Comparison_Page_Global_Settings::set_settings_default(true);
		}
		
		$wpec_compare_comparison_page_global_settings = get_option('wpec_compare_comparison_page_global_settings');
		$default_settings = WPEC_Compare_Comparison_Page_Global_Settings::get_settings_default();
		if ( !is_array($wpec_compare_comparison_page_global_settings) ) $wpec_compare_comparison_page_global_settings = $default_settings;
		else $wpec_compare_comparison_page_global_settings = array_merge($default_settings, $wpec_compare_comparison_page_global_settings);
		
		extract($wpec_compare_comparison_page_global_settings);
		
		$product_compare_id = get_option('product_compare_id');
		$pages = get_pages('title_li=&orderby=name');
		
		?>
        <h3><?php _e('Comparison Page Header Image', 'wpec_cp'); ?></h3>
  		<table class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wpec_compare_logo"><?php _e('Upload Page Header Image', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><?php echo WPEC_Compare_Uploader::upload_input('wpec_compare_logo', __('Compare Logo', 'wpec_cp'), '', '<img class="help_tip" tip="'.__('Upload an image with formats .jpg, .pgn, .jpeg. Any size.', 'wpec_cp').'" src="'.ECCP_IMAGES_URL.'/help.png" />' ); ?></td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Comparison Page Window', 'wpec_cp'); ?></h3>
  		<table class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label><?php _e('Open Comparison Page In', 'wpec_cp'); ?></label></th>
                    <td class="forminp">
                    <label><input type="radio" name="wpec_compare_comparison_page_global_settings[open_compare_type]" value="window" checked="checked" /> <?php _e('On Screen Window', 'wpec_cp'); ?></label> <br />
                    <label><input type="radio" name="wpec_compare_comparison_page_global_settings[open_compare_type]" value="new_page" <?php if ( $open_compare_type == 'new_page') { echo 'checked="checked"';} ?> /> <?php _e('New Window', 'wpec_cp'); ?></label> <span class="description"><?php _e("(Recommended - more mobile devise friendly, can't be blocked by pop-up blockers)", 'wpec_cp'); ?></span></td>
                 </tr>
			</tbody>
		</table>
        
        <h3><?php _e('Comparison Page Shortcode', 'wpec_cp'); ?></h3>
		<table cellspacing="0" class="form-table">
			<tbody>
				<tr valign="top">
					<td class="forminp" colspan="2"><?php _e("A 'Product Comparison' page with the shortcode [product_comparison_page] inserted should have been auto created on install. If not you need to manually create a new page and add the shortcode. Then set that page below so the plugin knows where to find it.", 'wpec_cp'); ?></td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="product_compare_id"><?php _e('Product Comparison Page','wpec_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" size="1" name="product_compare_id" id="product_compare_id" style="width:300px">
									<option selected='selected' value='0'><?php _e('Select Page','wpec_cp'); ?></option>
                                    <?php
                                    foreach ( $pages as $page ) {
                                        if ( $page->ID == $product_compare_id ) {
                                            $selected = "selected='selected'";	
                                        } else {
                                            $selected = "";		
                                        }
                                        echo "<option $selected value='".$page->ID."'>". $page->post_title."</option>";
                                    }
                                    ?>
						</select>
						<span class="description"><?php _e('Page contents', 'wpec_cp');?>: [product_comparison_page]</span>
					</td>
				</tr>
        	</tbody>
        </table>
	<?php
	}
}
?>
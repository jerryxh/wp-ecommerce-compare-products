<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Widget Thumbnails Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Widget_Thumbnail_Style{
	function get_settings_default() {
		$default_settings = array(
			'activate_thumbnail'			=> 1,
			'thumb_wide'					=> 64,
			'thumb_padding'					=> 2,
			'thumb_align'					=> 'right',
			'thumb_bg_colour'				=> '#FFFFFF',
			'thumb_border_size'				=> '1px',
			'thumb_border_style'			=> 'solid',
			'thumb_border_colour'			=> '#CDCDCE',
			'thumb_border_rounded'			=> 'square',
			'thumb_border_rounded_value' 	=> 10,
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		
		$default_settings = WPEC_Compare_Widget_Thumbnail_Style::get_settings_default();
				
		if ($reset) {
			update_option('wpec_compare_widget_thumbnail_style', $default_settings);
		} else {
			update_option('wpec_compare_widget_thumbnail_style', $default_settings);
		}	
	}
	
	function get_settings() {
		global $wpec_compare_widget_thumbnail_style;
		$wpec_compare_widget_thumbnail_style = WPEC_Compare_Widget_Thumbnail_Style::get_settings_default();
		
		return $wpec_compare_widget_thumbnail_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WPEC_Compare_Widget_Thumbnail_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Widget_Thumbnail_Style::set_settings_default(true);
		}
		
		$wpec_compare_widget_thumbnail_style = $default_settings = WPEC_Compare_Widget_Thumbnail_Style::get_settings_default();
		
		extract($wpec_compare_widget_thumbnail_style);
		
		?>
		<h3><?php _e('Product Thumbnails in Widget', 'wpec_cp'); ?></h3>
		<table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_activate_thumbnail"><?php _e('Product Thumbnails', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="wpec_compare_widget_thumbnail_style[activate_thumbnail]" id="compare_widget_activate_thumbnail" value="1" <?php if ( $activate_thumbnail == 1) { echo 'checked="checked"';} ?> /> <?php _e('Check to show Product Thumbnails when items added to the Compare Widget.', 'wpec_cp'); ?></label></td>
                </tr>
				<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_thumb_wide"><?php _e('Thumbnail Wide','wpec_cp'); ?></label></th>
                    <td class="forminp">
                        <input type="text" id="compare_widget_thumb_wide" name="wpec_compare_widget_thumbnail_style[thumb_wide]" value="<?php esc_attr_e( $thumb_wide );?>" style="width:120px;" />px <span class="description"><?php _e('Default','wpec_cp'); ?> <code><?php echo $default_settings['thumb_wide']; ?></code>px</span>
                    </td>
				</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_thumb_padding"><?php _e('Thumbnail Padding','wpec_cp'); ?></label></th>
					<td class="forminp">
						<input type="text" id="compare_widget_thumb_padding" name="wpec_compare_widget_thumbnail_style[thumb_padding]" value="<?php esc_attr_e( $thumb_padding );?>" style="width:120px;" />px <span class="description"><?php _e('Default','wpec_cp'); ?> <code><?php echo $default_settings['thumb_padding']; ?></code>px</span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_thumb_align"><?php _e('Thumbnail Alignment','wpec_cp'); ?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="compare_widget_thumb_align" name="wpec_compare_widget_thumbnail_style[thumb_align]">
							<option selected="selected" value="left"><?php _e('Left', 'wpec_cp'); ?></option>
                            <option <?php if($thumb_align == 'right'){ echo 'selected="selected"';} ?> value="right"><?php _e('Right', 'wpec_cp'); ?></option>
						</select>
                    </td>
				</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_thumb_bg_colour"><?php _e('Thumbnail Background Colour','wpec_cp'); ?></label></th>
					<td class="forminp">
						<input type="text" class="colorpick" name="wpec_compare_widget_thumbnail_style[thumb_bg_colour]" id="compare_widget_thumb_bg_colour" value="<?php esc_attr_e(stripslashes( $thumb_bg_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['thumb_bg_colour'] ?></code></span>
						<div id="colorPickerDiv_compare_widget_thumb_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
					</td>
				</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_thumb_border_size"><?php _e('Thumbnail Border Size','wpec_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="compare_widget_thumb_border_size" name="wpec_compare_widget_thumbnail_style[thumb_border_size]">
                                <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $thumb_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['thumb_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="compare_widget_thumb_border_style"><?php _e('Thumbnail Border Style', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="compare_widget_thumb_border_style" name="wpec_compare_widget_thumbnail_style[thumb_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'wpec_cp');?></option>
                                  <option <?php if( $thumb_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'wpec_cp');?></option>
                                  <option <?php if( $thumb_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'wpec_cp');?></option>
                                  <option <?php if( $thumb_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'wpec_cp');?></option>
                                </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Solid', 'wpec_cp');?></code></span>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_thumb_border_colour"><?php _e('Thumbnail Border Colour','wpec_cp'); ?></label></th>
					<td class="forminp">
						<input type="text" class="colorpick" name="wpec_compare_widget_thumbnail_style[thumb_border_colour]" id="compare_widget_thumb_border_colour" value="<?php esc_attr_e(stripslashes( $thumb_border_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['thumb_border_colour'] ?></code></span>
						<div id="colorPickerDiv_compare_widget_thumb_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for=""><?php _e('Thumbnail Border Rounded','wpec_cp'); ?></label></th>
					<td class="forminp">
                            <label><input type="radio" name="wpec_compare_widget_thumbnail_style[thumb_border_rounded]" value="rounded" <?php if( $thumb_border_rounded == 'rounded'){ echo 'checked="checked"'; } ?> /> <?php _e('Rounded Corners','wpec_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;
                            <label><?php _e('Rounded Value','wpec_cp'); ?> <input type="text" name="wpec_compare_widget_thumbnail_style[thumb_border_rounded_value]" value="<?php esc_attr_e( stripslashes( $thumb_border_rounded_value ) );?>" style="width:120px;" /></label>px <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['thumb_border_rounded_value']; ?></code>px</span>
                            <br />
                            <label><input type="radio" name="wpec_compare_widget_thumbnail_style[thumb_border_rounded]" value="square" id="square_cornes" <?php if( $thumb_border_rounded != 'rounded'){ echo 'checked="checked"'; } ?> /> <?php _e('Square Corners','wpec_cp'); ?></label> <span class="description">(<?php _e('Default', 'wpec_cp');?>)</span>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
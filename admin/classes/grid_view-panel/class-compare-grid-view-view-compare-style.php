<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Product Page View Compare Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Grid_View_View_Compare_Style
{
	public static function get_settings_default() {
		$default_settings = array(
			'disable_gridview_view_compare'	=> 1,
			
			'gridview_view_compare_link_text'=> __('View Compare &rarr;', 'wpec_cp'),
			'gridview_view_compare_link_font'=> '',
			'gridview_view_compare_link_font_size'=> '',
			'gridview_view_compare_link_font_style' => '',
			'gridview_view_compare_link_font_colour' => '',
			'gridview_view_compare_link_font_hover_colour' => '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		
		$default_settings = WPEC_Compare_Grid_View_View_Compare_Style::get_settings_default();
				
		if ($reset) {
			update_option('wpec_compare_gridview_view_compare_style', $default_settings);
		} else {
			update_option('wpec_compare_gridview_view_compare_style', $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpec_compare_gridview_view_compare_style;
		$wpec_compare_gridview_view_compare_style = WPEC_Compare_Grid_View_View_Compare_Style::get_settings_default();
		
		return $wpec_compare_gridview_view_compare_style;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WPEC_Compare_Grid_View_View_Compare_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Grid_View_View_Compare_Style::set_settings_default(true);
		}
		
		$wpec_compare_gridview_view_compare_style = $default_settings = WPEC_Compare_Grid_View_View_Compare_Style::get_settings_default();
		
		extract($wpec_compare_gridview_view_compare_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <h3><?php _e('Activate / Deactivate', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="disable_gridview_view_compare"><?php _e('View Compare on Product Page', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="wpec_compare_gridview_view_compare_style[disable_gridview_view_compare]" id="disable_gridview_view_compare" value="1" <?php if ( $disable_gridview_view_compare == 1) { echo 'checked="checked"';} ?> /> <?php _e('Check to deactivate the View Compare feature on Product Page Default, Listing or Grid View layout.', 'wpec_cp'); ?></label></td>
                </tr>
            </tbody>
        </table>
        
        <h3><?php _e('View Compare Linked Text Styling', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="gridview_view_compare_link_text"><?php _e('Linked Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $gridview_view_compare_link_text ) );?>" style="width:300px;" id="gridview_view_compare_link_text" name="wpec_compare_gridview_view_compare_style[gridview_view_compare_link_text]" /> <span class="description"><?php _e('For default', 'wpec_cp');?> <code>'<?php echo $default_settings['gridview_view_compare_link_text']; ?>'</code> <?php _e('or enter text', 'wpec_cp');?></span>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="gridview_view_compare_link_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="gridview_view_compare_link_font" name="wpec_compare_gridview_view_compare_style[gridview_view_compare_link_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $gridview_view_compare_link_font ) ==  htmlspecialchars($key) ){
                                        ?><option value='<?php echo htmlspecialchars($key); ?>' selected='selected'><?php echo $value; ?></option><?php
                                    }else{
                                        ?><option value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option><?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
					</td>
				</tr>
                <tr>
                    <th class="titledesc" scope="row"><label for="gridview_view_compare_link_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="gridview_view_compare_link_font_size" name="wpec_compare_gridview_view_compare_style[gridview_view_compare_link_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $gridview_view_compare_link_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="gridview_view_compare_link_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="gridview_view_compare_link_font_style" name="wpec_compare_gridview_view_compare_style[gridview_view_compare_link_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $gridview_view_compare_link_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $gridview_view_compare_link_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $gridview_view_compare_link_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $gridview_view_compare_link_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="gridview_view_compare_link_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_gridview_view_compare_style[gridview_view_compare_link_font_colour]" id="gridview_view_compare_link_font_colour" value="<?php esc_attr_e( stripslashes( $gridview_view_compare_link_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
            			<div id="colorPickerDiv_gridview_view_compare_link_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="gridview_view_compare_link_font_hover_colour"><?php _e('Font Hover Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_gridview_view_compare_style[gridview_view_compare_link_font_hover_colour]" id="gridview_view_compare_link_font_hover_colour" value="<?php esc_attr_e( stripslashes( $gridview_view_compare_link_font_hover_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
            			<div id="colorPickerDiv_gridview_view_compare_link_font_hover_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
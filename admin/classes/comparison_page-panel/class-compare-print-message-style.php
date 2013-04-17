<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Print Message Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Print_Message_Style{
	function get_settings_default() {
		$default_settings = array(
			'print_message_text'			=> __('Refine slections to 3 products and print!', 'wpec_cp'),
			'print_message_font'			=> 'Tahoma, Geneva, Verdana, sans-serif',
			'print_message_font_size'		=> '12px',
			'print_message_font_style'		=> 'normal',
			'print_message_font_colour'		=> '#000000',
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		
		$default_settings = WPEC_Compare_Print_Message_Style::get_settings_default();
				
		if ($reset) {
			update_option('wpec_compare_print_message_style', $default_settings);
		} else {
			update_option('wpec_compare_print_message_style', $default_settings);
		}
				
	}
	
	function get_settings() {
		global $wpec_compare_print_message_style;
		$wpec_compare_print_message_style = WPEC_Compare_Print_Message_Style::get_settings_default();
		
		return $wpec_compare_print_message_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WPEC_Compare_Print_Message_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Print_Message_Style::set_settings_default(true);
		}
		
		$wpec_compare_print_message_style = $default_settings = WPEC_Compare_Print_Message_Style::get_settings_default();
		
		extract($wpec_compare_print_message_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <h3><?php _e('Print Page Message', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="print_message_text"><?php _e('Print Page Message Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $print_message_text ) );?>" style="width:300px;" id="empty_text" name="wpec_compare_print_message_style[print_message_text]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> '<code><?php echo $default_settings['print_message_text']; ?></code>'</span>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="print_message_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="print_message_font" name="wpec_compare_print_message_style[print_message_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $print_message_font ) ==  htmlspecialchars($key) ){
                                        ?><option value='<?php echo htmlspecialchars($key); ?>' selected='selected'><?php echo $value; ?></option><?php
                                    }else{
                                        ?><option value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option><?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e( 'Tahoma', 'wpec_cp' ); ?></code></span>
					</td>
				</tr>
                <tr>
                    <th class="titledesc" scope="row"><label for="print_message_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="print_message_font_size" name="wpec_compare_print_message_style[print_message_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $print_message_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['print_message_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="print_message_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="print_message_font_style" name="wpec_compare_print_message_style[print_message_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $print_message_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $print_message_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $print_message_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $print_message_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Normal', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="print_message_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_print_message_style[print_message_font_colour]" id="print_message_font_colour" value="<?php esc_attr_e( stripslashes( $print_message_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['print_message_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_print_message_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
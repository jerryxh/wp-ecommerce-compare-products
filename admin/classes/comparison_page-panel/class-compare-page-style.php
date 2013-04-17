<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Page Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Page_Style{
	function get_settings_default() {
		$default_settings = array(
			'header_bg_colour'				=> '#FFFFFF',
			'header_bottom_border_size'		=> '3px',
			'header_bottom_border_style'	=> 'solid',
			'header_bottom_border_colour'	=> '#666666',
			
			'body_bg_colour'				=> '#FFFFFF',
			
			'no_product_message_text'		=> __('You do not have any product to compare.', 'wpec_cp'),
			'no_product_message_align'		=> 'center',
			'no_product_message_font'		=> 'Tahoma, Geneva, Verdana, sans-serif',
			'no_product_message_font_size'	=> '12px',
			'no_product_message_font_style'	=> 'normal',
			'no_product_message_font_colour'=> '#000000',
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		$wpec_compare_page_style = get_option('wpec_compare_page_style');
		if ( !is_array($wpec_compare_page_style) ) $wpec_compare_page_style = array();
		
		$default_settings = WPEC_Compare_Page_Style::get_settings_default();
		
		$wpec_compare_page_style = array_merge($default_settings, $wpec_compare_page_style);
		
		if ($reset) {
			update_option('wpec_compare_page_style', $default_settings);
		} else {
			update_option('wpec_compare_page_style', $wpec_compare_page_style);
		}
				
	}
	
	function get_settings() {
		global $wpec_compare_page_style;
		$wpec_compare_page_style = get_option('wpec_compare_page_style');
		if ( !is_array($wpec_compare_page_style) ) $wpec_compare_page_style = array();
		$default_settings = WPEC_Compare_Page_Style::get_settings_default();
		
		$wpec_compare_page_style = array_merge($default_settings, $wpec_compare_page_style);
		
		foreach ($wpec_compare_page_style as $key => $value) {
			if (trim($value) == '') $wpec_compare_page_style[$key] = $default_settings[$key];
			else $wpec_compare_page_style[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $wpec_compare_page_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$wpec_compare_page_style = $_REQUEST['wpec_compare_page_style'];
						
			update_option('wpec_compare_page_style', $wpec_compare_page_style);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Page_Style::set_settings_default(true);
		}
		
		$wpec_compare_page_style = get_option('wpec_compare_page_style');
		$default_settings = WPEC_Compare_Page_Style::get_settings_default();
		if ( !is_array($wpec_compare_page_style) ) $wpec_compare_page_style = $default_settings;
		else $wpec_compare_page_style = array_merge($default_settings, $wpec_compare_page_style);
		
		extract($wpec_compare_page_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <h3><?php _e('Comparison Page Header', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="header_bg_colour"><?php _e('Background Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $header_bg_colour ) );?>" style="width:120px;" id="header_bg_colour" name="wpec_compare_page_style[header_bg_colour]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['header_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_header_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="header_bottom_border_size"><?php _e('Bottom Border Size','wpec_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="header_bottom_border_size" name="wpec_compare_page_style[header_bottom_border_size]">
							<option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $header_bottom_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['header_bottom_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="header_bottom_border_style"><?php _e('Bottom Border Style', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="header_bottom_border_style" name="wpec_compare_page_style[header_bottom_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'wpec_cp');?></option>
                                  <option <?php if( $header_bottom_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'wpec_cp');?></option>
                                  <option <?php if( $header_bottom_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'wpec_cp');?></option>
                                  <option <?php if( $header_bottom_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'wpec_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Solid', 'wpec_cp');?></code></span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="header_bottom_border_colour"><?php _e('Bottom Border Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $header_bottom_border_colour ) );?>" style="width:120px;" id="header_bottom_border_colour" name="wpec_compare_page_style[header_bottom_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'wpec_cp');?> <code><?php echo $default_settings['header_bottom_border_colour']; ?></code></span>
            			<div id="colorPickerDiv_header_bottom_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>

        <h3><?php _e('Comparison Page Body', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="body_bg_colour"><?php _e('Background Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $body_bg_colour ) );?>" style="width:120px;" id="body_bg_colour" name="wpec_compare_page_style[body_bg_colour]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['body_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_body_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Comparison Empty Window Message', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="no_product_message_text"><?php _e('Comparison Empty Window Message Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $no_product_message_text ) );?>" style="width:300px;" id="empty_text" name="wpec_compare_page_style[no_product_message_text]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> '<code><?php echo $default_settings['no_product_message_text']; ?></code>'</span>
                    </td>
               	</tr>
                <tr>
                    <th class="titledesc" scope="row"><label for="no_product_message_align"><?php _e('Text Alignment', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="no_product_message_align" name="wpec_compare_page_style[no_product_message_align]">
                          <option value="center" selected="selected"><?php _e('Center', 'wpec_cp');?></option>
                          <option <?php if( $no_product_message_align == 'left'){ echo 'selected="selected"';} ?> value="left"><?php _e('Left', 'wpec_cp');?></option>
                          <option <?php if( $no_product_message_align == 'right'){ echo 'selected="selected"';} ?> value="right"><?php _e('Right', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Center', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="no_product_message_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="no_product_message_font" name="wpec_compare_page_style[no_product_message_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $no_product_message_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="no_product_message_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="no_product_message_font_size" name="wpec_compare_page_style[no_product_message_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $no_product_message_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['no_product_message_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="no_product_message_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="no_product_message_font_style" name="wpec_compare_page_style[no_product_message_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $no_product_message_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $no_product_message_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $no_product_message_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $no_product_message_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Normal', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="no_product_message_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_page_style[no_product_message_font_colour]" id="no_product_message_font_colour" value="<?php esc_attr_e( stripslashes( $no_product_message_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['no_product_message_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_no_product_message_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
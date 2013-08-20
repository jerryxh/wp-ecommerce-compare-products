<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Close Window Button Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Close_Window_Button_Style
{
	public static function get_settings_default() {
		$default_settings = array(
			'close_button_type'				=> 'button',
			
			'button_text'					=> __('Close window', 'wpec_cp'),
			'button_bg_colour'				=> '#476381',
			'button_bg_colour_from'			=> '#538bbc',
			'button_bg_colour_to'			=> '#476381',
			
			'button_border_size'			=> '1px',
			'button_border_style'			=> 'solid',
			'button_border_colour'			=> '#476381',
			'button_border_rounded'			=> 'rounded',
			'button_border_rounded_value'	=> 3,
			
			'button_font'					=> 'Tahoma, Geneva, Verdana, sans-serif',
			'button_font_size'				=> '12px',
			'button_font_style'				=> 'bold',
			'button_font_colour'			=> '#FFFFFF',
			'button_class'					=> '',
			
			'close_link_text'				=> __('Close window', 'wpec_cp'),
			'close_link_font'				=> 'Tahoma, Geneva, Verdana, sans-serif',
			'close_link_font_size'			=> '14px',
			'close_link_font_style'			=> 'bold',
			'close_link_font_colour'		=> '#21759B',
			'close_link_font_hover_colour'	=> '#D54E21',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		
		$default_settings = WPEC_Compare_Close_Window_Button_Style::get_settings_default();
				
		if ($reset) {
			update_option('wpec_compare_close_window_button_style', $default_settings);
		} else {
			update_option('wpec_compare_close_window_button_style', $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpec_compare_close_window_button_style;
		$wpec_compare_close_window_button_style = WPEC_Compare_Close_Window_Button_Style::get_settings_default();
		
		return $wpec_compare_close_window_button_style;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WPEC_Compare_Close_Window_Button_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Close_Window_Button_Style::set_settings_default(true);
		}
		
		$wpec_compare_close_window_button_style = $default_settings = WPEC_Compare_Close_Window_Button_Style::get_settings_default();
		
		extract($wpec_compare_close_window_button_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <script type="text/javascript">
			(function($){		
				$(function(){	
					$('.close_button_type').click(function(){
						if ($("input[name='wpec_compare_close_window_button_style[close_button_type]']:checked").val() == 'link') {
							$(".close_link_styling").show();
							$(".close_button_styling").hide();
						} else {
							$(".close_link_styling").hide();
							$(".close_button_styling").show();
						}
					});
				});		  
			})(jQuery);
		</script>
        <h3><?php _e('Settings', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_button_type"><?php _e('Button or Text', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="radio" class="close_button_type" name="wpec_compare_close_window_button_style[close_button_type]" value="button" checked="checked" /> <?php _e('Button', 'wpec_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label><input type="radio" class="close_button_type" name="wpec_compare_close_window_button_style[close_button_type]" value="link" <?php if ($close_button_type == 'link') { echo 'checked="checked"';} ?> /> <?php _e('Linked Text', 'wpec_cp'); ?></label> 
                </tr>
            </tbody>
        </table>
        
        <h3 class="close_button_styling" style=" <?php if($close_button_type == 'link') { echo 'display:none'; } ?>"><?php _e('Compare Table Close Window Button Styling', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table close_button_styling" style=" <?php if($close_button_type == 'link') { echo 'display:none'; } ?>">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_window_button_text"><?php _e('Button Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $button_text ) );?>" style="width:300px;" id="close_window_button_text" name="wpec_compare_close_window_button_style[button_text]" /> <span class="description"><?php _e('For default', 'wpec_cp');?> <code>'<?php echo $default_settings['button_text']; ?>'</code> <?php _e('or enter text', 'wpec_cp');?></span>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_window_button_bg_colour"><?php _e('Background Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour ) );?>" style="width:120px;" id="close_window_button_bg_colour" name="wpec_compare_close_window_button_style[button_bg_colour]" /> <span class="description"><?php _e('Button colour. Default', 'wpec_cp');?> <code><?php echo $default_settings['button_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_close_window_button_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_window_button_bg_colour_from"><?php _e('Background Colour Gradient From','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour_from ) );?>" style="width:120px;" id="close_window_button_bg_colour_from" name="wpec_compare_close_window_button_style[button_bg_colour_from]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_bg_colour_from']; ?></code></span>
            			<div id="colorPickerDiv_close_window_button_bg_colour_from" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_window_button_bg_colour_to"><?php _e('Background Colour Gradient To','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour_to ) );?>" style="width:120px;" id="close_window_button_bg_colour_to" name="wpec_compare_close_window_button_style[button_bg_colour_to]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_bg_colour_to']; ?></code></span>
            			<div id="colorPickerDiv_close_window_button_bg_colour_to" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="close_window_button_border_size"><?php _e('Border Size','wpec_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="close_window_button_border_size" name="wpec_compare_close_window_button_style[button_border_size]">
							<option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $button_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="close_window_button_border_style"><?php _e('Border Style', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="close_window_button_border_style" name="wpec_compare_close_window_button_style[button_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'wpec_cp');?></option>
                                  <option <?php if( $button_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'wpec_cp');?></option>
                                  <option <?php if( $button_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'wpec_cp');?></option>
                                  <option <?php if( $button_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'wpec_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Solid', 'wpec_cp');?></code></span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_window_button_border_colour"><?php _e('Border Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_border_colour ) );?>" style="width:120px;" id="close_window_button_border_colour" name="wpec_compare_close_window_button_style[button_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'wpec_cp');?> <code><?php echo $default_settings['button_border_colour']; ?></code></span>
            			<div id="colorPickerDiv_close_window_button_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_window_button_rounded_corner"><?php _e('Border Rounded','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    <input type="radio" name="wpec_compare_close_window_button_style[button_border_rounded]" value="rounded" id="close_window_button_rounded_corner" checked="checked" /> <label for="close_window_button_rounded_corner"><?php _e('Rounded Corners','wpec_cp'); ?></label> <span class="description">(<?php _e('Default', 'wpec_cp');?>)</span> &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><?php _e('Rounded Value','wpec_cp'); ?></label> <input type="text" name="wpec_compare_close_window_button_style[button_border_rounded_value]" value="<?php esc_attr_e( stripslashes( $button_border_rounded_value) );?>" style="width:120px;" />px <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_border_rounded_value']; ?></code>px</span>
                    <br />
                    <input type="radio" name="wpec_compare_close_window_button_style[button_border_rounded]" value="square" id="close_window_button_square_corner" <?php if($button_border_rounded == 'square'){ echo 'checked="checked"'; } ?> /> <label for="close_window_button_square_corner"><?php _e('Square Corners','wpec_cp'); ?></label>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="close_window_button_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="close_window_button_font" name="wpec_compare_close_window_button_style[button_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $button_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="close_window_button_font_size"><?php _e('Button Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="close_window_button_font_size" name="wpec_compare_close_window_button_style[button_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $button_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="close_window_button_font_style"><?php _e('Button Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="close_window_button_font_style" name="wpec_compare_close_window_button_style[button_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $button_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $button_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $button_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $button_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Bold', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_window_button_font_colour"><?php _e('Button Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_close_window_button_style[button_font_colour]" id="close_window_button_font_colour" value="<?php esc_attr_e( stripslashes( $button_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_close_window_button_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_window_button_class"><?php _e('CSS Class','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="wpec_compare_close_window_button_style[button_class]" id="close_window_button_class" value="<?php esc_attr_e( stripslashes( $button_class ) );?>" style="min-width:300px" /> <span class="description"><?php _e("Enter your own button CSS class", 'wpec_cp'); ?></span>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3 class="close_link_styling" style=" <?php if($close_button_type != 'link') { echo 'display:none'; } ?>"><?php _e('Compare Table Close Window Linked Text Styling', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table close_link_styling" style=" <?php if($close_button_type != 'link') { echo 'display:none'; } ?>">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_link_text"><?php _e('Linked Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $close_link_text ) );?>" style="width:300px;" id="close_link_text" name="wpec_compare_close_window_button_style[close_link_text]" /> <span class="description"><?php _e('For default', 'wpec_cp');?> <code>'<?php echo $default_settings['close_link_text']; ?>'</code> <?php _e('or enter text', 'wpec_cp');?></span>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="close_link_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="close_link_font" name="wpec_compare_close_window_button_style[close_link_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $close_link_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="close_link_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="close_link_font_size" name="wpec_compare_close_window_button_style[close_link_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $close_link_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['close_link_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="close_link_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="close_link_font_style" name="wpec_compare_close_window_button_style[close_link_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $close_link_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $close_link_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $close_link_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $close_link_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Bold', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_link_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_close_window_button_style[close_link_font_colour]" id="close_link_font_colour" value="<?php esc_attr_e( stripslashes( $close_link_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['close_link_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_close_link_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="close_link_font_hover_colour"><?php _e('Font Hover Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_close_window_button_style[close_link_font_hover_colour]" id="close_link_font_hover_colour" value="<?php esc_attr_e( stripslashes( $close_link_font_hover_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['close_link_font_hover_colour'] ?></code></span>
            			<div id="colorPickerDiv_close_link_font_hover_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Product Page Button Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Product_Page_Button_Style
{
	public static function get_settings_default() {
		$default_settings = array(
			'product_compare_button_type'	=> 'button',
			
			'product_compare_button_text'	=> __('Compare This*', 'wpec_cp'),
			'button_bg_colour'				=> '#476381',
			'button_bg_colour_from'			=> '#538bbc',
			'button_bg_colour_to'			=> '#476381',
			
			'button_border_size'			=> '1px',
			'button_border_style'			=> 'solid',
			'button_border_colour'			=> '#476381',
			'button_border_rounded'			=> 'rounded',
			'button_border_rounded_value'	=> 3,
			
			'button_font'					=> '',
			'button_font_size'				=> '',
			'button_font_style'				=> '',
			'button_font_colour'			=> '#FFFFFF',
			'button_class'					=> '',
			
			'product_compare_link_text'		=> __('Compare This*', 'wpec_cp'),
			'product_compare_link_font'		=> '',
			'product_compare_link_font_size'=> '',
			'product_compare_link_font_style' => '',
			'product_compare_link_font_colour' => '',
			'product_compare_link_font_hover_colour' => '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$wpec_compare_product_page_button_style = get_option('wpec_compare_product_page_button_style');
		if ( !is_array($wpec_compare_product_page_button_style) ) $wpec_compare_product_page_button_style = array();
		
		$default_settings = WPEC_Compare_Product_Page_Button_Style::get_settings_default();
		
		$wpec_compare_product_page_button_style = array_merge($default_settings, $wpec_compare_product_page_button_style);
		
		if ($reset) {
			update_option('wpec_compare_product_page_button_style', $default_settings);
			update_option('wpec_compare_product_success_icon', '');
		} else {
			update_option('wpec_compare_product_page_button_style', $wpec_compare_product_page_button_style);
		}
				
	}
	
	public static function get_settings() {
		global $wpec_compare_product_page_button_style;
		$wpec_compare_product_page_button_style = get_option('wpec_compare_product_page_button_style');
		if ( !is_array($wpec_compare_product_page_button_style) ) $wpec_compare_product_page_button_style = array();
		$default_settings = WPEC_Compare_Product_Page_Button_Style::get_settings_default();
		
		$wpec_compare_product_page_button_style = array_merge($default_settings, $wpec_compare_product_page_button_style);
		
		foreach ($wpec_compare_product_page_button_style as $key => $value) {
			if (trim($value) == '') $wpec_compare_product_page_button_style[$key] = $default_settings[$key];
			else $wpec_compare_product_page_button_style[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $wpec_compare_product_page_button_style;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			update_option('wpec_compare_product_success_icon', $_REQUEST['wpec_compare_product_success_icon']);
			$wpec_compare_product_page_button_style = $_REQUEST['wpec_compare_product_page_button_style'];
						
			update_option('wpec_compare_product_page_button_style', $wpec_compare_product_page_button_style);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Product_Page_Button_Style::set_settings_default(true);
		}
		
		$wpec_compare_product_page_button_style = get_option('wpec_compare_product_page_button_style');
		$default_settings = WPEC_Compare_Product_Page_Button_Style::get_settings_default();
		if ( !is_array($wpec_compare_product_page_button_style) ) $wpec_compare_product_page_button_style = $default_settings;
		else $wpec_compare_product_page_button_style = array_merge($default_settings, $wpec_compare_product_page_button_style);
		
		extract($wpec_compare_product_page_button_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <script type="text/javascript">
			(function($){		
				$(function(){	
					$('.product_compare_button_type').click(function(){
						if ($("input[name='wpec_compare_product_page_button_style[product_compare_button_type]']:checked").val() == 'link') {
							$(".product_compare_link_styling").show();
							$(".product_compare_button_styling").hide();
						} else {
							$(".product_compare_link_styling").hide();
							$(".product_compare_button_styling").show();
						}
					});
				});		  
			})(jQuery);
		</script>
        <h3><?php _e('Settings', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_compare_button_type"><?php _e('Button or Text', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="radio" class="product_compare_button_type" name="wpec_compare_product_page_button_style[product_compare_button_type]" value="button" checked="checked" /> <?php _e('Button', 'wpec_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label><input type="radio" class="product_compare_button_type" name="wpec_compare_product_page_button_style[product_compare_button_type]" value="link" <?php if ($product_compare_button_type == 'link') { echo 'checked="checked"';} ?> /> <?php _e('Linked Text', 'wpec_cp'); ?></label> 
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wpec_compare_product_success_icon"><?php _e('Compare Success Icon', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><?php echo WPEC_Compare_Uploader::upload_input('wpec_compare_product_success_icon', __('Compare Product Success', 'wpec_cp'), '', '<img class="help_tip" tip="'.__('Upload a 16px x 16px image, support .jpg, .pgn, .jpeg, .gif formats.', 'wpec_cp').'" src="'.ECCP_IMAGES_URL.'/help.png" />' ); ?></td>
               	</tr>
            </tbody>
        </table>
        
        <h3 class="product_compare_button_styling" style=" <?php if($product_compare_button_type == 'link') { echo 'display:none'; } ?>"><?php _e('Single Product Page Compare Button Styling', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table product_compare_button_styling" style=" <?php if($product_compare_button_type == 'link') { echo 'display:none'; } ?>">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_compare_button_text"><?php _e('Button Text', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="wpec_compare_product_page_button_style[product_compare_button_text]" id="product_compare_button_text" value="<?php esc_attr_e( stripslashes( $product_compare_button_text ) ); ?>" style="min-width:300px;" /> <span class="description"><?php _e('For default', 'wpec_cp');?> <code>'<?php echo $default_settings['product_compare_button_text']; ?>'</code> <?php _e('or enter text', 'wpec_cp');?></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_page_button_bg_colour"><?php _e('Background Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour ) );?>" style="width:120px;" id="product_page_button_bg_colour" name="wpec_compare_product_page_button_style[button_bg_colour]" /> <span class="description"><?php _e('Button colour. Default', 'wpec_cp');?> <code><?php echo $default_settings['button_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_product_page_button_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_page_button_bg_colour_from"><?php _e('Background Colour Gradient From','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour_from ) );?>" style="width:120px;" id="product_page_button_bg_colour_from" name="wpec_compare_product_page_button_style[button_bg_colour_from]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_bg_colour_from']; ?></code></span>
            			<div id="colorPickerDiv_product_page_button_bg_colour_from" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_page_button_bg_colour_to"><?php _e('Background Colour Gradient To','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour_to ) );?>" style="width:120px;" id="product_page_button_bg_colour_to" name="wpec_compare_product_page_button_style[button_bg_colour_to]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_bg_colour_to']; ?></code></span>
            			<div id="colorPickerDiv_product_page_button_bg_colour_to" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="product_page_button_border_size"><?php _e('Border Size','wpec_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="product_page_button_border_size" name="wpec_compare_product_page_button_style[button_border_size]">
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
					<th class="titledesc" scope="row"><label for="product_page_button_border_style"><?php _e('Border Style', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="product_page_button_border_style" name="wpec_compare_product_page_button_style[button_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'wpec_cp');?></option>
                                  <option <?php if( $button_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'wpec_cp');?></option>
                                  <option <?php if( $button_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'wpec_cp');?></option>
                                  <option <?php if( $button_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'wpec_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Solid', 'wpec_cp');?></code></span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_page_button_border_colour"><?php _e('Border Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_border_colour ) );?>" style="width:120px;" id="product_page_button_border_colour" name="wpec_compare_product_page_button_style[button_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'wpec_cp');?> <code><?php echo $default_settings['button_border_colour']; ?></code></span>
            			<div id="colorPickerDiv_product_page_button_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label><?php _e('Border Rounded','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    <label><input type="radio" name="wpec_compare_product_page_button_style[button_border_rounded]" value="rounded" checked="checked" /> <?php _e('Rounded Corners','wpec_cp'); ?></label> <span class="description">(<?php _e('Default', 'wpec_cp');?>)</span> &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><?php _e('Rounded Value','wpec_cp'); ?> <input type="text" name="wpec_compare_product_page_button_style[button_border_rounded_value]" value="<?php esc_attr_e( stripslashes( $button_border_rounded_value) );?>" style="width:120px;" />px</label> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_border_rounded_value']; ?></code>px</span>
                    <br />
                    <label><input type="radio" name="wpec_compare_product_page_button_style[button_border_rounded]" value="square" <?php if($button_border_rounded == 'square'){ echo 'checked="checked"'; } ?> /> <?php _e('Square Corners','wpec_cp'); ?></label>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="product_page_button_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="product_page_button_font" name="wpec_compare_product_page_button_style[button_font]">
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
						</select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
					</td>
				</tr>
                <tr>
                    <th class="titledesc" scope="row"><label for="product_page_button_font_size"><?php _e('Button Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="product_page_button_font_size" name="wpec_compare_product_page_button_style[button_font_size]">
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
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="product_page_button_font_style"><?php _e('Button Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="product_page_button_font_style" name="wpec_compare_product_page_button_style[button_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $button_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $button_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $button_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $button_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_page_button_font_colour"><?php _e('Button Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_product_page_button_style[button_font_colour]" id="product_page_button_font_colour" value="<?php esc_attr_e( stripslashes( $button_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['button_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_product_page_button_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_page_button_class"><?php _e('CSS Class','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="wpec_compare_product_page_button_style[button_class]" id="product_page_button_class" value="<?php esc_attr_e( stripslashes( $button_class ) );?>" style="min-width:300px" /> <span class="description"><?php _e("Enter your own button CSS class", 'wpec_cp'); ?></span>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3 class="product_compare_link_styling" style=" <?php if($product_compare_button_type != 'link') { echo 'display:none'; } ?>"><?php _e('Single Product Page Compare Linked Text Styling', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table product_compare_link_styling" style=" <?php if($product_compare_button_type != 'link') { echo 'display:none'; } ?>">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_compare_link_text"><?php _e('Linked Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $product_compare_link_text ) );?>" style="width:300px;" id="product_compare_link_text" name="wpec_compare_product_page_button_style[product_compare_link_text]" /> <span class="description"><?php _e('For default', 'wpec_cp');?> <code>'<?php echo $default_settings['product_compare_link_text']; ?>'</code> <?php _e('or enter text', 'wpec_cp');?></span>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="product_compare_link_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="product_compare_link_font" name="wpec_compare_product_page_button_style[product_compare_link_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $product_compare_link_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="product_compare_link_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="product_compare_link_font_size" name="wpec_compare_product_page_button_style[product_compare_link_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $product_compare_link_font_size ==  $i.'px' ){
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
                    <th class="titledesc" scope="row"><label for="product_compare_link_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="product_compare_link_font_style" name="wpec_compare_product_page_button_style[product_compare_link_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $product_compare_link_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $product_compare_link_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $product_compare_link_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $product_compare_link_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_compare_link_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_product_page_button_style[product_compare_link_font_colour]" id="product_compare_link_font_colour" value="<?php esc_attr_e( stripslashes( $product_compare_link_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
            			<div id="colorPickerDiv_product_compare_link_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="product_compare_link_font_hover_colour"><?php _e('Font Hover Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_product_page_button_style[product_compare_link_font_hover_colour]" id="product_compare_link_font_hover_colour" value="<?php esc_attr_e( stripslashes( $product_compare_link_font_hover_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wpec_cp');?></span>
            			<div id="colorPickerDiv_product_compare_link_font_hover_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
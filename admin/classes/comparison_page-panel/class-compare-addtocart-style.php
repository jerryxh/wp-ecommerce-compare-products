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
class WPEC_Compare_AddToCart_Style{
	function get_settings_default() {
		$default_settings = array(
			'disable_product_addcart'		=> 0,
			'addtocart_button_type'			=> 'link',
			
			'addtocart_link_text'			=> __('Add to cart', 'wpec_cp'),
			'addtocart_link_font'			=> 'Tahoma, Geneva, Verdana, sans-serif',
			'addtocart_link_font_size'		=> '12px',
			'addtocart_link_font_style'		=> 'normal',
			'addtocart_link_font_colour'	=> '#3088FF',
			'addtocart_link_font_hover_colour'=> '#D54E21',
			
			'addtocart_button_text'			=> __('Add to cart', 'wpec_cp'),
			'addtocart_button_bg_colour'	=> '#476381',
			'addtocart_button_bg_colour_from' => '#538bbc',
			'addtocart_button_bg_colour_to'	=> '#476381',
			
			'addtocart_button_border_size'	=> '1px',
			'addtocart_button_border_style'	=> 'solid',
			'addtocart_button_border_colour' => '#476381',
			'addtocart_button_border_rounded' => 'rounded',
			'addtocart_button_border_rounded_value' => 3,
			
			'addtocart_button_font'			=> 'Tahoma, Geneva, Verdana, sans-serif',
			'addtocart_button_font_size'	=> '12px',
			'addtocart_button_font_style'	=> 'bold',
			'addtocart_button_font_colour'	=> '#FFFFFF',
			'addtocart_button_class'		=> '',
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		
		$default_settings = WPEC_Compare_AddToCart_Style::get_settings_default();
				
		if ($reset) {
			update_option('wpec_compare_addtocart_style', $default_settings);
			update_option('wpec_compare_addtocart_success', '');
		} else {
			update_option('wpec_compare_addtocart_style', $default_settings);
			update_option('wpec_compare_addtocart_success', '');
		}
				
	}
	
	function get_settings() {
		global $wpec_compare_addtocart_style;
		$wpec_compare_addtocart_style = WPEC_Compare_AddToCart_Style::get_settings_default();
		
		return $wpec_compare_addtocart_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WPEC_Compare_AddToCart_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_AddToCart_Style::set_settings_default(true);
		}
		
		$wpec_compare_addtocart_style = $default_settings = WPEC_Compare_AddToCart_Style::get_settings_default();
		
		extract($wpec_compare_addtocart_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <script type="text/javascript">
			(function($){		
				$(function(){	
					$('.addtocart_button_type').click(function(){
						if ($("input[name='wpec_compare_addtocart_style[addtocart_button_type]']:checked").val() == 'link') {
							$(".addtocart_link_styling").show();
							$(".addtocart_button_styling").hide();
						} else {
							$(".addtocart_link_styling").hide();
							$(".addtocart_button_styling").show();
						}
					});
				});		  
			})(jQuery);
		</script>
        <h3><?php _e('Settings', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="disable_product_addcart"><?php _e('Add To Cart Link', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="wpec_compare_addtocart_style[disable_product_addcart]" id="disable_product_addcart" value="1" <?php if ( $disable_product_addcart == 1) { echo 'checked="checked"';} ?> /> <?php _e(' Check to deactivate the Add To Cart link on Comparison Table', 'wpec_cp'); ?></label></td>
                </tr>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_type"><?php _e('Button or Text', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="radio" class="addtocart_button_type" name="wpec_compare_addtocart_style[addtocart_button_type]" value="button" checked="checked" /> <?php _e('Button', 'wpec_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label><input type="radio" class="addtocart_button_type" name="wpec_compare_addtocart_style[addtocart_button_type]" value="link" <?php if ($addtocart_button_type == 'link') { echo 'checked="checked"';} ?> /> <?php _e('Linked Text', 'wpec_cp'); ?></label> 
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wpec_compare_addtocart_success"><?php _e('Added To Cart Success Icon', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><?php echo WPEC_Compare_Uploader::upload_input('wpec_compare_addtocart_success', __('Added To Cart Success', 'wpec_cp'), '', '<img class="help_tip" tip="'.__('Upload a 16px x 16px image, support .jpg, .pgn, .jpeg, .gif formats.', 'wpec_cp').'" src="'.ECCP_IMAGES_URL.'/help.png" />' ); ?></td>
               	</tr>
            </tbody>
        </table>
        
        <h3 class="addtocart_button_styling" style=" <?php if($addtocart_button_type == 'link') { echo 'display:none'; } ?>"><?php _e('Add To Cart Button Styling', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table addtocart_button_styling" style=" <?php if($addtocart_button_type == 'link') { echo 'display:none'; } ?>">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_text"><?php _e('Button Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $addtocart_button_text ) );?>" style="width:300px;" id="addtocart_button_text" name="wpec_compare_addtocart_style[addtocart_button_text]" /> <span class="description"><?php _e('For default', 'wpec_cp');?> <code>'<?php echo $default_settings['addtocart_button_text']; ?>'</code> <?php _e('or enter text', 'wpec_cp');?></span>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_bg_colour"><?php _e('Background Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $addtocart_button_bg_colour ) );?>" style="width:120px;" id="addtocart_button_bg_colour" name="wpec_compare_addtocart_style[addtocart_button_bg_colour]" /> <span class="description"><?php _e('Button colour. Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_button_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_addtocart_button_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_bg_colour_from"><?php _e('Background Colour Gradient From','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $addtocart_button_bg_colour_from ) );?>" style="width:120px;" id="addtocart_button_bg_colour_from" name="wpec_compare_addtocart_style[addtocart_button_bg_colour_from]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_button_bg_colour_from']; ?></code></span>
            			<div id="colorPickerDiv_addtocart_button_bg_colour_from" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_bg_colour_to"><?php _e('Background Colour Gradient To','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $addtocart_button_bg_colour_to ) );?>" style="width:120px;" id="addtocart_button_bg_colour_to" name="wpec_compare_addtocart_style[addtocart_button_bg_colour_to]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_button_bg_colour_to']; ?></code></span>
            			<div id="colorPickerDiv_addtocart_button_bg_colour_to" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="addtocart_button_border_size"><?php _e('Border Size','wpec_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="addtocart_button_border_size" name="wpec_compare_addtocart_style[addtocart_button_border_size]">
							<option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $addtocart_button_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_button_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="addtocart_button_border_style"><?php _e('Border Style', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="addtocart_button_border_style" name="wpec_compare_addtocart_style[addtocart_button_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'wpec_cp');?></option>
                                  <option <?php if( $addtocart_button_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'wpec_cp');?></option>
                                  <option <?php if( $addtocart_button_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'wpec_cp');?></option>
                                  <option <?php if( $addtocart_button_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'wpec_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Solid', 'wpec_cp');?></code></span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_border_colour"><?php _e('Border Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $addtocart_button_border_colour ) );?>" style="width:120px;" id="addtocart_button_border_colour" name="wpec_compare_addtocart_style[addtocart_button_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_button_border_colour']; ?></code></span>
            			<div id="colorPickerDiv_addtocart_button_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_border_rounded"><?php _e('Border Rounded','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    <label><input type="radio" name="wpec_compare_addtocart_style[addtocart_button_border_rounded]" value="rounded" checked="checked" /> <?php _e('Rounded Corners','wpec_cp'); ?></label> <span class="description">(<?php _e('Default', 'wpec_cp');?>)</span> &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><?php _e('Rounded Value','wpec_cp'); ?> <input type="text" name="wpec_compare_addtocart_style[addtocart_button_border_rounded_value]" value="<?php esc_attr_e( stripslashes( $addtocart_button_border_rounded_value) );?>" style="width:120px;" />px</label> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_button_border_rounded_value']; ?></code>px</span>
                    <br />
                    <label><input type="radio" name="wpec_compare_addtocart_style[addtocart_button_border_rounded]" value="square"  <?php if($addtocart_button_border_rounded == 'square'){ echo 'checked="checked"'; } ?> /> <?php _e('Square Corners','wpec_cp'); ?></label>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="addtocart_button_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="addtocart_button_font" name="wpec_compare_addtocart_style[addtocart_button_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $addtocart_button_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="addtocart_button_font_size"><?php _e('Button Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="addtocart_button_font_size" name="wpec_compare_addtocart_style[addtocart_button_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $addtocart_button_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_button_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="addtocart_button_font_style"><?php _e('Button Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="addtocart_button_font_style" name="wpec_compare_addtocart_style[addtocart_button_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $addtocart_button_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $addtocart_button_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $addtocart_button_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $addtocart_button_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Bold', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_font_colour"><?php _e('Button Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_addtocart_style[addtocart_button_font_colour]" id="addtocart_button_font_colour" value="<?php esc_attr_e( stripslashes( $addtocart_button_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_button_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_addtocart_button_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_button_class"><?php _e('CSS Class','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="wpec_compare_addtocart_style[addtocart_button_class]" id="addtocart_button_class" value="<?php esc_attr_e( stripslashes( $addtocart_button_class ) );?>" style="min-width:300px" /> <span class="description"><?php _e("Enter your own button CSS class", 'wpec_cp'); ?></span>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3 class="addtocart_link_styling" style=" <?php if($addtocart_button_type != 'link') { echo 'display:none'; } ?>"><?php _e('Add To Cart Linked Text Styling', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table addtocart_link_styling" style=" <?php if($addtocart_button_type != 'link') { echo 'display:none'; } ?>">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_link_text"><?php _e('Linked Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $addtocart_link_text ) );?>" style="width:300px;" id="addtocart_link_text" name="wpec_compare_addtocart_style[addtocart_link_text]" /> <span class="description"><?php _e('For default', 'wpec_cp');?> <code>'<?php echo $default_settings['addtocart_link_text']; ?>'</code> <?php _e('or enter text', 'wpec_cp');?></span>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="addtocart_link_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="addtocart_link_font" name="wpec_compare_addtocart_style[addtocart_link_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $addtocart_link_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="addtocart_link_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="addtocart_link_font_size" name="wpec_compare_addtocart_style[addtocart_link_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $addtocart_link_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_link_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="addtocart_link_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="addtocart_link_font_style" name="wpec_compare_addtocart_style[addtocart_link_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $addtocart_link_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $addtocart_link_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $addtocart_link_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $addtocart_link_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Normal', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_link_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_addtocart_style[addtocart_link_font_colour]" id="addtocart_link_font_colour" value="<?php esc_attr_e( stripslashes( $addtocart_link_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_link_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_addtocart_link_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="addtocart_link_font_hover_colour"><?php _e('Font Hover Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_addtocart_style[addtocart_link_font_hover_colour]" id="addtocart_link_font_hover_colour" value="<?php esc_attr_e( stripslashes( $addtocart_link_font_hover_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['addtocart_link_font_hover_colour'] ?></code></span>
            			<div id="colorPickerDiv_addtocart_link_font_hover_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Price Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Price_Style{
	function get_settings_default() {
		$default_settings = array(
			'disable_product_price'			=> 0,
			'product_price_position'		=> 'both',
			
			'price_font'					=> 'Tahoma, Geneva, Verdana, sans-serif',
			'price_font_size'				=> '16px',
			'price_font_style'				=> 'bold',
			'price_font_colour'				=> '#CC3300',
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		
		$default_settings = WPEC_Compare_Price_Style::get_settings_default();
				
		if ($reset) {
			update_option('wpec_compare_product_prices_style', $default_settings);
		} else {
			update_option('wpec_compare_product_prices_style', $default_settings);
		}
				
	}
	
	function get_settings() {
		global $wpec_compare_product_prices_style;
		$wpec_compare_product_prices_style = WPEC_Compare_Price_Style::get_settings_default();
		
		return $wpec_compare_product_prices_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WPEC_Compare_Price_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Price_Style::set_settings_default(true);
		}
		
		$wpec_compare_product_prices_style = $default_settings = WPEC_Compare_Price_Style::get_settings_default();
		
		extract($wpec_compare_product_prices_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <script type="text/javascript">
			(function($){		
				$(function(){	
					$('#disable_product_price').click(function(){
						if ($(this).is(':checked')) {
							$(".product_price_position_row").hide();
						} else {
							$(".product_price_position_row").show();
						}
					});
				});		  
			})(jQuery);
		</script>
        <h3><?php _e('Product Price Settings', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="disable_product_price"><?php _e('Product Price', 'wpec_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="wpec_compare_product_prices_style[disable_product_price]" id="disable_product_price" value="1" <?php if ( $disable_product_price == 1) { echo 'checked="checked"';} ?> /> <?php _e(' Check to deactivate the Product Price on Comparison Table', 'wpec_cp'); ?></label></td>
                </tr>
                <tr class="product_price_position_row" style=" <?php if ( $disable_product_price == 1) { echo 'display:none;';} ?>">
                    <th class="titledesc" scope="row"><label for="product_price_position"><?php _e('Product Price Position', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:200px;" id="product_price_position" name="wpec_compare_product_prices_style[product_price_position]">
                          <option value="both" selected="selected"><?php _e('Top and Bottom', 'wpec_cp');?></option>
                          <option <?php if( $product_price_position == 'top'){ echo 'selected="selected"';} ?> value="top"><?php _e('Top Only', 'wpec_cp');?></option>
                          <option <?php if( $product_price_position == 'bottom'){ echo 'selected="selected"';} ?> value="bottom"><?php _e('Bottom Only', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Top and Bottom', 'wpec_cp');?></code></span>
                    </td>
				</tr>
            </tbody>
        </table>
        
        <h3><?php _e('Price Font', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr>
					<th class="titledesc" scope="row"><label for="table_price_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="table_price_font" name="wpec_compare_product_prices_style[price_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $price_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="table_price_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="table_price_font_size" name="wpec_compare_product_prices_style[price_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $price_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['price_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="table_price_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="table_price_font_style" name="wpec_compare_product_prices_style[price_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $price_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $price_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $price_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $price_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Bold', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="table_price_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_product_prices_style[price_font_colour]" id="table_price_font_colour" value="<?php esc_attr_e( stripslashes( $price_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['price_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_table_price_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Table Content Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Table_Content_Style
{
	public static function get_settings_default() {
		$default_settings = array(
			'feature_title_font'			=> 'Tahoma, Geneva, Verdana, sans-serif',
			'feature_title_font_size'		=> '12px',
			'feature_title_font_style'		=> 'bold',
			'feature_title_font_colour'		=> '#000000',
			'feature_title_align'			=> 'right',
			
			'content_font'					=> 'Tahoma, Geneva, Verdana, sans-serif',
			'content_font_size'				=> '12px',
			'content_font_style'			=> 'normal',
			'content_font_colour'			=> '#000000',
			
			'product_name_font'				=> 'Tahoma, Geneva, Verdana, sans-serif',
			'product_name_font_size'		=> '16px',
			'product_name_font_style'		=> 'bold',
			'product_name_font_colour'		=> '#CC3300',
			
			'empty_text'					=> __('N/A', 'wpec_cp'),
			'empty_cell_bg_colour'			=> '#000000',
			'empty_font'					=> 'Tahoma, Geneva, Verdana, sans-serif',
			'empty_font_size'				=> '12px',
			'empty_font_style'				=> 'bold',
			'empty_font_colour'				=> '#FFFFFF',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		
		$default_settings = WPEC_Compare_Table_Content_Style::get_settings_default();
				
		if ($reset) {
			update_option('wpec_compare_table_content_style', $default_settings);
		} else {
			update_option('wpec_compare_table_content_style', $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpec_compare_table_content_style;
		$wpec_compare_table_content_style = WPEC_Compare_Table_Content_Style::get_settings_default();
		
		return $wpec_compare_table_content_style;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WPEC_Compare_Table_Content_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Table_Content_Style::set_settings_default(true);
		}
		
		$wpec_compare_table_content_style = $default_settings = WPEC_Compare_Table_Content_Style::get_settings_default();
		
		extract($wpec_compare_table_content_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <h3><?php _e('Compare Feature Titles (Left Fixed Column)', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr>
					<th class="titledesc" scope="row"><label for="feature_title_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="feature_title_font" name="wpec_compare_table_content_style[feature_title_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $feature_title_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="feature_title_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="feature_title_font_size" name="wpec_compare_table_content_style[feature_title_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $feature_title_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['feature_title_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="feature_title_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="feature_title_font_style" name="wpec_compare_table_content_style[feature_title_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $feature_title_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $feature_title_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $feature_title_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $feature_title_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Bold', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="feature_title_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_table_content_style[feature_title_font_colour]" id="feature_title_font_colour" value="<?php esc_attr_e( stripslashes( $feature_title_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['feature_title_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_feature_title_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr>
                    <th class="titledesc" scope="row"><label for="feature_title_align"><?php _e('Title Alignment', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="feature_title_align" name="wpec_compare_table_content_style[feature_title_align]">
                          <option value="right" selected="selected"><?php _e('Right', 'wpec_cp');?></option>
                          <option <?php if( $feature_title_align == 'center'){ echo 'selected="selected" ';} ?>value="center"><?php _e('Center', 'wpec_cp');?></option>
                          <option <?php if( $feature_title_align == 'left'){ echo 'selected="selected" ';} ?>value="left"><?php _e('Left', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Right', 'wpec_cp');?></code></span>
                    </td>
				</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Table Rows Feature Values Font', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr>
					<th class="titledesc" scope="row"><label for="table_content_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="table_content_font" name="wpec_compare_table_content_style[content_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $content_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="table_content_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="table_content_font_size" name="wpec_compare_table_content_style[content_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $content_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['content_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="table_content_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="table_content_font_style" name="wpec_compare_table_content_style[content_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $content_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $content_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $content_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $content_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Normal', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="table_content_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_table_content_style[content_font_colour]" id="table_content_font_colour" value="<?php esc_attr_e( stripslashes( $content_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['content_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_table_content_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Empty Feature Values Row Cell Display', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="empty_text"><?php _e('Default Text','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $empty_text ) );?>" style="width:120px;" id="empty_text" name="wpec_compare_table_content_style[empty_text]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['empty_text']; ?></code></span>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="empty_cell_bg_colour"><?php _e('Cell Background Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $empty_cell_bg_colour ) );?>" style="width:120px;" id="empty_cell_bg_colour" name="wpec_compare_table_content_style[empty_cell_bg_colour]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['empty_cell_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_empty_cell_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="empty_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="empty_font" name="wpec_compare_table_content_style[empty_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $empty_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="empty_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="empty_font_size" name="wpec_compare_table_content_style[empty_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $empty_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['empty_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="empty_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="empty_font_style" name="wpec_compare_table_content_style[empty_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $empty_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $empty_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $empty_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $empty_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Bold', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="empty_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_table_content_style[empty_font_colour]" id="empty_font_colour" value="<?php esc_attr_e( stripslashes( $empty_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['empty_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_empty_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Product Name Font', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr>
					<th class="titledesc" scope="row"><label for="table_product_name_font"><?php _e('Font', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="table_product_name_font" name="wpec_compare_table_content_style[product_name_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'wpec_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $product_name_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="table_product_name_font_size"><?php _e('Font Size', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="table_product_name_font_size" name="wpec_compare_table_content_style[product_name_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $product_name_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['product_name_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="table_product_name_font_style"><?php _e('Font Style', 'wpec_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="table_product_name_font_style" name="wpec_compare_table_content_style[product_name_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'wpec_cp');?></option>
                          <option <?php if( $product_name_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpec_cp');?></option>
                          <option <?php if( $product_name_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpec_cp');?></option>
                          <option <?php if( $product_name_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpec_cp');?></option>
                          <option <?php if( $product_name_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpec_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Bold', 'wpec_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="table_product_name_font_colour"><?php _e('Font Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="wpec_compare_table_content_style[product_name_font_colour]" id="table_product_name_font_colour" value="<?php esc_attr_e( stripslashes( $product_name_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['product_name_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_table_product_name_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
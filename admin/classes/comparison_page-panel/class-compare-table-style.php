<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Table Row Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WPEC_Compare_Table_Row_Style{
	function get_settings_default() {
		$default_settings = array(
			'table_border_size'				=> '1px',
			'table_border_style'			=> 'solid',
			'table_border_colour'			=> '#D6D6D6',
			
			'table_heading_bg_colour'		=> '#FFFFE0',
			'alt_row_bg_colour'				=> '#F6F6F6',
			
			'row_padding_topbottom'			=> 10,
			'row_padding_leftright'			=> 10,
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		
		$default_settings = WPEC_Compare_Table_Row_Style::get_settings_default();
				
		if ($reset) {
			update_option('wpec_compare_table_style', $default_settings);
		} else {
			update_option('wpec_compare_table_style', $default_settings);
		}
				
	}
	
	function get_settings() {
		global $wpec_compare_table_style;
		$wpec_compare_table_style = WPEC_Compare_Table_Row_Style::get_settings_default();
		
		return $wpec_compare_table_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WPEC_Compare_Table_Row_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WPEC_Compare_Table_Row_Style::set_settings_default(true);
		}
		
		$wpec_compare_table_style = $default_settings = WPEC_Compare_Table_Row_Style::get_settings_default();
		
		extract($wpec_compare_table_style);
		$fonts = WPEC_Compare_Functions::get_font();
		
		?>
        <h3><?php _e('Table Background', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="table_heading_bg_colour"><?php _e('Table Heading Background Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $table_heading_bg_colour ) );?>" style="width:120px;" id="table_heading_bg_colour" name="wpec_compare_table_style[table_heading_bg_colour]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['table_heading_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_table_heading_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="alt_row_bg_colour"><?php _e('Alternate Rows Background Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $alt_row_bg_colour ) );?>" style="width:120px;" id="alt_row_bg_colour" name="wpec_compare_table_style[alt_row_bg_colour]" /> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['alt_row_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_alt_row_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Table Border', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="table_border_size"><?php _e('Border Size','wpec_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="table_border_size" name="wpec_compare_table_style[table_border_size]">
							<option value="" selected="selected"><?php _e('Select Size', 'wpec_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $table_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['table_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="table_border_style"><?php _e('Border Style', 'wpec_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="table_border_style" name="wpec_compare_table_style[table_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'wpec_cp');?></option>
                                  <option <?php if( $table_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'wpec_cp');?></option>
                                  <option <?php if( $table_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'wpec_cp');?></option>
                                  <option <?php if( $table_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'wpec_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php _e('Solid', 'wpec_cp');?></code></span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="table_border_colour"><?php _e('Border Colour','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $table_border_colour ) );?>" style="width:120px;" id="table_border_colour" name="wpec_compare_table_style[table_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'wpec_cp');?> <code><?php echo $default_settings['table_border_colour']; ?></code></span>
            			<div id="colorPickerDiv_table_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Table Row Padding', 'wpec_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="row_padding_topbottom"><?php _e('Padding Top/Bottom','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $row_padding_topbottom ) );?>" style="width:120px;" id="row_padding_topbottom" name="wpec_compare_table_style[row_padding_topbottom]" />px <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['row_padding_topbottom']; ?></code>px</span>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="row_padding_leftright"><?php _e('Padding Left/Right','wpec_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $row_padding_leftright ) );?>" style="width:120px;" id="row_padding_leftright" name="wpec_compare_table_style[row_padding_leftright]" />px <span class="description"><?php _e('Default', 'wpec_cp');?> <code><?php echo $default_settings['row_padding_leftright']; ?></code>px</span>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>
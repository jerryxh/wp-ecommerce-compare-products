<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Settings
 *
 * Table Of Contents
 *
 * wpeccp_set_setting_default()
 * wpec_compare_settings_display()
 */
class WPEC_Compare_Settings{	
	
	function wpeccp_set_setting_default($reset=false){
		$comparable_settings = get_option('comparable_settings');
		if(!is_array($comparable_settings) || count($comparable_settings) < 1){
			$comparable_settings = array();	
		}
		
		if(!isset($comparable_settings['compare_logo']) || trim($comparable_settings['compare_logo']) == ''){
			$comparable_settings['compare_logo'] = '';
		}
		if(!isset($comparable_settings['popup_width']) || trim($comparable_settings['popup_width']) == '' || $reset){
			$comparable_settings['popup_width'] = 1000;
		}
		if(!isset($comparable_settings['popup_height']) || trim($comparable_settings['popup_height']) == '' || $reset){
			$comparable_settings['popup_height'] = 650;
		}
		if(!isset($comparable_settings['compare_container_height']) || trim($comparable_settings['compare_container_height']) == '' || $reset){
			$comparable_settings['compare_container_height'] = 500;
		}
		if(!isset($comparable_settings['auto_add']) || trim($comparable_settings['auto_add']) == '' || $reset){
			$comparable_settings['auto_add'] = 'yes';
		}
		if(!isset($comparable_settings['button_text']) || trim($comparable_settings['button_text']) == '' || $reset){
			$comparable_settings['button_text'] = 'Compare This*';
		}
		if(!isset($comparable_settings['button_type']) || trim($comparable_settings['button_type']) == '' || $reset){
			$comparable_settings['button_type'] = 'button';
		}
		update_option('comparable_settings', $comparable_settings);
	}
	
	function wpec_compare_settings_display(){
		global $wpdb;	
		$result_msg = '';	
		$comparable_setting_msg = '';
		
		if(isset($_REQUEST['bt_save_settings'])){
			$comparable_settings = get_option('comparable_settings');
			if(!isset($_REQUEST['auto_add'])) $comparable_settings['auto_add'] = 'no';
			$comparable_settings = array_merge((array)$comparable_settings, $_REQUEST);
			update_option('comparable_settings', $comparable_settings);
			$comparable_setting_msg = '<div class="updated" id="comparable_settings_msg"><p>'.__('Compare Settings Successfully saved','wpec_cp').'.</p></div>';
		}elseif(isset($_REQUEST['bt_reset_settings'])){
			WPEC_Compare_Settings::wpeccp_set_setting_default(true);
			$comparable_setting_msg = '<div class="updated" id="comparable_settings_msg"><p>'.__('Compare Settings Successfully reseted','wpec_cp').'.</p></div>';
		}
		?>
        <?php $comparable_settings = get_option('comparable_settings'); ?>
        <form action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings" method="post" name="form_comparable_settings" id="form_comparable_settings">    
        <h3><?php _e('Compare Pop-Up Window Setup', 'wpec_cp'); ?></h3>
        <?php echo $comparable_setting_msg; ?>  
		<table cellspacing="0" class="form-table">
			<tbody>
				<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_logo"><?php _e('Pop-Up Window Header Image','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="compare_logo" id="compare_logo" value="<?php if(isset($comparable_settings['compare_logo'])) echo $comparable_settings['compare_logo'] ?>" style="width:400px" />
                    	<div style="clear:both;"></div>
                    	<?php _e('To add a header image to your Compare Pop-Up Window put the full URL of the image you want to use. Use file formats .jpg .png. jpeg Your image can be any size. If it is not as wide as the Pop-Up Container that you set below it will sit in the centre at the top. If it is wider the bottom scroll bar will come into play.','wpec_cp'); ?>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="popup_width"><?php _e('Compare Pop-Up Width','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="popup_width" id="popup_width" value="<?php if(isset($comparable_settings['popup_width'])) echo $comparable_settings['popup_width'] ?>" style="width:100px" /> px
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="popup_height"><?php _e('Compare Pop-Up Height','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="popup_height" id="popup_height" value="<?php if(isset($comparable_settings['popup_height'])) echo $comparable_settings['popup_height'] ?>" style="width:100px" /> px
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_container_height"><?php _e('Pop-Up Container Height','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="compare_container_height" id="compare_container_height" value="<?php if(isset($comparable_settings['compare_container_height'])) echo $comparable_settings['compare_container_height'] ?>" style="width:100px" /> px
                    	<div style="clear:both;"></div>
                        <?php _e('Set at slightly less than the Pop-Up height to ensure that your Header Image and the Print button are always visible as users scroll down the products list of features.','wpec_cp'); ?>
                    </td>
               	</tr>
			</tbody>
		</table>
        <h3><?php _e('Product Page Compare Buttons', 'wpec_cp'); ?></h3>
        <table class="form-table">
			<tbody>
				<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="auto_add1"><?php _e('Auto Add Compare button','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="auto_add" id="auto_add1" value="yes" <?php if(isset($comparable_settings['auto_add']) && $comparable_settings['auto_add'] == 'yes'){ echo 'checked="checked"';} ?> /> <label for="auto_add1"><?php _e('Yes','wpec_cp'); ?></label>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="auto_add2"><?php _e('Manually set Show Compare button and/or Button Position','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="auto_add" id="auto_add2" value="no" <?php if(isset($comparable_settings['auto_add']) && $comparable_settings['auto_add'] == 'no'){ echo 'checked="checked"';} ?> /> <label for="auto_add2"><?php _e('Yes','wpec_cp'); ?></label>
                    	<div style="clear:both;"></div>
                        <?php _e('IMPORTANT! Select YES only it if you want to manually set / change the default position of the Compare Button / Link on your theme product pages. Use this function', 'wpec_cp'); ?> <code>&lt;?php if(function_exists('wpec_add_compare_button')) echo wpec_add_compare_button(); ?&gt;</code> <?php _e('to do that.','wpec_cp'); ?>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="button_type"><?php _e('Button or Text','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="button_type" id="button_type1" value="button" <?php if(isset($comparable_settings['button_type']) && $comparable_settings['button_type'] == 'button'){ echo 'checked="checked"';} ?> /> <label for="button_type1"><?php _e('Button','wpec_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="button_type" id="button_type2" value="link" <?php if(isset($comparable_settings['button_type']) && $comparable_settings['button_type'] == 'link'){ echo 'checked="checked"';} ?> /> <label for="button_type2"><?php _e('Link','wpec_cp'); ?></label> <img class="help_tip" tip='<?php _e('Show Compare feature on products as a Button or Hyperlink Text.', 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                    	<div style="clear:both;"></div>
                        <?php _e("If you select LINK - the hyperlinked text auto shows in your themes font and colour. It is not possible to auto know the Style and Colour of your themes BUTTONS as many themes have many different buttons. To set the style and Colour of the Compare button to the same as you theme use Class name 'bt_compare_this' for product pages and class name 'compare_button_go' for the sidebar widget.",'wpec_cp'); ?>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="button_text"><?php _e('BUTTON or LINK text','wpec_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="button_text" id="button_text" value="<?php if(isset($comparable_settings['button_text'])) echo $comparable_settings['button_text']; ?>" /> <img class="help_tip" tip='<?php _e('Add the text you want to show on your Compare Button / Link on the Products pages', 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for=""><?php _e('Show Compare Featured fields','wpec_cp'); ?></label></th>
                    <td class="forminp"><?php _e('To auto show and position the Product title and a list of the Compare features in your Themes product pages use this function','wpec_cp'); ?> <br /><code>&lt;?php if(function_exists('wpec_show_compare_fields')) echo wpec_show_compare_fields(); ?&gt;</code>
                    </td>
               	</tr>
			</tbody>
		</table>
        <p class="submit">
			<input type="submit" value="<?php _e('Save changes', 'wpec_cp'); ?>" class="button-primary" name="bt_save_settings" id="bt_save_settings">
			<input type="submit" name="bt_reset_settings" id="bt_reset_settings" class="button" value="<?php _e('Reset Settings', 'wpec_cp'); ?>"  />
	    </p>
		</form>
	<?php
	}
		
}
?>
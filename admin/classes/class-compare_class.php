<?php
/**
 * WPEC Compare Class
 *
 * Table Of Contents
 *
 * wpeccp_set_setting_default()
 * wpeccp_get_features_tab()
 * wpeccp_get_settings_tab()
 * wpeccp_right_sidebar()
 * wpec_compare_manager()
 * wpeccp_update_orders()
 */
class WPEC_Compare_Class{	
	public static $default_types = array(
									'input-text' => array('name' => 'Input Text', 'description' => 'Use when option is single Line of Text'),
									'text-area' => array('name' => 'Text Area', 'description' => 'When option is Multiple lines of Text'), 
									'checkbox' => array('name' => 'Check Box', 'description' => 'Options in a row allows multiple select'), 
									'radio' => array('name' => 'Radio button', 'description' => 'Like check box but only single select'), 
									'drop-down' => array('name' => 'Drop Down', 'description' => 'Options in dropdown, only select one'), 
									'multi-select' => array('name' => 'Multi Select', 'description' => 'Like Drop Down but mutiple select')
								);
	
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
	
	function wpeccp_get_features_tab($result_msg=''){
	?>
		<h2><?php _e('Add Compare Product Features','wpec_cp'); ?></h2>
        <p><?php _e('Upgrade to the PRO VERSION to be able to create unlimited number of Compare Feature Category Sets.','wpec_cp'); ?></p>
        <div style="clear:both;height:12px;"></div>
        <?php echo $result_msg; ?>
        <form action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features" method="post" name="form_add_compare" id="form_add_compare">
        <?php
			if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){
				$field_id = $_REQUEST['field_id'];
				$field = WPEC_Compare_Data::get_row($field_id);
			}
			$have_value = false;
		?>
        <?php
			if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){
		?>
        	<input type="hidden" value="<?php echo $field_id; ?>" name="field_id" id="field_id" />
        <?php		
			}
		?>
        	<table cellspacing="0" class="widefat post fixed">
            	<thead>
                	<tr><th class="manage-column" scope="col"><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){ _e('Edit Compare Feature','wpec_cp'); }else{ _e('Create New Compare Feature','wpec_cp'); } ?></th></tr>
                </thead>
                <tbody>
                	<tr>
                    	<td>
                        	<div style="width:200px; float:left"><label for="field_name"><?php _e('Feature Name','wpec_cp'); ?></label></div> <input type="text" name="field_name" id="field_name" value="<?php if(!empty($field)) echo stripslashes($field->field_name); ?>" style="width:400px" /> <img class="help_tip" tip='<?php _e('This is the Feature Name that users see in the Compare Fly-Out Window, for example-  System Height', 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both"></div>
                            <div style="width:200px; float:left"><label for="field_key"><?php _e('Feature Key','wpec_cp'); ?></label></div> <input type="text" name="field_key" id="field_key" value="<?php if(!empty($field)) echo stripslashes($field->field_key); ?>" style="width:400px" /> <img class="help_tip" tip="<?php _e("Users don't see this - its the features unique name on your database.", 'wpec_cp') ?>" src="<?php echo ECCP_IMAGES_URL; ?>/help.png" /><br />
							<div style="margin-left:200px; margin-bottom:10px;"><?php _e('Please do not enter space character.','wpec_cp'); ?></div>
                            <div style="clear:both"></div>
                            <div style="width:200px; float:left"><label for="field_type"><?php _e('Feature Input Type','wpec_cp'); ?></label></div> 
                            <select style="width:400px;" name="field_type" id="field_type">
                            <?php
								foreach(WPEC_Compare_Class::$default_types as $type => $type_name){
									if(!empty($field) && $type == $field->field_type){
										echo '<option value="'.$type.'" selected="selected">'.$type_name['name'].' - '.$type_name['description'].'</option>';	
									}else{
										echo '<option value="'.$type.'">'.$type_name['name'].' - '.$type_name['description'].'</option>';
									}
								}
								if(in_array($field->field_type, array('checkbox' , 'radio', 'drop-down', 'multi-select'))){
									$have_value = true;	
								}
							?>
                            </select> <img class="help_tip" tip="<?php _e("Users don't see this. You use this to set the data input field type that you will use on the product page to enter the Products data for this feature.", 'wpec_cp') ?>" src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both"></div>
                            <div id="field_value" <?php if(!$have_value){ echo 'style="display:none"';} ?>>
                                <div style="width:200px; float:left"><label for="default_value"><?php _e('Enter Input Type Options','wpec_cp'); ?></label><br /><?php _e('Each option in a line','wpec_cp'); ?></div> <textarea style="width:400px;height:100px; vertical-align:bottom;" name="default_value" id="default_value"><?php if(!empty($field)) echo stripslashes($field->default_value); ?></textarea> <img class="help_tip" tip="<?php _e("You have selected one of the Check Box, Radio Button, Drop Down, Mutli Select Input Types. Type your Options here, one line for each option.", 'wpec_cp') ?>" src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                                <div style="clear:both"></div>
                            </div>
                        	<div style="width:200px; float:left"><label for="field_unit"><?php _e('Feature Unit of Measurement','wpec_cp'); ?></label></div> <input type="text" name="field_unit" id="field_unit" value="<?php if(!empty($field)) echo stripslashes($field->field_unit); ?>" style="width:400px" /> <img class="help_tip" tip='<?php _e("e.g kgs, mm, lbs, cm, inches - the unit of measurement shows after the Feature name in (brackets) on the Compare Feature List on the front end. If you leave this blank you will just see the Feature name.", 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both"></div>
                            <div style="width:200px; float:left"><label for="field_description"><?php _e('Feature Description','wpec_cp'); ?></label></div> <input type="text" style="width:400px;" name="field_description" id="field_description" value="<?php if(!empty($field)) echo stripslashes($field->field_description); ?>"  /> <img class="help_tip" tip='<?php _e("The front end user does not see this. It is a short note that shows on the Feature data entry field on the Products edit page to remind your what the feature is about.", 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both"></div>
                    	</td>
                    </tr>
                    <tr>
                    	<td><input type="submit" name="bt_save_field" id="bt_save_field" class="button-primary" value="<?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){ _e('Save','wpec_cp'); }else{ _e('Create','wpec_cp'); } ?>"  /> <?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){ ?><a href="edit.php?post_type=wpsc-product&page=wpsc-comparable-settings"><input type="button" name="cancel" value="<?php _e('Cancel','wpec_cp'); ?>" class="button-primary" /></a><?php } ?></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div style="clear:both; margin-bottom:20px;"></div>
		<h2><?php _e('Compare Products Lite Master Category Features List','wpec_cp'); ?></h2>
        <ul>
        	<li>
            	<strong><?php _e("How to manage Master Category feature list",'wpec_cp'); ?></strong> <span class="wpeccp_read_more"><?php _e("Read More",'wpec_cp'); ?></span><br />
                <div class="wpeccp_description_text" style="display:none">
                	<p><?php _e("As soon as you create a Feature above you will see it appear at the bottom of the master category Feature list below. The features below are in the order that they will show for the Products in the Fly-Out window. You can change the order by dragging and dropping any feature up or down the list. You can edit any feature by clicking on the paper and pencil icon. You can delete any feature by clicking the RED X.",'wpec_cp'); ?></p>
                </div>
            </li>
        </ul> 
        <form action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features" method="post" name="form_compare_order" id="form_compare_order">      
          <div class="update_order_message">&nbsp;</div>
  		  <table cellspacing="0" class="widefat post fixed" style="width:500px">
            <thead>
            <tr>
              <th width="45" class="manage-column" scope="col"><?php _e('Order','wpec_cp'); ?></th>
              <th width="280" class="manage-column" scope="col"><?php _e('Feature Name','wpec_cp'); ?></th>
              <th width="129" class="manage-column" scope="col"><?php _e('Feature Input Type','wpec_cp'); ?></th>
              <th width="75" class="manage-column" scope="col"><?php _e('Action','wpec_cp'); ?></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
              <th class="manage-column" scope="col"><?php _e('Order','wpec_cp'); ?></th>
              <th class="manage-column" scope="col"><?php _e('Feature Name','wpec_cp'); ?></th>
              <th class="manage-column" scope="col"><?php _e('Feature Input Type','wpec_cp'); ?></th>
              <th class="manage-column" scope="col"><?php _e('Action','wpec_cp'); ?></th>
            </tr>
            </tfoot>          
            <tbody>
            	<tr>
				  <td class="tags column-tags" colspan="4">
               	<?php 
				  	$compare_fields = WPEC_Compare_Data::get_results('','field_order ASC');
					if(is_array($compare_fields) && count($compare_fields)>0){
				?>
                <?php wp_enqueue_script('jquery-ui-sortable'); ?>
                <?php $wpeccp_update_order = wp_create_nonce("wpeccp-update-order"); ?>
                <script type="text/javascript">
					(function($){
						$(function(){
							$("#compare_orders").sortable({ placeholder: "ui-state-highlight", opacity: 0.6, cursor: 'move', update: function() {
								var order = $(this).sortable("serialize") + '&action=wpeccp_update_orders&security=<?php echo $wpeccp_update_order; ?>';
								$.post("<?php echo admin_url('admin-ajax.php'); ?>", order, function(theResponse){
									$(".update_order_message").html(theResponse);
									$("#compare_orders").find(".compare_sort").each(function(index){
										$(this).html(index+1);
										$(this).parent("li").removeClass();
										if(index == 0){
											$(this).parent("li").addClass("first_record");	
										}
									});
								});
							}
							});
						});
					})(jQuery);
				</script>
                <?php
					echo '<ul class="compare_orders" style="width:60px;">';
					for($i=1; $i<=count($compare_fields);$i++){
						echo '<li>'.$i.'</li>';
					}
					echo '</ul>';
				?>
                	<ul class="compare_orders" id="compare_orders" style="width:505px;">
                <?php
					foreach($compare_fields as $field_data){
				?>
                		<li id="recordsArray_<?php echo $field_data->id; ?>"><div class="c_field_name"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $field_data->field_name; ?></div><div class="c_field_type"><?php echo WPEC_Compare_Class::$default_types[$field_data->field_type]['name']; ?></div><div class="c_field_action"><a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=edit&field_id=<?php echo $field_data->id; ?>" class="c_field_edit">&nbsp;</a> | <a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=delete&field_id=<?php echo $field_data->id; ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to delete', 'wpec_cp') ; ?> #<?php echo htmlspecialchars($field_data->field_name); ?>');">&nbsp;</a></div></li>
                <?php
					}
				?>
                    </ul>	
                <?php
					}else{
						_e('Do not have any Features','wpec_cp');
					}
				?>
                  </td>
				</tr>
            </tbody>          
          </table>
       	</form>
    <?php
	}
	
	function wpeccp_get_settings_tab($comparable_setting_msg=''){
	?>
		<h2><?php _e('WPEC Compare Product Settings','wpec_cp'); ?></h2>
        <?php $comparable_settings = get_option('comparable_settings'); ?>
        <?php echo $comparable_setting_msg; ?>
        <p><?php _e('Thanks for installing WPEC Compare Products Lite Version. Set up and manage all the of the Plugins functions from this admin page. Click the Read More links to read detailed instructions and use the tool tips for more help.','wpec_cp'); ?></p>
        <ul>
			<li>
				<strong><?php _e('How to use this page to set up and manage the Compare Products Plugin','wpec_cp'); ?></strong> <span class="wpeccp_read_more"><?php _e("Read More",'wpec_cp'); ?></span><br />
				<div class="wpeccp_description_text" style="display:none">
					<p><?php _e('Now you have Compare Products Lite activated it has auto added a Compare Button to all of your Products and the Compare sidebar widget. If you go to the front of your site and add any product to your Compare Products sidebar list and open the Compare Fly-Out by clicking the Compare Button you will see the product, but no Compare features. The PRO version does not auto add the Compare Button to Products and allows you to roll out the feature to each product as you add them, that is one of the reasons that PRO is more suitable for larger sites.','wpec_cp'); ?></p>
        			<p><?php _e('Setting up the Compare Products Lite feature on your site is a simple 3 step process.','wpec_cp'); ?></p>
        			<p><?php _e('STEP 1. Style your Compare Features. The Compare Lite plugin has auto added the Compare feature to all of your product pages. Follow the instructions below to style how the feature shows on your sites frontend.','wpec_cp'); ?></p>
                    <p><?php _e('STEP 2. Create Compare Product Features. After you have done your set up - go to the FEATURES tab at the top to add your Compare Product features.','wpec_cp'); ?></p>
                    <p><?php _e('STEP 3. Once you have Created some Compare Products features you then can start adding data for those features to your products OR if you do not want the Compare feature to show on that product you should deactivate the feature on that products page.','wpec_cp'); ?></p>
                    <p>&nbsp;</p>
				</div>
			</li>
		</ul>
        <div style="clear:both;"></div>
        <form action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings" method="post" name="form_comparable_settings" id="form_comparable_settings">      
  		  <table cellspacing="0" class="widefat post fixed">
            	<thead>
                	<tr><th class="manage-column" scope="col"><?php _e('Compare Set up','wpec_cp'); ?></th></tr>
                </thead>
                <tbody>
                    <tr>
                    	<td><h3><?php _e('COMPARE POP-UP WINDOW SETUP', 'wpec_cp'); ?></h3></td>
                    </tr>
                	<tr>
                    	<td>
                        	<div style="width:200px; float:left"><label for="compare_logo"><?php _e('Pop-Up Window Header Image','wpec_cp'); ?></label></div> <input type="text" name="compare_logo" id="compare_logo" value="<?php if(isset($comparable_settings['compare_logo'])) echo $comparable_settings['compare_logo'] ?>" style="width:400px" /><br />
                            <div style="margin-left:200px;"><?php _e('To add a header image to your Compare Pop-Up Window put the full URL of the image you want to use. Use file formats .jpg .png. jpeg Your image can be any size. If it is not as wide as the Pop-Up Container that you set below it will sit in the centre at the top. If it is wider the bottom scroll bar will come into play.','wpec_cp'); ?></div>
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for="popup_width"><?php _e('Compare Pop-Up Width','wpec_cp'); ?></label></div> <input type="text" name="popup_width" id="popup_width" value="<?php if(isset($comparable_settings['popup_width'])) echo $comparable_settings['popup_width'] ?>" style="width:100px" />px
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for="popup_height"><?php _e('Compare Pop-Up Height','wpec_cp'); ?></label></div> <input type="text" name="popup_height" id="popup_height" value="<?php if(isset($comparable_settings['popup_height'])) echo $comparable_settings['popup_height'] ?>" style="width:100px" />px
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for="compare_container_height"><?php _e('Pop-Up Container Height','wpec_cp'); ?></label></div> <input type="text" name="compare_container_height" id="compare_container_height" value="<?php if(isset($comparable_settings['compare_container_height'])) echo $comparable_settings['compare_container_height'] ?>" style="width:100px" />px <br />
                            <div style="margin-left:200px;"><?php _e('Set at slightly less than the Pop-Up height to ensure that your Header Image and the Print button are always visible as users scroll down the products list of features.','wpec_cp'); ?></div>
                            <div style="clear:both; height:20px;"></div>
                    	</td>
                 	</tr>
                    <tr>
                    	<td><h3><?php _e('COMPARE PRODUCT PAGE BUTTONS', 'wpec_cp'); ?></h3></td>
                    </tr>
                    <tr>
                    	<td>
                        	<div style="width:200px; float:left"><label for="auto_add1"><?php _e('Auto Add Compare button','wpec_cp'); ?></label></div> <input type="radio" name="auto_add" id="auto_add1" value="yes" <?php if(isset($comparable_settings['auto_add']) && $comparable_settings['auto_add'] == 'yes'){ echo 'checked="checked"';} ?> /> <label for="auto_add1"><?php _e('Yes','wpec_cp'); ?></label> <br />
                            <div style="margin-left:200px;"><?php _e("This feature must be set at YES in the FREE version for Compare Products to work. You can manually deactivate the Compare Button and features from any individual products page edit screen. If you'd prefer to be just able to just activate the Plugin and then add the Compare Products Button and Features to individual Products rather than ALL Products (and then have to deactivate on individual product pages) you can do that by upgrading to the PRO version. IMORTANT! If your theme does not auto show the Campare button on each product page you will need to activate the next option and take the necessary steps.", 'wpec_cp'); ?></div>
                            <div style="clear:both; height:20px;"></div>
                        	<div style="width:200px; float:left"><label for="auto_add2"><?php _e('Manually set Show Compare button and/or Button Position','wpec_cp'); ?></label></div> <input type="radio" name="auto_add" id="auto_add2" value="no" <?php if(isset($comparable_settings['auto_add']) && $comparable_settings['auto_add'] == 'no'){ echo 'checked="checked"';} ?> /> <label for="auto_add2"><?php _e('Yes','wpec_cp'); ?></label> <br />
                           <div style="margin-left:200px;"><?php _e('IMPORTANT! Select YES only it if you want to manually set / change the default position of the Compare Button / Link on your theme product pages. Use this function', 'wpec_cp'); ?> <code><br />&lt;?php if(function_exists('wpec_add_compare_button')) echo wpec_add_compare_button(); ?&gt;</code> <?php _e('to do that.','wpec_cp'); ?></div>
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for="button_type"><?php _e('Button or Text','wpec_cp'); ?></label></div> <input type="radio" name="button_type" id="button_type1" value="button" <?php if(isset($comparable_settings['button_type']) && $comparable_settings['button_type'] == 'button'){ echo 'checked="checked"';} ?> /> <label for="button_type1"><?php _e('Button','wpec_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="button_type" id="button_type2" value="link" <?php if(isset($comparable_settings['button_type']) && $comparable_settings['button_type'] == 'link'){ echo 'checked="checked"';} ?> /> <label for="button_type2"><?php _e('Link','wpec_cp'); ?></label> <img class="help_tip" tip='<?php _e('Show Compare feature on products as a Button or Hyperlink Text.', 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" /><br />
                            <div style="margin-left:200px;"><?php _e("If you select LINK - the hyperlinked text auto shows in your themes font and colour. It is not possible to auto know the Style and Colour of your themes BUTTONS as many themes have many different buttons. To set the style and Colour of the Compare button to the same as you theme use Class name 'bt_compare_this' for product pages and class name 'compare_button_go' for the sidebar widget.",'wpec_cp'); ?></div> 
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for="button_text"><?php _e('BUTTON or LINK text','wpec_cp'); ?></label></div> <input type="text" name="button_text" id="button_text" value="<?php if(isset($comparable_settings['button_text'])) echo $comparable_settings['button_text']; ?>" /> <img class="help_tip" tip='<?php _e('Add the text you want to show on your Compare Button / Link on the Products pages', 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for=""><?php _e('Show Compare Featured fields','wpec_cp'); ?></label></div>
                            <div style="margin-left:200px;"><?php _e('To auto show and position the Product title and a list of the Compare features in your Themes product pages use this function','wpec_cp'); ?> <br /><code>&lt;?php if(function_exists('wpec_show_compare_fields')) echo wpec_show_compare_fields(); ?&gt;</code></div>
                            <div style="clear:both; height:20px;"></div>
                    	</td>
                    </tr>
                    <tr>
                    	<td><input type="submit" name="bt_save_settings" id="bt_save_settings" class="button-primary" value="<?php _e('Save Settings','wpec_cp'); ?>"  /> <input type="submit" name="bt_reset_settings" id="bt_reset_settings" class="button-primary" value="<?php _e('Reset Settings','wpec_cp'); ?>"  /></td>
                    </tr>
                </tbody>
            </table>
       	</form>
    <?php
	}
	
	function wpeccp_right_sidebar(){
	?>
    	<div class="update_message">
        	<h3><?php _e('Rate This Plugin', 'wpec_cp'); ?></h3>
            <ul>
            	<li>* <a href="http://wordpress.org/extend/plugins/wp-ecommerce-compare-products/" target="_blank"><?php _e('Rate This Plugin','wpec_cp'); ?></a> - <?php _e('Help other WPEC user find this plugin, please give it your star rating on Wordpress.org. Good ratings really will help others discover it as well.','wpec_cp'); ?></li>
                <li>* <a href=http://a3rev.com/products-page/wp-e-commerce-plugins/wpec-compare-products/#user_previews target="_blank"><?php _e('Review This Plugin','wpec_cp'); ?></a> – <?php _e('Please write a Review on your experience with the plugin. It really helps us spread the word.','wpec_cp'); ?></a></li>
            </ul>
            <h3><?php _e('Plugin Info', 'wpec_cp'); ?></h3>
            <ul>
            	<li>* <a href=http://a3rev.com/products-page/wp-e-commerce-plugins/wpec-compare-products/#help target="_blank"><?php _e('Support','wpec_cp'); ?></a> - <?php _e('Please post your support requests, questions or suggestions on the Plugins home page - Under the HELP Tab.','wpec_cp'); ?></li>
            </ul>
        </div>
        <div class="update_message">
        	<h3><?php _e('COMPARE PRO FEATURES','wpec_cp'); ?></h3>
            <p><?php _e('Upgrade to','wpec_cp'); ?> <a href=http://a3rev.com/products-page/wp-e-commerce-plugins/wpec-compare-products/" target="_blanK">Compare Pro</a>:</p>
            <ul>
            	<li>* <?php _e('Seamless Upgrade - you do not lose any of the Compare Product Features you have set up on the Lite Version when you upgrade.','wpec_cp'); ?></li>
            	<li>* <?php _e('Compare Products – Easily and quickly manage, activate / deactivate, add and edit Compare Features on every product and variations on your site from the Compare Products admin panel.','wpec_cp'); ?></li>
                <li>* <?php _e('Compare Categories - Create and manage any number of Compare Product Categories to match different types of products on your sell on your site.','wpec_cp'); ?></li>
                <li>* <?php _e('Compare Features – Create Compare features and assign them to an individual Compare category or Multiple categories.','wpec_cp'); ?></li>
                <li>* <?php _e('Pop-Out Window only shows Compare Features for that Product.','wpec_cp'); ?></li>
            </ul>
        </div>
    <?php
	}
	
	function wpec_compare_manager(){
		global $wpdb;	
		$result_msg = '';	
		$comparable_setting_msg = '';
		$current_tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab'] : 'settings';
		
		if(isset($_REQUEST['bt_save_settings'])){
			$comparable_settings = get_option('comparable_settings');
			if(!isset($_REQUEST['auto_add'])) $comparable_settings['auto_add'] = 'no';
			$comparable_settings = array_merge((array)$comparable_settings, $_REQUEST);
			update_option('comparable_settings', $comparable_settings);
			$comparable_setting_msg = '<div class="updated below-h2" id="comparable_settings_msg"><p>'.__('Compare Settings Successfully saved','wpec_cp').'.</p></div>';
		}elseif(isset($_REQUEST['bt_reset_settings'])){
			WPEC_Compare_Class::wpeccp_set_setting_default(true);
			$comparable_setting_msg = '<div class="updated below-h2" id="comparable_settings_msg"><p>'.__('Compare Settings Successfully reseted','wpec_cp').'.</p></div>';
		}

		if(isset($_REQUEST['bt_save_field'])){
			if(isset($_REQUEST['field_id']) && $_REQUEST['field_id'] > 0){
				if(trim($_REQUEST['field_key']) == '' || WPEC_Compare_Data::check_field_key_for_update($_REQUEST['field_id'], $_REQUEST['field_key'])){
					$result = WPEC_Compare_Data::update_row($_REQUEST);
					$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature Successfully edited','wpec_cp').'.</p></div>';
				}else{
					$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('This Feature Key is existed, please enter other Feature Key','wpec_cp').'.</p></div>';
				}
			}else{
				if(trim($_REQUEST['field_key']) == '' || WPEC_Compare_Data::check_field_key($_REQUEST['field_key'])){
					$result = WPEC_Compare_Data::insert_row($_REQUEST);	
					if($result > 0){
						$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature Successfully created','wpec_cp').'.</p></div>';
					}else{
						$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Compare Feature Error created','wpec_cp').'.</p></div>';
					}
				}else{
					$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('This Feature Key is existed, please enter other Feature Key','wpec_cp').'.</p></div>';
				}
			}
		}
		
		if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'delete'){
			$field_id = trim($_REQUEST['field_id']);
			WPEC_Compare_Data::delete_row($field_id);
			$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature Successfully deleted','wpec_cp').'.</p></div>';
		}
		?>
        <style>
			.help_tip{margin-left:10px; vertical-align:middle;}
			.wpeccp_read_more{text-decoration:underline; cursor:pointer; margin-left:40px; color:#06F;}
			.update_order_message{color:#06C; margin:5px 0;}
			.update_message{padding:10px; background-color:#FFFFCC;border:1px solid #DDDDDD;margin-bottom:15px;}
			ul.compare_orders{float:left; margin:0; }
			ul.compare_orders li{padding-top:8px; border-top:1px solid #DFDFDF; margin:5px 0; line-height:20px;}
			ul.compare_orders .c_field_name{width:282px; float:left; padding-left:20px; background:url(<?php echo ECCP_IMAGES_URL; ?>/icon_sort.png) no-repeat 0 center;}
			ul.compare_orders .c_field_type{width:135px; float:left;}
			ul.compare_orders .c_field_edit{background:url(<?php echo ECCP_IMAGES_URL; ?>/icon_edit.png) no-repeat 0 0; width:16px; height:16px; display:inline-block;}
			ul.compare_orders .c_field_delete{background:url(<?php echo ECCP_IMAGES_URL; ?>/icon_del.png) no-repeat 0 0; width:16px; height:16px; display:inline-block;}
		</style>
        <script type="text/javascript">
			(function($){
				$(function(){
					$("#field_type").change( function() {
						var field_type = $(this).val();
						if(field_type == 'checkbox' || field_type == 'radio' || field_type == 'drop-down' || field_type == 'multi-select'){
							$("#field_value").show();	
						}else{
							$("#field_value").hide();
						}
					});
					$(".wpeccp_read_more").toggle(
						function(){
							$(this).html('Read Less');
							$(this).siblings(".wpeccp_description_text").slideDown('slow');
						},
						function(){
							$(this).html('Read More');
							$(this).siblings(".wpeccp_description_text").slideUp('slow');
						}
					);
				});
			})(jQuery);
			function confirmation(text) {
				var answer = confirm(text)
				if (answer){
					return true;
				}else{
					return false;
				}
			}
		</script>
        <div class="wrap">
        	<div class="icon32" id="icon-themes"><br></div><h2 class="nav-tab-wrapper">
		<?php
			$tabs = array(
				'settings' => __( 'Settings', 'wpec_cp' ),
				'features' => __( 'Features', 'wpec_cp' ),
			);
					
			foreach ($tabs as $name => $label) :
				echo '<a href="' . admin_url( 'edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=' . $name ) . '" class="nav-tab ';
				if( $current_tab==$name ) echo 'nav-tab-active';
				echo '">' . $label . '</a>';
			endforeach;
					
		?>
			</h2>
    		<div style="float:right; width:25%; margin-left:5%; margin-top:30px;">
    			<?php WPEC_Compare_Class::wpeccp_right_sidebar(); ?>
    		</div>
			<div style="width:70%; float:left;">
			<?php
                switch ($current_tab) :
                    case 'features':
                        WPEC_Compare_Class::wpeccp_get_features_tab($result_msg);
                        break;
                    default :
                        WPEC_Compare_Class::wpeccp_get_settings_tab($comparable_setting_msg);
                        break;
                endswitch;
                
            ?>        
                <div style="clear:both; margin-bottom:20px;"></div>
            </div>                 
    </div>  
	<?php
	}
		
	function wpeccp_update_orders(){
		check_ajax_referer( 'wpeccp-update-order', 'security' );
				
		$updateRecordsArray 	= $_REQUEST['recordsArray'];
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			WPEC_Compare_Data::update_order($recordIDValue, $listingCounter);
			$listingCounter++;
		}
		
		_e('You just save a new order for Compare Features.', 'wpec_cp');
		die();
	}
}
?>
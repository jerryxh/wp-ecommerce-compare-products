<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Fields
 *
 * Table Of Contents
 *
 * init_features_actions()
 * wpec_compare_manager()
 * wpeccp_features_orders()
 * wpeccp_update_orders()
 * features_search_area()
 */
class WPEC_Compare_Fields_Class {	
	public static $default_types = array(
									'input-text' => array('name' => 'Input Text', 'description' => 'Use when option is single Line of Text'),
									'text-area' => array('name' => 'Text Area', 'description' => 'When option is Multiple lines of Text'), 
									'checkbox' => array('name' => 'Check Box', 'description' => 'Options in a row allows multiple select'), 
									'radio' => array('name' => 'Radio button', 'description' => 'Like check box but only single select'), 
									'drop-down' => array('name' => 'Drop Down', 'description' => 'Options in dropdown, only select one'), 
									'multi-select' => array('name' => 'Multi Select', 'description' => 'Like Drop Down but mutiple select')
								);
	
	function init_features_actions() {
		$result_msg = '';	
		
		if(isset($_REQUEST['bt_save_field'])){
			$field_name = trim(strip_tags(addslashes($_REQUEST['field_name'])));
			if(isset($_REQUEST['field_id']) && $_REQUEST['field_id'] > 0){
				$field_id = trim($_REQUEST['field_id']);
				$count_field_name = WPEC_Compare_Data::get_count("field_name = '".$field_name."' AND id != '".$field_id."'");
				if ($field_name != '' && $count_field_name == 0) {
					$result = WPEC_Compare_Data::update_row($_REQUEST);
					if(isset($_REQUEST['field_cats']) && count((array)$_REQUEST['field_cats']) > 0){
						foreach($_REQUEST['field_cats'] as $cat_id){
							$check_existed = WPEC_Compare_Categories_Fields_Data::get_count("cat_id='".$cat_id."' AND field_id='".$field_id."'");
							if($check_existed == 0){
								WPEC_Compare_Categories_Fields_Data::insert_row($cat_id, $field_id);
							}
						}
						WPEC_Compare_Categories_Fields_Data::delete_row("field_id='".$field_id."' AND cat_id NOT IN(".implode(',', $_REQUEST['field_cats']).")");
					}else{
						WPEC_Compare_Categories_Fields_Data::delete_row("field_id='".$field_id."'");
					}
					$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature Successfully edited','wpec_cp').'.</p></div>';
				}else{
					$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Nothing edited! You already have a Compare Feature with that name. Use the Features Search function to find it. Use unique names to edit each Compare Feature.', 'wpec_cp').'</p></div>';
				}
			}else{
				$count_field_name = WPEC_Compare_Data::get_count("field_name = '".$field_name."'");
				if ($field_name != '' && $count_field_name == 0) {
					$field_id = WPEC_Compare_Data::insert_row($_REQUEST);	
					if($field_id > 0){
						WPEC_Compare_Categories_Fields_Data::delete_row("field_id='".$field_id."'");
						if(isset($_REQUEST['field_cats']) && count((array)$_REQUEST['field_cats']) > 0){
							foreach($_REQUEST['field_cats'] as $cat_id){
								WPEC_Compare_Categories_Fields_Data::insert_row($cat_id, $field_id);
							}
						}
						$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature Successfully created','wpec_cp').'.</p></div>';
					}else{
						$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Compare Feature Error created','wpec_cp').'.</p></div>';
					}
				}else{
					$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Nothing created! You already have a Compare Feature with that name. Use the Features Search function to find it. Use unique names to create each Compare Feature.', 'wpec_cp').'</p></div>';
				}
			}
		}elseif(isset($_REQUEST['bt_delete'])){
			$list_fields_delete = $_REQUEST['un_fields'];
			if(is_array($list_fields_delete) && count($list_fields_delete) > 0){
				foreach($list_fields_delete as $field_id){
					WPEC_Compare_Data::delete_row($field_id);
					WPEC_Compare_Categories_Fields_Data::delete_row("field_id='".$field_id."'");
				}
				$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature Successfully deleted','wpec_cp').'.</p></div>';
			}else{
				$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Please select Feature(s) to delete','wpec_cp').'.</p></div>';
			}
		}
		
		if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-delete'){
			$field_id = trim($_REQUEST['field_id']);
			if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] > 0){
				WPEC_Compare_Categories_Fields_Data::delete_row("field_id='".$field_id."' AND cat_id='".$_REQUEST['cat_id']."'");
				$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature successfully removed','wpec_cp').'.</p></div>';
			}else{
				WPEC_Compare_Data::delete_row($field_id);
				WPEC_Compare_Categories_Fields_Data::delete_row("field_id='".$field_id."'");
				$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature successfully deleted','wpec_cp').'.</p></div>';
			}
		}
		
		return $result_msg;
	}
	function wpec_compare_manager() {
		global $wpdb;
		?>
        <style>
			#field_type_chzn{width:300px !important;}
		</style>
        <h3 id="add_feature"><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-edit'){ _e('Edit Compare Product Features','wpec_cp'); }else{ _e('Add Compare Product Features','wpec_cp'); } ?></h3>
        <form action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features" method="post" name="form_add_compare" id="form_add_compare">
        <?php
			$have_value = false;
			if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-edit'){
				$field_id = $_REQUEST['field_id'];
				$field = WPEC_Compare_Data::get_row($field_id);
		?>
        	<input type="hidden" value="<?php echo $field_id; ?>" name="field_id" id="field_id" />
        <?php		
			}else{
				$field_id = 0;
			}
		?>
        	<table cellspacing="0" class="widefat post fixed form-table">
            	<thead>
                	<tr><th class="manage-column" scope="col"><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-edit'){ _e('Edit Compare Features','wpec_cp'); }else{ _e('Create New Compare Features','wpec_cp'); } ?></th></tr>
                </thead>
                <tbody>
                	<tr>
                    	<td>
                        	<div class="field_title"><label for="field_name"><?php _e('Feature Name','wpec_cp'); ?></label></div> <input type="text" name="field_name" id="field_name" value="<?php if(!empty($field)) echo stripslashes($field->field_name); ?>" style="min-width:300px" /> <img class="help_tip" tip='<?php _e('This is the Feature Name that users see in the Compare Fly-Out Window, for example-  System Height', 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both; height:20px"></div>
                        	<div class="field_title"><label for="field_unit"><?php _e('Feature Unit of Measurement', 'wpec_cp'); ?></label></div> <input type="text" name="field_unit" id="field_unit" value="<?php if (!empty($field)) echo stripslashes($field->field_unit); ?>" style="min-width:300px" /> <img class="help_tip" tip='<?php _e("e.g kgs, mm, lbs, cm, inches - the unit of measurement shows after the Feature name in (brackets). If you leave this blank you will just see the Feature name.", 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both; height:20px"></div>
                            <div class="field_title"><label for="field_type"><?php _e('Feature Input Type', 'wpec_cp'); ?></label></div>
                            <select style="min-width:300px;" name="field_type" id="field_type" class="chzn-select">
								<?php
                                foreach (WPEC_Compare_Fields_Class::$default_types as $type => $type_name) {
                                    if (!empty($field) && $type == $field->field_type) {
                                        echo '<option value="'.$type.'" selected="selected">'.$type_name['name'].' - '.$type_name['description'].'</option>';
                                    }else {
                                        echo '<option value="'.$type.'">'.$type_name['name'].' - '.$type_name['description'].'</option>';
                                    }
                                }
                                if (!empty($field) && in_array($field->field_type, array('checkbox' , 'radio', 'drop-down', 'multi-select'))) {
                                    $have_value = true;
                                }
                                ?>
                            </select> <img class="help_tip" tip="<?php _e("Users don't see this. Use to set the data input field type that you will use on to enter the Products data for this feature.", 'wpec_cp') ?>" src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both; height:20px"></div>
                            <div id="field_value" <?php if (!$have_value) { echo 'style="display:none"';} ?>>
                                <div class="field_title"><label for="default_value"><?php _e('Enter Input Type options', 'wpec_cp'); ?></label></div> <textarea style="min-width:300px;height:100px;" name="default_value" id="default_value"><?php if (!empty($field)) echo stripslashes($field->default_value); ?></textarea> <img class="help_tip" tip="<?php _e("You have selected one of the Check Box, Radio Button, Drop Down, Mutli Select Input Types. Type your Options here, one line for each option.", 'wpec_cp') ?>" src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />
                                <div style="clear:both"></div>
                            </div>
                            <div style="clear:both; height:20px"></div>
                            <div class="field_title"><label for="field_type"><?php _e('Assign Feature to Categories', 'wpec_cp'); ?></label></div>
                            	<?php
								$all_cat = WPEC_Compare_Categories_Data::get_results('', 'category_order ASC');
								$cat_fields = WPEC_Compare_Categories_Fields_Data::get_catid_results($field_id);
								if (is_array($all_cat) && count($all_cat) > 0) {
								?>
                                <select multiple="multiple" name="field_cats[]" data-placeholder="<?php _e('Select Compare Categories', 'wpec_cp'); ?>" style="width:300px; height:80px;" class="chzn-select">
                                <?php
								foreach ($all_cat as $cat) {
									if (in_array($cat->id, (array)$cat_fields)) {
								?>
                                	<option value="<?php echo $cat->id; ?>" selected="selected"><?php echo stripslashes($cat->category_name); ?></option>
                                <?php
									}else {
								?>
                                	<option value="<?php echo $cat->id; ?>"><?php echo stripslashes($cat->category_name); ?></option>
                                <?php	
									}
								}
								?>
                                </select>
								<?php
								}
								?>
                            <img class="help_tip" style="vertical-align:top;" tip='<?php _e("Assign features to one or more Categories. Features such as Colour, Size, Weight can be applicable to many Product categories. Create the Feature once and assign it to one or multiple categories.", 'wpec_cp') ?>' src="<?php echo ECCP_IMAGES_URL; ?>/help.png" />

                            <div style="clear:both"></div>
                    	</td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
	        	<input type="submit" name="bt_save_field" id="bt_save_field" class="button-primary" value="<?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-edit') { _e('Save', 'wpec_cp'); }else { _e('Create', 'wpec_cp'); } ?>"  /> <a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features" style="text-decoration:none;"><input type="button" name="cancel" value="<?php _e('Cancel', 'wpec_cp'); ?>" class="button" /></a>
	    	</p>
        </form>
        <div style="clear:both"></div>
        <?php
	}
	
	function wpeccp_features_orders() {
		$unavaliable_fields = WPEC_Compare_Categories_Fields_Data::get_unavaliable_field_results('field_name ASC');
		if (is_array($unavaliable_fields) && count($unavaliable_fields) > 0) {
			$un_i = 0;
?>
        <h3 id="#un_assigned"><?php _e('Un-Assigned Features (Assign to a Category to activate)', 'wpec_cp'); ?></h3>
        <form action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features" method="post" name="form_delete_fields" id="form_delete_fields" style="margin-bottom:30px;">
        	<table cellspacing="0" class="widefat post fixed" style="width:535px;">
            	<thead>
                	<tr>
                    	<th width="30" class="manage-column" scope="col" style="white-space: nowrap;"><input id="toggle1" class="toggle" type="checkbox" style="margin:0;" /></th>
                        <th width="35" class="manage-column" scope="col" style="white-space: nowrap;"><?php _e('No', 'wpec_cp'); ?></th>
                        <th class="manage-column" scope="col"><?php _e('Feature Name', 'wpec_cp'); ?></th>
                        <th width="90" class="manage-column" scope="col" style="text-align:right"><?php _e('Type', 'wpec_cp'); ?></th>
                        <th width="100" class="manage-column" scope="col" style="text-align:right"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
			foreach ($unavaliable_fields as $field_data) {
				$un_i++;
?>
                	<tr>
                    	<td><input class="list_fields" type="checkbox" name="un_fields[]" value="<?php echo $field_data->id; ?>" /></td>
                        <td><?php echo $un_i; ?></td>
                        <td><?php echo stripslashes($field_data->field_name); ?></td>
                        <td align="right"><?php echo WPEC_Compare_Fields_Class::$default_types[$field_data->field_type]['name']; ?></td>
                        <td align="right"><a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=field-edit&field_id=<?php echo $field_data->id; ?>" class="c_field_edit" title="<?php _e('Edit', 'wpec_cp') ?>" ><?php _e('Edit', 'wpec_cp') ?></a> | <a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=field-delete&field_id=<?php echo $field_data->id; ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to delete', 'wpec_cp') ; ?> #<?php echo htmlspecialchars($field_data->field_name); ?>');" title="<?php _e('Delete', 'wpec_cp') ?>" ><?php _e('Delete', 'wpec_cp') ?></a></td>
                	</tr>
                 <?php } ?>
                </tbody>
            </table>
            <div style="margin-top:10px;"><input type="submit" name="bt_delete" id="bt_delete" class="button-primary" value="<?php _e('Delete', 'wpec_cp') ; ?>" onclick="if (confirm('<?php _e('Are you sure about deleting this?', 'wpec_cp') ; ?>')) return true; else return false" /></div>
        </form>
        <?php
		}
		  
		$compare_cats = WPEC_Compare_Categories_Data::get_results('', 'category_order ASC');
		if (is_array($compare_cats) && count($compare_cats)>0) {
?>
        <h3><?php _e('Manage Compare Categories and Features', 'wpec_cp'); ?></h3>
        <p><?php _e('Use drag and drop to change Category order and Feature order within Categories.', 'wpec_cp') ?></p>
        <div class="updated below-h2 update_feature_order_message" style="display:none"><p></p></div>
        <div style="clear:both"></div>
        <ul style="margin:0; padding:0;" class="sorttable">
        <?php
			foreach ($compare_cats as $cat) {
				$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results("cat_id='".$cat->id."'", 'cf.field_order ASC');
?>
        <li id="recordsArray_<?php echo $cat->id; ?>">
          <input type="hidden" name="compare_orders_<?php echo $cat->id; ?>" class="compare_category_id" value="<?php echo $cat->id; ?>"  />
  		  <table cellspacing="0" class="widefat post fixed sorttable" id="compare_orders_<?php echo $cat->id; ?>" style="width:535px; margin-bottom:20px;">
            <thead>
            <tr>
              <th width="30" style="white-space: nowrap;"><span class="c_field_name">&nbsp;</span></th>
              <th><strong><?php echo stripslashes($cat->category_name) ;?></strong> :</th>
              <th width="90"></th>
              <th width="100" style="text-align:right; font-size:12px;white-space: nowrap;"><a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=cat-edit&category_id=<?php echo $cat->id; ?>" class="c_field_edit" title="<?php _e('Edit', 'wpec_cp') ?>"><?php _e('Edit', 'wpec_cp') ?></a> | <a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=cat-delete&category_id=<?php echo $cat->id; ?>" title="<?php _e('Delete', 'wpec_cp') ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to delete', 'wpec_cp') ; ?> #<?php echo htmlspecialchars($cat->category_name); ?>');"><?php _e('Delete', 'wpec_cp') ?></a><?php if (is_array($compare_fields) && count($compare_fields)>0) { ?> | <span class="c_openclose_table c_close_table" id="expand_<?php echo $cat->id; ?>">&nbsp;</span><?php }else {?> | <span class="c_openclose_none">&nbsp;</span><?php }?></th>
            </tr>
            </thead>
            <tbody class="expand_<?php echo $cat->id; ?>">
               	<?php
				if (is_array($compare_fields) && count($compare_fields)>0) {
					$i= 0;
					foreach ($compare_fields as $field_data) {
						$i++;
?>
                <tr id="recordsArray_<?php echo $field_data->id; ?>" style="display:none">
                	<td><span class="compare_sort"><?php echo $i; ?></span>.</td>
                    <td><div class="c_field_name"><?php echo stripslashes($field_data->field_name); ?></div></td>
                    <td align="right"><?php echo WPEC_Compare_Fields_Class::$default_types[$field_data->field_type]['name']; ?></td>
                    <td align="right"><a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=field-edit&field_id=<?php echo $field_data->id; ?>" class="c_field_edit" title="<?php _e('Edit', 'wpec_cp') ?>" ><?php _e('Edit', 'wpec_cp') ?></a> | <a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=field-delete&field_id=<?php echo $field_data->id; ?>&cat_id=<?php echo $cat->id; ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to remove', 'wpec_cp') ; ?> #<?php echo htmlspecialchars($field_data->field_name); ?> <?php _e('from', 'wpec_cp') ; ?> #<?php echo htmlspecialchars($cat->category_name); ?>');" title="<?php _e('Remove', 'wpec_cp') ?>" ><?php _e('Remove', 'wpec_cp') ?></a></td>
                </tr>
                <?php
					}
				}else {
					echo '<tr><td colspan="4">'.__('You have not assigned any Features to this category yet. No Hurry!', 'wpec_cp').'</td></tr>';
				}
?>
            </tbody>
          </table>
        </li>
        <?php
			}
?>
        </ul>
        		<?php wp_enqueue_script('jquery-ui-sortable'); ?>
                <?php $wpeccp_update_order = wp_create_nonce("wpeccp-update-order"); ?>
                <?php $wpeccp_update_cat_order = wp_create_nonce("wpeccp-update-cat-order"); ?>
                <script type="text/javascript">
					(function($){
						$(function(){
							$(".c_openclose_table").click( function() {
								if ( $(this).hasClass('c_close_table') ) {
									$(this).removeClass("c_close_table");
									$(this).addClass("c_open_table");
									$("tbody."+$(this).attr('id')+" tr").css('display', '');
								} else {
									$(this).removeClass("c_open_table");
									$(this).addClass("c_close_table");
									$("tbody."+$(this).attr('id')+" tr").css('display', 'none');
								}
							});

							var fixHelper = function(e, ui) {
								ui.children().each(function() {
									$(this).width($(this).width());
								});
								return ui;
							};

							$(".sorttable tbody").sortable({ helper: fixHelper, placeholder: "ui-state-highlight", opacity: 0.8, cursor: 'move', update: function() {
								var cat_id = $(this).parent('table').siblings(".compare_category_id").val();
								var order = $(this).sortable("serialize") + '&action=wpeccp_update_orders&security=<?php echo $wpeccp_update_order; ?>&cat_id='+cat_id;
								$.post("<?php echo ( ( is_ssl() || force_ssl_admin() || force_ssl_login() ) ? str_replace( 'http:', 'https:', admin_url( 'admin-ajax.php' ) ) : str_replace( 'https:', 'http:', admin_url( 'admin-ajax.php' ) ) ); ?>", order, function(theResponse){
									$(".update_feature_order_message p").html(theResponse);
									$(".update_feature_order_message").show();
									$("#compare_orders_"+cat_id).find(".compare_sort").each(function(index){
										$(this).html(index+1);
									});
								});
							}
							});

							$("ul.sorttable").sortable({ placeholder: "ui-state-highlight", opacity: 0.8, cursor: 'move', update: function() {
								var order = $(this).sortable("serialize") + '&action=wpeccp_update_cat_orders&security=<?php echo $wpeccp_update_cat_order; ?>';
								$.post("<?php echo ( ( is_ssl() || force_ssl_admin() || force_ssl_login() ) ? str_replace( 'http:', 'https:', admin_url( 'admin-ajax.php' ) ) : str_replace( 'https:', 'http:', admin_url( 'admin-ajax.php' ) ) ); ?>", order, function(theResponse){
									$(".update_feature_order_message p").html(theResponse).show();
									$(".update_feature_order_message").show();
								});
							}
							});
						});
					})(jQuery);
				</script>
        <?php
		}
	}
	
	function wpeccp_update_orders(){
		check_ajax_referer( 'wpeccp-update-order', 'security' );
	
		$updateRecordsArray 	= $_REQUEST['recordsArray'];
		$cat_id = $_REQUEST['cat_id'];
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			WPEC_Compare_Categories_Fields_Data::update_order($cat_id, $recordIDValue, $listingCounter);
			$listingCounter++;
		}
		
		_e('You just save the order for Compare Features.', 'wpec_cp');
		die();
	}
	
	function features_search_area() {
		global $wpdb;
	?>
    	<div id="icon-post" class="icon32 icon32-posts-post"><br></div>
        <h2><?php _e('Categories & Features', 'wpec_cp'); ?> <a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=add-new" class="add-new-h2"><?php _e('Add New', 'wpec_cp'); ?></a></h2>
        <div style="clear:both;height:12px"></div>
        <form method="get" action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features" name="compare_search_features">
        	<input type="hidden" name="post_type" value="wpsc-product"  />
            <input type="hidden" name="page" value="wpsc-compare-settings"  />
            <input type="hidden" name="tab" value="features"  />
        <?php
		$s_feature = '';
		if (isset($_REQUEST['s_feature']) && trim($_REQUEST['s_feature']) != '') $s_feature = trim(stripslashes($_REQUEST['s_feature'])); 
		?>
        	<table class="form-table" style="width:535px;">
                <tbody>
                	<tr valign="top">
                    	<th class="titledesc" scope="rpw" style="padding-left:0;"><input type="text" name="s_feature" id="s_feature" value="<?php echo $s_feature; ?>" style="min-width:300px" /></th>
                        <td class="forminp" style="padding-right:0; text-align:right;"><input type="submit" id="search_features" name="" value="<?php _e('Search Features', 'wpec_cp'); ?>" class="button"></td>
                    </tr>
                </tbody>
            </table>
        <?php
		if (isset($_REQUEST['s_feature'])) {
			$p = 1;
			$rows = 25;
			if (isset($_REQUEST['pp'])) $p = $_REQUEST['pp'];
			if (isset($_REQUEST['rows'])) $rows = $_REQUEST['rows'];
			$start = ($p - 1 ) * $rows;
			$end = $start+$rows;
			$div = 5;
			$keyword = trim(stripslashes($_REQUEST['s_feature']));
			
			$link = WPEC_Compare_Functions::modify_url(array('pp' => '', 'rows' => $rows, 's_feature' => $keyword ) );
			
			$character = 'latin1';
			if ( $wpdb->has_cap( 'collation' ) ) 
				if( ! empty($wpdb->charset ) ) $character = "$wpdb->charset";
			
			$where = "LOWER( CONVERT( field_name USING ".$character.") ) LIKE '%".strtolower(trim($_REQUEST['s_feature']))."%'";
			
			$total = WPEC_Compare_Data::get_count($where);
			if ($end > $total) $end = $total;
			$items = WPEC_Compare_Data::get_results($where, 'field_name ASC', $start.','.$rows);
			
			$innerPage = WPEC_Compare_Functions::printPage($link, $total, $p, $div, $rows, false);
			
			?>
            <h3><?php _e('Found', 'wpec_cp'); ?> <?php echo $total; ?> <?php _e('feature(s)', 'wpec_cp'); ?></h3>
            <?php
			if ($total > 0) {
			?>
        	<table cellspacing="0" class="widefat post fixed" style="width:535px;">
            	<thead>
                	<tr>
                        <th class="manage-column" scope="col"><?php _e('Feature Name', 'wpec_cp'); ?></th>
                        <th width="90" class="manage-column" scope="col" style="text-align:right"><?php _e('Type', 'wpec_cp'); ?></th>
                        <th width="100" class="manage-column" scope="col" style="text-align:right"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
			foreach ($items as $field_data) {
?>
                	<tr>
                        <td><?php echo stripslashes($field_data->field_name); ?></td>
                        <td align="right"><?php echo WPEC_Compare_Fields_Class::$default_types[$field_data->field_type]['name']; ?></td>
                        <td align="right"><a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=field-edit&field_id=<?php echo $field_data->id; ?>" class="c_field_edit" title="<?php _e('Edit', 'wpec_cp') ?>" ><?php _e('Edit', 'wpec_cp') ?></a> | <a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features&act=field-delete&field_id=<?php echo $field_data->id; ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to delete', 'wpec_cp') ; ?> #<?php echo htmlspecialchars($field_data->field_name); ?>');" title="<?php _e('Delete', 'wpec_cp') ?>" ><?php _e('Delete', 'wpec_cp') ?></a></td>
                	</tr>
                 <?php } ?>
                </tbody>
                <tfoot>
					<tr>
						<th class="manage-column column-title" colspan="3" style="padding:2px 7px">
                    		<div class="tablenav">
                                <span class="search_item_title"><?php _e('Show', 'wpec_cp'); ?>:</span>
                                <select name="rows" class="number_items">
                            <?php $number_items_array = array('15' => '15', '25' => '25', '50' => '50', '75' => '75', '100' => '100', '200' => '200', '1000000' => 'All'); 
                                foreach($number_items_array as $key => $value){
                                    if($key == $rows)
                                        echo "<option selected='selected' value='$key'>$value</option>";
                                    else
                                        echo "<option value='$key'>$value</option>";
                                }
                            ?>
                                </select>
                                <input type="submit" class="button" value="<?php _e('Go', 'wpec_cp'); ?>" name="" id="search_items" />
                                <div class="tablenav-pages"><span class="displaying-num"><?php _e('Displaying', 'wpec_cp') ; ?> <?php echo ($start+1); ?> - <?php echo $end; ?> <?php _e('of', 'wpec_cp') ; ?> <?php echo $total; ?></span><?php echo $innerPage;?></div>
                            </div>
						</th>
					</tr>
				</tfoot>
            </table>
            <?php
			}
		}
		?>
        </form>
    <?php	
	}
}
?>
<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Categories
 *
 * Table Of Contents
 *
 * init_categories_actions()
 * wpec_compare_categories_manager()
 * wpeccp_update_cat_orders()
 */
class WPEC_Compare_Categories_Class{
	
	function init_categories_actions() {
		global $wpdb;
		$cat_msg = '';
		if(isset($_REQUEST['bt_save_cat'])){
		}
		
		if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-delete'){
		}
		return $cat_msg;
	}
	function wpec_compare_categories_manager(){
		global $wpdb;	
		?>
        <h3><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit'){ _e('Edit Compare Product Categories','wpec_cp'); }else{ _e('Add Compare Product Categories','wpec_cp'); } ?></h3>
        <p><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] != 'cat-edit'){ _e('Create Categories based on groups of products that share the same compare feature list.', 'wpec_cp'); } ?></p>
        <form action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features" method="post" name="form_add_compare" id="form_add_compare">
        <?php
			if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit'){
				$category_id = $_REQUEST['category_id'];
				$cat_data = WPEC_Compare_Categories_Data::get_row($category_id);
		?>
        	<input type="hidden" value="<?php echo $category_id; ?>" name="category_id" id="category_id" />
        <?php		
			}
		?>
        	<table class="form-table">
                <tbody>
                	<tr valign="top">
                    	<th class="titledesc" scope="rpw"><label for="category_name"><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit'){ _e('Edit Category Name', 'wpec_cp'); } else { _e('Category Name', 'wpec_cp'); } ?></label></th>
                        <td class="forminp"><input type="text" name="category_name" id="category_name" value="<?php if (!empty($cat_data)) { echo stripslashes(htmlentities($cat_data->category_name)); } ?>" style="min-width:300px" /></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
	        	<input type="button" onclick="javascript:return alert_upgrade('<?php _e('Please upgrade to the Pro Version to activate Compare categories', 'wpec_cp') ; ?>');" name="bt_save_cat" id="bt_save_cat" class="button-primary" value="<?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { _e('Save', 'wpec_cp'); }else { _e('Create', 'wpec_cp'); } ?>"  /> <a href="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=features" style="text-decoration:none;"><input type="button" name="cancel" value="<?php _e('Cancel', 'wpec_cp'); ?>" class="button" /></a>
	    	</p>
        </form>
	<?php
	}
	
	function wpeccp_update_cat_orders(){
		check_ajax_referer( 'wpeccp-update-cat-order', 'security' );
		$updateRecordsArray 	= $_REQUEST['recordsArray'];
		
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			WPEC_Compare_Categories_Data::update_order($recordIDValue, $listingCounter);
			$listingCounter++;
		}
		
		_e('You just save the order for compare categories.', 'wpec_cp');
		die();
	}
}
?>
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
class WPEC_Compare_Categories_Class
{
	
	public static function init_categories_actions() {
		global $wpdb;
		$cat_msg = '';
		if(isset($_REQUEST['bt_save_cat'])){
			$category_name = trim(strip_tags(addslashes($_REQUEST['category_name'])));
			if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] > 0){
				$old_data = WPEC_Compare_Categories_Data::get_row($_REQUEST['category_id']);
				$count_category_name = WPEC_Compare_Categories_Data::get_count("category_name = '".$category_name."' AND id != '".$_REQUEST['category_id']."'");
				if ($category_name != '' && $count_category_name == 0) {
					$result = WPEC_Compare_Categories_Data::update_row($_REQUEST);
					$wpdb->query('UPDATE '.$wpdb->prefix.'postmeta SET meta_value="'.$category_name.'" WHERE meta_value="'.$old_data->category_name.'" AND meta_key="_wpsc_compare_category_name" ');
					$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category Successfully edited', 'wpec_cp').'.</p></div>';
				}else {
					$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Nothing edited! You already have a Compare Category with that name. Use unique names to edit each Compare Category.', 'wpec_cp').'</p></div>';
				}
			}else{
				$count_category_name = WPEC_Compare_Categories_Data::get_count("category_name = '".$category_name."'");
				if ($category_name != '' && $count_category_name == 0) {
					$category_id = WPEC_Compare_Categories_Data::insert_row($_REQUEST);
					if ($category_id > 0) {
						$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category Successfully created', 'wpec_cp').'.</p></div>';
					}else {
						$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Compare Category Error created', 'wpec_cp').'.</p></div>';
					}
				}else {
					$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Nothing created! You already have a Compare Category with that name. Use unique names to create each Compare Category.', 'wpec_cp').'</p></div>';
				}
			}
		}
		
		if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-delete'){
			$category_id = trim($_REQUEST['category_id']);
			WPEC_Compare_Categories_Data::delete_row($category_id);
			WPEC_Compare_Categories_Fields_Data::delete_row("cat_id='".$category_id."'");
			$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category deleted','wpec_cp').'.</p></div>';
		}
		return $cat_msg;
	}
	public static function wpec_compare_categories_manager(){
		global $wpdb;	
		?>
        <h2><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit'){ _e('Edit Compare Product Categories','wpec_cp'); }else{ _e('Add Compare Product Categories','wpec_cp'); } ?></h2>
        <p><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] != 'cat-edit'){ _e('Create Categories based on groups of products that share the same compare feature list.', 'wpec_cp'); } ?></p>
        <form action="admin.php?page=wpsc-compare-features" method="post" name="form_add_compare" id="form_add_compare">
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
                        <td class="forminp"><input type="text" name="category_name" id="category_name" value="<?php if (!empty($cat_data)) { echo stripslashes($cat_data->category_name); } ?>" style="min-width:300px" /></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
	        	<input type="submit" name="bt_save_cat" id="bt_save_cat" class="button button-primary" value="<?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { _e('Save', 'wpec_cp'); }else { _e('Create', 'wpec_cp'); } ?>"  /> <input type="button" class="button" onclick="window.location='admin.php?page=wpsc-compare-features'" value="<?php _e('Cancel', 'wpec_cp'); ?>" />
	    	</p>
        </form>
	<?php
	}
	
	public static function wpeccp_update_cat_orders(){
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

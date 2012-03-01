<?php
include( '../../../wp-config.php');
if(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'update_orders'){
	$updateRecordsArray 	= $_REQUEST['recordsArray'];
		
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		WPEC_Compare_Data::update_order($recordIDValue, $listingCounter);
		$listingCounter++;
	}
	
	echo 'You just save the order for compare fields.';
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'add_to_compare'){
	$product_id 	= $_REQUEST['product_id'];
	WPEC_Compare_Functions::add_product_to_compare_list($product_id);
	echo WPEC_Compare_Functions::get_compare_list_html_widget();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'remove_from_compare'){
	$product_id 	= $_REQUEST['product_id'];
	WPEC_Compare_Functions::delete_product_on_compare_list($product_id);
	echo WPEC_Compare_Functions::get_compare_list_html_widget();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'remove_from_popup_compare'){
	$product_id 	= $_REQUEST['product_id'];
	WPEC_Compare_Functions::delete_product_on_compare_list($product_id);
	echo WPEC_Compare_Functions::get_compare_list_html_popup();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'clear_compare'){
	WPEC_Compare_Functions::clear_compare_list();
	echo WPEC_Compare_Functions::get_compare_list_html_widget();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'update_compare_widget'){
	echo WPEC_Compare_Functions::get_compare_list_html_widget();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'update_total_compare'){
	echo WPEC_Compare_Functions::get_total_compare_list();
}
?>
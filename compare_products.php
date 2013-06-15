<?php
/*
Plugin Name: WP e-Commerce Compare Products LITE
Description: Compare Products uses your existing WP e-Commerce Product Categories and Product Variations to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen.
Version: 2.1.2
Author: A3 Revolution
Author URI: http://www.a3rev.com/
License: This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007

	WP e-Commerce Compare Products Pro. Plugin for the WP e-Commerce shopping Cart.
	Copyright 2012 A3 Revolution Web Design
	
	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/
?>
<?php
define('ECCP_FILE_PATH', dirname(__FILE__));
define('ECCP_DIR_NAME', basename(ECCP_FILE_PATH));
define('ECCP_FOLDER', dirname(plugin_basename(__FILE__)));
define('ECCP_NAME', plugin_basename(__FILE__));
define('ECCP_URL', WP_CONTENT_URL.'/plugins/'.ECCP_FOLDER);
define('ECCP_DIR', WP_CONTENT_DIR . '/plugins/' . ECCP_FOLDER );
define('ECCP_JS_URL',  ECCP_URL . '/assets/js' );
define('ECCP_CSS_URL',  ECCP_URL . '/assets/css' );
define('ECCP_IMAGES_URL',  ECCP_URL . '/assets/images' );
if(!defined("ECCP_AUTHOR_URI"))
    define("ECCP_AUTHOR_URI", "http://a3rev.com/shop/wpec-compare-products/");

include 'includes/class-compare_functions.php';

include 'classes/data/class-fields_data.php';
include 'classes/data/class-categories_data.php';
include 'classes/data/class-categories_fields_data.php';

include 'classes/class-compare_filter.php';
include 'classes/class-compare_metabox.php';
include 'uploader/class-compare-uploader.php';
include 'widget/class-compare_widget.php';

include 'admin/classes/class-compare_categories.php';
include 'admin/classes/class-compare_fields.php';
include 'admin/classes/class-compare_products.php';

include 'admin/classes/product_page-panel/class-compare-product-page-settings.php';
include 'admin/classes/product_page-panel/class-compare-product-page-button-style.php';
include 'admin/classes/product_page-panel/class-compare-product-page-view-compare-style.php';
include 'admin/classes/product_page-panel/class-compare-product-page-tab.php';
include 'admin/classes/class-compare-product-page-panel.php';
	
include 'admin/classes/widget-panel/class-compare-widget-style.php';
include 'admin/classes/widget-panel/class-compare-widget-title-style.php';
include 'admin/classes/widget-panel/class-compare-widget-button-style.php';
include 'admin/classes/widget-panel/class-compare-widget-clear-all-style.php';
include 'admin/classes/widget-panel/class-compare-thumbnail-style.php';
include 'admin/classes/class-compare-widget-style-panel.php';

include 'admin/classes/grid_view-panel/class-compare-grid-view-settings.php';
include 'admin/classes/grid_view-panel/class-compare-grid-view-button-style.php';
include 'admin/classes/grid_view-panel/class-compare-grid-view-view-compare-style.php';
include 'admin/classes/class-compare-grid-view-panel.php';
	
include 'admin/classes/comparison_page-panel/class-compare-comparison-page-global-settings.php';
include 'admin/classes/comparison_page-panel/class-compare-page-style.php';
include 'admin/classes/comparison_page-panel/class-compare-table-style.php';
include 'admin/classes/comparison_page-panel/class-compare-table-content-style.php';
include 'admin/classes/comparison_page-panel/class-compare-price-style.php';
include 'admin/classes/comparison_page-panel/class-compare-addtocart-style.php';
include 'admin/classes/comparison_page-panel/class-compare-viewcart-style.php';
include 'admin/classes/comparison_page-panel/class-compare-print-message-style.php';
include 'admin/classes/comparison_page-panel/class-compare-print-button-style.php';
include 'admin/classes/comparison_page-panel/class-compare-close-window-button-style.php';
include 'admin/classes/class-compare-page-panel.php';

// Editor
include 'tinymce3/tinymce.php';
	
include 'admin/compare_init.php';

function wpec_add_compare_button($product_id='', $echo=false){
	$html = WPEC_Compare_Hook_Filter::add_compare_button($product_id);	
	if($echo) echo $html;
	else return $html;
}

function wpec_show_compare_fields($product_id='', $echo=false){
	global $wpec_compare_product_page_tab;
	if ($wpec_compare_product_page_tab['disable_compare_featured_tab'] != 1) {
		$html = WPEC_Compare_Hook_Filter::show_compare_fields($product_id);
		if($echo) echo $html;
		else return $html;
	} else {
		if($echo) echo '';
		else return false;	
	}
}

register_activation_hook(__FILE__,'wpec_compare_install');
?>
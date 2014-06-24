<?php
/*
Plugin Name: WP e-Commerce Compare Products LITE
Description: Compare Products uses your existing WP e-Commerce Product Categories and Product Variations to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen.
Version: 2.1.5.5
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
define('ECCP_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
define('ECCP_DIR', WP_CONTENT_DIR . '/plugins/' . ECCP_FOLDER );
define('ECCP_JS_URL',  ECCP_URL . '/assets/js' );
define('ECCP_CSS_URL',  ECCP_URL . '/assets/css' );
define('ECCP_IMAGES_URL',  ECCP_URL . '/assets/images' );
if(!defined("ECCP_AUTHOR_URI"))
    define("ECCP_AUTHOR_URI", "http://a3rev.com/shop/wpec-compare-products/");

include('admin/admin-ui.php');
include('admin/admin-interface.php');
	
include('admin/admin-pages/admin-product-comparison-page.php');
	
include('admin/admin-init.php');

include 'includes/class-compare_functions.php';

include 'classes/data/class-fields_data.php';
include 'classes/data/class-categories_data.php';
include 'classes/data/class-categories_fields_data.php';

include 'classes/class-compare_filter.php';
include 'classes/class-compare_metabox.php';
include 'widget/class-compare_widget.php';

include 'admin/classes/class-compare_categories.php';
include 'admin/classes/class-compare_fields.php';
include 'admin/classes/class-compare-features-panel.php';
include 'admin/classes/class-compare_products.php';

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
function wpec_compare_product_lite_uninstall(){
	if ( get_option('wpec_compare_product_lite_clean_on_deletion') == 1 ) {
			
			delete_option( 'wpec_compare_product_page_settings' );
			delete_option( 'wpec_compare_product_page_button_style' );
			delete_option( 'wpec_compare_product_page_tab' );
			delete_option( 'wpec_compare_product_page_view_compare_style' );
			delete_option( 'wpec_compare_widget_clear_all_style' );
			delete_option( 'wpec_compare_widget_button_style' );
			delete_option( 'wpec_compare_widget_style' );
			delete_option( 'wpec_compare_widget_thumbnail_style' );
			delete_option( 'wpec_compare_widget_title_style' );
			delete_option( 'wpec_compare_grid_view_button_style' );
			delete_option( 'wpec_compare_grid_view_settings' );
			delete_option( 'wpec_compare_gridview_view_compare_style' );
			delete_option( 'wpec_compare_addtocart_style' );
			delete_option( 'wpec_compare_close_window_button_style' );
			delete_option( 'wpec_compare_comparison_page_global_settings' );
			delete_option( 'wpec_compare_page_style' );
			delete_option( 'wpec_compare_print_page_settings' );
			delete_option( 'wpec_compare_product_prices_style' );
			delete_option( 'wpec_compare_table_content_style' );
			delete_option( 'wpec_compare_table_style' );
			delete_option( 'wpec_compare_viewcart_style' );
			
			delete_option( 'wpec_compare_addtocart_success' );
			delete_option( 'wpec_compare_logo' );
			delete_option( 'wpec_compare_gridview_product_success_icon' );
			delete_option( 'wpec_compare_product_success_icon' );
			delete_option( 'wpec_compare_basket_icon' );
			
			delete_option( 'wpec_compare_product_lite_clean_on_deletion' );
			
			delete_post_meta_by_key('_wpsc_deactivate_compare_feature');
			delete_post_meta_by_key('_wpsc_compare_category');
			delete_post_meta_by_key('_wpsc_compare_category_name');
		
			wp_delete_post( get_option('product_compare_id') , true );
			
			global $wpdb;
			$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'wpec_compare_fields');
			$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'wpec_compare_categories');
			$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'wpec_compare_cat_fields');
		}
}
	
if ( get_option('wpec_compare_product_lite_clean_on_deletion') == 1 ) {
	register_uninstall_hook( __FILE__, 'wpec_compare_product_lite_uninstall' );
}
?>
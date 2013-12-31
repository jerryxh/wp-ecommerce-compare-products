<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Call this function when plugin is activated
 */
function wpec_compare_install(){
	update_option('a3rev_wpeccp_version', '2.1.5');
	$product_compare_id = WPEC_Compare_Functions::create_page( esc_sql( 'product-comparison' ), '', __('Product Comparison', 'wpec_cp'), '[product_comparison_page]' );
	update_option('product_compare_id', $product_compare_id);
	
	// Set Settings Default from Admin Init
	global $wpec_compare_admin_init;
	$wpec_compare_admin_init->set_default_settings();
	
	WPEC_Compare_Data::install_database();
	WPEC_Compare_Categories_Data::install_database();
	WPEC_Compare_Categories_Fields_Data::install_database();
	WPEC_Compare_Functions::add_meta_all_products();
	WPEC_Compare_Widget_Add::automatic_add_widget_to_sidebar();
	update_option('a3rev_wpeccp_just_confirm', 1);
	
	update_option('a3rev_wpeccp_just_installed', true);
}

update_option('a3rev_wpeccp_plugin', 'wpec_compare');

/**
 * Load languages file
 */
function wpeccp_init() {
	if ( get_option('a3rev_wpeccp_just_installed') ) {
		delete_option('a3rev_wpeccp_just_installed');
		wp_redirect( admin_url( 'admin.php?page=wpsc-compare-features', 'relative' ) );
		exit;
	}
	load_plugin_textdomain( 'wpec_cp', false, ECCP_FOLDER.'/languages' );
}
// Add language
add_action('init', 'wpeccp_init');

// Add custom style to dashboard
add_action( 'admin_enqueue_scripts', array( 'WPEC_Compare_Hook_Filter', 'a3_wp_admin' ) );

// Add admin sidebar menu css
add_action( 'admin_enqueue_scripts', array( 'WPEC_Compare_Hook_Filter', 'admin_sidebar_menu_css' ) );

// Plugin loaded
add_action( 'plugins_loaded', array( 'WPEC_Compare_Functions', 'plugins_loaded' ), 8 );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WPEC_Compare_Hook_Filter', 'plugin_extra_links'), 10, 2 );

	// Need to call Admin Init to show Admin UI
	global $wpec_compare_admin_init;
	$wpec_compare_admin_init->init();
	
	// Add upgrade notice to Dashboard pages
	add_filter( $wpec_compare_admin_init->plugin_name . '_plugin_extension', array( 'WPEC_Compare_Functions', 'plugin_pro_notice' ) );

	// Replace the template file from plugin
	add_filter('template_include', array('WPEC_Compare_Hook_Filter', 'template_loader') );

	// Add Admin Menu
	add_action('admin_menu', array( 'WPEC_Compare_Hook_Filter', 'register_admin_screen' ), 9 );
	
	// AJAX update orders for compare fields in dashboard
	add_action('wp_ajax_wpeccp_update_orders', array('WPEC_Compare_Fields_Class', 'wpeccp_update_orders') );
	add_action('wp_ajax_nopriv_wpeccp_update_orders', array('WPEC_Compare_Fields_Class', 'wpeccp_update_orders') );
	
	// AJAX update orders for compare categories in dashboard
	add_action('wp_ajax_wpeccp_update_cat_orders', array('WPEC_Compare_Categories_Class', 'wpeccp_update_cat_orders') );
	add_action('wp_ajax_nopriv_wpeccp_update_cat_orders', array('WPEC_Compare_Categories_Class', 'wpeccp_update_cat_orders') );
	
	// AJAX update compare popup
	add_action('wp_ajax_wpeccp_update_compare_popup', array('WPEC_Compare_Hook_Filter', 'wpeccp_update_compare_popup') );
	add_action('wp_ajax_nopriv_wpeccp_update_compare_popup', array('WPEC_Compare_Hook_Filter', 'wpeccp_update_compare_popup') );

	// AJAX update compare widget
	add_action('wp_ajax_wpeccp_update_compare_widget', array('WPEC_Compare_Hook_Filter', 'wpeccp_update_compare_widget') );
	add_action('wp_ajax_nopriv_wpeccp_update_compare_widget', array('WPEC_Compare_Hook_Filter', 'wpeccp_update_compare_widget') );
	
	// AJAX update total compare
	add_action('wp_ajax_wpeccp_update_total_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_update_total_compare') );
	add_action('wp_ajax_nopriv_wpeccp_update_total_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_update_total_compare') );
	
	// AJAX add to compare
	add_action('wp_ajax_wpeccp_add_to_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_add_to_compare') );
	add_action('wp_ajax_nopriv_wpeccp_add_to_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_add_to_compare') );
	
	// AJAX remove product from compare widget
	add_action('wp_ajax_wpeccp_remove_from_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_remove_from_compare') );
	add_action('wp_ajax_nopriv_wpeccp_remove_from_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_remove_from_compare') );
	
	// AJAX remove product from compare popup
	add_action('wp_ajax_wpeccp_remove_from_popup_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_remove_from_popup_compare') );
	add_action('wp_ajax_nopriv_wpeccp_remove_from_popup_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_remove_from_popup_compare') );
	
	// AJAX clear compare widget
	add_action('wp_ajax_wpeccp_clear_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_clear_compare') );
	add_action('wp_ajax_nopriv_wpeccp_clear_compare', array('WPEC_Compare_Hook_Filter', 'wpeccp_clear_compare') );
	
	// AJAX get compare feature fields for product when change compare category
	add_action('wp_ajax_wpeccp_product_get_fields', array('WPEC_Compare_MetaBox', 'wpeccp_product_get_fields') );
	add_action('wp_ajax_nopriv_wpeccp_product_get_fields', array('WPEC_Compare_MetaBox', 'wpeccp_product_get_fields') );
	
	// AJAX get compare products 
	add_action('wp_ajax_wpeccp_get_products', array('WPEC_Compare_Products_Class', 'wpeccp_get_products') );
	add_action('wp_ajax_nopriv_wpeccp_get_products', array('WPEC_Compare_Products_Class', 'wpeccp_get_products') );
	
	// Include google fonts into header
	add_action( 'wp_head', array( 'WPEC_Compare_Hook_Filter', 'add_google_fonts'), 11 );
	
	// Include google fonts into header
	add_action( 'wpeccp_comparison_page_header', array( 'WPEC_Compare_Hook_Filter', 'add_google_fonts_comparison_page'), 11 );
	
	// Add Custom style on frontend
	add_action( 'wp_head', array( 'WPEC_Compare_Hook_Filter', 'include_customized_style'), 11);
	
	// Add script into footer to hanlde the event from widget, popup
	add_action('get_footer', array('WPEC_Compare_Hook_Filter', 'wpec_compare_footer_script'));
	
	if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')){
		require_once(ABSPATH.'wp-admin/includes/plugin.php');
		$wpec_version = get_plugin_data(WP_PLUGIN_DIR.'/wp-e-commerce/wp-shopping-cart.php');
		if(version_compare($wpec_version['Version'], '3.8.7', '<')){ 
			add_action('the_post', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
		}else{
			add_action('wpsc_product_form_fields_begin', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
		}
	}else{
		add_action('wpsc_product_form_fields_end', array('WPEC_Compare_Hook_Filter', 'show_compare_button'));
	}
	
	// Create Compare Category when Product Category is created
	add_action( 'create_wpsc_product_category',  array('WPEC_Compare_Hook_Filter', 'auto_create_compare_category'), 10, 2 );
	
	// Create Compare Feature when Product Variation is created
	add_action( 'create_wpsc-variation', array('WPEC_Compare_Hook_Filter', 'auto_create_compare_feature'), 10, 2 );
	
	// Add compare feature fields box into Edit product page
	add_action( 'admin_menu', array('WPEC_Compare_MetaBox', 'compare_meta_boxes'), 1 );
	if(in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))){
		add_action('save_post', array('WPEC_Compare_MetaBox','save_compare_meta_boxes' ) );
	}
	
	if (in_array(basename($_SERVER['PHP_SELF']), array('admin.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('wpsc-compare-products'))) {
		add_action('admin_footer', array('WPEC_Compare_Products_Class', 'wpeccp_compare_products_script'));
	}

// Check upgrade functions
add_action('plugins_loaded', 'wpec_cp_lite_upgrade_plugin');
function wpec_cp_lite_upgrade_plugin () {
	
	if(version_compare(get_option('a3rev_wpeccp_version'), '1.0.1') === -1){
		WPEC_Compare_Functions::upgrade_version_1_0_1();
		update_option('a3rev_wpeccp_version', '1.0.1');
	}
	if(version_compare(get_option('a3rev_wpeccp_version'), '2.0') === -1){
		WPEC_Compare_Functions::upgrade_version_2_0();
		update_option('a3rev_wpeccp_version', '2.0');
	}
	if(version_compare(get_option('a3rev_wpeccp_version'), '2.0.1') === -1){
		WPEC_Compare_Functions::upgrade_version_2_0_1();
		update_option('a3rev_wpeccp_version', '2.0.1');
	}
	if(version_compare(get_option('a3rev_wpeccp_version'), '2.0.3') === -1){
		WPEC_Compare_Functions::upgrade_version_2_0_3();
		update_option('a3rev_wpeccp_version', '2.0.3');
	}
	
	// Upgrade to 2.1.0
	if(version_compare(get_option('a3rev_wpeccp_version'), '2.1.0') === -1){
		WPEC_Compare_Functions::upgrade_version_2_1_0();
		update_option('a3rev_wpeccp_version', '2.1.0');
	}
	
	// Upgrade to 2.1.5
	if(version_compare(get_option('a3rev_wpeccp_version'), '2.1.5') === -1){
		WPEC_Compare_Functions::lite_upgrade_version_2_1_5();
		update_option('a3rev_wpeccp_version', '2.1.5');
		update_option('a3rev_wpeccp_lite_version', '2.1.5');
	}
	update_option('a3rev_wpeccp_version', '2.1.5');
	update_option('a3rev_wpeccp_lite_version', '2.1.5');

}
?>
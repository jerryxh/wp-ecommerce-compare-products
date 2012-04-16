<?php
/**
 * Call this function when plugin is activated
 */
function wpec_compare_set_settings(){
	wpec_compare_install();
	WPEC_Compare_Class::wpeccp_set_setting_default();	
}

function wpec_compare_install(){
	WPEC_Compare_Data::install_database();
	WPEC_Compare_Widget_Add::automatic_add_widget_to_sidebar();
}
update_option('a3rev_wpeccp_plugin', 'wpec_compare');
	
	// Add Admin Menu
	add_action( 'wpsc_add_submenu','wpeccp_add_menu_item_e_commerce' );
	
	// AJAX update orders for compare fields in dashboard
	add_action('wp_ajax_wpeccp_update_orders', array('WPEC_Compare_Class', 'wpeccp_update_orders') );
	add_action('wp_ajax_nopriv_wpeccp_update_orders', array('WPEC_Compare_Class', 'wpeccp_update_orders') );
	
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
	
	// AJAX get compare popup 
	add_action('wp_ajax_wpeccp_get_popup', array('WPEC_Compare_Hook_Filter', 'wpeccp_get_popup') );
	add_action('wp_ajax_nopriv_wpeccp_get_popup', array('WPEC_Compare_Hook_Filter', 'wpeccp_get_popup') );
	
	add_action('get_header', array('WPEC_Compare_Hook_Filter','wpeccp_print_scripts'));
	add_action('wp_print_styles', array('WPEC_Compare_Hook_Filter','wpeccp_print_styles'));
	
	// Add script into footer to hanlde the event from widget, popup
	add_action('get_footer', array('WPEC_Compare_Hook_Filter', 'wpec_compare_footer_script'));
	//add_action('the_post', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
	//add_action('wpsc_start_product', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));

	require_once(ABSPATH.'wp-admin/includes/plugin.php');
	$wpec_version = get_plugin_data(WP_PLUGIN_DIR.'/wp-e-commerce/wp-shopping-cart.php');
	if(version_compare($wpec_version['Version'], '3.8.7', '<')){ 
		add_action('the_post', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
	}else{
		add_action('wpsc_product_form_fields_begin', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
	}
	
	// Add compare feature fields box into Edit product page
	add_action( 'admin_menu', array('WPEC_Compare_MetaBox', 'compare_meta_boxes'), 1 );
	if(in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))){
		add_action('save_post', array('WPEC_Compare_MetaBox','save_compare_meta_boxes' ) );
	}
	if(in_array(basename($_SERVER['PHP_SELF']), array('admin.php', 'edit.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('wpsc-compare-settings'))){
		add_action('admin_footer', array('WPEC_Compare_Hook_Filter','wpeccp_admin_script'));
	}

// Add Menu Comparable Settings in E Commerce Plugins
function wpeccp_add_menu_item_e_commerce() {
	$products_page = 'edit.php?post_type=wpsc-product';
	$comparable_settings_page = add_submenu_page( $products_page , __( 'Compare Settings', 'wpec_cp' ), __( 'Compare Settings', 'wpec_cp' ), 'manage_options', 'wpsc-compare-settings', 'wpsc_display_comparable_settings' );
}

/**
 * Show dashboard of plugin
 */
function wpsc_display_comparable_settings(){
	WPEC_Compare_Class::wpec_compare_manager();
}
?>
<?php
function wpec_compare_set_settings(){
	wpec_compare_install();
	WPEC_Compare_Class::wpeccp_set_setting_default();	
}

function wpec_compare_install(){
	WPEC_Compare_Data::install_database();
	WPEC_Compare_Functions::activate_this_plugin();
}
update_option('a3rev_wpeccp_plugin', 'wpec_compare');
	
	// Add Admin Menu
	add_action( 'wpsc_add_submenu','wpeccp_add_menu_item_e_commerce' );
	
	add_action('get_header', array('WPEC_Compare_Hook_Filter','wpeccp_print_scripts'));
	add_action('wp_print_styles', array('WPEC_Compare_Hook_Filter','wpeccp_print_styles'));
	
	add_action('get_footer', array('WPEC_Compare_Hook_Filter', 'wpec_compare_footer_script'));
	//add_action('the_post', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
	add_action('wpsc_start_product', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
	
	// Add compare feature fields box into Edit product page
	add_action( 'admin_menu', array('WPEC_Compare_MetaBox', 'compare_meta_boxes'), 1 );
	if(in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))){
		add_action('save_post', array('WPEC_Compare_MetaBox','save_compare_meta_boxes' ) );
	}

// Add Menu Comparable Settings in E Commerce Plugins
function wpeccp_add_menu_item_e_commerce() {
	$products_page = 'edit.php?post_type=wpsc-product';
	$comparable_settings_page = add_submenu_page( $products_page , __( 'Comparable Settings', 'wpec_cp' ), __( 'Comparable Settings', 'wpec_cp' ), 'manage_options', 'wpsc-comparable-settings', 'wpsc_display_comparable_settings' );
}

function wpsc_display_comparable_settings(){
	if(isset($_POST['wpeccp_pin_submit'])){
		echo '<div id="message" class="updated fade"><p>'.get_option("a3rev_compare_message").'</p></div>';
	}
	WPEC_Compare_Class::wpec_compare_manager();
}
?>
<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Call this function when plugin is activated
 */
function wpec_compare_install(){
	update_option('a3rev_wpeccp_version', '2.1.4');
	$product_compare_id = WPEC_Compare_Functions::create_page( esc_sql( 'product-comparison' ), '', __('Product Comparison', 'wpec_cp'), '[product_comparison_page]' );
	update_option('product_compare_id', $product_compare_id);
	
	WPEC_Compare_Widget_Style::set_settings_default();
	WPEC_Compare_Widget_Title_Style::set_settings_default();
	WPEC_Compare_Widget_Button_Style::set_settings_default();
	WPEC_Compare_Widget_Clear_All_Style::set_settings_default();
	WPEC_Compare_Widget_Thumbnail_Style::set_settings_default();
	
	WPEC_Compare_Product_Page_Settings::set_settings_default();
	WPEC_Compare_Product_Page_Button_Style::set_settings_default();
	WPEC_Compare_Product_Page_View_Compare_Style::set_settings_default();
	WPEC_Compare_Product_Page_Tab::set_settings_default();
		
	WPEC_Compare_Grid_View_Settings::set_settings_default();
	WPEC_Compare_Grid_View_Button_Style::set_settings_default();
	WPEC_Compare_Grid_View_View_Compare_Style::set_settings_default();
	
	WPEC_Compare_Comparison_Page_Global_Settings::set_settings_default();
	WPEC_Compare_Page_Style::set_settings_default();
	WPEC_Compare_Table_Row_Style::set_settings_default();
	WPEC_Compare_Table_Content_Style::set_settings_default();
	WPEC_Compare_Price_Style::set_settings_default();
	WPEC_Compare_AddToCart_Style::set_settings_default();
	WPEC_Compare_ViewCart_Style::set_settings_default();
	WPEC_Compare_Print_Message_Style::set_settings_default();
	WPEC_Compare_Print_Button_Style::set_settings_default();
	WPEC_Compare_Close_Window_Button_Style::set_settings_default();
	
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
		wp_redirect( admin_url( 'edit.php?post_type=wpsc-product&page=wpsc-compare-settings', 'relative' ) );
		exit;
	}
	load_plugin_textdomain( 'wpec_cp', false, ECCP_FOLDER.'/languages' );
}
// Add language
add_action('init', 'wpeccp_init');

// Plugin loaded
add_action( 'plugins_loaded', array( 'WPEC_Compare_Functions', 'plugins_loaded' ), 8 );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WPEC_Compare_Hook_Filter', 'plugin_extra_links'), 10, 2 );

	// Replace the template file from plugin
	add_filter('template_include', array('WPEC_Compare_Hook_Filter', 'template_loader') );

	// Add Admin Menu
	add_action( 'wpsc_add_submenu','wpeccp_add_menu_item_e_commerce' );
	
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
	if(in_array(basename($_SERVER['PHP_SELF']), array('admin.php', 'edit.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('wpsc-compare-settings'))){
		add_action('admin_head', array('WPEC_Compare_Hook_Filter', 'wpeccp_admin_header_script'));
		add_action('admin_footer', array('WPEC_Compare_Hook_Filter','wpeccp_admin_script'));
	}
	if (in_array(basename($_SERVER['PHP_SELF']), array('edit.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('wpsc-compare-settings')) && isset($_REQUEST['tab']) && in_array($_REQUEST['tab'], array('compare-products'))) {
		add_action('admin_footer', array('WPEC_Compare_Products_Class', 'wpeccp_compare_products_script'));
	}
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
	
	update_option('a3rev_wpeccp_version', '2.1.4');


// Add Menu Comparable Settings in E Commerce Plugins
function wpeccp_add_menu_item_e_commerce() {
	if (get_option('a3rev_wpeccp_just_confirm') == 1) {
		WPEC_Compare_Data::automatic_add_features();
		WPEC_Compare_Categories_Data::automatic_add_compare_categories();
		update_option('a3rev_wpeccp_just_confirm', 0);
	}
	$products_page = 'edit.php?post_type=wpsc-product';
		
	$comparable_settings_page = add_submenu_page( $products_page , __( 'Compare Settings', 'wpec_cp' ), __( 'Compare Products', 'wpec_cp' ), 'manage_options', 'wpsc-compare-settings', 'wpeccp_dashboard' );
}

/**
 * Show dashboard of plugin
 */
function wpeccp_dashboard(){
?>
	<style>
		.code, code { font-family: inherit; font-size:inherit; }
		.form-table{margin:0;border-collapse:separate;}
		.chzn-container{margin-right:2px;}
		.field_title{width:205px; padding:0 8px 0 10px; float:left;}
		.help_tip{cursor: help;line-height: 1;margin: -4px 0 0 5px;padding: 0;vertical-align: middle;}
		.compare_set_1{width:46%; float:left; margin-right:5%; margin-bottom:15px;}
		.compare_set_2{width:46%; float:left; margin-bottom:15px;}
		.update_message{padding:10px; background-color:#FFFFCC;border:1px solid #DDDDDD;margin-bottom:15px;}
		.ui-sortable-helper{}
		.ui-state-highlight{background:#F6F6F6; height:24px; padding:8px 0 0; border:1px dotted #DDD; margin-bottom:20px;}
		ul.compare_orders{float:left; margin:0; width:100%}
		ul.compare_orders li{padding-top:8px; border-top:1px solid #DFDFDF; margin:5px 0; line-height:20px;}
		ul.compare_orders li.first_record{border-top:none; padding-top:0;}
		ul.compare_orders .compare_sort{float:left; width:60px;}
		.c_field_name{padding-left:20px; background:url(<?php echo ECCP_IMAGES_URL; ?>/icon_sort.png) no-repeat 0 center;}
		.c_openclose_table{cursor:pointer;}
		.c_openclose_none{width:16px; height:16px; display:inline-block;}
		.c_close_table{background:url(<?php echo get_option('siteurl'); ?>/wp-admin/images/arrows.png) no-repeat center 0px; width:16px; height:16px; display:inline-block;}
		.c_open_table{background:url(<?php echo get_option('siteurl'); ?>/wp-admin/images/arrows.png) no-repeat center -35px; width:16px; height:16px; display:inline-block;}
		ul.compare_orders .c_field_type{width:120px; float:left;}
		ul.compare_orders .c_field_manager{background:url(<?php echo ECCP_IMAGES_URL; ?>/icon_fields.png) no-repeat 0 0; width:16px; height:16px; display:inline-block;}
		.tablenav-pages{float:right;}
		.widefat th input {
			vertical-align:middle;
			padding:3px 8px;
			margin:auto;
		}
		.widefat th, .widefat td {
			overflow: inherit !important;	
		}
		.chzn-container-multi .chzn-choices {
			min-height:100px;	
		}
		
		ul.feature_compare_orders .compare_sort{margin-right:10px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_name{margin-right:10px;padding:5px 0 5px 20px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_action{float:right;}
		ul.feature_compare_orders .c_field_type{float:right; margin-right:10px; width:70px;}

		body .flexigrid div.sDiv{display:block;}
		.flexigrid div.sDiv .sDiv2 select{display:none;}
		.flexigrid div.sDiv .cp_search, .flexigrid div.sDiv .cp_reset{cursor:pointer;}
		.edit_product_compare{cursor:pointer; text-decoration:underline; color:#06F;}
		
		.icon32-compare-product {
			background:url(<?php echo ECCP_IMAGES_URL; ?>/a3-plugins.png) no-repeat left top !important;
		}
		.subsubsub { white-space:normal;}
		.subsubsub li { white-space:nowrap;}
		#wpec_compare_product_panel_container { position:relative; margin-top:10px;}
		#wpec_compare_product_panel_fields {width:60%; float:left;}
		#wpec_compare_product_upgrade_area { position:relative; margin-left: 60%; padding-left:10px;}
		#wpec_compare_product_extensions { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; color: #555555; margin: 0px; padding: 5px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); background:#FFFBCC; }
		.pro_feature_fields { margin-right: -12px; position: relative; z-index: 10; border:2px solid #E6DB55;-webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px; border-right: 2px solid #FFFFFF; }
		.pro_feature_fields h3, .pro_feature_fields p { margin-left:5px; }
	</style>
    <script>
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
				$('#toggle1').click(function(){
					if($('#toggle1').is(':checked')){
						$(".list_fields").attr("checked", "checked");
						$(".toggle2").attr("checked", "checked");
					}else{
						$(".list_fields").removeAttr("checked");
						$(".toggle2").removeAttr("checked");
					}
				});
				$('#toggle2').click(function(){
					if($('#toggle2').is(':checked')){
						$(".list_fields").attr("checked", "checked");
						$(".toggle1").attr("checked", "checked");
					}else{
						$(".list_fields").removeAttr("checked");
						$(".toggle1").removeAttr("checked");
					}
				});	
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
		
		function alert_upgrade(text) {
			var answer = confirm(text)
			if (answer){
				window.open("<?php echo ECCP_AUTHOR_URI; ?>", '_blank')
			}else{
				return false;
			}
		}
	</script>
    <div class="wrap">
    	<div class="icon32 icon32-compare-product" id="icon32-compare-product"><br></div><h2 class="nav-tab-wrapper">
    <?php 
			$current_tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab'] : '';
			$tabs = array(
				'features' => __( 'Features', 'wpec_cp' ),
				'compare-products' => __( 'Products', 'wpec_cp' ),
				'single-product' => __( 'Single Product', 'wpec_cp' ),
				'widget-style' => __( 'Widget Style', 'wpec_cp' ),
				'product-page-style' => __( 'Product Page Style', 'wpec_cp' ),
				'comparison-page' => __( 'Comparison Page', 'wpec_cp' ),
			);
					
			foreach ($tabs as $name => $label) :
				echo '<a href="' . admin_url( 'edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=' . $name, 'relative' ) . '" class="nav-tab ';
				if($current_tab == '' && $name == 'features') echo 'nav-tab-active';
				if( $current_tab==$name ) echo 'nav-tab-active';
				echo '">' . $label . '</a>';
			endforeach;
					
		?>
		</h2>
        <div style="width:100%; float:left;">
        <?php
		switch ($current_tab) :
			case 'single-product':
				WPEC_Compare_Product_Page_Panel::panel_manager();
				break;
			case 'compare-products':
				WPEC_Compare_Products_Class::wpeccp_products_manager();
				break;
			case 'widget-style':
				WPEC_Compare_Widget_Style_Panel::panel_manager();
				break;
			case 'product-page-style':
				WPEC_Compare_Grid_View_Panel::panel_manager();
				break;
			case 'comparison-page':
				WPEC_Compare_Page_Panel::panel_manager();
				break;
			default :
				echo '<div id="wpec_compare_product_panel_container"><div id="wpec_compare_product_panel_fields">';
				echo WPEC_Compare_Fields_Class::init_features_actions();
				echo WPEC_Compare_Categories_Class::init_categories_actions();
				if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'add-new') {
					WPEC_Compare_Categories_Class::wpec_compare_categories_manager();
					WPEC_Compare_Fields_Class::wpec_compare_manager();
				} else if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') {
					WPEC_Compare_Categories_Class::wpec_compare_categories_manager();
				} else if (isset($_REQUEST['act']) &&  $_REQUEST['act'] == 'field-edit') {
					WPEC_Compare_Fields_Class::wpec_compare_manager();
				} else if (isset($_REQUEST['s_feature'])) {
					WPEC_Compare_Fields_Class::features_search_area();
				} else {
					WPEC_Compare_Fields_Class::features_search_area();
					WPEC_Compare_Fields_Class::wpeccp_features_orders();
				}
				echo '</div><div id="wpec_compare_product_upgrade_area">'.WPEC_Compare_Functions::plugin_pro_notice().'</div></div>';
				break;
		endswitch;
		?>
        </div>
        <div style="clear:both; margin-bottom:20px;"></div>
    </div>
<?php	
}
?>
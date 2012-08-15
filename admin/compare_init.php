<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

/**
 * Call this function when plugin is activated
 */
function wpec_compare_set_settings(){
	update_option('a3rev_wpeccp_free_version', '2.0.3');
	WPEC_Compare_Settings::wpeccp_set_setting_default();	
	wpec_compare_install();
}

/**
 * Call this function when plugin is confirmed
 */
function wpec_compare_install(){
	WPEC_Compare_Data::install_database();
	WPEC_Compare_Categories_Data::install_database();
	WPEC_Compare_Categories_Fields_Data::install_database();
	WPEC_Compare_Categories_Data::auto_add_master_category();
	WPEC_Compare_Data::add_features_to_master_category();
	WPEC_Compare_Functions::add_meta_all_products();
	WPEC_Compare_Widget_Add::automatic_add_widget_to_sidebar();
	WPEC_Compare_Functions::auto_assign_master_category_to_all_products();
	update_option('a3rev_wpeccp_just_confirm', 1);
}
update_option('a3rev_wpeccp_plugin', 'wpec_compare');

/**
 * Load languages file
 */
function wpeccp_init() {
	load_plugin_textdomain( 'wpec_cp', false, ECCP_FOLDER.'/languages' );
}
// Add language
add_action('init', 'wpeccp_init');


	// Add Admin Menu
	add_action( 'wpsc_add_submenu','wpeccp_add_menu_item_e_commerce' );
	
	// AJAX update orders for compare fields in dashboard
	add_action('wp_ajax_wpeccp_update_orders', array('WPEC_Compare_Fields_Class', 'wpeccp_update_orders') );
	add_action('wp_ajax_nopriv_wpeccp_update_orders', array('WPEC_Compare_Fields_Class', 'wpeccp_update_orders') );
	
	// AJAX update orders for compare categories in dashboard
	add_action('wp_ajax_wpeccp_update_cat_orders', array('WPEC_Compare_Categories_Class', 'wpeccp_update_cat_orders') );
	add_action('wp_ajax_nopriv_wpeccp_update_cat_orders', array('WPEC_Compare_Categories_Class', 'wpeccp_update_cat_orders') );
	
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
	
	// AJAX get compare popup 
	add_action('wp_ajax_wpeccp_get_popup', array('WPEC_Compare_Hook_Filter', 'wpeccp_get_popup') );
	add_action('wp_ajax_nopriv_wpeccp_get_popup', array('WPEC_Compare_Hook_Filter', 'wpeccp_get_popup') );
	
	// AJAX get compare products 
	add_action('wp_ajax_wpeccp_get_products', array('WPEC_Compare_Products_Class', 'wpeccp_get_products') );
	add_action('wp_ajax_nopriv_wpeccp_get_products', array('WPEC_Compare_Products_Class', 'wpeccp_get_products') );
	
	// AJAX get product compare feature fields popup
	add_action('wp_ajax_wpeccp_popup_features', array('WPEC_Compare_Products_Class', 'wpeccp_popup_features') );
	add_action('wp_ajax_nopriv_wpeccp_popup_features', array('WPEC_Compare_Products_Class', 'wpeccp_popup_features') );
	
	add_action('get_header', array('WPEC_Compare_Hook_Filter','wpeccp_print_scripts'));
	add_action('wp_print_styles', array('WPEC_Compare_Hook_Filter','wpeccp_print_styles'));
	
	// Add script into footer to hanlde the event from widget, popup
	add_action('get_footer', array('WPEC_Compare_Hook_Filter', 'wpec_compare_footer_script'));
	//add_action('the_post', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
	//add_action('wpsc_start_product', array('WPEC_Compare_Hook_Filter', 'wpec_ajax_add_compare_button'));
	
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
		add_action('admin_footer', array('WPEC_Compare_Hook_Filter','wpeccp_admin_script'));
	}
	if (in_array(basename($_SERVER['PHP_SELF']), array('edit.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('wpsc-compare-settings')) && isset($_REQUEST['tab']) && in_array($_REQUEST['tab'], array('compare-products'))) {
		add_action('admin_footer', array('WPEC_Compare_Products_Class', 'wpeccp_compare_products_script'));
	}
	if(version_compare(get_option('a3rev_wpeccp_free_version'), '1.0.1') === -1){
		WPEC_Compare_Upgrade::upgrade_version_1_0_1();
		update_option('a3rev_wpeccp_free_version', '1.0.1');
	}
	if(version_compare(get_option('a3rev_wpeccp_free_version'), '2.0') === -1){
		WPEC_Compare_Upgrade::upgrade_version_2_0();
		update_option('a3rev_wpeccp_free_version', '2.0');
	}
	if(version_compare(get_option('a3rev_wpeccp_free_version'), '2.0.3') === -1){
		WPEC_Compare_Upgrade::upgrade_version_2_0_3();
		update_option('a3rev_wpeccp_free_version', '2.0.3');
	}
	update_option('a3rev_wpeccp_free_version', '2.0.3');

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WPEC_Compare_Hook_Filter', 'plugin_extra_links'), 10, 2 );

// Add Menu Comparable Settings in E Commerce Plugins
function wpeccp_add_menu_item_e_commerce() {
	if (get_option('a3rev_wpeccp_just_confirm') == 1) {
		WPEC_Compare_Data::automatic_add_features();
		WPEC_Compare_Categories_Data::automatic_add_compare_categories();
		update_option('a3rev_wpeccp_just_confirm', 0);
	}
	$products_page = 'edit.php?post_type=wpsc-product';
	
	//$compare_products_page = add_submenu_page( $products_page , __( 'Compare Products', 'wpec_cp' ), __( 'Compare Products', 'wpec_cp' ), 'manage_options', 'wpsc-compare-products', 'wpeccp_compare_products' );
	//add_action('admin_print_scripts-' . $compare_products_page, array('WPEC_Compare_Products_Class','wpeccp_compare_products_script'));
	
	$comparable_settings_page = add_submenu_page( $products_page , __( 'Compare Products', 'wpec_cp' ), __( 'Compare Products', 'wpec_cp' ), 'manage_options', 'wpsc-compare-settings', 'wpeccp_dashboard' );
}

/**
 * Show right sidebar in dashboard page
 */
function wpeccp_right_sidebar(){
?>
	
<?php
}

/**
 * Show dashboard of plugin
 */
function wpeccp_dashboard(){
?>
	<style>
		#compare_extensions { background: url("<?php echo ECCP_IMAGES_URL; ?>/logo_a3blue.png") no-repeat scroll 4px 6px #F1F1F1; -webkit-border-radius:4px;-moz-border-radius:4px;-o-border-radius:4px; border-radius: 4px 4px 4px 4px; color: #555555; float: right; margin: 10px 0 5px; padding: 4px 8px 4px 38px; position: relative; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); width: 200px;
		}
		.form-table{margin:0;border-collapse:separate;}
		.chzn-container{margin-right:2px;}
		.field_title{width:205px; padding:0 8px 0 10px; float:left;}
		.help_tip{cursor: help;line-height: 1;margin: -4px 0 0 5px;padding: 0;vertical-align: middle;}
		.compare_set_1{width:46%; float:left; margin-right:5%; margin-bottom:15px;}
		.compare_set_2{width:46%; float:left; margin-bottom:15px;}
		.update_message{padding:10px; background-color:#FFFFCC;border:1px solid #DDDDDD;margin-bottom:15px;}
		.wpeccp_read_more{text-decoration:underline; cursor:pointer; margin-left:40px; color:#06F;}
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
		.c_field_edit, .c_field_delete{cursor:pointer;}
		.widefat th input {
			vertical-align:middle;
			padding:3px 8px;
			margin:auto;
		}

		ul.feature_compare_orders .compare_sort{margin-right:10px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_name{margin-right:10px;padding:5px 0 5px 20px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_action{float:right;}
		ul.feature_compare_orders .c_field_type{float:right; margin-right:10px; width:70px;}

		body .flexigrid div.sDiv{display:block;}
		.flexigrid div.sDiv .sDiv2 select{display:none;}
		.flexigrid div.sDiv .cp_search, .flexigrid div.sDiv .cp_reset{cursor:pointer;}
		.edit_product_compare{cursor:pointer; text-decoration:underline; color:#06F;}
		.upgrade_message {color:#F00; font-size:16px;}
	</style>
    <script>
		(function($){
			$(function(){
				$(".wpeccp_read_more").toggle(
					function(){
						$(this).html('Read Less');
						$(this).siblings(".wpeccp_description_text").slideDown('slow');
					},
					function(){
						$(this).html('Read More');
						$(this).siblings(".wpeccp_description_text").slideUp('slow');
					}
				);
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
				window.open("<?php echo A3REV_AUTHOR_URI; ?>", '_blank')
			}else{
				return false;
			}
		}
	</script>
    <div class="wrap">
    	<div class="icon32" id="icon-themes"><br></div><h2 class="nav-tab-wrapper">
    <?php 
		if(isset($_POST['wpeccp_pin_submit'])){
			echo '<div id="message" class="updated fade"><p>'.get_option("a3rev_compare_message").'</p></div>';
		}
			$current_tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab'] : '';
			$tabs = array(
				'settings' => __( 'Settings', 'wpec_cp' ),
				'features' => __( 'Features', 'wpec_cp' ),
				'compare-products' => __( 'Products', 'wpec_cp' )
			);
					
			foreach ($tabs as $name => $label) :
				echo '<a href="' . admin_url( 'edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=' . $name ) . '" class="nav-tab ';
				if($current_tab == '' && $name == 'settings') echo 'nav-tab-active';
				if( $current_tab==$name ) echo 'nav-tab-active';
				echo '">' . $label . '</a>';
			endforeach;
					
		?>
		</h2>
        <div style="float:right; width:0%; margin-left:0%; margin-top:30px;">
            <?php wpeccp_right_sidebar(); ?>
        </div>
        <div style="width:100%; float:left;">
        <?php
		echo WPEC_Compare_Functions::compare_extension();
		switch ($current_tab) :
			case 'features':
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
				break;
			case 'compare-products':
				WPEC_Compare_Products_Class::wpeccp_products_manager();
				break;
			default :
				WPEC_Compare_Settings::wpec_compare_settings_display();
				break;
		endswitch;
		?>
        </div>
        <?php //if($current_tab == 'features') WPEC_Compare_Fields_Class::wpeccp_features_orders(); ?>
        <div style="clear:both; margin-bottom:20px;"></div>
    </div>
<?php	
}

/**
 * Show Compare Products Manager page
 */
function wpeccp_compare_products(){
?>
	<style type="text/css">
	body .flexigrid div.sDiv{display:block;}
	.flexigrid div.sDiv .sDiv2 select{display:none;}
	.flexigrid div.sDiv .cp_search, .flexigrid div.sDiv .cp_reset{cursor:pointer;}
	.edit_product_compare{cursor:pointer;}
	</style>
	<div class="wrap">
        
        <div style="">
		<?php WPEC_Compare_Products_Class::wpeccp_products_manager(); ?>
        </div>
        <div style="clear:both; margin-bottom:20px;"></div>
	</div>
<?php
}

?>

<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Hook Filter
 *
 * Table Of Contents
 *
 * template_loader()
 * include_customized_style()
 * wpec_ajax_add_compare_button()
 * add_compare_button()
 * show_compare_button()
 * show_compare_fields()
 * wpeccp_add_to_compare()
 * wpeccp_remove_from_popup_compare()
 * wpeccp_update_compare_popup()
 * wpeccp_update_compare_widget()
 * wpeccp_update_total_compare()
 * wpeccp_remove_from_compare()
 * wpeccp_clear_compare()
 * wpec_compare_footer_script()
 * wpeccp_admin_header_script()
 * wpeccp_admin_script()
 * auto_create_compare_category()
 * auto_create_compare_feature()
 * plugin_extra_links()
 */
class WPEC_Compare_Hook_Filter{
	
	function template_loader( $template ) {
		global $product_compare_id;
		global $post;

		if ( $product_compare_id == $post->ID ) {

			$file 	= 'product-compare.php';
			$find[] = $file;
			$find[] = apply_filters( 'ecommerce_compare_template_url', 'e-commerce/' ) . $file;
			
			$template = locate_template( $find );
			if ( ! $template ) $template = ECCP_FILE_PATH . '/templates/' . $file;

		}
	
		return $template;
	}
	
	function include_customized_style() {
		include( ECCP_DIR. '/templates/customized_style.php' );
	}
	
	function wpec_ajax_add_compare_button() {
		global $post;
		global $wpec_compare_product_page_settings;
		global $wpec_compare_grid_view_settings;
		global $wpec_compare_comparison_page_global_settings;
		global $product_compare_id;
		$product_id = $post->ID;
		if ( (is_singular('wpsc-product') && $wpec_compare_product_page_settings['disable_product_page_compare'] == 1 ) || (!is_singular('wpsc-product') && $wpec_compare_grid_view_settings['disable_grid_view_compare'] == 1) ) return;
		
		if ( is_singular('wpsc-product') && $wpec_compare_product_page_settings['auto_add'] == 'no') return;
		
		if ($post->post_type == 'wpsc-product' && WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id) ) {
			
			if ( is_singular('wpsc-product') ) {
				
				global $wpec_compare_product_page_button_style;
				global $wpec_compare_product_page_view_compare_style;
				
				$product_compare_custom_class = $wpec_compare_product_page_button_style['button_class'];
				$product_compare_text = $wpec_compare_product_page_button_style['product_compare_button_text'];
				$product_compare_class = 'wpec_bt_compare_this_button';
				if ($wpec_compare_product_page_button_style['product_compare_button_type'] == 'link') {
					$product_compare_custom_class = '';
					$product_compare_text = $wpec_compare_product_page_button_style['product_compare_link_text'];
					$product_compare_class = 'wpec_bt_compare_this_link';
				}
				
				$view_compare_html = '';
				if ($wpec_compare_product_page_view_compare_style['disable_product_view_compare'] == 0) {
					$product_view_compare_custom_class = '';
					$product_view_compare_text = $wpec_compare_product_page_view_compare_style['product_view_compare_link_text'];
					$product_view_compare_class = 'wpec_bt_view_compare_link';
					if ($wpec_compare_product_page_view_compare_style['product_view_compare_button_type'] == 'button') {
						$product_view_compare_custom_class = $wpec_compare_product_page_view_compare_style['button_class'];
						$product_view_compare_text = $wpec_compare_product_page_view_compare_style['product_view_compare_button_text'];
						$product_view_compare_class = 'wpec_bt_view_compare_button';
					}
					$product_compare_page = get_permalink($product_compare_id);
					if ($wpec_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') {
						$product_compare_page = '#';
					}
					$view_compare_html = '<div style="clear:both;"></div><a class="wpec_bt_view_compare '.$product_view_compare_class.' '.$product_view_compare_custom_class.'" href="'.$product_compare_page.'" target="_blank" alt="" title="" style="display:none;">'.$product_view_compare_text.'</a>';
				}
				
				$compare_html = '<div class="wpec_compare_button_container"><a class="wpec_bt_compare_this '.$product_compare_class.' '.$product_compare_custom_class.'" id="wpec_bt_compare_this_'.$product_id.'">'.$product_compare_text.'</a>' . $view_compare_html . '<input type="hidden" id="input_wpec_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
				
				$button_position = 'before';
				if ($wpec_compare_product_page_settings['product_page_button_position'] == 'below') $button_position = 'after';
				
			} else {
				
				global $wpec_compare_grid_view_button_style;
				global $wpec_compare_gridview_view_compare_style;
				
				$compare_grid_view_custom_class = $wpec_compare_grid_view_button_style['button_class'];
				$compare_grid_view_text = $wpec_compare_grid_view_button_style['button_text'];
				$compare_grid_view_class = 'wpec_bt_compare_this_button';
				
				$view_compare_html = '';
				
				$compare_html = '<div class="wpec_grid_compare_button_container"><a class="wpec_bt_compare_this '.$compare_grid_view_class.' '.$compare_grid_view_custom_class.'" id="wpec_bt_compare_this_'.$product_id.'">'.$compare_grid_view_text.'</a>' . $view_compare_html . '<input type="hidden" id="input_wpec_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
				
				$button_position = 'before';
				if ($wpec_compare_grid_view_settings['product_page_button_position'] == 'below') $button_position = 'after';
				
			}
			$script_add = '<script type="text/javascript">
				(function($){		
					$(function(){
						if($("#wpec_bt_compare_this_'.$product_id.'").length <= 0){
							if($("input#product_'.$product_id.'_submit_button").length > 0){
								$("input#product_'.$product_id.'_submit_button").'.$button_position.'(\''.$compare_html.'\');
							}else if($(".product_view_'.$product_id.'").length > 0){
								$(".product_view_'.$product_id.'").find(".more_details").'.$button_position.'(\''.$compare_html.'\');
							}else{
								$("input.wpsc_buy_button").'.$button_position.'(\''.$compare_html.'\');
							}
						}
					});		  
				})(jQuery);
				</script>';
			echo $script_add;
		}
	}
	
	function add_compare_button($product_id='') {
		global $post;
		global $wpec_compare_product_page_button_style;
		global $wpec_compare_comparison_page_global_settings;
		global $wpec_compare_product_page_view_compare_style;
		global $product_compare_id;
		extract($wpec_compare_product_page_button_style);
		if (trim($product_id) == '') $product_id = $post->ID;
		$post_type = get_post_type($product_id);
		$html = '';
		if ($post_type == 'wpsc-product' && WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id)) {
			$product_compare_custom_class = $wpec_compare_product_page_button_style['button_class'];
			$product_compare_text = $wpec_compare_product_page_button_style['product_compare_button_text'];
			$product_compare_class = 'wpec_bt_compare_this_button';
			if ($wpec_compare_product_page_button_style['product_compare_button_type'] == 'link') {
				$product_compare_custom_class = '';
				$product_compare_text = $wpec_compare_product_page_button_style['product_compare_link_text'];
				$product_compare_class = 'wpec_bt_compare_this_link';
			}
			
			$view_compare_html = '';
			if ($wpec_compare_product_page_view_compare_style['disable_product_view_compare'] == 0) {
				$product_view_compare_custom_class = '';
				$product_view_compare_text = $wpec_compare_product_page_view_compare_style['product_view_compare_link_text'];
				$product_view_compare_class = 'wpec_bt_view_compare_link';
				if ($wpec_compare_product_page_view_compare_style['product_view_compare_button_type'] == 'button') {
					$product_view_compare_custom_class = $wpec_compare_product_page_view_compare_style['button_class'];
					$product_view_compare_text = $wpec_compare_product_page_view_compare_style['product_view_compare_button_text'];
					$product_view_compare_class = 'wpec_bt_view_compare_button';
				}
				$product_compare_page = get_permalink($product_compare_id);
				if ($wpec_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') {
					$product_compare_page = '#';
				}
				$view_compare_html = '<div style="clear:both;"></div><a class="wpec_bt_view_compare '.$product_view_compare_class.' '.$product_view_compare_custom_class.'" href="'.$product_compare_page.'" target="_blank" alt="" title="" style="display:none;">'.$product_view_compare_text.'</a>';
			}
			
			$html .= '<div class="wpec_compare_button_container"><a class="wpec_bt_compare_this '.$product_compare_class.' '.$product_compare_custom_class.'" id="wpec_bt_compare_this_'.$product_id.'">'.$product_compare_text.'</a>' . $view_compare_html . '<input type="hidden" id="input_wpec_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
		}
		
		return $html;
	}
	
	function show_compare_button() {
		global $wpec_compare_product_page_settings;
		if ($wpec_compare_product_page_settings['auto_add'] == 'yes') {
			echo '<div class="wpsc_buy_button_container">'.WPEC_Compare_Hook_Filter::add_compare_button().'</div>';
		}
	}
	
	function show_compare_fields($product_id='', $use_table_style=true) {
		global $post, $wpec_compare_table_content_style;
		if(trim($product_id) == '') $product_id = $post->ID;
		$html = '';
		$variations_list = WPEC_Compare_Functions::get_variations($product_id);
		if (is_array($variations_list) && count($variations_list) > 0) {
			foreach ($variations_list as $variation_id) {
				if (WPEC_Compare_Functions::check_product_activate_compare($variation_id) && WPEC_Compare_Functions::check_product_have_cat($variation_id)) {
					$html .= '<div class="compare_product_variation"><h2>'.get_the_title($variation_id).'</h2></div>';
					if ($use_table_style) 
						$html .= '<table class="compare_featured_fields shop_attributes">'; 
					else
						$html .= '<ul class="compare_featured_fields">';
					$fixed_width = ' width="60%"';
					$compare_category = get_post_meta( $variation_id, '_wpsc_compare_category', true );
					$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'",'cf.field_order ASC');
					foreach ($compare_fields as $field_data) {
						$field_value = get_post_meta( $variation_id, '_wpsc_compare_'.$field_data->field_key, true );
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
						elseif (is_array($field_value) && count($field_value) < 0) $field_value = $wpec_compare_table_content_style['empty_text'];
						if (trim($field_value) == '') $field_value = $wpec_compare_table_content_style['empty_text'];
						if (trim($field_data->field_unit) != '') $field_unit = ' <span class="compare_featured_unit">('.trim($field_data->field_unit).')</span>';
						if ($use_table_style) 
							$html .= '<tr><th><span class="compare_featured_name">'.stripslashes($field_data->field_name).'</span>'.$field_unit.'</th><td '.$fixed_width.'><span class="compare_featured_value">'.$field_value.'</span></td></tr>';
						else
							$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.stripslashes($field_data->field_name).'</strong>'.$field_unit.'</span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
						$fixed_width = '';
					}
					if ($use_table_style) 
						$html .= '</table>';
					else 
						$html .= '</ul>';
				}
			}
		} elseif (WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id)) {
			$compare_category = get_post_meta( $product_id, '_wpsc_compare_category', true );
			$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'",'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {
				if ($use_table_style) 
					$html .= '<table class="compare_featured_fields shop_attributes">'; 
				else
					$html .= '<ul class="compare_featured_fields">';
				$fixed_width = ' width="60%"';
				foreach ($compare_fields as $field_data) {
					$field_value = get_post_meta( $product_id, '_wpsc_compare_'.$field_data->field_key, true );
					if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
					if (is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
					elseif (is_array($field_value) && count($field_value) < 0) $field_value = $wpec_compare_table_content_style['empty_text'];
					if (trim($field_value) == '') $field_value = $wpec_compare_table_content_style['empty_text'];
					if (trim($field_data->field_unit) != '') $field_unit = ' <span class="compare_featured_unit">('.trim(stripslashes($field_data->field_unit)).')</span>';
					if ($use_table_style) 
						$html .= '<tr><th><span class="compare_featured_name">'.stripslashes($field_data->field_name).'</span>'.$field_unit.'</th><td '.$fixed_width.'><span class="compare_featured_value">'.$field_value.'</span></td></tr>';
					else
						$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.stripslashes($field_data->field_name).'</strong>'.$field_unit.'</span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
					$fixed_width = '';
				}
				if ($use_table_style) 
					$html .= '</table>';
				else 
					$html .= '</ul>';
			}
		}
		return $html;
	}
	
	function wpeccp_add_to_compare() {
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		
		$product_id 	= $_REQUEST['product_id'];
		WPEC_Compare_Functions::add_product_to_compare_list($product_id);
		
		die();
	}
	
	function wpeccp_remove_from_popup_compare() {
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
	
		$product_id 	= $_REQUEST['product_id'];
		WPEC_Compare_Functions::delete_product_on_compare_list($product_id);
		
		die();
	}
	
	function wpeccp_update_compare_popup() {
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		$result = WPEC_Compare_Functions::get_compare_list_html_popup();
		$result .= '<script src="'. ECCP_JS_URL.'/fixedcolumntable/fixedcolumntable.js"></script>';
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_update_compare_widget() {
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		$result = WPEC_Compare_Functions::get_compare_list_html_widget();
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_update_total_compare() {
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		$result = WPEC_Compare_Functions::get_total_compare_list();
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_remove_from_compare() {
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		$product_id 	= $_REQUEST['product_id'];
		WPEC_Compare_Functions::delete_product_on_compare_list($product_id);
		die();
	}
	
	function wpeccp_clear_compare() {
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		WPEC_Compare_Functions::clear_compare_list();
		die();
	}
		
	function wpec_compare_footer_script(){
		global $product_compare_id;
		global $wpec_compare_comparison_page_global_settings;
		$wpeccp_compare_events = wp_create_nonce("wpeccp-compare-events");
		$wpeccp_compare_popup = wp_create_nonce("wpeccp-compare-popup");
		
		$script_add_on = '';
		$script_add_on .= '<script type="text/javascript">
				jQuery(document).ready(function($) {
						var ajax_url = "'.( ( is_ssl() || force_ssl_admin() || force_ssl_login() ) ? str_replace( 'http:', 'https:', admin_url( 'admin-ajax.php' ) ) : str_replace( 'https:', 'http:', admin_url( 'admin-ajax.php' ) ) ).'"';
		if ($wpec_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') {
			$script_add_on .= '
						$(document).on("click", ".wpec_compare_button_go, .wpec_bt_view_compare", function (event){
							var compare_url = "'.get_permalink($product_compare_id).'";
							window.open(compare_url, "'.__('Product_Comparison', 'wpec_cp').'", "scrollbars=1, width=980, height=650");
							event.preventDefault();
							return false;
					 
					  });';
		}
		$script_add_on .= '
						$(document).on("click", ".wpec_bt_compare_this", function(){
							var bt_compare_current = $(this);
							var product_id = $("#input_"+$(this).attr("id")).val();
							$(".wpec_compare_widget_loader").show();
							$(".wpec_compare_widget_container").html("");
							bt_compare_current.removeClass("compared");
							bt_compare_current.siblings(".wpec_bt_view_compare").hide();
							var data = {
								action: 		"wpeccp_add_to_compare",
								product_id: 	product_id,
								security: 		"'.$wpeccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								bt_compare_current.addClass("compared");
								bt_compare_current.siblings(".wpec_bt_view_compare").show();
								data = {
									action: 		"wpeccp_update_compare_widget",
									security: 		"'.$wpeccp_compare_events.'"
								};
								$.post( ajax_url, data, function(response) {
									result = $.parseJSON( response );
									$(".wpec_compare_widget_loader").hide();
									$(".wpec_compare_widget_container").html(result);
								});
								wpec_update_total_compare_list();
							});							
						});
						
						$(document).on("click", ".wpec_compare_remove_product", function(){
							var remove_product_id = $(this).attr("rel");
							$(".wpec_compare_widget_loader").show();
							$(".wpec_compare_widget_container").html("");
							var data = {
								action: 		"wpeccp_remove_from_compare",
								product_id: 	remove_product_id,
								security: 		"'.$wpeccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								data = {
									action: 		"wpeccp_update_compare_widget",
									security: 		"'.$wpeccp_compare_events.'"
								};
								$.post( ajax_url, data, function(response) {
									result = $.parseJSON( response );
									$(".wpec_compare_widget_loader").hide();
									$(".wpec_compare_widget_container").html(result);
								});
								wpec_update_total_compare_list();
							});
						});
						$(document).on("click", ".wpec_compare_clear_all", function(){
							$(".wpec_compare_widget_loader").show();
							$(".wpec_compare_widget_container").html("");
							var data = {
								action: 		"wpeccp_clear_compare",
								security: 		"'.$wpeccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								data = {
									action: 		"wpeccp_update_compare_widget",
									security: 		"'.$wpeccp_compare_events.'"
								};
								$.post( ajax_url, data, function(response) {
									result = $.parseJSON( response );
									$(".wpec_compare_widget_loader").hide();
									$(".wpec_compare_widget_container").html(result);
								});
								wpec_update_total_compare_list();
							});
						});
						
						function wpec_update_total_compare_list(){
							var data = {
								action: 		"wpeccp_update_total_compare",
								security: 		"'.$wpeccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								total_compare = $.parseJSON( response );
								$("#total_compare_product").html(total_compare);
							});
						}
					});		  
				</script>';
		echo $script_add_on;
	}
	
	function wpeccp_admin_header_script() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('farbtastic');
		wp_enqueue_style('farbtastic');
		
		WPEC_Compare_Uploader::uploader_js();
	}
	
	function wpeccp_admin_script(){
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style( 'a3rev-chosen-style', ECCP_JS_URL . '/chosen/chosen.css' );
		wp_enqueue_script( 'chosen', ECCP_JS_URL . '/chosen/chosen.jquery'.$suffix.'.js', array(), false, true );
		wp_enqueue_script( 'a3rev-chosen-script-init', ECCP_JS_URL.'/init-chosen.js', array(), false, true );
		
		wp_enqueue_style( 'tiptup_style', ECCP_JS_URL . '/tipTip/tipTip.css' );
		echo '<script src="'.ECCP_JS_URL . '/tipTip/jquery.tipTip'.$suffix.'.js" type="text/javascript"></script>';	
		?>
<script type="text/javascript">
jQuery(window).load(function(){
	// Subsubsub tabs
	jQuery('div.a3_subsubsub_section ul.subsubsub li a:eq(0)').addClass('current');
	jQuery('div.a3_subsubsub_section .section:gt(0)').hide();
	jQuery('div.a3_subsubsub_section ul.subsubsub li a').click(function(){
		var $clicked = jQuery(this);
		var $section = $clicked.closest('.a3_subsubsub_section');
		var $target  = $clicked.attr('href');
	
		$section.find('a').removeClass('current');
	
		if ( $section.find('.section:visible').size() > 0 ) {
			$section.find('.section:visible').fadeOut( 100, function() {
				$section.find( $target ).fadeIn('fast');
			});
		} else {
			$section.find( $target ).fadeIn('fast');
		}
	
		$clicked.addClass('current');
		jQuery('#last_tab').val( $target );
	
		return false;
	});
	<?php if (isset($_REQUEST['subtab']) && $_REQUEST['subtab']) echo 'jQuery("div.a3_subsubsub_section ul.subsubsub li a[href='.$_REQUEST['subtab'].']").click();'; ?>
});
(function($){		
	$(function(){
		// Tooltips
		jQuery(".help_tip").tipTip({
			"attribute" : "tip",
			"fadeIn" : 50,
			"fadeOut" : 50
		});
		// Color picker
		$('.colorpick').each(function(){
			$('.colorpickdiv', $(this).parent()).farbtastic(this);
			$(this).on('click',function() {
				if ( $(this).val() == "" ) $(this).val('#000000');
				$('.colorpickdiv', $(this).parent() ).show();
			});	
		});
		$(document).mousedown(function(){
			$('.colorpickdiv').hide();
		});
	});		  
})(jQuery);
</script>
	<?php
    }
	
	function auto_create_compare_category($term_id) {
		$term = get_term( $term_id, 'wpsc_product_category' );
		$check_existed = WPEC_Compare_Categories_Data::get_count("category_name='".trim($term->name)."'");
		if ($check_existed < 1 ) {
			WPEC_Compare_Categories_Data::insert_row(array('category_name' => trim(addslashes($term->name))));
		}
	}
	
	function auto_create_compare_feature($term_id) {
		$term = get_term( $term_id, 'wpsc-variation' );
		$check_existed = WPEC_Compare_Data::get_count("field_name='".trim($term->name)."'");
		if ($check_existed < 1 && $term->parent == 0 ) {
			WPEC_Compare_Data::insert_row(array('field_name' => trim(addslashes($term->name)), 'field_type' => 'input-text', 'field_unit' => '', 'default_value' => '' ) );
		}
	}
	
	function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != ECCP_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/wp-e-commerce/wpec-compare-products/" target="_blank">'.__('Documentation', 'wpec_cp').'</a>';
		$links[] = '<a href="http://a3rev.com/shop/wpec-compare-products/#help_tab" target="_blank">'.__('Support', 'wpec_cp').'</a>';
		return $links;
	}
}
?>
<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Hook Filter
 *
 * Table Of Contents
 *
 * wpec_ajax_add_compare_button()
 * add_compare_button()
 * show_compare_button()
 * show_compare_fields()
 * wpeccp_update_compare_widget()
 * wpeccp_update_total_compare()
 * wpeccp_add_to_compare()
 * wpeccp_remove_from_compare()
 * wpeccp_remove_from_popup_compare()
 * wpeccp_clear_compare()
 * wpeccp_get_popup()
 * wpec_compare_footer_script()
 * wpeccp_print_scripts()
 * wpeccp_print_styles()
 * wpeccp_admin_script()
 * auto_create_compare_category()
 * auto_create_compare_feature()
 */
class WPEC_Compare_Hook_Filter{
	
	function wpec_ajax_add_compare_button(){
		global $post;
		$product_id = $post->ID;
		$comparable_settings = get_option('comparable_settings');
		$button_text = $comparable_settings['button_text'];
		if($button_text == '') $button_text = __('Compare this', 'wpec_cp');
		if($post->post_type == 'wpsc-product' && WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id) && $comparable_settings['auto_add'] == 'yes'){
			if($comparable_settings['button_type'] == 'button'){
				$script_add = '<style>input.bt_compare_this{display:block !important;}</style><script type="text/javascript">
				(function($){		
					$(function(){
						if($("#bt_compare_this_'.$product_id.'").length <= 0){
							if($("input#product_'.$product_id.'_submit_button").length > 0){
								add_cart_class = $("#product_'.$product_id.'_submit_button").attr("class");
								$("input#product_'.$product_id.'_submit_button").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><input type=\"button\" value=\"'.$button_text.'\" class=\"bt_compare_this "+ add_cart_class +" \" id=\"bt_compare_this_'.$product_id.'\" style=\"cursor:pointer\" /><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" /></div>");
							}else if($(".product_view_'.$product_id.'").length > 0){
								$(".product_view_'.$product_id.'").find(".more_details").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><input type=\"button\" value=\"'.$button_text.'\" class=\"bt_compare_this \" id=\"bt_compare_this_'.$product_id.'\" style=\"cursor:pointer\" /><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" /></div>");
							}else{
								add_cart_class = $("input.wpsc_buy_button").attr("class");
								$("input.wpsc_buy_button").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><input type=\"button\" value=\"'.$button_text.'\" class=\"bt_compare_this "+ add_cart_class +" \" id=\"bt_compare_this_'.$product_id.'\" style=\"cursor:pointer\" /><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" /></div>");
							}
						}
					});		  
				})(jQuery);
				</script>';
				
				echo $script_add;
			}else{
				$script_add = '<style>input.bt_compare_this{display:block !important;}</style><script type="text/javascript">
				(function($){		
					$(function(){
						if($("#bt_compare_this_'.$product_id.'").length <= 0){
							if($("input#product_'.$product_id.'_submit_button").length > 0){
								$("input#product_'.$product_id.'_submit_button").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><a class=\"bt_compare_this\" id=\"bt_compare_this_'.$product_id.'\" style=\"cursor:pointer\">'.$button_text.'</a><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" /></div>");
							}else if($(".product_view_'.$product_id.'").length > 0){
								$(".product_view_'.$product_id.'").find(".more_details").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><a class=\"bt_compare_this\" id=\"bt_compare_this_'.$product_id.'\" style=\"cursor:pointer\">'.$button_text.'</a><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" /></div>");
							}else{
								$("input.wpsc_buy_button").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><a class=\"bt_compare_this\" id=\"bt_compare_this_'.$product_id.'\" style=\"cursor:pointer\">'.$button_text.'</a><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" />");
							}
						}
					});		  
				})(jQuery);
				</script>';
				echo $script_add;
			}
		}
	}
	
	function add_compare_button($product_id=''){
		global $post;
		if(trim($product_id) == '') $product_id = $post->ID;
		$comparable_settings = get_option('comparable_settings');
		$button_text = $comparable_settings['button_text'];
		if($button_text == '') $button_text = __('Compare this', 'wpec_cp');
		$post_type = get_post_type($product_id);
		$html = '';
		if($post_type == 'wpsc-product' && WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id)){
			if($comparable_settings['button_type'] == 'button'){
				$html .= '<div class="compare_button_container"><input type="button" value="'.$button_text.'" class="bt_compare_this" id="bt_compare_this_'.$product_id.'" style="cursor:pointer" /><input type="hidden" id="input_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>
				<script type="text/javascript">
				(function($){		
					$(function(){
						if($("input#product_'.$product_id.'_submit_button").length > 0){
							add_cart_class = $("#product_'.$product_id.'_submit_button").attr("class");
							$("#bt_compare_this_'.$product_id.'").addClass(add_cart_class);
						}else if($("input.wpsc_buy_button").length > 0){
							add_cart_class = $("input.wpsc_buy_button").attr("class");
							$("#bt_compare_this_'.$product_id.'").addClass(add_cart_class);
						}else {
							$("#bt_compare_this_'.$product_id.'").addClass("wpsc_buy_button");
						}
					});		  
				})(jQuery);
				</script>';			
			}else{
				$html .= '<div class="compare_button_container"><a class="bt_compare_this" id="bt_compare_this_'.$product_id.'" style="cursor:pointer">'.$button_text.'</a><input type="hidden" id="input_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
			}
		}
		
		return $html;
	}
	
	function show_compare_button(){
		$comparable_settings = get_option('comparable_settings');
		if ($comparable_settings['auto_add'] == 'yes') {
			echo '<div class="wpsc_buy_button_container">'.WPEC_Compare_Hook_Filter::add_compare_button().'</div>';
		}
	}
	
	function show_compare_fields($product_id='', $use_table_style=true){
		global $post;
		if(trim($product_id) == '') $product_id = $post->ID;
		$html = '';
		$variations_list = WPEC_Compare_Functions::get_variations($product_id);
		if(is_array($variations_list) && count($variations_list) > 0){
			foreach($variations_list as $variation_id){
				if(WPEC_Compare_Functions::check_product_activate_compare($variation_id) && WPEC_Compare_Functions::check_product_have_cat($variation_id)){
					$html .= '<div class="compare_product_variation"><h2>'.get_the_title($variation_id).'</h2></div>';
					if ($use_table_style) 
						$html .= '<table class="compare_featured_fields shop_attributes">'; 
					else
						$html .= '<ul class="compare_featured_fields">';
					$fixed_width = ' width="60%"';
					$compare_category = get_post_meta( $variation_id, '_wpsc_compare_category', true );
					$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'",'cf.field_order ASC');
					foreach($compare_fields as $field_data){
						$field_value = get_post_meta( $variation_id, '_wpsc_compare_'.$field_data->field_key, true );
						if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
						elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
						if(trim($field_value) == '') $field_value = 'N/A';
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
		}elseif(WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id)){
			if(is_array($compare_fields) && count($compare_fields)>0){
				if ($use_table_style) 
					$html .= '<table class="compare_featured_fields shop_attributes">'; 
				else
					$html .= '<ul class="compare_featured_fields">';
				$fixed_width = ' width="60%"';
				$compare_category = get_post_meta( $product_id, '_wpsc_compare_category', true );
				$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'",'cf.field_order ASC');
				foreach($compare_fields as $field_data){
					$field_value = get_post_meta( $product_id, '_wpsc_compare_'.$field_data->field_key, true );
					if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
					if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
					elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
					if(trim($field_value) == '') $field_value = 'N/A';
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
		return $html;
	}
	
	function wpeccp_update_compare_widget(){
		//check_ajax_referer( 'wpeccp-compare-events', 'security' );
		$result = WPEC_Compare_Functions::get_compare_list_html_widget();
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_update_total_compare(){
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		$result = WPEC_Compare_Functions::get_total_compare_list();
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_add_to_compare(){
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		
		$product_id 	= $_REQUEST['product_id'];
		WPEC_Compare_Functions::add_product_to_compare_list($product_id);
		$result = WPEC_Compare_Functions::get_compare_list_html_widget();
		
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_remove_from_compare(){
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
				
		$product_id 	= $_REQUEST['product_id'];
		WPEC_Compare_Functions::delete_product_on_compare_list($product_id);
		$result = WPEC_Compare_Functions::get_compare_list_html_widget();
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_remove_from_popup_compare(){
		//check_ajax_referer( 'wpeccp-compare-events', 'security' );
	
		$product_id 	= $_REQUEST['product_id'];
		WPEC_Compare_Functions::delete_product_on_compare_list($product_id);
		$result = WPEC_Compare_Functions::get_compare_list_html_popup();
		
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_clear_compare(){
		check_ajax_referer( 'wpeccp-compare-events', 'security' );
		WPEC_Compare_Functions::clear_compare_list();
		$result = WPEC_Compare_Functions::get_compare_list_html_widget();
		echo json_encode( $result );
		die();
	}
	
	function wpeccp_get_popup(){
		check_ajax_referer( 'wpeccp-compare-popup', 'security' );
		$comparable_settings = get_option('comparable_settings');
		if(trim($comparable_settings['compare_container_height']) != '') $compare_container_height = $comparable_settings['compare_container_height']; else $compare_container_height = 500;
	?>
    	<div class="compare_popup_container">
			<style type="text/css">
            .compare_popup_container{
                font-size:12px;
                margin:auto;
                width:960px;
            }
            .compare_popup_wrap{
                overflow:auto;
                width:940px;
                height:<?php echo $compare_container_height; ?>px;
                margin:0 10px;
                padding-bottom:10px;
            }
            .compare_logo{
                text-align:center;	
            }
            .compare_logo img{
                max-width:940px;
            }
            .compare_heading{
                float:left;
                width:940px;
                margin:10px 10px 0;	
            }
            .compare_heading h1{
                font-size:20px;
                font-weight:bold;
                float:left;
            }
            .wpec_compare_print{
                float:right;
                background:url(<?php echo ECCP_IMAGES_URL; ?>/icon_print.png) no-repeat 0 center;
                padding-left:20px;	
                cursor:pointer;
            }
            .wpec_compare_print_msg{
                float:right;
                clear:right;
            }
            .compare_popup_table{
                border:1px solid #CBCBCB; 
                border-radius:0px; 
                -khtml-border-radius: 0px; 
                -webkit-border-radius: 0px; 
                -moz-border-radius: 0px;
                box-shadow:2px 3px 2px #333333;
                -moz-box-shadow: 2px 3px 2px #333333;
                -webkit-box-shadow: 2px 3px 2px #333333;
                margin:auto;
            }
            .compare_popup_table td{
                font-size:12px;
                text-align:center;
                padding:2px 10px;
                vertical-align:middle;
            }
            .compare_popup_table tr.row_product_detail td{
                vertical-align:top;	
            }
            .compare_popup_table .column_first{
                background:#f6f6f6;
                font-size:13px;
                font-weight:bold;
            }
            .compare_popup_table .first_row{
                width:220px; 
                min-width:220px;
                height:20px;
                text-align:right;
                /* fallback (opera, ie<=7) */
                background: #EEEEEE;
                /* Mozilla: */
                background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE);
                /* Chrome, safari:*/
                background: -webkit-gradient(linear, left top, left bottom, from(#FFFFFF), to(#EEEEEE));
                /* MSIE 8+ */
                filter: progid:DXImageTransform.Microsoft.Gradient(StartColorStr='#FFFFFF', EndColorStr='#EEEEEE', GradientType=0);
            }
            .compare_popup_table .column_first.first_row{
                width:190px;
                min-width:190px;	
            }
            .compare_popup_table .row_1{
                background:#FFF;
            }
            .compare_popup_table .row_2{
                background:#f6f6f6;
                border-top:1px solid #CCC;
                border-bottom:1px solid #CCC;
            }
            .compare_popup_table .row_2 td{
                border-top:1px solid #CCC;
                border-bottom:1px solid #CCC;
            }
            .compare_popup_table .row_end td{
                border-bottom:none;	
                padding-bottom:10px;
                padding-top:10px;
            }
            .compare_image_container{
                /*width:220px;*/ 
                height:180px; 
                /*display:table-cell;*/ 
                overflow:hidden; 
                text-align:center; 
                line-height:180px; 
                vertical-align:middle;
            }
            .compare_image_container img{
                max-width:220px; 
                max-height:180px; 
                border:0;
                vertical-align:middle;
            }
            .compare_product_name{
                color:#C30;
                font-weight:bold;
                font-size:16px;
                line-height:21px;
                margin-bottom:5px;
            }
            .compare_avg_rating{
                margin-bottom:5px;	
            }
            .compare_avg_rating .votetext{
                height:auto;
            }
            .compare_price{
                color:#C30;
                font-weight:bold;
                font-size:16px;
                margin-bottom:5px;
            }
            .compare_price del{
                color:#999;
                font-size:13px;
                font-weight:normal;	
            }
            </style>
                <div class="compare_logo"><?php if(trim($comparable_settings['compare_logo']) != ''){ ?><img src="<?php echo $comparable_settings['compare_logo']; ?>" alt="" /><?php } ?></div>
                <div class="compare_heading"><h1><?php _e('Compare Products', 'wpec_cp'); ?></h1> <span class="wpec_compare_print"><?php _e('Print This Page', 'wpec_cp'); ?></span><span class="wpec_compare_print_msg"><?php _e('Narrow your selection to 3 products and print!', 'wpec_cp'); ?></span></div>
                <div style="clear:both;"></div>
                <div class="popup_wpec_compare_widget_loader" style="display:none; text-align:center"><img src="<?php echo ECCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 /></div>
                <div class="compare_popup_wrap">
                    <?php echo WPEC_Compare_Functions::get_compare_list_html_popup();?>
                </div>
        </div>
    <?php
		die();
	}
	
	function wpec_compare_footer_script(){
		$wpeccp_compare_events = wp_create_nonce("wpeccp-compare-events");
		$wpeccp_compare_popup = wp_create_nonce("wpeccp-compare-popup");
		$comparable_settings = get_option('comparable_settings');
		if(trim($comparable_settings['popup_width']) != '') $popup_width = $comparable_settings['popup_width'];
		else $popup_width = 1000;
		
		if(trim($comparable_settings['popup_height']) != '') $popup_height = $comparable_settings['popup_height'];
		else $popup_height = 650;
		
		$script_add_on = '';
		$script_add_on .= '<script type="text/javascript">
				(function($){		
					$(function(){
						var ajax_url = "'.admin_url('admin-ajax.php').'";
						$(".compare_button_go").live("click", function(ev){
							  $.lightbox(ajax_url+"?action=wpeccp_get_popup&security='.$wpeccp_compare_popup.'", {
								"width"       : '.$popup_width.',
								"height"      : '.$popup_height.'
							  });
							  ev.preventDefault();
						});
						
						$(".wpec_compare_print").live("click", function(){
							$(".compare_popup_container").printElement({
								printBodyOptions:{
									styleToAdd:"overflow:visible !important;",
									classNameToAdd : "compare_popup_wrap"
								}
							});
						});
						
						$(".bt_compare_this").live("click", function(){
							var product_id = $("#input_"+$(this).attr("id")).val();
							$(".compare_widget_loader").show();
							$(".compare_widget_container").html("");
							var data = {
								action: 		"wpeccp_add_to_compare",
								product_id: 	product_id,
								security: 		"'.$wpeccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = $.parseJSON( response );
								$(".compare_widget_loader").hide();
								$(".compare_widget_container").html(result);
								update_total_compare_list();
							});							
						});
						
						$(".compare_popup_remove_product").live("click", function(){
							var popup_remove_product_id = $(this).attr("rel");
							$(".popup_wpec_compare_widget_loader").show();
							$(".compare_popup_wrap").html("");
							var data = {
								action: 		"wpeccp_remove_from_popup_compare",
								product_id: 	popup_remove_product_id,
								security: 		"'.$weccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = $.parseJSON( response );
								$(".popup_wpec_compare_widget_loader").hide();
								$(".compare_popup_wrap").html(result);
								data = {
									action: 		"wpeccp_update_compare_widget",
									security: 		"'.$weccp_compare_events.'"
								};
								$.post( ajax_url, data, function(response) {
									new_widget = $.parseJSON( response );
									$(".compare_widget_container").html(new_widget);
								});
								update_total_compare_list();
							});
						});
						
						$(".compare_remove_product").live("click", function(){
							var remove_product_id = $(this).attr("rel");
							$(".compare_widget_loader").show();
							$(".compare_widget_container").html("");
							var data = {
								action: 		"wpeccp_remove_from_compare",
								product_id: 	remove_product_id,
								security: 		"'.$wpeccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = $.parseJSON( response );
								$(".compare_widget_loader").hide();
								$(".compare_widget_container").html(result);
								update_total_compare_list();
							});
						});
						$(".compare_clear_all").live("click", function(){
							$(".compare_widget_loader").show();
							$(".compare_widget_container").html("");
							var data = {
								action: 		"wpeccp_clear_compare",
								security: 		"'.$wpeccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = $.parseJSON( response );
								$(".compare_widget_loader").hide();
								$(".compare_widget_container").html(result);
								update_total_compare_list();
							});
						});
						
						function update_total_compare_list(){
							var data = {
								action: 		"wpeccp_update_total_compare",
								security: 		"'.$wpeccp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								total_compare = $.parseJSON( response );
								$("#total_compare_product").html("("+total_compare+")");
							});
						}
					});		  
				})(jQuery);
				</script>';
		echo $script_add_on;
	}
	
	function wpeccp_print_scripts(){
		wp_enqueue_script('jquery');
				
		// light box
		wp_enqueue_script('lightbox2_script', ECCP_JS_URL . '/lightbox/jquery.lightbox.js');
		wp_enqueue_script('a3_print_element', ECCP_JS_URL . '/jquery.printElement.js');
	}
	
	function wpeccp_print_styles(){
		wp_enqueue_style('a3_lightbox_style', ECCP_JS_URL . '/lightbox/themes/default/jquery.lightbox.css');
	}
	
	function wpeccp_admin_script(){
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.minified';

		wp_enqueue_style( 'tiptup_style', ECCP_JS_URL . '/tipTip/tipTip.css' );
		echo '<script src="'.ECCP_JS_URL . '/tipTip/jquery.tipTip'.$suffix.'.js" type="text/javascript"></script>';	
		echo '<script type="text/javascript">
(function($){		
	$(function(){
		// Tooltips
		jQuery(".help_tip").tipTip({
			"attribute" : "tip",
			"fadeIn" : 50,
			"fadeOut" : 50
		});
	});		  
})(jQuery);
		</script>';
	}
	
	function auto_create_compare_category($term_id) {
		$term = get_term( $term_id, 'wpsc_product_category' );
		$check_existed = WPEC_Compare_Categories_Data::get_count("category_name='".trim($term->name)."'");
		if ($check_existed < 1 ) {
			WPEC_Compare_Categories_Data::insert_row(array('category_name' => trim(addslashes($term->name))));
		}
	}
	
	function auto_create_compare_feature($term_id) {
		$master_category_id = get_option('master_category_compare');
		$term = get_term( $term_id, 'wpsc-variation' );
		$check_existed = WPEC_Compare_Data::get_count("field_name='".trim($term->name)."'");
		if ($check_existed < 1 && $term->parent == 0 ) {
			$feature_id = WPEC_Compare_Data::insert_row(array('field_name' => trim(addslashes($term->name)), 'field_type' => 'input-text', 'field_unit' => '', 'default_value' => '' ) );
			if ($feature_id !== false) {
				WPEC_Compare_Categories_Fields_Data::insert_row($master_category_id, $feature_id);
			}
		}
	}
}
?>
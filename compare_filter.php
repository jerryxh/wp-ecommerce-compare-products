<?php
class WPEC_Compare_Hook_Filter{
	
	function wpec_ajax_add_compare_button(){
		global $post;
		$product_id = $post->ID;
		$comparable_settings = get_option('comparable_settings');
		$button_text = $comparable_settings['button_text'];
		if($button_text == '') $button_text = __('Compare this', 'wpec_cp');
		if($post->post_type == 'wpsc-product' && WPEC_Compare_Functions::check_product_activate_compare($product_id) && $comparable_settings['auto_add'] == 'yes'){
			if($comparable_settings['button_type'] == 'button'){
				$script_add = '<script type="text/javascript">
				(function($){		
					$(function(){
						if($("#bt_compare_this_'.$product_id.'").length <= 0){
							if($("input#product_'.$product_id.'_submit_button").length > 0){
								add_cart_class = $("#product_'.$product_id.'_submit_button").attr("class");
								$("input#product_'.$product_id.'_submit_button").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><input type=\"button\" value=\"'.$button_text.'\" class=\"bt_compare_this "+ add_cart_class +" \" id=\"bt_compare_this_'.$product_id.'\" /><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" /></div>");
							}else if($(".product_view_'.$product_id.'").length > 0){
								$(".product_view_'.$product_id.'").find(".more_details").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><input type=\"button\" value=\"'.$button_text.'\" class=\"bt_compare_this \" id=\"bt_compare_this_'.$product_id.'\" /><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" /></div>");
							}else{
								add_cart_class = $("input.wpsc_buy_button").attr("class");
								$("input.wpsc_buy_button").after("<div class=\"compare_button_container\" style=\"margin-top:10px\"><input type=\"button\" value=\"'.$button_text.'\" class=\"bt_compare_this "+ add_cart_class +" \" id=\"bt_compare_this_'.$product_id.'\" /><input type=\"hidden\" id=\"input_bt_compare_this_'.$product_id.'\" name=\"product_compare_'.$product_id.'\" value=\"'.$product_id.'\" /></div>");
							}
						}
					});		  
				})(jQuery);
				</script>';
				
				echo $script_add;
			}else{
				$script_add = '<script type="text/javascript">
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
		if($post_type == 'wpsc-product' && WPEC_Compare_Functions::check_product_activate_compare($product_id)){
			if($comparable_settings['button_type'] == 'button'){
				$html .= '<div class="compare_button_container"><input type="button" value="'.$button_text.'" class="bt_compare_this" id="bt_compare_this_'.$product_id.'" /><input type="hidden" id="input_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>
				<script type="text/javascript">
				(function($){		
					$(function(){
						if($("input#product_'.$product_id.'_submit_button").length > 0){
							add_cart_class = $("#product_'.$product_id.'_submit_button").attr("class");
							$("#bt_compare_this_'.$product_id.'").addClass(add_cart_class);
						}else{
							add_cart_class = $("input.wpsc_buy_button").attr("class");
							$("#bt_compare_this_'.$product_id.'").addClass(add_cart_class);
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
	
	function show_compare_fields($product_id=''){
		global $post;
		if(trim($product_id) == '') $product_id = $post->ID;
		$html = '';
		$compare_fields = WPEC_Compare_Data::get_results('','field_order ASC');
		$variations_list = WPEC_Compare_Functions::get_variations($product_id);
		if(is_array($variations_list) && count($variations_list) > 0){
			foreach($variations_list as $variation_id){
				if(WPEC_Compare_Functions::check_product_activate_compare($variation_id)){
					$html .= '<div class="compare_product_variation"><h2>'.get_the_title($variation_id).'</h2></div>';
					$html .= '<ul class="compare_featured_fields">';
					foreach($compare_fields as $field_data){
						$field_value = get_post_meta( $variation_id, '_wpsc_compare_'.$field_data->field_key, true );
						if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
						elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
						if(trim($field_value) == '') $field_value = 'N/A';
						$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.$field_data->field_name.'</strong></span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
					}
					$html .= '</ul>';
				}
			}
		}elseif(WPEC_Compare_Functions::check_product_activate_compare($product_id)){
			if(is_array($compare_fields) && count($compare_fields)>0){
				$html .= '<ul class="compare_featured_fields">';
				foreach($compare_fields as $field_data){
					$field_value = get_post_meta( $product_id, '_wpsc_compare_'.$field_data->field_key, true );
					if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
					if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
					elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
					if(trim($field_value) == '') $field_value = 'N/A';
					$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.$field_data->field_name.'</strong></span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
				}
				$html .= '</ul>';
			}
		}
		return $html;
	}
	
	function wpec_compare_footer_script(){
		$comparable_settings = get_option('comparable_settings');
		if(trim($comparable_settings['popup_width']) != '') $popup_width = $comparable_settings['popup_width'];
		else $popup_width = 1000;
		
		if(trim($comparable_settings['popup_height']) != '') $popup_height = $comparable_settings['popup_height'];
		else $popup_height = 650;
		
		$script_add_on = '';
		$script_add_on .= '<script type="text/javascript">
				(function($){		
					$(function(){
						$(".compare_button_go").live("click", function(ev){
							  $.lightbox("'.ECCP_URL.'/compare_popup.php", {
								"width"       : '.$popup_width.',
								"height"      : '.$popup_height.'
							  });
							  ev.preventDefault();
						});
						
						$(".compare_print").live("click", function(){
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
							$.ajax({
								type: "POST",
								url: "'.ECCP_URL.'/compare_process_ajax.php",
								data: "action=add_to_compare&product_id="+product_id,
								success: function(result){
									$(".compare_widget_loader").hide();
									$(".compare_widget_container").html(result);
									update_total_compare_list();
								}
							});
						});
						
						$(".compare_popup_remove_product").live("click", function(){
							var popup_remove_product_id = $(this).attr("rel");
							$(".popup_compare_widget_loader").show();
							$(".compare_popup_wrap").html("");
							$.ajax({
								type: "POST",
								url: "'.ECCP_URL.'/compare_process_ajax.php",
								data: "action=remove_from_popup_compare&product_id="+popup_remove_product_id,
								success: function(result){
									$(".popup_compare_widget_loader").hide();
									$(".compare_popup_wrap").html(result);
									$.ajax({
										type: "POST",
										url: "'.ECCP_URL.'/compare_process_ajax.php",
										data: "action=update_compare_widget",
										success: function(new_widget){
											$(".compare_widget_container").html(new_widget);
										}
									});
									update_total_compare_list();
								}
							});
						});
						
						$(".compare_remove_product").live("click", function(){
							var remove_product_id = $(this).attr("rel");
							$(".compare_widget_loader").show();
							$(".compare_widget_container").html("");
							$.ajax({
								type: "POST",
								url: "'.ECCP_URL.'/compare_process_ajax.php",
								data: "action=remove_from_compare&product_id="+remove_product_id,
								success: function(result){
									$(".compare_widget_loader").hide();
									$(".compare_widget_container").html(result);
									update_total_compare_list();
								}
							});
						});
						$(".compare_clear_all").live("click", function(){
							$(".compare_widget_loader").show();
							$(".compare_widget_container").html("");
							$.ajax({
								type: "POST",
								url: "'.ECCP_URL.'/compare_process_ajax.php",
								data: "action=clear_compare",
								success: function(result){
									$(".compare_widget_loader").hide();
									$(".compare_widget_container").html(result);
									update_total_compare_list();
								}
							});
						});
						
						function update_total_compare_list(){
							$.ajax({
								type: "POST",
								url: "'.ECCP_URL.'/compare_process_ajax.php",
								data: "action=update_total_compare",
								success: function(total_compare){
									$("#total_compare_product").html("("+total_compare+")");
								}
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
		wp_enqueue_script('lightbox2_script', ECCP_URL . '/js/lightbox/jquery.lightbox.js');
		wp_enqueue_script('a3_print_element', ECCP_URL . '/js/jquery.printElement.js');
	}
	
	function wpeccp_print_styles(){
		wp_enqueue_style('a3_lightbox_style', ECCP_URL . '/js/lightbox/themes/default/jquery.lightbox.css');
	}
}
?>
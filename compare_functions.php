<?php
class WPEC_Compare_Functions{
	function get_variations($product_id){
		$wpsc_variations = new wpsc_variations( $product_id );
		$product_avalibale = array();
		$variation_list = array();
		foreach($wpsc_variations->all_associated_variations as $variation_groups){
			foreach($variation_groups as $variation){
				if($variation->term_id != 0){
					$variation_list[] = $variation->term_id;
				}
			}
		}
		$product_ids = wpsc_get_child_object_in_select_terms( $product_id, $variation_list, 'wpsc_variation' );
		if(is_array($product_ids) && count($product_ids) > 0){
			foreach($product_ids as $variation_id){
				if(WPEC_Compare_Functions::check_product_activate_compare($variation_id)){
					$product_avalibale[] = $variation_id;
				}
			}
		}
		
		return $product_avalibale;
	}
	
	function check_product_activate_compare($product_id){
		if(get_post_meta( $product_id, '_wpsc_deactivate_compare_feature', true ) != 'yes'){
			return true;
		}else{
			return false;	
		}
	}
	
	function add_product_to_compare_list($product_id){
		$product_list = WPEC_Compare_Functions::get_variations($product_id);
		if(count($product_list) < 1 && WPEC_Compare_Functions::check_product_activate_compare($product_id)) $product_list = array($product_id);
		if(is_array($product_list) && count($product_list) > 0){
			$current_compare_list = (array)$_SESSION['wpec_compare_list'];
			foreach($product_list as $product_add){
				if(!in_array($product_add, $current_compare_list)){
					$current_compare_list[] = $product_add;
				}
			}
			$_SESSION['wpec_compare_list'] = $current_compare_list;
		}
	}
	
	function get_compare_list(){
		$current_compare_list = (array)$_SESSION['wpec_compare_list'];
		$return_compare_list = array();
		if(is_array($current_compare_list) && count($current_compare_list) > 0){
			foreach($current_compare_list as $product_id){
				if(WPEC_Compare_Functions::check_product_activate_compare($product_id)){
					$return_compare_list[] = $product_id;
				}
			}
		}
		return $return_compare_list;
	}
	
	function get_total_compare_list(){
		$current_compare_list = (array)$_SESSION['wpec_compare_list'];
		$return_compare_list = array();
		if(is_array($current_compare_list) && count($current_compare_list) > 0){
			foreach($current_compare_list as $product_id){
				if(WPEC_Compare_Functions::check_product_activate_compare($product_id)){
					$return_compare_list[] = $product_id;
				}
			}
		}
		return count($return_compare_list);
	}
	
	function delete_product_on_compare_list($product_id){
		$current_compare_list = (array)$_SESSION['wpec_compare_list'];
		$key = array_search($product_id, $current_compare_list);
		unset($current_compare_list[$key]);
		$_SESSION['wpec_compare_list'] = $current_compare_list;
	}
	
	function clear_compare_list(){
		unset($_SESSION['wpec_compare_list']);
	}
	
	function wpeccp_the_product_price( $product_id, $no_decimals = false, $only_normal_price = false ) {
		global $wpsc_query, $wpsc_variations, $wpdb;
		$price = $full_price = get_post_meta( $product_id, '_wpsc_price', true );
	
		if ( ! $only_normal_price ) {
			$special_price = get_post_meta( $product_id, '_wpsc_special_price', true );
	
			if ( ( $full_price > $special_price ) && ( $special_price > 0 ) )
				$price = $special_price;
		}
	
		if ( $no_decimals == true )
			$price = array_shift( explode( ".", $price ) );
	
		$price = apply_filters( 'wpsc_do_convert_price', $price );
		$args = array(
				'display_as_html' => false,
				'display_decimal_point' => ! $no_decimals
		);
		if($price > 0){
			$output = wpsc_currency_display( $price, $args );
			return $output;
		}
	}
	
	function get_compare_list_html_widget(){
		$compare_list = WPEC_Compare_Functions::get_compare_list();
		$html = '';
		if(is_array($compare_list) && count($compare_list)>0){
			$html .= '<ul class="compare_widget_ul">';
			foreach($compare_list as $product_id){
				$html .= '<li class="compare_widget_item">';
					$html .= '<div class="compare_remove_column" style="float:right; margin-left:5px;"><a class="compare_remove_product" rel="'.$product_id.'" style="cursor:pointer;"><img src="'.ECCP_IMAGES_FOLDER.'/compare_remove.png" border=0 /></a></div>';
					$html .= '<div class="compare_title_column">'.get_the_title($product_id).'</div>';
				$html .= '</li>';
			}
			$html .= '</ul>';
			$html .= '<div class="compare_widget_action"><a class="compare_clear_all" style="cursor:pointer;">Clear All</a> <input type="button" name="compare_button_go" class="compare_button_go" value="Compare" /></div>';
		}else{
			$html .= '<div class="no_compare_list">You do not have any product to compare.</div>';	
		}
		return $html;
	}
	
	function get_compare_list_html_popup(){
		$compare_list = WPEC_Compare_Functions::get_compare_list();
		$html = '';
		if(is_array($compare_list) && count($compare_list)>0){
			$html .= '<table class="compare_popup_table" border="0" cellpadding="5" cellspacing="0" width="">';
				$html .= '<tr><td class="column_first first_row"></td>';
				foreach($compare_list as $product_id){
					$html .= '<td class="first_row"><a class="compare_popup_remove_product" rel="'.$product_id.'" style="cursor:pointer;"><img src="'.ECCP_IMAGES_FOLDER.'/compare_remove.png" border=0 /></a></td>';
				}
				$html .= '</tr>';
				$html .= '<tr class="row_1 row_product_detail"><td class="column_first"></td>';
				$i = 0;
				foreach($compare_list as $product_id){
					$i++;
					$product_name = get_the_title($product_id);
					$image_src = WPEC_Compare_Functions::get_post_thumbnail($product_id, 220, 180);
					if(trim($image_src) == ''){
						$image_src = '<img alt="'.$product_name.'" src="'.WPSC_CORE_THEME_URL.'wpsc-images/noimage.png" />';
					}
					$html .= '<td class="column_'.$i.'">';
						$html .= '<div class="compare_image_container">'.$image_src.'</div>';
						$html .= '<div class="compare_product_name">'.$product_name.'</div>';
						$html .= '<div class="compare_avg_rating">'.__( 'Avg. Customer Rating', 'wpsc' ).':<br />'.wpsc_product_existing_rating( $product_id ).'</div>';
						$html .= '<div class="compare_price">'.WPEC_Compare_Functions::wpeccp_the_product_price($product_id).'</div>';
					if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')){
						$html .= '<div class="compare_add_cart">';
						$html .= '<form class="product_form" id="product_'.$product_id.'" enctype="multipart/form-data" action="" method="post" name="product_'.$product_id.'">';														
							$html .= '<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />';
							$html .= '<input type="hidden" value="'.$product_id.'" name="product_id" />';
							
								if(wpsc_product_has_stock($product_id)){
									$html .= '<div class="wpsc_buy_button_container">';
									if(wpsc_product_external_link($product_id) == ''){
										$html .= '<input type="submit" value="'.__('Add To Cart', 'wpsc').'" name="Buy" class="wpsc_buy_button" id="product_'.$product_id.'_submit_button" />';
									}
									$html .= '</div>';
								}else{
									$html .= '<p class="soldout">'.__('This product has sold out.', 'wpsc').'</p>';
								}
						$html .= '</form>';
						$html .= '</div>';
					}
					$html .= '</td>';
				}
				$html .= '</tr>';
			$compare_fields = WPEC_Compare_Data::get_results('','field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
			$j = 1;
			foreach($compare_fields as $field_data){
				$j++;
				$html .= '<tr class="row_'.$j.'">';
					$html .= '<td class="column_first">'.$field_data->field_name.'</td>';
				$i = 0;
				foreach($compare_list as $product_id){
					$i++;
					$field_value = get_post_meta( $product_id, '_wpsc_compare_'.$field_data->field_key, true );
					if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
					if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
					elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
					if(trim($field_value) == '') $field_value = 'N/A';
					$html .= '<td class="column_'.$i.'"><div class="compare_value compare_'.$field_data->field_key.'">'.$field_value.'</div></td>';
				}
				$html .= '</tr>';
				if($j==2) $j=0;
			}
			$j++;
			if($j>2) $j=1;
				$html .= '<tr class="row_'.$j.' row_end"><td class="column_first"></td>';
				$i = 0;
				foreach($compare_list as $product_id){
					$i++;
					$html .= '<td class="column_'.$i.'">';
						$html .= '<div class="compare_price">'.WPEC_Compare_Functions::wpeccp_the_product_price($product_id).'</div>';
					$html .= '</td>';
				}
		}
			$html .= '</table>';
		}else{
			$html .= '<div class="no_compare_list">You do not have any product to compare.</div>';	
		}
		return $html;
	}
	
	function get_post_thumbnail($postid=0, $width=220, $height=180){
		$mediumSRC = '';
		// Get the product ID if none was passed
		if ( empty( $postid ) )
			$postid = get_the_ID();
	
		// Load the product
		$product = get_post( $postid );
			
		if(has_post_thumbnail($postid)) {
			$thumbid = get_post_thumbnail_id($postid);
			$attachmentArray = wp_get_attachment_image_src($thumbid, array(0 => $width, 1 => $height), false);
			$mediumSRC = $attachmentArray[0];
			if(trim($mediumSRC != '')){
				return '<img src="'.$mediumSRC.'" />';
			}
		}
		if(trim($mediumSRC == '')){
			$args = array( 'post_parent' => $postid ,'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null); 
			$attachments = get_posts($args);
			if ($attachments) {
				foreach ( $attachments as $attachment ) {
					$mediumSRC = wp_get_attachment_image( $attachment->ID, array(0 => $width, 1 => $height),true );
					break;
				}
			}
		}
		
		if(trim($mediumSRC == '')){
			// Get ID of parent product if one exists
			if ( !empty( $product->post_parent ) )
				$postid = $product->post_parent;
				
			if(has_post_thumbnail($postid)) {
				$thumbid = get_post_thumbnail_id($postid);
				$attachmentArray = wp_get_attachment_image_src($thumbid, array(0 => $width, 1 => $height), false);
				$mediumSRC = $attachmentArray[0];
				if(trim($mediumSRC != '')){
					return '<img src="'.$mediumSRC.'" />';
				}
			}
			if(trim($mediumSRC == '')){
				$args = array( 'post_parent' => $postid ,'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null); 
				$attachments = get_posts($args);
				if ($attachments) {
					foreach ( $attachments as $attachment ) {
						$mediumSRC = wp_get_attachment_image( $attachment->ID, array(0 => $width, 1 => $height),true );
						break;
					}
				}
			}
		}
		return $mediumSRC;
	}
	
	function activate_this_plugin(){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: WPEC Compare Products Lite <mr.alextuan@gmail.com>' . "\r\n\\";
		$subject = 'Activated WPEC Compare Products plugin';
		
		$content = '------------------------------------------------------<br \><br \>';
		$content .= 'Website: '.get_bloginfo('name').' <br />';
		$content .= 'URL: '.get_option('siteurl').' <br />';
		$content .= 'IP: '.$_SERVER['SERVER_ADDR'].' <br />';
		$content .= 'Plugin: WPEC Compare Products <br />';
		$content .= 'Email: '.get_bloginfo('admin_email').' <br />';
		$content .= '------------------------------------------------------<br \><br \>';
		
		return wp_mail('mr.nguyencongtuan@gmail.com', $subject, $content, $headers, '');
	}
}
?>
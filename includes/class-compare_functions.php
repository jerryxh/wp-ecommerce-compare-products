<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Functions Class
 *
 * Table Of Contents
 *
 * get_variations()
 * check_product_activate_compare()
 * check_product_have_cat()
 * add_product_to_compare_list()
 * get_compare_list()
 * get_total_compare_list()
 * delete_product_on_compare_list()
 * clear_compare_list()
 * wpeccp_the_product_price()
 * get_compare_list_html_widget()
 * get_compare_list_html_popup()
 * add_meta_all_products()
 * auto_assign_master_category_to_all_products()
 * get_post_thumbnail()
 * modify_url()
 * printPage()
 * compare_extension()
 */
class WPEC_Compare_Functions{
	
	function get_variations($product_id){
		$wpsc_variations = new wpsc_variations( $product_id );
		$product_avalibale = array();
		$variation_list = array();
		foreach($wpsc_variations->all_associated_variations as $variation_groups){
			foreach($variation_groups as $variation){
				if($variation->term_id != 0){
					$variation_list[] = $variation->term_taxonomy_id;
				}
			}
		}
		global $wpdb;
		$sql = $wpdb->prepare( "SELECT tr.`object_id`
				FROM `".$wpdb->term_relationships."` AS tr
				LEFT JOIN `".$wpdb->posts."` AS posts
				ON posts.`ID` = tr.`object_id`
				WHERE tr.`term_taxonomy_id` IN (".implode(',', esc_sql( $variation_list ) ).") and posts.`post_parent` = %d", $product_id );
		$product_ids = $wpdb->get_col($sql);
		
		if(is_array($product_ids) && count($product_ids) > 0){
			foreach($product_ids as $variation_id){
				if(WPEC_Compare_Functions::check_product_activate_compare($variation_id) && WPEC_Compare_Functions::check_product_have_cat($variation_id)){
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
	
	function check_product_have_cat($product_id){
		$compare_category = get_post_meta( $product_id, '_wpsc_compare_category', true );
		if($compare_category > 0 && WPEC_Compare_Categories_Data::get_count("id='".$compare_category."'") > 0){
			$compare_fields = WPEC_Compare_Categories_Fields_Data::get_fieldid_results($compare_category);
			if(is_array($compare_fields) && count($compare_fields)>0){
				return true;	
			}else{
				return false;
			}
		}else{
			return false;	
		}
	}
	
	function add_product_to_compare_list($product_id){
		$product_list = WPEC_Compare_Functions::get_variations($product_id);
		if(count($product_list) < 1 && WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id)) $product_list = array($product_id);
		if(is_array($product_list) && count($product_list) > 0){
			if(isset($_SESSION['wpec_compare_list']))
				$current_compare_list = (array)$_SESSION['wpec_compare_list'];
			else
				$current_compare_list = array();
			foreach($product_list as $product_add){
				if(!in_array($product_add, $current_compare_list)){
					$current_compare_list[] = $product_add;
				}
			}
			$_SESSION['wpec_compare_list'] = $current_compare_list;
		}
	}
	
	function get_compare_list(){
		if(isset($_SESSION['wpec_compare_list']))
			$current_compare_list = (array)$_SESSION['wpec_compare_list'];
		else
			$current_compare_list = array();
		$return_compare_list = array();
		if(is_array($current_compare_list) && count($current_compare_list) > 0){
			foreach($current_compare_list as $product_id){
				if(WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id)){
					$return_compare_list[] = $product_id;
				}
			}
		}
		return $return_compare_list;
	}
	
	function get_total_compare_list(){
		if(isset($_SESSION['wpec_compare_list']))
			$current_compare_list = (array)$_SESSION['wpec_compare_list'];
		else
			$current_compare_list = array();
		$return_compare_list = array();
		if(is_array($current_compare_list) && count($current_compare_list) > 0){
			foreach($current_compare_list as $product_id){
				if(WPEC_Compare_Functions::check_product_activate_compare($product_id) && WPEC_Compare_Functions::check_product_have_cat($product_id)){
					$return_compare_list[] = $product_id;
				}
			}
		}
		return count($return_compare_list);
	}
	
	function delete_product_on_compare_list($product_id){
		if(isset($_SESSION['wpec_compare_list']))
			$current_compare_list = (array)$_SESSION['wpec_compare_list'];
		else
			$current_compare_list = array();
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
					$html .= '<div class="compare_remove_column" style="float:right; margin-left:5px;"><a class="compare_remove_product" rel="'.$product_id.'" style="cursor:pointer;"><img src="'.ECCP_IMAGES_URL.'/compare_remove.png" border=0 /></a></div>';
					$html .= '<div class="compare_title_column">'.get_the_title($product_id).'</div>';
				$html .= '</li>';
			}
			$html .= '</ul>';
			$html .= '<div class="compare_widget_action" style="margin-top:10px;"><a class="compare_clear_all" style="cursor:pointer;float:left;">'.__( 'Clear All', 'wpec_cp' ).'</a> <input style="float:right;" type="button" name="compare_button_go" class="compare_button_go" value="'.__('Compare', 'wpec_cp').'" /><div style="clear:both"></div></div>';
		}else{
			$html .= '<div class="no_compare_list">'.__('You do not have any product to compare', 'wpec_cp').'.</div>';	
		}
		return $html;
	}
	
	function get_compare_list_html_popup(){
		$compare_list = WPEC_Compare_Functions::get_compare_list();
		$html = '';
		$product_cats = array();
		$products_fields = array();
		if(is_array($compare_list) && count($compare_list)>0){
			$html .= '<table class="compare_popup_table" border="0" cellpadding="5" cellspacing="0" width="">';
				$html .= '<tr><td class="column_first first_row"></td>';
				foreach($compare_list as $product_id){
					$product_cat = get_post_meta( $product_id, '_wpsc_compare_category', true );
					$products_fields[$product_id] = WPEC_Compare_Categories_Fields_Data::get_fieldid_results($product_cat);
					if($product_cat > 0){
						$product_cats[] = $product_cat;
					}
					$html .= '<td class="first_row"><a class="compare_popup_remove_product" rel="'.$product_id.'" style="cursor:pointer;"><img src="'.ECCP_IMAGES_URL.'/compare_remove.png" border=0 /></a></td>';
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
						$html .= '<div class="compare_avg_rating">'.__( 'Avg. Customer Rating', 'wpec_cp' ).':<br />'.wpsc_product_existing_rating( $product_id ).'</div>';
						$html .= '<div class="compare_price">'.WPEC_Compare_Functions::wpeccp_the_product_price($product_id).'</div>';
					if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')){
						$html .= '<div class="compare_add_cart">';
						$html .= '<form class="product_form" id="product_'.$product_id.'" enctype="multipart/form-data" action="" method="post" name="product_'.$product_id.'">';														
							$html .= '<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />';
							$html .= '<input type="hidden" value="'.$product_id.'" name="product_id" />';
							
								if(wpsc_product_has_stock($product_id)){
									$html .= '<div class="wpsc_buy_button_container">';
									if(wpsc_product_external_link($product_id) == ''){
										$html .= '<input type="submit" value="'.__('Add To Cart', 'wpec_cp').'" name="Buy" class="wpsc_buy_button" id="product_'.$product_id.'_submit_button" />';
									}
									$html .= '</div>';
								}else{
									$html .= '<p class="soldout">'.__('This product has sold out.', 'wpec_cp').'</p>';
								}
						$html .= '</form>';
						$html .= '</div>';
					}
					$html .= '</td>';
				}
				$html .= '</tr>';
		$product_cats = implode(",", $product_cats);
		$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results('cat_id IN('.$product_cats.')','cf.cat_id ASC, cf.field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
			$j = 1;
			foreach($compare_fields as $field_data){
				$j++;
				$html .= '<tr class="row_'.$j.'">';
				if(trim($field_data->field_unit) != '')
					$html .= '<td class="column_first">'.stripslashes($field_data->field_name).' ('.trim(stripslashes($field_data->field_unit)).')</td>';
				else
					$html .= '<td class="column_first">'.stripslashes($field_data->field_name).'</td>';
				$i = 0;
				foreach($compare_list as $product_id){
					$i++;
					if(in_array($field_data->id, $products_fields[$product_id])){					
						$field_value = get_post_meta( $product_id, '_wpsc_compare_'.$field_data->field_key, true );
						if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
						elseif(is_array($field_value) && count($field_value) < 0) $field_value = __('N/A', 'wpec_cp');
						if(trim($field_value) == '') $field_value = __('N/A', 'wpec_cp');
					}else{
						$field_value = '';
					}
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
			$html .= '<div class="no_compare_list">'.__('You do not have any product to compare', 'wpec_cp').'.</div>';	
		}
		return $html;
	}
	
	function add_meta_all_products(){
		
		// Add deactivate compare feature meta for all products when activate this plugin
		$have_deactivate_meta = get_posts(array('numberposts' => -1, 'post_type' => array('wpsc-product'), 'post_status' => array('publish', 'private'), 'meta_key' => '_wpsc_deactivate_compare_feature'));
		$have_ids = array();
		if(is_array($have_deactivate_meta) && count($have_deactivate_meta) > 0){
			foreach($have_deactivate_meta as $product){
				$have_ids[] = $product->ID;
			}
		}
		if(is_array($have_ids) && count($have_ids) > 0){
			$no_deactivate_meta = get_posts(array('numberposts' => -1, 'post_type' => array('wpsc-product'), 'post_status' => array('publish', 'private'), 'post__not_in' => $have_ids));
		}else{
			$no_deactivate_meta = get_posts(array('numberposts' => -1, 'post_type' => array('wpsc-product'), 'post_status' => array('publish', 'private')));
		}
		if(is_array($no_deactivate_meta) && count($no_deactivate_meta) > 0){
			foreach($no_deactivate_meta as $product){
				add_post_meta($product->ID, '_wpsc_deactivate_compare_feature', '');
			}
		}
		
		// Add deactivate compare feature meta for all products when activate this plugin
		$have_compare_category_meta = get_posts(array('numberposts' => -1, 'post_type' => array('wpsc-product'), 'post_status' => array('publish', 'private'), 'meta_key' => '_wpsc_compare_category_name'));
		$have_ids = array();
		if(is_array($have_compare_category_meta) && count($have_compare_category_meta) > 0){
			foreach($have_compare_category_meta as $product){
				$have_ids[] = $product->ID;
			}
		}
		if(is_array($have_ids) && count($have_ids) > 0){
			$no_compare_category_meta = get_posts(array('numberposts' => -1, 'post_type' => array('wpsc-product'), 'post_status' => array('publish', 'private'), 'post__not_in' => $have_ids));
		}else{
			$no_compare_category_meta = get_posts(array('numberposts' => -1, 'post_type' => array('wpsc-product'), 'post_status' => array('publish', 'private')));
		}
		if(is_array($no_compare_category_meta) && count($no_compare_category_meta) > 0){
			foreach($no_compare_category_meta as $product){
				add_post_meta($product->ID, '_wpsc_compare_category_name', '');
			}
		}
		
		// Add compare category name into product have compare category id
		$have_compare_category_id_meta = get_posts(array('numberposts' => -1, 'post_type' => array('wpsc-product'), 'post_status' => array('publish'), 'meta_key' => '_wpsc_compare_category'));
		if(is_array($have_compare_category_id_meta) && count($have_compare_category_id_meta) > 0){
			foreach($have_compare_category_id_meta as $product){
				$compare_category = get_post_meta( $product->ID, '_wpsc_compare_category', true );
				$category_data = WPEC_Compare_Categories_Data::get_row($compare_category);
				update_post_meta($product->ID, '_wpsc_compare_category_name', $category_data->category_name);
			}
		}
		
	}
	
	function auto_assign_master_category_to_all_products() {
		$master_category = 'Master Category';
		$master_category_id = get_option('master_category_compare');
		$all_products = get_posts(array('numberposts' => -1, 'post_type' => array('wpsc-product'), 'post_status' => array('publish', 'private')));		
		if (is_array($all_products) && count($all_products) > 0) {
			foreach ($all_products as $product) {
				update_post_meta( $product->ID, '_wpsc_compare_category', $master_category_id );
				update_post_meta( $product->ID, '_wpsc_compare_category_name', $master_category);
			}
		}

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
	
	function modify_url($mod=array()){
		$url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
 		$url .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
 		$url .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
		
		$query = explode("&", $_SERVER['QUERY_STRING']);
		if (!$_SERVER['QUERY_STRING']) {
			$queryStart = "?";
			foreach($mod as $key => $value){
				if($value != ''){
					$url .= $queryStart.$key.'='.$value;
					$queryStart = "&";
				}
			}
		} else {
		// modify/delete data
			foreach($query as $q){
				list($key, $value) = explode("=", $q);
				if(array_key_exists($key, $mod)){
					if($mod[$key]){
						$url = preg_replace('/'.$key.'='.$value.'/', $key.'='.$mod[$key], $url);
					}else{
						$url = preg_replace('/&?'.$key.'='.$value.'/', '', $url);
					}
				}
			}
			// add new data
			foreach($mod as $key => $value){
				if($value && !preg_match('/'.$key.'=/', $url)){
					$url .= '&'.$key.'='.$value;
				}
			}
		}
		return $url;
	}
	
	function printPage($link, $total = 0,$currentPage = 1,$div = 3,$rows = 5, $li = false, $a_class= ''){
		if(!$total || !$rows || !$div || $total<=$rows) return false;
		$nPage = floor($total/$rows) + (($total%$rows)?1:0);
		$nDiv  = floor($nPage/$div) + (($nPage%$div)?1:0);	
		$currentDiv = floor(($currentPage-1)/$div) ;	
		$sPage = '';	
		if($currentDiv) {	
			if($li){
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', 1, $link).'">&laquo;</a></span></li>';	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', $currentDiv*$div, $link).'">'.__("Back", "wpec_cp").'</a></span></li>';	
			}else{
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', 1, $link).'">&laquo;</a> ';	
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', $currentDiv*$div, $link).'">'.__("Back", "wpec_cp").'</a> ';	
			}
		}
		$count =($nPage<=($currentDiv+1)*$div)?($nPage-$currentDiv*$div):$div;	
		for($i=1;$i<=$count;$i++){	
			$page = ($currentDiv*$div + $i);	
			if($li){
				$sPage .= '<li '.(($page==$currentPage)? 'class="current"':'class="page-numbers"').'><span class="pagenav"><a title="" href="'.add_query_arg('pp', ($currentDiv*$div + $i ), $link).'" '.(($page==$currentPage)? 'class="current '.$a_class.'"':'class="page-numbers '.$a_class.'"').'>'.$page.'</a></span></li>';
			}else{
				$sPage .= '<a title="" href="'.add_query_arg('pp', ($currentDiv*$div + $i ), $link).'" '.(($page==$currentPage)? 'class="current '.$a_class.'"':'class="page-numbers '.$a_class.'"').'>'.$page.'</a> ';
			}
		}	
		if($currentDiv < $nDiv - 1){	
			if($li){	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', ((($currentDiv+1)*$div)+1), $link).'">'.__("Next", "wpec_cp").'</a></span></li>';	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', (($nDiv*$div )-2), $link).'">&raquo;</a></span></li>';	
			}else{
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', ((($currentDiv+1)*$div)+1), $link).'">'.__("Next", "wpec_cp").'</a> ';	
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', (($nDiv*$div )-2), $link).'">&raquo;</a>';	
			}
		}	
		return 	$sPage;	
	}
	
	function compare_extension() {
		$html = '';
		$html .= '<div id="compare_extensions">'.__('See more quality WP e-Commerce plugins at the', 'wpec_cp').' <a target="_blank" href="http://a3rev.com/product-category/wp-e-commerce/">'.__('A3 WPEC extensions', 'wpec_cp').'</a>.</div>';
		return $html;	
	}
	
	function create_category_extension() {
		$html = '';
		$html .= '<div class="upgrade_extensions"><a href="http://a3rev.com/shop/" target="_blank" style="float:left; margin-right:10px;"><img src="'.ECCP_IMAGES_URL.'/logo_a3blue.png" /></a> '.__('Please upgrade to the', 'wpec_cp').' <a target="_blank" href="'.A3REV_AUTHOR_URI.'">'.__('Pro Version', 'wpec_cp').'</a> '.__('to activate the power of Compare Categories. Find out more', 'woo_cp').' <a href="http://docs.a3rev.com/user-guides/wp-e-commerce/wpec-compare-products/" target="_blank">'.__('here.', 'wpec_cp').'</a></div>';
		return $html;	
	}
	
	function products_tab_extension() {
		$html = '';
		$html .= '<div class="upgrade_extensions products_tab_extension"><a href="http://a3rev.com/shop/" target="_blank" style="float:left; margin-right:10px;"><img src="'.ECCP_IMAGES_URL.'/logo_a3blue.png" /></a>'.__('Make managing the Compare products feature across your entire catalog a breeze. Upgrade to the', 'wpec_cp').' <a target="_blank" href="'.A3REV_AUTHOR_URI.'">'.__('Pro Version', 'wpec_cp').'</a> '.__('to activate this feature.', 'wpec_cp').'</div>';
		return $html;	
	}
	
	function other_plugins_notice() {
		$html = '';
		$html .= '<div id="a3rev_plugins_notice">';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><img src="'.ECCP_IMAGES_URL.'/a3logo.png" /></a>';
		$html .= '<h3>'.__('Upgrade to Compare Products Pro', 'wpec_cp').'</h3>';
		$html .= '<p>'.__("Visit the", 'wpec_cp').' <a href="http://a3rev.com/shop/wpec-compare-products/" target="_blank">'.__("a3rev website", 'wpec_cp').'</a> '.__("to see all the extra features the Pro version of this plugin offers, like the Compare categories that you can see inside the yellow box. All of your Product Categories have been auto created here as Compare categories. The Lite Version uses only 1 category - The Master category. All of your product attributes have been auto created as Compare features under the Master category.", 'wpec_cp').'</p>';
		$html .= '<h3>'.__('Plugin Documentation', 'wpec_cp').'</h3>';
		$html .= '<p>'.__('All of our plugins have comprehensive online documentation. Please refer to the plugins docs before raising a support request', 'wpec_cp').'. <a href="http://docs.a3rev.com/user-guides/wp-e-commerce/wpec-compare-products/" target="_blank">'.__('Visit the a3rev wiki.', 'wpec_cp').'</a></p>';
		$html .= '<h3>'.__('More a3rev Quality Plugins', 'wpec_cp').'</h3>';
		$html .= '<p>'.__('Below is a list of the a3rev plugins that are available for free download from wordpress.org', 'wpec_cp').'</p>';
		$html .= '<h3>'.__('WP e-Commerce Plugins', 'wpec_cp').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('WP e-Commerce Dynamic Gallery', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-predictive-search/" target="_blank">'.__('WP e-Commerce Predictive Search', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-ecommerce-compare-products/" target="_blank">'.__('WP e-Commerce Compare Products', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-catalog-visibility-and-email-inquiry/" target="_blank">'.__('WP e-Commerce Catalog Visibility & Email Inquiry', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-grid-view/" target="_blank">'.__('WP e-Commerce Grid View', 'wpec_cp').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		
		$html .= '<h3>'.__('WordPress Plugins', 'wpec_cp').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'wpec_cp').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('WooCommerce Plugins', 'wpec_cp').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('WooCommerce Dynamic Products Gallery', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-predictive-search/" target="_blank">'.__('WooCommerce Predictive Search', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-compare-products/" target="_blank">'.__('WooCommerce Compare Products', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woo-widget-product-slideshow/" target="_blank">'.__('WooCommerce Widget Product Slideshow', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://a3rev.com/shop/woocommerce-email-inquiry-and-cart-options/" target="_blank">'.__('WooCommerce Email Inquiry & Cart Options', 'wpec_cp').'</a>'.__(' - Pro Version only from a3rev', 'wpec_cp').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('Help spread the Word about this plugin', 'wpec_cp').'</h3>';
		$html .= '<p>'.__("Things you can do to help others find this plugin", 'wpec_cp');
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-ecommerce-compare-products/" target="_blank">'.__('Rate this plugin 5', 'wpec_cp').' <img src="'.ECCP_IMAGES_URL.'/stars.png" align="top" /> '.__('on WordPress.org', 'wpec_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-ecommerce-compare-products/" target="_blank">'.__('Mark the plugin as a fourite', 'wpec_cp').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '</div>';
		return $html;	
	}
}
?>
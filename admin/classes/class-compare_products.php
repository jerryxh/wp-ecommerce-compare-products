<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Products Manager
 *
 * Table Of Contents
 *
 * wpeccp_get_products()
 * wpeccp_products_manager()
 * wpeccp_compare_products_script()
 */
class WPEC_Compare_Products_Class{
	function wpeccp_get_products(){
		check_ajax_referer( 'wpeccp-products-manager', 'security' );
		
		$paged = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$cp_show_variations = isset($_POST['cp_show_variations']) ? $_POST['cp_show_variations'] : 0;
		$start = ($paged-1)*$rp;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'title';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'asc';
		$query = isset($_POST['query']) ? $_POST['query'] : false;
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;
		
		$data_a = array();
		$data_a['s'] = $query;
		$data_a['numberposts'] = $rp;
		$data_a['offset'] = $start;
		if($sortname == 'title'){
			$data_a['orderby'] = $sortname;
		}else{
			$data_a['orderby'] = 'meta_value';
			$data_a['meta_key'] = $sortname;
		}
		$data_a['order'] = strtoupper($sortorder);
		$data_a['post_type'] = 'wpsc-product';
		$data_a['post_status'] = array('private', 'publish');
		
		$all_data = array();
		$all_data['s'] = $query;
		$all_data['posts_per_page'] = 1;
		$all_data['post_type'] = 'wpsc-product';
		$all_data['post_status'] = array('private', 'publish');
		
		
		//$all_products = get_posts($all_data);
		//$total = count($all_products);
		$query = new WP_Query($all_data);
		$total = $query->found_posts;
		//$total = $wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_title LIKE '%{$query}%' AND post_type='wpsc-product' AND post_status IN ('private', 'publish') ;");
		$products = get_posts($data_a);
		
		$jsonData = array('page'=>$paged,'total'=>$total,'rows'=>array());
		$number = $start;
		
		foreach($products as $product){
			$number++;
			//If cell's elements have named keys, they must match column names
			//Only cell's with named keys and matching columns are order independent.
			$terms = get_the_terms( $product->ID, 'wpsc_product_category' );
			$on_cats = '';
			if ( $terms && ! is_wp_error( $terms ) ){ 
				$cat_links = array();		
				foreach ( $terms as $term ) {
					$cat_links[] = $term->name;
				}
				$on_cats = join( ", ", $cat_links );
			}
			$compare_category = get_post_meta( $product->ID, '_wpsc_compare_category_name', true );
			$deactivate_compare_feature = get_post_meta( $product->ID, '_wpsc_deactivate_compare_feature', true );
			if($deactivate_compare_feature == 'no' && $compare_category != '') $status = '<font style="color:green">'.__( "Activated", 'wpec_cp' ).'</font>';
			else $status = '<font style="color:red">'.__( "Deactivated", 'wpec_cp' ).'</font>';
			
			$entry = array(
					'id' => $product->ID,
					'cell' => array(
						'number' => $number,
						'title' => $product->post_title,
						'cat' => $on_cats,
						'_wpsc_compare_category_name' => $compare_category,
						'_wpsc_deactivate_compare_feature' => $status,
						'edit' => '<span rel="'.$product->ID.'|'.$paged.'|'.$rp.'|'.$sortname.'|'.$sortorder.'|'.$cp_show_variations.'|'.$qtype.'" class="edit_product_compare">'.__( "Edit", 'wpec_cp' ).'</span>'
					),
				);
			$jsonData['rows'][] = $entry;
			if($cp_show_variations == 1){
				$wpsc_variations = new wpsc_variations( $product->ID );
				$variation_list = array();
				foreach($wpsc_variations->all_associated_variations as $variation_groups){
					foreach($variation_groups as $variation){
						if($variation->term_id != 0){
							$variation_list[] = $variation->term_taxonomy_id;
						}
					}
				}
				global $wpdb;
				$sql = $wpdb->prepare( "SELECT DISTINCT tr.`object_id`
						FROM `".$wpdb->term_relationships."` AS tr
						LEFT JOIN `".$wpdb->posts."` AS posts
						ON posts.`ID` = tr.`object_id`
						WHERE tr.`term_taxonomy_id` IN (".implode(',', esc_sql( $variation_list ) ).") and posts.`post_parent` = %d", $product->ID );
				$product_ids = $wpdb->get_col($sql);
				
				if(is_array($product_ids) && count($product_ids) > 0){
					foreach($product_ids as $variation_id){
						$compare_category = get_post_meta( $variation_id, '_wpsc_compare_category_name', true );
						$deactivate_compare_feature = get_post_meta( $variation_id, '_wpsc_deactivate_compare_feature', true );
						if($deactivate_compare_feature == 'no' && $compare_category != '') $status = '<font style="color:green">'.__( "Activated", 'wpec_cp' ).'</font>';
						else $status = '<font style="color:red">'.__( "Deactivated", 'wpec_cp' ).'</font>';
						
						$entry = array(
							'id' => $variation_id,
							'cell' => array(
								'number' => '',
								'title' => '-- '.get_the_title($variation_id),
								'cat' => $on_cats,
								'_wpsc_compare_category_name' => $compare_category,
								'_wpsc_deactivate_compare_feature' => $status,
								'edit' => '<span rel="'.$variation_id.'|'.$paged.'|'.$rp.'|'.$sortname.'|'.$sortorder.'|'.$cp_show_variations.'|'.$qtype.'"  class="edit_product_compare">'.__( "Edit", 'wpec_cp' ).'</span>'
							),
						);
						$jsonData['rows'][] = $entry;
					}
				}
			}
		}
		echo json_encode($jsonData);
		die();
	}
		
	function wpeccp_products_manager(){
		$compare_product_message = '';
		$paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$cp_show_variations = isset($_POST['cp_show_variations']) ? $_POST['cp_show_variations'] : 0;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'title';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'asc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';
				
		if(isset($_REQUEST['bt_update_product_features'])){
			if(isset($_REQUEST['productid']) && $_REQUEST['productid'] > 0){
				$post_id = $_REQUEST['productid'];
				$post_status = get_post_status($post_id);
				$post_type = get_post_type($post_id);
				if($post_type == 'wpsc-product' && $post_status != false){
					if(isset($_REQUEST['_wpsc_deactivate_compare_feature']) && $_REQUEST['_wpsc_deactivate_compare_feature'] == 'no'){
						update_post_meta($post_id, '_wpsc_deactivate_compare_feature', 'no');
					}else{
						update_post_meta($post_id, '_wpsc_deactivate_compare_feature', 'yes');
					}
					$compare_category = $_REQUEST['_wpsc_compare_category'];
					update_post_meta($post_id, '_wpsc_compare_category', $compare_category);
					
					$category_data = WPEC_Compare_Categories_Data::get_row($compare_category);
					update_post_meta($post_id, '_wpsc_compare_category_name', $category_data->category_name);
					
					$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'",'cf.field_order ASC');
					if(is_array($compare_fields) && count($compare_fields)>0){
						foreach($compare_fields as $field_data){
							if ( isset($_REQUEST['_wpsc_compare_'.$field_data->field_key]) ) {
								update_post_meta($post_id, '_wpsc_compare_'.$field_data->field_key, $_REQUEST['_wpsc_compare_'.$field_data->field_key]);
							}
						}
					}
				}
				$compare_product_message = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Product Feature Fields updated successfully','wpec_cp').'.</p></div>';
			}
		}
?>
<?php echo $compare_product_message; ?>
<div id="wpec_compare_product_panel_container">
<div id="wpec_compare_product_panel_fields">
	<div class="pro_feature_fields" style="margin-top:15px; padding-left:5px; padding-bottom:10px;">
    <h3><?php _e('WPEC Compare Products Manager', 'wpec_cp'); ?></h3>
    <div style="clear:both; margin-bottom:20px;"></div>
    <table id="wpeccp_products_manager" style="display:none"></table>
    </div>
</div>
<div id="wpec_compare_product_upgrade_area"><?php echo WPEC_Compare_Functions::plugin_pro_notice(); ?></div>
</div>
    <?php 
		$wpeccp_products_manager = wp_create_nonce("wpeccp-products-manager");
		$wpeccp_popup_features = wp_create_nonce("wpeccp-popup-features");
	?>
    <script type="text/javascript">
	(function($){		
		$(function(){
			$("#wpeccp_products_manager").flexigrid({
				url: '<?php echo admin_url( 'admin-ajax.php', 'relative' ) .'?action=wpeccp_get_products&security='.$wpeccp_products_manager; ?>',
				dataType: 'json',
				width: 'auto',
				resizable: false,
				colModel : [
					{display: '<?php _e( "No.", 'wpec_cp' ); ?>', name : 'number', width : 20, sortable : false, align: 'right'},
					{display: '<?php _e( "Product Name", 'wpec_cp' ); ?>', name : 'title', width : 200, sortable : true, align: 'left'},
					{display: '<?php _e( "Product Category", 'wpec_cp' ); ?>', name : 'cat', width : 110, sortable : false, align: 'left'},
					{display: '<?php _e( "Compare Category", 'wpec_cp' ); ?>', name : '_wpsc_compare_category_name', width : 110, sortable : true, align: 'left'},
					{display: '<?php _e( "Activated / Deactivated", 'wpec_cp' ) ;?>', name : '_wpsc_deactivate_compare_feature', width : 110, sortable : false, align: 'center'},
					{display: '<?php _e( "Edit", 'wpec_cp' ); ?>', name : 'edit', width : 30, sortable : false, align: 'center'}
					],
				searchitems : [
					{display: 'Product Name', name : 'title', isdefault: true}
					],
				sortname: "title",
				sortorder: "asc",
				usepager: true,
				title: '<?php _e( "Products", 'wpec_cp' ); ?>',
				findtext: '<?php _e( "Find Product Name", 'wpec_cp' ); ?>',
				useRp: true,
				rp: <?php echo $rp; ?>, //results per page
				newp: <?php echo $paged; ?>,
				page: <?php echo $paged; ?>,
				query: '<?php echo $query; ?>',
				qtype: '<?php echo $qtype; ?>',
				sortname: '<?php echo $sortname; ?>',
				sortorder: '<?php echo $sortorder; ?>',
				rpOptions: [10, 15, 20, 30, 50, 100], //allowed per-page values 
				showToggleBtn: false, //show or hide column toggle popup
				showTableToggleBtn: false,
				height: 'auto',
				variations: '<?php echo $cp_show_variations; ?>'
			});
			$(document).on("click", ".edit_product_compare", function(){
				return alert_upgrade('<?php _e( 'Please upgrade to the Pro Version to activate Products express Compare feature manager', 'wpec_cp' ); ?>');
			});
		});		  
	})(jQuery);
	</script>
<?php
	}
	
	function wpeccp_compare_products_script(){
		echo'<style>
			#TB_ajaxContent{padding-bottom:0 !important; padding-right:0 !important; height:auto !important; width:auto !important;}
			#TB_iframeContent{width:auto !important; padding-right:10px !important; margin-bottom:0px !important; max-height:480px !important;}
		</style>';
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.pack';
		
		//wp_enqueue_script('jquery');
		// validate
		wp_enqueue_script('wpeccp_flexigrid_script', ECCP_JS_URL . '/flexigrid/js/flexigrid'.$suffix.'.js');
		wp_enqueue_style( 'wpeccp_flexigrid_style',ECCP_JS_URL . '/flexigrid/css/flexigrid'.$suffix.'.css' );
				
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
	}
}
?>
<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Products Manager
 *
 * Table Of Contents
 *
 * wpeccp_get_products()
 * wpeccp_popup_features()
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
				$sql = $wpdb->prepare( "SELECT tr.`object_id`
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
	
	function wpeccp_popup_features(){
		check_ajax_referer( 'wpeccp-popup-features', 'security' );
		$post_id = 0;
		$paged = 1;
		$rp = 10;
		$sortname = 'title';
		$sortorder = 'asc';
		$cp_show_variations = 0;
		$query = false;
		$qtype = false;
		$product_data = explode('|',$_REQUEST['product_data']);
		if(is_array($product_data) && count($product_data) > 0){
			$post_id = $product_data[0];
			$paged = $product_data[1];
			$rp = $product_data[2];
			$sortname = $product_data[3];
			$sortorder = $product_data[4];
			$cp_show_variations = $product_data[5];
			$qtype = $product_data[6];			
		}
		if(isset($_REQUEST['search_string']) && trim($_REQUEST['search_string']) != '') $query = trim($_REQUEST['search_string']);
		
		$wpeccp_product_compare = wp_create_nonce("wpeccp-product-compare");
		$deactivate_compare_feature = get_post_meta( $post_id, '_wpsc_deactivate_compare_feature', true );
		$compare_category = get_post_meta( $post_id, '_wpsc_compare_category', true );
		?>
        <style>
		#compare_cat_fields table td input[type="text"], #compare_cat_fields table td textare, #compare_cat_fields table td select{ width:250px !important; }
		</style>
        <script type="text/javascript">
		(function($){
			$(function(){
				$("#compare_category").change(function(){
					var cat_id = $(this).val();
					var post_id = <?php echo $post_id; ?>;
					$(".compare_widget_loader").show();
					var data = {
                        action: 'wpeccp_product_get_fields',
                        cat_id: cat_id,
                        post_id: post_id,
                        security: '<?php echo $wpeccp_product_compare; ?>'
                    };
                    $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
						$(".compare_widget_loader").hide();
						$("#compare_cat_fields").html(response);
					});
				});	
			});	
		})(jQuery);
		</script>
		<div id="TB_iframeContent" style="position:relative;width:100%;">
        <div style="padding:10px 25px;">
        <form action="edit.php?post_type=wpsc-product&page=wpsc-compare-settings&tab=compare-products" method="post" name="form_product_features">
        	<input type="hidden" name="paged" value="<?php echo $paged; ?>" />
            <input type="hidden" name="rp" value="<?php echo $rp; ?>" />
            <input type="hidden" name="sortname" value="<?php echo $sortname; ?>" />
            <input type="hidden" name="sortorder" value="<?php echo $sortorder; ?>" />
            <input type="hidden" name="cp_show_variations" value="<?php echo $cp_show_variations; ?>" />
            <input type="hidden" name="qtype" value="<?php echo $qtype; ?>" />
        	<input type="hidden" name="query" value="<?php echo $query; ?>" />
        	<h3><?php echo get_the_title($post_id); ?></h3>
            <input type="hidden" name="productid" value="<?php echo $post_id; ?>" />
            <p><input id='deactivate_compare_feature' type='checkbox' value='no' <?php if ( $deactivate_compare_feature == 'no' ) echo 'checked="checked"'; else echo ''; ?> name='_wpsc_deactivate_compare_feature' style="float:none; width:auto; display:inline-block;" />
            <label style="display:inline-block" for='deactivate_compare_feature' class='small'><?php _e( "Activate Compare Feature for this Product", 'wpec_cp' ); ?></label></p>
            <label style="display:inline-block; float:left;" for='compare_category' class='small'><?php _e( "Select a  Compare Category for this Product", 'wpec_cp' ); ?> :</label>
            <p style="margin:0; padding:0; margin-left:290px;"><select name="_wpsc_compare_category" id="compare_category" style="width:180px; margin-top:-2px;">
                    <option value="0"><?php _e('Select...', 'wpec_cp'); ?></option>
            <?php
                $compare_cats = WPEC_Compare_Categories_Data::get_results("id = '".$master_category_id."'", 'category_order ASC');
                if(is_array($compare_cats) && count($compare_cats)>0){
                    foreach($compare_cats as $cat_data){
                        if($compare_category == $cat_data->id){
                            echo '<option selected="selected" value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';	
                        }else{
                            echo '<option value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
                        }
                    }
                }
            ?>
                </select> <img class="compare_widget_loader" style="display:none;" src="<?php echo ECCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 />
            </p>
            <div style="clear:both; margin-bottom:10px;"></div>
            <div id="compare_cat_fields" style=""><?php WPEC_Compare_MetaBox::wpec_show_field_of_cat($post_id, $compare_category); ?></div>
            
            <div style="text-align:left; display:inline-block; padding:10px 0 30px 0;">
            	<input type="submit" name="bt_update_product_features" id="bt_update_product_features" class="button" value="<?php _e( "Update", 'wpec_cp' ); ?>" /> 
                <a onclick="tb_remove(); return false;" href="#" style="color:#21759B; margin-left:10px;"><?php _e( "Cancel", 'wpec_cp' ); ?></a>
            </div>
        </form>
        </div>
        </div>
		<?php        
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
							update_post_meta($post_id, '_wpsc_compare_'.$field_data->field_key, $_REQUEST['_wpsc_compare_'.$field_data->field_key]);
						}
					}
				}
				$compare_product_message = '<div class="updated " id="result_msg"><p>'.__('Compare Product Feature Fields updated successfully','wpec_cp').'.</p></div>';
			}
		}
?>
    <h3><?php _e('WPEC Compare Products Manager', 'wpec_cp'); ?></h3>
    <?php echo $compare_product_message; ?>
    <div style="clear:both; margin-bottom:20px;"></div>
    <table id="wpeccp_products_manager" style="display:none"></table>
    <?php 
		$wpeccp_products_manager = wp_create_nonce("wpeccp-products-manager");
		$wpeccp_popup_features = wp_create_nonce("wpeccp-popup-features");
	?>
    <script type="text/javascript">
	(function($){		
		$(function(){
			$("#wpeccp_products_manager").flexigrid({
				url: '<?php echo admin_url("admin-ajax.php").'?action=wpeccp_get_products&security='.$wpeccp_products_manager; ?>',
				dataType: 'json',
				width: 'auto',
				resizable: false,
				colModel : [
					{display: '<?php _e( "No.", 'wpec_cp' ); ?>', name : 'number', width : 30, sortable : false, align: 'right'},
					{display: '<?php _e( "Product Name", 'wpec_cp' ); ?>', name : 'title', width : 380, sortable : true, align: 'left'},
					{display: '<?php _e( "Product Category", 'wpec_cp' ); ?>', name : 'cat', width : 160, sortable : false, align: 'left'},
					{display: '<?php _e( "Compare Category", 'wpec_cp' ); ?>', name : '_wpsc_compare_category_name', width : 160, sortable : true, align: 'left'},
					{display: '<?php _e( "Activated / Deactivated", 'wpec_cp' ) ;?>', name : '_wpsc_deactivate_compare_feature', width : 110, sortable : false, align: 'center'},
					{display: '<?php _e( "Edit", 'wpec_cp' ); ?>', name : 'edit', width : 50, sortable : false, align: 'center'}
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
				variations: <?php echo $cp_show_variations; ?>
			});
			$(".edit_product_compare").live("click", function(ev){
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
		
		//wp_enqueue_style('a3_lightbox_style', ECCP_JS_URL . '/lightbox/themes/default/jquery.lightbox.css');
		//wp_enqueue_script('lightbox2_script', ECCP_JS_URL . '/lightbox/jquery.lightbox.js');
		
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
	}
}
?>
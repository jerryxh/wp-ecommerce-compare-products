<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Meta Box
 *
 * Table Of Contents
 *
 * compare_meta_boxes()
 * wpeccp_product_get_fields()
 * wpec_compare_feature_box()
 * wpec_show_field_of_cat()
 * save_compare_meta_boxes()
 */
class WPEC_Compare_MetaBox
{
	public static function compare_meta_boxes() {
		global $post;
		$pagename = 'wpsc-product';
		add_meta_box( 'wpec_compare_feature_box', __('Compare Feature Fields', 'wpec_cp'), array('WPEC_Compare_MetaBox', 'wpec_compare_feature_box'), $pagename, 'normal', 'high' );
	}
	
	public static function wpeccp_product_get_fields() {
		check_ajax_referer( 'wpeccp-product-compare', 'security' );
		$cat_id = $_REQUEST['cat_id'];
		$post_id = $_REQUEST['post_id'];
		WPEC_Compare_MetaBox::wpec_show_field_of_cat($post_id, $cat_id);
		die();
	}
	
	public static function wpec_compare_feature_box() {
		global $post;
		$wpeccp_product_compare = wp_create_nonce("wpeccp-product-compare");
		$deactivate_compare_feature = get_post_meta( $post->ID, '_wpsc_deactivate_compare_feature', true );
		$compare_category = get_post_meta( $post->ID, '_wpsc_compare_category', true );
		?>
        <script type="text/javascript">
		(function($){
			$(function(){
				$(document).on( 'click', '.deactivate_compare_feature', function(){
					if ($(this).is(':checked')) {
						$(this).siblings(".compare_feature_activate_form").show();
					} else {
						$(this).siblings(".compare_feature_activate_form").hide();
					}
				});
				$("#compare_category").change(function(){
					var cat_id = $(this).val();
					var post_id = <?php echo $post->ID; ?>;
					$(".wpec_compare_widget_loader").show();
					var data = {
                        action: 'wpeccp_product_get_fields',
                        cat_id: cat_id,
                        post_id: post_id,
                        security: '<?php echo $wpeccp_product_compare; ?>'
                    };
                    $.post('<?php echo admin_url( 'admin-ajax.php' , 'relative'); ?>', data, function(response) {
						$(".wpec_compare_widget_loader").hide();
						$("#compare_cat_fields").html(response);
					});
				});	
			});	
		})(jQuery);
		</script>
		<input id='deactivate_compare_feature' class="deactivate_compare_feature" type='checkbox' value='no' <?php if ( $deactivate_compare_feature == 'no' ) echo 'checked="checked"'; else echo ''; ?> name='_wpsc_deactivate_compare_feature' />
		<label for='deactivate_compare_feature' class='small'><?php _e( "Activate Compare Feature for this Product", 'wpec_cp' ); ?></label>
		<div class="compare_feature_activate_form" style=" <?php if ( $deactivate_compare_feature != 'no') { echo 'display:none;';} ?>">
            <p><label for='compare_category' class='small'><?php _e( "Select Compare Category for this Product", 'wpec_cp' ); ?></label> : 
                <select name="_wpsc_compare_category" id="compare_category" style="width:200px;">
                    <option value="0"><?php _e('Select...', 'wpec_cp'); ?></option>
            <?php
                $compare_cats = WPEC_Compare_Categories_Data::get_results('', 'category_order ASC');
                if (is_array($compare_cats) && count($compare_cats)>0) {
                    foreach ($compare_cats as $cat_data) {
                        if ($compare_category == $cat_data->id) {
                            echo '<option selected="selected" value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';	
                        } else {
                            echo '<option value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
                        }
                    }
                }
            ?>
                </select> <img class="wpec_compare_widget_loader" style="display:none;" src="<?php echo ECCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 />
            </p>
            <div id="compare_cat_fields"><?php WPEC_Compare_MetaBox::wpec_show_field_of_cat($post->ID, $compare_category); ?></div>
        </div>
<?php
	}
	
	public static function wpec_show_field_of_cat($post_id=0, $cat_id=0) {
		if($cat_id > 0 && WPEC_Compare_Categories_Data::get_count("id='".$cat_id."'") > 0){
?>
		<style>
			.comparison_category_features_data th{padding-left:0px !important;}
			@media screen and ( max-width: 782px ) {
				.comparison_category_features_data textarea, .comparison_category_features_data input[type="text"], .comparison_category_features_data input[type="email"], .comparison_category_features_data input[type="number"], .comparison_category_features_data input[type="password"], .comparison_category_features_data select {
					width: 100% !important;	
				}
			}
		</style>
		<table cellspacing="0" cellpadding="5" style="width: 100%;" class="form-table comparison_category_features_data">
            <tbody>
        <?php
		$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results("cat_id='".$cat_id."'",'cf.field_order ASC');
		if (is_array($compare_fields) && count($compare_fields)>0) {
			
			foreach ($compare_fields as $field_data) {
		?>
                <tr class="form-field">
                    <th valign="top" scope="row"><label for="<?php echo $field_data->field_key; ?>"><strong><?php echo stripslashes($field_data->field_name) ; ?> : </strong> <?php if(trim($field_data->field_unit) != ''){ ?>(<?php echo trim(stripslashes($field_data->field_unit)); ?>)<?php } ?></label><br /><?php echo $field_data->field_description; ?></th>
                    <td>
               	<?php
					$field_value = get_post_meta( $post_id, '_wpsc_compare_'.$field_data->field_key, true );
					switch($field_data->field_type){
						case "text-area":
							echo '<textarea style="width:400px" name="_wpsc_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'">'.$field_value.'</textarea>';
							break;
							
						case "checkbox":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if (!is_array($field_value)) $field_value = array();
							if (is_array($field_option) && count($field_option) > 0) {
								foreach ($field_option as $option_value) {
									$option_value = trim(stripslashes($option_value));
									if (in_array($option_value, $field_value)) {
										echo '<input type="checkbox" name="_wpsc_compare_'.$field_data->field_key.'[]" value="'.esc_attr($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" />'.esc_attr( $option_value ).' &nbsp;&nbsp;';
									} else{
										echo '<input type="checkbox" name="_wpsc_compare_'.$field_data->field_key.'[]" value="'.esc_attr($option_value).'" style="float:none; width:auto; display:inline-block;" />'.esc_attr( $option_value ).' &nbsp;&nbsp;';
									}
								}
							}
							break;
							
						case "radio":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if (is_array($field_option) && count($field_option) > 0) {
								foreach ($field_option as $option_value) {
									$option_value = trim(stripslashes($option_value));
									if ($option_value == $field_value) {
										echo '<input type="radio" name="_wpsc_compare_'.$field_data->field_key.'" value="'.esc_attr($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;';
									} else {
										echo '<input type="radio" name="_wpsc_compare_'.$field_data->field_key.'" value="'.esc_attr($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;';
									}
								}
							}
							break;
						
						case "drop-down":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							echo '<select name="_wpsc_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'" style="width:400px">';
								echo '<option value="">'.__( "Select value", 'wpec_cp' ).'</option>';
							if (is_array($field_option) && count($field_option) > 0) {
								foreach ($field_option as $option_value) {
									$option_value = trim(stripslashes($option_value));
									if ($option_value == $field_value) {
										echo '<option value="'.esc_attr($option_value).'" selected="selected">'.esc_attr( $option_value ).'</option>';
									} else {
										echo '<option value="'.esc_attr($option_value).'">'.esc_attr( $option_value ).'</option>';
									}
								}
							}
							echo '</select>';
							break;
						
						case "multi-select":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if (!is_array($field_value)) $field_value = array();
							echo '<select multiple="multiple" name="_wpsc_compare_'.$field_data->field_key.'[]" id="'.$field_data->field_key.'" style="width:400px">';
							if (is_array($field_option) && count($field_option) > 0) {
								foreach ($field_option as $option_value) {
									$option_value = trim(stripslashes($option_value));
									if (in_array($option_value, $field_value)) {
										echo '<option value="'.esc_attr($option_value).'" selected="selected">'.esc_attr( $option_value ).'</option>';
									} else {
										echo '<option value="'.esc_attr($option_value).'">'.esc_attr( $option_value ).'</option>';
									}
								}
							}
							echo '</select>';
							break;
							
						default:
							echo '<input style="width:400px" type="text" name="_wpsc_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'" value="'.esc_attr( $field_value ).'" />';
							break;
					}
				?>
                    </td>
                </tr>
        <?php		
			}
		}else{
		?>
        		<tr><td><i style="text-decoration:blink"><?php _e('Do not have any field on this category, please add fields for it at', 'wpec_cp'); ?> <a href="admin.php?page=wpsc-compare-features" target="_blank"><?php _e('this page', 'wpec_cp'); ?></a></i></td></tr>
        <?php	
		}
		?>
        	</tbody>
        </table>
        <?php
		}
	}
	
	public static function save_compare_meta_boxes($post_id) {
		$post_status = get_post_status($post_id);
		$post_type = get_post_type($post_id);
		if ($post_type == 'wpsc-product' && $post_status != false) {
			update_post_meta($post_id, '_wpsc_deactivate_compare_feature', 'yes');
			if (isset($_REQUEST['_wpsc_deactivate_compare_feature']) && $_REQUEST['_wpsc_deactivate_compare_feature'] == 'no') {
				update_post_meta($post_id, '_wpsc_deactivate_compare_feature', 'no');
			} else {
				update_post_meta($post_id, '_wpsc_deactivate_compare_feature', 'yes');
			}
			$compare_category = $_REQUEST['_wpsc_compare_category'];
			update_post_meta($post_id, '_wpsc_compare_category', $compare_category);
			
			$category_data = WPEC_Compare_Categories_Data::get_row($compare_category);
			update_post_meta($post_id, '_wpsc_compare_category_name', $category_data->category_name);
			
			$compare_fields = WPEC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'",'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {
				foreach ($compare_fields as $field_data) {
					update_post_meta($post_id, '_wpsc_compare_'.$field_data->field_key, $_REQUEST['_wpsc_compare_'.$field_data->field_key]);
				}
			}
		}
	}
}
?>
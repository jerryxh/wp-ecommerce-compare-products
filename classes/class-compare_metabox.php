<?php
/**
 * WPEC Compare Meta Box
 *
 * Table Of Contents
 *
 * compare_meta_boxes()
 * wpeccp_product_get_fields()
 * save_compare_meta_boxes()
 */
class WPEC_Compare_MetaBox{
	function compare_meta_boxes(){
		global $post;
		$pagename = 'wpsc-product';
		add_meta_box( 'wpec_compare_feature_box', __('Compare Feature Fields', 'wpec_cp'), array('WPEC_Compare_MetaBox', 'wpec_compare_feature_box'), $pagename, 'advanced', 'high' );
	}
	
	function wpec_compare_feature_box() {
		global $post;

		$deactivate_compare_feature = get_post_meta( $post->ID, '_wpsc_deactivate_compare_feature', true );
		?>
		<br /><input id='deactivate_compare_feature' type='checkbox' value='yes' <?php if ( $deactivate_compare_feature == 'yes' ) echo 'checked="checked"'; else echo ''; ?> name='meta[_wpsc_deactivate_compare_feature]' />
		<label for='deactivate_compare_feature' class='small'><?php _e( "Deactivate Compare Feature for this Product", 'wpec_cp' ); ?></label>
        <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
            <tbody>
        <?php
		$compare_fields = WPEC_Compare_Data::get_results('','field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
			
			foreach($compare_fields as $field_data){
		?>
                <tr class="form-field">
                    <th valign="top" scope="row"><label for="<?php echo $field_data->field_key; ?>"><strong><?php echo $field_data->field_name; ?> : </strong> <?php if(trim($field_data->field_unit) != ''){ ?>(<?php echo $field_data->field_unit; ?>)<?php } ?></label><br /><?php echo $field_data->field_description; ?></th>
                    <td>
               	<?php
					$field_value = get_post_meta( $post->ID, '_wpsc_compare_'.$field_data->field_key, true );
					switch($field_data->field_type){
						case "text-area":
							echo '<textarea name="meta[_wpsc_compare_'.$field_data->field_key.']" id="'.$field_data->field_key.'">'.$field_value.'</textarea>';
							break;
							
						case "checkbox":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if(!is_array($field_value)) $field_value = array();
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if(in_array($option_value, $field_value)){
										echo '<input type="checkbox" name="meta[_wpsc_compare_'.$field_data->field_key.'][]" value="'.$option_value.'" checked="checked" style="width:auto" />'.$option_value.' &nbsp;&nbsp;';
									}else{
										echo '<input type="checkbox" name="meta[_wpsc_compare_'.$field_data->field_key.'][]" value="'.$option_value.'" style="width:auto" />'.$option_value.' &nbsp;&nbsp;';
									}
								}
							}
							break;
							
						case "radio":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if($option_value == $field_value){
										echo '<input type="radio" name="meta[_wpsc_compare_'.$field_data->field_key.']" value="'.$option_value.'" checked="checked" style="width:auto" />'.$option_value.' &nbsp;&nbsp;';
									}else{
										echo '<input type="radio" name="meta[_wpsc_compare_'.$field_data->field_key.']" value="'.$option_value.'" style="width:auto" />'.$option_value.' &nbsp;&nbsp;';
									}
								}
							}
							break;
						
						case "drop-down":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							echo '<select name="meta[_wpsc_compare_'.$field_data->field_key.']" id="'.$field_data->field_key.'" style="width:400px">';
								echo '<option value="">'.__( "Select value", 'wpec_cp' ).'</option>';
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if($option_value == $field_value){
										echo '<option value="'.$option_value.'" selected="selected">'.$option_value.'</option>';
									}else{
										echo '<option value="'.$option_value.'">'.$option_value.'</option>';
									}
								}
							}
							echo '</select>';
							break;
						
						case "multi-select":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if(!is_array($field_value)) $field_value = array();
							echo '<select multiple="multiple" name="meta[_wpsc_compare_'.$field_data->field_key.'][]" id="'.$field_data->field_key.'" style="width:400px">';
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if(in_array($option_value, $field_value)){
										echo '<option value="'.$option_value.'" selected="selected">'.$option_value.'</option>';
									}else{
										echo '<option value="'.$option_value.'">'.$option_value.'</option>';
									}
								}
							}
							echo '</select>';
							break;
							
						default:
							echo '<input type="text" name="meta[_wpsc_compare_'.$field_data->field_key.']" id="'.$field_data->field_key.'" value="'.$field_value.'" />';
							break;
					}
				?>
                    </td>
                </tr>
        <?php		
			}
		}
		?>
        	</tbody>
        </table>
<?php
	}
	
	function save_compare_meta_boxes($post_id){
		$post_status = get_post_status($post_id);
		$post_type = get_post_type($post_id);
		if($post_type == 'wpsc-product' && $post_status != false){
			if(isset($_REQUEST['_wpsc_deactivate_compare_feature']) && $_REQUEST['_wpsc_deactivate_compare_feature'] == 'yes'){
				update_post_meta($post_id, '_wpsc_deactivate_compare_feature', 'yes');
			}else{
				update_post_meta($post_id, '_wpsc_deactivate_compare_feature', 'no');
			}
			$compare_fields = WPEC_Compare_Data::get_results('','field_order ASC');
			if(is_array($compare_fields) && count($compare_fields)>0){
				foreach($compare_fields as $field_data){
					update_post_meta($post_id, '_wpsc_compare_'.$field_data->field_key, $_REQUEST['_wpsc_compare_'.$field_data->field_key]);
				}
			}
		}
	}
}
?>
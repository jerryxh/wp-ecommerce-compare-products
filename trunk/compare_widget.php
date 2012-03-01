<?php
add_action( 'widgets_init', create_function('', 'return register_widget("WPEC_Compare_Widget");') );
class WPEC_Compare_Widget extends WP_Widget{

	function WPEC_Compare_Widget() {
		$widget_ops = array('classname' => 'wpec_compare_widget');
		$this->WP_Widget('wpec_compare_widget', 'WPEC Compare Products', $widget_ops);

	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$compare_list = WPEC_Compare_Functions::get_compare_list();
		$total_compare_product = 0;
		if(is_array($compare_list)) $total_compare_product = count($compare_list);
    	$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

		echo $before_widget;
		if ( $title != '')
			echo $before_title . $title . ' <span id="total_compare_product">('.$total_compare_product.')</span>' . $after_title;
		else
			echo $before_title . 'Compare Products <span id="total_compare_product">('.$total_compare_product.')</span>' . $after_title;
		
		
		echo '<div class="compare_widget_container">'.WPEC_Compare_Functions::get_compare_list_html_widget().'</div><div class="compare_widget_loader" style="display:none; text-align:center"><img src="'.ECCP_IMAGES_FOLDER.'/ajax-loader.gif" border=0 /></div>';
		
		echo $after_widget;
	
	}

	function update($new_instance, $old_instance) {
    	$instance = $old_instance;
    	$instance['title'] = strip_tags($new_instance['title']);
    	return $instance;

	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
	    $title = strip_tags($instance['title']);
	    ?>

        <p>
          	<label for="<?php echo $this->get_field_id('title'); ?>">Title :
            	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
          	</label>
        </p>
		<?php
	}
}
?>
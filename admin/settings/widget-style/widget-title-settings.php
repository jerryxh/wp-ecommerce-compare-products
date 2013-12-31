<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Compare Widget Title Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WPEC_Compare_Widget_Title_Settings extends WPEC_Compare_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'compare-widget';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wpec_compare_widget_title_style';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_compare_widget_title_style';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 2;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Widget Title Settings successfully saved.', 'wpec_cp' ),
				'error_message'		=> __( 'Error: Widget Title Settings can not save.', 'wpec_cp' ),
				'reset_message'		=> __( 'Widget Title Settings successfully reseted.', 'wpec_cp' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wpec_compare_admin_interface;
		
		$wpec_compare_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wpec_compare_admin_interface;
		
		$wpec_compare_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wpec_compare_admin_interface;
		
		$wpec_compare_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'widget-title',
			'label'				=> __( 'Widget Title', 'wpec_cp' ),
			'callback_function'	=> 'wpec_compare_widget_title_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wpec_compare_admin_interface;
		
		$output = '';
		$output .= $wpec_compare_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			array(
            	'name' 		=> __( 'Widget Title Setup ', 'wpec_cp' ),
				'desc'		=> __( "Custom settings below apply style to the 'Title' you add on the Compare Widget.", 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Widget Title Style', 'wpec_cp' ),
				'id' 		=> 'enable_widget_title_customized',
				'class' 	=> 'enable_widget_title_customized',
				'type' 		=> 'onoff_radio',
				'default'	=> 0,
				'onoff_options' => array(
					array(
						'val' 				=> 0,
						'text' 				=> __( 'Use Default Theme Style for Widget Title', 'wpec_cp' ) . ' <span class="description">('.__('default', 'wpec_cp').')</span>',
						'checked_label'		=> __( 'ON', 'wpec_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'wpec_cp') ,
					),
					array(
						'val' 				=> 1,
						'text' 				=> __( 'Customized Style for Widget Title', 'wpec_cp' ),
						'checked_label'		=> __( 'ON', 'wpec_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'wpec_cp') ,
					),
				),
			),
			
			array(
            	'name' 		=> __( 'Customized Style for Widget Title', 'wpec_cp' ),
                'type' 		=> 'heading',
          		'class'		=> 'enable_widget_title_customized_container'
           	),
			array(  
				'name' 		=> __( 'Widget Title Text Font', 'wpec_cp' ),
				'id' 		=> 'widget_title_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Widget Title Container Align', 'wpec_cp' ),
				'desc' 		=> __( "Default <code>Left</code>.", 'wpec_cp' ),
				'id' 		=> 'widget_title_align',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'left',
				'options'	=> array(
						'left'			=> __( 'Left', 'wpec_cp' ) ,	
						'center'		=> __( 'Center', 'wpec_cp' ) ,	
						'right'			=> __( 'Right', 'wpec_cp' ) ,
					),
			),
			array(  
				'name' 		=> __( 'Widget Title Container Wide', 'wpec_cp' ),
				'id' 		=> 'widget_title_wide',
				'class' 	=> 'widget_title_wide',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'auto',
				'checked_value'		=> 'auto',
				'unchecked_value'	=> 'full',
				'checked_label'		=> __( 'Auto', 'wpec_cp' ),
				'unchecked_label' 	=> __( 'Full', 'wpec_cp' ),
			),
			array(  
				'name' 		=> __( 'Widget Title Container Padding', 'wpec_cp' ),
				'id' 		=> 'widget_title_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'widget_title_padding_topbottom',
	 										'name' 		=> __( 'Top/Bottom', 'wpec_cp' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
	 
	 								array(  'id' 		=> 'widget_title_padding_leftright',
	 										'name' 		=> __( 'Left/Right', 'wpec_cp' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
	 							)
			),
			array(  
				'name' 		=> __( 'Widget Title Container Margin', 'wpec_cp' ),
				'id' 		=> 'widget_title_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'widget_title_margin_top',
	 										'name' 		=> __( 'Top', 'wpec_cp' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '0' ),
	 
	 								array(  'id' 		=> 'widget_title_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wpec_cp' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '10' ),
	 							)
			),
			array(  
				'name' 		=> __( 'Widget Title Container Background Colour', 'wpec_cp' ),
				'desc' 		=> __( 'Default', 'wpec_cp' ) . ' [default_value]',
				'id' 		=> 'widget_title_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' 		=> __( 'Widget Title Container Border', 'wpec_cp' ),
				'id' 		=> 'widget_title_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '0px', 'style' => 'solid', 'color' => '#476381', 'corner' => 'square' , 'top_left_corner' => 3 , 'top_right_corner' => 3 , 'bottom_left_corner' => 3 , 'bottom_right_corner' => 3 ),
			),
			
			array(
            	'name' 		=> __( 'Comparable Products Counter (0)', 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'To show before number', 'wpec_cp' ),
				'id' 		=> 'before_total_text',
				'style'		=> 'width:80px;',
				'type' 		=> 'text',
				'default'	=> '(',
			),
			array(  
				'name' 		=> __( 'To show after number', 'wpec_cp' ),
				'id' 		=> 'after_total_text',
				'style'		=> 'width:80px;',
				'type' 		=> 'text',
				'default'	=> ')',
			),
			
			array(
            	'name' 		=> __( 'Compare Count Number Styling', 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Count Number Font', 'wpec_cp' ),
				'id' 		=> 'total_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.enable_widget_title_customized:checked").val() == '1') {
		$(".enable_widget_title_customized_container").slideDown();
		//$(".enable_widget_title_customized_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".enable_widget_title_customized_container").slideUp();
		//$(".enable_widget_title_customized_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	$(document).on( "a3rev-ui-onoff_radio-switch", '.enable_widget_title_customized', function( event, value, status ) {
		//$(".enable_widget_title_customized_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( value == '1' && status == 'true' ) {
			$(".enable_widget_title_customized_container").slideDown();
		} else {
			$(".enable_widget_title_customized_container").slideUp();
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $wpec_compare_widget_title_settings;
$wpec_compare_widget_title_settings = new WPEC_Compare_Widget_Title_Settings();

/** 
 * wpec_compare_widget_title_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_compare_widget_title_settings_form() {
	global $wpec_compare_widget_title_settings;
	$wpec_compare_widget_title_settings->settings_form();
}

?>
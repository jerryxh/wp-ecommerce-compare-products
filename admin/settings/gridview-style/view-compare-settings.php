<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Grid View View Compare Button Settings

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

class WPEC_Compare_GridView_View_Compare_Button_Settings extends WPEC_Compare_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'product-cards';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wpec_compare_gridview_view_compare_style';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_compare_gridview_view_compare_style';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 3;
	
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
				'success_message'	=> __( 'View Compare Settings successfully saved.', 'wpec_cp' ),
				'error_message'		=> __( 'Error: View Compare Settings can not save.', 'wpec_cp' ),
				'reset_message'		=> __( 'View Compare Settings successfully reseted.', 'wpec_cp' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
		
		add_action( $this->plugin_name . '_settings_gridview_view_compare_activated_container_start_before', array( $this, 'gridview_view_compare_activated_container_start' ) );
		add_action( $this->plugin_name . '_settings_gridview_view_compare_activated_container_end_after', array( $this, 'gridview_view_compare_activated_container_end' ) );
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
			'name'				=> 'view-compare',
			'label'				=> __( 'View Compare', 'wpec_cp' ),
			'callback_function'	=> 'wpec_compare_gridview_view_compare_button_settings_form',
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
            	'name' 		=> __( "View Compare Link Feature", 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "View Compare on Product Cards", 'wpec_cp' ),
				'class'		=> 'disable_gridview_view_compare',
				'id' 		=> 'disable_gridview_view_compare',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'wpec_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'wpec_cp' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'gridview_view_compare_activated_container',
				'id'		=> 'gridview_view_compare_activated_container_start',
           	),
			
			array(
            	'name' 		=> __( 'View Compare Hyperlink Styling', 'wpec_cp' ),
                'type' 		=> 'heading',
          		'class'		=> 'gridview_view_compare_hyperlink_styling_container'
           	),
			array(  
				'name' 		=> __( 'Hyperlink Text', 'wpec_cp' ),
				'id' 		=> 'gridview_view_compare_link_text',
				'type' 		=> 'text',
				'default'	=> __('View Compare &rarr;', 'wpec_cp')
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'wpec_cp' ),
				'id' 		=> 'gridview_view_compare_link_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' )
			),
			
			array(  
				'name' 		=> __( 'Hyperlink Hover Colour', 'wpec_cp' ),
				'id' 		=> 'gridview_view_compare_link_font_hover_colour',
				'type' 		=> 'color',
				'default'	=> '#999999'
			),
			
			array(
                'type' 		=> 'heading',
				'id'		=> 'gridview_view_compare_activated_container_end',
           	),
			
        ));
	}
	
	public function gridview_view_compare_activated_container_start() {
		echo '<div class="gridview_view_compare_activated_container_start">';	
	}
	public function gridview_view_compare_activated_container_end() {
		echo '</div>';	
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.disable_gridview_view_compare:checked").val() == '0') {
		$(".gridview_view_compare_activated_container_start").slideDown();
		//$(".gridview_view_compare_activated_container_start").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".gridview_view_compare_activated_container_start").slideUp();
		//$(".gridview_view_compare_activated_container_start").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.disable_gridview_view_compare', function( event, value, status ) {
		//$(".gridview_view_compare_activated_container_start").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".gridview_view_compare_activated_container_start").slideDown();
		} else {
			$(".gridview_view_compare_activated_container_start").slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
}

global $wpec_compare_gridview_view_compare_button_settings;
$wpec_compare_gridview_view_compare_button_settings = new WPEC_Compare_GridView_View_Compare_Button_Settings();

/** 
 * wpec_compare_gridview_view_compare_button_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_compare_gridview_view_compare_button_settings_form() {
	global $wpec_compare_gridview_view_compare_button_settings;
	$wpec_compare_gridview_view_compare_button_settings->settings_form();
}

?>
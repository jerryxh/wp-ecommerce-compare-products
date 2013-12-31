<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Comparison Page Global Settings

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

class WPEC_Compare_Comparison_Page_Global_Settings extends WPEC_Compare_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'comparison-page';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wpec_compare_comparison_page_global_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_compare_comparison_page_global_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
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
				'success_message'	=> __( 'Comparison Page Settings successfully saved.', 'wpec_cp' ),
				'error_message'		=> __( 'Error: Comparison Page Settings can not save.', 'wpec_cp' ),
				'reset_message'		=> __( 'Comparison Page Settings successfully reseted.', 'wpec_cp' ),
			);
						
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
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
			'name'				=> 'general-settings',
			'label'				=> __( 'General Settings', 'wpec_cp' ),
			'callback_function'	=> 'wpec_compare_comparison_page_global_settings_form',
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
            	'name' 		=> __( "Comparison Page Header Image", 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Header Image', 'wpec_cp' ),
				'desc_tip'	=> __( 'Upload an image with formats .jpg, .pgn, .jpeg. Any size.', 'wpec_cp' ),
				'id' 		=> 'wpec_compare_logo',
				'type' 		=> 'upload',
				'separate_option'	=> true,
			),
			
			array(
            	'name' 		=> __( "Comparison Page Window", 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Open Compare Table in', 'wpec_cp' ),
				'id' 		=> 'open_compare_type',
				'type' 		=> 'onoff_radio',
				'default'	=> 'new_page',
				'onoff_options' => array(
					array(
						'val' 				=> 'window',
						'text' 				=> __( 'On Screen Window', 'wpec_cp' ),
						'checked_label'		=> __( 'ON', 'wpec_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'wpec_cp') ,
					),
					array(
						'val' 				=> 'new_page',
						'text' 				=> __( 'New Window', 'wpec_cp' ) . ' <span class="description">'.__("(Recommended - more mobile devise friendly, can't be blocked by pop-up blockers)", 'wpec_cp').'</span>',
						'checked_label'		=> __( 'ON', 'wpec_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'wpec_cp') ,
					),
				),
			),
			
			array(
            	'name' 		=> __( "Comparison Page Shortcode", 'wpec_cp' ),
				'desc'		=> __( "A 'Product Comparison' page with the shortcode [product_comparison_page] inserted should have been auto created on install. If not you need to manually create a new page and add the shortcode. Then set that page below so the plugin knows where to find it.", 'wpec_cp'),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Product Comparison Page', 'wpec_cp' ),
				'desc' 		=> __( 'Page contents', 'wpec_cp' ).': [product_comparison_page]',
				'id' 		=> 'product_compare_id',
				'type' 		=> 'single_select_page',
				'default'	=> '',
				'separate_option'	=> true,
				'placeholder'		=> __( 'Select Page', 'wpec_cp' ),
				'css'		=> 'width:300px;',
			),

        ));
	}

}

global $wpec_compare_comparison_page_global_settings_panel;
$wpec_compare_comparison_page_global_settings_panel = new WPEC_Compare_Comparison_Page_Global_Settings();

/** 
 * wpec_compare_comparison_page_global_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_compare_comparison_page_global_settings_form() {
	global $wpec_compare_comparison_page_global_settings_panel;
	$wpec_compare_comparison_page_global_settings_panel->settings_form();
}

?>
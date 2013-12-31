<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Compare Product Page Compare Tab Settings

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

class WPEC_Compare_Product_Page_Compare_Tab_Settings extends WPEC_Compare_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'product-page';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wpec_compare_product_page_tab';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_compare_product_page_tab';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 4;
	
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
				'success_message'	=> __( 'Product Page Compare Feature Fields Settings successfully saved.', 'wpec_cp' ),
				'error_message'		=> __( 'Error: Product Page Compare Feature Fields Settings can not save.', 'wpec_cp' ),
				'reset_message'		=> __( 'Product Page Compare Feature Fields Settings successfully reseted.', 'wpec_cp' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
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
			'name'				=> 'compare-feature-fields',
			'label'				=> __( 'Product Page Compare Feature Fields', 'wpec_cp' ),
			'callback_function'	=> 'wpec_compare_product_page_compare_tab_settings_form',
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
            	'name' 		=> __( "Product Page Compare Feature Fields", 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Compare Features Fields", 'wpec_cp' ),
				'class'		=> 'disable_compare_featured_tab',
				'id' 		=> 'disable_compare_featured_tab',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'wpec_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'wpec_cp' ),
			),
			
			array(
            	'name' 		=> __( "Compare Feature Fields Function", 'wpec_cp' ),
				'class'		=> 'produc_page_compare_tab_activate_container',
				'desc'		=> '<table class="form-table"><tbody><tr valign="top"><th scope="rpw" class="titledesc"><label for="">'.__( 'Show Compare Featured fields', 'wpec_cp' ).'</label></th><td class="forminp">'.__( 'To auto show and position the Product title and a list of the Compare features in your Themes single product pages use this function').' <br>'."<code>&lt;?php if(function_exists('wpec_show_compare_fields')) echo wpec_show_compare_fields(); ?&gt;</code></td></tr></tbody></table>",
                'type' 		=> 'heading',
           	),

        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
	
	$(document).ready(function() {
		
		if ( $("input.disable_compare_featured_tab:checked").val() == '0') {
			$(".produc_page_compare_tab_activate_container").slideDown();
			//$(".produc_page_compare_tab_activate_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		} else {
			$(".produc_page_compare_tab_activate_container").slideUp();
			//$(".produc_page_compare_tab_activate_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		}
		
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.disable_compare_featured_tab', function( event, value, status ) {
			//$(".produc_page_compare_tab_activate_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			if ( status == 'true' ) {
				$(".produc_page_compare_tab_activate_container").slideDown();
			} else {
				$(".produc_page_compare_tab_activate_container").slideUp();
			}
		});
		
	});
	
})(jQuery);
</script>
    <?php	
	}
	
}

global $wpec_compare_product_page_compare_tab_settings;
$wpec_compare_product_page_compare_tab_settings = new WPEC_Compare_Product_Page_Compare_Tab_Settings();

/** 
 * wpec_compare_product_page_compare_tab_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_compare_product_page_compare_tab_settings_form() {
	global $wpec_compare_product_page_compare_tab_settings;
	$wpec_compare_product_page_compare_tab_settings->settings_form();
}

?>
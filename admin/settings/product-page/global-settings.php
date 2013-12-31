<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Compare Product Page Global Settings

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

class WPEC_Compare_Product_Page_Global_Settings extends WPEC_Compare_Admin_UI
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
	public $option_name = 'wpec_compare_product_page_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_compare_product_page_settings';
	
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
				'success_message'	=> __( 'Product Page Settings successfully saved.', 'wpec_cp' ),
				'error_message'		=> __( 'Error: Product Page Settings can not save.', 'wpec_cp' ),
				'reset_message'		=> __( 'Product Page Settings successfully reseted.', 'wpec_cp' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'after_save_settings' ) );
		
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
	/* after_save_settings()
	/* Process when clean on deletion option is un selected */
	/*-----------------------------------------------------------------------------------*/
	public function after_save_settings() {
		if ( ( isset( $_POST['bt_save_settings'] ) || isset( $_POST['bt_reset_settings'] ) ) && get_option( 'wpec_compare_product_lite_clean_on_deletion' ) == 0  )  {
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[ECCP_NAME]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
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
			'name'				=> 'product-page-settings',
			'label'				=> __( 'Product Page Settings', 'wpec_cp' ),
			'callback_function'	=> 'wpec_compare_product_page_global_settings_form',
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
            	'name' 		=> __( "Show Compare On Product Pages", 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Compare Button / Text", 'wpec_cp' ),
				'class'		=> 'disable_product_page_compare',
				'id' 		=> 'disable_product_page_compare',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'wpec_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'wpec_cp' ),
			),
			
			array(
            	'name' 		=> __( "Product Page Compare Button/Link Position", 'wpec_cp' ),
				'class'		=> 'produc_page_activate_container',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Button/Link Position relative to Add to Cart Button', 'wpec_cp' ),
				'desc'		=> __( 'Position relative to Add to Cart button location', 'wpec_cp' ),
				'id' 		=> 'product_page_button_position',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'above',
				'checked_value'		=> 'above',
				'unchecked_value'	=> 'below',
				'checked_label' 	=> __( 'Above', 'wpec_cp' ),
				'unchecked_label'	=> __( 'Below', 'wpec_cp' ),
			),
			array(  
				'name' 		=> __( 'Button Margin', 'wpec_cp' ),
				'id' 		=> 'product_page_button_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'product_page_button_margin_top',
	 										'name' 		=> __( 'Top', 'wpec_cp' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
	 
	 								array(  'id' 		=> 'product_page_button_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wpec_cp' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
											
									array( 
											'id' 		=> 'product_page_button_margin_left',
	 										'name' 		=> __( 'Left', 'wpec_cp' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'product_page_button_margin_right',
	 										'name' 		=> __( 'Right', 'wpec_cp' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),
			array(  
				'name' 		=> __( "Manually set Compare button position", 'wpec_cp' ),
				'desc'		=> __( "ON to deactivate default button position settings created by the plugin.", 'wpec_cp' ).'<br />'.__('Then use this function to manually postion the Compare button on product pages', 'wpec_cp')."<br /><code>&lt;?php if ( function_exists('wpec_add_compare_button' ) ) echo wpec_add_compare_button(); ?&gt;</code>",
				'id' 		=> 'auto_add',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'no',
				'unchecked_value' 	=> 'yes',
				'checked_label'		=> __( 'ON', 'wpec_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'wpec_cp' ),
			),
			
			array(
            	'name' 		=> __( 'House Keeping :', 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Clean up on Deletion', 'wpec_cp' ),
				'desc' 		=> __( "On deletion (not deactivate) the plugin will completely remove all tables and data it created, leaving no trace it was ever here.", 'wpec_cp' ),
				'id' 		=> 'wpec_compare_product_lite_clean_on_deletion',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'separate_option'	=> true,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wpec_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'wpec_cp' ),
			),

        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
	
	$(document).ready(function() {
		
		if ( $("input.disable_product_page_compare:checked").val() == '0') {
			$(".produc_page_activate_container").slideDown();
		} else {
			$(".produc_page_activate_container").slideUp();
		}
		
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.disable_product_page_compare', function( event, value, status ) {
			if ( status == 'true' ) {
				$(".produc_page_activate_container").slideDown();
			} else {
				$(".produc_page_activate_container").slideUp();
			}
		});
		
	});
	
})(jQuery);
</script>
    <?php	
	}
	
}

global $wpec_compare_product_page_global_settings;
$wpec_compare_product_page_global_settings = new WPEC_Compare_Product_Page_Global_Settings();

/** 
 * wpec_compare_product_page_global_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_compare_product_page_global_settings_form() {
	global $wpec_compare_product_page_global_settings;
	$wpec_compare_product_page_global_settings->settings_form();
}

?>
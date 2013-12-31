<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Comparison Page Add To Cart Button Settings

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

class WPEC_Compare_Comparison_Page_AddToCart_Button_Settings extends WPEC_Compare_Admin_UI
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
	public $option_name = 'wpec_compare_addtocart_style';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_compare_addtocart_style';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 6;
	
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
				'success_message'	=> __( 'Add to Cart Settings successfully saved.', 'wpec_cp' ),
				'error_message'		=> __( 'Error: Add to Cart Settings can not save.', 'wpec_cp' ),
				'reset_message'		=> __( 'Add to Cart Settings successfully reseted.', 'wpec_cp' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
		
		add_action( $this->plugin_name . '_settings_comparison_page_addtocart_activated_container_start_before', array( $this, 'comparison_page_addtocart_activated_container_start' ) );
		add_action( $this->plugin_name . '_settings_comparison_page_addtocart_activated_container_end_after', array( $this, 'comparison_page_addtocart_activated_container_end' ) );
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
			'name'				=> 'add-to-cart',
			'label'				=> __( 'Add to Cart', 'wpec_cp' ),
			'callback_function'	=> 'wpec_compare_comparison_page_addtocart_button_settings_form',
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
            	'name' 		=> __( "Add to Cart Feature", 'wpec_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Add To Cart Link", 'wpec_cp' ),
				'class'		=> 'disable_product_addcart',
				'id' 		=> 'disable_product_addcart',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'wpec_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'wpec_cp' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'comparison_page_addtocart_activated_container',
				'id'		=> 'comparison_page_addtocart_activated_container_start',
           	),
			
			array(
            	'name' => __( 'Add To Cart Button / Hyperlink', 'wpec_cp' ),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Button or Hyperlink Type', 'wpec_cp' ),
				'id' 		=> 'addtocart_button_type',
				'class' 	=> 'addtocart_button_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'button',
				'checked_value'		=> 'button',
				'unchecked_value'	=> 'link',
				'checked_label'		=> __( 'Button', 'wpec_cp' ),
				'unchecked_label' 	=> __( 'Hyperlink', 'wpec_cp' ),
			),
			array(  
				'name' 		=> __( 'Added To Cart Success Icon', 'wpec_cp' ),
				'desc_tip'	=> __( 'Upload a 16px x 16px image, support .jpg, .pgn, .jpeg, .gif formats.', 'wpec_cp' ),
				'id' 		=> 'wpec_compare_addtocart_success',
				'type' 		=> 'upload',
				'separate_option'	=> true,
				'default'	=> ECCP_IMAGES_URL.'/addtocart_success.png',
			),
			
			array(
            	'name' 		=> __( 'Add To Cart Hyperlink Styling', 'wpec_cp' ),
                'type' 		=> 'heading',
          		'class'		=> 'comparison_page_addtocart_hyperlink_styling_container'
           	),
			array(  
				'name' 		=> __( 'Hyperlink Text', 'wpec_cp' ),
				'id' 		=> 'addtocart_link_text',
				'type' 		=> 'text',
				'default'	=> __('Add to cart', 'wpec_cp')
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'wpec_cp' ),
				'id' 		=> 'addtocart_link_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#21759B' )
			),
			array(  
				'name' 		=> __( 'Hyperlink Hover Colour', 'wpec_cp' ),
				'id' 		=> 'addtocart_link_font_hover_colour',
				'type' 		=> 'color',
				'default'	=> '#D54E21'
			),
			
			array(
            	'name' 		=> __( 'Add To Cart Button Styling', 'wpec_cp' ),
                'type' 		=> 'heading',
          		'class' 	=> 'comparison_page_addtocart_button_styling_container'
           	),
			array(  
				'name' 		=> __( 'Button Text', 'wpec_cp' ),
				'id' 		=> 'addtocart_button_text',
				'type' 		=> 'text',
				'default'	=> __('Add to cart', 'wpec_cp')
			),
			array(  
				'name' 		=> __( 'Button Padding', 'wpec_cp' ),
				'desc' 		=> __( 'Padding from Button text to Button border', 'wpec_cp' ),
				'id' 		=> 'addtocart_button_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'addtocart_button_padding_tb',
	 										'name' 		=> __( 'Top/Bottom', 'wpec_cp' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '7' ),
	 
	 								array(  'id' 		=> 'addtocart_button_padding_lr',
	 										'name' 		=> __( 'Left/Right', 'wpec_cp' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '8' ),
	 							)
			),
			array(  
				'name' 		=> __( 'Background Colour', 'wpec_cp' ),
				'desc' 		=> __( 'Default', 'wpec_cp' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#476381'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'wpec_cp' ),
				'desc' 		=> __( 'Default', 'wpec_cp' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#538bbc'
			),
			
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'wpec_cp' ),
				'desc' 		=> __( 'Default', 'wpec_cp' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#476381'
			),
			array(  
				'name' 		=> __( 'Button Border', 'wpec_cp' ),
				'id' 		=> 'addtocart_button_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#476381', 'corner' => 'rounded' , 'top_left_corner' => 3 , 'top_right_corner' => 3 , 'bottom_left_corner' => 3 , 'bottom_right_corner' => 3 ),
			),
			array(  
				'name' 		=> __( 'Button Font', 'wpec_cp' ),
				'id' 		=> 'addtocart_button_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#FFFFFF' )
			),
			array(  
				'name' => __( 'Button Shadow', 'wpec_cp' ),
				'id' 		=> 'addtocart_button_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' )
			),
			
			array(
                'type' 		=> 'heading',
				'id'		=> 'comparison_page_addtocart_activated_container_end',
           	),
			
        ));
	}
	
	public function comparison_page_addtocart_activated_container_start() {
		echo '<div class="comparison_page_addtocart_activated_container_start">';	
	}
	public function comparison_page_addtocart_activated_container_end() {
		echo '</div>';	
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.disable_product_addcart:checked").val() == '0') {
		$(".comparison_page_addtocart_activated_container_start").slideDown();
		//$(".comparison_page_addtocart_activated_container_start").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".comparison_page_addtocart_activated_container_start").slideUp();
		//$(".comparison_page_addtocart_activated_container_start").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
		
	if ( $("input.addtocart_button_type:checked").val() == 'button') {
		$(".comparison_page_addtocart_button_styling_container").slideDown();
		$(".comparison_page_addtocart_hyperlink_styling_container").slideUp();
		//$(".comparison_page_addtocart_button_styling_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		//$(".comparison_page_addtocart_hyperlink_styling_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	} else {
		$(".comparison_page_addtocart_button_styling_container").slideUp();
		$(".comparison_page_addtocart_hyperlink_styling_container").slideDown();
		//$(".comparison_page_addtocart_button_styling_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		//$(".comparison_page_addtocart_hyperlink_styling_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.disable_product_addcart', function( event, value, status ) {
		//$(".comparison_page_addtocart_activated_container_start").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".comparison_page_addtocart_activated_container_start").slideDown();
		} else {
			$(".comparison_page_addtocart_activated_container_start").slideUp();
		}
	});
		
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.addtocart_button_type', function( event, value, status ) {
		//$(".comparison_page_addtocart_button_styling_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		//$(".comparison_page_addtocart_hyperlink_styling_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true') {
			$(".comparison_page_addtocart_button_styling_container").slideDown();
			$(".comparison_page_addtocart_hyperlink_styling_container").slideUp();
		} else {
			$(".comparison_page_addtocart_button_styling_container").slideUp();
			$(".comparison_page_addtocart_hyperlink_styling_container").slideDown();
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $wpec_compare_comparison_page_addtocart_button_settings;
$wpec_compare_comparison_page_addtocart_button_settings = new WPEC_Compare_Comparison_Page_AddToCart_Button_Settings();

/** 
 * wpec_compare_comparison_page_addtocart_button_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_compare_comparison_page_addtocart_button_settings_form() {
	global $wpec_compare_comparison_page_addtocart_button_settings;
	$wpec_compare_comparison_page_addtocart_button_settings->settings_form();
}

?>
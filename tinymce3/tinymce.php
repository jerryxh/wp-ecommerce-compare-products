<?php

/**
 * @title TinyMCE V3 Button Integration (for Wp2.5)
 */

function wpeccp_addbuttons() {
	 
	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
	 
	// add the button for wp25 in a new way
		add_filter("mce_external_plugins", "wpeccp_add_tinymce_plugin", 5);
	}
}

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function wpeccp_add_tinymce_plugin($plugin_array) {

	$plugin_array['productcomparison_image'] = ECCP_URL . '/tinymce3/editor_plugin.js';
	
	return $plugin_array;
}


// init process for button control
add_action('init', 'wpeccp_addbuttons');
?>
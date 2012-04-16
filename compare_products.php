<?php
/*
Plugin Name: WP e-Commerce Compare Products
Plugin URI: http://www.a3rev.com/
Description: WP e-Commerce Compare Products plugin.
Version: 1.0.5
Author: A3 Revolution Software Development team
Author URI: http://www.a3rev.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, <http://www.gnu.org/licenses/>.
*/

/*
	WP e-Commerce Compare Products. Plugin for the WP e-Commerce shopping Cart.
	Copyright © 2011 A3 Revolution Software Development team
	
	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/

/*
== Changelog ==

= 1.0.5 - 2012/04/13 =
* Feature: Combined 2 admin pages into one with SETTINGS  |  FEATURES tabs
* Feature: Added comprehensive admin page setup instructions via Tool Tips and text instructions.
* Greatly improved Admin pages layout for enhanced user experience.
* Feature: Add pop up window when deleting feature fields to ask you to check if you are sure?
* Fix : Auto add Compare Widget to sidebar when plugin is activated.
* Fix: Feature Unit of Measurement is added in brackets after Feature Name and if nothing added it does not show.
* Fix: Replace deprecated widget attribute_escape with esc_attr().
* Tweak: Changed Pop-Out window function from - include( '../../../wp-config.php') to show content using wp_ajax
* Tweak: Run WP_DEBUG check and fixed plugins 'undefined...' errors
* Tweak: Removed fading update messages and animation and replaced with default wordpress 'updated' messages.
* Tweak: Replace custom ajax handlers with wp_ajax and wp_ajax_nopriv
* Tweak: Code re-organized into folders with all files commented on and appropriate names as per WordPress Coding standards. 

= 1.0.4 - 2012/04/02 =
* Tweak the code

= 1.0.3 - 2012/03/20 =
* Fix show Compare button for older and latest versions of WP e-commerce

= 1.0.2 - 2012/03/19 =
* Fix Auto Add Compare button feature.

= 1.0.1 - 2012/02/28 =
* Update Compare Feature for Product Variations

= 1.0.0 =
* First working release of the modification

*/
?>
<?php
define('ECCP_FILE_PATH', dirname(__FILE__));
define('ECCP_DIR_NAME', basename(ECCP_FILE_PATH));
define('ECCP_FOLDER', dirname(plugin_basename(__FILE__)));
define('ECCP_URL', WP_CONTENT_URL.'/plugins/'.ECCP_FOLDER);
define( 'ECCP_JS_URL',  ECCP_URL . '/assets/js' );
define( 'ECCP_IMAGES_URL',  ECCP_URL . '/assets/images' );
if(!defined("ECCP_MANAGER_URL"))
    define("ECCP_MANAGER_URL", "http://a3dev.net/api/plugins");

update_option('a3rev_wpeccp_version', '1.0.5');
include('includes/class-compare_functions.php');

include('admin/classes/class-compare_class.php');
include('classes/class-compare_filter.php');
include('classes/class-compare_metabox.php');

include('classes/data/class-compare_data.php');

include('widget/class-compare_widget.php');

include('admin/compare_init.php');

function wpec_add_compare_button($product_id='', $echo=false){
	$html = WPEC_Compare_Hook_Filter::add_compare_button($product_id);	
	if($echo) echo $html;
	else return $html;
}

function wpec_show_compare_fields($product_id='', $echo=false){
	$html = WPEC_Compare_Hook_Filter::show_compare_fields($product_id);
	if($echo) echo $html;
	else return $html;
}

register_activation_hook(__FILE__,'wpec_compare_set_settings');
?>

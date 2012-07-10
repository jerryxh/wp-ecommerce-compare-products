<?php
/*
Plugin Name: WP e-Commerce Compare Products
Plugin URI: http://www.a3rev.com/
Description: WP e-Commerce Compare Products plugin.
Version: 2.0
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

= 2.0 - 2012/07/04 =

* Feature - All Product Categories auto created as Compare Categories when plugin is activated. 
* Feature - All Product Variations auto added as 'Un-assigned' Compare Features when the plugin is first activated.
* Feature ñ When Product Categories or Sub categories are created they are auto created as Compare categories. The plugin only listens to Create new so edits to Product categories are ignored.
* Feature: When parent product variations are created they are auto created as unassigned Compare Features. Child product variations and edits are ignored. 
* Feature - Complete rework of admin user interface - Combined Features and Categories tabs into a single tab - Added Products Tab. Greatly enhanced user experience and ease of use.
* Feature - Moved Create New Categories and Features to a single on page assessable from an 'add new' button on Features tab.
* Feature - Added Features search facility for ease of finding and editing Compare Features.
* Feature - Support for use of Cyrillic Symbols when creating Compare categories and Features.
* Feature - Support for use of <sup> tags.
* Feature ñ Language file added to support localization ñ looking for people to do translations.
* Fixed - WP e-Commerce version updates editing Product Page Compare meta field values which caused Compare feature when activated from product page not updating Compare category name and show as activated on the Compare Products Admin Page.
* Fixed - Can't create Compare Feature if user does not have a default value set in SQL. Changed INSERT INTO SQL command output to cater for this relatively rare occurrence.
* Tweak - Replaced all Category Edit | Delete icons with WordPress link text. Replace edit icon on Product Update table with text link.
* Tweak - Edited Product update table to fit 100% wide on page so that the horizontal scroll bar does not auto show.
* Tweak - Removed verbose text explanations and superfluous tool tips.
* Tweak - Edited the way that Add Compare Features shows on product edit page - now same width as the page content.
* Tweak - Show Compare Featured fields on products page - added table css styling.
* Tweak - Adding padding between Product name and the Clear All - Compare button in sidebar widget. 
* Other ñ Set up a Github repository for the plugins files.
* License updated to GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007

= 1.0.5 - 2012/06/12 =
* Fix: Show Compare Button when Activate the 'Hide Add to cart Button' in the Presentation panel of WPEC

= 1.0.4 - 2012/04/11 =

* Feature: Added Compare Products Manager - Manage / Update Compare Features on all products from a single admin page.
* Feature: Combined 3 admin pages into one with SETTINGS  |  CATEGORIES  |  FEATURES tabs
* Feature: Added comprehensive admin page setup instructions via Tool Tips and text instructions.
* Greatly improved Admin pages layout for enhanced user experience.
* Feature: Add pop up window when deleting feature fields to ask you to check if you are sure?
* Fix: Compare Products Page Table loading speed. All products now load directly from database which greatly reduced the time the feature takes to load the first time. Set to default don't show variations to enhance initial load times.
* Fix: After editing and updating a Product Variation Features Product Page reloads with all Variations Products showing rather than on the default - not showing.
* Fix: Edit Code so when the page re-loads that it get current page number, number of items to show, search keyword
* Fix: After upgrading from the FREE version to PRO, Compare Products Features show as activated for all products on Compare Products manage table - edited to show all deactivated which they are until assigned to a Compare category.
* Fix : Auto add Compare Widget to sidebar when plugin is activated.
* Fix: Feature Unit of Measurement is added in brackets after Feature Name and if nothing added it does not show.
* Fix: Replace deprecated widget attribute_escape with esc_attr().
* Tweak: Changed Pop-Out window function from - include( '../../../wp-config.php') to show content using wp_ajax
* Tweak: Run WP_DEBUG check and fixed plugins 'undefined...' errors
* Tweak: Removed fading update messages and animation and replaced with default wordpress 'updated' messages.
* Tweak: Replace custom ajax handlers with wp_ajax and wp_ajax_nopriv
* Tweak: Code re-organized into folders with all files commented on and appropriate names as per WordPress Coding standards.


= 1.0.3 - 2012/03/20 =
* Fix show Compare button for older and latest versions of WP e-commerce
* Update the message on Comparable Settings page
* Put Compare button under Add To Cart button and make 10px padding

= 1.0.2 - 2012/03/01 =
* Make Compare Category for each Product (Variations)

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
if(!defined("A3REV_AUTHOR_URI"))
    define("A3REV_AUTHOR_URI", "http://a3rev.com/products-page/wp-e-commerce-plugins/wpec-compare-products/");

include('includes/class-compare_functions.php');

include('classes/data/class-fields_data.php');
include('classes/data/class-categories_data.php');
include('classes/data/class-categories_fields_data.php');

include('classes/class-compare_filter.php');
include('classes/class-compare_metabox.php');

include('widget/class-compare_widget.php');

include('admin/classes/class-compare_settings.php');
include('admin/classes/class-compare_categories.php');
include('admin/classes/class-compare_fields.php');
include('admin/classes/class-compare_products.php');

include('classes/class-compare_upgrade.php');

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

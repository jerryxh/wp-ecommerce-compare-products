<?php
/*
Plugin Name: WP e-Commerce Compare Products Lite
Plugin URI: http://a3rev.com/shop/wpec-compare-products
Description: Compare Products uses your existing WP e-Commerce Product Categories and Product Variations to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen.
Version: 2.0.5
Author: A3 Revolution
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
?>
<?php
define('ECCP_FILE_PATH', dirname(__FILE__));
define('ECCP_DIR_NAME', basename(ECCP_FILE_PATH));
define('ECCP_FOLDER', dirname(plugin_basename(__FILE__)));
define('ECCP_NAME', plugin_basename(__FILE__));
define('ECCP_URL', WP_CONTENT_URL.'/plugins/'.ECCP_FOLDER);
define( 'ECCP_JS_URL',  ECCP_URL . '/assets/js' );
define( 'ECCP_IMAGES_URL',  ECCP_URL . '/assets/images' );
if(!defined("A3REV_AUTHOR_URI"))
    define("A3REV_AUTHOR_URI", "http://a3rev.com/shop/wpec-compare-products/");

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
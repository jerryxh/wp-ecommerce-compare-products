<?php
/*
Plugin Name: WPEC Compare Products
Plugin URI: http://www.a3rev.com/
Description: WPEC Compare Products plugin.
Version: 1.0.2
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
	WPEC Compare Products. Plugin for the WP e-Commerce shopping Cart.
	Copyright © 2011 A3 Revolution Software Development team
	
	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/

/*
== Changelog ==

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
define( 'ECCP_CORE_IMAGES_URL',  ECCP_URL . '/images' );
define( 'ECCP_IMAGES_FOLDER',  ECCP_URL . '/images' );
if(!defined("ECCP_MANAGER_URL"))
    define("ECCP_MANAGER_URL", "http://a3dev.net/api/plugins");

update_option('a3rev_wpeccp_version', '1.0.2');
include('compare_class.php');
include('compare_filter.php');
include('compare_data.php');
include('compare_functions.php');
include('compare_metabox.php');
include('compare_widget.php');
include('compare_admin.php');

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

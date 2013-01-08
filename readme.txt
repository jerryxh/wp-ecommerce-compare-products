=== WP e-Commerce Compare Products ===
Contributors: a3rev, A3 Revolution Software Development team

Tags: WP eCommerce, WP e-Commerce, compare product, wpec compare product, compare products, wp ecommerce compare products, e-commerce, ecommerce

Requires at least: 2.92
Tested up to: 3.5
Stable tag: 2.0.5

The Only Compare Products Plugin for WP e-Commerce. Add the compare products feature to your WP e-Commerce store today with WP e-Commerce Compare Products. 

== Description ==

Compare Products uses your existing WP e-Commerce Product Categories and Product Variations to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen. Products in the pop-up screen can be added to the shopping cart (if the product has that capability) and there is a hard copy print results capability.
 
= Key Features =
* Professional front end compare products presentation, buttons, links, sidebar widget and Compare pop-up window.
* Works with any Theme that has the WP e-Commerce plugin installed and activated.
* All existing Product Categories and Variations are auto created as Compare Categories and Comparable Features.
* Compare features are auto added to the Compare Master Category.
* Extremely Flexible. Add an additional unlimited number of custom Compare categories and features.

<strong>Online shoppers love a quality compare products feature</strong>. Giving customers more of what they love leads to <strong>more sales.</strong> Boost your sales today by installing WP e-Commerce Compare Products on your WP e-Commerce store.

= Comprehensive Documentation =

Complete and comprehensive plugin documentation [available here](http://docs.a3rev.com/user-guides/wp-e-commerce/wpec-compare-products/)

= Premium Upgrade =

When you install WP e-Commerce Compare Products you will see all the added functionality that the Premium Version offers. The plugin is designed so that the upgrade is completely seamless. Nothing changes or is lost when you upgrade. Upon upgrading all the PRO features of Compare Products you see on the Lite version dashboard are activated. This means you can activate, set up and use the free version completely risk free.

[Home Page](http://a3rev.com/shop/wpec-compare-products/) |
[Documentation](http://docs.a3rev.com/user-guides/wp-e-commerce/wpec-compare-products/) |
[Support](http://a3rev.com/shop/wpec-compare-products/#tab-reviews)

= Localization =
* English (default) - always include.
* Bulgarian translation now included thanks to Keremidi
* .pot file (wpec_cp.pot) in languages folder for translations.
* Your translation? Please [send it to us](http://www.a3rev.com/contact/) We'll acknowledge your work and link to your site.
Please [Contact us](http://www.a3rev.com/contact/) if you'd like to provide a translation or an update.


== Screenshots ==


1. screenshot-1.jpg

2. screenshot-2.jpg

3. screenshot-3.jpg

 
 == Installation ==


To install WP e-Commerce  Compare Products:
1. Download the WP e-Commerce Compare Products plugin  
2. Upload the wp-ecommerce-compare-products folder to your /wp-content/plugins/ directory
3. Activate the ‘WP e-Commerce Compare Products from the Plugins menu within WordPress



== Usage ==


1. Open Products > Compare Products

2. Settings Tab - follow the extensive onscreen help notes to style your Compare feature.

3. Features Tab - add your products Compare Features. 

4. Go to any products edit screen and add data to your Compare Feature Fields.

5. Make more sales! 

== Frequently Asked Questions ==

When can I use this plugin?  

You can use this plugin when you have installed the WP e-Commerce plugin

 
== Support ==


If you have any problems, questions or suggestions please post your request to the [HELP tab](http://a3rev.com/shop/wpec-compare-products/#tab-reviews) on the Pro Versions Home page.



== Changelog ==

= 2.0.5 - 2013/01/08 = 

* Feature: Added support for Chinese Characters* Tweak: UI tweak - changed the order of the admin panel tabs so that the most used Features tab is moved to first tab.
* Tweak: Added links to all other a3rev wordpress.org plugins from the Features tab* Tweak: Updated Support and Pro Version link URL's on wordpress.org description, plugins and plugins dashboard. Links were returning 404 errors since the launch of the all new a3rev.com mobile responsive site as the base e-commerce permalinks is changed.


= 2.0.4 - 2012/12/14 =

* Fixed: Updated depreciated custom database collator $wpdb->supports_collation() with new WP3.5 function $wpdb->has_cap( 'collation' ). ÊSupports backward version compatibility.
* Fixed: When Product attributes are auto created as Compare Features, if the Attribute has no terms then the value input field is created as Input Text - Single line instead of a Checkbox.
* Fixed: On Compare Products admin tab, ajax not able to load the products list again after saving a product edit

= 2.0.3 - 2012/08/15 =

* Changed - Variations where auto created as Compare Feature input type 'dropdown' (single select). Changed to input type 'check box' (multi-select)
* Documentation - Added comprehensive extension documentation to the a3rev wiki.
* Localization - Added Bulgarian translation (thanks to Keremidi)
* Tweak - Jumped Lite version from v2.0.0 to v2.0.3 to bring Lite and Pro versions back into sync.
* Tweak - Updated plugin description and added link to Documentation.
* Tweak - Set database table name to be created the same as WordPress table type
* Tweak - Change localization file path from actual to base path


= 2.0 - 2012/07/09 =

MAJOR UPGRADE

* Feature - All Product Categories auto created as Compare Categories when plugin is activated. Feature is activated on upgrade.
* Feature - All Product Variations auto added to Master Category as Compare Features when the plugin is first activated.
* Feature – When Product Categories or Sub categories are created they are auto created as Compare categories. The plugin only listens to Create new so edits to Product categories are ignored.
* Feature: When parent product variations are created they are auto created as Compare Features. Child product variations and edits are ignored. 
* Feature - Complete rework of admin user interface - Combined Features and Categories tabs into a single tab - Added Products Tab. Greatly enhanced user experience and ease of use.
* Feature - Moved Create New Categories and Features to a single on page assessable from an 'add new' button on Features tab.
* Feature - Added Features search facility for ease of finding and editing Compare Features.
* Feature - Added support for use of special characters in Feature Fields.
* Feature - Added support for use of Cyrillic Symbols in Feature Fields.
* Feature - Added support for use of sup tags in Feature Fields.
* Feature – Language file added to support localization – looking for people to do translations.
* Fixed - WP e-Commerce version updates editing Product Page Compare meta field values which caused Compare feature when activated from product page not updating Compare category name and show as activated on the Compare Products Admin Page.
* Fixed - Can't create Compare Feature if user does not have a default value set in SQL. Changed INSERT INTO SQL command output to cater for this relatively rare occurrence.
* Tweak - Replaced all Category Edit | Delete icons with WordPress link text. Replace edit icon on Product Update table with text link.
* Tweak - Edited Product update table to fit 100% wide on page so that the horizontal scroll bar does not auto show.
* Tweak - Removed verbose text explanations and superfluous tool tips.
* Tweak - Edited the way that Add Compare Features shows on product edit page - now same width as the page content.
* Tweak - Show Compare Featured fields on products page - added table css styling.
* Tweak - Adding padding between Product name and the Clear All - Compare button in sidebar widget.
* Other - Create script to facilitate seamless upgrade from Version 1.04 to Major upgrade Version 2.0  


= 1.0.5 - 2012/04/16 =
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

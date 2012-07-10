=== WP e-Commerce Compare Products ===


Contributors: A3 Revolution Software Development team

Tags: WP eCommerce, WP e-Commerce, compare product, wpec compare product, compare products, wp ecommerce compare products, e-commerce, ecommerce


Requires at least: 2.92
Tested up to: 3.4.1
Stable tag: 2.0

The Only Compare Products Plugin for WP e-Commerce. Add the compare products feature to your WP e-Commerce store toady with WP e-Commerce Compare Products. 

== Description ==

WP e-Commerce Compare products instantly adds the <strong>cutting edge Compare products feature</strong> to you store in just minutes. 
 
= Key Features =

* Professional front end compare products presentation, buttons, links, sidebar widget and compare pop-up
* Works with any Theme that has WP e-Commerce installed.
* Takes just minutes to set up on your site.
* Product variants auto created as Compare feature - add unlimited custom features to compare.

Research has proven <strong>Online shoppers love the compare products feature</strong> and giving customers more of what they love leads to <strong>more sales.</strong>. Boost your sales today by installing WP e-Commerce Compare Products on your WP e-Commerce store.

= Premium Upgrade =

When you install WP e-Commerce Compare Products you will see all the added functionality that the Premium Version offers. The plugin is designed so that the upgrade is completely seamless. Nothing changes except all the features of Compare Products are activated. This means you can activate, set up and use the free version completely risk free.  

PRO Version upgrade features:

* Compare Categories - is activated - Categories are important to delivering you customers easy to read compare features in the pop-up window.
* Create unlimited number of custom Compare Categories. 
* Compare Express Products Manager  - is activate - makes setting up and managing the Compare feature across you entire catalogue at least 50 times faster. 
 
TRY WP e-Commerce Compare Products FREE version today. <strong>Your customers will love you for it.</strong>

= Localization =
* English (default) - always include.
* .pot file (wpec_cp.pot) in languages folder for translations.
* Your translation? Please [send it to us](http://www.a3rev.com/contact/) We'll acknowledge your work and link to your site.
Please [Contact us](http://www.a3rev.com/contact/) if you'd like to provide a translation or an update.

[Home Page](http://www.a3rev.com/products-page/wp-e-commerce/wpec-compare-products/) |
[Documentation](http://www.a3rev.com/products-page/wp-e-commerce/wpec-compare-products/) |
[Support](http://www.a3rev.com/products-page/wp-e-commerce/wpec-compare-products/)



== Screenshots ==


1. screenshot-1.jpg

2. screenshot-2.jpg

3. screenshot-3.jpg

 
 == Installation ==


1. Upload the folder wpec-compare-products to the /wp-content/plugins/ directory

2. Activate the plugin through the Plugins menu in WordPress



== Usage ==


1. Open Products > Compare Products

2. Settings Tab - follow the extensive onscreen help notes to style your Compare feature.

3. Features Tab - add your products Compare Features. 

4. Go to any products edit screen and add data to your Compare Feature Fields.

5. Make more sales! 

==Frequently Asked Questions ==

= 
When can I use this plugin? =

You can use this plugin when you have installed the WP e-Commerce plugin

= 
How do I show the Compare button on product page and detail product page? =

You can go to Products -> Compare Settings, checked on Auto Add Compare button, it will automatically add the Compare button on your theme. If you want to show the Compare button anywhere you want, you unchecked Auto Add Compare button, then copy this code `<? if(function_exists('wpec_add_compare_button')) echo wpec_add_compare_button(); ?>` and past into the theme code where you want to show Compare button.

= 

How do I change the Color of the Compare Buttons to match my theme? = 

It is an easy task to change the color of the button - but you will need some coding knowledge.

All objects in the plugin have a class so you can style for them. Using an ftp client open the style.css in your theme.

Look for the style of your themes buttons below is an example - it will look something like this
wrap input[type="submit"], #wrap input[type="button"] {

background: url('images/bg-button.png') no-repeat scroll right top transparent; border: 1px solid #153B94; border-radius: 5px 5px 5px 5px; box-shadow: 1px 1px 2px #333333; color: #FFFFFF; cursor: pointer; font-size: 12px; padding: 9px 27px 7px 10px; }

Once you have found that in themes style.css directory then add that style into your themes style.css under the class name 'bt_compare_this' which is for the Compare button on the product pages and class name 'compare_button_go' for the Compare button in the sidebar widget. This is how it would look using the example above as the style for the button.

input.bt_compare_this { background: url('images/bg-button.png') no-repeat scroll right top transparent; border: 1px solid #153B94; border-radius: 5px 5px 5px 5px; box-shadow: 1px 1px 2px #333333; color: #FFFFFF; cursor: pointer; font-size: 12px; padding: 9px 27px 7px 10px; }

This will then mean that style will apply for all input tag in div that has the class compare_button_container to change the sidebar widget button you do the same but use the class 'compare_button_go'

=

How can I auto show the Compare Featured fields on my product pages? =

You can copy this code `<? if(function_exists('wpec_show_compare_fields')) echo wpec_show_compare_fields(); ?>` and past into your theme code where you want to show the Compare Featured fields to auto show on your product pages.

== Support ==


If you have any problems, questions or suggestions please post your request to the [HELP tab](http://www.a3rev.com/products-page/wp-e-commerce/wpec-compare-products/#help) on the Pro Versions Home page.



== Changelog ==

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



== Upgrade Notice ==

= 1.0.3 - 2012/03/20 =
* Upgrade to show Compare button for older and latest versions of WP e-commerce.

= 1.0.2 - 2012/03/19 =
* Upgrade to can checked and unchecked Auto Add Compare button feature on Comparable Settings.

= 
1.0.1 - 2012/02/28 =
Upgrade to can use Deactivate Compare Feature option for Product Variations.


= 1.0 =
This first version.
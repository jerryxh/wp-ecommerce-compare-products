=== WP e-Commerce Compare Products ===


Contributors: A3 Revolution Software Development team

Tags: WP eCommerce, WP e-Commerce, compare product, wpec compare product, compare products, wp ecommerce compare products, e-commerce, ecommerce


Requires at least: 2.92
Tested up to: 3.3.1
Stable tag: 1.0.5

The Only Compare Products Plugin for WP e-Commerce. FULLY FEATURED, and Plug and play - FREE FOREVER

== Description ==

Ever seen or used one of those excellent Compare Products features on another e-commerce platform? You will agree they are a brilliant feature. WP e-Commerce Compare Products has very every feature of the best of those and it is plug-and-play and FREE FOREVER. 

WP e-Commerce Compare Products has been released in 2 versions - FREE and PRO because we want every WP e-Commerce site owner to be able to have this incredibly powerful feature on their sites.

= Fully Featured FREE Version - FREE Forever =

WP e-Commerce Compare Products has been released in a fully featured FREE version because we want every WP e-Commerce site owner to be able to use this mighty plugin on their sites to generate more sales - completely obligation and risk free. In fact if you have a smaller site or only sell one type of product on your site, that is all products have the same comparable features then the WP e-Commerce Compare Products FREE Version is all you will ever need.

[youtube http://www.youtube.com/watch?v=v7MQi2B_qeo]

= PRO VERSION Upgrade =

You can upgrade to the WP e-Commerce Compare Products PRO version at any time - or never, its up to you. When you do upgrade all of your Compare Features automatically transfer to the PRO version - nothing is lost.

If  you have a larger site or a varied product mix you will want the WP e-Commerce Compare Products PRO version for ease of management and the enhanced features it offers site owners and users. Whilst the FREE version is fully featured the advantages of the PRO version are:

* Bulk-update all your Products Compare Features from a single admin page.
* The plugin when activated auto adds a Compare Settings and Compare Products links to your WP e-Commerce Products Menu.
* Compare Settings has 3 tabs SETTINGS | CATEGORIES  |  FEATURES - each page has extensive help notes via Tool Tips and text.  
* Compare Feature only shows on a product once it has been assigned to a Compare Category. Allows you to do an orderly roll-out of the feature across your site.
* COMPARE PRODUCTS - Manage Compare features on every product on your site from the one page. See at a glance which products and variations have the feature activated. Add or edit Compare features on any products on your site.
* Edit the Compare Products feature on any products edit page.
 
We are are so confident that once you've installed the FREE version you'll want all the goodies PRO brings a professional online seller. If we are wrong then fully featured FREE version is yours for life for FREE FOREVER including lifetime upgrades and the same support as our PRO users.

Grab [WP e-Commerce Compare Product Pro Version](http://www.a3rev.com/products-page/wp-e-commerce/wpec-compare-products/) when you are ready. 

= TRY WP e-Commerce Compare Products FREE version = Install and try the FREE version before you spend your cash - we know you'll love it.

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

4. screenshot-4.jpg

5. screenshot-5.jpg

6. screenshot-6.jpg



= Localization =
Please [Contact us](http://www.a3rev.com/contact/) if you'd like to provide a translation or an update.

 == Installation ==


1. Upload the folder wpec-compare-products to the /wp-content/plugins/ directory

2. Activate the plugin through the Plugins menu in WordPress



== Usage ==


1. Open Products > Compare Settings

2. Settings Tab - follow the extensive onscreen help notes to style your Compare feature.

3. Features Tab - add your products Compare Features - extensive onscreen help notes to guide you. 

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
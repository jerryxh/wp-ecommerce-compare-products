<style>
<?php
global $wpec_compare_admin_interface, $wpec_compare_fonts_face;

// Grid View Button Style
global $wpec_compare_grid_view_settings, $wpec_compare_grid_view_button_style;
extract($wpec_compare_grid_view_settings);
extract($wpec_compare_grid_view_button_style);
?>
@charset "UTF-8";
/* CSS Document */

/* Grid View Button Style */
.wpec_grid_compare_button_container { 
	text-align:center; 
	margin: <?php echo $grid_view_button_margin_top; ?>px <?php echo $grid_view_button_margin_right; ?>px <?php echo $grid_view_button_margin_bottom; ?>px <?php echo $grid_view_button_margin_left; ?>px !important;
}
.wpec_grid_compare_button_container .wpec_bt_compare_this {
	position: relative !important;
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
}
.wpec_grid_compare_button_container .wpec_bt_compare_this_button {
	padding:<?php echo $gridview_button_padding_tb; ?>px <?php echo $gridview_button_padding_lr; ?>px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $button_bg_colour_from; ?>),
					color-stop(1, <?php echo $button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $button_bg_colour_from; ?> 20%,
					<?php echo $button_bg_colour_to; ?> 100%
				) !important;;
	
		
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_grid_view_button_style['button_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_grid_view_button_style['button_shadow'] ); ?>
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_grid_view_button_style['button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

.wpec_grid_compare_button_container .wpec_bt_compare_this_link {
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_grid_view_button_style['link_font'] ); ?>
}
.wpec_grid_compare_button_container .wpec_bt_compare_this_link:hover {
	color: <?php echo $link_font_hover_colour; ?> !important;
}
.wpec_grid_compare_button_container .wpec_bt_compare_this.compared:before {
<?php 
$wpec_compare_gridview_product_success_icon = get_option('wpec_compare_gridview_product_success_icon');
if ( $wpec_compare_gridview_product_success_icon != '') {
?>
	background: url(<?php echo $wpec_compare_gridview_product_success_icon; ?>) no-repeat scroll 0 center transparent;
<?php	
} else {
?>
	background: url(<?php echo ECCP_IMAGES_URL; ?>/compare_success.png) no-repeat scroll 0 center transparent;
<?php
}
?>
	position: absolute;
	right:-26px;
    content: "";
    height: 16px;
    text-indent: 0;
    width: 16px;
}

<?php
// Grid View View Compare Style
global $wpec_compare_gridview_view_compare_style;
extract($wpec_compare_gridview_view_compare_style);
?>
/* Grid View View Compare Style */
.wpec_grid_compare_button_container .wpec_bt_view_compare {
	position:relative !important;
	cursor:pointer !important;
	line-height: 1 !important;
	display:inline-block;
	margin-top:5px !important;
}

.wpec_grid_compare_button_container .wpec_bt_view_compare_link {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_gridview_view_compare_style['gridview_view_compare_link_font'] ); ?>
}
.wpec_grid_compare_button_container .wpec_bt_view_compare_link:hover {
	color: <?php echo $gridview_view_compare_link_font_hover_colour; ?> !important;
}

<?php
// Product Page Button Style
global $wpec_compare_product_page_settings, $wpec_compare_product_page_button_style;
extract($wpec_compare_product_page_settings);
extract($wpec_compare_product_page_button_style);
?>
/* Product Page Button Style */
.wpec_compare_button_container { 
	clear:both;
	margin: <?php echo $product_page_button_margin_top; ?>px <?php echo $product_page_button_margin_right; ?>px <?php echo $product_page_button_margin_bottom; ?>px <?php echo $product_page_button_margin_left; ?>px !important;
}
.wpec_compare_button_container .wpec_bt_compare_this {
	position:relative !important;
	cursor:pointer !important;
	display: inline-block !important;
	line-height: 1 !important;
}
.wpec_compare_button_container .wpec_bt_compare_this_button {
	padding: <?php echo $product_compare_button_padding_tb; ?>px <?php echo $product_compare_button_padding_lr; ?>px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $button_bg_colour_from; ?>),
					color-stop(1, <?php echo $button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $button_bg_colour_from; ?> 20%,
					<?php echo $button_bg_colour_to; ?> 100%
				) !important;;
	
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_product_page_button_style['button_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_product_page_button_style['button_shadow'] ); ?>
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_product_page_button_style['button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

.wpec_compare_button_container .wpec_bt_compare_this_link {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $product_compare_link_font ); ?>
}
.wpec_compare_button_container .wpec_bt_compare_this_link:hover {
	color: <?php echo $product_compare_link_font_hover_colour; ?> !important;
}
.wpec_compare_button_container .wpec_bt_compare_this.compared:before {
<?php 
$wpec_compare_product_success_icon = get_option('wpec_compare_product_success_icon');
if ( $wpec_compare_product_success_icon != '') {
?>
	background: url(<?php echo $wpec_compare_product_success_icon; ?>) no-repeat scroll 0 center transparent;
<?php	
} else {
?>
	background: url(<?php echo ECCP_IMAGES_URL; ?>/compare_success.png) no-repeat scroll 0 center transparent;
<?php
}
?>
	position: absolute;
	right:-26px;
    content: "";
    height: 16px;
    text-indent: 0;
    width: 16px;
}

<?php
// Product Page View Compare Style
global $wpec_compare_product_page_view_compare_style;
extract($wpec_compare_product_page_view_compare_style);
?>
/* Product Page View Compare Style */
.wpec_compare_button_container .wpec_bt_view_compare {
	position:relative !important;
	cursor:pointer !important;
	line-height: 1 !important;
	display:inline-block;
	margin-top:5px !important;
}
.wpec_compare_button_container .wpec_bt_view_compare_button {
	padding: <?php echo $product_view_compare_button_padding_tb; ?>px <?php echo $product_view_compare_button_padding_lr; ?>px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $button_bg_colour_from; ?>),
					color-stop(1, <?php echo $button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $button_bg_colour_from; ?> 20%,
					<?php echo $button_bg_colour_to; ?> 100%
				) !important;;
	
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_product_page_view_compare_style['button_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_product_page_view_compare_style['button_shadow'] ); ?>
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_product_page_view_compare_style['button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

.wpec_compare_button_container .wpec_bt_view_compare_link {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $product_view_compare_link_font ); ?>
}
.wpec_compare_button_container .wpec_bt_view_compare_link:hover {
	color: <?php echo $product_view_compare_link_font_hover_colour; ?> !important;
}

<?php
// Compare Widget Title Style
global $wpec_compare_widget_title_style;
extract($wpec_compare_widget_title_style);
?>
/* Compare Widget Title Style */
#compare_widget_title_container {
<?php if ( $widget_title_wide == 'auto') { ?>
	<?php if ( $widget_title_align != 'center') { ?>
	float: <?php echo $widget_title_align; ?> !important;
	<?php } else { ?>
	text-align:center !important;
	margin-left:auto !important;
	margin-right:auto !important;
	<?php } ?>
<?php } else { ?>
	text-align: <?php echo $widget_title_align; ?> !important;
<?php } ?>
	padding: <?php echo $widget_title_padding_topbottom; ?>px <?php echo $widget_title_padding_leftright; ?>px !important;
	margin-top: <?php echo $widget_title_margin_top; ?>px !important;
	margin-bottom: <?php echo $widget_title_margin_bottom; ?>px !important;
	
	/*Background*/
	background-color: <?php echo $widget_title_bg_colour; ?> !important;
	
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_widget_title_style['widget_title_border'] ); ?>
}

#compare_widget_title_container #compare_widget_title_text {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_widget_title_style['widget_title_font'] ); ?>
}

#total_compare_product {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_widget_title_style['total_font'] ); ?>
}

<?php
// Compare Widget Style
global $wpec_compare_widget_style;
extract($wpec_compare_widget_style);
?>
/* Compare Widget Style */
.no_compare_list {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_widget_style['text_font'] ); ?>
}
ul.compare_widget_ul {
	list-style:none !important;
	margin-left:0 !important;
	margin-right:0 !important;
	padding-left:0 !important;
	padding-right:0 !important;	
}
ul.compare_widget_ul li.compare_widget_item {
	background:none !important;
	list-style:none !important;
	margin-left:0 !important;
	margin-right:0 !important;
	padding-left:0 !important;
	padding-right:0 !important;
	margin-bottom:5px;
}
.wpec_compare_remove_product {
	cursor:pointer;
	display:inline-block !important;
	text-decoration: none !important;
}
.wpec_compare_remove_icon {
	border:none !important;
	padding:0 !important;
	margin:6px 0 0 !important;	
	max-width:10px !important;
	max-height:10px !important;
}
.wpec_compare_widget_item {
	display:block !important;
	text-decoration:none;	
}

.compare_widget_action {
	margin-top:10px;	
}

<?php
// Compare Thumbnail Style
global $wpec_compare_widget_thumbnail_style;
extract($wpec_compare_widget_thumbnail_style);
?>

<?php if ($activate_thumbnail == 1) { ?>
/* Compare Thumbnail Style */
.wpec_compare_widget_thumbnail {
	width: <?php echo $thumb_wide; ?>px !important;
	max-width: 100% !important;
	min-width: auto !important;
	height: auto !important;
	float: <?php echo $thumb_align; ?> !important;
<?php if ($thumb_align == 'left') { ?>
	margin: 0 5px 2px 0 !important;
<?php } else { ?>
	margin: 0 0 2px 3px !important;
<?php } ?>
	padding: <?php echo $thumb_padding; ?>px !important;
	/*Background*/
	background-color: <?php echo $thumb_bg_colour; ?> !important;
	
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_widget_thumbnail_style['thumb_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_widget_thumbnail_style['thumb_shadow'] ); ?>
	
}
<?php } ?>

.compare_remove_column {
<?php if ($thumb_align == 'left') { ?>
	float: right;
<?php } else { ?>
	float: left;
<?php } ?>
}
.compare_title_column {
<?php if ($thumb_align == 'left') { ?>
	margin-right:15px;
<?php } else { ?>
	margin-left:15px;
<?php } ?>
}

<?php
// Compare Widget Button Style
global $wpec_compare_widget_button_style;
extract($wpec_compare_widget_button_style);
?>
@charset "UTF-8";
/* CSS Document */

/* Compare Widget Button Style */
.wpec_compare_widget_button_container { 
	text-align:center;
<?php if ($button_position != 'center') { ?>
	float: <?php echo $button_position; ?> !important;
<?php } ?> 
}
.wpec_compare_button_go {
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
	margin:0;
}
.wpec_compare_widget_button_go {
	padding: <?php echo $compare_widget_button_padding_tb; ?>px <?php echo $compare_widget_button_padding_lr; ?>px !important;	
	/*Background*/
	background-color: <?php echo $button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $button_bg_colour_from; ?>),
					color-stop(1, <?php echo $button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $button_bg_colour_from; ?> 20%,
					<?php echo $button_bg_colour_to; ?> 100%
				) !important;;
	
		
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_widget_button_style['button_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_widget_button_style['button_shadow'] ); ?>
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_widget_button_style['button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
.wpec_compare_widget_link_go {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_widget_button_style['compare_widget_link_font'] ); ?>
}
.wpec_compare_widget_link_go:hover {
	color: <?php echo $compare_widget_link_font_hover_colour; ?> !important;
}

<?php
// Compare Widget Clear All Items Style
global $wpec_compare_widget_clear_all_style;
extract($wpec_compare_widget_clear_all_style);
?>
/* Compare Widget Clear All Items Style */
.wpec_compare_clear_all_container {
	text-align:center;
<?php if ($clear_all_item_horizontal != 'center') { ?>
	float: <?php echo $clear_all_item_horizontal; ?> !important;
<?php } ?>
<?php if ($clear_all_item_vertical != 'below') { ?>
	margin-bottom: 10px !important;
<?php } else { ?>
	margin-top: 8px !important;
<?php } ?>
}
.wpec_compare_clear_all {
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
	margin:0;
}
.wpec_compare_clear_all_button {
	padding: <?php echo $clear_all_button_padding_tb; ?>px <?php echo $clear_all_button_padding_lr; ?>px !important;	
	/*Background*/
	background-color: <?php echo $clear_all_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $clear_all_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $clear_all_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $clear_all_button_bg_colour_from; ?> 20%,
					<?php echo $clear_all_button_bg_colour_to; ?> 100%
				) !important;;
	
		
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_widget_clear_all_style['clear_all_button_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_widget_clear_all_style['clear_all_button_shadow'] ); ?>
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_widget_clear_all_style['clear_all_button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
.wpec_compare_clear_all_link {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_widget_clear_all_style['clear_text_font'] ); ?>
}
.wpec_compare_clear_all_link:hover {
	color: <?php echo $clear_text_font_hover_colour; ?> !important;
}

</style>
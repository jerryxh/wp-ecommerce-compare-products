<style>
<?php
global $wpec_compare_admin_interface, $wpec_compare_fonts_face;

// Grid View Button Style
global $wpec_compare_page_style;
extract($wpec_compare_page_style);
?>
@charset "UTF-8";
/* CSS Document */

/* Comparison Page Body Style */
body {
	background-color: <?php echo $body_bg_colour; ?> !important;
}

.compare_print_container {
	z-index:9;	
}
/* Comparison Page Header Style */
.compare_heading {
	/*Background*/
	background-color: <?php echo $header_bg_colour; ?> !important;
	/*Border*/
	border-bottom: <?php echo esc_attr( $header_bottom_border['width'] ); ?> <?php echo esc_attr( $header_bottom_border['style'] ); ?> <?php echo esc_attr( $header_bottom_border['color'] ); ?> !important;
}

/* Comparison Empty Window Message Style */
.no_compare_list {
	text-align: <?php echo $no_product_message_align; ?>;
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_page_style['no_product_message_font'] ); ?>
}

<?php
// Print Message Style
global $wpec_compare_print_page_settings;
extract($wpec_compare_print_page_settings);
?>

/* Print Message Style */
.wpec_compare_print_msg {
	text-align: right;
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_print_page_settings['print_message_font'] ); ?>
}

<?php
// Print Button Style
?>

/* Print Button Style */
.wpec_compare_print {
	float:right;
	cursor:pointer;
	display: inline-block;
	line-height: 1 !important;
	margin: 0 10px 5px 0 !important;
	padding: 7px 10px !important;
}
.compare_print_button_type {
	padding: <?php echo $print_button_padding_tb; ?>px <?php echo $print_button_padding_lr; ?>px !important;
	
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
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_print_page_settings['button_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_print_page_settings['print_button_shadow'] ); ?>
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_print_page_settings['button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
.compare_print_link_type {
	position:relative;
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_print_page_settings['print_link_font'] ); ?>
}
.compare_print_link_type:hover {
	color: <?php echo $print_link_font_hover_colour; ?> !important;
}

<?php
// Close Button Style
global $wpec_compare_close_window_button_style;
extract($wpec_compare_close_window_button_style);
?>

/* Close Button Style */
.wpec_compare_close {
	float:right;
	cursor:pointer;
	display: inline-block;
	line-height: 1 !important;
	padding: 7px 10px !important;
	margin: 0 10px 5px 0 !important;
}
.compare_close_button_type {
	padding: <?php echo $close_button_padding_tb; ?>px <?php echo $close_button_padding_lr; ?>px !important;
	
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
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_close_window_button_style['button_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_close_window_button_style['close_button_shadow'] ); ?>
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_close_window_button_style['button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
.compare_close_link_type {
	position:relative;
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_close_window_button_style['close_link_font'] ); ?>
}
.compare_close_link_type:hover {
	color: <?php echo $close_link_font_hover_colour; ?> !important;
}

<?php
// Table Style
global $wpec_compare_table_style;
extract($wpec_compare_table_style);
?>

/* Table Style */
#bg-labels {
	background-color: <?php echo $body_bg_colour; ?> !important;
}
#nameTableHldr {
	background-color: #FFF !important;
}
#product_comparison {
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_table_style['table_border'] ); ?>
	border-collapse:collapse !important;
}
#nameTable {
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_table_style['table_border'] ); ?>
	border-collapse:collapse !important;
}

/* Tabe First Cell Style */
tr.row_product_detail th, tr.row_product_detail td {
	/*Background*/
	background-color: <?php echo $table_heading_bg_colour; ?> !important;
}
tr.row_2 td, tr.row_2 th {
	background-color: <?php echo $alt_row_bg_colour; ?> !important;
}
/* Tabe Cell Style */
#product_comparison td, #nameTable td {
	border-right: <?php echo $table_border['width']; ?> <?php echo $table_border['style']; ?> <?php echo $table_border['color']; ?> !important;
	border-bottom: <?php echo $table_border['width']; ?> <?php echo $table_border['style']; ?> <?php echo $table_border['color']; ?> !important;
	border-left:none;
}
#product_comparison th, #nameTable th {
	border:none;	
}
#bg-labels span, .td-spacer {
	padding-top: <?php echo $table_row_padding_top; ?>px !important;
	padding-bottom: <?php echo $table_row_padding_bottom; ?>px !important;
	padding-left: <?php echo $table_row_padding_left; ?>px !important;
	padding-right: <?php echo $table_row_padding_right; ?>px !important;
}

<?php
// Add To Cart
global $wpec_compare_addtocart_style;
extract($wpec_compare_addtocart_style);
?>
/* Add To Cart */
.compare_add_cart a.add_to_cart_button_type {
	position:relative;
	display:inline-block;
	padding: <?php echo $addtocart_button_padding_tb; ?>px <?php echo $addtocart_button_padding_lr; ?>px !important;
	margin-bottom:5px !important;
	
	/*Background*/
	background-color: <?php echo $addtocart_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $addtocart_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $addtocart_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $addtocart_button_bg_colour_from; ?> 20%,
					<?php echo $addtocart_button_bg_colour_to; ?> 100%
				) !important;;
	
		
	/*Border*/
	<?php echo $wpec_compare_admin_interface->generate_border_css( $wpec_compare_addtocart_style['addtocart_button_border'] ); ?>
	
	/* Shadow */
	<?php echo $wpec_compare_admin_interface->generate_shadow_css( $wpec_compare_addtocart_style['addtocart_button_shadow'] ); ?>
	
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_addtocart_style['addtocart_button_font'] ); ?>

	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

.compare_add_cart a.add_to_cart_link_type {
	position:relative;
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_addtocart_style['addtocart_link_font'] ); ?>
}
.compare_add_cart a.add_to_cart_link_type:hover {
	color: <?php echo $addtocart_link_font_hover_colour; ?> !important;
}
.compare_add_cart a.added:before {
<?php 
$wpec_compare_addtocart_success = get_option('wpec_compare_addtocart_success');
if ( $wpec_compare_addtocart_success != '') {
?>
	background: url(<?php echo $wpec_compare_addtocart_success; ?>) no-repeat scroll 0 center transparent;
<?php	
} else {
?>
	background: url(<?php echo ECCP_IMAGES_URL; ?>/addtocart_success.png) no-repeat scroll 0 center transparent;
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
// View Cart
global $wpec_compare_viewcart_style;
extract($wpec_compare_viewcart_style);
?>
/* View Cart */
.compare_add_cart a.added_to_cart {
	display:block;
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_viewcart_style['viewcart_link_font'] ); ?>
}
.compare_add_cart a.added_to_cart:hover {
	color: <?php echo $viewcart_link_font_hover_colour; ?> !important;
}
.compare_add_cart .virtual_added_to_cart {
	display:block;
	visibility:hidden;
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_viewcart_style['viewcart_link_font'] ); ?>
}


<?php
// Table Content Style
global $wpec_compare_table_content_style;
extract($wpec_compare_table_content_style);
?>

/* Compare Feature Titles ( Left Fixed Column) Style */
.compare_value {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_table_content_style['feature_title_font'] ); ?>
	
	text-align: <?php echo $feature_title_align; ?> !important;
}

/* Table Rows Feature Values Font */
.td-spacer {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_table_content_style['content_font'] ); ?>
}
.td-spacer iframe {
	z-index:8;	
}

/* Empty Feature Values Row Cell Display */
#product_comparison td.empty_cell {
	/*Background*/
	background-color: <?php echo $empty_cell_bg_colour; ?> !important;
}
.empty_text {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_table_content_style['empty_font'] ); ?>
}

/* Product Name Font */
.compare_product_name {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_table_content_style['product_name_font'] ); ?>
}

<?php
// Price Style
global $wpec_compare_product_prices_style;
extract($wpec_compare_product_prices_style);
?>
/* Price Style */
.compare_price {
	/* Font */
	<?php echo $wpec_compare_fonts_face->generate_font_css( $wpec_compare_product_prices_style['price_font'] ); ?>
}

/* For Print Page*/
.compare_popup_print .hide_in_print {
	display: none !important;	
}
.compare_popup_print .compare_heading {
	position:absolute !important;
}
.compare_popup_print .compare_value {
	text-align: <?php echo $feature_title_align; ?> !important;
	padding-top: <?php echo $table_row_padding_top; ?>px !important;
	padding-bottom: <?php echo $table_row_padding_bottom; ?>px !important;
	padding-left: <?php echo $table_row_padding_left; ?>px !important;
	padding-right: <?php echo $table_row_padding_right; ?>px !important;
	width:215px !important;
}
.compare_popup_print #product_comparison th, .compare_popup_print #product_comparison td {
	border-right: <?php echo $table_border_size; ?> <?php echo $table_border_style; ?> <?php echo $table_border_colour; ?> !important;
	border-bottom: <?php echo $table_border_size; ?> <?php echo $table_border_style; ?> <?php echo $table_border_colour; ?> !important;
}
</style>

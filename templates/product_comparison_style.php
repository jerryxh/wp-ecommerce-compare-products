<style>
<?php
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

/* Comparison Page Header Style */
.compare_heading {
	/*Background*/
	background-color: <?php echo $header_bg_colour; ?> !important;
	/*Border*/
	border-bottom: <?php echo $header_bottom_border_size; ?> <?php echo $header_bottom_border_style; ?> <?php echo $header_bottom_border_colour; ?> !important;
}

/* Comparison Empty Window Message Style */
.no_compare_list {
	text-align: <?php echo $no_product_message_align; ?>;
	/* Font */
	font-family: <?php echo $no_product_message_font; ?> !important;
	font-size: <?php echo $no_product_message_font_size; ?> !important;
	color: <?php echo $no_product_message_font_colour; ?> !important;
<?php if ( stristr($no_product_message_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($no_product_message_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $no_product_message_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
}

<?php
// Print Message Style
global $wpec_compare_print_message_style;
extract($wpec_compare_print_message_style);
?>

/* Print Message Style */
.wpec_compare_print_msg {
	text-align: right;
	/* Font */
	font-family: <?php echo $print_message_font; ?> !important;
	font-size: <?php echo $print_message_font_size; ?> !important;
	color: <?php echo $print_message_font_colour; ?> !important;
<?php if ( stristr($print_message_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($print_message_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $print_message_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
}

<?php
// Print Button Style
global $wpec_compare_print_button_style;
extract($wpec_compare_print_button_style);
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
	border: <?php echo $button_border_size; ?> <?php echo $button_border_style; ?> <?php echo $button_border_colour; ?> !important;
<?php if ($button_border_rounded == 'rounded') { ?>
	-webkit-border-radius: <?php echo $button_border_rounded_value; ?>px !important;
	-moz-border-radius: <?php echo $button_border_rounded_value; ?>px !important;
	border-radius: <?php echo $button_border_rounded_value; ?>px !important;
<?php } else { ?>
	-webkit-border-radius: 0px !important;
	-moz-border-radius: 0px !important;
	border-radius: 0px !important;
<?php } ?>
	
	/* Font */
	font-family: <?php echo $button_font; ?> !important;
	font-size: <?php echo $button_font_size; ?> !important;
	color: <?php echo $button_font_colour; ?> !important;
<?php if ( stristr($button_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($button_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $button_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
.compare_print_link_type {
	position:relative;
	/* Font */
	font-family: <?php echo $print_link_font; ?> !important;
	font-size: <?php echo $print_link_font_size; ?> !important;
	color: <?php echo $print_link_font_colour; ?> !important;
<?php if ( stristr($print_link_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($print_link_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $print_link_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
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
	border: <?php echo $button_border_size; ?> <?php echo $button_border_style; ?> <?php echo $button_border_colour; ?> !important;
<?php if ($button_border_rounded == 'rounded') { ?>
	-webkit-border-radius: <?php echo $button_border_rounded_value; ?>px !important;
	-moz-border-radius: <?php echo $button_border_rounded_value; ?>px !important;
	border-radius: <?php echo $button_border_rounded_value; ?>px !important;
<?php } else { ?>
	-webkit-border-radius: 0px !important;
	-moz-border-radius: 0px !important;
	border-radius: 0px !important;
<?php } ?>
	
	/* Font */
	font-family: <?php echo $button_font; ?> !important;
	font-size: <?php echo $button_font_size; ?> !important;
	color: <?php echo $button_font_colour; ?> !important;
<?php if ( stristr($button_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($button_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $button_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
.compare_close_link_type {
	position:relative;
	/* Font */
	font-family: <?php echo $close_link_font; ?> !important;
	font-size: <?php echo $close_link_font_size; ?> !important;
	color: <?php echo $close_link_font_colour; ?> !important;
<?php if ( stristr($close_link_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($close_link_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $close_link_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
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
	border: <?php echo $table_border_size; ?> <?php echo $table_border_style; ?> <?php echo $table_border_colour; ?> !important;
	border-collapse:collapse !important;
}
#nameTable {
	/*Border*/
	border: <?php echo $table_border_size; ?> <?php echo $table_border_style; ?> <?php echo $table_border_colour; ?> !important;
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
	border-right: <?php echo $table_border_size; ?> <?php echo $table_border_style; ?> <?php echo $table_border_colour; ?> !important;
	border-bottom: <?php echo $table_border_size; ?> <?php echo $table_border_style; ?> <?php echo $table_border_colour; ?> !important;
	border-left:none;
}
#product_comparison th, #nameTable th {
	border:none;	
}
#bg-labels span, .td-spacer, {
	padding-top: <?php echo $row_padding_topbottom; ?>px !important;
	padding-bottom: <?php echo $row_padding_topbottom; ?>px !important;
	padding-left: <?php echo $row_padding_leftright; ?>px !important;
	padding-right: <?php echo $row_padding_leftright; ?>px !important;
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
	padding: 5px 10px !important;
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
	border: <?php echo $addtocart_button_border_size; ?> <?php echo $addtocart_button_border_style; ?> <?php echo $addtocart_button_border_colour; ?> !important;
<?php if ($addtocart_button_border_rounded == 'rounded') { ?>
	-webkit-border-radius: <?php echo $addtocart_button_border_rounded_value; ?>px !important;
	-moz-border-radius: <?php echo $addtocart_button_border_rounded_value; ?>px !important;
	border-radius: <?php echo $addtocart_button_border_rounded_value; ?>px !important;
<?php } else { ?>
	-webkit-border-radius: 0px !important;
	-moz-border-radius: 0px !important;
	border-radius: 0px !important;
<?php } ?>

	/* Font */
	font-family: <?php echo $addtocart_button_font; ?> !important;
	font-size: <?php echo $addtocart_button_font_size; ?> !important;
	color: <?php echo $addtocart_button_font_colour; ?> !important;
<?php if ( stristr($addtocart_button_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($addtocart_button_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $addtocart_button_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>

	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

.compare_add_cart a.add_to_cart_link_type {
	position:relative;
	/* Font */
	font-family: <?php echo $addtocart_link_font; ?> !important;
	font-size: <?php echo $addtocart_link_font_size; ?> !important;
	color: <?php echo $addtocart_link_font_colour; ?> !important;
<?php if ( stristr($addtocart_link_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($addtocart_link_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $addtocart_link_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
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
	font-family: <?php echo $viewcart_link_font; ?> !important;
	font-size: <?php echo $viewcart_link_font_size; ?> !important;
	color: <?php echo $viewcart_link_font_colour; ?> !important;
<?php if ( stristr($viewcart_link_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($viewcart_link_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $viewcart_link_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
}
.compare_add_cart a.added_to_cart:hover {
	color: <?php echo $viewcart_link_font_hover_colour; ?> !important;
}
.compare_add_cart .virtual_added_to_cart {
	display:block;
	visibility:hidden;
	/* Font */
	font-family: <?php echo $viewcart_link_font; ?> !important;
	font-size: <?php echo $viewcart_link_font_size; ?> !important;
	color: <?php echo $viewcart_link_font_colour; ?> !important;
<?php if ( stristr($viewcart_link_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($viewcart_link_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $viewcart_link_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
}


<?php
// Table Content Style
global $wpec_compare_table_content_style;
extract($wpec_compare_table_content_style);
?>

/* Compare Feature Titles ( Left Fixed Column) Style */
.compare_value {
	/* Font */
	font-family: <?php echo $feature_title_font; ?> !important;
	font-size: <?php echo $feature_title_font_size; ?> !important;
	color: <?php echo $feature_title_font_colour; ?> !important;
<?php if ( stristr($feature_title_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($feature_title_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $feature_title_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
	
	text-align: <?php echo $feature_title_align; ?> !important;
}

/* Table Rows Feature Values Font */
.td-spacer {
	/* Font */
	font-family: <?php echo $content_font; ?> !important;
	font-size: <?php echo $content_font_size; ?> !important;
	color: <?php echo $content_font_colour; ?> !important;
<?php if ( stristr($content_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($content_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $content_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
}

/* Empty Feature Values Row Cell Display */
#product_comparison td.empty_cell {
	/*Background*/
	background-color: <?php echo $empty_cell_bg_colour; ?> !important;
}
.empty_text {
	/* Font */
	font-family: <?php echo $empty_font; ?> !important;
	font-size: <?php echo $empty_font_size; ?> !important;
	color: <?php echo $empty_font_colour; ?> !important;
<?php if ( stristr($empty_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($empty_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $empty_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
}

/* Product Name Font */
.compare_product_name {
	/* Font */
	font-family: <?php echo $product_name_font; ?> !important;
	font-size: <?php echo $product_name_font_size; ?> !important;
	color: <?php echo $product_name_font_colour; ?> !important;
<?php if ( stristr($product_name_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($product_name_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $product_name_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
}

<?php
// Price Style
global $wpec_compare_product_prices_style;
extract($wpec_compare_product_prices_style);
?>
/* Price Style */
.compare_price {
	/* Font */
	font-family: <?php echo $price_font; ?> !important;
	font-size: <?php echo $price_font_size; ?> !important;
	color: <?php echo $price_font_colour; ?> !important;
<?php if ( stristr($price_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($price_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $price_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
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
	padding-top: <?php echo $row_padding_topbottom; ?>px !important;
	padding-bottom: <?php echo $row_padding_topbottom; ?>px !important;
	padding-left: <?php echo $row_padding_leftright; ?>px !important;
	padding-right: <?php echo $row_padding_leftright; ?>px !important;
	width:215px !important;
}
.compare_popup_print #product_comparison th, .compare_popup_print #product_comparison td {
	border-right: <?php echo $table_border_size; ?> <?php echo $table_border_style; ?> <?php echo $table_border_colour; ?> !important;
	border-bottom: <?php echo $table_border_size; ?> <?php echo $table_border_style; ?> <?php echo $table_border_colour; ?> !important;
}
</style>
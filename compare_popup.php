<?php
include( '../../../wp-config.php');
?>
<?php $comparable_settings = get_option('comparable_settings'); ?>
<?php if(trim($comparable_settings['compare_container_height']) != '') $compare_container_height = $comparable_settings['compare_container_height']; else $compare_container_height = 500; ?>
<div class="compare_popup_container">
	<style type="text/css">
	.compare_popup_container{
		font-size:12px;
		margin:auto;
		width:960px;
	}
	.compare_popup_wrap{
		overflow:auto;
		width:940px;
		height:<?php echo $compare_container_height; ?>px;
		margin:0 10px;
		padding-bottom:10px;
	}
	.compare_logo{
		text-align:center;	
	}
	.compare_logo img{
		max-width:940px;
	}
	.compare_heading{
		float:left;
		width:940px;
		margin:10px 10px 0;	
	}
	.compare_heading h1{
		font-size:20px;
		font-weight:bold;
		float:left;
	}
	.compare_print{
		float:right;
		background:url(<?php echo ECCP_IMAGES_FOLDER; ?>/icon_print.png) no-repeat 0 center;
		padding-left:20px;	
		cursor:pointer;
	}
	.compare_print_msg{
		float:right;
		clear:right;
	}
	.compare_popup_table{
		border:1px solid #325EBF; 
		border-radius:8px; 
		-khtml-border-radius: 8px; 
		-webkit-border-radius: 8px; 
		-moz-border-radius: 8px;
		box-shadow:2px 3px 2px #333333;
		-moz-box-shadow: 2px 3px 2px #333333;
		-webkit-box-shadow: 2px 3px 2px #333333;
		margin:auto;
	}
	.compare_popup_table td{
		font-size:12px;
		text-align:center;
		padding:2px 10px;
		vertical-align:middle;
	}
	.compare_popup_table tr.row_product_detail td{
		vertical-align:top;	
	}
	.compare_popup_table .column_first{
		background:#f6f6f6;
		font-size:13px;
		font-weight:bold;
	}
	.compare_popup_table .first_row{
		width:220px; 
		min-width:220px;
		height:20px;
		text-align:right;
		/* fallback (opera, ie<=7) */
		background: #EEEEEE;
		/* Mozilla: */
		background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE);
		/* Chrome, safari:*/
		background: -webkit-gradient(linear, left top, left bottom, from(#FFFFFF), to(#EEEEEE));
		/* MSIE 8+ */
		filter: progid:DXImageTransform.Microsoft.Gradient(StartColorStr='#FFFFFF', EndColorStr='#EEEEEE', GradientType=0);
	}
	.compare_popup_table .column_first.first_row{
		width:190px;
		min-width:190px;	
	}
	.compare_popup_table .row_1{
		background:#FFF;
	}
	.compare_popup_table .row_2{
		background:#f6f6f6;
		border-top:1px solid #CCC;
		border-bottom:1px solid #CCC;
	}
	.compare_popup_table .row_2 td{
		border-top:1px solid #CCC;
		border-bottom:1px solid #CCC;
	}
	.compare_popup_table .row_end td{
		border-bottom:none;	
		padding-bottom:10px;
		padding-top:10px;
	}
	.compare_image_container{
		width:220px; 
		height:180px; 
		display:table-cell; 
		overflow:hidden; 
		text-align:center; 
		line-height:180px; 
		vertical-align:middle;
	}
	.compare_image_container img{
		max-width:220px; 
		max-height:180px; 
		border:0;
		vertical-align:middle;
	}
	.compare_product_name{
		color:#C30;
		font-weight:bold;
		font-size:16px;
		line-height:21px;
		margin-bottom:5px;
	}
	.compare_avg_rating{
		margin-bottom:5px;	
	}
	.compare_avg_rating .votetext{
		height:auto;
	}
	.compare_price{
		color:#C30;
		font-weight:bold;
		font-size:16px;
		margin-bottom:5px;
	}
	</style>
    	<div class="compare_logo"><?php if(trim($comparable_settings['compare_logo']) != ''){ ?><img src="<?php echo $comparable_settings['compare_logo']; ?>" alt="" /><?php } ?></div>
        <div class="compare_heading"><h1>Compare Products</h1> <span class="compare_print">Print This Page</span><span class="compare_print_msg">Narrow your selection to 3 products and print!</span></div>
        <div style="clear:both;"></div>
    	<div class="popup_compare_widget_loader" style="display:none; text-align:center"><img src="<?php echo ECCP_IMAGES_FOLDER; ?>/ajax-loader.gif" border=0 /></div>
  		<div class="compare_popup_wrap">
        	<?php echo WPEC_Compare_Functions::get_compare_list_html_popup();?>
        </div>
</div>
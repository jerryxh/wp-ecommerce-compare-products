<?php
@set_time_limit(86400); //increase time-out to 1 day as downloading and parsing the eBay category tree may take a while
@ini_set("memory_limit","64M"); //increase memory limit because tree is big
@ini_set("max-execution-time", 86400);
include( '../../../wp-config.php');
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
if(isset($_REQUEST['res_id']) && trim($_REQUEST['res_id']) > 0 && isset($_REQUEST['menu']) && array_key_exists(trim($_REQUEST['menu']), SubMenus_Data::$parent_menus) ){
global $wbdb;
	$res_id = trim($_REQUEST['res_id']);
	$parent_menu = trim($_REQUEST['menu']);
	
	$submenus = SubMenus_Data::get_results("res_id=".$res_id." AND parent_menu='".$parent_menu."' AND published=1", "ordering ASC");
	if(is_array($submenus) && count($submenus) > 0){
		
	
		$company_name = get_bloginfo('name');
		$company_site = get_option('siteurl');
		$company_site_tag = str_replace("http://", "", $company_site);
		$check_www = substr_compare($company_site_tag, "www.", 0, 4);
		if(!$check_www){
			$company_site_new = $company_site_tag;
		}else{
			$company_site_new = "www.".$company_site_tag;
		}
		
		$company_email = get_option('admin_email');
	
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($company_name);
		$pdf->SetTitle(SubMenus_Data::$parent_menus[$parent_menu].' Menu');
		$pdf->SetSubject(SubMenus_Data::$parent_menus[$parent_menu].' Menu');
		$pdf->SetKeywords($company_name.', '.$company_site.', '.$company_email.', '.SubMenus_Data::$parent_menus[$parent_menu].' Menu');
		
		// set default header data
		$pdf->SetHeaderData('', '', strtoupper(SubMenus_Data::$parent_menus[$parent_menu].' Menu'), 'By '. strtoupper($company_name).' - '.$company_site_new);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);
		
		// remove default footer
		$pdf->setPrintFooter(false);
		
		//set auto page breaks
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		
		// ---------------------------------------------------------
		
		// set font$pdf->SetFont('times', '', 12);
		$pdf->SetFont('', '', 12);
		
		$right_server_dir = stristr(A3_RES_FILE_PATH, '/wp-content');
		$left_server_dir = str_replace($right_server_dir, '', A3_RES_FILE_PATH);
		
		// Start First Page Group
		$pdf->startPageGroup();
		
		
		foreach($submenus as $submenu){
			if(trim($submenu->content) != ''){
				// add a page
				$pdf->AddPage();
				$menu_name = '<h2 style="color:#BAB3FF">'.$submenu->submenu.'</h2><div style="clear:both"></div>';
				$pdf->writeHTML($menu_name, true, false, true, false, '');
				$content = str_replace($left_server_dir, get_option('siteurl'), $submenu->content).'<div style="clear:both"></div>';
				$content = str_replace('/userfiles', get_option('siteurl')."/userfiles", $content);
				$content = htmlspecialchars_decode($content);
				$pdf->writeHTML($content, true, false, true, false, '');
			}
		}
		
		//Close and output PDF document
		$pdf->Output($parent_menu.'.pdf', 'I');
 
	}
}
?>
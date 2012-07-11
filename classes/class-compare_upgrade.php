<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Upgrade
 *
 * Table Of Contents
 *
 * upgrade_version_1_0_1()
 * upgrade_version_2_0()
 * upgrade_version_2_0_1()
 */					
class WPEC_Compare_Upgrade{
	function upgrade_version_1_0_1(){
		WPEC_Compare_Categories_Data::install_database();
		WPEC_Compare_Categories_Fields_Data::install_database();
	}
	
	function upgrade_version_2_0() {
		global $wpdb;
		$sql = "ALTER TABLE ". $wpdb->prefix . "wpec_compare_fields CHANGE `field_name` `field_name` blob NOT NULL";
		$wpdb->query($sql);
		
		global $wpdb;
		$sql = "ALTER TABLE ". $wpdb->prefix . "wpec_compare_fields CHANGE `field_unit` `field_unit` blob NOT NULL";
		$wpdb->query($sql);
		
		global $wpdb;
		$sql = "ALTER TABLE ". $wpdb->prefix . "wpec_compare_fields CHANGE `field_description` `field_description` blob NOT NULL";
		$wpdb->query($sql);
		
		WPEC_Compare_Categories_Data::auto_add_master_category();
		WPEC_Compare_Data::add_features_to_master_category();
	}
	
	function upgrade_version_2_0_1() {
		global $wpdb;
		$sql = "ALTER TABLE ". $wpdb->prefix . "wpec_compare_categories CHANGE `category_name` `category_name` blob NOT NULL";
		$wpdb->query($sql);
	}
}
?>

<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Categories Data
 *
 * Table Of Contents
 *
 * install_database()
 * automatic_add_compare_categories()
 * get_row()
 * get_maximum_order()
 * get_count()
 * get_results()
 * insert_row()
 * update_row()
 * update_items_order()
 * update_order()
 * delete_rows()
 * delete_row()
 */
class WPEC_Compare_Categories_Data{
	function install_database(){
		global $wpdb;
		$table_compare_categories = $wpdb->prefix. "wpec_compare_categories";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_compare_categories'") != $table_compare_categories){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table_compare_categories}` (
				  `id` int(11) NOT NULL auto_increment,
				  `category_name` blob NOT NULL,
				  `category_order` int(11) NOT NULL,
				  PRIMARY KEY  (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}
	
	function automatic_add_compare_categories() {
		$terms = get_terms("wpsc_product_category", array('hide_empty' => 0));
		if ( count($terms) > 0 ) {
			foreach ($terms as $category_product) {
				$check_existed = WPEC_Compare_Categories_Data::get_count("category_name='".trim(addslashes($category_product->name))."'");
				if ($check_existed < 1 ) {
					WPEC_Compare_Categories_Data::insert_row(array('category_name' => trim(addslashes($category_product->name))));
				}
			}
		}
	}
	
	function auto_add_master_category() {
		$master_category = 'Master Category';
		$check_existed = WPEC_Compare_Categories_Data::get_count("category_name='".$master_category."'");
		if ($check_existed < 1 ) {
			$master_category_id = WPEC_Compare_Categories_Data::insert_row(array('category_name' => $master_category, 'category_order' => 0));
			if ($master_category_id !== false ) {
				update_option('master_category_compare' , $master_category_id);	
			}
		} else {
			$master_category_data = WPEC_Compare_Categories_Data::get_results("category_name='".$master_category."'");
			$master_category_id = $master_category_data[0]->id;
			WPEC_Compare_Categories_Data::update_order($master_category_id, 0);
			update_option('master_category_compare' , $master_category_id);
		}
	}
	
	function get_row($id, $where='', $output_type='OBJECT'){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		if(trim($where) != '')
			$where = ' AND '.$where;
		$result = $wpdb->get_row("SELECT * FROM {$table_name} WHERE id='$id' {$where}", $output_type);
		return $result;
	}
	
	function get_maximum_order($where=''){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_categories";
		if(trim($where) != '')
			$where = " WHERE {$where} ";
		$maximum = $wpdb->get_var("SELECT MAX(category_order) FROM {$table_name} {$where}");
		
		return $maximum;
	}
	
	function get_count($where=''){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_categories";
		if(trim($where) != '')
			$where = " WHERE {$where} ";
		$count = $wpdb->get_var("SELECT COUNT(id) FROM {$table_name} {$where}");
		
		return $count;
	}
	
	function get_results($where='', $order='', $limit ='', $output_type='OBJECT'){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_categories";
		if(trim($where) != '')
			$where = " WHERE {$where} ";
		if(trim($order) != '')
			$order = " ORDER BY {$order} ";
		if(trim($limit) != '')
			$limit = " LIMIT {$limit} ";
		$result = $wpdb->get_results("SELECT * FROM {$table_name} {$where} {$order} {$limit}", $output_type);
		return $result;
	}
	
	function insert_row($args){
		global $wpdb;
		extract($args);
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		$category_name = strip_tags(addslashes($category_name));
		$category_order = WPEC_Compare_Categories_Data::get_maximum_order();
		$category_order++;
		$query = $wpdb->query("INSERT INTO {$table_name}(category_name, category_order) VALUES('$category_name', '$category_order')");
		if($query){
			$category_id = $wpdb->insert_id;
			return $category_id;
		}else{
			return false;
		}
	}
	
	function update_row($args){
		global $wpdb;
		extract($args);
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		$category_name = strip_tags(addslashes($category_name));
		
		$query = $wpdb->query("UPDATE {$table_name} SET category_name='$category_name' WHERE id='$category_id'");
		return $query;
		
	}
	
	function update_items_order($item_orders=array()){
		if(is_array($item_orders) && count($item_orders) > 0){
			foreach($item_orders as $category_id => $category_order){
				WPEC_Compare_Categories_Data::update_order($category_id, $category_order);
			}
		}
	}
	
	function update_order($category_id, $category_order=0){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		$query = $wpdb->query("UPDATE {$table_name} SET category_order='$category_order' WHERE id='$category_id'");
		return $query;
	}
	
	function delete_rows($items=array()){
		if(is_array($items) && count($items) > 0){
			foreach($items as $category_id){
				WPEC_Compare_Categories_Data::delete_row($category_id);
			}
		}
	}
	
	function delete_row($category_id){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		$result = $wpdb->query("DELETE FROM {$table_name} WHERE id='{$category_id}'");
		return $result;
	}
}
?>
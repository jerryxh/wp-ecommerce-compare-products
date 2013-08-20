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
class WPEC_Compare_Categories_Data
{
	public static function install_database(){
		global $wpdb;
		$collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if( ! empty($wpdb->charset ) ) $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			if( ! empty($wpdb->collate ) ) $collate .= " COLLATE $wpdb->collate";
		}
		$table_compare_categories = $wpdb->prefix. "wpec_compare_categories";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_compare_categories'") != $table_compare_categories){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table_compare_categories}` (
				  `id` int(11) NOT NULL auto_increment,
				  `category_name` blob NOT NULL,
				  `category_order` int(11) NOT NULL,
				  PRIMARY KEY  (`id`)
				) $collate;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}
	
	public static function automatic_add_compare_categories() {
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
	
	public static function get_row($id, $where='', $output_type='OBJECT'){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		if(trim($where) != '')
			$where = ' AND '.$where;
		$result = $wpdb->get_row("SELECT * FROM {$table_name} WHERE id='$id' {$where}", $output_type);
		return $result;
	}
	
	public static function get_maximum_order($where=''){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_categories";
		if(trim($where) != '')
			$where = " WHERE {$where} ";
		$maximum = $wpdb->get_var("SELECT MAX(category_order) FROM {$table_name} {$where}");
		
		return $maximum;
	}
	
	public static function get_count($where=''){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_categories";
		if(trim($where) != '')
			$where = " WHERE {$where} ";
		$count = $wpdb->get_var("SELECT COUNT(id) FROM {$table_name} {$where}");
		
		return $count;
	}
	
	public static function get_results($where='', $order='', $limit ='', $output_type='OBJECT'){
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
	
	public static function insert_row($args){
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
	
	public static function update_row($args){
		global $wpdb;
		extract($args);
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		$category_name = strip_tags(addslashes($category_name));
		
		$query = $wpdb->query("UPDATE {$table_name} SET category_name='$category_name' WHERE id='$category_id'");
		return $query;
		
	}
	
	public static function update_items_order($item_orders=array()){
		if(is_array($item_orders) && count($item_orders) > 0){
			foreach($item_orders as $category_id => $category_order){
				WPEC_Compare_Categories_Data::update_order($category_id, $category_order);
			}
		}
	}
	
	public static function update_order($category_id, $category_order=0){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		$query = $wpdb->query("UPDATE {$table_name} SET category_order='$category_order' WHERE id='$category_id'");
		return $query;
	}
	
	public static function delete_rows($items=array()){
		if(is_array($items) && count($items) > 0){
			foreach($items as $category_id){
				WPEC_Compare_Categories_Data::delete_row($category_id);
			}
		}
	}
	
	public static function delete_row($category_id){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_categories";
		$result = $wpdb->query("DELETE FROM {$table_name} WHERE id='{$category_id}'");
		return $result;
	}
}
?>
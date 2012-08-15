<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Categories Fields Data
 *
 * Table Of Contents
 *
 * install_database()
 * get_row()
 * get_count()
 * get_results()
 * get_unavaliable_field_results()
 * get_maximum_order()
 * update_items_order()
 * update_order()
 * get_catid_results()
 * get_fieldid_results()
 * insert_row()
 * delete_row()
 */
class WPEC_Compare_Categories_Fields_Data{
	function install_database(){
		global $wpdb;
		$collate = '';
		if ( $wpdb->supports_collation() ) {
			if( ! empty($wpdb->charset ) ) $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			if( ! empty($wpdb->collate ) ) $collate .= " COLLATE $wpdb->collate";
		}
		$table_compare_categories_fields = $wpdb->prefix. "wpec_compare_cat_fields";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_compare_categories_fields'") != $table_compare_categories_fields){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table_compare_categories_fields}` (
				  `cat_id` int(11) NOT NULL,
				  `field_id` int(11) NOT NULL,
				  `field_order` int(11) NOT NULL
				) $collate;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}
	
	function get_row($cat_id, $field_id, $output_type='OBJECT'){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_cat_fields";
		$result = $wpdb->get_row("SELECT * FROM {$table_name} WHERE cat_id='$cat_id' AND field_id='$field_id' ", $output_type);
		return $result;
	}
	
	function get_count($where=''){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_cat_fields";
		if(trim($where) != '')
			$where = " WHERE {$where} ";
		$count = $wpdb->get_var("SELECT COUNT(*) FROM {$table_name} {$where}");
		
		return $count;
	}
	
	function get_results($where='', $order='', $limit ='', $output_type='OBJECT'){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_cat_fields";
		$table_fields = $wpdb->prefix. "wpec_compare_fields";
		if(trim($where) != '')
			$where = " WHERE {$where} ";
		if(trim($order) != '')
			$order = " ORDER BY {$order} ";
		if(trim($limit) != '')
			$limit = " LIMIT {$limit} ";
		
		$result = $wpdb->get_results("SELECT * FROM {$table_name} AS cf INNER JOIN {$table_fields} AS f ON(cf.field_id=f.id) {$where} GROUP BY field_id {$order} {$limit}", $output_type);
		return $result;
	}
	
	function get_unavaliable_field_results($order='', $limit ='', $output_type='OBJECT'){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_cat_fields";
		$table_fields = $wpdb->prefix. "wpec_compare_fields";
		if(trim($order) != '')
			$order = " ORDER BY {$order} ";
		if(trim($limit) != '')
			$limit = " LIMIT {$limit} ";
		
		$result = $wpdb->get_results("SELECT f.* FROM {$table_fields} AS f WHERE f.id NOT IN(SELECT DISTINCT cf.field_id FROM {$table_name} AS cf WHERE cf.cat_id > 0)  {$order} {$limit}", $output_type);
		return $result;
	} 
	
	function get_maximum_order($where=''){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_cat_fields";
		if(trim($where) != '')
			$where = " WHERE {$where} ";
		$maximum = $wpdb->get_var("SELECT MAX(field_order) FROM {$table_name} {$where}");
		
		return $maximum;
	}
	
	function update_items_order($cat_id=0, $item_orders=array()){
		if(is_array($item_orders) && count($item_orders) > 0){
			foreach($item_orders as $field_id => $field_order){
				WPEC_Compare_Categories_Fields_Data::update_order($cat_id, $field_id, $field_order);
			}
		}
	}
	
	function update_order($cat_id, $field_id, $field_order=0){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_cat_fields";
		$query = $wpdb->query("UPDATE {$table_name} SET field_order='$field_order' WHERE field_id='$field_id' AND cat_id='$cat_id'");
		return $query;
	}
	
	function get_catid_results($field_id, $where='', $order='', $limit =''){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_cat_fields";
		$table_fields = $wpdb->prefix. "wpec_compare_fields";
		if(trim($where) != '')
			$where = ' AND '.$where;
		if(trim($order) != '')
			$order = " ORDER BY {$order} ";
		if(trim($limit) != '')
			$limit = " LIMIT {$limit} ";
		$result = $wpdb->get_col("SELECT DISTINCT cf.cat_id FROM {$table_name} AS cf INNER JOIN {$table_fields} AS f ON(cf.field_id=f.id) WHERE field_id='$field_id' {$where} {$order} {$limit}");
		return $result;
	}
	
	function get_fieldid_results($cat_id, $where='', $order='', $limit =''){
		global $wpdb;
		$table_name = $wpdb->prefix . "wpec_compare_cat_fields";
		$table_fields = $wpdb->prefix. "wpec_compare_fields";
		if(trim($where) != '')
			$where = ' AND '.$where;
		if(trim($order) != '')
			$order = " ORDER BY {$order} ";
		if(trim($limit) != '')
			$limit = " LIMIT {$limit} ";
		$result = $wpdb->get_col("SELECT DISTINCT cf.field_id FROM {$table_name} AS cf INNER JOIN {$table_fields} AS f ON(cf.field_id=f.id) WHERE cat_id='$cat_id' {$where} {$order} {$limit}");
		return $result;
	}
	
	function insert_row($cat_id, $field_id){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_cat_fields";
		$field_order = WPEC_Compare_Categories_Fields_Data::get_maximum_order("cat_id='".$cat_id."'");
		$field_order++;
		$query = $wpdb->query("INSERT INTO {$table_name}(cat_id, field_id, field_order) VALUES('$cat_id', '$field_id', '$field_order')");
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function delete_row($where){
		global $wpdb;
		$table_name = $wpdb->prefix. "wpec_compare_cat_fields";
		$result = $wpdb->query("DELETE FROM {$table_name} WHERE {$where}");
		return $result;
	}
}
?>

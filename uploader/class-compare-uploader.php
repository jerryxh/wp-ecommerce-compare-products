<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Compare Uploader Class
 *
 * Table Of Contents
 *
 * uploader_init()
 * get_silentpost()
 * upload_input()
 * change_button_text()
 * modify_tabs()
 * inside_popup()
 * uploader_js()
 */
class WPEC_Compare_Uploader {
	
	function uploader_init () {
		register_post_type( 'wpec_compare_images', array(
			'labels' => array(
				'name' => __( 'WPEC Compare Internal Container', 'wpec_cp' ),
			),
			'public' => true,
			'show_ui' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'supports' => array( 'title', 'editor' ),
			'query_var' => false,
			'can_export' => true,
			'show_in_nav_menus' => false
		) );
	}
	
	function get_silentpost ( $option_key='' ) {
		global $wpdb;
		$post_id = 1;
		if ( $option_key != '' ) {
			$args = array( 
				'post_parent' => '0', 
				'post_type' => 'wpec_compare_images', 
				'post_name' => $option_key, 
				'post_status' => 'draft', 
				'comment_status' => 'closed', 
				'ping_status' => 'closed'
			);
			$my_posts = get_posts( $args );
			if ( $my_posts ) {
				foreach ($my_posts as $my_post) {
					$post_id = $my_post->ID;
					break;
				}
			} else {
				$args['post_title'] = str_replace('_', ' ', $option_key);
				$post_id = wp_insert_post( $args );
			}
		}
		return $post_id;
	}
	
	function upload_input ( $option_key, $option_name='', $default_value='', $help_text='', $input_wide='300px',$post_id=0 ) {
		$output = '';
		$value = '';
		
		if ( $post_id == 0 ) {
			$post_id = WPEC_Compare_Uploader::get_silentpost( $option_key );
		}

		$value = get_option( $option_key );

		if ( $default_value != '' && $value == '' ) {
			$value = $default_value;
		}
		
		$output .= '<input type="text" name="'.$option_key.'" id="'.$option_key.'" value="'.esc_attr( $value ).'" class="a3_upload" style="width:'.$input_wide.';" rel="'.$option_name.'" /> ';
		$output .= '<input id="upload_'.$option_key.'" class="a3_upload_button button" type="button" value="'.__( 'Upload', 'wpec_cp' ).'" rel="'.$post_id.'" /> '.$help_text;
		
		$output .= '<div style="clear:both;"></div><div class="a3_screenshot" id="'.$option_key.'_image" style="'.( ( $value == '' ) ? 'display:none;' : 'display:block;' ).'">';

		if ( $value != '' ) {
			$remove = '<a href="javascript:(void);" class="a3_uploader_remove">'.__('Remove', 'wpec_cp').'</a>';

			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );

			if ( $image ) {
				$output .= '<img class="a3_uploader_image" src="' . esc_url( $value ) . '" alt="" />'.$remove.'';
			} else {
				$parts = explode( "/", $value );

				for( $i = 0; $i < sizeof( $parts ); ++$i ) {
					$title = $parts[$i];
				}

				$output .= '';

				$title = __( 'View File', 'wpec_cp' );

				$output .= '<div class="a3_no_image"><span class="a3_file_link"><a href="'.esc_url( $value ).'" target="_blank" rel="a3_external">'.$title.'</a></span>'.$remove.'</div>';

			}
		}

		$output .= '</div>';

		return $output;
	}
	
	function change_button_text( $translation, $original ) {
	    if ( isset( $_REQUEST['type'] ) ) { return $translation; }
	    
	    if ( $original == 'Insert into Post' ) {
	    	$translation = __( 'Use this Image', 'wpec_cp' );
			if ( isset( $_REQUEST['title'] ) && $_REQUEST['title'] != '' ) { $translation =__( 'Use as', 'wpec_cp' ).' '.esc_attr( $_REQUEST['title'] ); }
	    }
	
	    return $translation;
	}
	
	function modify_tabs ( $tabs ) {
		if ( isset( $tabs['gallery'] ) ) { $tabs['gallery'] = str_replace( 'Gallery', __( 'Previously Uploaded', 'wpec_cp' ), $tabs['gallery'] ); }
		return $tabs;
	}
	
	function inside_popup () {
		if ( isset( $_REQUEST['a3_uploader'] ) && $_REQUEST['a3_uploader'] == 'yes' ) {
			add_filter( 'media_upload_tabs', array('WPEC_Compare_Uploader', 'modify_tabs') );
		}
	}
	
	function uploader_js () {
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_style( 'a3-uploader-style', ECCP_URL . '/uploader/uploader.css' );
		wp_enqueue_script( 'a3-uploader-script', ECCP_URL . '/uploader/uploader-script.js', array( 'jquery', 'thickbox' ) );
		wp_enqueue_script( 'media-upload' );
	}
}

if ( is_admin() ) {
	add_action( 'init', array('WPEC_Compare_Uploader', 'uploader_init') );
	add_action( 'admin_print_scripts', array('WPEC_Compare_Uploader', 'inside_popup') );
	add_filter( 'gettext', array('WPEC_Compare_Uploader', 'change_button_text'), null, 2 );
}
?>
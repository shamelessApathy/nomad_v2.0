<?php

if( !defined('fwp_hero_main_theme_url') ) {
    define( 'fwp_hero_main_theme_url', get_template_directory_uri() );
}

function FastWP_Hero_getPostIdAndTitle($post_type = 'page', $value_first = false) {
		global $wpdb;
		$sql = $wpdb->prepare("SELECT post_title, ID from $wpdb->posts WHERE `post_type` = '%s' AND `post_status`='publish' ORDER BY `post_title` ASC;",
			$post_type);
		$result = $wpdb->get_results( $sql, ARRAY_A );
		$output = array();
		if(isset($result) && is_array($result)){
			foreach($result as $item){
				if($value_first == true){
					$key = $item['post_title'];
					$value=$item['ID'];
				}else {
					$key = $item['ID'];
					$value=$item['post_title'];
				}
				$output[$key] = $value;
			}
		}
		return $output;
}
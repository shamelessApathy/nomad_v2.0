<?php
/*
Plugin Name: FastWP Hero Theme extension
Plugin URI: http://themeforest.net/user/FastWP
Description: FastWP Theme extension for fastwp themes. This plugin is required to initialize custom posts, custom taxonomies and theme shortcodes
Author: Ionut Stoica
Version: 1.0
Author URI: http://fastwp.net
*/
if(!class_exists('FastWP_Hero_Functions_Plugin')){
	class FastWP_Hero_Functions_Plugin {
		/**
		Register custom defined post types.
		**/
		static function register_custom_posts(){
			global $fwp_custom_posts;
			if(!isset($fwp_custom_posts) || !is_array($fwp_custom_posts)) return;
			foreach($fwp_custom_posts as $post_type=>$details){
				$args 			= $details['settings'];
				$args['labels'] = array(
					'menu_name' 	=> $details['name'],
					'name'         	=> $details['multiple'],
					'singular_name'	=> $details['single'],
					);

				register_post_type( $post_type, $args );
			}
		}
		/**
		Register custom defined taxonomies.
		**/
		static function register_custom_taxonomy(){
			global $fwp_custom_taxonomies;
			if(!isset($fwp_custom_taxonomies) || !is_array($fwp_custom_taxonomies)) return;
			foreach($fwp_custom_taxonomies as $slug=>$details){
				$args =  $details['settings'];
	  			register_taxonomy($slug, $details['post_type'], $args);
			}
		}

		/**
		Register custom defined shortcodes.
		**/
		static function register_shortcodes(){
			global $fwp_shortcodes;

			if(!isset($fwp_shortcodes) || !is_array($fwp_shortcodes) || count($fwp_shortcodes) < 1) return;
			$class_name = 'fwp_theme_shortcodes';
			if(!class_exists($class_name)){ return; }
			foreach($fwp_shortcodes as $k=>$v){
				$shortcodeFunction = sprintf("FWP_Shortcode_%s",$v);
				if(function_exists($shortcodeFunction)){
					add_shortcode($k, sprintf("FWP_Shortcode_%s",$v));
				}
			}
		}
	}

	/**
	Register cool stuff here
	**/
	add_action('init', array('FastWP_Hero_Functions_Plugin', 'register_custom_posts'));
	add_action('init', array('FastWP_Hero_Functions_Plugin', 'register_custom_taxonomy'));
	add_action('init', array('FastWP_Hero_Functions_Plugin', 'register_shortcodes'));
}
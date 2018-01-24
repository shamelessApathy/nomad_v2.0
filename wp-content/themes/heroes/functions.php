<?php

define( 'fwp_core_version', '1.0.5');
define( 'fwp_core_uri', sprintf('%s/fastwp/', get_template_directory()) );
defined('fwp_main_theme_url') or define('fwp_main_theme_url', get_template_directory_uri());
defined('fwp_child_theme_url') or define('fwp_child_theme_url', get_stylesheet_directory_uri());
defined('fwp_shortcode_classname') or define('fwp_shortcode_classname', 'fwp_theme_shortcodes');

define( 'fwp_lib_uri', fwp_core_uri . 'lib/');
define( 'fwp_lib_url', fwp_main_theme_url . '/fastwp/lib/');
define( 'fwp_debug', false);
defined('fwp_menu_child_class') or define('fwp_menu_child_class', 'dropdown-menu child');
defined('fwp_autoload_scripts') or define('fwp_autoload_scripts', false);
defined('fwp_autoload_styles') or define('fwp_autoload_styles', true);

require_once get_template_directory() . '/fastwp.theme.functions.php';

// Disable VC Front End Editor
if(function_exists('vc_disable_frontend')){
	vc_disable_frontend();
}

if(!isset($fwp_custom_js)){
	global $fwp_custom_js;
	$fwp_custom_js = array();
}

if(!isset($fwp_demo_found)){
	global $fwp_demo_found;
	$fwp_demo_found = false;
}

if(!isset($fwp_raw_js)){
	global $fwp_raw_js;
	$fwp_raw_js = '';
}

require_once fwp_core_uri . 'fastwp.core.php';
require_once fwp_core_uri . 'fastwp.core.functions.php';
require_once fwp_core_uri . 'fastwp.core.actions.php';
require_once fwp_core_uri . 'fastwp.core.vc-config.php';
require_once fwp_core_uri . 'fastwp.user.interface.php';
require_once fwp_core_uri . 'fastwp.abstract.php';
require_once fwp_core_uri . 'fastwp.settings.php';
require_once fwp_core_uri . 'fastwp.utils.php';

if(is_admin()){
	require_once fwp_lib_uri . 'php/admin.interface.php';
	require_once fwp_lib_uri . 'php/admin.metabox.php';
	require_once fwp_lib_uri . 'php/plugin.activator.php';
	require_once fwp_core_uri . 'fastwp.admin.menu.php';
}

/**
 Set up the content width value based on the theme's design and stylesheet.
 Deprecated setting while this template is responsive !
 **/

if (!isset($content_width))
	$content_width = 980;

/**
Single pages must have comment form, so this script is mandatory
**/

if ( is_singular() ) wp_enqueue_script( "comment-reply" );

/**
Set default visual composer behavior
**/

if(function_exists('vc_set_default_editor_post_types')){
	$list = array('page', 'fwp_portfolio');
	vc_set_default_editor_post_types( $list );
}

<?php
/*
Plugin Name: FastWP Redux extension
Plugin URI: http://themeforest.net/user/FastWP
Description: Redux for Here theme by FastWP
Author: FastWP
Version: 1.0
Author URI: http://fastwp.net
*/

$dir = plugin_dir_path( __FILE__ );
require_once(ABSPATH .'wp-includes/pluggable.php');
require_once $dir  . 'Functions.php';
require_once $dir  . 'ReduxCore/loader.php';
require_once $dir  . 'ReduxCore/framework.php';
require_once $dir . 'config/fastwp.redux.config.php';
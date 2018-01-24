<?php

if(is_page()){
    $currentTemplate = FastWP::getPageTemplate();
	if($currentTemplate === 'template-one-page.php') fwp_settings::set_var('do_skip_menu', true);
}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png" />
<?php wp_head(); ?>
</head>

<?php

$extra_body = array();

$custom_body_class = fwp_settings::get_var('body_class');
if( !empty( $custom_body_class ) ) {
    $extra_body[] = $custom_body_class;
}

?>

<body id="bigWrapper" <?php body_class( implode( ' ', array_filter( $extra_body ) ) ); ?> data-spy="scroll" data-target=".navbar-default" data-offset="100">

<?php

do_action('fwp_before_top_menu');
if( !fwp_settings::get_var('do_skip_menu') ) {

?>

<header class="fwp-menu-container">
<?php UI_displayMenu('', 'nav navbar-nav', true); ?>
</header>

<?php

}

do_action('fwp_after_top_menu');
UI_showPreloader();
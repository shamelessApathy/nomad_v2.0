<?php

/* Template Name: Normal Page */

get_header();
the_post();
do_action('fwp_before_page_content');

?>

<section class="fwp-page-content">
<?php

    $show_container = fwp_settings::get_var('show_container');

    if( $show_container ) echo '<div class="container-text-separator">';

	$temp_content = get_the_content();
    $temp_content = apply_filters('the_content', $temp_content);
	$temp_content = apply_filters('fastwp_filter_section_content', $temp_content, $post);
	echo $temp_content;

	wp_link_pages();

    if( $show_container ) echo '</div>';

?>
</section>

<?php

do_action('fwp_after_page_content');
get_footer();
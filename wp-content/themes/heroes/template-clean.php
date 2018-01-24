<?php

/* Template Name: Empty Page */

fwp_settings::set_var('do_skip_menu', true);

get_header();
the_post();

?>

<section id="page-content">

<?php

    $temp_content = get_the_content();
    $temp_content = apply_filters('the_content', $temp_content);
    $temp_content = apply_filters('fastwp_filter_section_content', $temp_content, $post);
    echo $temp_content;

    wp_link_pages();

?>

</section>

<?php get_footer(); ?>
<?php

get_header();
the_post();
do_action('fwp_before_page_content');

?>

<section class="fwp-page-content">
<?php

    echo '<div class="container-text-separator">';

    echo '
    <div class="container">

    <h2>' . get_the_title() . '</h2>';

	$temp_content = get_the_content();
    $temp_content = apply_filters('the_content', $temp_content);
	$temp_content = apply_filters('fastwp_filter_section_content', $temp_content, $post);
	echo $temp_content;

	wp_link_pages();

    comments_template();

    echo '</div>
    </div>';

?>
</section>

<?php

do_action('fwp_after_page_content');
get_footer();
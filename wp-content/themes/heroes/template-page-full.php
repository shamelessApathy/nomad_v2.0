<?php

/* Template Name: Full Width */

$fwp_pageClass = fwp_settings::get_var('fwp_pageClass');

get_header();
the_post();
do_action('fwp_before_page_content');

//$fwp__meta 		= get_post_meta( get_the_ID(), '_fwp_meta', true );

$fw_pageClass  = isset( $fwp_pageClass ) ? ' ' . $fwp_pageClass : '';
$fwp_pageClass = apply_filters('fwp_page_class', 'page-content' . $fwp_pageClass);

?>

<section id="page-content" class="<?php echo esc_attr($fwp_pageClass); ?>">

<div class="row content">

<?php

    $temp_content = get_the_content();
	$temp_content = apply_filters('the_content', $post->post_content);
	$temp_content = apply_filters('fastwp_filter_section_content', $temp_content, $post);
	echo $temp_content;

    wp_link_pages();

?>
</div>

</section>

<?php

do_action('fwp_after_page_content');
get_footer();
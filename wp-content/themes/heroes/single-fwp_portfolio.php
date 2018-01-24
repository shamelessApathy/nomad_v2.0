<?php if( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) { ?>

<div id="transmitter">
<div class="container">

<?php

/* Make sure visual oomposer CSS is loaded on ajax called portfolio items */
$custom_css   = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
if( isset( $custom_css ) && !empty( $custom_css ) ){
    echo '<style>' . $custom_css . '</style>';
}

the_post();

?>

<?php the_content(); ?>

</div>
<div class="is-hidden">

<?php wp_footer(); ?>

</div>
</div>

<?php

FastWP_UI::add_custom_css();

} else {

get_header();

// load mandatory scripts for projects
do_action('fwp_enqueue_script', 'custom,jquery.hc-sticky.min');

do_action('fwp_before_page_content');

// $fwp_options = fwp_get_option( array( '' ) );

// Start the
while ( have_posts() ) :
the_post();

$terms = array();

$get_terms =  get_the_terms( get_the_ID(), 'portfolio-category' );
if( !empty( $get_terms ) ) {
    foreach( $get_terms as $term ) {
        $terms[$term->term_id] = $term->name;
    }
}

$fwp__meta  = get_post_meta( get_the_ID(), '_fwp_meta', true);

if( !empty( $fwp__meta['hero_section'] ) ) { ?>

<section id="projectPageIntro" data-stellar-background-ratio="0.8">
    <div class="black-overlay"></div>
    <div class="container">
        <div class="row singleTitle">
            <div class="col-md-12 text-left">
                <h1 class="minimal"><?php the_title(); ?></h1>
                <h5 class="minimal"><small><?php echo implode( '/', $terms ); ?></small></h5>
            </div>
        </div>
    </div>
</section>

<?php } ?>

<section id="projectPage">
<div class="container container-ptf">
<?php

the_content();

fastwp_post_nav();

?>
</div>
</section>

<?php

endwhile;

do_action('fwp_after_page_content');
get_footer();

}

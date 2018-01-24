<?php

/**
* The template for displaying all single posts
*/

get_header();

do_action('fwp_enqueue_script', 'scripts'); // Conditional load scripts

$mainContentClass = (is_active_sidebar( 'sidebar-1' )  && fastwp_sidebar_position() != '') ? 'col-md-9 col-xs-12' : 'col-md-12';
do_action('fwp_before_page_content');

if( isset($fwp_data['fwp_single_type']) && $fwp_data['fwp_single_type'] == 'image' ) {
    setup_postdata($post);
}

echo fastwp_blog_header('blog');   

if('post'==  get_post_type()) :

?>

<section id="blogContent" class="group">
<div class="container pBottom-110">
<div class="row">

<?php else: ?>

<section  class="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php endif; ?>

<?php if(is_active_sidebar( 'sidebar-1' ) && 'left' == fastwp_sidebar_position()  ):
echo '<div class="col-md-3 col-xs-12 col-md-12">';
    get_sidebar();
echo '</div>';
endif;

if('post'==  get_post_type()) : ?>
<div class="<?php echo esc_attr( $mainContentClass ); ?>">
<div class="blogPost3">
<div class="grid-sizer-blog-1"></div>
<?php endif;

if ( have_posts() ) :
while ( have_posts() ) : the_post();
    get_template_part('extend-helpers/content', get_post_format() );
endwhile;
			
else :
get_template_part('extend-helpers/content', 'none' );
endif;

if('post'==  get_post_type()) : ?>

</div>

<?php
comments_template();
fastwp_post_nav();
?>

</div>

<?php endif;

if(is_active_sidebar( 'sidebar-1' ) && 'right' == fastwp_sidebar_position() ) :
echo '<div class="col-md-3 col-xs-12 col-md-12">';
    get_sidebar();
echo '</div>';
endif;

if('post' ==  get_post_type()) : ?>

</div>
</div>

</section>

<?php else: ?>

</section>

<?php

endif;

do_action('fwp_after_page_content');

get_footer();
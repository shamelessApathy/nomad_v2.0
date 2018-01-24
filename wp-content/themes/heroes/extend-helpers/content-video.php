<?php

/**
 * The template for displaying posts in the Video post format
*/

$fwp_options = fwp_get_option( array( 'fwp_single_type' ) );

?>

<div id="post-<?php the_ID(); ?>"   <?php post_class(fastwp_blog_type()); ?> ><!-- Post item -->
	<?php $video = fastwp_video_post(); ?>
	
	<?php if(!is_single()): ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		   <?php if($video): ?>
		   	<div class="fwp-video-container">
				<?php if('blogPost' == fastwp_blog_type()): ?>
					<iframe width="100%" height="350" src="<?php echo esc_url($video); ?>"></iframe>
				<?php else: ?>
					<iframe width="100%" height="400" src="<?php echo esc_url($video); ?>"></iframe>
				<?php endif;?>
			</div>
		   <?php elseif ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
				<div class="post-thumbnail">
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
				</div> 
			<?php endif; ?>
		</a>
	<?php else: ?>
		<?php if($video): ?>
			<div class="fwp-video-container">
			<iframe width="100%" height="400" src="<?php echo esc_url($video); ?>"></iframe>
			</div>
	   <?php elseif (!(isset($fwp_options['fwp_single_type'] ) && $fwp_options['fwp_single_type']) &&  has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
				<div class="post-thumbnail">
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
				</div> 
	   <?php endif; ?>
	<?php  endif; ?>
	<?php get_template_part('extend-helpers/content','common' ); ?> 
</div><!-- Post item -->

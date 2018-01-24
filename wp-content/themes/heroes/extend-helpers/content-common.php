<?php

$fwp_options = fwp_get_option( array( 'fwp_blog_author_meta', 'fwp_blog_category_meta', 'fwp_blog_date_meta' ) );

?>

<div class="post-content"><!-- Post content wrapper -->
		<div class="post-title"><!-- Post title -->
			<?php echo fastwp_post_title(); ?>
		</div><!-- Post title -->
		
		<div class="post-info"> <!-- Post meta -->
			<div class="postBy">
				<p>
					<i class="fa fa-pencil"></i>
					<?php if(!isset($fwp_options['fwp_blog_author_meta']) || (isset($fwp_options['fwp_blog_author_meta']) && $fwp_options['fwp_blog_author_meta'] != false)){
					 esc_html_e('Posted by ','heroes'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a> <?php esc_html_e('in ','heroes');
					} 
					  if(!isset($fwp_options['fwp_blog_category_meta']) || (isset($fwp_options['fwp_blog_category_meta']) && $fwp_options['fwp_blog_category_meta'] != false)){
					  	fastwp_category_list();
					  }
					  if(!isset($fwp_options['fwp_blog_date_meta']) || (isset($fwp_options['fwp_blog_date_meta']) && $fwp_options['fwp_blog_date_meta'] != false)){
					  	esc_html_e(' on ','heroes');
					  	the_time( get_option( 'date_format' ) ); 
					}
					the_tags( '<span class="o-post-tags"> '.esc_html__('Tags: ','heroes'), ' / ', '</span>' );
					?>
				</p>
			</div>
		</div> <!-- Post meta  -->
        <div class="lineSeparator"></div>
		<!--Post content -->
		<?php if(!is_single()): ?>
			<p class="excerpt">
				<?php the_excerpt(); ?>
			</p>
		<?php else: ?>
			<?php the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'heroes' ) ); ?>
		<?php endif; ?>
	  	<?php if(!is_single()): ?>
			<a class="btn btn-default btn-black center-block" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','heroes'); ?></a>
		<?php endif; ?>
		<?php 
			if(is_single()){  wp_link_pages(array('before' => '<p class="o-post-paging">' . esc_html__( 'Pages:', 'heroes' ), 'pagelink'=>'<span class="post-paging--page">%</span>')); }
		?>
		<!--Post content -->
</div> <!-- Post-content wrapper -->

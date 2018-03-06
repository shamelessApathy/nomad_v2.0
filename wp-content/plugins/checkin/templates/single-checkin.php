<?php
/*
*	Template name: Single Checkin
*	Template used for the single Checkin visualisation.
*/

$post_id = get_the_ID();
$post_ = get_post( $post_id );
$post_featured_image = get_the_post_thumbnail_url( $post_id, "full" );
$venue_id = get_post_meta( $post_id, "venue_id", true );

get_header();
?>
<div id="post-<?php echo $post_id ?>" class="post-container">
	<div id="post-header" class="post-header" style="background-image: url(<?php echo $post_featured_image; ?>);">
		<h1 class="header"><?php echo $post_->post_title; ?></h1>
		<?php if ( isset( $venue_id ) && !empty( $venue_id ) ) { ?><h2 class="sub-header">@</h2><?php } ?>
	</div>
	<div id="post-meta" class="post-meta">
		<span class="meta"><a href="<?php echo get_author_posts_url( $post_->post_author ); ?>"><?php echo get_the_author( $post_->post_authors ); ?></a></span>
		<span class="dotter">&bull;</span>
		<spa class="meta"><?php echo date( "H:i d-M-Y", strtotime( $post_->post_date ) ); ?></span>
	</div>
	<div id="post-content" class="post-content">
		<?php echo $post_->post_content; ?>
	</div>
	<div id="post-venue-container" class="post-venue-container" venue-id="<?php echo $venue_id; ?>"></div>
</div>
<script type="text/javascript">
jQuery( document ).ready(function(){ getVenue( "<?php echo $venue_id; ?>" ); });
</script>
<?php get_footer(); ?>

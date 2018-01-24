<?php

if (!function_exists('fastwp_is_blog')) {

	function fastwp_is_blog() {
		if (!is_front_page() && is_home())
			return TRUE;
	}

}

if (!function_exists("fastwp_blog_type")) {
	function fastwp_blog_type() {
		global $fwp_data;
		if(is_single())
		return "blogPost3";
		if (isset($_GET['blog_type'])) {

			switch($_GET['blog_type']) {
				case 1 :
					return "blogPost3";
					break;
				case 2 :
					return "blogPost2";
					break;
				case 3 :
					return "blogPost";
					break;
			}
		}
		return (isset( $fwp_data['fwp_blog_type']))?  $fwp_data['fwp_blog_type'] : "blogPost";
	}
}

if (!function_exists("fastwp_sidebar_position")) {
	function fastwp_sidebar_position() {
		global $fwp_data;
		if (isset($_GET['sidebar_position'])) {
				return $_GET['sidebar_position'];
		}
		return (isset( $fwp_data['fwp_sidebar_pos']))?  $fwp_data['fwp_sidebar_pos'] : "right";
	}
}
if (!function_exists("fastwp_blog_wrapper")) {
	function fastwp_blog_wrapper() {
		switch(fastwp_blog_type()) {
			case "blogPost" :
				return "blogPostsWrapper";
				break;
			case 'blogPost2' :
				return "blogPostsWrapper2";
				break;
		}
	}

}
if (!function_exists('fastwp_grid_sizer')) {
	function fastwp_grid_sizer() {
		switch(fastwp_blog_type()) {
			case "blogPost" :
				return "grid-sizer-blog-3";
				break;
			case 'blogPost2' :
				return "grid-sizer-blog-2";
				break;
		}
	}
}

if ( ! function_exists( 'fastwp_category_list' ) ) {
	function fastwp_category_list($strip_tags = false)
	{
		$categories_list= get_the_category_list( esc_html__( ' / ', 'heroes' ) );
		if($strip_tags == true) {
			echo strip_tags($categories_list);
		}else {
			echo $categories_list;
		}
	}
}
if ( ! function_exists( 'fastwp_post_title' ) ) {
	function fastwp_post_title()
	{
		global $post;
		if(!isset($post->ID)) return;
		if(!is_single()){
			$html = '<%s class="minimal"><a href="%s" alt="%s"> %s </a></%s>';
			if("blogPost3" == fastwp_blog_type()){
				$tag = 'h4';
			}else{
				$tag = 'h4';
			}
			return sprintf($html,$tag, get_permalink($post->ID), $post->post_title, apply_filters('the_title',$post->post_title), $tag );
		}else{
			$html =  '<h4 class="minimal">%s</h4>';
			return sprintf($html,$post->post_title);
		}
	}
}


if ( ! function_exists( 'post_link_attributes' ) ) :
add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');

function post_link_attributes($output) {
	global $fwp_post_navigation_style;
	if($fwp_post_navigation_style == 2){
		$code = 'class="new-style-nav"';
	}
	else {
		$code = 'class="btn btn-default btn-black"';
	}
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}
endif;

if ( ! function_exists( 'fastwp_post_nav' ) ) :
function fastwp_post_nav(){
echo '<hr>';
fastwp_set_navigation_style(1);
echo '<div class="clearfix paginationRow">';
ob_start();
previous_post_link( '<div class="col-xs-6">%link</div>', 'Prev');
$prev = ob_get_clean();
$class = (strlen($prev) > 5)? 'col-xs-6' : 'col-xs-12';
echo $prev;
next_post_link( '<div class="'.$class.' text-right">%link</div>', 'Next' );
echo '</div>';
}
endif;

if ( ! function_exists( 'fastwp_post_nav_arrow' ) ) :
function fastwp_post_nav_arrow($grid_action){
	fastwp_set_navigation_style(2);
	echo '<div class="row PaddingTop30">';
		previous_post_link( '<div class="col-xs-4">%link</div>', '<i class="fa fa-angle-left fa-2x"></i>');
		echo '<div class="col-xs-4 text-center"><a href="'.$grid_action.'"><i class="fa fa-th fa-2x"></i></a></div>';
		next_post_link( '<div class="col-xs-4 text-right">%link</div>', '<i class="fa fa-angle-right fa-2x"></i>' );
	echo '</div>';
}
endif;

if ( ! function_exists( 'fastwp_get_category_list' ) ) :
function fastwp_get_category_list($id = null, $separator = ' / '){
	$id = ($id != null)? $id : get_the_ID();
	$tl = wp_get_object_terms($id, 'portfolio-category');
	$cats 		= array();
	foreach($tl as $term){
		$cats[] = $term->name;
	}
	return implode($separator, $cats);
}

endif;

if ( ! function_exists( 'fastwp_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function fastwp_paging_nav() {
	global $wp_query;
	// Don't print empty markup if there's only one page.
	 //print_r($wp_query->max_num_pages);
	if ( $wp_query->max_num_pages < 2 )
		return;
		$nextpostlink =  explode('"', get_next_posts_link());
		$nextpostlink = (isset($nextpostlink[1]))? $nextpostlink[1] : false;
		$previouspostlink = explode('"', get_previous_posts_link());
 		$previouspostlink = (isset($previouspostlink[1]))? $previouspostlink[1] : false;
	?>
	    <hr>
		<div class="row">
			<br>
			<br>
			<?php
			$has_prevlink = false;
			if ( get_previous_posts_link() ) : ?>
				<div class="col-xs-6">
					<a class="btn btn-default btn-black" href="<?php echo $previouspostlink; ?>"> <?php esc_html_e('&lt; Previous','heroes'); ?></a>
				</div>
			<?php
			$has_prevlink = true;
			endif; ?>
			<?php if ( get_next_posts_link() ) :
				$classNum = ($has_prevlink)? 6 : 12;
			?>
				<div class="col-xs-<?php echo $classNum; ?> text-right">
					<a class="btn btn-default btn-black" href="<?php echo $nextpostlink; ?>"> <?php esc_html_e('Next &gt;','heroes'); ?></a>
				</div>
			<?php endif; ?>
		</div>

	<?php
}
endif;

if ( ! function_exists( 'fastwp_video_post' ) ) :

function fastwp_video_post() {
	    global $post;
		if(!isset($post->ID)) return;

		$details 	= get_post_meta($post->ID,'_fwp_meta', true);
		$video 		= (isset($details['video']))? $details['video'] : '';
		if($video != ''):
				if(substr_count($video, 'vimeo.com') == 1){
					$videoURL = str_replace('http://vimeo.com/','http://player.vimeo.com/video/', $video);

				}else if(substr_count($video, 'youtu.be') == 1 ||substr_count($video, 'youtube.com') == 1){
					$videoURL = str_replace('/watch?v=','/embed/', $video);
				}
		return $videoURL;
		endif;
		return false;
}
endif;
if(!function_exists("fastwp_gallery_post")):

	function fastwp_gallery_post() {
		global $post;
		if(!isset($post->ID)) return;

		$details 	= get_post_meta($post->ID,'_fwp_meta', true);
		$photos = (isset($details['gallery']))? array_filter($details['gallery']) : array();

		$gallery = '';
		$posturl='#';
		if(!is_single()){
			$posturl = get_permalink($post->ID);
		}

		if(count($photos) > 0){
			foreach($photos as $photo){
				if(trim($photo) == '') continue;
				$gallery .= '<a href="'. $posturl .'">
                               <img class="img-responsive" src="' .esc_url(trim($photo)).' " alt="image">
                            </a>';
			}
		}

		if($gallery!='') return sprintf('<div id="owl-blog-single" class="owl-carousel">%s</div>', $gallery);

	   return false;

	}
endif;
if ( ! function_exists( 'fastwp_audio_post' ) ) :
	function fastwp_audio_post() {
		global $post;
		if(!isset($post->ID)) return;

		$details 	= get_post_meta($post->ID,'_fwp_meta', true);
		$audio 		= (isset($details['audio']))? $details['audio'] : '';
		if($audio != ''):
					$url = urlencode($audio);
			return $url;
		endif;
		 return false;
	}
endif;
if(!function_exists('fastwp_blog_header')){
	function fastwp_blog_header($type){
		global $fwp_data;

		if( empty( $fwp_data['fwp_show_blog_hero'] ) || ( empty( $fwp_data['fwp_blog_description_page'] ) && empty( $fwp_data['fwp_show_blog_title'] ) ) ) {
			return '<div style="height:110px; width:100%"></div>';
		}

		$img = '<img src="'.get_stylesheet_directory_uri().'/assets/img/separatorBlack.png" class="img-responsive center-block separator" alt="separator">';
		$description  = (isset($fwp_data['fwp_blog_description_page']) && !empty($fwp_data['fwp_blog_description_page']))? FastWP::getPageContent($fwp_data['fwp_blog_description_page'], true) : '';
		$title = (isset($fwp_data['fwp_default_blog_title']) && !empty($fwp_data['fwp_default_blog_title']))? esc_attr($fwp_data['fwp_default_blog_title']) : esc_html__('Blog','heroes');
		$title_markup = '<h2 class="minimal" data-scroll-reveal="enter top move 10px over 1s after 0.2s">%s</h2>';
		$html = '<section id="blogIntro">
            <div class="container">
                <!--header-->
                <div class="row sectionIntro">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        %s
                        %s
                        %s
                    </div>
                </div>
                <!--end header-->
            </div>

        </section>';
        $finalTitle = (isset($fwp_data['fwp_show_blog_title']) && $fwp_data['fwp_show_blog_title'] == 0)? '' : sprintf($title_markup, $title);
        if($description == '' && $finalTitle == '') return '<div class="u-top-spacing"></div>';
		return sprintf($html,$finalTitle,$description,$img);
	}
}

if(!function_exists('fastwp_post_separator')):

	  function fastwp_post_separator(){
	  	global $postcount, $wp_query;
	  	if('blogPost3' == fastwp_blog_type()){
		  	$maxposts = get_option('posts_per_page');
			$url = (defined('child_theme_url'))? child_theme_url : get_template_directory_uri();
			if($wp_query->current_post < $maxposts -1 &&  $wp_query->current_post < $wp_query->post_count -1 ){
				?>
					<img id="separator-<?php echo esc_attr($postcount); ?>" src="<?php echo esc_url($url); ?>/assets/img/separatorBlack.png" class="img-responsive center-block separator blogArticlesSeparator" alt="separator">
				<?php
			}else{
				$postcount = 0;
				return FALSE;
			}
	  }
	return FALSE;
  }
endif;

if ( ! function_exists( 'fastwp_search_form' ) ) :
function fastwp_search_form( $form ) {
    $form = '
		<form role="search" method="get" id="searchform" class="form-inline form"  action="' . home_url( '/' ) . '" >
		   <div class="input-group">
			    <input type="text" name="s" value="' . get_search_query() . '" class="form-control" placeholder="'.esc_html__('SEARCH...','heroes').'"  />
			    <span class="input-group-addon">
			    	<button class="search-button animate" type="submit" title="Start Search"><i class="fa fa-search"></i></button>
			    </span>
		    </div>
	    </form>
   ';
    return $form;
}
add_filter( 'get_search_form', 'fastwp_search_form' );
endif;

if( ! function_exists('fastwp_comment_form')):

	function fastwp_comment_form()
	{
		global $post;
		if(!isset($post->ID)) return;

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$user_identity = esc_attr( $commenter['comment_author']);
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$required_text = esc_html__('Field is required', 'heroes');
		$args = array(
		  'id_form'           => 'contact_form',
		  'id_submit'         => 'submit',
		  'class_submit'     =>  'btn btn-default btn-black',
		  'title_reply'       => esc_html__( 'Leave a comment', 'heroes' ),
		  'title_reply_to'    => esc_html__( 'Leave a Reply to %s', 'heroes' ),
		  'cancel_reply_link' => esc_html__( 'Cancel Reply', 'heroes' ),
		  'label_submit'      => esc_html__( 'Post Comment', 'heroes' ),

		  'comment_field' =>  '<div class="col-md-12" style=""><label for="comments"  ><textarea id="comments" name="comment" cols="45" rows="8" class="comment-field" aria-required="true" placeholder="'.esc_html_x( 'Comment', 'noun', 'heroes' ).'">' .
		    '</textarea></label></div>',

		  'must_log_in' => '<p class="must-log-in">' .
		    sprintf(
		     fwp_utils::fwp_escape(__( 'You must be <a href="%s">logged in</a> to post a comment.', 'heroes' ) ),
		      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		    ) . '</p>',

		  'logged_in_as' => '<p class="logged-in-as">' .
		    sprintf(
		    fwp_utils::fwp_escape(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'heroes' ) ),
		      admin_url( 'profile.php' ),
		      $user_identity,
		      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
		    ) . '</p>',

		  'comment_notes_before' => '<p class="comment-notes"> ' .
		    esc_html__( 'Your email address will not be published.', 'heroes' ) . ( $req ? $required_text : '' ) .
		    '</p>',

		  'comment_notes_after' => '<p class="form-allowed-tags">' .
		    sprintf(
		    esc_html__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'heroes' ),
		      ' <code>' . allowed_tags() . '</code>'
		    ) . '</p>',

		  'fields' => apply_filters( 'comment_form_default_fields', array(

		    'author' =>
		      '<div class="col-md-12 name" style="">' .
		      '<label for="name" style=""> ' .

		      '<input id="name" class="name-field" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		      '" size="30"' . $aria_req . '  placeholder="'. esc_html__( 'Name', 'heroes' ).'"/></label></div>',

		    'email' =>
		      '<div class="col-md-6 email-filed" style="">
		      <label for="email">' .

		      '<input id="email" class="email-field" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		      '" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Email', 'heroes' ) . '" /></lable></div>',

		    'url' =>
		      '<div class="col-md-6 webiste-url" style="">
		       <label for="website">' .
		      '<input id="website" name="url" class="website-field"  type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		      '" size="30" placeholder="' .  esc_html__( 'Website', 'heroes' ) . '" /> </label></div>'
		    )
		  ),
		);
		return comment_form( $args, $post->ID );
	}
endif;


add_action( 'comment_form_top', 'fastwp_pre_comment_text' );
function fastwp_pre_comment_text() {
	echo '<div class="row test">';
}
add_action( 'comment_form', 'fastwp_after_comment_text' );
function fastwp_after_comment_text() {
	echo '</div>';
}
function fastwp_comment_form_submit_button($button) {
	$button =
		'<input name="submit" type="submit" class="submit btn btn-default btn-black"  id="[args:id_submit]" value="[args:label_submit]" />' .
		get_comment_id_fields();
	return $button;
}
apply_filters('comment_form_submit_button', 'fastwp_comment_form_submit_button');


if ( ! function_exists( 'fastwp_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own fastwp_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since fastwp 1.0
 *
 * @return void
 */
function fastwp_comment( $comment, $args, $depth ) {
	global $post;
	if(!isset($post->ID)) return;
 $GLOBALS['comment'] = $comment;
 //print_r($comment->comment_type);
 switch ( $comment->comment_type ) :
  case 'pingback' :
  case 'trackback' :
  // Display trackbacks differently than normal comments.
 ?>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="li-comment-<?php comment_ID(); ?>">
 	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
  <p><?php esc_html_e( 'Pingback:', 'heroes' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'heroes' ), '<span class="edit-link">', '</span>' ); ?></p>
 <?php
   break;
  default :
  // Proceed with normal comments.

 ?>
 	<div class="media" id="li-comment-<?php comment_ID(); ?>">
 		<div class="media-left">
			<?php echo get_avatar( $comment, 90); ?>
		</div>
		<div class="media-body">
			<h5 class="media-heading">
                <?php
                   echo  get_comment_author();
                 ?>
            </h5>
            <p>
            	<a>
            	 <?php printf( esc_html__( '%1$s at %2$s,', 'heroes' ), get_comment_date('F j, Y'), get_comment_time() );?>
            	 <?php if(comments_open( $post->ID )):?>
            	</a>
						<?php echo " &#183; ";
							    echo  comment_reply_link( array_merge( $args, array( 'reply_text' =>  esc_html__( 'Reply', 'heroes' ), 'before'=>'', 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
								endif;
		    				 ?>
            </p>
            <div class="blogPostSeparator"></div>
            <?php if ( '0' == $comment->comment_approved ) : ?>
			     	<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'heroes' ); ?></p>
			  <?php else: ?>
			  <?php comment_text(); ?>
			  <?php endif; ?>

 <?php
  break;
 endswitch; // end comment_type check
}
endif;
if(!function_exists('fastwp_comment_close_tag')):
	function fastwp_comment_close_tag(){
		 ?>
			</div></div>
		<?php
	}
endif;

if(!function_exists('fastwp_widgets_init')):
function fastwp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Widget Area', 'heroes' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'heroes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'fastwp_widgets_init' );
endif;


if(!function_exists('fastwp_set_navigation_style')):
function fastwp_set_navigation_style( $new_style) {
	global $fwp_post_navigation_style;
	$fwp_post_navigation_style = $new_style;
}
endif;
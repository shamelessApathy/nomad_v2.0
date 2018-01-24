<?php

class fwp_theme_shortcodes {

	public static function HeroLatestProjects($atts, $content){
		extract(shortcode_atts(array(
			'count'			=> '3',
			'grid'			=> '4',
			'target'		=> '_blank',
			'extra_class'	=> '',
			'include'		=> '',
			'exclude'		=> '',
			'order'			=> 'DESC',
			'orderby' 		=> 'post_date',
			'animated' 		=> 'true',
            'more_label'    => 'More',
			'animation' 	=> 'enter right move 10px over 1s after 0.2s',
            'include_cats'  => '',
            'exclude_cats'  => ''
		), $atts));
	
		$animated 			= apply_filters('fwp_animation_enable', $animated);

		$finalAnimation 	= ( $animated == 'true' && $animation != '' ) ? sprintf( 'data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ) : '';

        $args = array(
            'numberposts' 		=> $count,
        	'posts_per_page' 	=> $count,
        	'post_status' 		=> 'publish',
        	'post_type'			=> 'fwp_portfolio',
        	'suppress_filters'	=> '0',
        	);

		if($include != ''){
			$args['include'] = $include;
            $args['orderby'] = 'post__in';
		}
		if($exclude != ''){
			$args['exclude'] = $exclude;
		}

        if( !empty( $exclude_cats ) && empty( $include_cats ) ) {
        $args['tax_query'] = array(
          array(
            'taxonomy' => 'portfolio-category',
            'field'    => 'ids',
            'terms'    => $exclude_cats,
            'operator' => 'NOT IN'
          )
        );
        }

        if( !empty( $include_cats )  ) {
        $args['tax_query'] = array(
          array(
            'taxonomy' => 'portfolio-category',
            'field'    => 'ids',
            'terms'    => $include_cats
          )
        );
        }

 		$items_markup = '';
		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', esc_html__('Used [fwp-hero-latest-projects] shortcode but no projects is added yet. <br>Please add at least one project before using this shortcode.', 'heroes'));
		}


        $html = '<div data-scroll-reveal="%s">
                    <div id="owl-featured" class="%s">
                        <!--item -->
                            %s
                        <!--end item -->
                    </div>
                </div>';

    	$target = ($target == '')? ' data-toggle="modal"': sprintf(' target="%s"', esc_attr( $target ) );
    	$btn_class = ($target == '')? ' overlay-ajax ' : '';
    	$featured_content = '';

    	foreach($items as $project){
            $item = '<div class="featureWrapper">
                        <div class="feature-inner">

                            <img alt="thumbnail" class="galleryImage" src="%s">

                            <!-- caption -->
                            <div class="caption-heading">
                                <h5>%s</h5>
                                <p>%s</p>
                                <a class="btn btn-default btn-black overlay-ajax" id="trigger-overlay-four" href="%s" %s>%s</a>
                            </div>
                            <!-- end caption -->

                        </div>
                    </div>';
    		$item_image = wp_get_attachment_image_src( get_post_thumbnail_id( $project->ID ), 'full' );

    		$featured_content .= sprintf($item, ( isset( $item_image[0] ) ? $item_image[0] : '' ), $project->post_title, $project->post_excerpt, get_permalink($project->ID), $target, esc_html( $more_label ) );
    	}


		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
		do_action(__METHOD__);
		do_action('fwp_shortcode_output', __METHOD__);

        return sprintf($html, $finalAnimation, esc_attr( $extra_class ), $featured_content);
}

static function HeroMessage($atts, $content){
		extract(shortcode_atts(array(
			'type'			=> 'success',
			'dismissible'	=> 'false',
		), $atts));
		if(!in_array($type, array('success','info','warning','danger'))){
			return FastWP_UI::alert( 'warning', sprintf( esc_html__( 'Used <b>[fastwp-message]</b> shortcode with incorrect type parameter (<i><b>%s</b></i>)', 'heroes' ), esc_html( $type ) ) );
		}

		$class = 'alert-'.$type;
		$class .= ($dismissible == 'true')?' alert-dismissible':'';
		$html_dismiss = ($dismissible == 'true')? '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' : '';
		$html = '<div class="alert %s" role="alert">%s %s</div>';

		do_action(__METHOD__);
		do_action('fwp_shortcode_output', __METHOD__);

        return sprintf($html, $class, $html_dismiss, do_shortcode( $content ) );
}

static function HeroTab($atts, $content){
		extract(shortcode_atts(array(
			'title' 		=> '',
			'is_active' 	=> false,
            'icon_class'    => '',
            'extra_class'   => ''
		), $atts));

		if( $is_active == 1 ) {
		    $extra_class .= 'tab-current ';
		}

        $extra_class .= !empty( $extra_class ) ? sanitize_html_class( $extra_class ) . ' ' : '';

		return sprintf( '<li class="%s"><a href="#" class="icon %s"><span>%s</span><p>%s</p></a></li>', trim( $extra_class ), esc_attr( $icon_class ), esc_html( $title ), $content );
}

static function HeroTabs($atts, $content){
		extract(shortcode_atts(array(
			'animated'		=> 'false',
			'extra_class'	=> '',
		), $atts));

		return sprintf( '<div class="tabs tabs-style-iconfall%s">
                            <nav>
                                <ul>
                                    %s
                                </ul>
                            </nav>

                        <div class="content-wrap">
                            <div class="content-current">
                                <p class="minimal"></p>
                            </div>
                        </div>

                        </div>', ( !empty( $extra_class ) ? ' ' . sanitize_html_class( $extra_class ) : '' ), do_shortcode( $content ) );
}

static function HeroCountdown($atts, $content){
		global $fwp_custom_js;
		extract(shortcode_atts(array(
            'stop_year'     => date('Y'),
			'stop_month'	=> date('F'),
			'stop_day'		=> date('j'),
            'stop_hour'     => date('G'),
            'stop_minute'   => date('s'),
            'logo'          => '',
            'background'    => '',
            'title'         => '<small>We are</small> Coming Soon'
		), $atts));

        $logo 	        = wp_get_attachment_image_src( $logo, 'full' );
        $background 	= wp_get_attachment_image_src( $background, 'full' );

		$countdown = sprintf( '<div class="intro intro-full">
            <div class="black-overlay"></div>
            <div class="container valign">
                <div class="row">
                    <div class="col-md-12">
                        <img src="%s" class="img-responsive center-block introLogo" alt="Intro Logo">
                    </div>
                    <div class="col-md-offset-2 col-md-8 text-center">
                        <h2 class="minimal">%s</h2>
                    </div>
                    <div class="col-md-12 text-center">
                        <div id="countdown"></div>
                    </div>
                </div>
            </div>
        </div>', ( isset( $logo[0] ) ? $logo['0'] : '' ), $title );

        if( isset( $background[0] ) ) {
            $countdown .= "
            <script>
            jQuery(function($){
                $.backstretch('$background[0]');
            });
            </script>";
        }

    	$fwp_custom_js['countdown_date'] = date( 'd F Y, H:i', strtotime( implode( ' ', array( $stop_day, $stop_month, $stop_year, ', ' . $stop_hour . ':' . $stop_minute ) ) ) );

		do_action('fwp_enqueue_script', 'scripts,jquery.plugin.min,jquery.countdown.min'); // Conditional load scripts
		do_action(__METHOD__); 
		do_action('fwp_shortcode_countdown', __METHOD__);

		return $countdown;
	}

	static function HeroTwitter($atts, $content){
		extract(shortcode_atts(array(
    	    'user'	        => '',
			'tweets' 		=> 2,
            'date_format'   => 'M/d/Y',
			'extra_class'	=> '',
		), $atts));

        if( !function_exists( 'getTweets' ) ) {
			return FastWP_UI::alert('warning', esc_html__('This shortcode works only <a href="https://wordpress.org/plugins/oauth-twitter-feed-for-developers/">oAuth Twitter Feed</a> plugin.', 'heroes'));
        }

  		$tweets = getTweets( $user, $tweets );

  		if( isset( $tweets['error'] ) ) {
			return FastWP_UI::alert('warning', $tweets['error']);  	
		}

        $content = '';
        foreach( $tweets as $tweet ) {
            $text = preg_replace( '/((http|ftp)+(s)?:\/\/[^<>\s]+)/i', "<a href=\"$0\" target=\"_blank\">$0</a>", $tweet['text'] );
            $text = preg_replace( '/(?<=^|\s)@([a-z0-9_]+)/i', '<a href="http://www.twitter.com/$1">@$1</a>', $text );
            $text = preg_replace( '/\#([a-zA-Z0-9_]+)/', '<a href="https://twitter.com/search?q=#$1&src=hash">#$1</a>', $text );
            $content .= sprintf( '<li>%s - %s</li>', date( $date_format, strtotime( $tweet['created_at'] ) ), $text );
        }

		do_action(__METHOD__);
		do_action('fwp_shortcode_output', __METHOD__);

        return sprintf( '<div class="tweet%s">
        <ul>
            %s
        </ul></div>', ( !empty( $extra_class ) ? ' ' . esc_attr( $extra_class ) : '' ), $content );
	}

	static function HeroStellarImage($atts, $content){
		extract(shortcode_atts(array(
			'image' 		=> '',
			'alignment'		=> '',
			'data_ratio'	=> '0.5',
			'extra_class'	=> '',
		), $atts));
		if(empty($image)) return;
		$item_image 		= wp_get_attachment_image_src($image, 'full' );
		$item_image 		= (isset($item_image[0]))? $item_image[0] : '';
		$main_class 		= 'fwp-stellar-image';
		$main_class			.= ' '.$alignment;
		$blank_markup		= '<img class="%s %s" src="%s" data-stellar-ratio="%s">';

		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
		do_action(__METHOD__);
        do_action('fwp_shortcode_output', __METHOD__);

		return sprintf($blank_markup, esc_attr( $main_class ), esc_attr( $extra_class ), $item_image, esc_attr( $data_ratio ) );
	}


	static function HeroAnimatedText($atts, $content){
		extract(shortcode_atts(array(
			'animated'		=> 'true',
			'animation'		=> 'enter right move 10px over 1s after',
			'extra_class'	=> '',
		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$module_markup 	= '<div class="fwp-text-block %s"%s>%s</div>';
		$finalAnimation = ( $animated == 'true' ) ? sprintf(' data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ) : '';
		return sprintf( $module_markup, esc_attr( $extra_class ), $finalAnimation, do_shortcode($content));
	}
		
	static function HeroParallaxLetter($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'anim_ratio'	=> '1.5',
			'anim_offset'	=> '0',
			'hposition'		=> '50%',
			'lcolor'		=> '',
			'extra_class'	=> '',
		), $atts));
		$module_markup 	= '<h1 class="parallaxLetter %s" id="%s" data-stellar-ratio="%s" data-stellar-vertical-offset="%s">%s</h1>';
		$id = 'letter-'.rand(1000,9999);
		$other_css_definitions = ($lcolor != '')? sprintf(' color:%s;', esc_html( $lcolor ) ) : '';
		$fwp_custom_shortcode_css .= sprintf('#%s { left: %s; %s }', $id, esc_html( $hposition ), esc_html( $other_css_definitions ) );

		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts

		return sprintf($module_markup, esc_attr( $extra_class ), $id, esc_attr( $anim_ratio ), esc_attr( $anim_offset ), strip_tags( $content ) );
	}

	static function HeroSubtitle($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'tag'			=> 'h4',
			'color'			=> '#333333',
			'class'			=> '',
			'align'			=> '',
			'small_color'	=> '#fff',
			'text'			=> 'test',
			'animated'		=> 'true',
			'animation'		=> 'enter left move 10px over 1s after 0.2s',
			'extra_class'	=> ''
		), $atts));
		/* Do not skip this if you have animation in shortcode. You will not be able to globally remove animations */
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$fwp_subtitle_id 	= 'subtitle-'.rand(1000,9999);
		$fwp_custom_shortcode_css .= sprintf('#%s.%s {color:%s; text-align:%s;}', $fwp_subtitle_id, esc_html( $class ), esc_html( $color ), esc_html( $align ) );
		$fwp_custom_shortcode_css .= sprintf('#%s.%s small {color:%s; text-align:%s;}', $fwp_subtitle_id, esc_html( $class ), esc_html( $small_color ), esc_html( $align ) );
		$blank_markup 	= '<%s id="%s" class="%s %s" %s>%s</%s>';
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ) : '';

		/**
		Mandatory for all FWP Shortcodes
		**/

		do_action(__METHOD__); 
		do_action('fwp_shortcode_output', __METHOD__);

		return sprintf($blank_markup, esc_attr( $tag ), $fwp_subtitle_id, esc_attr( $class ), esc_attr( $extra_class ), $finalAnimation, fwp_utils::fwp_escape( $text ),esc_attr( $tag ) );
	}

	static function HeroAboutBox($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'title'			=> '',
			'title_serif'	=> '',
			'title_tag'		=> 'h4',
			'title_color'	=> '#333333',
			'icon_class'	=> 'fa-facebook',
			'icon_color'	=> '#F1F1F1',
			'icon_offset'	=> '300',
			'stellar_speed'	=> '1',
			'animated'		=> 'true',
			'animation'		=> 'enter left move 10px over 1s after 0.2s',
			'extra_class'	=> ''
		), $atts));
		/* Do not skip this if you have animation in shortcode. You will not be able to globally remove animations */
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$fwp_about_box_id 	= 'about-box-'.rand(1000,9999);
		$fwp_custom_shortcode_css .= sprintf('#%s i {color:%s;} ', $fwp_about_box_id, esc_html( $icon_color ) );
		$fwp_custom_shortcode_css .= sprintf('#%s .aboutText %s {color:%s;} ', $fwp_about_box_id, esc_html( $title_tag ), esc_html( $title_color ) );
		$blank_markup 	= '<div id="%s" class="aboutItem clearfix %s %s">
                        <div class="aboutIconWrapper" data-stellar-ratio="%s" data-stellar-vertical-offset="%s">
                            <i class="fa %s"></i>
                        </div>
                        <div class="aboutText">
                            <%s>%s <span class="serif">%s</span></%s>
                            <div class="aboutSeparator"></div>
                            <p>
                                %s
                            </p>
                        </div>
                    </div>';
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ) : '';
		/**
		Mandatory for all FWP Shortcodes
		**/
		do_action(__METHOD__); 
		do_action('fwp_shortcode_output', __METHOD__); 
		return sprintf($blank_markup, $fwp_about_box_id, esc_attr( $extra_class ), $finalAnimation, esc_attr( $stellar_speed ), esc_attr( $icon_offset ), esc_attr( $icon_class ), esc_attr( $title_tag ), fwp_utils::fwp_escape( $title ), esc_attr( $title_serif ), esc_attr( $title_tag ), fwp_utils::fwp_escape( $content ) );
	}

	static function HeroContactBox($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'is_last'		=> '',
			'icon'			=> '',
			'animated'		=> 'true',
			'animation'		=> 'enter left move 10px over 1s after 0.2s',
			'extra_class'	=> 'text',
			'icon_color'	=> '',
			'color'			=> '',
		), $atts));
		$contact_box_id = 'fwp-hero-cbox-'.rand(100,9999);
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ) : '';
		$blank_markup = ' 
						<div id="%s" class="contactInfo1 %s" %s>
	                        <i class="%s"></i>
	                        <p>%s</p>
	                    </div>';
        $fwp_custom_shortcode_css .= sprintf('#%s.contactInfo1 i {color:%s}', $contact_box_id, esc_html( $color ) );
        $fwp_custom_shortcode_css .= ($is_last == 'true') ? sprintf('#%s.contactInfo1 {border:0}', $contact_box_id) : '';

        do_action(__METHOD__);
        do_action('fwp_shortcode_output', __METHOD__);

        return sprintf( $blank_markup, $contact_box_id, esc_attr( $extra_class ), $finalAnimation, esc_attr( $icon ), do_shortcode( $content ) );
	}

	static function HeroCounterBox($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'value_sufix'	=> 'AAAA',
			'value_color'	=> '#F1F1F1',
			'text'			=> 'tweets',
			'text_color'	=> '#F1F1F1',
			'icon_class'	=> 'fa-facebook',
			'icon_color'	=> '',
			'icon_offset'	=> '300',
			'animated'		=> 'true',
			'animation'		=> 'enter left move 10px over 1s after 0.2s',
			'start'			=> '0',
			'end'			=> '100',
			'speed'			=> '2000',
			'interval'		=> '10',
			'stellarratio'	=> '',
			'extra_class'	=> ''
		), $atts));
		/* Do not skip this if you have animation in shortcode. You will not be able to globally remove animations */

		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$text_markup 	= ($text !='') ? sprintf('<p>%s</p>',$text) : '';
		$fwp_counter_box_id	= 'counter-box-'.rand(1000,9999);
		$fwp_custom_shortcode_css .= sprintf('#%s .timerIcon i {color:%s;} #%s h1 .timer {color:%s;}', $fwp_counter_box_id, $icon_color,$fwp_counter_box_id,$text_color);
		$blank_markup 	= '<div id="%s" class="text-center timerWrapper timer-item %s" data-settings="{start:%s,max:%s,speed:%s,iterval:%s}" %s>
		                        <div class="timerIcon center-block" data-stellar-ratio="%s" data-stellar-vertical-offset="%s">
		                            <i class="fa %s"></i>
		                        </div>
		                        <h1><span class="timer">0</span> %s</h1>
		                        %s
                    		</div>';
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ) : '';
		/**
		Mandatory for all FWP Shortcodes
		**/
		do_action(__METHOD__); 
		do_action('fwp_shortcode_output', __METHOD__);
		//do_action('fwp_enqueue_script', 'scripts,custom');
		return sprintf($blank_markup, $fwp_counter_box_id, esc_attr( $extra_class ), esc_attr( $start ), esc_attr( $end ), esc_attr( $speed ), esc_attr( $interval ), $finalAnimation, esc_attr( $stellarratio ), esc_attr( $icon_offset ), esc_attr( $icon_class ), esc_attr( $value_sufix ), fwp_utils::fwp_escape( $text_markup ) );
	}

	static function HeroTestimonials($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'animated' 		=> 'true',
			'animation' 	=> 'enter right move 10px over 1s after 0.2s',
			'include'		=> '',
			'exclude'		=> '',
			'extra_class'	=> '',

		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);
		/* Do not skip this if you have animation in shortcode. You will not be able to globally remove animations */
		$finalAnimation = sprintf('data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) );
		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_testimonial',
			'include'			=> $include,
			'exclude'			=> $exclude,
			'suppress_filters'	=> '0',
			);


		$items = get_posts($args);

		if(!is_array($items) || (is_array($items) && count($items) == 0)){

			do_action(__METHOD__);
            do_action('fwp_shortcode_output', __METHOD__);

            return FastWP_UI::alert('warning', esc_html__('Used [testimonials] shortcode but no testimonial is selected. <br>Please add at least one testimonial before using this shortcode.', 'heroes'));
		}
 		$items_markup 	= '';
 		$item_markup 	= '<div id="%s" class="review" %s>
                                <p>
                                    %s
                                </p>
                                <br>
                                <p class="reviewParagraph">
                                    %s
                                </p>
                                <br>
                                <h4>%s</h4>
                                <p class="titulation">%s</p>
                            </div>';

                
		foreach($items as $item){
			$fwp_testimonial_id = 'fwp-testimonal-'.rand(1000,9999);
			$fwp__meta  		= get_post_meta( $item->ID, '_fwp_meta', true);
			$title 			= $item->post_title;
			$role 			= (isset($fwp__meta['role']))? $fwp__meta['role']:'';		
			$i = 0;
			$stars = (isset($fwp__meta['stars']))? $fwp__meta['stars'] : 0;
			$role = (isset($fwp__meta['title']))? $fwp__meta['title'] : '';
			$title = $item->post_title;
			$name_color = (isset($fwp__meta['name_color']))? $fwp__meta['name_color'] : '';
			$stars_color = (isset($fwp__meta['stars_color']))? $fwp__meta['stars_color'] : '#fffff';
			$ocupation_color = (isset($fwp__meta['ocupation_color']))? $fwp__meta['ocupation_color'] : '#c8c8c8';				
			$finalStars = '';
			$fullStars 	= intval($stars);
			$halfStar 	= ($fullStars != $stars)? 1 : 0;
			$emptyStars = 5 - $fullStars - $halfStar;
			$finalStars .= str_repeat('<i class="fa fa-star"></i>', $fullStars);
			$finalStars .= str_repeat('<i class="fa fa-star-half-o"></i>', $halfStar);
			$finalStars .= str_repeat('<i class="fa fa-star-o"></i>', $emptyStars);
            $items_markup .= sprintf($item_markup, esc_attr( $fwp_testimonial_id ), $finalAnimation, $finalStars, $item->post_content, $title, esc_html( $role ) );
            $fwp_custom_shortcode_css .= sprintf('#%s h4 {color:%s;} #%s i {color:%s} #%s .titulation {color:%s}', $fwp_testimonial_id, esc_html( $name_color ), $fwp_testimonial_id, esc_html( $stars_color ), $fwp_testimonial_id, esc_html( $ocupation_color ) );
		}

		$blank_markup = '<div id="owl-testimonials"> %s </div>';

		do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts

		/**
		Mandatory for all FWP Shortcodes
		**/

		do_action(__METHOD__);
		do_action('fwp_shortcode_output', __METHOD__);

		return sprintf($blank_markup, $items_markup);
	}

	static function HeroTeam($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'animated'		=> 'true',
			'animation'		=> 'enter right move 10px over 1s after ',
			'initial_delay' => '0.8',
			'increment_delay' => '0.2',
			'include'		=> '',
			'exclude'		=> '',
			'stop_on_hover' => '',
			'show_arrows'	=> '',
			'autoplay'		=> '',

		), $atts));	
		$animated = apply_filters('fwp_animation_enable', $animated);
        /* Do not skip this if you have animation in shortcode. You will not be able to globally remove animations */
		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_team',
			'suppress_filters'	=> '0',
			'include'			=> $include,
			'exclude'			=> $exclude,
			);


		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', esc_html__('Used [our-team] shortcode but no team member is selected. <br>Please add at least one member before using this shortcode.', 'heroes'));
		}

 		$items_markup 	= $carousel_overrides = $show_controls = '';
 		$social_item_markup = '<a href="%s" target="_blank"><i class="fa %s"></i></a>';
 		$item_markup 	= '
                        <!--member-->
                        <div class="teamMember">

                            <div class="col-md-6 col-sm-6 col-xs-12 teamImageWrapper">
                                <div class="team-image">
                                    <img src="%s" class="center-block img-responsive team-imagetocenter" alt="Team Image">
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 memberDescription text-center">
                                <h2 data-scroll-reveal="enter right move 10px over 1s after 0.2s">%s</h2>
                                <h3 class="position"  data-scroll-reveal="enter right move 10px over 1s after 0.4s">
                                 	<span class="serif">
                                        %s
                                    </span>
                                </h3>
                                <p class="memberParagraph" data-scroll-reveal="enter right move 10px over 1s after 0.6s">%s</p>
                              <div class="allIconsSocialWrapper center-block">
                              %s
                              </div>
                              <div class="clearfix"></div>
                              <img src="%s" class="img-responsive center-block zigzagSep" alt="separator">
                            </div>
                        </div>
                        <!--end member-->			   
                ';

                
		foreach($items as $item){
			$fwp__meta  		= get_post_meta( $item->ID, '_fwp_meta', true);
			$title 			= $item->post_title;
			$item_image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
			$role 			= (isset($fwp__meta['role']))? $fwp__meta['role']:'';
			$social_markup  ='';
			$final_social_markup = '';
			$i = 0;
			if(isset($fwp__meta['social']) && is_array($fwp__meta['social']) && count($fwp__meta['social']) > 0){
				foreach($fwp__meta['social'] as $k=>$v){
					if(substr_count($v, '|') == 0) continue;
					list($icon, $url) = explode('|', $v);
					$url = trim($url);
					$social_markup = sprintf($social_item_markup, esc_url( $url ),esc_html( $icon ) );
					$social_markup_wrapper = '<div class="socialWrapper">
						                        <div class="socialIcon-wrap socialIcon-effect-1 socialIcon-effect-1a">
						                            <div class="socialIcon">%s
						                            </div>
						                        </div>
						                    </div>';
					$final_social_markup .= sprintf($social_markup_wrapper, $social_markup);
				$i++;
				}
			}

            $items_markup .= sprintf($item_markup, ( isset($item_image[0]) ? $item_image[0] : '' ), $title, esc_html( $role ), $item->post_content, $final_social_markup, get_stylesheet_directory_uri() .'/assets/img/zigzagsep.png');
		}
		$carousel_overrides = '{"autoplay": "'.esc_html($autoplay).'", "showControls": "'.esc_html($show_controls).'"}';
		$blank_markup = '<div class="owl-carousel" id="owl-team" data-carousel-settings=\'%s\'> %s </div>';

        do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts

		/**
		Mandatory for all FWP Shortcodes
		**/

        do_action(__METHOD__);
		do_action('fwp_shortcode_output', __METHOD__);

        return sprintf($blank_markup, $carousel_overrides, $items_markup);
	}

static function HeroServices ($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'animated'		=> 'true',
			'order'			=> 'DESC',
			'by'			=> 'post_date',
			'include'		=> '',
			'exclude'		=> ''
		), $atts));

		$animated = apply_filters('fwp_animation_enable', $animated);

        /* Do not skip this if you have animation in shortcode. You will not be able to globally remove animations */
		$args = array(
			'numberposts' 		=> '-1',
			'posts_per_page' 	=> '-1',
			'post_status' 		=> 'publish',
			'post_type'			=> 'fwp_service',
			'suppress_filters'	=> '0',
			'include'			=> $include,
			'exclude'			=> $exclude,
			'order'				=> $order,
			'orderby'			=> $by

			);

		$items_markup = '';
		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', esc_html__('Used [our-service] shortcode but no team services is selected. <br>Please add at least one member before using this shortcode.', 'heroes'));
		}

		$i = 0;
		foreach($items as $item){
			$fwp__meta  			= get_post_meta( $item->ID, '_fwp_meta', true);
			$classes 				= array('left', 'right');
			$title 					= $item->post_title;
			$link					= (isset( $fwp__meta['target_url']))?$fwp__meta['target_url']:'';
			$item_icon 				= wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
			$customActions          = (!empty($link))? ' onclick="window.open(\''.esc_url( $link ).'\'); return false;"' :'';
			$services_description 	= (isset($item->post_excerpt) && !empty($item->post_excerpt))? apply_filters('the_content', $item->post_excerpt) : apply_filters('the_content', $item->post_content);
			$item_markup 	= '
		 		<div class="serviceBox text-center">
		                    <div class="valign">
		                        <div class="serviceIcon-wrap serviceIcon-effect-1 serviceIcon-effect-1a%s" %s>
		                            <div class="serviceIcon" %s>
		                                <img src="%s" class="img-responsive" alt="icon">
		                            </div>
		                        </div>
		                        <h5 class="minimal" %s>%s</h5>
		                        <p %s>
		                          %s
		                        </p>
		                    </div>
		                </div>			   
                ';
            $direction 	= ($i%2 == 0)? 'left':'right';
            $animIcon	= 'data-scroll-reveal="enter '.$direction.' move 10px over 1s after 0.2s"';
			$animTitle 	= 'data-scroll-reveal="enter '.$direction.' mvoe 10px over 1s after 0.4s"';
			$animText 	= 'data-scroll-reveal="enter '.$direction.' move 10px over 1s after 0.6s"';
			$i++;
            $items_markup .= sprintf($item_markup, (!empty($link) ? ' is-clickable' : ''), $animIcon,$customActions, ( isset( $item_icon[0] ) ? $item_icon[0] : '' ), $animTitle, $title, $animText, $services_description);
		}

        do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts

		/**
		Mandatory for all FWP Shortcodes
		**/

		do_action(__METHOD__);
		do_action('fwp_shortcode_output', __METHOD__);

		return sprintf($items_markup, $item_markup);
	}


		static function HeroClients($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'			=> '',
			'animated'				=> 'true',
			'animation'				=> 'enter right move 10px over 1s after',
			'animation_delay_start' => '0.6',
			'animation_delay_step' 	=> '0.2',
			'animated_items'		=> 3,
			'autoplay' 				=> 'true',
			'show_controls'			=> 'true',
			'target'				=> '_self'

		), $atts));
		$animated 		= apply_filters('fwp_animation_enable', $animated);

        /* Do not skip this if you have animation in shortcode. You will not be able to globally remove animations */
		$module_output 	= '';
		$module_markup 	= ' <div id="owl-clients" class="owl-clients owl-carousel" data-carousel-settings=\'%s\'>%s</div>';
		$item_markup 	= ' <div class="clientLogo" %s>
                                <a href="%s" target="%s"><img src="%s" class="img-responsive center-block" alt="image"></a>
                            </div>';
        $items_output   = '';
		if($content != ''){
			$content = strip_tags($content);
			$clients = str_replace("\r\n", "\n", $content);
			$clients = explode("\n",$clients);
			$i = 0;
			foreach($clients as $client){
				if(trim($client) == '') continue;
				$animation_settings = '';
				if(substr_count($client, '|') != 0){
					list($img, $link) = explode('|', $client);
				}else {
					$img 	= $client;
					$link 	= 'javascript:void(0);';
				}
				$img = trim ($img);
				if($i < $animated_items && $animated == 'true'){
					$delay =  floatval($animation_delay_start) - ($i * floatval($animation_delay_step));
					if($delay > 0)
						$animation_settings = 'data-scroll-reveal="'. fwp_utils::fwp_escape( $animation ).' '.$delay.'s"';
				}

				$items_output .= sprintf($item_markup, $animation_settings, esc_url( $link ), esc_attr ( $target ), esc_url( $img ) );
				$i++;
			}

			$carousel_overrides = '{"autoplay": "'.esc_html( $autoplay ).'", "showControls": "'.esc_html( $show_controls ).'"}';
			$module_output = sprintf($module_markup, $carousel_overrides, $items_output);

			do_action('fwp_enqueue_script', 'scripts,custom'); // Conditional load scripts
			do_action(__METHOD__);
			do_action('fwp_shortcode_output', __METHOD__);

			return $module_output;
		}
		return FastWP_UI::alert('warning', esc_html__('Used [our-clients] shortcode but no client is defined. <br>Please add at least one client within this shortcode.', 'heroes'));
		
	}

	static function HeroContactInfo($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'icon_class'			=> 'icon-pointer',
			'icon_color'			=> '#333333',
            'icon_size'             => '',
			'animated'				=> 'true',
			'animation'				=> 'enter left move 10px over 1s after 0.2s',
			'url'					=>	'',
			'extra_class'			=> 	'',
            'extra_id'              =>  ''
		), $atts));
		/* Do not skip this if you have animation in shortcode. You will not be able to globally remove animations */
		$animated 		= apply_filters('fwp_animation_enable', $animated);
		$fwp_contact_info_id 	= 'contact-info-'.rand(1000,9999);
		$fwp_custom_shortcode_css .= (sprintf('#%s i {color:%s;font-size:%spx}', $fwp_contact_info_id, $icon_color,$icon_size));
		$blank_markup  ='<div id="%s" class="infoContact %s" %s>
                                        <i class="fa %s"></i>%s
                        </div>';
		$contactinfo_wrapper = '<a href="%s" target="%s" %s>%s</a>';
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf( 'data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ) : '';
		$final_contact = sprintf($blank_markup, $fwp_contact_info_id, esc_attr( $extra_class ), $finalAnimation, esc_html( $icon_class ), fwp_utils::fwp_escape( $content ) );


        $parse_args = vc_build_link($url );
        $url       = ( isset( $parse_args['url'] ) ) ? esc_url( $parse_args['url'] ) : '#';
        $target    = ( isset( $parse_args['target'] ) ) ? trim( $parse_args['target'] ) : '_self';

		/**
		Mandatory for all FWP Shortcodes
		**/

		do_action(__METHOD__);
		do_action('fwp_shortcode_output', __METHOD__);

        if (!empty($url)) {
			return sprintf($contactinfo_wrapper, $url, esc_html( $target ), $finalAnimation, $final_contact);
		} else {
			return $final_contact;
		}

	}

	static function HeroPriceTable($atts, $content){
		extract(shortcode_atts(array(
			'price'			=> '0',
			'currency'		=> '$',
			'suffix'		=> '/month',
			'suffix_first'	=> 'false',
			'title'			=> '',
			'stars'			=> 5,
			'submit_label'	=> 'SUBSCRIBE!',
			'submit_url'	=> '#',
			'submit_target'	=> '_blank',
			'animated' 		=> 'true',
			'remove_button'	=> 'false',
			'animation' 	=> 'enter bottom move 10px over 1s after 0.2s',
			'extra_class'	=> '',

		), $atts));
		$animated 	= apply_filters('fwp_animation_enable', $animated);

		$separator 	= get_stylesheet_directory_uri() .'/assets/img/zigzagsep.png';
		$finalAnimation = ($animated == 'true' && $animation != '')? sprintf('data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ):'';
		if($suffix_first == 'false'){

		$finalPrice = '<h2>'.esc_html( $price.$currency ).'</h2><p> '.esc_html( $suffix ).'</p>';
		}
		else
		{
		$finalPrice = '<h2>'.esc_html( $currency.$price ).'</h2><p> '. esc_html( $suffix ).'</p>';
		};

		$finalStars = '';
		$fullStars 	= intval($stars);
		$halfStar 	= ($fullStars != $stars)? 1 : 0;
		$emptyStars = 5 - $fullStars - $halfStar;
		$finalStars .= str_repeat('<i class="fa fa-star"></i>', $fullStars);
		$finalStars .= str_repeat('<i class="fa fa-star-half-o"></i>', $halfStar);
		$finalStars .= str_repeat('<i class="fa fa-star-o"></i>', $emptyStars);
		$table_button = ($remove_button == 'false') ? sprintf('<a class="btn btn-default btn-black" href="%s" target="%s">%s</a>', esc_url( $submit_url ), esc_html( $submit_target ), esc_html( $submit_label ) ) : '';
		$item_html 	= '<div class="tableWrapper text-center %s" %s>
		<div class="subscriptionName">
		<h2>%s</h2></div><img class="separator center-block img-responsive" src="%s" alt="zig zag Separatorr">
		<div class="subscriptionPrice">%s</div>
		<div class="rating">%s</div>
		<div class="subscriptionList">%s</div>
		%s</div>';

        do_action(__METHOD__);
        do_action('fwp_shortcode_output', __METHOD__);

        return sprintf($item_html, $extra_class, $finalAnimation, esc_html( $title ), $separator, $finalPrice, $finalStars, $content, $table_button);
	}
/**
	Portfolio
	**/
	static function portfolio_overlay_markup(){
		global $fwp_data;

		$close_class = !empty( $fwp_data['fwp_portfolio_close'] ) ? esc_attr( $fwp_data['fwp_portfolio_close'] ) : 'icon-close';

		$close_markup 	= sprintf( '<div class="col-md-12 overlaytop"><a class="overlay-close top"><br><br><i class="%s"></i></a></div>', $close_class );

		echo sprintf('<div class="container overlay overlay-hugeinc"><div class="row">%s<div class="overlay-section"></div></div></div>', $close_markup );
	}

	static function HeroPortfolio($atts, $content){
	global $fwp_custom_js;
		extract(shortcode_atts(array(
			'animated'		=> 'true',
			'animation'		=> 'enter bottom move 10px over 1s after 0.2s',
			'classes'		=> 'col-md-6 col-sm-6 col-xs-12',
			'layout'		=> 'masonry',
			'boxed'			=> 'no',
			'styleid'		=> '0',
			'show_filters'	=> 'yes',
			'filter_col'	=> '',
			'filter_bg'		=> '',
			'filter_col_hov'=> '',
			'extra_class'	=> '',
			'cont_class'	=> 'container portfolio-boxed',
			'all_label'		=> '',
			'button_label'	=> 'More',
			'orderby' 		=> 'menu_order',
	      	'cat_orderby' 	=> 'count',
		  	'hide_empty'	=> 0,
		  	'hide_filters'	=> 'no',
		  	'show_overlay' 	=> 'no',
			'include'		=> '',
			'exclude'		=> '',
			'include_cats'	=> '',
			'exclude_cats'	=> '',
			'default_cat'	=> '*',
			'gutter_width'	=> '',
			'gutter_color'	=> ''
		), $atts));
		$animated = apply_filters('fwp_animation_enable', $animated);

/**
#Region GetPortfolioItems
*/

        $args = array(
            'numberposts' 		=> '-1',
        	'posts_per_page' 	=> '-1',
        	'post_status' 		=> 'publish',
        	'post_type'			=> 'fwp_portfolio',
        	'suppress_filters'	=> '0',
        	);

		if($include != ''){
			$args['include'] = $include;
            $args['orderby'] = 'post__in';
		}
		if($exclude != ''){
			$args['exclude'] = $exclude;
		}

        if( !empty( $exclude_cats ) && empty( $include_cats ) ) {
        $args['tax_query'] = array(
          array(
            'taxonomy' => 'portfolio-category',
            'field'    => 'ids',
            'terms'    => $exclude_cats,
            'operator' => 'NOT IN'
          )
        );
        }

        if( !empty( $include_cats )  ) {
        $args['tax_query'] = array(
          array(
            'taxonomy' => 'portfolio-category',
            'field'    => 'ids',
            'terms'    => $include_cats
          )
        );
        }

/**
#Region HandleGeneralError
*/
		$items = get_posts($args);
		if(!is_array($items) || (is_array($items) && count($items) == 0)){
			return FastWP_UI::alert('warning', esc_html__('Used [portfolio] shortcode but no project is added yet. <br>Please add at least one project before using this shortcode.', 'heroes'));
		}
/**
#Region SetupDefaults
*/
		$grids 			= array('grid-sizer', 'grid-sizer-two-columns', 'grid-sizer-four-columns','no-grid');
		$classes 		= array('', 'two-columns', 'four-columns','');
		$grid 			= $grids[$styleid];
		$gal_size_class = $classes[$styleid];
		$before_items 	= '';
		$after_items 	= '';
		$styleid 		= intval($styleid);
		$excluded_cats	= !empty( $exclude_cats ) ? explode( ',', trim( $exclude_cats ) ) : array();
		$included_cats	= !empty( $include_cats ) ? explode( ',', trim( $include_cats ) ) : array();
 		$items_markup 	= '';
 		$portfolio_id 	= 'fwp_portfolio_'.rand(1000,9999);
 		$fwp_custom_js['portfolio']		= (isset($fwp_custom_js['portfolio']))? $fwp_custom_js['portfolio'] : array();
 		$fwp_custom_js['portfolio'][] 	= array('exclude_cat' => $exclude_cats, 'default_cat' => $default_cat,'id'=>$portfolio_id);

		$all_projects_filter 				= new stdClass;
		$all_projects_filter->class_name 	= 'selected';
		$all_projects_filter->slug 			= '.f--all';
		$all_projects_filter->name 			= $all_label != '' ? esc_html( $all_label ) : esc_html__('Show All','heroes');

		$categories 		= array_merge(array($all_projects_filter), get_terms('portfolio-category', array('orderby' => $cat_orderby, 'hide_empty' => $hide_empty)));
		$filters_markup		= '';
		$single_filter		= '<button class="btn btn-default" data-filter="%s" data-toggle="tooltip" data-placement="top" title="%s" %s>%s</button>';

		if($boxed == 'yes'){
			$before_items 	= '<div class="'.esc_attr( $cont_class ).'">';
			$after_items 	= '</div>';
		}

		if(count($categories) > 0 && $show_filters == 'yes'){
			foreach ($categories as $category) {
				if( isset( $category->term_id ) && in_array( $category->term_id, $excluded_cats ) && empty( $include_cats ) ) continue;
                if( isset( $category->term_id ) && !empty( $include_cats ) && !in_array( $category->term_id, $included_cats ) ) continue;
				$final_animation = sprintf('data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) );
				$slug = $category->slug != '.f--all' && $category->slug != '' ? '.f-'.$category->slug : $category->slug;
				$filters_markup .= sprintf($single_filter, $slug, $category->name, $final_animation, $category->name);
			}
		}


	    $item_markup 	= '
	             <!--item -->
                <div class="gallery-inner %s %s">
                    <!-- caption -->
                    <div class="caption text-center ">
                        <div class="captionWrapper valign">
                            <a class="%s blackOverlayBackground" href="%s" data-toggle="%s" >
                                <div class="verticallineSeparator center-block"></div>
                                <div class="caption-heading">
                                    <h4>%s</h4>
                                    <p>%s</p>
                                </div>
                                <div class="verticallineSeparator center-block"></div>
                            </a>
                        </div>
                    </div>
                    <!-- end caption -->

                    <img alt="thumbnail" class="galleryImage" src="%s">

                </div>';
		$item_markup_detail_1 = '
				<div class="grayBackground">
                <div class="containerPortfolio portfolio-boxed">
                    <div class="row">
                        <div class="col-md-6 col-sm-7 heightItem">
                            <img class="img-responsive" src="%s" alt="">
                        </div>
                        <div class="col-md-6 col-sm-5 heightItem">
                            <div class="valign">

                                    <div class="caption-heading">
                                        <h3 class="minimal">%s</h3>
                                        <h5 class="minimal"><small>%s</small></h5>
                                        %s
                                        <a class="%s" data-slug="%s" href="%s" data-toggle="%s">
                                            <div class="btn btn-default btn-black">%s</div>
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';

        $item_markup_detail_2 = '
				<div class="whiteBackground">
                <div class="containerPortfolio portfolio-boxed">
                    <div class="row">
                        <div class="col-md-6 col-sm-5 heightItem">
                            <div class="valign">

                                    <div class="caption-heading">
                                        <h3 class="minimal">%s</h3>
                                        <h5 class="minimal"><small>%s</small></h5>
                                        %s
                                        <a class="%s" data-slug="%s" href="%s" data-toggle="%s">
                                            <div class="btn btn-default btn-black">%s</div>
                                        </a>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-7 heightItem">
                            <img class="img-responsive" src="%s" alt="">
                        </div>
                    </div>
                </div>
            </div>
            ';

        $i = 0;
		foreach($items as $item){
			$category 		= '';

			$more_label 	= esc_html( $button_label );
			$title 			= $item->post_title;
			$item_image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
			$fwp__meta  	= get_post_meta( $item->ID, '_fwp_meta', true);
			$project_url 	= (isset($fwp__meta['url']) && !empty($fwp__meta['url']))? esc_url( $fwp__meta['url'] ) : get_permalink($item->ID);
			$project_slug	= $item->post_name;
			$target 		= (isset($fwp__meta['open_type']) && !empty($fwp__meta['open_type'])) ? esc_html( $fwp__meta['open_type'] ) : 'modal';
			$a_class = 'no-overlay';
			switch($target){

				case 'singlepage':
					$a_class = ' ';
				break;
				case 'new':
					$a_class = '" target="_blank';
				break;
				case 'lightbox':
					$project_url = isset( $item_image[0] ) ? $item_image[0] : '';
					$a_class = 'popup-link';
				break;
				default:
				case 'modal':
					$a_class = 'overlay-ajax';
				break;
			}

			$tl 		= wp_get_object_terms($item->ID, 'portfolio-category');
			$filters 	= 'f--all ';
			$cats 		= array();

			/* go trough category list and build required strings */
			foreach($tl as $term){
				if(in_array($term->term_id, $excluded_cats))
					continue;

				$filters .= ' f-'.$term->slug;
				$cats[] = $term->name;
			}
			/* Exclude projects that belongs just to excluded categories */
			if(count($cats) == 0){
				continue;
			}

			$category = implode(' / ', $cats);
			if($styleid != 3){
				$overlay_class = ($show_overlay == 'yes')? ' opaque-caption' : '';
				$overlay_class.= ($gutter_width != '') ? ' BorderedItem' :'';
	            $items_markup .= sprintf($item_markup, $gal_size_class . $overlay_class, $filters, $a_class, $project_url, $target, $title, $category, $item_image[0]);
			} else {
				$item_content = apply_filters('the_content', $item->post_excerpt);
			
				if($i%2 == 0){
	           	 	$items_markup .= sprintf($item_markup_detail_1, $item_image[0], $title, $category, $item_content, $a_class, $project_slug, $project_url, $target, $more_label);
	            } else {
	            	$items_markup .= sprintf($item_markup_detail_2, $title, $category, $item_content, $a_class, $project_slug, $project_url, $target, $more_label, $item_image[0]);
				}
			}
			$i++;
		}

		if($styleid != 3){
			$blank_markup = '<div id="%s" class="portfolio-holder">';
			$blank_markup .= ($show_filters == 'yes')? '
			<div class="portfolioFilters text-center">
				<div class="container">
					<div class="row">
						<div class="col-sm-4 text-left">
							<div class="activeFilter"><h3>Category being watched: </h3><h3><span>All</span></h3></div>
						</div>
						<div class="col-md-8 text-right">
							<div class="js-filters" id="filters">%s</div>
						</div>
					</div>
				</div>
			</div>' : '';
			$blank_markup .= '%s<div class="gallery js-isotope" data-isotope-options=\'{ "itemSelector": ".gallery-inner", "masonry": { "columnWidth": ".%s" } }\'><div class="%s"></div>%s </div>%s';
			$blank_markup .= '</div>';
		} else {
			$filters_markup = '';
			$blank_markup = '<div id="%s" class="portfolio-holder"><div class="portfolio-block">%s %s<!--  %s %s -->%s %s</div></div>';
		}

		
		$sc_css 		= '';
		$sc_css 		.= ($gutter_width !='') ? '.portfolio-holder .gallery-inner.BorderedItem {border: '. esc_html( $gutter_width ).'px solid transparent}' : '';
		$sc_css 		.= ($gutter_color !='') ? '.portfolio-holder .gallery-inner.BorderedItem {border-color: '.esc_html( $gutter_color ).'}' : '';

		if($filter_bg != '' || $filter_bg != '#1d1d1d'){
			$sc_css .= "#$portfolio_id .portfolioFilters { background-color: " . esc_html( $filter_bg ) . "; }";
		}
		if($filter_col != ''){
			$sc_css 	.= "
			#$portfolio_id .portfolioFilters .btn:before,
			#$portfolio_id .portfolioFilters .btn:after { background: " . esc_html( $filter_col ) . "; }
			#$portfolio_id .portfolioFilters .btn { color: " . esc_html( $filter_col ) . "; }
			#$portfolio_id .portfolioFilters .btn:hover {background-color: " . esc_html( $filter_col ) . "; }
			";
		}
		if($filter_col_hov != ''){
			$sc_css 	.= "#$portfolio_id .portfolioFilters .btn:hover { color: " . esc_html( $filter_col_hov ) . "; }";
		}

		if($sc_css != ''){
			global $fwp_custom_shortcode_css;
			$fwp_custom_shortcode_css .= $sc_css;
		}

		add_action('fwp_before_footer', array('fwp_theme_shortcodes', 'portfolio_overlay_markup'));
        do_action('fwp_enqueue_script', 'scripts,jquery.matchHeight-min,jquery.plugin.min,overlay,modernizr.custom,custom,owl-carousel,owl-theme'); // Conditional load scripts
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);
		if($show_filters == 'yes'){
			return sprintf($blank_markup, $portfolio_id, $filters_markup, $before_items, $grid, $grid, $items_markup, $after_items);
		
		}else {
			return sprintf($blank_markup, $portfolio_id, $before_items, $grid, $grid, $items_markup, $after_items);
		}
	}


static function HeroSocialIconsContainer( $atts, $content ){
		global $fwp_custom_shortcode_css;
		extract( shortcode_atts( array(
			'alignment'		=> 'text-center',
			'extra_class'	=> '',
		), $atts ) );	
		$blank_markup = '<div class="allIconsSocialWrapper center-block %s%s">%s</div>';
		return sprintf( $blank_markup, ( !empty( $extra_class ) ? ' ' . esc_attr( $extra_class ) : '' ), esc_html ( $alignment ), do_shortcode( $content ) );
	}

static function HeroSocialIconsItem( $atts, $content ){
		global $fwp_custom_shortcode_css;
		extract( shortcode_atts( array(
			'icon_class'	=> 'fa fa-facebook',
			'color'			=> '#282828'
,			'icon_background' => 'rgba(245,245,245,1)',
			'icon_background_hover' => 'rgba(0,0,0,1)',
			'icon_color_hover' => '#fff',
			'icon_border'	=> '#282828',
			'url'			=> '#',		
			'target'		=> '_blank',	
			'border_width'	=> '',
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'extra_class'	=> '',

		), $atts ) );	
		$id = 'socialicons-'.rand( 1000,9999 );
		$blank_markup = '<div id="%s" class="socialWrapper %s" data-scroll-reveal="%s">
                            <div class="socialIcon-wrap socialIcon-effect-1 socialIcon-effect-1a">
                                <div class="socialIcon">
                                    <a href="%s" target="%s"><i class="%s"></i></a>
                                </div>
                            </div>
                        </div>';
       
        $animated 		= apply_filters( 'fwp_animation_enable', $animated );
		$finalAnimation = ( $animated == 'true' && $animation != '' ) ? sprintf( 'data-scroll-reveal="%s"', $animation ) : '';
		$fwp_custom_shortcode_css .= ( $icon_background != "" ) ? sprintf( '#%s .socialIcon i {color: %s} #%s .socialIcon-effect-1 .socialIcon {background: %s}', $id, esc_attr( $color ), $id, esc_attr ( $icon_background ) ) : '';
		$fwp_custom_shortcode_css .= ( $icon_background_hover != "" ) ? sprintf( '#%s.socialWrapper:hover .socialIcon-effect-1a .socialIcon {background: %s}', $id, esc_attr( $icon_background_hover ) ) : '';
		$fwp_custom_shortcode_css .= ( $icon_color_hover != "" ) ? sprintf( '#%s.socialWrapper:hover .socialIcon i {color: %s}', $id, esc_attr( $icon_color_hover ) ) : '';
		$fwp_custom_shortcode_css .= ( $icon_border != "" ) ? sprintf( '#%s.socialWrapper:hover .socialIcon-effect-1a .socialIcon:after {box-shadow:  0 0 0 2px %s}', $id, esc_attr( $icon_border) ) : '';

        do_action(__METHOD__);
        do_action('fwp_shortcode_output', __METHOD__);

        return sprintf($blank_markup, $id, esc_attr( $extra_class ), esc_html( $finalAnimation ), esc_url( $url ), esc_attr( $target ), esc_attr( $icon_class ) );
	}

static function HeroButton($atts, $content){
		extract(shortcode_atts(array(
			'extra_class'	=> '',
			'type'			=> 'default',
			'label'			=> '',
			'link'			=> '#',
			'animate'		=> 'false',
			'action'		=> '',
			'target'		=> '',
			'tag'			=> 'button',
			'align'			=> 'center',
		), $atts));

		$scroll             = ( $animate == 'true' ? 'data-scroll=""' : '' );
		$item_button_html   = '<button type="button" class="%s fastwp btn btn-%s" onClick="%s">%s</button>';
		$item_a_html        = '<a %s href="%s" class="%s fastwp btn btn-%s" target="%s" onClick="%s">%s</a>';

        $link = fwp_utils::url_from_vc( $link );

		if($tag == 'button'){
			$button = sprintf( $item_button_html, esc_attr( $extra_class ), esc_attr( $type ), esc_html( $action ), esc_html( $link['title'] ) );
		} else {
			$button = sprintf( $item_a_html, $scroll, esc_url( $link['url'] ), esc_attr( $extra_class ), esc_attr( $type ), esc_html( $link['target'] ), esc_html( $action ), esc_html( $link['title'] ) );
		}

        return sprintf('<div class="fwp-btn-wrap text-%s">%s</div>', esc_attr( $align ), $button);
	}

static function HeroTitleSerif($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'tag'			=> 'h2',
			'color'			=> '#000',
			'animated'		=> 'true',
			'class'			=> '',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'text_color'    => '#000',
			'serif_color'   => '#000',
			'small_color'	=> '#000',
			'line_color'	=> '#c0c0c0',
			'extra_class'	=> '',
			'alignment'		=> 'center',
			'image_url'		=> get_stylesheet_directory_uri() .'/assets/img/incline-white.png',
            'show_line'     => 1

		), $atts));

		$animated 			= apply_filters('fwp_animation_enable', $animated);
		$finalAnimation 	= ( $animated == 'true' && $animation != '' ) ? sprintf( 'data-scroll-reveal="%s"', fwp_utils::fwp_escape( $animation ) ) : '';
		$id = 'titleserif-'.rand(1000,9999);
		$blank_markup = '<%s id="%s" class="title %s %s" %s>%s</%s>%s';
		$fwp_custom_shortcode_css .= ($alignment != '') ? sprintf('#%s.title {text-align: %s}', $id, $alignment) : '';
		$fwp_custom_shortcode_css .= sprintf('#%s.title {color: %s}', $id, esc_html( $color ) );
		$fwp_custom_shortcode_css .= sprintf('#%s.title small {color: %s}', $id, esc_html( $small_color ) );
        $image = ( $show_line == 1 ? sprintf( '<img src="%s" class="inclineLine center-block" alt="incline">', esc_url( $image_url ) ) : '' );

        do_action(__METHOD__);
        do_action('fwp_shortcode_output', __METHOD__);

        return sprintf($blank_markup, esc_attr( $tag ), $id, esc_attr( $class ), esc_attr( $extra_class ), $finalAnimation, fwp_utils::fwp_escape( $content ), esc_attr( $tag ), $image );
	}

static function HeroSeparator($atts, $content){
		global $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'width'         => '100px',
			'height'		=> '',
			'class'			=> '',
			'color'			=> '',
			'background'	=> '#fff',
			'type'			=> 'image',
			'image_url'		=> get_stylesheet_directory_uri() .'/assets/img/zigzagsep.png',
			'whiteimg_url'	=> get_stylesheet_directory_uri() .'/assets/img/zigzagsepWhite.png',
			'verticalimg_url' => get_stylesheet_directory_uri() .'/assets/img/incline-white.png',
			'animated'		=> 'true',
			'animation'		=> 'enter top move 10px over 1s after 0.2s',
			'extra_class'	=> '',

		), $atts));

        $separator ='';

		switch ($type) {
		case 'separator':
			$id = 'separator-fwp-'.rand(1000,9999);
			$blank_markup = '<div id="%s" class="lineSeparator %s %s"></div>';
			$separator = sprintf($blank_markup, $id, esc_attr( $class ), esc_attr( $extra_class ) );
			$fwp_custom_shortcode_css .= sprintf('#%s {background: %s; width: %s; height: %s;}', $id, esc_html( $background ), esc_html( $width ), esc_html( $height ) );
			break;
		case 'vertical':
			$id = 'separator-fwp-vertical'.rand(1000,9999);
			$blank_markup = '<div id="%s" class="verticallineSeparator %s %s"></div>';
			$separator = sprintf($blank_markup, $id, esc_attr( $class ) , esc_attr( $extra_class ) );
			$fwp_custom_shortcode_css .= sprintf('#%s.verticallineSeparator {background: %s; width: %s; height: %s;}', $id, esc_html( $background ), esc_html( $width ), esc_html( $height ) );
			break;
		case 'image':
			$id = 'separator-fwp-image-'.rand(1000,9999);
			$separator_image = '<div id="%s" class="separatorImage %s"><img src="%s" class="img-responsive center-block zigzagSep %s" alt="separator"></div>';
			$separator = sprintf($separator_image, $id, esc_attr( $extra_class ), esc_url( $image_url ), esc_attr( $extra_class ) );
			$fwp_custom_shortcode_css .= sprintf('#%s {color: %s; width: %s; height: %s;}', $id, esc_html( $color ), esc_html( $width ), esc_html( $height ) );
			break;
		case 'image-white':
			$id = 'separator-fwp-image-'.rand(1000,9999);
			$separator_image = '<div id="%s" class="separatorImage %s"><img src="%s" class="img-responsive center-block zigzagSep %s" alt="separator"></div>';
			$separator = sprintf($separator_image, $id, esc_attr( $extra_class ), esc_url( $whiteimg_url ), esc_attr( $extra_class ) );
			$fwp_custom_shortcode_css .= sprintf('#%s {color: %s; width: %s; height: %s;}', $id, esc_html( $color ), esc_html( $width ), esc_html( $height ) );
			break;
		case 'image-vertical':
			$id = 'separator-fwp-image-vertical'.rand(1000,9999);
			$separator_image_vertical = '<div id="%s" class="separatorImageVertical center-block %s"><img src="%s" class="img-responsive center-block zigzagSep %s" alt="separator"></div>';
		    $separator = sprintf($separator_image_vertical, $id, esc_attr( $extra_class ), esc_url( $verticalimg_url ), esc_attr( $extra_class ) );
		    $fwp_custom_shortcode_css .= sprintf('#%s {color: %s; width: %s; height: %s;}', $id, esc_html( $color ), esc_html( $width ), esc_html( $height ) );
		    break;
		}

		do_action(__METHOD__);
        do_action('fwp_shortcode_output', __METHOD__);

        return $separator;

	}
static function HerogMap($atts, $content){
        global $fwp_data, $fwp_custom_js;
		extract(shortcode_atts(array(
			'center'		=> '44.434596, 26.080533',
			'marker_title'	=> '',
			'marker_addr'	=> '',
			'map_style'		=> 'fastwp',
			'map_zoom'		=> '8',
			'map_izoom'		=> '12',

		), $atts));

        if( empty( $fwp_data['fwp_gmap_key'] ) ) {
			return FastWP_UI::alert('warning', esc_html__('Please visit your theme options and insert your Google Map API Key.', 'heroes'));
        }

		list($lat, $lng) = explode(',', $center);
		$fwp_custom_js['gmap_center'] = array(trim($lat),trim($lng));
		$titles 	= explode('|', $marker_title);
		$addrs 		= explode('|', $marker_addr);
		$contents 	= explode('|', $content);

		for($i=0; $i<count($addrs);$i++){
			$addrs[$i] = explode(',', str_replace(' ', '', $addrs[$i]));
		}
		for($i=0; $i<count($contents);$i++){
			$contents[$i] = apply_filters('the_content', $contents[$i]);
		}

		$fwp_custom_js['gmap_marker_titles']= $titles;
		$fwp_custom_js['gmap_marker_addrs'] = $addrs;
		$fwp_custom_js['gmap_marker_ct'] 	= $contents;
		$fwp_custom_js['gmap_style'] 		= $map_style;
		$fwp_custom_js['gmap_zoom'] 		= $map_zoom;
		$fwp_custom_js['gmap_izoom'] 		= $map_izoom;


		$html = '<div class="google-map" id="googleMap">Loading...</div>';

		do_action('fwp_enqueue_script', 'http://maps.googleapis.com/maps/api/js?key=' . ( !empty( $fwp_data['fwp_gmap_key'] ) ? esc_html( $fwp_data['fwp_gmap_key'] ) : '' ) . ',custom, scripts, googleMapInit');
		do_action(__METHOD__); do_action('fwp_shortcode_output', __METHOD__);

        return $html;
	}

	public static function HeroSliderbg($atts, $content){
		global $fwp_raw_js, $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'images' 		=> '',
			'pageid'		=> '',
			'duration'		=> '2000',
			'fade'			=> '750',
			'overlay'		=> 'true',
			'extra_class'	=> '',
		), $atts));
		$item_image  = '';
		$show_error  = false;
		$imagesArray = array();
		if($images != ''){
			$images = explode(',', $images);
			foreach($images as $image){
				$item_image = wp_get_attachment_image_src($image, 'full' );
				$item_image = (isset($item_image[0]))? $item_image[0] : '';
				if($item_image != ''){
					$imagesArray[] = '"'.$item_image.'"';
				}
			}
			
			if(count($imagesArray) == 0){
				$show_error = true;
			}
		} else {
			$show_error = true;
		}

		if($show_error == true){
			return FastWP_UI::alert('warning', '<br><br><br>' . esc_html__('Used [fwp-slider-bg] shortcode but no images are added yet. <br>Please select at least one image before using this shortcode.', 'heroes'));
		}

		$overlay_markup = ($overlay == 'true')? '<div class="black-overlay"></div>':'';
		
		$page_content = '';

		if($pageid != ''){
			$pageCt = get_page($pageid);
			if(isset($pageCt->post_content)){
				$page_content = apply_filters('the_content', $pageCt->post_content);
				$fwp_custom_shortcode_css 	.= get_post_meta( $pageCt->ID, '_wpb_shortcodes_custom_css', true );
			}
		}
		$imagesArrayText = implode(',',$imagesArray);
		$blank_markup = '<section class="intro" class="%s">%s<div class="container valign"><div class="row">%s</div></div></section>';
		$fwp_raw_js .= '
            jQuery(function($){
 				$.backstretch([
                '.$imagesArrayText.'
            	], {duration: '.$duration.', fade: '.$fade.'});
            });';
		do_action('fwp_enqueue_script', 'scripts,jquery.matchHeight-min,okvideo.min,overlay,modernizr.custom,preloader,custom'); // Conditional load scripts
		do_action(__METHOD__);
		do_action('fwp_shortcode_output', __METHOD__); 
		return sprintf($blank_markup, esc_attr( $extra_class ), $overlay_markup, $page_content);
	}

public static function HeroVideoBg($atts, $content){
		global $fwp_raw_js, $fwp_custom_shortcode_css;
		extract(shortcode_atts(array(
			'video' 		=> '',
			'image' 		=> '',
			'pageid'		=> '',
			'overlay'		=> 'true',
			'autoplay'		=> 'true', 
			'loop'			=> 'true', 
			'highdef'		=> 'true', 
			'hd'			=> 'true', 
			'adproof'		=> 'true',
			'volume'		=> '0',
			'extra_class'	=> '',
		), $atts));
		$item_image = '';
		if($image != ''){
			$item_image 	= wp_get_attachment_image_src($image, 'full' );
			$item_image = (isset($item_image[0]))? $item_image[0] : '';
		}

		$overlay_markup = ($overlay == 'true')? '<div class="black-overlay"></div>':'';
		$page_content = '';

		if($pageid != ''){
			$pageCt = get_page($pageid);
			if(isset($pageCt->post_content)){
				$page_content = apply_filters('the_content', $pageCt->post_content);
				$fwp_custom_shortcode_css 	.= get_post_meta( $pageCt->ID, '_wpb_shortcodes_custom_css', true );
			}
		}

		$videoURL = ($video != '') ? esc_url( $video ) : 'http://vimeo.com/18052127';
		$blank_markup = '<section class="intro" class="%s">%s<div class="container valign"><div class="row">%s</div></div></section>';
		if(isset($item_image) && !empty($item_image) && isset($videoURL) && !empty($videoURL)){
			$fwp_raw_js .= "
            jQuery(function($){
                if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                    $.backstretch('$item_image');
                }
                else{
                    $.okvideo({source: '$videoURL', autoplay: $autoplay, loop: $loop, highdef: $highdef, hd: $hd, adproof: $adproof, volume: $volume })
                }
            });";
		}
		do_action('fwp_enqueue_script', 'scripts,okvideo.min,custom'); // Conditional load scripts

		do_action(__METHOD__);
        do_action('fwp_shortcode_output', __METHOD__);

        return sprintf($blank_markup, esc_attr( $extra_class ), $overlay_markup, $page_content);
	}
}

if(!function_exists('FWP_Shortcode_HeroTab')){
	function FWP_Shortcode_HeroTab($atts, $content){
		return fwp_theme_shortcodes::HeroTab($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_HeroTabs')){
	function FWP_Shortcode_HeroTabs($atts, $content){
		return fwp_theme_shortcodes::HeroTabs($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_HeroCountdown')){
	function FWP_Shortcode_HeroCountdown($atts, $content){
		return fwp_theme_shortcodes::HeroCountdown($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_HeroTwitter')){
	function FWP_Shortcode_HeroTwitter($atts, $content){
		return fwp_theme_shortcodes::HeroTwitter($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_HeroSeparator')){
	function FWP_Shortcode_HeroSeparator($atts, $content){
		return fwp_theme_shortcodes::HeroSeparator($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_HeroSubitle')){
	function FWP_Shortcode_HeroSubitle($atts, $content){
		return fwp_theme_shortcodes::HeroSubitle($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_HeroTitleSerif')){
	function FWP_Shortcode_HeroTitleSerif($atts, $content){
		return fwp_theme_shortcodes::HeroTitleSerif($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_HeroSocialIcons')){
	function FWP_Shortcode_HeroSocialIcons($atts, $content){
		return fwp_theme_shortcodes::HeroSocialIcons($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroButton')){
	function FWP_Shortcode_HeroButton($atts, $content){
		return fwp_theme_shortcodes::HeroButton($atts, $content);
	}
}

if(!function_exists('FWP_Shortcode_HeroSubtitle')){
	function FWP_Shortcode_HeroSubtitle($atts, $content){
		return fwp_theme_shortcodes::HeroSubtitle($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroAboutBox')){
	function FWP_Shortcode_HeroAboutBox($atts, $content){
		return fwp_theme_shortcodes::HeroAboutBox($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroCounterBox')){
	function FWP_Shortcode_HeroCounterBox($atts, $content){
		return fwp_theme_shortcodes::HeroCounterBox($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroTestimonials')){
	function FWP_Shortcode_HeroTestimonials($atts, $content){
		return fwp_theme_shortcodes::HeroTestimonials($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroTeam')){
	function FWP_Shortcode_HeroTeam($atts, $content){
		return fwp_theme_shortcodes::HeroTeam($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroClients')){
	function FWP_Shortcode_HeroClients($atts, $content){
		return fwp_theme_shortcodes::HeroClients($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroContactInfo')){
	function FWP_Shortcode_HeroContactInfo($atts, $content){
		return fwp_theme_shortcodes::HeroContactInfo($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroServices')){
	function FWP_Shortcode_HeroServices($atts, $content){
		return fwp_theme_shortcodes::HeroServices($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroPriceTable')){
	function FWP_Shortcode_HeroPriceTable($atts, $content){
		return fwp_theme_shortcodes::HeroPriceTable($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroPortfolio')){
	function FWP_Shortcode_HeroPortfolio($atts, $content){
		return fwp_theme_shortcodes::HeroPortfolio($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HerogMap')){
	function FWP_Shortcode_HerogMap($atts, $content){
		return fwp_theme_shortcodes::HerogMap($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroSliderbg')){
	function FWP_Shortcode_HeroSliderbg($atts, $content){
		return fwp_theme_shortcodes::HeroSliderbg($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroVideoBg')){
	function FWP_Shortcode_HeroVideoBg($atts, $content){
		return fwp_theme_shortcodes::HeroVideoBg($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroContactBox')){
	function FWP_Shortcode_HeroContactBox($atts, $content){
		return fwp_theme_shortcodes::HeroContactBox($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroAnimatedText')){
	function FWP_Shortcode_HeroAnimatedText($atts, $content){
		return fwp_theme_shortcodes::HeroAnimatedText($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroParallaxLetter')){
	function FWP_Shortcode_HeroParallaxLetter($atts, $content){
		return fwp_theme_shortcodes::HeroParallaxLetter($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroStellarImage')){
	function FWP_Shortcode_HeroStellarImage($atts, $content){
		return fwp_theme_shortcodes::HeroStellarImage($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroSocialIconsContainer')){
	function FWP_Shortcode_HeroSocialIconsContainer($atts, $content){
		return fwp_theme_shortcodes::HeroSocialIconsContainer($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroSocialIconsItem')){
	function FWP_Shortcode_HeroSocialIconsItem($atts, $content){
		return fwp_theme_shortcodes::HeroSocialIconsItem($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroMessage')){
	function FWP_Shortcode_HeroMessage($atts, $content){
		return fwp_theme_shortcodes::HeroMessage($atts, $content);
	}
}
if(!function_exists('FWP_Shortcode_HeroLatestProjects')){
	function FWP_Shortcode_HeroLatestProjects($atts, $content){
		return fwp_theme_shortcodes::HeroLatestProjects($atts, $content);
	}
}


global $fwp_shortcodes;

$fwp_shortcodes = array(
	'fwp_hero_tabs' =>'HeroTabs',
	'fwp_hero_tab' =>'HeroTab',
	'fwp-hero-countdown' => 'HeroCountdown',
	'fwp-hero-twitter' => 'HeroTwitter',
	'fwp-hero-subtitle' => 'HeroSubtitle',
	'fwp-hero-about-box' => 'HeroAboutBox',
	'fwp-hero-counter-box' => 'HeroCounterBox',
	'fwp-hero-testimonials' => 'HeroTestimonials',
	'fwp-hero-team' => 'HeroTeam',
	'fwp-hero-clients' => 'HeroClients',
	'fwp-hero-contact-info' => 'HeroContactInfo',
	'fwp-hero-services'	=> 'HeroServices',
	'fwp-hero-pricetable' => 'HeroPriceTable',
	'fwp-hero-portfolio'=> 'HeroPortfolio',
	'fwp_hero_socialicons_container'=> 'HeroSocialIconsContainer',
	'fwp_hero_socialicons_item'=> 'HeroSocialIconsItem',
	'fwp-hero-button'	=> 'HeroButton',
	'fwp-hero-titlewithserif'=> 'HeroTitleSerif',
	'fwp-hero-subitle'=> 'HeroSubitle',
	'fwp-hero-separator'=> 'HeroSeparator',
	'fwp-hero-map' => 'HerogMap',
	'fwp-hero-sliderbg' => 'HeroSliderbg',
	'fwp-hero-videobg' =>'HeroVideoBg',
	'fwp-hero-contact-box' => 'HeroContactBox',
	'fwp-hero-animatedtext' =>'HeroAnimatedText',
	'fwp-hero-parallaxletter' =>'HeroParallaxLetter',
	'fwp-hero-stellarimage' =>'HeroStellarImage',
	'fwp-hero-message'	=> 'HeroMessage',
    'fwp-hero-latest-projects' => 'HeroLatestProjects'
);
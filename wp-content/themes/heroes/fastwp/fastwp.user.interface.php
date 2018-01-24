<?php
class FastWP_UI {
	static function getMenu($id = '', $class = 'menu', $echo = true){
	    return wp_nav_menu(array(
	        'theme_location'    => 'primary', //menu id
			'container'		=> null,
			'menu_class' 	=> $class, 
			'menu_id' 		=> $id,
			'echo'			=> $echo,
			'fallback_cb'   => array('Walker_Menu_FastWP','do_default_page_menu'),
	        'walker'  		=> new Walker_Menu_FastWP()
	    ));
	} 

	static function getAffixSize(){
		global $fwp_data;
		$c_page_tpl		= (is_page() || is_single())? basename(get_page_template()) : '';

		if($c_page_tpl == 'template-one-page.php'){
			return (isset($fwp_data['fwp_affix_onepage']) && is_numeric($fwp_data['fwp_affix_onepage']))? $fwp_data['fwp_affix_onepage'] : 50;
		} elseif(is_front_page() || is_home()){
			return (isset($fwp_data['fwp_affix_home']) && is_numeric($fwp_data['fwp_affix_home']))? $fwp_data['fwp_affix_home'] : 0;
		} elseif(is_page()) {
			return (isset($fwp_data['fwp_affix_page']) && is_numeric($fwp_data['fwp_affix_page']))? $fwp_data['fwp_affix_page'] : 0;
		} else {
			return (isset($fwp_data['fwp_affix_blog']) && is_numeric($fwp_data['fwp_affix_blog']))? $fwp_data['fwp_affix_blog'] : 0;
		}

		return 0;
	}

	static function displayMenu($id = '', $class = 'menu', $echo = true){
		global $fwp_data;
		$c_page_tpl		= (is_page() || is_single())? basename(get_page_template()) : '';
		$blank_markup 	= '<nav class="navbar navbar-default navbar-fixed-top" role="navigation" data-spy="affix" data-offset-top="%s"><div class="container-fluid"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="%s" %s>%s</a> </div><div class="collapse navbar-collapse navbar-right" id="navbar-collapse">%s</div> </div></nav>';

		$offset 		= UI_getAffixSize();
		$scrollOrNot 	= ($c_page_tpl == 'template-one-page.php')? ' data-scroll':'';

		$textLogoValue 	= (isset($fwp_data['fwp_text_logo']))? fwp_utils::fwp_escape( $fwp_data['fwp_text_logo'] ) :'<span class="serif">H</span>ERO';
		$TextOrLogo 	= (isset($fwp_data['fwp_logo']) && !empty($fwp_data['fwp_logo']['url'])) ? $fwp_data['fwp_logo'] : $textLogoValue;
		
		if(is_array($TextOrLogo)){
			$logoImg 	= (isset($TextOrLogo['url']))? $TextOrLogo['url'] : '';
			$extraStyle = (isset($fwp_data['fwp_margin_top_logo']) && $fwp_data['fwp_margin_top_logo'] != '0')? sprintf('style="margin-top:%spx;"', $fwp_data['fwp_margin_top_logo']):'';
			$TextOrLogo = sprintf('<img src="%s" %s>', $logoImg, $extraStyle);
		}

		$logoTargetUrl = (isset($fwp_data['fwp_logotarget']) && !empty($fwp_data['fwp_logotarget']))? $fwp_data['fwp_logotarget'] : site_url().'#';
		$menu_markup 	= sprintf($blank_markup, $offset,$logoTargetUrl,$scrollOrNot, $TextOrLogo, UI_getMenu($id, $class, false));



		if($echo == false){
			return 	$menu_markup;
		} else {
			echo 	$menu_markup;
		}
	}

	static function getPreloaderMarkup(){
		global $fwp_data;

        do_action('fwp_enqueue_script', 'preloader'); // Conditional load scripts

		$preloaderImg = ( !empty( $fwp_data['preloader_logo']['url'] ) ? $fwp_data['preloader_logo']['url'] : fwp_main_theme_url.'/assets/img/logoWhite.png' );
		return sprintf('        <div class="ip-header">
            <div class="black-overlay"></div>
            <div class="ip-logo">
                <img class="img-responsive preloaderLogo center-block" src="%s" alt="preloader">
            </div>

            <div class="ip-loader">
                <svg class="ip-inner" width="50px" height="50px" viewBox="0 0 80 80">
                    <path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
                    <path id="ip-loader-circle" class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
                </svg>
            </div>
        </div>', $preloaderImg);
	}

	static function showPreloader($forceVisible = false){
		global $fwp_data;
		$forceVisible = (
				$forceVisible == true || 
				(
					isset($fwp_data['show_preloader']) && 
					$fwp_data['show_preloader'] == 1 && 
					(
						is_front_page() || 
						!isset($fwp_data['disable_inner_preloader']) || 
						(isset($fwp_data['disable_inner_preloader']) && $fwp_data['disable_inner_preloader'] != 1) 
					) && (
						UI_getPreloaderStatusForCurrentPage()
					)
				))? true : false;
		if($forceVisible == true){
			echo UI_getPreloaderMarkup();
			do_action('fwp_after_preloader');
		}
	}

	static function getPreloaderStatusForCurrentPage(){
		return true;
	}

	static function getNavMenuItems($showHome = '0'){
		/* Get data */
		$menu_locations 	= get_nav_menu_locations();
		$menu_query_args 	= array('order'=>'ASC', 'orderby'=>'menu_order', 'post_type'=>'nav_menu_item', 'post_status'=>'publish', 'output_key'=>'menu_order', 'nopaging'=>true, 'update_post_term_cache'=>false );
		$primary_menu		= (isset($menu_locations) && isset($menu_locations['primary']))? $menu_locations['primary'] : '';
		$menu_items 		= wp_get_nav_menu_items($primary_menu, $menu_query_args );
		/* Add home button if needed */
		if($showHome === '1'){
			$menu_home_item 		= new stdClass;
			$menu_home_item->title 	= esc_html__('Home' ,'heroes');
			$menu_home_item->url 	= home_url('/');
			$menu_home_item->type 	= null;
			$menu_home_item->object_id 	= null;
			$menu_home_item->menutype 	= null;
			$menu_items 			= array_merge(array($menu_home_item), $menu_items);
		}

		return $menu_items;      
	}

	static function displayMultipage($menu_after_first_section=false){
		global $fwp_custom_shortcode_css;

		do_action('fastwp_before_generate_sections');
		$menu = sprintf('<header>%s</header>',UI_displayMenu('','nav navbar-nav', false));
		$sections_and_pages = UI_getNavMenuItems(0);
		if(!is_array($sections_and_pages)){
			do_action('_fastwp_no_sections_defined');
			return;
		}
		$sections_and_pages = apply_filters('fwp_filter_sections', $sections_and_pages);

		/* Remove from list individual pages */
		$sections = array();
		for($i=0;$i<count($sections_and_pages);$i++){
			$type = get_post_meta( $sections_and_pages[$i]->ID, '_menu_item_menutype', true );
			if(isset($type) && $type != '' && $type != 'page'){
				$sections[] = $sections_and_pages[$i];
			}
		}

		$sections_and_pages = $sections;
		$content = '';
		$demo_found = false;
		for($i=0;$i<count($sections_and_pages);$i++){

			if(($i==0 && $menu_after_first_section==false) || ($i==1 && $menu_after_first_section==true)){
				$content .= $menu;
			}
			if($sections_and_pages[$i]->xfn == 'demo'){
				if(isset($_REQUEST['demo_id'])&&!empty($_REQUEST['demo_id'])){
		    		if($_REQUEST['demo_id'] != $sections_and_pages[$i]->object_id) {
		    			continue;
		    		}
		    	} else {
		    		if($demo_found == false){
		    			$demo_found = true;
		    		} else {
		    			continue;
		    		}
		    	}
	    	}

	    	/* Get Visual Composer meta style just if composer is installed and enabled */
	    	if(defined('WPB_VC_VERSION')){
				$fwp_custom_shortcode_css 	.= get_post_meta( $sections_and_pages[$i]->object_id, '_wpb_shortcodes_custom_css', true );
				$fwp_custom_shortcode_css 	.= get_post_meta( $sections_and_pages[$i]->object_id, '_wpb_post_custom_css', true );
			}

			/* Get page template name */
			$template 				= get_post_meta( $sections_and_pages[$i]->object_id, '_wp_page_template', true );
			/* Get section page object */
			$section_page 			= get_page($sections_and_pages[$i]->object_id);

			if($template == 'template-page-boxed.php'){
				$content_template 	= '<div class="container"><div class="row">%s</div></div>';
			}else {
				$content_template 	= '%s';
			}

			$section_ori_class		= ($template === 'template-page-nobg.php')? "clearfix no-bg-color" : "clearfix";
			$section_id 			= FastWP::getMenuSectionId($sections_and_pages[$i]);
			$section_class			= apply_filters('fwp_page_class', $section_ori_class, $sections_and_pages[$i]->object_id);
			$section_content 		= sprintf($content_template, apply_filters('the_content',$section_page->post_content));
			$section_content		= apply_filters('fastwp_filter_section_content', $section_content, $sections_and_pages[$i]);

			$temp_section 			= sprintf('<section id="%s" class="%s">%s</section>', $section_id, $section_class, $section_content);
			$content 				.= apply_filters('fastwp_filter_section_output', $temp_section);
			$temp_section 			= '';

			do_action('fwp_after_page_content', $sections_and_pages[$i]->object_id, '#'.$section_id);
		}

		do_action('fastwp_sections_generated');

		echo $content;
	}

	static function add_custom_css(){

		global $fwp_custom_shortcode_css, $fwp_data;

		$fwp_custom_shortcode_css .= (isset($fwp_data['custom_css']))? $fwp_data['custom_css'] : '';

		if(isset($fwp_data['nav_bg_color']) && !empty($fwp_data['nav_bg_color'])){
			if(is_array($fwp_data['nav_bg_color'])){
				$fwp_data['nav_bg_color'] = FastWP::hex2rgba($fwp_data['nav_bg_color']['color'],$fwp_data['nav_bg_color']['alpha']);
			}
			$fwp_custom_shortcode_css .= sprintf('nav.navbar.affix { background-color:%s;}', $fwp_data['nav_bg_color']);

		}

        if( !empty( $fwp_data['body_font'] ) ) {
            $body_font = array();
            $body_font[] = !empty( $fwp_data['body_font']['font-family'] ) ? 'font-family: ' . $fwp_data['body_font']['font-family'] . '!important' : '';
            $body_font[] = !empty( $fwp_data['body_font']['font-weight'] ) ? 'font-weight: ' . $fwp_data['body_font']['font-weight'] . '!important' : '';
            $body_font[] = !empty( $fwp_data['body_font']['text-align'] ) ? 'text-align: ' . $fwp_data['body_font']['text-align'] . '!important' : '';
            $body_font[] = !empty( $fwp_data['body_font']['font-size'] ) ? 'font-size: ' . $fwp_data['body_font']['font-size'] . '!important' : '';
            $body_font[] = !empty( $fwp_data['body_font']['line-height'] ) ? 'line-height: ' . $fwp_data['body_font']['line-height'] . '!important' : '';
            $body_font[] = !empty( $fwp_data['body_font']['color'] ) ? 'color: ' . $fwp_data['body_font']['color'] . '!important' : '';
            if( !empty( $body_font ) ) {
                $fwp_custom_shortcode_css .= sprintf( 'body{%s}', implode( '; ', array_filter( $body_font ) ) );
            }
        }
        if( !empty( $fwp_data['h1_font'] ) ) {
            $h1_font = array();
            $h1_font[] = !empty( $fwp_data['h1_font']['font-family'] ) ? 'font-family: ' . $fwp_data['h1_font']['font-family'] . '!important' : '';
            $h1_font[] = !empty( $fwp_data['h1_font']['font-weight'] ) ? 'font-weight: ' . $fwp_data['h1_font']['font-weight'] . '!important' : '';
            $h1_font[] = !empty( $fwp_data['h1_font']['text-align'] ) ? 'text-align: ' . $fwp_data['h1_font']['text-align'] . '!important' : '';
            $h1_font[] = !empty( $fwp_data['h1_font']['font-size'] ) ? 'font-size: ' . $fwp_data['h1_font']['font-size'] . '!important' : '';
            $h1_font[] = !empty( $fwp_data['h1_font']['line-height'] ) ? 'line-height: ' . $fwp_data['h1_font']['line-height'] . '!important' : '';
            $h1_font[] = !empty( $fwp_data['h1_font']['color'] ) ? 'color: ' . $fwp_data['h1_font']['color'] . '!important' : '';
            if( !empty( $h1_font ) ) {
                $fwp_custom_shortcode_css .= sprintf( 'h1{%s}', implode( '; ', array_filter( $h1_font ) ) );
            }
        }
        if( !empty( $fwp_data['h2_font'] ) ) {
            $h2_font = array();
            $h2_font[] = !empty( $fwp_data['h2_font']['font-family'] ) ? 'font-family: ' . $fwp_data['h2_font']['font-family'] . '!important' : '';
            $h2_font[] = !empty( $fwp_data['h2_font']['font-weight'] ) ? 'font-weight: ' . $fwp_data['h2_font']['font-weight'] . '!important' : '';
            $h2_font[] = !empty( $fwp_data['h2_font']['text-align'] ) ? 'text-align: ' . $fwp_data['h2_font']['text-align'] . '!important' : '';
            $h2_font[] = !empty( $fwp_data['h2_font']['font-size'] ) ? 'font-size: ' . $fwp_data['h2_font']['font-size'] . '!important' : '';
            $h2_font[] = !empty( $fwp_data['h2_font']['line-height'] ) ? 'line-height: ' . $fwp_data['h2_font']['line-height'] . '!important' : '';
            $h2_font[] = !empty( $fwp_data['h2_font']['color'] ) ? 'color: ' . $fwp_data['h2_font']['color'] . '!important' : '';
            if( !empty( $h2_font ) ) {
                $fwp_custom_shortcode_css .= sprintf( 'h2{%s}', implode( '; ', array_filter( $h2_font ) ) );
            }
        }
        if( !empty( $fwp_data['h3_font'] ) ) {
            $h3_font = array();
            $h3_font[] = !empty( $fwp_data['h3_font']['font-family'] ) ? 'font-family: ' . $fwp_data['h3_font']['font-family'] . '!important' : '';
            $h3_font[] = !empty( $fwp_data['h3_font']['font-weight'] ) ? 'font-weight: ' . $fwp_data['h3_font']['font-weight'] . '!important' : '';
            $h3_font[] = !empty( $fwp_data['h3_font']['text-align'] ) ? 'text-align: ' . $fwp_data['h3_font']['text-align'] . '!important' : '';
            $h3_font[] = !empty( $fwp_data['h3_font']['font-size'] ) ? 'font-size: ' . $fwp_data['h3_font']['font-size'] . '!important' : '';
            $h3_font[] = !empty( $fwp_data['h3_font']['line-height'] ) ? 'line-height: ' . $fwp_data['h3_font']['line-height'] . '!important' : '';
            $h3_font[] = !empty( $fwp_data['h3_font']['color'] ) ? 'color: ' . $fwp_data['h3_font']['color'] . '!important' : '';
            if( !empty( $h3_font ) ) {
                $fwp_custom_shortcode_css .= sprintf( 'h3{%s}', implode( '; ', array_filter( $h3_font ) ) );
            }
        }
        if( !empty( $fwp_data['h4_font'] ) ) {
            $h4_font = array();
            $h4_font[] = !empty( $fwp_data['h4_font']['font-family'] ) ? 'font-family: ' . $fwp_data['h4_font']['font-family'] . '!important' : '';
            $h4_font[] = !empty( $fwp_data['h4_font']['font-weight'] ) ? 'font-weight: ' . $fwp_data['h4_font']['font-weight'] . '!important' : '';
            $h4_font[] = !empty( $fwp_data['h4_font']['text-align'] ) ? 'text-align: ' . $fwp_data['h4_font']['text-align'] . '!important' : '';
            $h4_font[] = !empty( $fwp_data['h4_font']['font-size'] ) ? 'font-size: ' . $fwp_data['h4_font']['font-size'] . '!important' : '';
            $h4_font[] = !empty( $fwp_data['h4_font']['line-height'] ) ? 'line-height: ' . $fwp_data['h4_font']['line-height'] . '!important' : '';
            $h4_font[] = !empty( $fwp_data['h4_font']['color'] ) ? 'color: ' . $fwp_data['h4_font']['color'] . '!important' : '';
            if( !empty( $h4_font ) ) {
                $fwp_custom_shortcode_css .= sprintf( 'h4{%s}', implode( '; ', array_filter( $h4_font ) ) );
            }
        }
        if( !empty( $fwp_data['h5_font'] ) ) {
            $h5_font = array();
            $h5_font[] = !empty( $fwp_data['h5_font']['font-family'] ) ? 'font-family: ' . $fwp_data['h5_font']['font-family'] . '!important' : '';
            $h5_font[] = !empty( $fwp_data['h5_font']['font-weight'] ) ? 'font-weight: ' . $fwp_data['h5_font']['font-weight'] . '!important' : '';
            $h5_font[] = !empty( $fwp_data['h5_font']['text-align'] ) ? 'text-align: ' . $fwp_data['h5_font']['text-align'] . '!important' : '';
            $h5_font[] = !empty( $fwp_data['h5_font']['font-size'] ) ? 'font-size: ' . $fwp_data['h5_font']['font-size'] . '!important' : '';
            $h5_font[] = !empty( $fwp_data['h5_font']['line-height'] ) ? 'line-height: ' . $fwp_data['h5_font']['line-height'] . '!important' : '';
            $h5_font[] = !empty( $fwp_data['h5_font']['color'] ) ? 'color: ' . $fwp_data['h5_font']['color'] . '!important' : '';
            if( !empty( $h5_font ) ) {
                $fwp_custom_shortcode_css .= sprintf( 'h5{%s}', implode( '; ', array_filter( $h5_font ) ) );
            }
        }
        if( !empty( $fwp_data['h6_font'] ) ) {
            $h6_font = array();
            $h6_font[] = !empty( $fwp_data['h6_font']['font-family'] ) ? 'font-family: ' . $fwp_data['h6_font']['font-family'] . '!important' : '';
            $h6_font[] = !empty( $fwp_data['h6_font']['font-weight'] ) ? 'font-weight: ' . $fwp_data['h6_font']['font-weight'] . '!important' : '';
            $h6_font[] = !empty( $fwp_data['h6_font']['text-align'] ) ? 'text-align: ' . $fwp_data['h6_font']['text-align'] . '!important' : '';
            $h6_font[] = !empty( $fwp_data['h6_font']['font-size'] ) ? 'font-size: ' . $fwp_data['h6_font']['font-size'] . '!important' : '';
            $h6_font[] = !empty( $fwp_data['h6_font']['line-height'] ) ? 'line-height: ' . $fwp_data['h6_font']['line-height'] . '!important' : '';
            $h6_font[] = !empty( $fwp_data['h6_font']['color'] ) ? 'color: ' . $fwp_data['h6_font']['color'] . '!important' : '';
            if( !empty( $h6_font ) ) {
                $fwp_custom_shortcode_css .= sprintf( 'h6{%s}', implode( '; ', array_filter( $h6_font ) ) );
            }
        }
        if( !empty( $fwp_data['menu_font'] ) ) {
            $nav_font = array();
            $nav_font[] = !empty( $fwp_data['menu_font']['font-family'] ) ? 'font-family: ' . $fwp_data['menu_font']['font-family'] . '!important' : '';
            $nav_font[] = !empty( $fwp_data['menu_font']['font-weight'] ) ? 'font-weight: ' . $fwp_data['menu_font']['font-weight'] . '!important' : '';
            $nav_font[] = !empty( $fwp_data['menu_font']['text-align'] ) ? 'text-align: ' . $fwp_data['menu_font']['text-align'] . '!important' : '';
            $nav_font[] = !empty( $fwp_data['menu_font']['font-size'] ) ? 'font-size: ' . $fwp_data['menu_font']['font-size'] . '!important' : '';
            $nav_font[] = !empty( $fwp_data['menu_font']['line-height'] ) ? 'line-height: ' . $fwp_data['menu_font']['line-height'] . '!important' : '';
            $nav_font[] = !empty( $fwp_data['menu_font']['color'] ) ? 'color: ' . $fwp_data['menu_font']['color'] . '!important' : '';
            if( !empty( $nav_font ) ) {
                $fwp_custom_shortcode_css .= sprintf( '#nav a{%s}', implode( '; ', array_filter( $nav_font ) ) );
            }
        }

		if ( ! empty( $fwp_custom_shortcode_css ) ) {
			echo '<style type="text/css" data-type="vc-shortcodes-custom-css">';
			echo $fwp_custom_shortcode_css;
			echo '</style>';
		}

		$fwp_custom_shortcode_css = '';

	}

	static function alert($type, $message) {
		return sprintf('<div class="alert alert-%s" role="alert">%s</div>', $type, $message);
	} 
}

class Walker_Menu_FastWP extends Walker {
   var $db_fields = array(
        'parent' => 'menu_item_parent', 
        'id'     => 'db_id' 
    );
	
	function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= ' <ul class="'.fwp_menu_child_class.' level-'.($depth + 1).'" role="menu"> ';
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= ' </ul> ';
	}
	
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    	global $fwp_demo_found;
    	$c_page_tpl		= (is_page() || is_single())? basename(get_page_template()) : '';
    	if(isset($_REQUEST['demo_id'])&&!empty($_REQUEST['demo_id'])){
    		if($_REQUEST['demo_id'] != $item->object_id && $item->xfn == 'demo') {
    			return;
    		}
    	} else {
    		if($item->xfn == 'demo'){
		    	if($fwp_demo_found == false){
		    		$fwp_demo_found = true;
		    	} else {
		    		return;
		    	}
	    	}
	    }
    	if(isset($item->post_status) && isset($item->ID) && !isset($item->object_id)){
    		$item->object_id= $item->ID;
    		$item->title 	= $item->post_title;
    		$item->url 		= get_permalink($item->ID);
    	}
		$type 				= get_post_meta( $item->ID, '_menu_item_menutype', true );
		$onepage_separator 	= false;
		$onepage_section 	= false;
		if(isset($type) && $type != '' && $type != 'page'){
			$onepage_section= true;
			if($type == 'separator'){
				$onepage_separator = true;
			}
		}
		if($onepage_separator === true) return;

		$class = $liclass = '';

		$class = ( $item->object_id === get_the_ID() )?' active ':'';
		if(isset($item->hasChildren) && $item->hasChildren){
			$liclass 	.= ' class="dropdown parent"';
			$class 		.= ' dropdown-toggle ';
		}
		$class 	.= (isset($item->classes))? implode(' ',$item->classes) :'';

		$href 	 = ($onepage_section == true && (!isset($item->object) || $item->object != 'custom'))? sprintf('#%s', FastWP::getMenuSectionId($item)) : $item->url;
		if($href != $item->url){
			if($c_page_tpl != 'template-one-page.php'){
				$href 	= site_url() . $href;
			}
		}
		if(substr_count($class,'divider-before')){
        	$output 	.= '<li class="divider"></li>';
        }
        $output 		.= sprintf( "\n<li%s><a href='%s'%s>%s</a>",
			$liclass,
            $href,
            ' class="'.$class.'" ' . 
            ((isset($item->hasChildren) && $item->hasChildren)?' data-toggle="dropdown"':'') . 
            ((isset($item->target))?sprintf(' target="%s" ', $item->target):'') . 
            ((isset($onepage_section) && $onepage_section == true && (!isset($item->hasChildren) || !$item->hasChildren))?' data-scroll="" ':'')
            ,
            $item->title . ((isset($item->hasChildren) && $item->hasChildren)?' <span class="caret"></span>':'')
        );
        if(substr_count($class,'divider-after')){
        	$output 	.= '<li class="divider"></li>';
        }
    }
	
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		global $fwp_demo_found;
		if(isset($_REQUEST['demo_id'])&&!empty($_REQUEST['demo_id'])){
    		if($_REQUEST['demo_id'] != $item->object_id && $item->xfn == 'demo') {
    			return;
    		}
    	} else {
    		if($item->xfn == 'demo'){
		    	if($fwp_demo_found == false){
		    		$fwp_demo_found = true;
		    	} else {
		    		return;
		    	}
	    	}
	    }
		$output .= '</li>';
	}


	public static function do_default_page_menu($args = array()){
		$defaults 	= array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
		$args 		= wp_parse_args( $args, $defaults );
		$args 		= apply_filters( 'wp_page_menu_args', $args );
		$menu 		= '';
		$list_args 	= $args;

		if ( ! empty($args['show_home']) ) {
			if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
				$text = esc_html__('Home','heroes');
			else
				$text = $args['show_home'];
			$class = '';
			if ( is_front_page() && !is_paged() )
				$class = 'class="current_page_item"';
			$menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
			// If the front page is a page, add it to the exclude list
			if (get_option('show_on_front') == 'page') {
				if ( !empty( $list_args['exclude'] ) ) {
					$list_args['exclude'] .= ',';
				} else {
					$list_args['exclude'] = '';
				}
				$list_args['exclude'] .= get_option('page_on_front');
			}
		}

		$list_args['echo'] = false;
		$list_args['title_li'] = '';
		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

		if ( $menu )
			$menu = '<ul class="nav navbar-nav">' . $menu . '</ul>';

		$menu = '<div class="' . esc_attr($args['menu_class']) . '">' . $menu . "</div>\n";
		$menu = apply_filters( 'wp_page_menu', $menu, $args );
		if ( $args['echo'] )
			echo $menu;
		else
			return $menu;
	} 
}


<?php
define('child_theme_url', get_stylesheet_directory_uri());
add_image_size( 'fwp-hero-latest-projects', 400, 300, true );

global $fwp_data;

if(!isset($fwp_custom_js)){
	global $fwp_custom_js;
	$fwp_custom_js = array();
}

global $fwp_load_scripts;

$fwp_load_scripts = array(
	'googleMapInit',
	'theme.scripts',
	'okvideo.min',
	'theme.init',
	'custom',
    'preloader',
	'jquery.matchHeight-min',
    'overlay',
	'scripts',
    'modernizr.custom',
	'owl.carousel.min',
    'jquery.plugin.min',
    'jquery.countdown.min',
    'jquery.hc-sticky.min',
    'http://maps.googleapis.com/maps/api/js?key=' . ( !empty( $fwp_data['fwp_gmap_key'] ) ? esc_html( $fwp_data['fwp_gmap_key'] ) : '' )
);

global $fwp_load_styles;

$fwp_load_styles = array(
	'bs/bootstrap.min',
	'bs/bootstrap-theme.min',
	'fa/font-awesome.min',
	'theme.style',
	'simple-line-icons',
	'responsive',
	'owl.carousel',
    'preloader'
);

if(isset($fwp_load_styles_child)){
	$fwp_load_styles = array_merge($fwp_load_styles, $fwp_load_styles_child);
}

if(isset($fwp_load_scripts_child)){
	$fwp_load_scripts = array_merge($fwp_load_scripts, $fwp_load_scripts_child);
}

global $fwp_custom_posts;

$fwp_custom_posts = null;

add_action('init', 'fwp_theme_init_custom_post_types',1);
function fwp_theme_init_custom_post_types(){
	global $fwp_data, $fwp_custom_posts, $fwp_metaboxes, $fwp_custom_taxonomies;

$customPortfolioSlug = (isset($fwp_data['fastwp_portfolio_slug'])) ? $fwp_data['fastwp_portfolio_slug'] : 'project';
$fwp_custom_posts = array(
	'fwp_portfolio' => array(
		'name' 				 => esc_html__( 'Portfolio', 'heroes' ),
		'single' 			 => esc_html__( 'Portfolio Item', 'heroes' ),
		'multiple' 			 => esc_html__( 'Portfolio Items', 'heroes' ),
		'settings'	=> array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $customPortfolioSlug ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail')
		)
	),
	'fwp_team' => array(
		'name' 				 => esc_html__( 'Members', 'heroes' ),
		'single' 			 => esc_html__( 'Member', 'heroes' ),
		'multiple' 			 => esc_html__( 'Members', 'heroes' ),
		'settings'	=> array(
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'member' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail')
		)
	),
	'fwp_service' => array(
		'name' 				 => esc_html__( 'Services', 'heroes' ),
		'single' 			 => esc_html__( 'Service', 'heroes' ),
		'multiple' 			 => esc_html__( 'Services', 'heroes' ),
		'settings'	=> array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'service' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'excerpt','thumbnail')
		)
	),
	'fwp_testimonial' => array(
		'name' 				 => esc_html__( 'Testimonials', 'heroes' ),
		'single' 			 => esc_html__( 'Testimonial', 'heroes' ),
		'multiple' 			 => esc_html__( 'Testimonials', 'heroes' ),
		'settings'	=> array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'testimonial' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author')
		)
	),
	
);

$fwp_custom_taxonomies = array(
	'portfolio-category' => array(
		'post_type' => 'fwp_portfolio',
		'settings' => array(
		    'hierarchical'        => true,
		    'show_ui'             => true,
		    'show_admin_column'   => true,
		    'query_var'           => true,
			'show_in_nav_menus'	  => false,
		    'rewrite'             => array( 'slug' => 'portfolio-category' )
		 )
	 ),
);
}

$fwp_metaboxes = array(
	'post' 	=> array(
		array(
			'id'		=>'fwp-post-settings',
			'title'		=>'Post settings',
			'position'	=>'advanced',
			'priority'	=>'default',
			'fields'	=>array(
				array('type'=>'div','id'=>'', 'class'=>'meta-wrap'),
					array('type'=>'div','id'=>'post-type-gallery', 'class'=>'hide-default post-type-dependant'),
						array('type'=>'gallery','id'=>'gallery','title'=>'Setup post gallery','desc'=>'Insert slides and select your images to be shown', 'class'=>''),
					array('type'=>'div-close'),
					array('type'=>'div','id'=>'post-type-image', 'class'=>'hide-default post-type-dependant'),
						array('type'=>'text-display','id'=>'image-text','title'=>'Setup post image','desc'=>'Defaults to post thumbnail. Nothing to set here.', 'class'=>''),
					array('type'=>'div-close'),
					array('type'=>'div','id'=>'post-type-0', 'class'=>'hide-default post-type-dependant'),
						array('type'=>'text-display','id'=>'standard-text','title'=>'','desc'=>'Default post type has nothing to set here.', 'class'=>''),
					array('type'=>'div-close'),
					array('type'=>'div','id'=>'post-type-audio', 'class'=>'hide-default post-type-dependant'),
						array('type'=>'text','id'=>'audio','title'=>'Set audio url','desc'=>'Insert audio url from spundcloud', 'class'=>''),
					array('type'=>'div-close'),
					array('type'=>'div','id'=>'post-type-video', 'class'=>'hide-default post-type-dependant'),
						array('type'=>'text','id'=>'video','title'=>'Set video url','desc'=>'Insert vimeo or youtube url', 'class'=>''),
					array('type'=>'div-close'),
					array('type'=>'div','id'=>'post-type-quote', 'class'=>'hide-default post-type-dependant'),
						array('type'=>'text','id'=>'author','title'=>'Set author','desc'=>'Set author or title of quote', 'class'=>''),
					array('type'=>'div-close'),
				array('type'=>'div-close'),

				)
		),
	),

	'page' 	=> array(
		array(
			'id'		=>'page-metabox',
			'title'		=>'Page / Section setup',
			'position'	=>'side',
			'priority'	=>'high',
			'fields'	=>array(
				array('type'=>'text-display','id'=>'standard-text','title'=>'','desc'=>'Set letter parallax for section. Standalone page is not affected by this setting.', 'class'=>''),
					
				array('type'=>'multi_text','id'=>'letter_parallax','title'=>'Parallax letter Settings',
					'keys'=> array(
						'text1'=>'Letter 1', 
						'ratio1'=>'Letter 1 stellar ratio', 
						'offset1'=>'Letter 1 offset', 
						'left1'=> 'Letter 1 position relative to left window side (percent)',
						'text2'=>'Letter 2', 
						'ratio2'=>'Letter 2 stellar ratio', 
						'offset2'=>'Letter 2 offset', 
						'left2'=> 'Letter 2 position relative to left window side (percent)',
						'text3'=>'Letter 3', 
						'ratio3'=>'Letter 3 stellar ratio', 
						'offset3'=>'Letter 3 offset', 
						'left3'=> 'Letter 3 position relative to left window side (percent)',
						'text4'=>'Letter 4', 
						'ratio4'=>'Letter 4 stellar ratio', 
						'offset4'=>'Letter 4 offset', 
						'left4'=> 'Letter 4 position relative to left window side (percent)',

					), 
					'defaults'=> array(
						'text1'=>'', 
						'ratio1'=>'1.5', 
						'offset1'=>'0', 
						'left1'=> '10',
						'text2'=>'',
						'ratio2'=>'0.5', 
						'offset2'=>'200', 
						'left2'=>'35',
						'text3'=>'',
						'ratio3'=>'0.25', 
						'offset3'=>'150', 
						'left3'=>'55',
						'text4'=>'',
						'ratio4'=>'0.75', 
						'offset4'=>'100', 
						'left4'=>'85',

					), 
				'class'=>''),	

				array('type'=>'colorpicker'	, 'id'=>'pcolor_t1'	, 'title'=>'Letter 1 color', 'class'=>''),
				array('type'=>'switch','id'=>'lplacement_t1','title'=>'Letter 1 after content','desc'=>'Place letter after content', 'class'=>''),
				
				array('type'=>'colorpicker'	, 'id'=>'pcolor_t2'	, 'title'=>'Letter 2 color', 'class'=>''),
				array('type'=>'switch','id'=>'lplacement_t2','title'=>'Letter 2 after content','desc'=>'Place letter after content', 'class'=>''),
				
				array('type'=>'colorpicker'	, 'id'=>'pcolor_t3'	, 'title'=>'Letter 3 color', 'class'=>''),
				array('type'=>'switch','id'=>'lplacement_t3','title'=>'Letter 3 after content','desc'=>'Place letter after content', 'class'=>''),
				
				array('type'=>'colorpicker'	, 'id'=>'pcolor_t4'	, 'title'=>'Letter 4 color', 'class'=>''),
				array('type'=>'switch','id'=>'lplacement_t4','title'=>'Letter 4 after content','desc'=>'Place letter after content', 'class'=>''),

				array('type'=>'colorpicker'	, 'id'=>'section_bg'	, 'title'=>'Section Background', 'class'=>''),
				
				array('type'=>'select'	, 'id'=>'s_padding_tpl'	, 'title'=>'Section spacing',
					'values'	=> array(
						'none'			=> 'No padding', 
						'small-space'	=> 'Small padding', 
						'mid-space'		=> 'Normal padding', 
						'big-space'		=> 'Big padding',
					)), 
					
				array('type'=>'multi_text', 'id'=>'s_padding_override', 'title'=>'Override padding',
					'keys'=> array(
						'top'	=> 'Top padding', 
						'bottom'=> 'Bottom padding', 
						'left'	=> 'Left padding', 
						'right'	=> 'Right padding',
					), 
					'defaults'=> array(
						'top'	=> '', 
						'bottom'=> '', 
						'left'	=> '', 
						'right'	=> '',
					), 
				'class'=>''),	
			)
		),
	),

	'fwp_team' => array(
		array(
			'id'		=>'team-metabox',
			'title'		=>'Member info',
			'position'	=>'side',
			'priority'	=>'default',
			'fields'	=>array(
				array('type'=>'text','id'=>'role', 'title'=>'Member role','desc'=>'', 'class'=>''),
				
			//	array('type'=>'multi_text','id'=>'social_old','title'=>'Social media','keys'=> array('facebook'=>'Facebook URL', 'twitter'=>'Twitter url'), 'class'=>''),
				array('type'=>'multi_text','id'=>'social','title'=>'Social media', 'desc'=>'Set social media icons. Format: ICON|LINK. Accepted icons: Font Awesome', 'keys'=> 'auto', 'class'=>''),
				
				)
		),
	),

	'fwp_service' => array(
		array(
			'id'		=>'service-metabox',
			'title'		=>'Service settings',
			'position'	=>'side',
			'priority'	=>'default',
			'fields'	=>array(
				array('type'=>'text','id'=>'target_url', 'title'=>'Target URL','desc'=>'Open this page when click on service title (new window)', 'class'=>''),				
				)
		),
	),

	'fwp_testimonial' => array(
		array(
			'id'		=>'testimonial-metabox',
			'title'		=>'Testimonial details',
			'position'	=>'side',
			'priority'	=>'default',
			'fields'	=>array(
				array('type'=>'text','id'=>'title', 'title'=>'Member ocupation','desc'=>'Ex: Art Director', 'class'=>''),
				array('type'=>'colorpicker','id'=>'ocupation_color', 'title'=>'Ocupation Color (Meta)','desc'=>'Select Ocupation color - default #c8c8c8', 'class'=>''),
				array('type'=>'text','id'=>'stars', 'title'=>'Star rating','desc'=>'Use full or half values. Value like 4.3 will show 4.5 stars', 'class'=>''),
				array('type'=>'colorpicker','id'=>'stars_color', 'title'=>'Star Color (Meta)','desc'=>'Select Stars Color - default #fffff', 'class'=>''),
				array('type'=>'colorpicker','id'=>'name_color', 'title'=>'Name Color (Title)','desc'=>'Select Author text color - default #fffff', 'class'=>'')
				)
		),
),

	'fwp_portfolio' => array(
		array(
			'id'		=>'portfolio-metabox',
			'title'		=>'Settings',
			'position'	=>'side',
			'priority'	=>'high',
			'fields'	=>array(
				array('type'=>'select', 'values'=>array(
						'modal'=>'Expander (in-page content)',
						'singlepage'=>'Single page',
						'new'=>'Single page (New window)',
						'lightbox'=>'Post thumbnail full',
					    ),'id'=>'open_type', 'title'=>'Open type','desc'=>'How this project should open on click', 'class'=>''),
				array('type'=>'text','id'=>'url', 'title'=>'Target url','desc'=>'Default target url is project url. You can override here', 'class'=>''),
				array('type'=>'select', 'values'=>array(
						1 => 'Yes',
						0 =>'No',
					    ),'id'=>'hero_section', 'title'=>'Title/Cateogories section','desc'=>'Enable title and categories hero section', 'class'=>''),
			),

		),
	)
);

global $fwp_required_plugins;

$fwp_required_plugins = array(
		 array(
            'name'				=> 'WPBakery Visual Composer', // The plugin name
             'slug'				=> 'js_composer', // The plugin slug (typically the folder name)
             'source'			=> get_template_directory_uri() . '/fastwp/plugins/js_composer.zip', // The plugin source
             'required'			=> true, // If false, the plugin is only 'recommended' instead of required
             'version'			=> '4.11.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
             'force_activation'	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
             'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
             'external_url'		=> '', // If set, overrides default API URL and points to an external URL
         ),
		array(
            'name'				=> 'FastWP Hero Theme extension', // The plugin name
            'slug'				=> 'fastwp-hero-theme-extension', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/fastwp/plugins/fastwp-hero-theme-extension.zip', // The plugin source
            'required'			=> true, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
		array(
            'name'				=> 'Redux for FastWP Hero extension', // The plugin name
            'slug'				=> 'fastwp-redux-hero-extension', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/fastwp/plugins/fastwp-redux-hero-extension.zip', // The plugin source
            'required'			=> true, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
		array(
            'name'				=> 'oAuth Twitter Feed for Developers', // The plugin name
            'slug'				=> 'oauth-twitter-feed-for-developers', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/fastwp/plugins/oauth-twitter-feed-for-developers.zip', // The plugin source
            'required'			=> true, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'      		=> 'Contact Form 7',
            'slug'      		=> 'contact-form-7',
            'required'  		=> true,
            'force_activation'  => false,
        ),
    );

global $fwp_custom_posts_with_id;

$fwp_custom_posts_with_id 	= array('fwp_team','fwp_service','fwp_portfolio','fwp_testimonial');

$fwp_themeUrl 				= (defined('child_theme_url'))? child_theme_url : get_template_directory_uri();
$fwp_vc_css_url 			= $fwp_themeUrl . '/assets/css/admin.vc.css';

require_once get_template_directory() . '/extend/extend.actions.php';
require_once get_template_directory() . '/extend/extend.filters.php';
require_once get_template_directory() . '/extend/extend.shortcodes.php';
require_once get_template_directory() . '/extend/extend.visual-composer.php';
require_once get_template_directory() . '/extend/extend.blog.php';
<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('FastWP_Redux_Framework_config')) {

    class FastWP_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            $this->initSettings();

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();


            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);

            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

            // Dynamically add a section. Can be also used to modify sections/fields
            // add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field   set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {

        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            /*$sections[] = array(
                'title' => __('Section via hook', 'fastwp'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'fastwp'),
                'icon' => 'el-icon-paper-clip',
                'fields' => array()
            );*/

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
         //   $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        public function setSections() {


            $this->sections[] = array(
                'icon'      => 'el-icon-wrench',
                'title'     => __('General', 'fastwp'),
                'fields'    => array(

                    array(
                        'id'        => 'opt-info-field',
                        'type'      => 'info',
                        'title'  => __('Welcome to Hero Options Panel.', 'fastwp'),
                        'desc'      => __('It is meant to make your life easier by offering you options which will customize your website. Here you can set all general options that affects entire website.', 'fastwp')
                    ),

					array(
                        'id'        => 'fwp_logotarget',
                        'type'      => 'text',
                        'title'     => __('Custom logo target', 'fastwp'),
                        'subtitle'  => ''
                    ),

                    array(
                        'id'        => 'fwp_favicon',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Custom Favicon', 'fastwp'),
                        'subtitle'  => __('Upload a 32px x 32px Png/Gif image that will represent your website`s favicon.', 'fastwp')  ,
                        'default'   => array('url' => fwp_hero_main_theme_url.'/assets/img/favicon-32x32.png')
                    ),



                    array(
                        'id'        => 'show_preloader',
                        'type'      => 'switch',
                        'title'     => __('Show preloader', 'fastwp'),
                        'subtitle'  => __('Enable/Disable preloader.', 'fastwp'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),
                    array(
                        'id'        => 'disable_inner_preloader',
                        'type'      => 'switch',
                        'title'     => __('Disable on inner pages', 'fastwp'),
                        'subtitle'  => __('Disable preloader on any page except homepage.', 'fastwp'),
                        'required'  => array('show_preloader', '=', '1'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),
                    array(
                        'id'        => 'preloader_logo',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Custom Preloader Logo', 'fastwp'),
                        'subtitle'  => __('Upload an image that will represent your preloader logo.', 'fastwp'),
                        'required'  => array('show_preloader', '=', '1'),
                        'default'   => array('url' => fwp_hero_main_theme_url.'/assets/img/logoWhite.png')
                    ),
                    array(
                        'id'       => 'preloader_background',
                        'type'     => 'background',
                        'title'    => __('Preloader Background color', 'fastwp'),
                        'subtitle' => __('Preloader background color, etc.', 'fastwp'),
                        'required'  => array('show_preloader', '=', '1'),
                        'default'  => array(
                            'background-color' => '#1d1d1d',
                        ),
                        'output'   => '.ip-header'
                    ),

                    array(
                        'id'        => 'fwp_preloader_bg_svg_color',
                        'type'      => 'color',
                        'title'     => __('Circle Background Color', 'fastwp'),
                        'subtitle'  => __('Select bacgrkound color for radial loader ', 'fastwp'),
                        // 'output'    => array('.ip-header .ip-loader svg path.ip-loader-circlebg'),
                        'default'   => '#ddd',
                    ),

                       array(
                        'id'        => 'fwp_preloader_svg_inner_color',
                        'type'      => 'color',
                        'title'     => __('Circle Color', 'fastwp'),
                        'subtitle'  => __('Select color for radial loader ', 'fastwp'),
                        // 'output'    => array('.ip-header .ip-loader svg path.ip-loader-circle'),
                        'default'   => '#046674',
                    ),

                    array(
                        'id'        => 'fwp_gmap_key',
                        'type'      => 'text',
                        'title'     => __('Google Maps API Key', 'fastwp'),
                        'subtitle'  => __('<a href="https://www.youtube.com/watch?v=-UCHsqxBqwY" target="_blank">How to generate your api key ?</a>', 'fastwp'),
                        'default'   => ''
                    ),
                    array(
                        'id'        => 'fwp_affix_onepage',
                        'type'      => 'text',
                        'title'     => __('OnePage Menu Affix size', 'fastwp'),
                        'subtitle'  => __('Scroll size to be passed before menu will go opaque (in px).', 'fastwp'),
                        'default'   => '50'
                    ),

                    array(
                        'id'        => 'fwp_affix_home',
                        'type'      => 'text',
                        'title'     => __('Homepage Menu Affix size', 'fastwp'),
                        'subtitle'  => __('Scroll size to be passed before menu will go opaque (in px).', 'fastwp'),
                        'default'   => '0'
                    ),

                    array(
                        'id'        => 'fwp_affix_page',
                        'type'      => 'text',
                        'title'     => __('Page Menu Affix size', 'fastwp'),
                        'subtitle'  => __('Scroll size to be passed before menu will go opaque (in px).', 'fastwp'),
                        'default'   => '0'
                    ),

                    array(
                        'id'        => 'fwp_affix_blog',
                        'type'      => 'text',
                        'title'     => __('Blog Menu Affix size', 'fastwp'),
                        'subtitle'  => __('Scroll size to be passed before menu will go opaque (in px).', 'fastwp'),
                        'default'   => '0'
                    ),


                    array(
                        'id'        => 'custom_css',
                        'type'      => 'textarea',
                        'title'     => __('Custom CSS', 'fastwp'),
                        'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', 'fastwp'),
                        'validate'  => 'css',
                    ),
                    array(
                        'id'        => 'info_bubble_1_text',
                        'type'      => 'editor',
                        'required'  => array('use_info_bubble_1', '=', '1'),
                        'title'     => __('Info bubble #1 content', 'fastwp'),
                        'subtitle'  => __('Place here your info bubble content.', 'fastwp')
                    ),
                    array(
                        'id'        => 'custom_js',
                        'type'      => 'ace_editor',
                        'title'     => __('Custom JS', 'fastwp'),
                        'subtitle'  => __('Paste your JavaScript code here. Use this field to quickly add JS code snippets.', 'fastwp'),
                        'mode'      => 'javascript',
                        'theme'     => 'chrome',
                        'default'   => ""
                    ),
                    array(
                        'id'        => 'font_montserrat',
                        'type'      => 'typography',
                        'title'     => __('Replace Montserrat font with this one:', 'fastwp'),
                        'subtitle'  => __('Select font that will replace Montserrat font site-wide', 'fastwp'),
                        'google'    => true, 'text-align'=> false, 'subsets'   => false,'color' => false,'font-weight' => false,'font-style' => false, 'font-size' => false,'line-height' => false,
                        'all_styles'=>true,
                        'default'   => array(
                            'google'      => true,
                            'font-family'   => 'Montserrat',
                        ),
                    ),
                    array(
                        'id'        => 'font_opensans',
                        'type'      => 'typography',
                        'title'     => __('Replace Open Sans font with this one:', 'fastwp'),
                        'subtitle'  => __('Select font that will replace Open Sans font site-wide', 'fastwp'),
                        'google'    => true, 'text-align'=> false, 'subsets'   => false,'color' => false,'font-weight' => false,'font-style' => false, 'font-size' => false,'line-height' => false,
                        'all_styles'=>true,
                        'default'   => array(
                            'google'      => true,
                            'font-family'   => 'Open Sans',
                        ),
                    ),
                )
            );

// Typography

            $this->sections[] = array(
                'icon' => 'el-icon-font',
                'title' => __('Typography Options', 'fastwp'),
                'fields' => array(
                    array(
                        'id' => 'body_font',
                        'type' => 'typography',
                        'title' => __('Body Font Setting', 'fastwp'),
                        'subtitle' => __('Specify the body font properties.', 'fastwp'),
                        'google' => true,
                        'default' => array(
                            'font-family' => '',
                            'font-size' => '',
                            'line-height' => '',
                            'font-weight' => '',
                            'color' => '',
                        ),
                    ),
                    array(
                        'id' => 'h1_font',
                        'type' => 'typography',
                        'title' => __('Heading 1(H1) Font Setting', 'fastwp'),
                        'subtitle' => __('Specify the H1 tag font properties.', 'fastwp'),
                        'units' => 'em',
                        'google' => true,
                        'default' => array(
                            'font-family' => '',
                            'font-weight' => '',
                            'color' => '',
                        )
                    ),

                    array(
                        'id' => 'h2_font',
                        'type' => 'typography',
                        'title' => __('Heading 2(H2) Font Setting', 'fastwp'),
                        'subtitle' => __('Specify the H2 tag font properties.', 'fastwp'),
                        'google' => true,
                        'default' => array(
                            'font-family' => '',
                            'font-weight' => '',
                            'color' => '',
                        )
                    ),

                    array(
                        'id' => 'h3_font',
                        'type' => 'typography',
                        'title' => __('Heading 3(H3) Font Setting', 'fastwp'),
                        'subtitle' => __('Specify the H3 tag font properties.', 'fastwp'),
                        'google' => true,
                        'default' => array(
                            'font-family' => '',
                            'font-weight' => '',
                            'color' => '',
                        )
                    ),

                    array(
                        'id' => 'h4_font',
                        'type' => 'typography',
                        'title' => __('Heading 4(H4) Font Setting', 'fastwp'),
                        'subtitle' => __('Specify the H4 tag font properties.', 'fastwp'),
                        'google' => true,
                        'default' => array(
                            'font-family' => '',
                            'font-weight' => '',
                            'color' => '',
                        )
                    ),

                    array(
                        'id' => 'h5_font',
                        'type' => 'typography',
                        'title' => __('Heading 5(H5) Font Setting', 'fastwp'),
                        'subtitle' => __('Specify the H5 tag font properties.', 'fastwp'),
                        'google' => true,
                        'default' => array(
                            'font-family' => '',
                            'font-weight' => '',
                            'color' => '',
                        )
                    ),
                    array(
                        'id' => 'h6_font',
                        'type' => 'typography',
                        'title' => __('Heading 6(H6) Font Setting', 'fastwp'),
                        'subtitle' => __('Specify the H6 tag font properties.', 'fastwp'),
                        'google' => true,
                        'default' => array(
                            'font-family' => '',
                            'font-weight' => '',
                            'color' => '',
                        )
                    ),
                    array(
                        'id' => 'menu_font',
                        'type' => 'typography',
                        'title' => __('Menu Font Setting', 'fastwp'),
                        'subtitle' => __('Specify the font properties for menu links.', 'fastwp'),
                        'google' => true,
                        'default' => array(
                            'font-family' => '',
                            'font-weight' => '',
                            'color' => '',
                        )
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-th-list',
                'title'     => __('Blog', 'fastwp'),
                'fields'    => array(

                    array(
                        'id'        => 'opt-info-field2',
                        'type'      => 'info',
                        'title'  => __('Blog settings.', 'fastwp'),
                        'desc'      => __('All settings that affect just blog are present here.', 'fastwp')
                    ),


                    array(
                        'id'        => 'fwp_default_blog_title',
                        'type'      => 'text',
                        'title'     => __('Blog title', 'fastwp'),
                        'subtitle'  => __('Title to show on blog index (This don`t affect archive pages)', 'fastwp'),
                        'default'   => 'Blog'
                    ),
                    array(
                        'id'        => 'fwp_show_blog_hero',
                        'type'      => 'switch',
                        'title'     => __('Show blog hero section', 'fastwp'),
                        'subtitle'  => __('This setting affects all archive pages (Archive, Category, Author, Tag)', 'fastwp'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),
                    array(
                        'id'        => 'fwp_show_blog_title',
                        'type'      => 'switch',
                        'title'     => __('Show blog title', 'fastwp'),
                        'subtitle'  => __('This setting affects all archive pages (Archive, Category, Author, Tag)', 'fastwp'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                        'required'  => array('fwp_show_blog_hero', '=', 1)
                    ),
                    array(
                        'id'        => 'fwp_blog_description_page',
                        'type'      => 'select',
                        'title'     => __('Blog description page', 'fastwp'),
                        'subtitle'  => __('Choose one of your pages to be present in all blog pages below blog title', 'fastwp'),
                        'options'   => FastWP_Hero_getPostIdAndTitle(),
                        'required'  => array('fwp_show_blog_hero', '=', 1)
                    ),
                     array(
                        'id'        => 'fwp_blog_author_meta',
                        'type'      => 'switch',
                        'title'     => __('Show Author Info Box', 'fastwp'),
                        'subtitle'  => __('Shows or hides the post author in blog page.', 'fastwp'),
                        'on'        => 'Yes',
                        'off'       => 'No',
                        'default'   => true
                    ),
                    array(
                        'id'        => 'fwp_blog_category_meta',
                        'type'      => 'switch',
                        'title'     => __('Show Category Info Box', 'fastwp'),
                        'subtitle'  => __('Shows or hides the post category in blog page.', 'fastwp'),
                        'on'        => 'Yes',
                        'off'       => 'No',
                        'default'   => true
                    ),
                       array(
                        'id'        => 'fwp_blog_date_meta',
                        'type'      => 'switch',
                        'title'     => __('Show Date Info Box', 'fastwp'),
                        'subtitle'  => __('Shows or hides the post date in blog page.', 'fastwp'),
                        'on'        => 'Yes',
                        'off'       => 'No',
                        'default'   => true
                    ),

                    /**
                        Future development
                    */
                    /*
                    array(
                        'id'        => 'fwp_show_description',
                        'type'      => 'switch',
                        'title'     => __('Show description when available', 'fastwp'),
                        'subtitle'  => __('Show category description instead of page set above when description is available', 'fastwp'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),*/
                    array(
                        'id'        => 'fwp_blog_type',
                        'type'      => 'select',
                        'title'     => __('Blog layout', 'fastwp'),
                        'subtitle'  => __('Choose one of blog layouts', 'fastwp'),
                        'options'   => array('blogPost'=>'Layout 1 (No sidebar)','blogPost2'=>'Layout 2 (Masonry)','blogPost3'=>'Layout 3 (Block)'),
                        'default'   => 'blogPost'
                    ),
                    array(
                        'id'        => 'fwp_sidebar_pos',
                        'type'      => 'select',
                        'title'     => __('Sidebar position', 'fastwp'),
                        'subtitle'  => __('Choose sidebar position', 'fastwp'),
                        'options'   => array('right'=>'Right',''=>'None','left'=>'Left'),
                        'default'   => 'right'
                    ),
                    array(
                        'id'        => 'fwp_single_type',
                        'type'      => 'select',
                        'title'     => __('Blog post style', 'fastwp'),
                        'subtitle'  => __('Choose between full image header and normal layout', 'fastwp'),
                        'options'   => array('default'=>'Default','image'=>'Full image',),
                        'default'   => 'right'
                    ),
                )
            );

              $this->sections[] = array(
                'icon'      => 'el-icon-bookmark',
                'title'     => __('Header', 'fastwp'),
                'fields'    => array(
                        array(
                        'id'        => 'fwp_text_logo',
                        'type'      => 'text',
                        'title'     => __('Logo text', 'fastwp'),
                        'subtitle'  => __('Here you can set a text as site logo. Default: <span class="serif">H</span>ERO ', 'fastwp'),
                     //   'desc'      => __('', 'fastwp'),
                     //   'validate'  => 'numeric',
                        'default'   => '<span class="serif">H</span>ERO'
                    ),
                    array(
                        'id'        => 'fwp_text_logo_font',
                        'type'      => 'typography',
                        'title'     => __('Logo font family', 'fastwp'),
                        'subtitle'  => __('Select font family size and color for logo text', 'fastwp'),
                        'google'    => true, 'text-align'=> false, 'subsets'   => false,'color' => true,'font-weight' => false,'font-style' => false, 'font-size' => true,'line-height' => false,
                        'all_styles'=>true,
                        'units'       =>'px',
                        'output'    => array('.navbar-default .navbar-brand'),
                        'default'   => array(
                            'font-family'   => 'Montserrat',
                            'font-weight'   => '700',
                            'color'         => '#fff',
                            'font-size'     => '18px'
                        )
                    ),
                    array(
                        'id'        => 'fwp_top_text_logo_color',
                        'type'      => 'color',
                        'title'     => __('Top Text Logo Color', 'fastwp'),
                        'subtitle'  => __('Select color for logo text', 'fastwp'),
                        'output'    => array('.navbar-default.affix-top .navbar-brand'),
                        'default'   => '#fff',
                    ),
                    array(
                        'id'        => 'fwp_top_text_logo_color_hover',
                        'type'      => 'color',
                        'title'     => __('Top Text Logo Color Hover', 'fastwp'),
                        'subtitle'  => __('Select color for logo text on mouse hover', 'fastwp'),
                        'output'    => array('.navbar-default.affix-top .navbar-brand:hover'),
                        'default'   => '#d5d5d5',
                    ),
                    array(
                        'id'        => 'fwp_text_logo_color',
                        'type'      => 'color',
                        'title'     => __('Text Logo Color', 'fastwp'),
                        'subtitle'  => __('Select color for logo text', 'fastwp'),
                        'output'    => array('.navbar-default .navbar-brand'),
                        'default'   => '#ababab',
                    ),
                    array(
                        'id'        => 'fwp_text_logo_color_hover',
                        'type'      => 'color',
                        'title'     => __('Text Logo Color Hover', 'fastwp'),
                        'subtitle'  => __('Select color for logo text on mouse hover', 'fastwp'),
                        'output'    => array('.navbar-default .navbar-brand:hover'),
                        'default'   => '#d5d5d5',
                    ),
                    array(
                        'id'        => 'fwp_logo',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Custom Logo', 'fastwp'),
                        'subtitle'  => __('Upload an image that will represent your website`s logo.', 'fastwp')  ,
                        'default'   => ''
                    ),

                    array(
                        'id'        => 'fwp_margin_top_logo',
                        'type'      => 'text',
                        'title'     => __('Margin-Top Value for Header`s Logo', 'fastwp'),
                        'subtitle'  => __('You can adjust the logo position in header by setting a top-margin to it. You can use negative values as well. For example, if you enter 10, the logo will be lowered by 10px. ', 'fastwp'),
                        'desc'      => __('Use numbers only', 'fastwp'),
                        'validate'  => 'numeric',
                        'default'   => '0'
                    ),
                    array(
                        'id'        => 'nav_bg_color_top',
                        'type'      => 'color_rgba',
                        'title'     => __('Top Navigation background color', 'fastwp'),
                        'subtitle'  => __('Navigation background color in top position', 'fastwp'),
                        'transparent'=>false,
                        'mode'      =>'background-color',
                        'default'   => array('color' => '', 'alpha' => '1'),
                        'output'    => 'nav.navbar.affix-top'
                     ),

                    array(
                        'id'        => 'nav_bg_color',
                        'type'      => 'color_rgba',
                        'title'     => __('Navigation background color', 'fastwp'),
                        'subtitle'  => __('Navigation background color default', 'fastwp'),
                        'transparent'=>false,
                        'mode'      =>'background-color',
                        'default'   => array('color' => '#fff', 'alpha' => '1.0'),
                     ),
                    array(
                        'id'        => 'nav_color_line',
                        'type'      => 'color',
                        'title'     => __('Navigation drop down selector color', 'fastwp'),
                        'subtitle'  => __('Navigation dropdown color for responsive layout', 'fastwp'),
                        'transparent'=>false,
                        'default'   => '#ffff',
                        'output'    => array('background-color' => '.navbar-default .navbar-toggle .icon-bar')
                     ),
                     array(
                        'id'        => 'fwp_menu_font',
                        'type'      => 'typography',
                        'title'     => __('Menu items font family', 'fastwp'),
                        'subtitle'  => __('Select font family size and color for menu items', 'fastwp'),
                        'google'    => true, 'text-align'=> false, 'subsets'   => false,'color' => false,'font-weight' => false,'font-style' => false, 'font-size' => true,'line-height' => false,
                        'all_styles'=>true,
                        'units'       =>'px',
                        'output'    => array('.navbar-default .navbar-nav>li>a'),
                        'default'   => array(
                            'font-family'   => 'Open Sans',
                            'font-weight'   => '900',
                            'font-size'     => '10px'
                        )
                    ),
                       array(
                        'id'        => 'fwp_menu_cotainer',
                        'type'      => 'text',
                        'title'     => __('Menu width', 'fastwp'),
                        'subtitle'  => __('Adjust menu container maximum width', 'fastwp'),
                        'desc'      => __('Use numbers only', 'fastwp'),
                        'validate'  => 'numeric',
                        'default'   => ''
                    ),
                    array(
                        'id'        => 'fwp_top_menu_links_color',
                        'type'      => 'link_color',
                        'title'     => __('Top Menu items color', 'fastwp'),
                        'subtitle'  => __('Select menu items colors for default, hover and active state', 'fastwp'),
                        'google'    => true, 'text-align'=> false, 'subsets'   => false,'color' => false,'font-weight' => false,'font-style' => false, 'font-size' => true,'line-height' => false,
                        'all_styles'=>true,
                        'units'       =>'px',
                        'output'    => array('.navbar-default.affix-top .navbar-nav > li > a'),
                        'default'   => array(
                                'regular'  => '#fff',
                                'hover'    => '#d5d5d5',
                                'active'   => '#d5d5d5',
                                'visited'  => '#fff'
                        )
                    ),
                    array(
                        'id'        => 'fwp_menu_links_color',
                        'type'      => 'link_color',
                        'title'     => __('Menu items color', 'fastwp'),
                        'subtitle'  => __('Select menu items colors for default, hover and active state', 'fastwp'),
                        'google'    => true, 'text-align'=> false, 'subsets'   => false,'color' => false,'font-weight' => false,'font-style' => false, 'font-size' => true,'line-height' => false,
                        'all_styles'=>true,
                        'units'       =>'px',
                        'output'    => array('.navbar-default .navbar-nav > li > a'),
                        'default'   => array(
                                'regular'  => '#777',
                                'hover'    => '#d5d5d5',
                                'active'   => '#d5d5d5',
                                'visited'  => '#d5d5d5'
                        )
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-folder',
                'title'     => __('Portfolio', 'fastwp'),
                'fields'    => array(
                    array(
                        'id'        => 'fwp_portfolio_close',
                        'type'      => 'text',
                        'title'     => __('Custom Close Icon', 'fastwp'),
                        'desc'      => __('Default: icon-close','fastwp'),
                        'default'   => 'icon-close'
                    ),
                    array(
                        'id'        => 'fastwp_portfolio_slug',
                        'type'      => 'text',
                        'title'     => __('Custom Slug', 'fastwp'),
                        'desc'      => __('Use this option in order to change the default portfolio slug (default fwp_portfolio), you need to refresh your permalink page after updating this field.','fastwp'),
                        'default'   => 'fwp_portfolio'
                    ),
                    array(
                        'id'        => 'fastwp_portfolio_single_bg',
                        'type'      => 'background',
                        'title'     => __('Portfolio Background color', 'fastwp'),
                        'subtitle'  => __('Portfolio Single Page background color for normal page', 'fastwp'),
                        'default'   => array(
                            'background-color' => '#fff',
                        ),
                        'output'    => '.single-fwp_portfolio .project-single'
                    ),
                    array(
                        'id'        => 'fastwp_portfolio_single_ajax_bg',
                        'type'      => 'background',
                        'title'     => __('Portfolio Background color', 'fastwp'),
                        'subtitle'  => __('Portfolio Single Page  background color for ajax page', 'fastwp'),
                        'default'   => array(
                            'background-color' => '#fff',
                        ),
                        'output'    => array('.overlay-slidedown.open')
                    ),

                ),
            );



            $this->sections[] = array(
                'icon'      => 'el-icon-inbox',
                'title'     => __('Footer', 'fastwp'),
                'fields'    => array(
                    array(
                        'id'        => 'before_footer_page_id',
                        'type'      => 'select',
                        'title'     => __('Content above footer', 'fastwp'),
                        'subtitle'  => __('Choose one of your pages to be present in all pages above footer area', 'fastwp'),
                        'options'   => FastWP_Hero_getPostIdAndTitle(),
                    ),
                     array(
                    'id'=>'social-media',
                    'type' => 'multi_text',
                    'title' => __('Footer social media', 'fastwp'),
                    'subtitle' => __('Set any social media networks you want', 'fastwp'),
                    'desc' => __('Format is ICON-CLASS | URL. Icon classes can be retrieved from font awesome website', 'fastwp')
                    ),
                    array(
                        'id'        => 'fwp_footer_social_media',
                        'type'      => 'color',
                        'title'     => __('Icon Colors', 'fastwp'),
                        'subtitle'  => __('Select color for social icons displayed in footer', 'fastwp'),
                        'output'    => array('#footer .socialIcon i'),
                        'default'   => '#a5a5a5',
                    ),
                    array(
                        'id'        => 'fwp_footer_social_media_background',
                        'hint'      => array (
                            'hint' => 'Use this to change social media background color'),
                        'type'      => 'background',
                        'background-attachment' =>  false,
                        'background-image' =>  false,
                        'background-size' =>  false,
                        'background-position' =>  false,
                        'background-repeat'     => false,
                        'title'     => __('Icon Background Colors', 'fastwp'),
                        'subtitle'  => __('Select background color for social icons  displayed in footer', 'fastwp'),
                        'output'    => array('#footer .socialIcon'),
                        'default'   => '#a5a5a5',
                    ),
                    array(
                        'id'        => 'fwp_footer_social_media_hover',
                        'type'      => 'color',
                        'title'     => __('Icon Colors (Hover)', 'fastwp'),
                        'subtitle'  => __('Select color for social icons displayed in footer in hover state', 'fastwp'),
                        'output'    => array('#footer .socialIcon i:hover'),
                        'default'   => '#a5a5a5',
                    ),
                    array(
                        'id'        => 'fwp_footer_social_media_background_hover',
                        'type'      => 'color',
                        'title'     => __('Icon Background Colors', 'fastwp'),
                        'subtitle'  => __('Select background color for social icons displayed in footer when icons are hovered', 'fastwp'),
                        'default'   => '',
                    ),
                     array(
                        'id'       => 'fwp_footer_background',
                        'type'     => 'background',
                        'title'    => __('Footer Background color', 'fastwp'),
                        'subtitle' => __('Footer background color, etc.', 'fastwp'),
                        'default'  => array(
                            'background-color' => '#222222',
                        ),
                        'output'   => '#footer .bottomLine'
                    ),

                    array(
                        'id'        => 'copyright',
                        'type'      => 'editor',
                     //   'required'  => array('use_info_bubble_1', '=', '1'),
                        'title'     => __('Copyright text', 'fastwp'),
                        'subtitle'  => __('Place here your copyright info.', 'fastwp')
                    ),

                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-inbox',
                'title'     => __('404 Page', 'fastwp'),
                'fields'    => array(

                    array(
                        'id'        => 'e404_bg',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Background image', 'fastwp'),
                        'subtitle'  => __('Upload image used as background in 404 error screen.', 'fastwp')  ,
                         'default'   => array('url' => fwp_hero_main_theme_url.'/assets/img/screen-1.jpg')
                    ),

                    array(
                        'id'        => 'e404_logo',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Logo image', 'fastwp'),
                        'subtitle'  => __('Upload image used as logo above 404 page text.', 'fastwp')  ,
                        'default'   => array('url' => fwp_hero_main_theme_url.'/assets/img/logoWhite.png')
                    ),

                    array(
                        'id'        => 'e404_text',
                        'type'      => 'editor',
                        'title'     => __('Error page content', 'fastwp'),
                        'subtitle'  => __('Place here your text for 404 page.', 'fastwp'),
                        'default'   => __( '<h5 class="minimal"><small>Who is a</small> Hero?</h5>
                        <p class="minimal">
                            a person, typically a man, who is admired for their courage, outstanding achievements, or noble qualities.
                        </p>
                        <a href="index.html" class="btn btn-default btn-white">
                            GO BACK
                        </a>' )
                    ),

                    array(
                        'id'        => 'e404_menu',
                        'type'      => 'switch',
                        'title'     => __('Show menu on 404 page', 'fastwp'),
                        'subtitle'  => __('', 'fastwp'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),
                    array(
                        'id'        => 'e404_override',
                        'type'      => 'switch',
                        'title'     => __('Show this page content as 404', 'fastwp'),
                        'subtitle'  => __('Override default 404 page with page content.', 'fastwp'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),
                    array(
                        'id'        => 'e404_page_id',
                        'type'      => 'select',
                        'title'     => __('Override 404', 'fastwp'),
                        'subtitle'  => __('Override default 404 page with this page content.', 'fastwp'),
                        'options'   => FastWP_Hero_getPostIdAndTitle(),
                    ),

                ),
            );





        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'fwp_data',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'submenu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'fastwp'),
                'page_title'        => __('Theme Options', 'fastwp'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyBPVwg6CaFLmKlxYjQu0bJGpxDN1p04S-Q', // Must be defined to add google fonts to the typography module

                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *

                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export'    => true, // REMOVE
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/fastwp',
                'title' => 'Follow FastWP on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://themes.fastwp.net/hero',
                'title' => 'Hero Official Page',
                'icon'  => 'el-icon-link'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'mailto:themes@fastwp.net',
                'title' => 'Send an email to FastWP',
                'icon'  => 'el-icon-envelope'
            );
        }

    }

    global $reduxConfig;
    $reduxConfig = new FastWP_Redux_Framework_config();
}

/**
Import custom settings after demo content import
**/
if ( !function_exists( 'wbc_demo_load' ) ) {
    function wbc_demo_load( $demo_active_import , $demo_directory_path ) {
        reset( $demo_active_import );
        $current_key = key( $demo_active_import );

        /* Menu import */
        $wbc_menu_array = array(
            'demo-onepage' => 'Hero One Page',
            'demo-multipage' => 'Hero MultiPage'
        );
	//	var_dump($demo_active_import[$current_key]['directory']);
	//	var_dump(in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ));

        if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && (array_key_exists($demo_active_import[$current_key]['directory'], $wbc_menu_array) || in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array )) ) {
            $top_menu = get_term_by( 'name', $wbc_menu_array[$demo_active_import[$current_key]['directory']], 'nav_menu' );
  //          var_dump($top_menu);
			if ( isset( $top_menu->term_id ) ) {
                set_theme_mod( 'nav_menu_locations', array(
                        'primary' => $top_menu->term_id
                    )
                );
            }
        }

        /* Homepage select */
        $wbc_home_pages = array(
            'demo-onepage' => 'Front Page',
            'demo-multipage' => 'Home',
        );
        if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
            $page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_on_front', $page->ID );
                update_option( 'show_on_front', 'page' );
            }
        }

        /* Blog page select */
        $wbc_home_pages = array(
            'demo-onepage' => 'Blog',
            'demo-multipage' => 'Blog',
        );
        if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
            $page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_for_posts', $page->ID );
            }
        }

    }
    add_action( 'wbc_importer_after_content_import', 'wbc_demo_load', 10, 2 );
}

/**
Set demo content path
**/

if ( !function_exists( 'wbc_change_demo_directory_path' ) ) {
    function wbc_change_demo_directory_path( $demo_directory_path ) {
        $demo_directory_path = get_template_directory().'/demo-data/';
        return $demo_directory_path;
    }

    add_filter('wbc_importer_dir_path', 'wbc_change_demo_directory_path' );
}



if ( !function_exists( 'wbc_filter_title' ) ) {
    function wbc_filter_title( $title ) {
        return ucfirst( trim( str_replace( "-", " ", str_replace('demo','',$title )) ) );
    }
    add_filter( 'wbc_importer_directory_title', 'wbc_filter_title', 10 );
}
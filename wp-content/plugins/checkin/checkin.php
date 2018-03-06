<?php
/*
Plugin Name: Checkin
Description: This plugin will allow you to check where are you at any moment, directly from your blog.
Version: 1.0
Author: GeroNikolov
Author URI: http://geronikolov.com
License: GPLv2
*/

class CHECKIN {
    function __construct(){
        // Register the Checkins CPT
        add_action( "init", array( $this, "register_checkins_cpt" ) );

        // Register scripts and styles for the Back-end part
        add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_js' ), "1.0.0", "true" );
        add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_css' ) );

		//Add scripts and styles for the Front-end part
		add_action( 'wp_enqueue_scripts', array( $this, 'register_front_JS' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_front_CSS' ) );

        // Register the Checkin Fields Metabox for the Checkins CPT
        add_action( "add_meta_boxes", array( $this, "register_checkin_metabox" ), 10, 2 );

		// Register On Update event
        add_action( "save_post", array( $this, "action_on_update" ) );

		// Add Checkins single page template
		add_filter( "single_template", array( $this, "checkins_single_page" ) );

        // Add the shortcode which is going to show the last checkin
		add_action( 'init', array( $this, 'register_shortcode' ) );
    }

    function __desctruct(){}

    /*
    *   Function name: register_checkins_cpt
    *   Function arguments: NONE
    *   Function purpose: This function is used to initialize (register) the Checkins CPT to the WP Dashboard.
    */
    function register_checkins_cpt() {
        $labels = array(
            'name'               => _x( 'Checkins', 'post type general name', 'checkin' ),
    		'singular_name'      => _x( 'Checkin', 'post type singular name', 'checkin' ),
    		'menu_name'          => _x( 'Checkins', 'admin menu', 'checkin' ),
    		'name_admin_bar'     => _x( 'Checkin', 'add new on admin bar', 'checkin' ),
    		'add_new'            => _x( 'Add New', 'checkin', 'checkin' ),
    		'add_new_item'       => __( 'Add New Checkin', 'checkin' ),
    		'new_item'           => __( 'New Checkin', 'checkin' ),
    		'edit_item'          => __( 'Edit Checkin', 'checkin' ),
    		'view_item'          => __( 'View Checkin', 'checkin' ),
    		'all_items'          => __( 'All Checkins', 'checkin' ),
    		'search_items'       => __( 'Search Checkin', 'checkin' ),
    		'parent_item_colon'  => __( 'Parent Checkins:', 'checkin' ),
    		'not_found'          => __( 'No checkins found.', 'checkin' ),
    		'not_found_in_trash' => __( 'No checkins found in Trash.', 'checkin' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Here you can add your checkins everytime you want to share your location with your visitors.', 'checkin' ),
    		'public'             => true,
    		'publicly_queryable' => true,
    		'show_ui'            => true,
    		'show_in_menu'       => true,
    		'query_var'          => true,
    		'rewrite'            => array( 'slug' => 'checkins' ),
    		'capability_type'    => 'post',
    		'has_archive'        => true,
    		'hierarchical'       => false,
    		'menu_position'      => null,
    		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' )
        );

        register_post_type( "checkin", $args );
    }

    // Register Admin JS
	function register_admin_JS() {
		wp_enqueue_script( 'checkin-admin-js', plugins_url( '/assets/scripts.js' , __FILE__ ), array('jquery'), '1.0', true );
	}

    // Register Admin CSS
	function register_admin_CSS( $hook ) {
		wp_enqueue_style( 'checkin-admin-css', plugins_url( '/assets/style.css', __FILE__ ), array(), '1.0', 'screen' );
	}

	//Register frontend JS
	function register_front_JS() {
		wp_enqueue_script( 'ful-front-js', plugins_url( '/assets/front.js' , __FILE__ ), array('jquery'), '1.0', true );
	}
	//Register frontend CSS
	function register_front_CSS() {
		wp_enqueue_style( 'ful-front-css', plugins_url( '/assets/front.css', __FILE__ ), array(), '1.0', 'screen' );
	}

    /*
    *   Function name: register_checkin_metabox
    *   Function arguments: NONE [ $post_type, $post - NOT USED ]
    *   Function purpose: This function is used to generate the CHECKIN_CHECKIN_FIELDs meta box for the Checkins CPT.
    */
    function register_checkin_metabox( $post_type, $post ) {
        add_meta_box(
            "checkin_fields",
            "Checkin",
            array( $this, "build_checkin_fields_metabox" ),
            "checkin",
            "normal",
            "high"
        );
    }

    /*
    *   Function name: build_checkin_fields_metabox
    *   Function arguments: NONE
    *   Function purpose: This function is used to build the Checkin Fields name metabox.
    */
    function build_checkin_fields_metabox() {
		global $post;
		$venue_id = get_post_meta( $post->ID, "venue_id", true );
		$hidden_ = !isset( $venue_id ) || empty( $venue_id ) ? "" : "hidden";
		$visible_ = !isset( $venue_id ) || empty( $venue_id ) ? "hidden" : "visible";
        ?>

        <div id="venue-search-container" class="venue-search-container <?php echo $hidden_; ?>">
            <div id="venue-search-box" class="venue-search-box">
                <input type="text" id="town-search" class="search" placeholder="City name">
                <input type="text" id="venue-search" class="search" placeholder="Place name or just &quot;hookah&quot;?">
                <button type="button" id="search-controller" class="button button-primary button-large search-button">Search</button>
            </div>
            <div id="venues-list" class="venues-list">
            </div>
			<input id="venue-id" name="venue_id" type="hidden" />
		</div>
		<div id="venue-selection-container" class="venue-selection-container <?php echo $visible_; ?>">
		</div>
		<?php if ( isset( $venue_id ) && !empty( $venue_id ) ) { ?>
		<script type="text/javascript">
		jQuery( document ).ready(function(){
			getVenue( "<?php echo $venue_id; ?>" );
		});
		</script>
		<?php } ?>

        <?php
    }

	/*
	*	Function name: action_on_update
	*	Function arguments: $post_id [ INT ] (required)
	*	Function purpose: This function is used to update the current venue.
	*/
	function action_on_update( $post_id ) {
		$venue_id = isset( $_POST[ "venue_id" ] ) && !empty( trim( $_POST[ "venue_id" ] ) ) ? sanitize_text_field( trim( $_POST[ "venue_id" ] ) ) : "";

		$current_venue_id = get_post_meta( $post_id, "venue_id", false );

		if ( !empty( $current_venue_id ) ) { update_post_meta( $post_id, "venue_id", $venue_id ); }
		else { add_post_meta( $post_id, "venue_id", $venue_id ); }
	}

	/*
	*	Function name: checkins_single_page
	*	Function arguments: $template [ STRING ]
	*	Function purpose: This function loads the specific view for the single checkin page.
	*/
	function checkins_single_page( $template ) {
		global $post;

		$single_template = get_template_directory() ."/single.php";
		if ($post->post_type == 'checkin') {
			$single_template = plugin_dir_path( __FILE__ ) . '/templates/single-checkin.php';
		}

		return $single_template;
	}

    /*
    *   Function name: register_shortcode
    *   Function arguments: NONE
    *   Function purpose: This function is used to register the [last_checkin] shortcode.
    */
    function register_shortcode() { add_shortcode( "last_checkin", array( $this, "checkin" ) ); }

    /*
    *   Function name: checkin
    *   Function arguments: $atts [MIXED_ARRAY] [NOT_USED]
    *   Function purpose: This function shows the last checkin in a container.
    */
    function checkin( $atts ) {
        $args = array(
            "posts_per_page" => 1,
            "post_status" => "publish",
            "post_type" => "checkin",
            "orderby" => "ID",
            "order" => "DESC"
        );
        $checkins_ = get_posts( $args );
        $checkin_ = $checkins_[0];

        $venue_id = get_post_meta( $checkin_->ID, "venue_id", true );

        return "
        <a href='". get_permalink( $checkin_->ID ) ."' class='venue-anchor'>
            <div id='post-header' class='venue-caller' style='background-image: url(". get_the_post_thumbnail_url( $checkin_->ID, "full" ) .");'>
                <div class='overlay'>
                    <span class='header'>". $checkin_->post_title ."</span>
                    <span id='venue' class='venue'>@</span>
                </div>
            </div>
        </a>
        <script type='text/javascript'>
            jQuery( document ).ready(function(){ getVenuePlace( '". $venue_id ."', '#venue' ); });
        </script>
        ";
    }
}

$_CHECKIN_ = new CHECKIN;
?>

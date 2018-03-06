<?php
/*
 * The Main Plugin Controller
 *
 * @package Google Analytics
 * @subpackage Google Analytics Controller
 * @since 1.0.0
 */
 
if ( !class_exists( 'epGoogleAnalyticsController' ) ) {
	/* 
	 * The Controller Class in the MVC Architecture
	 *
	 * @package Google Analytics
	 * @subpackage Google Analytics Controller
	 * @since 1.0.0
	 */

	class epGoogleAnalyticsController {
		/*
		 * The Constructor
		 *
		 * @package Google Analytics
 		 * @subpackage Google Analytics Controller
		 * @since 1.0.0
		 */
		 
		public function __construct() {
			if ( is_admin() ) {
				add_action( 
					'admin_menu', 
					array( $this, 'options_menu' )
				);

				add_action( 
					'admin_init', 
					array( $this, 'options_init' )
				);
			}
			else {
				add_action(
					'wp_head',
					array( $this, 'render_header_code' )
				);
			}
		}

		/*
		 * Adds a submenu to the Settings top-level menu
		 *
		 * @package Google Analytics
 		 * @subpackage Google Analytics Controller
		 * @since 1.0.0
		 */

		public function options_menu() {
			add_options_page(
				'Google Analytics',
				'Google Analytics',
				'manage_options',
				'ep_google_analytics_admin',
				array( $this, 'analytics_options' )
			);
		}
		 
		/*
		 * Callback { ep_google_analytics_menu() } to render the options page
		 *
		 * @package Google Analytics
 		 * @subpackage Google Analytics Controller
		 * @since 1.0.0
		 */

		public function analytics_options() {
			// Include the view class file
			require_once( 'ep_google_analytics_view.php' );

			// Call a static function from the view class to insert the html
			epGoogleAnalyticsAdminView::render_options_page();
		}

		/*
		 * Callback to register to whitelist our options
		 *
		 * @package Google Analytics
 		 * @subpackage Google Analytics Controller
		 * @since 1.0.0
		 */

		public function options_init () {
			register_setting(
				'ep_google_analytics_options_group',
				'ep_google_analytics_options',
				array( $this, 'sanitisation' )
			);

			add_settings_section(
				'tracking_id_section',
				'Tracking ID',
				array( $this, 'render_tracking_section' ),
				'ep_google_analytics_admin'
			);

			add_settings_field(
				'tracking_id_field',
				'Tracking ID',
				array( $this, 'render_tracking_field' ),
				'ep_google_analytics_admin',
				'tracking_id_section'
			);
		}

		/*
		 * Sanitise the input to the tracking_field
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics Controller
		 * @since 1.0.0
		 */

		public function sanitisation ( $input ) {
			$newTrackingID = array();

			if ( isset( $input['trackingID'] ) ) {
				$newTrackingID['trackingID'] = sanitize_text_field( $input['trackingID'] );
			}

			return $newTrackingID;
		}

		/*
		 * Insert the Tracking ID section html
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics Controller
		 * @since 1.0.0
		 */

		public function render_tracking_section () {
			// Include the view class
			require_once ( 'ep_google_analytics_view.php' );

			// Call a static function to do the rendering
			epGoogleAnalyticsAdminView::render_tracking_section ();
		}

		/*
		 * Insert the Tracking ID field html
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics Controller
		 * @since 1.0.0
		 */

		public function render_tracking_field () {
			// We need the trackingID from the model
			require_once ( 'ep_google_analytics_model.php' );
			$model = new epGoogleAnalyticsModel;

			// Inlcude the View
			require_once ( 'ep_google_analytics_view.php' );

			// Call a static function to do the rendering
			epGoogleAnalyticsAdminView::render_tracking_field ( $model->get_trackingID () );
		}

		/*
		 * Insert the code block into the footer.
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics Controller
		 * @since 1.0.0
		 */
		
		public function render_header_code()
		{
			// Include the model data
			require_once( 'ep_google_analytics_model.php' );

			// Instantiate the model data
			$epGoogleAnalyticsModel = new epGoogleAnalyticsModel;

			// Get the model data
			$trackingID = $epGoogleAnalyticsModel->get_trackingID();

			if ( isset ( $trackingID ) === true && $trackingID !== '' ) {
				// Include the view
				require_once( 'ep_google_analytics_view.php' );

				// Render the code block into the footer
				epGoogleAnalyticsFooterView::render_code_block( $trackingID );
			}
		}
	}
}

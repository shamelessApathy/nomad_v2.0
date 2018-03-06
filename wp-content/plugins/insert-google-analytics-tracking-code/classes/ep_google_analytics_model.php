<?php
/*
 * The Main Plugin Model
 *
 * @package Google Analytics
 * @subpackage Google Analytics Model
 *
 * @since 1.0.0
 */

if ( !class_exists( 'epGoogleAnalyticsModel' ) )
{
	/*
	 * The Model Class in the MVC Architecture
	 *
	 * @package Google Analytics
	 * @subpackage Google Analytics Model
	 * @since 1.0.0
	 */

	class epGoogleAnalyticsModel
	{

		/*
		 * Allocate storage for the Tracking ID
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics Model
		 * @since 1.0.0
		 *
		 * @var string
		 */

		private $trackingID = '';

		/*
		 * The Class Constructor
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics Model
		 * @since 1.0.0
		 */

		public function __construct()
		{
			// Get the option value from the database
			// array( 'trackingID' => 'value' )

			$options = get_option( 'ep_google_analytics_options' );
			$this->set_trackingID( $options[ 'trackingID' ] );
		}

		/*
		 * Setter for the trackingID
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics Model
		 * @since 1.0.0
		 *
		 * @param $string
		 */

		public function set_trackingID( $newTrackingID )
		{
			$this->trackingID = $newTrackingID;
		}

		/*
		 * Getter for the trackingID
		 *
		 * @package Google Analytics
		 * @subpackage Google Analytics Model
		 * @since 1.0.0
		 *
		 * @return $string
		 */

		public function get_trackingID()
		{
			return $this->trackingID;
		}
	}
}

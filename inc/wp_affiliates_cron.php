<?php 

/**
 * wp_affiliates_cron.php
 *
**/


if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}



if( !class_exists( 'WP_Affiliates_CronJob' ) ):

class WP_Affiliates_CronJob {

	public function __construct(){

		$this->wp_affiliate_deactivate_affiliate();		

	}

	public function wp_affiliate_deactivate_affiliate(){

	if (! wp_next_scheduled ( 'wp_deactivate_affiliate_cron' )) {

		wp_schedule_event( time(), 'hourly', 'wp_deactivate_affiliate_cron' );

    }

    add_action('wp_deactivate_affiliate_cron', array( $this , 'wp_deactivate_affiliate_function' ) );

	}

	public function wp_deactivate_affiliate_function() {
	// do something every hour
	}

	public function clear_cron_deactivation(){
		wp_clear_scheduled_hook('wp_deactivate_affiliate_cron');
	}


}

endif;
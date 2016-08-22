<?php 

/**
 * simple-newsletter.php
 *
 *
 * Plugin Name: Simple Newsletter
 * Plugin URI: 
 * Description: 
 * Version: 1.0.0
 * Author: Sumesh S
 * Author URI: https://github.com/sumeshsr
**/


if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

global $wpdb;

define( 'SIMPLE_NEWSLETTER_VERSION' , '1.0.0' );
define( 'SIMPLE_NEWSLETTER_BASENAME', plugin_basename( __FILE__ ) );
define( 'SIMPLE_NEWSLETTER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SIMPLE_NEWSLETTER_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'SIMPLE_NEWSLETTER_ADMINISTER_OPTIONS', 'manage_options' );
define( 'SIMPLE_NEWSLETTER_TABLE', $wpdb->prefix.'simple_newsletter' );
define( 'SIMPLE_NEWSLETTER_TABLE_OPTIONS', $wpdb->prefix.'simple_newsletter_options' );
define( 'SIMPLE_NEWSLETTER_PLUGIN_DOMAIN', 'simple_newsletter' );
define( 'SIMPLE_NEWSLETTER_ADMIN_ASSETS', SIMPLE_NEWSLETTER_PLUGIN_DIR_URL.'assets/admin' );
define( 'SIMPLE_NEWSLETTER_PLUGIN_ASSETS', SIMPLE_NEWSLETTER_PLUGIN_DIR_URL.'assets' );


register_activation_hook( __FILE__ , 'simple_newsletter_plugin_init' );
register_deactivation_hook( __FILE__, 'simple_newsletter_plugin_deactivation' );
require_once( SIMPLE_NEWSLETTER_PLUGIN_DIR.'/inc/functions.php' );

/*
 * Loads File for admin options;; 
 */

if ( is_admin() ) {	
	require_once( SIMPLE_NEWSLETTER_PLUGIN_DIR.'/admin/admin-functions.php' );
	require_once( SIMPLE_NEWSLETTER_PLUGIN_DIR.'/admin/admin-template-functions.php' );
	require_once( SIMPLE_NEWSLETTER_PLUGIN_DIR.'/admin/class-admin.php' );
	//require_once( WP_AFFILIATES_PLUGIN_DIR.'/admin/class-admin.php' );
	//require_once( WP_AFFILIATES_PLUGIN_DIR.'/admin/class-admin-add-affiliate.php' );	
		
}

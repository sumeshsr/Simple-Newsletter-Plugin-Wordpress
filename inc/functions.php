<?php 

/**
 * functions.php
 * 
 *
 */


if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}



/**
 * Triggers the simple_newsletter_plugin_init() function on plugin activation.
 */

if ( !function_exists('simple_newsletter_plugin_init' ) ) {

function simple_newsletter_plugin_init(){

	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	$sm_newsletter = "CREATE TABLE IF NOT EXISTS " .SIMPLE_NEWSLETTER_TABLE . "( 
		subscriber_id bigint(20) unsigned NOT NULL AUTO_INCREMENT, 
		subscriber_email varchar(100) NOT NULL , 
		subscribed_time_date varchar(100) NOT  NULL , 
		subscriber_ip varchar(100)  NOT NULL , 
		subscriber_token varchar(100)  NOT NULL , 
		subscriber_status enum('subscribed', 'unsubscribed') default 'subscribed'  NOT NULL , 
		init_mail_status varchar(255)  NOT NULL , 
		PRIMARY KEY ( subscriber_id )	
		) {$charset_collate};";

	$sm_newsletter_options = "CREATE TABLE IF NOT EXISTS " .SIMPLE_NEWSLETTER_TABLE_OPTIONS . "( 
		option_id bigint(20) unsigned NOT NULL AUTO_INCREMENT, 
		option_name varchar(100) NOT NULL , 
		option_value varchar(100)  NOT NULL , 
		option_status varchar(100)  NULL , 
		PRIMARY KEY ( option_id , option_name )	
		) {$charset_collate};";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sm_newsletter );
	dbDelta( $sm_newsletter_options );
}



}

if ( !function_exists('sm_newsletter_admin_pagination' ) ) {

function sm_newsletter_admin_pagination( $totalposts,$p,$lpm1,$prev,$next ){

    $adjacents 			= 1;
    $pagination 		= '';
    $prev_text 			= '&lsaquo;';
    $next_text 			= '&rsaquo;';
    $first_page_text 	= '&laquo;';
    $last_page_text 	= '&raquo;';

    $prev_get 			= array_merge( $_GET , array( "pg" => $prev ) );
    $next_get 			= array_merge( $_GET , array( "pg" => $next ) );
    $first_get 			= array_merge( $_GET , array( "pg" => '1' ) );
    $last_get 			= array_merge( $_GET , array( "pg" => $totalposts ) );
	$prev_url   		= http_build_query( $prev_get );
	$next_url   		= http_build_query( $next_get );
	$first_url   		= http_build_query( $first_get );
	$last_url   		= http_build_query( $last_get );

	$target 			= http_build_query( $_GET );

    if($totalposts > 1){

        $pagination .= "<div class='pagination_container text-right'>";
        $pagination .= "<ul class='pagination' style=\"margin:0;display:inline-block;\">";

        if ($p > 1){
        	$pagination.= "<li title=\" Previous \"><a  href=\"?{$first_url}\">{$first_page_text}</a> </li>";
        	$pagination.= "<li title=\" Previous \"><a  href=\"?{$prev_url}\">{$prev_text}</a> </li>";
    	}
        else{
        	$pagination.= "<li class=\"disabled\" title=\" Previous \"><span >{$first_page_text}</span> </li>";
        	$pagination.= "<li class=\"disabled\" title=\" Previous \"><span >{$prev_text}</span> </li>";
    	}

        if ($totalposts < 7 + ($adjacents * 2)){
            $pagination.= "<li class='active'><span>{$p}<span></li>";
            $pagination.= "<li><span class=\"wp_affiliate_total_page\" > of </span></li>";
            $pagination.= "<li><span>$totalposts</span></li>";
    	}

        if ($p != $totalposts){
        	$pagination.= " <li title=\" Next \"><a href=\"?{$next_url}\" >{$next_text}</a></li>";
        	$pagination.= " <li title=\" Next \"><a href=\"?{$last_url}\">{$last_page_text}</a></li>";
    	}
        else{
        	$pagination.= " <li class=\"disabled\" title=\" Next \" ><span >{$next_text}</span></li>";
        	$pagination.= " <li class=\"disabled\" title=\" Next \" ><span >{$last_page_text}</span></li>";
    	}

        $pagination.= "\n</ul></div>";
    }

    return $pagination;
}

}

if( file_exists( SIMPLE_NEWSLETTER_PLUGIN_DIR.'inc/shortcode.php' ) ){

	require SIMPLE_NEWSLETTER_PLUGIN_DIR.'inc/shortcode.php';

}
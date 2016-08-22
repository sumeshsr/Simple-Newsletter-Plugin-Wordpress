<?php 

/**
 * class-admin.php
 *
 */


if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}


if( !class_exists( 'Simple_Newsletter_Admin_Views' ) ):

class Simple_Newsletter_Admin_Views {


	public function __construct(){

		add_action( 'admin_menu', array( __CLASS__, 'simple_newsletter_admin_menu' ) );

		// Filters to remove wp-admin footer text..
		add_filter( 'admin_footer_text', '__return_empty_string', 11 ); 
		add_filter( 'update_footer', '__return_empty_string', 11 );

		require SIMPLE_NEWSLETTER_PLUGIN_DIR.'admin/class-mail-list.php';
		require SIMPLE_NEWSLETTER_PLUGIN_DIR.'admin/class-simple-newsletter-settings.php';

		

	}


	/*
	 * Function to create admin menu.
	 */

	public static function simple_newsletter_admin_menu() {

		$pages = array();	

		$pages[] = add_menu_page(  'Simple Newsletter' ,  'Newsletter' ,  SIMPLE_NEWSLETTER_ADMINISTER_OPTIONS , 'simple_newsletter' ,  array( __CLASS__ , 'simple_newsletter_admin_menu_option' ) ,  SIMPLE_NEWSLETTER_PLUGIN_ASSETS.'/images/icon.png' ,  25 );
		
		new Simple_Newsletter_Settings;

		new Simple_Newsletter_Mailing_List;

		

		//$pages[] = add_submenu_page ( 'simple-newsletter', 'Settings', 'WP Affiliate Settings', simple-newsletter_ADMINISTER_OPTIONS, 'wp-affiliate-settings', array( 'simple-newsletter_Admin_Settings' , 'create_admin_page' ) ) ;

		foreach( $pages as $page ){
			add_action( "admin_print_styles-{$page}", array( __CLASS__ , 'simple_newsletter_admin_styles' ) );
			add_action( "admin_print_scripts-{$page}", array( __CLASS__ , 'simple_newsletter_admin_scripts' ) );
		}
	}


	/*
	 * Adds admin section
	 */

	public static function simple_newsletter_admin_menu_option() {
		
		global $wpdb, $paged, $max_num_pages , $total_spicy_post ,$post;

		if ( !current_user_can( simple-newsletter_ADMINISTER_OPTIONS ) ) {
			wp_die( __( 'You are not Authorized to access this page!!!!.', simple-newsletter_PLUGIN_DOMAIN ) );
		}	

		$delete 	= '';

		if( isset( $_REQUEST['confirm_sn_delete_subscriber'] ) ):
			$delete 	= 	delete_subscribers_newsletter( $_REQUEST );
		endif;

		// Max Number of results to show

		$max = 10;


		if( isset( $_REQUEST['pg'] ) ){
		    $p = $_REQUEST['pg'];
		}else{
		    $p = 1;
		}

		$limit 		= ($p - 1) * $max;
		$prev 		=  $p - 1;
		$next 		=  $p + 1;
		$limits 	= (int)($p - 1) * $max;

		//query the posts with pagination

		$query		= "SELECT * FROM ".SIMPLE_NEWSLETTER_TABLE;
		$page_query	= $query." ORDER BY subscriber_id DESC LIMIT ".$limit.", ".$max."; ";

		$results 	= $wpdb->get_results( $page_query, ARRAY_A);
		

		$totalres 	= count( $wpdb->get_results( $query , ARRAY_A ) );


		$totalposts = ceil( $totalres / $max );
		$lpm1 		= $totalposts - 1;
		$i 			= 1;

		$options 	 = 	"";

		$deleteAction	=  !isset( $_REQUEST['sn_bulk_action'] ) ||  $_REQUEST['sn_bulk_action'] != 'delete' ;

		if( $deleteAction ):

		$options 	.= 	'<form name="simple_newsletter_table" id="simple_newsletter_table" style="min-height:700px;" method="POST" action="'.admin_url().'?page='.$_REQUEST['page'].'" >';

		endif;

		$options 	.= 	"<div class='col-lg-12' style='padding-left:0;' >";

		if( !empty( $delete ) ):

			$options 	.= 	$delete;

		endif;

		

		$options 	.= 	"";
		$options 	.= 	"<div class='panel-group'>";
		$options 	.= 	"<div class='panel panel-primary' style='margin-top:20px;'>";
		$options 	.= 	"<div class='panel-heading'>";

		$options 	.= 	"<div class='row'>";

		$options 	.= 	"<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
		$options 	.= 	"<b>Simple Newsletter <span class='glyphicon glyphicon-envelope' style='position:relative;top:2px;'> </span></b> ";
		$options 	.= 	"</div>";
		$options 	.= 	"<div class='shortcode_container col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center'> ";
		$options 	.= 	"Simple Newsletter Shortcode : <input type='text' name='shortcode' class='form-control shortcode-details' value='[simple_newsletter]' data-toggle='tooltip' data-placement='top' title='Copy & Paste this shortcode in your page to see the newsletter in Action!''  readonly >";
		$options 	.= 	"</div>";


		$options 	.= 	"</div>";
		$options 	.= 	"</div>";


		$options 	.= 	"<div class='panel-body'>";
		
		 if( !empty( $results ) && $deleteAction ):
		$options 	.= 	'<div class="well">';
		$options 	.= 	'<select name="sn_bulk_action" class="form-control" style="max-width:120px;display:inline-block;" >';
		$options 	.= 	'<option value="0" selected >Bulk Action</option>';
		$options 	.= 	'<option value="delete">Delete</option>';
		$options 	.= 	'</select>';
		$options 	.= 	'<button style="display:inline-block;margin-left:5px;" class="btn btn-primary btn-xs" name="bulk_select_submit" >Submit</button>';
		$options 	.= 	'</div>';
		endif;

		$options 	.= 	'<div class="well">';

		if( !empty( $results ) && $deleteAction ):

			$options 	.=  admin_list_subscribers( $results );

		elseif( isset( $_REQUEST['sn_bulk_action'] ) && $_REQUEST['sn_bulk_action'] == 'delete' ):

			$options 	.=  admin_delete_subscribers( $_REQUEST );

	  	endif;


		$options 	.=  "</div>";
		
		$pagination  =	sm_newsletter_admin_pagination( $totalposts , $p , $lpm1 , $prev ,$next );
		if( $pagination ){
			$options 	.= '<div class="well" style="margin-bottom:0;" >';
			$options 	.= $pagination;
			$options 	.= '</div>';
		}


		$options 	.=  "</div>";

		$options 	.=  "</div>";
		$options 	.= 	"</div>";
		$options 	.= 	"</div>";
		$options 	.= 	"</div>";
		if( !empty( $results ) &&  $deleteAction ):
		$options 	.= 	"</form>";
		endif;
		$options 	.= 	"<div class='clearfix'></div>";

		echo $options;


		
	}


	/*
	 * Function to load css file only in the simple-newsletter admin page.
	 */

	public static function simple_newsletter_admin_styles() {

        wp_register_style( 'simple-newsletter-css', SIMPLE_NEWSLETTER_ADMIN_ASSETS. '/css/simple-newsletter.css', false, '1.0.0' );
        wp_register_style( 'bootstrap-css', SIMPLE_NEWSLETTER_ADMIN_ASSETS. '/css/bootstrap.min.css', false, '3.3.7' );
        
        wp_enqueue_style( 'bootstrap-css' );
        wp_enqueue_style('thickbox');
        wp_enqueue_style( 'simple-newsletter-css' );
        
	}
	/*
	 * Function to load js files only in the simple-newsletter admin page.
	 */

	public static function simple_newsletter_admin_scripts() {

       wp_register_script('simple-newsletter-js', SIMPLE_NEWSLETTER_ADMIN_ASSETS. '/js/simple-newsletter.js', false, '1.0.0' , true );
      
       wp_register_script('bootstrap-js', SIMPLE_NEWSLETTER_ADMIN_ASSETS. '/js/bootstrap.min.js', false, '3.3.7' , true );
       wp_register_script('select2-js', SIMPLE_NEWSLETTER_ADMIN_ASSETS. '/js/select2.full.min.js', false, '3.3.7' , true );

       
       wp_enqueue_script( 'simple-newsletter-js' );

       wp_enqueue_script( 'bootstrap-js' );
       wp_enqueue_script('media-upload');
	   wp_enqueue_script('thickbox');
	   wp_enqueue_script('my-upload');
	   
	}




}//Class Simple_Newsletter_Admin_Views #ends

new Simple_Newsletter_Admin_Views;

endif;
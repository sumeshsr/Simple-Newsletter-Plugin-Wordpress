<?php 

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}


if( !function_exists('admin_list_subscribers') ){

function admin_list_subscribers( &$subscribers ){

	if ( !current_user_can( SIMPLE_NEWSLETTER_ADMINISTER_OPTIONS ) ) {
	    wp_die( 'You are not authorized.' ); 
	}

	$i 			 =	1;
	$counter	 =  0;
	$nonce 		 = wp_create_nonce( 'sm_newsletter_nonce_subscriber' );
	$options 	 = '';
	$options 	.= 	'<div class="table-responsive">';
	$options 	.= 	'<table class="table table-striped" data-toggle="table" >';
	$options 	.= 	'<thead>';
	$options 	.= 	'<tr>';
	$options 	.= 	'<th><input type="checkbox" name="bulk_select"  />';
	$options 	.= 	'<input type="hidden" name="wp_nonce"  value="'.$nonce.'" /></th>';
	$options 	.= 	'<th>Sl No</th>';
	$options 	.= 	'<th>Email</th>';
	$options 	.= 	'<th>Subscribed Date</th>';
	$options 	.= 	'<th>Subscriber IP Address</th>';
	$options 	.= 	'</tr>';
	$options 	.= 	'</thead>';
	$options 	.= 	'<tbody>';

	foreach( $subscribers as $subscriber ){
		extract( $subscriber );
		$options 	.= 	'<tr>';
		$options 	.= 	'<td><input type="checkbox" name="subscribers_data[]" value="'.$subscriber_id.': '.$subscriber_email.'" />';
		$options 	.= 	'<td>'.$i.'</td>';
		$options 	.= 	'<td>'.$subscriber_email.'</td>';
		$options 	.= 	'<td>'.$subscribed_time_date.'</td>';
		$options 	.= 	'<td>'.$subscriber_ip.'</td>';
		$options 	.= 	'</tr>';
		$i++;
		$counter++;
	}


	$options 	.= 	'</tbody>';
	$options 	.= 	'</table>';
	$options 	.= 	'</div>';

	return $options;

}

}


if( !function_exists('admin_delete_subscribers') ){

function admin_delete_subscribers( &$requests ){

	extract( $requests );


	if ( ! wp_verify_nonce( $wp_nonce , 'sm_newsletter_nonce_subscriber' ) && !current_user_can( SIMPLE_NEWSLETTER_ADMINISTER_OPTIONS ) ) {
	    wp_die( 'You are not authorised.' ); 
	}

	

	$nonce 		 = wp_create_nonce( '_nonce_subscriber_delete' );

	$output		 =	'<form method="POST" action="'.admin_url().'?page='.$_REQUEST['page'].'" >';	
	$output		.=	'<h4>Delete Subscribers</h4>';	
	$output		.=	'<h6>You have specified these subscribers for deletion:</h6>';	
	$output		.=	'<input type="hidden" name="_wp_nonce" value="'.$nonce.'"  />';	

	foreach( $subscribers_data as $subscriber  ):

		
		if( !empty($subscriber) ):

		$users		 =  explode(":", $subscriber);

		$output		.=	"ID #{$users[0]}: {$users[1]}<br>" ;	
		$output		.=	"<input type='hidden' name='subscribers_datas[]' value='{$users[0]}' />" ;	
		endif;

	endforeach;

	$output		.=	'<div class="clearfix" ></div>';	
	$output		.=	"<button type='submit' style='margin-top:15px;' name='confirm_sn_delete_subscriber' class='button button-primary'> Confirm Deletion </button>" ;
	$output		.=	"</form>" ;

	return $output;

}

}

if( !function_exists('delete_subscribers_newsletter') ){

function delete_subscribers_newsletter( &$requset ){

	global $wpdb;

	extract($requset);
	

	if ( ! wp_verify_nonce( $_wp_nonce , '_nonce_subscriber_delete' ) && !current_user_can( SIMPLE_NEWSLETTER_ADMINISTER_OPTIONS ) ) {
	    wp_die( 'You are not authorized.' ); 
	}

	$valid	= true;

	foreach( $subscribers_datas as $ID ):

	$deleteData	= $wpdb->delete( SIMPLE_NEWSLETTER_TABLE , array( 'subscriber_id' => $ID ), array( '%d' ) );
	if( !$deleteData ):
		$valid	=	false;
	endif;

	endforeach;

	if( $valid ):

	$output		.=	'<div style="margin-top:18px;" class="alert alert-info fade in">';
    $output		.=	'<a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>';
    $output		.=	'<strong>Deleted!</strong>  Successfully deleted subscribers.';
	$output		.=	'</div>';

	else:	

	$output		.=	'<div style="margin-top:18px;" class="alert alert-danger fade in">';
    $output		.=	'<a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>';
    $output		.=	'<strong>Failed!</strong> Failed to Proceed your request.'.$id;
	$output		.=	'</div>';

	endif;

	return $output;


}

}

if( !function_exists('get_simple_newsletter_option') ){

function get_simple_newsletter_option( $key ){

	global $wpdb;

	$option_value 	= $wpdb->get_var( $wpdb->prepare( 
		"
			SELECT option_value 
			FROM ".SIMPLE_NEWSLETTER_TABLE_OPTIONS."
			WHERE option_name = %s
		", 
		esc_sql( $key )
	) );

	if( $option_value ){
		return $option_value;
	}else{
		return false;
	}

}

}


if( !function_exists('simple_newsletter_email_settings') ){

function simple_newsletter_email_settings(){

	if ( !current_user_can( SIMPLE_NEWSLETTER_ADMINISTER_OPTIONS ) ) {
	    wp_die( 'You are not authorized.' ); 
	}

	global $wpdb;

	$siteName		= get_bloginfo('name');

	$admin_email 	= get_simple_newsletter_option( 'simple_newsletter_email' );

	$sitename 		= get_simple_newsletter_option( 'company_name' );



	$output		 =  '';

	$output		.=  '<div class="form-group" >';
	$output		.=  '<label for="admin_email" class="label" >Newsletter From Email</label>';
	$output		.=  "<input type='email' name='sn_admin_email' class='form-control' id='admin_email' value='{$admin_email}' />";
	$output		.=  '</div>';

	$output		.=  '<div class="form-group" >';
	$output		.=  '<label for="company_name" class="label" >Company Name</label>';
	$output		.=  "<input type='text' name='company_name' class='form-control' id='company_name' value='{$sitename}' />";
	$output		.=  '</div>';

	$output		.=  '<div class="form-group" >';
	$output		.=  '<label class="label">Company Logo</label>';

	$output		.=  '<div>';
	$output		.=  '<label for="upload_image_button" class="btn btn-primary btn-sm" aria-label="Left Align" > <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload Image</label>';
	$output		.=  '<img id="upload_image" class="hidden" src="" class="img-responsive"/>';
	$output		.=  '<input id="company_image" name="company_image" type="hidden" value="" />';
	$output		.=  '<input id="upload_image_button" type="button" value="Upload Image" style="visibility:hidden;"/>';

	$output		.=  '</div>';
	$output		.=  '</div>';

	


	return $output;

}

}
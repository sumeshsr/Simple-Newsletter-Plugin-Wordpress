<?php 

/**
 * class-simple-newsletter-settings.php
 *
 */


if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}


if( !class_exists( 'Simple_Newsletter_Settings' ) ):

class Simple_Newsletter_Settings {


	public function __construct(){

		$pages[] = add_submenu_page ( 'simple_newsletter', 'Simple Newsletter Settings', 'Settings', WP_AFFILIATES_ADMINISTER_OPTIONS, 'sm-newsletter-settings', array( __CLASS__ , 'sm_newsletter_settings' ) ) ;

		foreach( $pages as $page ){
			add_action( "admin_print_styles-{$page}", array( 'Simple_Newsletter_Admin_Views' , 'simple_newsletter_admin_styles' ) );
			add_action( "admin_print_scripts-{$page}", array( 'Simple_Newsletter_Admin_Views' , 'simple_newsletter_admin_scripts' ) );
		}

	}

	public static function sm_newsletter_settings(){

		$options 	.= 	"<div class='col-lg-12' style='padding-left:0;' >";		

		$options 	.= 	"";
		$options 	.= 	"<div class='panel-group'>";
		$options 	.= 	"<div class='panel panel-primary' style='margin-top:20px;'>";
		$options 	.= 	"<div class='panel-heading'>";

		$options 	.= 	"<div class='row'>";

		$options 	.= 	"<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
		$options 	.= 	"<b>Simple Newsletter Settings <span class='glyphicon glyphicon-cog' style='position:relative;top:2px;'> </span></b> ";
		$options 	.= 	"</div>";
		$options 	.= 	"<div class='shortcode_container col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center'> ";
		$options 	.= 	"Simple Newsletter Shortcode : <input type='text' name='shortcode' class='form-control shortcode-details' value='[simple_newsletter]' data-toggle='tooltip' data-placement='top' title='Copy & Paste this shortcode in your page to see the newsletter in Action!''  readonly >";
		$options 	.= 	"</div>";


		$options 	.= 	"</div>";
		$options 	.= 	"</div>";


		$options 	.= 	"<div class='panel-body '>";




		$options 	.= 	'<div class="well">';


		$options 	.= 	'<div id="newsletter_settings" >';
		$options 	.= 	 simple_newsletter_email_settings();
		$options 	.= 	'</div>';

		$options 	.= 	'</div>';

		$options 	.= 	'<div class="well well-sm">';
		$options		.=  '<div class="form-group" style="margin:0 0 0 8px;" >';
		$options		.=  '<button type="submit" class="btn btn-primary btn-sm" >Save Changes</button>';
		$options		.=  '</div>';
		$options 		.= 	'</div>';

		
		

		
		

		$options 	.=  "</div>";

		$options 	.=  "</div>";
		$options 	.= 	"</div>";
		$options 	.= 	"</div>";

		$options 	.= 	"<div class='clearfix'></div>";

		echo $options;
	}


}//Class Simple_Newsletter_Settings #ends


endif;
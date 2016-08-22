 <?php 

/**
 * class-mail-list.php
 *
 */


if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}


if( !class_exists( 'Simple_Newsletter_Mailing_List' ) ):

class Simple_Newsletter_Mailing_List {


	public function __construct(){

		$pages[] = add_submenu_page ( 'simple_newsletter', 'Simple Newsletter Mailing List', 'Mailing List', WP_AFFILIATES_ADMINISTER_OPTIONS, 'sm-newsletter-mailing', array( __CLASS__ , 'simple_newsletter_mailing' ) ) ;

		foreach( $pages as $page ){
			add_action( "admin_print_styles-{$page}", array( 'Simple_Newsletter_Admin_Views' , 'simple_newsletter_admin_styles' ) );
			add_action( "admin_print_scripts-{$page}", array( 'Simple_Newsletter_Admin_Views' , 'simple_newsletter_admin_scripts' ) );
		}

	}

	public static function simple_newsletter_mailing(){

		$options 	.= 	"<div class='col-lg-12' style='padding-left:0;' >";		

		$options 	.= 	"";
		$options 	.= 	"<div class='panel-group'>";
		$options 	.= 	"<div class='panel panel-primary' style='margin-top:20px;'>";
		$options 	.= 	"<div class='panel-heading'>";

		$options 	.= 	"<div class='row'>";

		$options 	.= 	"<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
		$options 	.= 	"<b>Simple Newsletter Mailing List <span class='glyphicon glyphicon-bullhorn' style='position:relative;top:2px;'> </span></b> ";
		$options 	.= 	"</div>";
		$options 	.= 	"<div class='shortcode_container col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center'> ";
		$options 	.= 	"Simple Newsletter Shortcode : <input type='text' name='shortcode' class='form-control shortcode-details' value='[simple_newsletter]' data-toggle='tooltip' data-placement='top' title='Copy & Paste this shortcode in your page to see the newsletter in Action!''  readonly >";
		$options 	.= 	"</div>";


		$options 	.= 	"</div>";
		$options 	.= 	"</div>";


		$options 	.= 	"<div class='panel-body '>";




		$options 	.= 	'<div class="well">';		
		$options 	.= 	'</div>';

		
		

		
		

		$options 	.=  "</div>";

		$options 	.=  "</div>";
		$options 	.= 	"</div>";
		$options 	.= 	"</div>";

		$options 	.= 	"<div class='clearfix'></div>";

		echo $options;
	}


}//Class Simple_Newsletter_Mailing_List #ends


endif;
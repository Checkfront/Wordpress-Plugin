<?php
/**
 *  @package WordPress
 *  @subpackage Default_Theme
 *  Template Name: Checkfront Booking Page
 *
 *  The easiest way to use Checkfront is to create a new post in the
 *  wordpres editor, and paste in the Checkfront shortcode: [checkfront]
 *  There are additinal options you can pass to the shortcode to change
 *  the behavour or layout.
 *
 *  Alternativly, if you wish to build Checkfront into a theme, you can
 *  use this sample as a starting point.  You will need to tweak it
 *  with your theme.
 *
 *  The pipe.html file must be on the server.  This helps with sizing the 
 *  booking portal.
 *
 *  Please see our Wordpress Setup Guide for up to date information:
 *  http://www.checkfront.com/extend/wordpress/
 *
 *  For more complex custom integrations, consider our API:
 *  http://www.checkfront.com/api/2/
 *  
 *  The Checkfront plugin must be installed and active.  This method
 *  only works with the v2 interface.
 */


$schema = ($_SERVER['HTTPS'] != "on") ? 'http' : 'https';
// replace demo.checkfront.com with your checkfront host
// if using https, be sure and change the schema in the pipe

include_once('CheckfrontWidget.php');
$Checkfront = new CheckfrontWidget(
	array(
		'host'=>'demo.checkfront.com', // your checkfront host
		'plugin_url'=>"{$schema}://{$_SERVER['HTTP_HOST']}/wp-content/plugins/checkfront-wp-booking/",
		'interface' =>'v2', 
		'provider' =>'wordpress'
	)
);


// add the widget include to your theme header.  you could remove this and it in manually if preferrer. 
function checkfront_custom_head() {
	global $Checkfront;
	echo ' <script src="//' . $Checkfront->host . '/lib/interface.js?v' . $Checkfront->interface_lib_version . '" type="text/javascript"></script>';
}
add_action('wp_head', 'checkfront_custom_head');


get_header($template_name);


echo $Checkfront->render(
	array(
		'options'=>'tabs,compact',
		'style'=>'background-color: #fff; color: #000; font-family: Arial',
	)
);

get_footer($template_name);

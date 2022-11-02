<?php
/**
 *  @package WordPress
 *  @subpackage Default_Theme
 *  Template Name: Checkfront Booking Page
 *
 *  The easiest way to use Checkfront is to create a new post in the
 *  Wordpress editor, and paste in the Checkfront shortcode: [checkfront]
 *  There are additional options you can pass to the shortcode to change
 *  the behavour or layout.
 *
 *  Alternatively, if you wish to build Checkfront into a theme, you can
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


$schema = ($_SERVER['HTTPS'] !== "on") ? 'http' : 'https';
// replace demo.checkfront.com with your Checkfront host

include_once('CheckfrontWidget.php');
$Checkfront = new CheckfrontWidget([
	'host'       => 'demo.checkfront.com', // your Checkfront host url
	'plugin_url' => '/wp-content/plugins/checkfront-wp-booking/',
	'provider'   => 'wordpress',
]);

function checkfront_enqueue_scripts() {
	// Widget iFrame loading support
	global $Checkfront;
	wp_enqueue_script('cf/interface.js', "//{$Checkfront->host}/lib/interface--{$Checkfront->interface_version}.js");
}
add_action('wp_enqueue_scripts', 'checkfront_enqueue_scripts');


get_header($template_name);

// add extra content here

echo $Checkfront->render([
	'options' => 'tabs,compact',
	'style'   => 'background-color: fff; color: 000; font-family: Arial',
]);

get_footer($template_name);

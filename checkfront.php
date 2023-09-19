<?php

/*
Plugin Name: Checkfront Online Booking System
Plugin URI: https://www.checkfront.com/wordpress
Description: Connects Wordpress to the Checkfront Online Booking System.  Checkfront allows Tour, Activity, Accommodation, and Rental businesses to manage their availability, track inventories, centralize reservations, and process online payments. This plugin connects your WordPress site to your Checkfront account, and provides a powerful real-time booking interface – right within your existing website.
Version: 3.7
Author: Checkfront Inc.
Author URI: https://www.checkfront.com/
Copyright: 2008 - 2023 Checkfront Inc
*/

if ( ! defined( 'WP_PLUGIN_URL' ) ) define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );

/* ------------------------------------------------------
 * Wordpress Required Functions
/* ------------------------------------------------------*/

//Shortcode [checkfront parameter="value"]
function checkfront_func($cnf, $content=null)
{
	$cnf = shortcode_atts([
		'category_id'=> '',
		'item_id'    => '',
		'date'       => '',
		'start_date' => '',
		'end_date'   => '',
		'tid'        => '',
		'discount'   => '',
		'options'    => '',
		'style'      => '',
		'host'       => '',
		'width'      => '',
		'theme'      => '',
		'lang_id'    => '',
		'partner_id' => '',
		'popup'      => '',
		'widget_id'  => '',
	], $cnf);
	return checkfront($cnf);
}

// Global shortcode call
function checkfront($cnf)
{
	global $Checkfront;
	if (is_page() || is_single()) {
		// Wordpress will try and auto format paragraphs -- remove new lines
		return str_replace("\n",'',$Checkfront->render($cnf));
	}
}

// Wordpress Admin Hook
function checkfront_conf()
{
	if (function_exists('add_submenu_page')) {
		add_submenu_page('plugins.php', __('Checkfront'), __('Checkfront'), 'manage_options', 'checkfront', 'checkfront_setup');
	}

	add_filter('plugin_row_meta', 'checkfront_plugin_meta', 10, 2 );
}

// Wordpress Setup Page
function checkfront_setup()
{
	global $Checkfront;
	include(dirname(__FILE__).'/setup.php');
}

// include required js, if the page will use it
function checkfront_enqueue_scripts()
{
	global $post, $Checkfront;
	if (!isset($Checkfront->host)) {
		return;
	}
	
	// does this page have any shortcode. If not, back out.
	if (stripos($post->post_content, '[checkfront') === false) {
		return;
	}

	wp_enqueue_script('cf/interface.js', "//{$Checkfront->host}/lib/interface--{$Checkfront->interface_version}.js", ['jquery']);
	// Disable Comments
	add_filter('comments_open', 'checkfront_comments_open_filter', 10, 2);
	add_filter('comments_template', 'checkfront_comments_template_filter', 10, 1);

	// disable auto p
	// remove_filter ('the_content', 'wpautop');

	// disable wptexturize
	remove_filter('the_content', 'wptexturize');
}

// disable comments on booking page
function checkfront_comments_open_filter($open, $post_id=null)
{
	return $open;
}

// disable comment include (required to clear)
function checkfront_comments_template_filter($file)
{
	return dirname(__FILE__).'/xcomments.html';
}

// plugin init
function checkfront_init()
{
	wp_enqueue_script('jquery');
	add_action('wp_enqueue_scripts', 'checkfront_enqueue_scripts');
}

// Set admin meta
function checkfront_plugin_meta($links, $file)
{
	// create link
	if (basename($file, '.php') == 'checkfront') {
		return array_merge(
			$links,
			[
				'<a href="plugins.php?page=checkfront">' . __('Setup') . '</a>',
				'<a href="https://www.checkfront.com/support/?src=wp-setup">' . __('Support') . '</a>',
				'<a href="https://www.checkfront.com/login/?src=wp-setup">' . __('Login') . '</a>',
			]
		);
	}
	return $links;
}

/*
 Create Checkfront class. If you wish to include this in a custom theme (not shortcode)
 see the checkfront-custom-template-sample.php
*/
// Include Checkfront Widget Class
include_once(dirname(__FILE__).'/CheckfrontWidget.php');

$Checkfront = new CheckfrontWidget([
	'host' => get_option('checkfront_host'),
	'pipe_url' => '/' . basename(WP_CONTENT_URL) . '/plugins/' . basename(dirname(__FILE__)) . '/pipe.html',
	'provider' => 'wordpress',
	'load_msg' => __('Searching Availability'),
	'continue_msg' => __('Continue to Secure Booking System'),
]);

add_shortcode('checkfront', 'checkfront_func');
add_action('admin_menu', 'checkfront_conf');
add_action('init', 'checkfront_init');

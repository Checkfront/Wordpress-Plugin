<?php

/*
Plugin Name: Checkfront Online Booking System
Plugin URI: https://www.checkfront.com/wordpress
Description: Connects Wordpress to the Checkfront Online Booking System.  Checkfront allows Tour, Activity, Accommodation, and Rental businesses to manage their availability, track inventories, centralize reservations, and process online payments. This plugin connects your WordPress site to your Checkfront account, and provides a powerful real-time booking interface – right within your existing website.
Version: 3.5
Author: Checkfront Inc.
Author URI: https://www.checkfront.com/
Copyright: 2008 - 2022 Checkfront Inc
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
	wp_enqueue_script('jquery'); 
	wp_enqueue_script(WP_PLUGIN_URL . '/setup.js'); 
	include(dirname(__FILE__).'/setup.php');
}

// Init Checkfront, include any required js / css only when required
function checkfront_head()
{
	$embedded = 0;

	global $post, $Checkfront;
	if (!isset($Checkfront->host)) {
		return;
	}
	
	// does this page have any shortcode. If not, back out.
	$pos = stripos($post->post_content, '[checkfront');
	if ($pos || $pos === 0) {
		$embedded = 1;
	}

	// calendar widget
	if ($Checkfront->arg['widget']) {
		$checkfront_widget_post = get_option("checkfront_widget_post");
		$checkfront_widget_page = get_option("checkfront_widget_page");
		$checkfront_widget_booking = get_option("checkfront_widget_booking");

		if ($embedded && !$checkfront_widget_booking) { 
			$Checkfront->arg['widget'] = 0;
		} else {
			if (is_page() && !$checkfront_widget_page) {
				$Checkfront->arg['widget'] = 0;
			}
			if (is_single() && !$checkfront_widget_post) {
				$Checkfront->arg['widget'] = 0;
			}
		}
	}

	if ($Checkfront->arg['widget'] || $embedded) {
		echo ' <script src="//' . $Checkfront->host . '/lib/interface--' . $Checkfront->interface_version . '.js" type="text/javascript"></script>' ."\n";
		if ($embedded) {
			// Disable Comments
			add_filter('comments_open', 'checkfront_comments_open_filter', 10, 2);
			add_filter('comments_template', 'checkfront_comments_template_filter', 10, 1);

			// disable auto p
			// remove_filter ('the_content', 'wpautop');

			// disable wptexturize
			remove_filter('the_content', 'wptexturize');
		}
	}
}

// disable comments on booking pagfe
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
	global $Checkfront;
	wp_register_sidebar_widget(
		'checkfront_widget',
		'Checkfront',
		'checkfront_widget',
		['description' => __('Availability calendar and search')]
	);

	wp_register_widget_control('checkfront_widget', 'Checkfront', 'checkfront_widget_ctrl');
	add_action('wp_head', 'checkfront_head');
	// required includes
	wp_enqueue_script('jquery');
	if (!isset($Checkfront->arg)) {
		$Checkfront->arg = [];
	}

	$Checkfront->arg['widget'] = (is_active_widget('checkfront_widget')) ? 1 : 0;
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

// Show widget
function checkfront_widget()
{
	global $Checkfront;
	if (!$Checkfront->arg['widget']) {
		return;
	}
	$checkfront_widget_title = get_option("checkfront_widget_title");
	if ($checkfront_book_url = get_option("checkfront_book_url")) {
		if (!(strpos('http', $checkfront_book_url) === 0)) {
			$checkfront_book_url = 'http://' . $_SERVER['HTTP_HOST'] . $checkfront_book_url;
		}
	}
	if (!empty($checkfront_widget_title)) {
		echo '<h2 class="widgettitle">' . $checkfront_widget_title . '</h2>';
	}
	echo '<div id="checkfront-cal"><iframe allowTransparency=true border=0 style="border:0; height: 260px;" src="//' . $Checkfront->host . '/reserve/widget/calendar/?return=' . urlencode($checkfront_book_url) . '"></iframe></div>';
}

// Widget control
function checkfront_widget_ctrl()
{
	if ($_POST['checkfront_update']) {
		update_option("checkfront_book_url", $_POST['checkfront_book_url']);
		update_option("checkfront_widget_title", $_POST['checkfront_widget_title']);
		update_option("checkfront_widget_post ", $_POST['checkfront_widget_post']);
		update_option("checkfront_widget_page ", $_POST['checkfront_widget_page']);
		update_option("checkfront_widget_booking", $_POST['checkfront_widget_booking']);
	}

	$checkfront_book_url = get_option("checkfront_book_url");

	// try and find booking page in content
	if (!$checkfront_book_url) {
		global $wpdb;
		$checkfront_book_url = $wpdb->get_var("select guid FROM `{$wpdb->prefix}posts` where post_content like '%[checkfront%' and post_type = 'page' limit 1");
		update_option("checkfront_widget_url", $checkfront_book_url);
	}

 	$checkfront_widget_title = get_option("checkfront_widget_title");
	$checkfront_widget_post = (get_option("checkfront_widget_post")) ? ' checked="checked"' : '';
 	$checkfront_widget_page = (get_option("checkfront_widget_page")) ? ' checked="checked"' : '';
 	$checkfront_widget_booking  = (get_option("checkfront_widget_booking")) ? ' checked="checked"' : '';

	echo '<input type="hidden" name="checkfront_update" value="1" />';	
	echo '<ul>';
	echo '<li><label for="checkfront_book_url">' . __('Internal Booking Page (URL)') . ': </label><input type="text" id="checkfront_book_url" name="checkfront_book_url" value="' . $checkfront_book_url . '" /> </li>';
	echo '<li><label for="checkfront_widget_title">' . __('Title') . ': </label><input type="text" id="checkfront_widget_title" name="checkfront_widget_title" value="' . $checkfront_widget_title . '" /> </li>';
	echo '<li style="color: firebrick">It is not recommended to use this with the v2 interface.</li>';
	echo '<li><input type="checkbox" id="checkfront_widget_post" name="checkfront_widget_post" value="1"' . $checkfront_widget_post . '/><label for="checkfront_widget_post" />' . __('Show on posts') . '</li>';
	echo '<li><input type="checkbox" id="checkfront_widget_page" name="checkfront_widget_page" value="1"' .  $checkfront_widget_page . '/><label for="checkfront_widget_post" />' . __('Show on pages') . '</li>';
	echo '<li><input type="checkbox" id="checkfront_widget_booking" name="checkfront_widget_booking" value="1"' . $checkfront_widget_booking . '/><label for="checkfront_widget_booking" />' . __('Show on booking page') . '</li>';
	echo '</ul>';
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

?>
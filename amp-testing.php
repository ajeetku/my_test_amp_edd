<?php
/*
Plugin Name: my amp edd Testing
Description: AMP Extension Test Update, License & Git Integration
Version: 0.0.1
Author URI: http://ampforwp.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if (!defined('AMP_TESTING_VERSION')) {
	define('AMP_TESTING_VERSION','0.0.1');
}

function hello(){
	echo "called function";
}
function all_success_date_called(){
	echo "sdcsdc";
	echo "sdcsdc";
	echo "sdcsdc";
} 
// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'AMP_TESTING_STORE_URL', 'https://wordpress-amp.000webhostapp.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of your product. This should match the download name in EDD exactly
define( 'AMP_TESTING_ITEM_NAME', 'Advanced Testing Ads' );

// the download ID. This is the ID of your product in EDD and should match the download ID visible in your Downloads list (see example below)
//define( 'AMP_ITEM_ID', 2502 );
// the name of the settings page for the license input to be displayed
define( 'AMP_TESTING_LICENSE_PAGE', 'amp-testing-license' );






if ( defined( 'AMPFORWP_PLUGIN_DIR' ) ) {
	add_filter( 'plugin_action_links', 'ampforwp_settings_link', 10, 5 );
} else {

	add_filter( 'plugin_action_links', 'ampforwp_plugin_activation_link', 10, 5 );

	// Add Activate Parent Plugin button in settings page
	if ( ! function_exists( 'ampforwp_plugin_activation_link' ) ) {
		function ampforwp_plugin_activation_link( $actions, $plugin_file ) {
			static $plugin;
			if (!isset($plugin))
				$plugin = plugin_basename(__FILE__);
				if ($plugin == $plugin_file) {
						$settings = array('settings' => '<a href="plugin-install.php?s=accelerated+mobile+pages&tab=search&type=term">' . __('Please Activate the Parent Plugin.', 'ampforwp_incontent_ads') . '</a>');
						$actions = array_merge($settings , $actions );
					}
				return $actions;
		}
	}
	// Return if Parent plugin is not active, and don't load the below code.
	return;
}

if ( ! function_exists( 'ampforwp_settings_link' ) ) {
	function ampforwp_settings_link( $actions, $plugin_file )  {
			static $plugin;
			if (!isset($plugin))
				$plugin = plugin_basename(__FILE__);
				if ($plugin == $plugin_file) {
						$settings = array('settings' => '<a href="admin.php?page=amp_options&tab=8">' . __('Settings', 'ampforwp_incontent_ads') . '</a>');
			  		$actions = array_merge( $actions , $settings);
					}
				return $actions;
	}
}

require plugin_dir_path( __FILE__ ).'settings.php';

function teaser_position($content){
		global $redux_builder_amp;
		$closing_p = '</p>';
		$paragraphs = explode( $closing_p, $content );
		$no_of_p = count($paragraphs);
		$position_of_button = $redux_builder_amp['ampforwp-teaser-position'];
		if($position_of_button == '1'){
			$paragraphs_index = $no_of_p /4;
			$paragraphs_index = floor($paragraphs_index);
		}
		elseif($position_of_button == '2'){
			$paragraphs_index = $no_of_p /2;
			$paragraphs_index = floor($paragraphs_index);
		}
		elseif($position_of_button == '3'){
			$paragraphs_index = $no_of_p /3;
			$paragraphs_index = floor($paragraphs_index);
		}
		elseif($position_of_button == '4'){
			$paragraphs_index = $no_of_p /1;
			$paragraphs_index = floor($paragraphs_index);
		}
		$counter=0;
		$content = '';
		foreach($paragraphs as $value){
			if($counter == $paragraphs_index) break;

				$content= $content.$paragraphs[$counter];
				$counter++;
		}
		return $content;
}


add_action('pre_amp_render_post','amp_teaser');
function amp_teaser(){
	global $redux_builder_amp;
	if($redux_builder_amp['ampforwp-enable-teaser'] == '1'){
		$post_types[] = get_post_type();
		$users_selected = $redux_builder_amp['ampforwp-teaser-for'];

		foreach($users_selected as $key=>$value){
				if(in_array($value,$post_types)){

					add_filter('the_content','adding_teaser');
				}
			}
	}
}

function adding_teaser($content){
	global $redux_builder_amp;
	$position = teaser_position($content);
	$post_link = user_trailingslashit(get_permalink(get_the_ID()));
	$content = $position;
	$button_name = $redux_builder_amp['ampforwp-teaser-button-name'];
	$button = '<div class="amp-teaser comment-button-wrapper"><a href="'.$post_link.'?nonamp=1'.'">'.$button_name.'</a></div>';
	$content = $content.$button;
	return $content;
}



require_once dirname( __FILE__ ) . '/updater/EDD_SL_Plugin_Updater.php';
// Check for updates
function amp_ads_plugin_updater() {

	// retrieve our license key from the DB
	//$license_key = trim( get_option( 'amp_ads_license_key' ) );
	$selectedOption = get_option('redux_builder_amp',true);
    $license_key = '';//trim( get_option( 'amp_ads_license_key' ) );
    $pluginItemName = '';
    $pluginItemStoreUrl = '';
    $pluginstatus = '';
    if( isset($selectedOption['amp-license']) && "" != $selectedOption['amp-license']){
       $pluginsDetail = $selectedOption['amp-license']['amp-testing'];
       $license_key = $pluginsDetail['license'];
       $pluginItemName = $pluginsDetail['item_name'];
       $pluginItemStoreUrl = $pluginsDetail['store_url'];
       $pluginstatus = $pluginsDetail['status'];
    }
	
	// setup the updater
	$edd_updater = new AMP_TESTING_EDD_SL_Plugin_Updater( AMP_TESTING_STORE_URL, __FILE__, array(
			'version' 	=> AMP_TESTING_VERSION, 				// current version number
			'license' 	=> $license_key, 						// license key (used get_option above to retrieve from DB)
			'license_status'=>$pluginstatus,
			'item_name' => AMP_TESTING_ITEM_NAME, 			// name of this plugin
			'author' 	=> 'Mohammed Kaludi',  					// author of this plugin
			'beta'		=> false,
		)
	);
}
add_action( 'admin_init', 'amp_ads_plugin_updater', 0 );
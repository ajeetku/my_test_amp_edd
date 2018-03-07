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

if ( ! defined( 'AMP_TESTING_VERSION' ) ) {
	define( 'AMP_TESTING_VERSION', '0.0.1' );
}

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'AMP_TESTING_STORE_URL', 'https://wordpress-amp.000webhostapp.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of your product. This should match the download name in EDD exactly
define( 'AMP_TESTING_ITEM_NAME', 'Advanced Testing Ads' );

// the download ID. This is the ID of your product in EDD and should match the download ID visible in your Downloads list (see example below)
//define( 'AMP_ITEM_ID', 2502 );
// the name of the settings page for the license input to be displayed
define( 'AMP_TESTING_LICENSE_PAGE', 'amp-testing-license' );


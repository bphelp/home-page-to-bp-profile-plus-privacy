<?php 
/*
Plugin Name: Home Page To BP Profile Plus Privacy
Plugin URI: http://bphelpblog.wordpress.com/
Description: Adds privacy and redirects logged in user from home to profile.
Version: 1.0
Requires at least: 3.2.1
Tested up to: 3.6.1
License: GNU/GPL 2
Author: bphelp
Author URI: http://bphelpblog.wordpress.com/
*/

/*** Make sure BuddyPress is loaded ********************************/
function bphelp_home_page_to_bp_profile_check() {
    if ( !class_exists( 'BuddyPress' ) ) {
	add_action( 'admin_notices', 'home_page_to_bp_profile_install_buddypress_notice' );
    }
}
add_action('plugins_loaded', 'bphelp_home_page_to_bp_profile_check', 999);

function home_page_to_bp_profile_install_buddypress_notice() {
	echo '<div id="message" class="error fade"><p style="line-height: 150%">';
	_e('<strong>Home Page To BP Profile Plus Privacy</strong></a> requires the BuddyPress plugin to work. Please <a href="http://buddypress.org/download">install BuddyPress</a> first, or <a href="plugins.php">deactivate Home Page To BP Profile Plus Privacy</a>.');
	echo '</p></div>';
}

function home_page_to_bp_profile_init() {
	require( dirname( __FILE__ ) . '/home-page-to-bp-profile-plus-privacy.php' );
}
add_action( 'bp_include', 'home_page_to_bp_profile_init' );
?>
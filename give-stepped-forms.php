<?php
/**
 * @package Give_Stepped_Forms
 * @version 1.0
 */
/*
Plugin Name: Give - Stepped Forms
Plugin URI: https://www.mattcromwell.com/products/give-stepped-forms
Description: An experiment with Give forms that advance with a button click.
Author: Matt Cromwell
Version: 1.0
Author URI: https://www.mattcromwell.com
*/


// Defines Plugin directory for easy reference
define( 'GIVESF_DIR', dirname( __FILE__ ) );
define( 'GIVESF_URL', plugin_dir_url( __FILE__ ) );

// Checks if GIVE is active. 
// If not, it bails with an Admin notice as to why. 
// If so, it loads the necessary scripts 

function givesf_plugin_init() {
	
	// If Give is NOT active
	if ( current_user_can( 'activate_plugins' ) && !class_exists('Give')) {
		
		add_action( 'admin_init', 'givesf_deactivate' );
		add_action( 'admin_notices', 'givesf_admin_notice' );
		
		// Deactivate GIVESF
		function givesf_deactivate() {
		  deactivate_plugins( plugin_basename( __FILE__ ) );
		}
		
		// Throw an Alert to tell the Admin why it didn't activate
		function givesf_admin_notice() {
		   echo "<div class=\"error\"><p><strong>" . __('"Give Stepped Forms"</strong> requires the free <a href="https://wordpress.org/plugins/give" target="_blank">Give Donation Plugin</a> to function. Please activate Give before activating this plugin. For now, the plug-in has been <strong>deactivated</strong>.', 'givesf') . "</p></div>";
		   if ( isset( $_GET['activate'] ) )
				unset( $_GET['activate'] );
		}

	// If Give IS Active, then we load everything up.
    } else {
		
		// Include/Execute necessary files
		include_once( GIVESF_DIR . '/inc/asset-loader.php' );

	 }
}

// The initialization function
add_action( 'plugins_loaded', 'givesf_plugin_init' );
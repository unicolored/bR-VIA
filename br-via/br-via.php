<?php

/**
* The plugin bootstrap file
*
* This file is read by WordPress to generate the plugin information in the plugin
* admin area. This file also includes all of the dependencies used by the plugin,
* registers the activation and deactivation functions, and defines a function
* that starts the plugin.
*
* @link              http://example.com
* @since             1.0.0
* @package           bR_VIA
*
* @wordpress-plugin
* Plugin Name:       bodyRock VIA
* Plugin URI:        http://example.com/br-via-uri/
* Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
* Version:           1.0.0
* Author:            Your Name or Your Company
* Author URI:        http://example.com/
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain:       br-via
* Domain Path:       /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
* The code that runs during plugin activation.
* This action is documented in includes/class-br-via-activator.php
*/
function activate_br_via() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-br-via-activator.php';
	bR_VIA_Activator::activate();
}

/**
* The code that runs during plugin deactivation.
* This action is documented in includes/class-br-via-deactivator.php
*/
function deactivate_br_via() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-br-via-deactivator.php';
	bR_VIA_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_br_via' );
register_deactivation_hook( __FILE__, 'deactivate_br_via' );

/**
* The core plugin class that is used to define internationalization,
* admin-specific hooks, and public-facing site hooks.
*/
require plugin_dir_path( __FILE__ ) . 'includes/class-br-via.php';

/**
* Begins execution of the plugin.
*
* Since everything within the plugin is registered via hooks,
* then kicking off the plugin from this point in the file does
* not affect the page life cycle.
*
* @since    1.0.0
*/
function run_br_via() {
	//	add_filter( 'wpseo_canonical', '__return_false' );
	//	add_filter( 'wpseo_metadesc', '__return_false' );

	// Remove actions that we will handle through our wpseo_head call, and probably change the output of
	//	add_action( 'wpseo_head', 'remove' ,0);

		// metabox/
		//add_action("admin_init", "bodyloop_meta_box");

		//require 'metabox/bodyloop.php';

		$plugin = new bR_VIA();
		$plugin->run();
		add_meta_box("bodyloop-meta", "Bodyloop", "bodyloop_meta_options", "page", "normal", "high");

}
run_br_via();
?>

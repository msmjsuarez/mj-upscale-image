<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://portfolio.mjlayasan.com/
 * @since             1.0.0
 * @package           Mj_Upscale_Image
 *
 * @wordpress-plugin
 * Plugin Name:       MJ Upscale Image
 * Plugin URI:        https://demo.mjlayasan.com
 * Description:       This plugin is use to upscale uploaded image.
 * Version:           1.0.0
 * Author:            MJ Layasan
 * Author URI:        https://portfolio.mjlayasan.com//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mj-upscale-image
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('MJ_UPSCALE_IMAGE_VERSION', '1.0.0');
define('MJ_UPSCALE_API_KEY', ''); //add your API key here

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mj-upscale-image-activator.php
 */
function activate_mj_upscale_image()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-mj-upscale-image-activator.php';
	Mj_Upscale_Image_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mj-upscale-image-deactivator.php
 */
function deactivate_mj_upscale_image()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-mj-upscale-image-deactivator.php';
	Mj_Upscale_Image_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_mj_upscale_image');
register_deactivation_hook(__FILE__, 'deactivate_mj_upscale_image');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-mj-upscale-image.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mj_upscale_image()
{

	$plugin = new Mj_Upscale_Image();
	$plugin->run();
}
run_mj_upscale_image();

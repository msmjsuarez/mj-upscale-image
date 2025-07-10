<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://portfolio.mjlayasan.com/
 * @since      1.0.0
 *
 * @package    Mj_Upscale_Image
 * @subpackage Mj_Upscale_Image/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mj_Upscale_Image
 * @subpackage Mj_Upscale_Image/includes
 * @author     MJ Layasan <msmjsuarez@gmail.com>
 */
class Mj_Upscale_Image_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mj-upscale-image',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

<?php

class Mj_Upscale_Image_Public
{
	private $plugin_name;
	private $version;

	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mj-upscale-image-public.css', array(), $this->version, 'all');
	}

	public function enqueue_scripts()
	{

		wp_enqueue_script(
			'mj-upscale-image-public',
			plugin_dir_url(__FILE__) . 'js/mj-upscale-image-public.js',
			['jquery'],
			'1.0.0',
			true
		);

		wp_localize_script(
			'mj-upscale-image-public',
			'mjUpscaleAjax',
			[
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce'    => wp_create_nonce('mj_upscale_nonce'),
			]
		);
	}
}

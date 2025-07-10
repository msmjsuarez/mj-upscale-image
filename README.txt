=== MJ Upscale Image ===
Contributors: MJ Layasan  
Tags: image upscaling, AI image enhancer, upscaler, picsart, AI tools, WordPress image  
Requires at least: 6.0  
Tested up to: 6.5  
Requires PHP: 8.1  
Stable tag: 1.0.0  
License: MIT  
License URI: https://opensource.org/licenses/MIT  

MJ Upscale Image allows users to upload and upscale their images using the Picsart AI API — supports JPG and PNG, up to 8X resolution.

== Description ==

MJ Upscale Image is a simple yet powerful WordPress plugin that integrates with the [Picsart Upscale API](https://picsart.io/tools/upscale) to enhance user-uploaded images. Users can upload a JPG or PNG file and upscale it by 2X, 4X, or 8X, with the enhanced version displayed beside the original.

It’s perfect for photography websites, media portfolios, and applications that need higher-resolution visuals without sacrificing quality.

**Features:**
* AI-powered upscaling via Picsart API
* Choose upscale factors: 2X, 4X, or 8X
* Side-by-side image preview
* JPG and PNG support
* Max resolution guardrail (16MP limit)

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory or install via the WordPress Plugins screen.
2. Run `composer install` inside the plugin directory to install dependencies.
3. Add your API key to `wp-config.php`:

```php
define('MJ_UPSCALE_API_KEY', 'your_api_key_here');

Activate the plugin through the 'Plugins' screen in WordPress.

Use the [mj_upscale_image_form] shortcode on any post or page.

== Usage ==

Add the following shortcode to display the upload and upscale form:

[mj_upscale_image_form]

After uploading and selecting an upscale factor, users will see the original and upscaled image side-by-side.

== Frequently Asked Questions ==

= What file formats are supported? =
Only JPG and PNG formats are supported.

= What’s the maximum output size allowed? =
Due to Picsart API limitations, the final resolution cannot exceed 16 megapixels (~23,040,000 pixels). A warning will be shown if this limit is exceeded.

= Do I need an API key? =
Yes. You must register for a Picsart Developer API key at https://picsart.io.

== Screenshots ==

Frontend form for uploading and upscaling

Result preview with side-by-side comparison

Admin console logs for API debugging

== Changelog ==

= 1.0.0 =

Initial release

AJAX-based uploader

Side-by-side image display

Error handling for API and file uploads

== Upgrade Notice ==

= 1.0.0 =
Initial version

== License ==

This plugin is licensed under the MIT License.

<?php

class MJ_Upscale_Image_Public_Settings
{
    public function __construct()
    {
        add_shortcode('mj_upscale_image_form', [$this, 'render_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_mj_upscale_image', [$this, 'handle_upscale']);
        add_action('wp_ajax_nopriv_mj_upscale_image', [$this, 'handle_upscale']);
    }

    public function render_shortcode()
    {
        ob_start();
?>
        <form id="mj-upscale-form" enctype="multipart/form-data">
            <label>Choose an image to upscale:</label><br>
            <input type="file" name="image" id="image" required><br><br>

            <label>Select upscale factor:</label>
            <select name="scale" id="scale">
                <option value="2">2X</option>
                <option value="4">4X</option>
                <option value="8">8X</option>
            </select><br><br>

            <input type="hidden" name="action" value="mj_upscale_image">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('mj_upscale_nonce'); ?>">

            <button type="submit" id="mj-upscale-submit">Upscale Image</button>
        </form>

        <div id="mj-upscale-result" style="margin-top: 30px;"></div>
<?php
        return ob_get_clean();
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

    public function handle_upscale()
    {
        check_ajax_referer('mj_upscale_nonce', 'nonce');

        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            wp_send_json_error([
                'message' => 'No file uploaded or upload error.',
                'error_code' => $_FILES['image']['error']
            ]);
        }

        $uploadedfile = $_FILES['image'];
        $upload_overrides = ['test_form' => false];
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if (!$movefile || isset($movefile['error'])) {
            $error = isset($movefile['error']) ? $movefile['error'] : 'Unknown upload error.';
            wp_send_json_error(['message' => 'Upload failed: ' . $error]);
        }

        $file_path = $movefile['file'];
        $file_name = basename($file_path);
        $mime_type = mime_content_type($file_path);
        $allowed_types = ['image/jpeg', 'image/png'];

        if (!in_array($mime_type, $allowed_types)) {
            wp_send_json_error([
                'message' => 'Unsupported image format. Only JPG and PNG are allowed.',
            ]);
        }

        $scale = in_array($_POST['scale'], ['2', '4', '8']) ? $_POST['scale'] : '2';

        // ✅ Resolution check to ensure output does not exceed 16MP
        list($width, $height) = getimagesize($file_path);
        $output_pixels = ($width * $scale) * ($height * $scale);
        if ($output_pixels > 16000000) {
            wp_send_json_error([
                'message' => 'Selected upscale factor will result in an image larger than 16MP. Please choose a lower factor or upload a smaller image.'
            ]);
        }

        try {
            $image_contents = file_get_contents($file_path);

            $client = new \GuzzleHttp\Client();

            error_log('MJ API KEY: ' . (defined('MJ_UPSCALE_API_KEY') ? MJ_UPSCALE_API_KEY : 'NOT DEFINED'));

            $response = $client->request('POST', 'https://api.picsart.io/tools/1.0/upscale', [
                'headers' => [
                    'X-Picsart-API-Key' => MJ_UPSCALE_API_KEY,
                    'accept'            => 'application/json',
                ],
                'multipart' => [
                    [
                        'name'     => 'upscale_factor',
                        'contents' => $scale,
                    ],
                    [
                        'name'     => 'format',
                        'contents' => 'JPG',
                    ],
                    [
                        'name'     => 'image',
                        'filename' => $file_name,
                        'contents' => $image_contents,
                    ],
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            if (!isset($body['data']['url'])) {
                throw new Exception('API response did not contain image URL.');
            }

            wp_send_json_success([
                'original_url' => esc_url($movefile['url']),
                'upscaled_url' => esc_url($body['data']['url']),
            ]);
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => 'Upscaling failed: ' . $e->getMessage()
            ]);
        }
    }
}

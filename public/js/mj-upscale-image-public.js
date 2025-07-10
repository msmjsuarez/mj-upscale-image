(function( $ ) {
	'use strict';

	jQuery(document).ready(function ($) {
		$('#mj-upscale-form').on('submit', function (e) {
			e.preventDefault();

			const formData = new FormData(this);
			formData.append('action', 'mj_upscale_image');
			formData.append('nonce', mjUpscaleAjax.nonce);

			$('#mj-upscale-submit').prop('disabled', true).text('Upscaling...');

			$.ajax({
				url: mjUpscaleAjax.ajax_url,
				method: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					$('#mj-upscale-submit').prop('disabled', false).text('Upscale Image');

					if (response.success) {
						$('#mj-upscale-result').html(`
							<div style="display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start;">
								<div style="text-align:center; flex: 1;">
									<p><strong>Original Image</strong></p>
									<img src="${response.data.original_url}" style="width: 300px; height: auto; border: 1px solid #ccc;" />
								</div>
								<div style="text-align:center; flex: 1;">
									<p><strong>Upscaled Image</strong></p>
									<img src="${response.data.upscaled_url}" style="width: 300px; height: auto; border: 1px solid #ccc;" />
								</div>
							</div>
						`);
					} else {
						$('#mj-upscale-result').html(`<p style="color: red;"><strong>Error:</strong> ${response.data.message}</p>`);
					}
				},
				error: function () {
					$('#mj-upscale-submit').prop('disabled', false).text('Upscale Image');
					$('#mj-upscale-result').html('<p style="color:red;"><strong>Error:</strong> An unexpected error occurred.</p>');
				}
			});
		});
	});


})( jQuery );

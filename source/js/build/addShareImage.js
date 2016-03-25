(function(F) {
	'use strict';

	F.fn.make('addShareImage', {
		init: function() {
			var $btn = $('.js-seomaster-add-image');
			var $imgInput = $('.js-seomaster-image');
			var $thumbWrapper = $('.js-seomaster-thumb-wrapper');

			// When the FilePicker delivers a file
			$btn.FilePicker({
				callback: function(file, references) {
					// Create a new image
					var img = new Image();
					// jscs:disable
					img.src = file.thumb_path; // jshint ignore:line

					// Set the file id to the image input
					$imgInput.val(file.file_id); // jshint ignore:line
					// jscs:enable

					// Show the image thumbnail
					$('.js-seomaster-image-thumb').html(img);
					$thumbWrapper.jsShow();

					// Hide the add image button
					$btn.jsHide();

					// Close the modal
					references.modal.find('.m-close').click();
				}
			});

			$('.js-thumb-delete').on('click', function() {
				$imgInput.val('');
				$thumbWrapper.jsHide();
				$btn.jsShow();
			});
		}
	});
})(window.SEOMASTER);

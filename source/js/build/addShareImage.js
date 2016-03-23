(function(F) {
	'use strict';

	F.fn.make('addShareImage', {
		init: function() {
			var $btn = $('.js-seomaster-add-image');
			var $imgInput = $('.js-seomaster-image');
			var $thumbWrapper = $('.js-seomaster-thumb-wrapper');

			// jscs:disable
			$.ee_filebrowser.add_trigger($btn, $btn, { // jshint ignore:line
				content_type: 'image', // jshint ignore:line
				directory: this.uploadDirectory
			}, function(file) {
				var img = new Image();
				img.src = file.thumb;

				$imgInput.val(file.file_id); // jshint ignore:line
				$('.js-seomaster-image-thumb').html(img);
				$thumbWrapper.jsShow();

				$btn.jsHide();
			});
			// jscs:enable

			$('.js-thumb-delete').on('click', function() {
				$imgInput.val('');
				$thumbWrapper.jsHide();
				$btn.jsShow();
			});
		}
	});
})(window.SEOMASTER);

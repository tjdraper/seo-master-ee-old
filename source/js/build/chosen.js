(function(F) {
	'use strict';

	F.fn.make('chosen', {
		init: function() {
			var self = this;
			var $sel = $('select[name="field_type"]');

			self.check($sel);

			$sel.on('change.seomaster', function() {
				self.check($sel);
			});
		},

		check: function($sel) {
			if ($sel.val() === 'seomaster') {
				this.run();

				$sel.off('change.seomaster');
			}
		},

		run: function() {
			var $chosenSelects = $('.js-seomaster-chosen');

			// If there are no chosen selects, we have nothing to do
			if (! $chosenSelects.length) {
				return;
			}

			// Loop through the chosen selects
			$chosenSelects.each(function() {
				var $el = $(this);

				// If chosen has already been intialized, move on
				if ($el.data('chosen-init') === true) {
					return;
				}

				// Init chosen
				$el.chosen({
					width: '100%'
				});

				// Set the data attribute
				$el.data('chosen-init', true);
			});
		}
	});
})(window.SEOMASTER);

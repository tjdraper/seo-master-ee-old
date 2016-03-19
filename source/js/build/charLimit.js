(function(F) {
	'use strict';

	F.fn.make('charLimit', {
		init: function() {
			var self = this;

			$('.js-seomaster-limited').each(function() {
				self.setLimits($(this));
			});
		},

		setLimits: function($el) {
			var $input = $el.children('.js-seomaster-input');
			var $countWrapper = $el.children('.js-seomaster-count-wrap');
			var $counter = $countWrapper.children('.js-seomaster-count');
			var limit = $el.data('limit');
			var warningLevel = limit * 0.65;

			if ($el.data('limits-set')) {
				return;
			}

			$input.on('keyup', function() {
				if ($input.val().length > limit) {
					$input.val($input.val().substr(0, limit));
				}

				$counter.text($input.val().length);

				if ($input.val().length >= warningLevel) {
					$countWrapper.addClass('seomaster-count--warning');
				} else {
					$countWrapper.removeClass('seomaster-count--warning');
				}

				if ($input.val().length >= limit) {
					$countWrapper.addClass('seomaster-count--limit-reached');
				} else {
					$countWrapper.removeClass('seomaster-count--limit-reached');
				}
			});

			$el.data('limits-set', true);
		}
	});
})(window.SEOMASTER);

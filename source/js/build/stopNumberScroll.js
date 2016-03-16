(function(F) {
	'use strict';

	F.fn.make('stopNumberScroll', {
		_construct: function() {
			$(':input[type=number]').on('mousewheel', function() {
				this.blur();
			});
		}
	});
})(window.SEOMASTER);

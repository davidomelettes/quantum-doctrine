$.fn.omForm = function(options) {
	var opts = $.extend({}, $.fn.omForm.defaults, options);

	return this.each(function(){
		var $form = $(this);
		$form.find('fieldset.when').each(function () {
			var $fs = $(this);
			var $date = $fs.find('input.date');
			$date.parent().find('span.input-group-addon').click(function () {
				$date.focus();
			});
			
			var $time = $fs.find('input.time');
			var $toggle = $('<a class="btn btn-default"><span class="glyphicon glyphicon-time"></span></a>').insertBefore($time.parent());
			if ($time.val() !== '') {
				$toggle.hide();
			} else {
				$time.parent().hide();
			}
			
			var $clock = $fs.find('span.glyphicon-time').parent();
			$clock.click(function(){
				$toggle.toggle();
				$time.parent().toggle();
				$time.filter(':visible').focus();
				$time.not(':visible').val('');
			});
			
			if (!Modernizr.datetime) {
				// User agent does not natively support date/time fields
				$date.datepicker();
				$time.timepicker();
			}
		});
			
		$form.find('fieldset.collection').omCollection();
	});
};
$.fn.omForm.defaults = {};

$.fn.omCollection = function(options) {
	var opts = $.extend({}, $.fn.omCollection.defaults, options);
	
	return this.each(function () {
		var $c = $(this);
		var $new = $c.find('a.btn.template');
		var remove = function (ev) {
			$(ev.target).parents('fieldset:first').remove();
		};
		$new.click(function () {
			var index = $new.data('index');
			var $item = $($new.data('template').replace(/__index__/g, index));
			$item.find('.remove').click(remove);
			$new.data('index', index+1).parents('div.form-group:first').before($item);
		});
		$c.find('.remove').click(remove);
	});
}
$.fn.omCollection.defaults = {};

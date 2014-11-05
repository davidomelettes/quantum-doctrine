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
			$fs.find('label').attr('for', $date.attr('id'));
		});
		
		$form.find('.form-group-tags').each(function () {
			var $gr = $(this);
			var $tagsInput = $gr.find('input').hide();
			var $autoComplete = $('<input>').addClass($tagsInput.attr('class')).uniqueId().insertBefore($tagsInput);
			var $staticList = $gr.find('ul');
			// Tie label to new input
			$gr.find('label').attr('for', $autoComplete.attr('id'));
			// Set the hidden input value
			var funcSetTagString = function () {
				var strings = [];
				$staticList.find('span.btn').each(function () {
					strings.push($(this).data('tag'));
				});
				$tagsInput.val(strings.join());
			};
			// Remove a tag
			var funcRemoveTag = function (ev) {
				$(ev.target).parents('li').remove();
				funcSetTagString();
			};
			$staticList.find('li').click(funcRemoveTag);
			// Add a tag
			var funcAddTag = function (tagString) {
				if (tagString !== '') {
					// Search first
					var $found = $staticList.find('.btn').filter(function () {
						return $(this).data('tag') === tagString;
					}).effect('pulsate', {times: 1}, 'slow');
					if (!$found.length) {
						var $tag = $('<span class="btn btn-xs btn-info">').data('tag', tagString).text(' ' + tagString).prepend($('<span class="glyphicon glyphicon-tag">')).click(funcRemoveTag);
						$staticList.append($('<li>').append($tag));
						funcSetTagString();
					}
				}
			};
			// Handle plus button
			$autoComplete.parent().find('div').click(function () {
				funcAddTag($autoComplete.val().trim());
				$autoComplete.val('');
			});
			// Handle commas in input
			$autoComplete.on('input', function (ev) {
				var inputString = $(this).val();
				if (inputString.match(/,/)) {
					// We have a comma
					var tagStrings = inputString.match(/[^,]+/g);
					if (tagStrings) {
						$.each(tagStrings, function (i, tagString) {
							funcAddTag(tagString.trim());
						});
					}
					$(this).val('');
				}
			});
		});
			
		$form.find('fieldset.collection').omCollection();
	});
};
$.fn.omForm.defaults = {};

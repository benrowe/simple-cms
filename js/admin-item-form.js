$(function () {
	var
		$submit = $('#submit');

	// detect if a preview was requested, and open it in a new window :)
	if ($('#WebItemForm_action').val() === 'preview' && hasErrors() == false) {
		$.ajax({
			url: createUrl,
			data: {
				route: '/site/preview'
			},
			success: function(url) {
				window.open(url, '_blank', 'width=1024,height=768');
				$('#WebItemForm_action').val('');
			}

		});
	}

    function hasErrors()
    {
        return $('span.error:visible').length > 0;
    }

	// preview item functionality
	$('#preview').click(function(e) {
		e.preventDefault();
		// lets save the current information to the preview and open a new tab!
		$('#WebItemForm_action').val('preview');
		$submit.click();
		return false;
	});

	// publish item on submit
	$('#submit-publish').click(function(e) {
		e.preventDefault();

		var $dp = $('#WebItemForm_datePublished');
		$('#WebItemForm_published').val(1);
		if ($dp.val() == '') {
			$dp.val(dateToYMD(new Date));
		}
		$submit.click();
	})

	function dateToYMD(date)
	{
		var d = date.getDate();
		var m = date.getMonth()+1;
		var y = date.getFullYear();
		return '' + y +'/'+ (m<=9?'0'+m:m) +'/'+ (d<=9?'0'+d:d);
	}

	// preview page url

	// textarea data -reformat
	var $jsonTextareas = $('textarea.format-json');
	if ($jsonTextareas.length > 0) {
		$jsonTextareas.each(function() {
			$(this).val(jsl.format.formatJson($(this).val()));
		});
	}

	// automatically write the slug (id) based on the title value, as it's typed

	// Slug functionality
	(function() {

		// create preview & update
		$('<div id="url-preview">Url Preview: <span class="value"></span></div>').insertAfter('#WebItemForm_id_em_');
		updateSlugPreview()

		var t;
		// conver the id into a auto slug
		new InputSlug($('#WebItemForm_title'), $('#WebItemForm_id'), {
			onChange: function(val) {
				clearTimeout();
			setTimeout(function () {
				updateSlugPreview();
			}, 500);
			}
		});


		$('#WebItemForm_type').change(function() {
			updateSlugPreview();
		})

		function updateSlugPreview()
		{
			var val = $('#WebItemForm_id').val();
			var type = $('#WebItemForm_type').val();
			$.ajax({
				url: createUrl,
				data: {
					route: '/site/item',
					params: {
						'type': type,
						'slug': val
					}
				},
				success: function(url) {
					$('#url-preview .value').html(url);//'/'+type+'/'+val);
				}

			})

		}
	})();

	// preload schema functionality
	$('#load-schema').click(function(e) {
		e.preventDefault();
		if (confirm('Sure?')) {
			var type = $('#WebItemForm_type').val();
			$.ajax({
				url: window.location.pathname,
				data: {
					r: 'admin/contenttypes/json',
					id: type
				},
				dataType: 'json',
				success: function(data)
				{
					$('#WebItemForm_data').val(jsl.format.formatJson(data.schema_string));
				},
				error: function() {
					alert('shit');
				}
			})
		}
	})

	// pagedown

	$('<div id="wmd-preview" class="wmd-panel wmd-preview"></div>').insertAfter('#wmd-input');

	var converter1 = Markdown.getSanitizingConverter();
	var editor1 = new Markdown.Editor(converter1);
    editor1.run();

});



/**
 *
 */
function InputSlug($input, $output, options)
{
	var self = this;

	options = options || {};
	var o = $.extend({
		emptyOnly: true, // only bind when the input value is empty at init
		triggerEvents: 'change keyup keydown', // what events should trigger the slug-recalculation
		onChange: function() {}
	}, options);

	/**
	 * Constructor
	 *
	 */
	(function() {
		_bind();
	})();

	/**
	 * Binds the events to the supplied inputs/outputs
	 */
	function _bind()
	{
		var s = new Slug;
		var t;
		if ($output && ($output.val() == '' || o.emptyOnly == false)) {
			var update = true;
			$input.bind(o.triggerEvents, function() {
				var value = this.value;
				if (value == '') {
					update = true;
				}
				if (update) {
					value = s.convert(value);
					o.onChange(value)
					$output.val(value);
				}
			});
			$output.focus(function() {
				update  = false;
			}).bind('keyup', function() {
				var self = this;
				clearTimeout(t);
				t = setTimeout(function() {
					var value = self.value;
					value = s.convert(value);
					$output.val(value);
					o.onChange(value);
				}, 2000);
			})
		}
	}

	return this;
}

/**
 * automatically writes the slug
 */
function Slug()
{
	this.convert = function(value)
	{
		value = $.trim(value);
		return  value.replace(/[^\w\d]+/g, '-').replace(/^-+|-+$/g, '').toLowerCase();
		//
	}

	return this;
}
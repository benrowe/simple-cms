"use strict";
/**
 * The PublishDate Module
 */
var PublishDate = (function() {
	// static

	/**
	 * get an instance of the popup, as attached to the dom
	 */

	return function(options) 
	{
		options = options || {};
		var o = $.extend({}, options);
		/**
		 * Show the date selector
		 */
		this.show = function(date)
		{
			var $element = PublishDate.getPopup('date-selector');
			$element.find('.input-date').val(date);
			$element.show();
		}
	}
}());

/**
 * generate an instance of the popup with it's default state
 *
 * @param string id
 * @return jQuery
 */
PublishDate.getPopup = function(id)
{
	var p = $('#'+id);
	if (p.length === 0) {
		var 
			now = new Date, 
			d = now.getDate(), 
			m = Common.pad(now.getMonth(), 2, '0', 'left'), 
			y = now.getFullYear();
		p = $('<div id="'+id+'" class="popup-date-picker">'+
			'<input class="input-date" placeholder="'+y+'/'+m+'/'+d+'" />'+
			'<label><input type="checkbox" /> Enabled</label>'+
			'</div>').hide().appendTo("body");	
	}
	return p;
}

// $(function() {
// 	var pd = new PublishDate;
// 	$('dt').click(function(event) {
// 		pd.show();
// 	})
// });


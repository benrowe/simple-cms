function ArticleNav(pages, options)
{
	options = options || {};
	var o = $.extend({
		
	}, options);
	
	(function() {
		if (pages.length > 1) {
			$('.prev-page, .next-page').remove();
			var options = '';
			var currentPage = 1;
			var r = /page=(\d+)/.exec(window.location.href);
			if (r) {
				currentPage = parseInt(r[1]);
			}
			$.each(pages, function(i, page) {
				if (currentPage -1 == i) {
					options += '<option selected value="'+i+'">'+page.title+'</option>';
				} else {
					options += '<option value="'+i+'">'+page.title+'</option>';
				}
			});
			$('.page-list').replaceWith('<select id="page-select">'+options+'</select>');
			$('#page-select').change(function() {
				var url;
				if (window.location.search.indexOf('?page') > -1) {
					url = window.location.href.replace(/page=\d+/, 'page=');
				} else {
					url = window.location.href + '?page=';
				}
				url += (this.selectedIndex+1);
				window.location.href = url;
			});
		}
	})();
}
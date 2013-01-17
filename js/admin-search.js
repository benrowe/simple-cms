$(function() {
	
	// toggle buttons for radio group
	var html = '<div class="btn-group item-types-group" data-toggle="buttons-radio">';
	$('.item-types label>input').each(function() {
		var $i = $(this);
		var txt = $i.next().text();
		var cls = ['btn'];
		if ($i.attr('checked')) {
			cls.push('active');
		}
		if (txt.indexOf('All') > -1) {
			//cls.push('btn-primary');
		} else if (txt.indexOf('Published') > -1) {
			cls.push('btn-success');
		} else {
			cls.push('btn-inverse');
		}
		html += '<a class="'+cls.join(' ')+'">'+txt+'</a>';
	});
	html += '</div>';
	$(html).on('click', 'a', function() {
		var i =$(this).index();
		$('.item-types label>input').filter(':eq('+i+')').attr('checked', true);
	}).prependTo($('.item-types').parent());
	$('.item-types').hide();
	
	// auto toggle tabs, based on hash
	loadTab();
	
});

function loadTab()
{
	if (window.location.hash.length > 1) {
		var type = window.location.hash.split('_')[1];
		$('.tab-'+type+' a:first').tab('show');
	}
	setTimeout(function() {
		scrollTo(window.location.hash);
	}, 300);
}

function scrollTo(id)
{
	if (id[0] !== '#') {
		id = '#'+id;
	}
	$('body').scrollTop($(id).offset().top);
	
}
jQuery(function() {
	
	$('.preview a, a.preview').each(function() {
		$(this).attr('target', '_blank');
	})
	
	// delete confirmation
	$('.delete').click(function(e) {
		if(confirm('Are you sure you want to delete?')) {
			return true;
		}
		e.preventDefault();
		return false;
	});
	
	// feature toggle
	$('.f a').click(function(e) {
		//var actions = ['featured', 'unfeatured'];
		e.preventDefault();
		var self = this;
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'json',
			success: function(response) {
				$(self)
					.parent()
						.toggleClass('unfeatured')
						.toggleClass('featured')
						.parents('.item')
							.toggleClass('featured-true')
							.toggleClass('featured-false')
							.addClass('hilite');
				setTimeout(function() {
					$(self).parents('.item').removeClass('hilite');
				}, 150);
				$(self).text($(self).parent().hasClass('featured') ? 'Featured' : 'Un-featured');
				$(self).attr('href', response.data.url);
			}, error: function() {
				
			}
		})
		return false;
	});
	
	// publish toggle
	$('.p a').click(function(e) {
		e.preventDefault();
		var self = this;
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'json',
			success: function(response) {
				updateSearchForm();
				$(self).parent().toggleClass('unpublished').toggleClass('published').parents('.item').toggleClass('published-true').toggleClass('published-false').addClass('hilite');
				setTimeout(function() {
					$(self).parents('.item').removeClass('hilite');
				}, 150);
				$(self).text($(self).parent().hasClass('published') ? 'Published' : 'Draft');
				$(self).attr('href', response.data.url);
			}, error: function() {
				
			}
		})
		return false;
	});
});

function updateSearchForm()
{
	var url = window.location.href;
	if(url.substr(-10) == 'admin.html') {
		url = url.substr(0, url.length-5)+'/default/index.html';
	}
	$.ajax({
		url: url.replace('/index', '/searchform'),
		success: function(searchForm) {
			$('.form').replaceWith(searchForm);
		}
	})
}




/*jslint white: true, devel: true, onevar: true, browser: true, undef: true, nomen: true, regexp: true, plusplus: false, bitwise: true, newcap: true, maxerr: 50, indent: 4 */
var jsl = typeof jsl === 'undefined' ? {} : jsl;

/**
 * jsl.format - Provide json reformatting in a character-by-character approach, so that even invalid JSON may be reformatted (to the best of its ability).
 *
**/
jsl.format = (function () {

    function repeat(s, count) {
        return new Array(count + 1).join(s);
    }

    function formatJson(json) {
        var i           = 0,
            il          = 0,
            tab         = "    ",
            newJson     = "",
            indentLevel = 0,
            inString    = false,
            currentChar = null;

        for (i = 0, il = json.length; i < il; i += 1) { 
            currentChar = json.charAt(i);

            switch (currentChar) {
            case '{': 
            case '[': 
                if (!inString) { 
                    newJson += currentChar + "\n" + repeat(tab, indentLevel + 1);
                    indentLevel += 1; 
                } else { 
                    newJson += currentChar; 
                }
                break; 
            case '}': 
            case ']': 
                if (!inString) { 
                    indentLevel -= 1; 
                    newJson += "\n" + repeat(tab, indentLevel) + currentChar; 
                } else { 
                    newJson += currentChar; 
                } 
                break; 
            case ',': 
                if (!inString) { 
                    newJson += ",\n" + repeat(tab, indentLevel); 
                } else { 
                    newJson += currentChar; 
                } 
                break; 
            case ':': 
                if (!inString) { 
                    newJson += ": "; 
                } else { 
                    newJson += currentChar; 
                } 
                break; 
            case ' ':
            case "\n":
            case "\t":
                if (inString) {
                    newJson += currentChar;
                }
                break;
            case '"': 
                if (i > 0 && json.charAt(i - 1) !== '\\') {
                    inString = !inString; 
                }
                newJson += currentChar; 
                break;
            default: 
                newJson += currentChar; 
                break;                    
            } 
        } 

        return newJson; 
    }

    return { "formatJson": formatJson };

}());
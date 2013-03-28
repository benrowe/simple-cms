var Common = (function() {

});

/**
 * string pad functionality
 *
 * @param string input
 * @param int len
 * @param string value
 * @param string type
 */
Common.pad = function(input, len, value, type)
{
	input = input+''; // force string
	value = value || " ";
	type = type || "right";
	while(input.length < len) {
		switch (type) {
			case 'left':
				input = value + input;
				break;
			case 'right':
				input += value;
				break;
		}
	}

	return input;
}
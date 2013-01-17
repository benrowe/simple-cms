$(function() {
	// load up the page schema, if we're viewing an item
	
	var schema = new ItemSchema();
	schema.getCurrent(function (response) {
		// we have the schema
		// 
		// load gallery, if it's available
		if (typeof Gallery == "function") {
			var data = response.item.data.images ? response.item.data.images : response.item.data.media;
			window.gallery = new Gallery(data);
		}
		
		//
		if (typeof ArticleNav == "function") {
			window.an = new ArticleNav(response.item.data.pages);
		}
	});
	
});




































function _log(message)
{
	if (window.console) {
		console.log(message);
	}
}

var site = (function()
{
	var self = this;
	
	this.getBaseUrl = function()
	{
		var installDir = $('.nav li:first a').attr('href');
		return window.location.origin+installDir;
	}
	
	this.getType = function()
	{
		var slugParts = _getSlug().split('/');
		return slugParts[0];
	}
	
	this.getId = function()
	{
		var slug = _getSlug();
		return slug.substr(slug.indexOf('/')+1);
	}
	
	function _getSlug()
	{
		return window.location.href.substr(this.getBaseUrl().length);
	}
	
	return this;
})();

/**
 * manages loading and retrieving item schemas
 */
function ItemSchema()
{
	var _schemas = {};
	var _callbacks = {};
	
	var self = this;
	
	(function() {
		//_loadSchema();
	})();
	
	/**
	 * get the schema for the current item
	 */
	this.getCurrent = function(callback)
	{
		_loadSchema(site.getType(), site.getId(), callback);
	}
	
	this.addEventListener = function(eventName, callback)
	{
		_registerCallbacks(eventName, callback);
	}
	
	this.getData = function() 
	{
		return _schema.data;
	}
	
	function _loadSchema(type, id, callback)
	{
		
		var url = site.getBaseUrl()+type+'/'+id;
		var hash = '';
		if (_schemas[hash]) {
			callback(_schemas[hash]);
		} else {
			$.ajax({
				url: url,
				data: {view: 'json'},
				dataType: 'json',
				success: function(itemSchema)
				{
					var metaSchema = $.extend({type: type, id: id}, {item: itemSchema});
					_schema = metaSchema;
					callback(metaSchema);
					_runCallback('ready', metaSchema);
				}, 
				error: function(data)
				{
					console.log('unable to load schema');
					console.log(arguments);
				}
			});
		}
	}
	
	/*function _loadSchema()
	{
		
		$.ajax({
			url: '',
			data: {view: 'json'},
			dataType: 'json',
			success: function(data)
			{
				_schema = data;
				_runCallback('ready');
			}, 
			error: function(data)
			{
				console.log('unable to load schema');
			}
		})
	}*/
	
	/**
	 * Register a callback with the model
	 * 
	 * @param string eventName
	 * @param callback callback
	 */
	function _registerCallbacks(eventName, callback)
	{
		if (!_callbacks[eventName]) {
			_callbacks[eventName] = [];
		}
		_callbacks[eventName].push(callback);
	}
	
	/**
	 * Run the registered callbacks for a specific type
	 * 
	 * @param string eventName
	 * @param array args an array of arguments to supply each callback with
	 */
	function _runCallback(eventName, args)
	{
		console.log('tiggering event: ' + eventName);
		if (_callbacks[eventName]) {
			_log(eventName)
			var cb;
			args = args || [];
			for (var i = 0, len = _callbacks[eventName].length; i < len; i++) {
				cb = _callbacks[eventName][i];
				cb.apply(self, args);
			}
		}
	}
	
	return this;
}
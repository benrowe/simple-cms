/**
 * Handle the gallery data
 */
function GalleryModel(images, options)
{
	var _images = [];
	var _callbacks = {};
	
	var self = this;
	
	options = options || {};
	var o = $.extend({
		
	}, options);
	
	(function() {
		_setImages(images);
	})();
	
	this.addEventListener = function(eventName, callback)
	{
		_registerCallbacks(eventName, callback);
	}
	
	this.setImages = function(images)
	{
		return _setImages(images);
	}
	
	this.getImages = function()
	{
		return _getImages();
	}
	
	this.getImageByIndex = function(index)
	{
		return _getImageByIndex(index);
	}
	
	this.addImage = function(image)
	{
		_addImage(image);
	}
	
	this.count = function()
	{
		return _images.length;
	}
	
	
	
	
	/**
	 * Set the current images
	 * 
	 * @param array images
	 */
	function _setImages(images)
	{
		_clearAllImages();
		_addImages(images);
	}
	
	/**
	 * Get all the images
	 * 
	 * @return array
	 */
	function _getImages()
	{
		return _images;
	}

	/**
	 * get a specific image
	 * 
	 * @param int index
	 * @return image
	 */
	function _getImageByIndex(index)
	{
		if (_images[index]) {
			return _images[index];
		}
		return null;
	}
	
	/**
	 * Add a new image
	 * 
	 * @callback addimage
	 */
	function _addImage(image)
	{
		_images.push(image);
		_runCallback('addimage', [_images.length, image]);
	}
	
	/*
	 * Clear all images from the stack
	 * 
	 * @callback clearall
	 * @return boolean
	 */
	function _clearAllImages()
	{
		_images = [];
		_runCallback('clearall');
		return true;
	}
	
	/**
	 * adds an array of images to the existing set of images
	 * 
	 * @callback addimages, addimage
	 */
	function _addImages(images)
	{
		if (images.length > 0) {
			for (var i = 0, len = images.length; i < len; i++) {
				_addImage(images[i]);
			}
		}
		_runCallback('addimages', [images]);
	}
	
	/**
	 * delete a specific image based on it's index position
	 * 
	 * @callback delete
	 * @return boolean
	 */
	function _deleteImage(index)
	{
		if (_images[index]) {
			var img = _images[index];
			delete _images[index];
			_runCallback('delete', [index, img]);
			return true;
		}
		return false;
	}
	
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
		//console.log('tiggering event: ' + eventName);
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

/**
 * A
 */
function Gallery(images, options)
{
	var _model;
	var _index = 0;
	
	var self = this;
	
	options = options || {};
	var o = $.extend({
		'dom': $('.gallery'),
		'keyboardSupport': true,
		'hashPrefix': 'image-',
		'tnlist': '.image-list-preview',
		'selectedClass': 'selected'
	}, options);
	
	/**
	 * Constructor
	 */
	(function() {
		_model = new GalleryModel(images);
		_model.addEventListener('addimages', function() {
			_redraw();
		});
		_setup();
		_registerEventHooks();
		if (o.keyboardSupport) {
			_enableKeyboardSupport();
		}
		_initThumbnails();
		_loadImageFromHash();
		_initPreloadImages();
	})();
	
	/**
	 * Proceed to the next available image
	 */
	this.nextImage = function()
	{
		this.showImage(_index+1);
	}
	
	/**
	 * Return to the previously available image
	 */
	this.prevImage = function()
	{
		this.showImage(_index-1);
	}
	
	this.showImage = function(index)
	{
		_displayImage(index);
	}
	
	this.getCurrentImageIndex = function()
	{
		return _index;
	}
	
	function _setup()
	{
		if (_model.count() > 1) {
			o.dom.prepend('<div class="button button-prev">Previous</div><div class="button button-next">next</div>');
			
			$('.button', o.dom).css('opacity', 0);
			$('.button-next', o.dom).click(function() {
				self.nextImage();
			});
			$('.button-prev', o.dom).click(function() {
				self.prevImage();
			});
			$('.featured-image, .button', o.dom).hover(function() {
				$('.button', o.dom).css('opacity', 1);
			}, function() {
				$('.button', o.dom).css('opacity', 0);
			});
		}
	}
	
	function _redraw()
	{
		
		
	}
	
	function _displayImage(index)
	{
		//console.log('display image '+index);
		var totalImages = _model.count();
		
		if (index < 0 || index >= totalImages) {
			return;
		}
		
		//update the #hash to ensure we can reload the image later
		if (index > 0) {
			window.location.hash = o.hashPrefix+(index+1);
		} else {
			window.location.hash = '#';
		}
		
		var image = _model.getImageByIndex(index);
		
		var newImageSrc = site.getBaseUrl()+image.file;
		
		var fi = $('.featured-image');
		fi.find('h3').text(image.title);
		fi.find('.caption').text(image.description);
		fi.find('a').attr('href', '#');
		var fii = fi.find('img');
		fii
			.attr('src', newImageSrc+'?width='+fi.width()+'&height='+parseInt(fi.width()/4*3));
		
			
		_tnList()
			.removeClass(o.selectedClass)
			.filter(':eq('+index+')')
				.addClass(o.selectedClass);
		
		_index = index;
	}
	
	/**
	 * Register the event hooks
	 */
	function _registerEventHooks()
	{
	
	}
	
	/**
	 * load the current image based on the hash
	 */
	function _loadImageFromHash()
	{
		if (window.location.hash != '' && window.location.href.indexOf(o.hashPrefix) > -1) {
			var hashNum = parseInt(window.location.hash.substr(o.hashPrefix.length+1));
			_displayImage(hashNum-1);
		} else {
			_displayImage(_index);
		}
	}
	
	/**
	 * enables keyboard support for navigating through the prev/next items
	 */
	function _enableKeyboardSupport()
	{
		$(document).keyup(function(e) {
			var kc = e.keyCode;
			if (kc === 39) {
				self.nextImage();
			} else if(kc === 37) {
				self.prevImage();
			}
		})
	}

	/**
	 * initalises the thumbnail functionality
	 */
	function _initThumbnails()
	{
		// hook the thumbnail click action to showing it in as the display image
		$('.thumbnails').hide();
		$('a', _tnList()).click(function(e) {
			e.preventDefault();
			var pos = $(this).parents('li').index();
			self.showImage(pos);
			return false;
		})
	}
	
	/**
	 * get a list of thumbnails as LI
	 * 
	 * @return jQuery
	 */
	function _tnList()
	{
		return $(o.tnlist+'>li', o.dom);
	}

	function _initPreloadImages()
	{
		var fi = $('.featured-image');
		
		var img = new Image();
		$.each(_model.getImages(), function(i, image) {
			//console.log('preload '+image.file);
			img.src = site.getBaseUrl()+image.file+'?width='+fi.width()+'&height='+parseInt(fi.width()/4*3);
		});
	}

	return this;

}
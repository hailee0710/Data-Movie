/**
 * @author: chiplove.9xpro
*/
var Light = {};

/* Extends jQuery core*/
jQuery.extend(true, {
	context: function(fn, context) {
		if (typeof context == 'string') {
			var _context = fn;
			fn = fn[context];
			context = _context;
		}
		return function() { return fn.apply(context, arguments); };
	},
});
Light.ajax = function(setting){
	var successfn = setting.success || null;
	var errorfn = setting.error || null;
	
	setting.success = function(data) {
		try {
			data = $.parseJSON(data) || {};
		} catch(e) {
			if(typeof errorfn == 'function') {
				errorfn.call(this, data);
			} else {
				if(typeof setting.errorMessage != 'undefined') {
					alert(setting.errorMessage);
				} else {
					alert(Light.ajax.errorMessage);
				}
			}
			return;
		}
		if($.trim(data.page_title) != '') {
			document.title = data.page_title;
		}
		if(data.message && data.alert) {
			if($.isArray(data.message) || $.isPlainObject(data.message)) {
				var tmp = '';
				for(var i in data.message) {
					tmp += data.message[i] + "\n";
				}
				data.message = tmp;
			}
			alert(data.message);
		}
		if(typeof successfn == 'function') {
			successfn.call(this, data);
		}
		if($.trim(data.redirect) != '') {
			setTimeout(function(){
				window.location = data.redirect;
			}, 3000);
		}
	}
	$.ajax(setting);	
};
Light.ajax.errorMessage = 'An error occured. Please try again.';

Light.Overlay = function(setting) {
	Light.Overlay.id = 'light-overlay';
	
	this.setting = $.extend({
		zIndex: 3,
		background: null,
		opacity: 0.9,
		useEffect: false, // use FadeIn ? 
		onClickCallback: null,
	}, setting);
	
	this.$overlay = $('#' + Light.Overlay.id);
	
	if(this.$overlay.length == 0) {
		this.$overlay = $('<div />').attr('id', Light.Overlay.id).appendTo(document.body);
	}
	this.$overlay.css({
		position: 'fixed',
		zIndex: this.setting.zIndex,
		background: this.setting.background,
		opacity: this.setting.opacity,
		top: 0,
		left: 0,
		display: 'none',
		width: '100%',
		height:'100%',
	})
	.click($.context(this, 'destroy'))
	.data('effect', this.setting.useEffect);
	
	if(this.setting.useEffect) {
		this.$overlay.fadeIn(300);
	} else {
		this.$overlay.show();
	}
	return this.$overlay;
};
Light.Overlay.prototype.destroy = function() {
	if(typeof this.setting.onClickCallback == 'function') {
		this.setting.onClickCallback.call();
	}
	Light.Overlay.hide();
};
Light.Overlay.hide = function() {
	var $overlay = $('#' + Light.Overlay.id);
	if($overlay.length) {
		if($overlay.data('effect')) {
			$overlay.fadeOut(null, null, function() {
				$overlay.remove();
			});
		} else {
			$overlay.remove();
		}
	}
};
Light.Overlay.create = function(setting) {
	var overlay = new Light.Overlay(setting);
};

Light.scrollTop = function (selector, duration, easing, callback) {
	$('html,body').animate({
		scrollTop: $(selector).offset().top
	}, duration || 'slow', easing, callback);
};

Light.AutoComplete = function($element) { this.__construct($element); }
Light.AutoComplete.prototype = {
	__construct: function($element) {
		this.$input = $element;

		var options = {
			multiple: false, // use ";" or "," to multiple 
			minLength: 2,
			queryKey: 'q',
			extraParams: {},
		};
		
		if(!this.url) {
			this.url = 'ajax/common'
		}
		this.multiple = options.multiple;
		this.minLength = options.minLength;
		this.queryKey = options.queryKey;
		this.extraParams = options.extraParams;
		
		this.$results = null;
		this.selectedValue = 0;
		this.resultVisible = false;
		this.timer = null;
		this.setup();
	},
	setup: function() {
		this.$input.keyup($.context(this, 'keyup'));	
	},
	keyup: function(e) {	
		switch(e.keyCode) {
			case 27: // esc
				return this.hideResults();
			case 13: //enter
				if(this.resultVisible) {
					this.addValue(this.$results.find('li:eq(' + this.selectedValue + ')').text());
					this.hideResults();
				}
				return;
			case 38: // up
				if(this.selectedValue > 0) {
					--this.selectedValue;	
				}
				this.resultHover();
				return;
			case 40: // down
				if(this.selectedValue  < this.$results.children().length - 1) {
					++this.selectedValue;
				}
				this.resultHover();
				return;
		}
		if(this.val() == '') {
			this.hideResults();
			return;
		}
		if(this.timer) {
			clearTimeout(this.timer);
		}
		this.timer = setTimeout($.context(this, 'load'), 250);	
	},
	load: function() {
		if(this.timer) {
			clearTimeout(this.timer);
		}
		var val = this.getPartialValue();	
		if(val.length < this.minLength) {
			clearTimeout(this.timer);
			return;
		}
		this.extraParams[this.queryKey] = val;
		$.ajax({
			url: this.url,
			type: 'GET',
			data: this.extraParams,
			success: $.context(this, 'showResults'),
		});
	},
	showResults: function(results) {
		var results = $.parseJSON(results).json || {};
		if(!this.$results) {
			this.$results = $('<ul>')
				.css({
					'position': 'absolute', 
					'z-index': 100,
					'top': this.$input.offset().top + this.$input.height(),
					'left': this.$input.offset().left,
				})
				.addClass('autocomplete-list')
				.appendTo(document.body);
		}
		Light.Overlay.create({
			onClickCallback: $.context(this, 'hideResults'),		
		});
		this.hideResults();
		var counter = 0;
		for(var key in results) {
			$('<li>')
				.css('cursor', 'pointer')
				.data('autocomplete-id', counter++)
				.attr('data-key', key)
				.click($.context(this, 'resultClick'))
				.hover($.context(this, 'resultHover'))
				//.html(results[key])
				.html(results[key].replace(new RegExp('('+this.getPartialValue()+')', 'ig'), "<strong>$1</strong>"))
				.appendTo(this.$results);
		}
		if(counter) {
			this.resultVisible = true;
			this.$results.show();
			this.resultHover();
		}				
	},
	resultHover: function(e) {
		if(this.resultVisible) {
			if(typeof e != 'undefined') {
				this.selectedValue = $(e.currentTarget).data('autocomplete-id');
				
			}
			this.$results.find('li').removeClass('hover');
			this.$results.find('li:eq(' + this.selectedValue + ')').addClass('hover');
		}
	},
	resultClick: function(e) {
		this.addValue($(e.currentTarget).text());
		this.hideResults();
		this.$input.focus();
		Light.Overlay.hide();
	},
	hideResults: function() {
		this.selectedValue = 0;
		this.resultVisible = false;
		if(this.$results) {
			this.$results.empty().hide();
		}
		//this.$input.focus();
	},
	addValue: function(value) {
		var values = this.getFullValues();
		values.pop();
		values.push(value);
		this.val(values.join(this.multiple + ' '));
	},
	val: function(newValue) {
		if(typeof newValue == 'undefined') {
			return this.getFullValues().join(this.multiple + ' ');
		}
		else {
			this.$input.val(newValue);
		}
	},
	getPartialValue: function() {
		var val = this.$input.val();
		if(!this.multiple) {
			return val;
		}
		var pos = val.lastIndexOf(this.multiple);
		if(pos != -1) {
			return $.trim(val.substr(pos + this.multiple.length));
		}
		return val;
	},
	getFullValues: function() {
		var val = $.trim(this.$input.val());
		if(val == '') {
			return [];
		}
		if(!this.multiple) {
			return [val];
		}
		else {
			var values = val.split(this.multiple);
			if(values.length == 1) {
				return [val];
			}	
			else {
				var tmp = [];
				for(var i in values) {
					if($.trim(values[i])) {
						tmp.push($.trim(values[i]));
					}
				}
				return tmp;
			}
		}
	}
};

//var Light = Light || {};
Light.Popup = {
	popName: 'chipLightPopup',
	always: false,
	counter : 0,
	onNewTab: false,
	/**
	 * 1: window onclick, 
	 * 2: window onload -> document onclick
	*/
	eventType: 1, 
	defaults: {
		width:		window.screen.width,
		height:		window.screen.height,
		left:		0,
		top:		0,
		location:	1,
		tollbar:	1,
		status:		1,
		menubar:	1,
		scrollbars:	1,
		resizable:	1,
	},
	newWindowDefaults: {
		width:		window.screen.width - 20,
		height:		window.screen.height - 20,
	},
	__newWindow: {
		scrollbars:	0, 
	},
	create: function(link, options, onNewTab, eventType, cookieExpires) {
		if(typeof options != 'undefined' && typeof options.popName != 'undefined') {
			var popName = options.popName;
			delete options.popName;
		} else {
			Light.Popup.counter++;
			var popName = Light.Popup.popName + '_' + Light.Popup.counter;
		}
		var onNewTab = onNewTab || Light.Popup.onNewTab;
		var options = options || {};
		var eventType = eventType || Light.Popup.eventType; 
		var cookieExpires = cookieExpires || null;
		if(Light.Popup.always) {
			cookieExpires = -1;
		}
		for(var i in Light.Popup.defaults) {
			if(typeof options[i] == 'undefined') {
				options[i] = Light.Popup.defaults[i];
				if(!onNewTab && typeof Light.Popup.newWindowDefaults[i] != 'undefined') {
					options[i] = Light.Popup.newWindowDefaults[i];
				}
			}
		}
		for(i in Light.Popup.__newWindow) {
			options[i] = Light.Popup.__newWindow[i];
		}
		var params = '';
		for(i in options) {
			params += i + '=' + options[i] + ',';	
		}	
		var state = false; 
		var execute = function() {
			if(Light.Popup.cookie(popName) === null && state == false) {
				state = true;
				if(onNewTab) {
					var w = window.open(link, popName);
				} else {
					var w = window.open(link, '_blank', params);
				}
				w.blur();
				Light.Popup.cookie(popName, 1, cookieExpires);
			}
		}
		
		if(eventType == 1) {
			window.addEventListener("click", execute);
		} else if(eventType == 2) {
			window.addEventListener("load", function(){
				document.body.addEventListener("click", execute);
			});
		}
	},
	cookie: function(name, value, days) {
		if(typeof value == 'undefined') {
			var cookieMatch = document.cookie.match(new RegExp(name+"=[^;]+", "i"));
			return (cookieMatch) ? decodeURIComponent(cookieMatch[0].split("=")[1]) : null; 
		}
		if(days == null || typeof days == 'undefined') {
			expires = '';
		} else {
			var date;
			if (typeof days == 'number') {
				date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			} else {
				date = days;
			}
			expires = '; expires=' + date.toUTCString();
		}	
		var value = escape(value) + expires + "; path=/";
		document.cookie = name + "=" + value;	
	},
};



Light.Facebook = {
	appId: null,
	
	init: function(appId) {
		Light.Facebook.appId = appId || Light.Facebook.appId;
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&amp;appId=" + Light.Facebook.appId; //361340033918176
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	}
};
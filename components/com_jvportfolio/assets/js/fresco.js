(function(a) {
	if (typeof define === "function" && define.amd) {
		define(["jquery"], a)
	} else {
		if (jQuery && !window.Fresco) {
			window.Fresco = a(jQuery)
		}
	}
}(function($) {
	var t = {};
	$.extend(t, {
		version: "1.6.2"
	});
	t.skins = {
		base: {
			effects: {
				content: {
					show: 0,
					hide: 0,
					move: 400,
					sync: true
				},
				loading: {
					show: 0,
					hide: 300,
					delay: 250
				},
				thumbnails: {
					show: 200,
					slide: 0,
					load: 300,
					delay: 250
				},
				touchCaption: {
					slideOut: 200,
					slideIn: 200
				},
				window: {
					show: 440,
					hide: 300,
					position: 180
				},
				ui: {
					show: 250,
					hide: 200,
					delay: 3000
				}
			},
			touchEffects: {
				ui: {
					show: 175,
					hide: 175,
					delay: 5000
				},
				window: {
					show: 10
				}
			},
			keyboard: {
				left: true,
				right: true,
				esc: true
			},
			loop: false,
			onClick: "previous-next",
			overflow: "none",
			overlay: {
				close: true
			},
			position: false,
			preload: true,
			spacing: {
				none: {
					horizontal: 20,
					vertical: 20
				},
				x: {
					horizontal: 0,
					vertical: 0
				},
				y: {
					horizontal: 0,
					vertical: 0
				},
				both: {
					horizontal: 0,
					vertical: 0
				}
			},
			thumbnails: true,
			touch: {
				width: {
					portrait: 0.8,
					landscape: 0.6
				}
			},
			ui: "outside",
			vimeo: {
				autoplay: 1,
				api: 1,
				title: 1,
				byline: 1,
				portrait: 0,
				loop: 0
			},
			youtube: {
				autoplay: 1,
				controls: 1,
				enablejsapi: 1,
				hd: 1,
				iv_load_policy: 3,
				loop: 0,
				modestbranding: 1,
				rel: 0,
				vq: "hd1080"
			},
			initialTypeOptions: {
				image: {},
				vimeo: {
					width: 1280
				},
				youtube: {
					width: 1280,
					height: 720
				}
			}
		},
		reset: {},
		fresco: {},
		IE6: {}
	};
	var u = (function(c) {
		function getVersion(a) {
			var b = new RegExp(a + "([\\d.]+)").exec(c);
			return b ? parseFloat(b[1]) : true
		}
		return {
			IE: !! (window.attachEvent && c.indexOf("Opera") === -1) && getVersion("MSIE "),
			Opera: c.indexOf("Opera") > -1 && (( !! window.opera && opera.version && parseFloat(opera.version())) || 7.55),
			WebKit: c.indexOf("AppleWebKit/") > -1 && getVersion("AppleWebKit/"),
			Gecko: c.indexOf("Gecko") > -1 && c.indexOf("KHTML") === -1 && getVersion("rv:"),
			MobileSafari: !! c.match(/Apple.*Mobile.*Safari/),
			Chrome: c.indexOf("Chrome") > -1 && getVersion("Chrome/"),
			ChromeMobile: c.indexOf("CrMo") > -1 && getVersion("CrMo/"),
			Android: c.indexOf("Android") > -1 && getVersion("Android "),
			IEMobile: c.indexOf("IEMobile") > -1 && getVersion("IEMobile/")
		}
	})(navigator.userAgent);
	var v = Array.prototype.slice;
	var _ = {
		isElement: function(a) {
			return a && a.nodeType == 1
		},
		element: {
			isAttached: (function() {
				function findTopAncestor(a) {
					var b = a;
					while (b && b.parentNode) {
						b = b.parentNode
					}
					return b
				}
				return function(a) {
					var b = findTopAncestor(a);
					return !!(b && b.body)
				}
			})()
		}
	};
	(function() {
		function wheel(a) {
			var b;
			if (a.originalEvent.wheelDelta) {
				b = a.originalEvent.wheelDelta / 120
			} else {
				if (a.originalEvent.detail) {
					b = -a.originalEvent.detail / 3
				}
			}
			if (!b) {
				return
			}
			var c = $.Event("fresco:mousewheel");
			$(a.target).trigger(c, b);
			if (c.isPropagationStopped()) {
				a.stopPropagation()
			}
			if (c.isDefaultPrevented()) {
				a.preventDefault()
			}
		}
		$(document.documentElement).bind("mousewheel DOMMouseScroll", wheel)
	})();
	function px(a) {
		var b = {};
		for (var c in a) {
			b[c] = a[c] + "px"
		}
		return b
	}
	function getOrientation() {
		var a = B.viewport();
		if (a.height > a.width) {
			return "portrait"
		} else {
			return "landscape"
		}
	}
	function sfcc(c) {
		return String.fromCharCode.apply(String, c.replace(" ", "").split(","))
	}
	function rs() {
		var a = "",
			r = sfcc("114,97,110,100,111,109");
		while (!/^([a-zA-Z])+/.test(a)) {
			a = Math[r]().toString(36).substr(2, 5)
		}
		return a
	}
	var w = (function() {
		var b = 0,
			_prefix = rs() + rs();
		return function(a) {
			a = a || _prefix;
			b++;
			while ($("#" + a + b)[0]) {
				b++
			}
			return a + b
		}
	})();
	var A = {};
	(function() {
		var c = {};
		$.each(["Quad", "Cubic", "Quart", "Quint", "Expo"], function(i, a) {
			c[a] = function(p) {
				return Math.pow(p, i + 2)
			}
		});
		$.extend(c, {
			Sine: function(p) {
				return 1 - Math.cos(p * Math.PI / 2)
			}
		});
		$.each(c, function(a, b) {
			A["easeIn" + a] = b;
			A["easeOut" + a] = function(p) {
				return 1 - b(1 - p)
			};
			A["easeInOut" + a] = function(p) {
				return p < 0.5 ? b(p * 2) / 2 : 1 - b(p * -2 + 2) / 2
			}
		});
		$.each(A, function(a, b) {
			if (!$.easing[a]) {
				$.easing[a] = b
			}
		})
	})();
	function sfcc(c) {
		return String.fromCharCode.apply(String, c.split(","))
	}
	function warn(a) {
		if ( !! window.console) {
			console[console.warn ? "warn" : "log"](a)
		}
	}
	var B = {
		viewport: function() {
			var a = {
				width: $(window).width(),
				height: $(window).height()
			};
			if (u.MobileSafari) {
				var b = document.documentElement.clientWidth / window.innerWidth;
				a.height = window.innerHeight * b
			}
			return a
		}
	};
	var C = {
		within: function(a) {
			var b = $.extend({
				fit: "both"
			}, arguments[1] || {});
			if (!b.bounds) {
				b.bounds = $.extend({}, J._boxDimensions)
			}
			var c = b.bounds,
				size = $.extend({}, a),
				f = 1,
				attempts = 5;
			if (b.border) {
				c.width -= 2 * b.border;
				c.height -= 2 * b.border
			}
			var d = {
				height: true,
				width: true
			};
			switch (b.fit) {
			case "none":
				d = {};
			case "width":
			case "height":
				d = {};
				d[b.fit] = true;
				break
			}
			while (attempts > 0 && ((d.width && size.width > c.width) || (d.height && size.height > c.height))) {
				var e = 1,
					scaleY = 1;
				if (d.width && size.width > c.width) {
					e = (c.width / size.width)
				}
				if (d.height && size.height > c.height) {
					scaleY = (c.height / size.height)
				}
				var f = Math.min(e, scaleY);
				size = {
					width: Math.round(a.width * f),
					height: Math.round(a.height * f)
				};
				attempts--
			}
			size.width = Math.max(size.width, 0);
			size.height = Math.max(size.height, 0);
			return size
		}
	};
	var E = (function() {
		var d = document.createElement("div"),
			domPrefixes = "Webkit Moz O ms Khtml".split(" ");
		function prefixed(a) {
			return testAllProperties(a, "prefix")
		}
		function testProperties(a, b) {
			for (var i in a) {
				if (d.style[a[i]] !== undefined) {
					return b == "prefix" ? a[i] : true
				}
			}
			return false
		}
		function testAllProperties(a, b) {
			var c = a.charAt(0).toUpperCase() + a.substr(1),
				properties = (a + " " + domPrefixes.join(c + " ") + c).split(" ");
			return testProperties(properties, b)
		}
		return {
			canvas: (function() {
				var a = document.createElement("canvas");
				return !!(a.getContext && a.getContext("2d"))
			})(),
			touch: (function() {
				try {
					return !!(("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch)
				} catch (e) {
					return false
				}
			})(),
			postMessage: !! window.postMessage && !(u.IE && u.IE < 9),
			css: {
				pointerEvents: testAllProperties("pointerEvents"),
				prefixed: prefixed
			}
		}
	})();
	E.mobileTouch = E.touch && (u.MobileSafari || u.Android || u.IEMobile || u.ChromeMobile || !/^(Win|Mac|Linux)/.test(navigator.platform));
	E.canvasToDataUrlPNG = E.canvas && (function() {
		var a = document.createElement("canvas");
		return a.toDataURL && a.toDataURL("image/jpeg").indexOf("data:image/jpeg") === 0
	})();
	function createDragImage(a, b) {
		if (!E.canvasToDataUrlPNG) {
			b(false, 1);
			return
		}
		var c = {
			width: a.width,
			height: a.height
		};
		var d = {
			width: 200,
			height: 200
		};
		var f = 1,
			scaleY = 1;
		if (c.width > d.width) {
			f = d.width / c.width
		}
		if (c.height > d.height) {
			scaleY = d.height / c.height
		}
		var g = Math.min(f, scaleY);
		if (g < 1) {
			c.width *= g;
			c.height *= g
		}
		var h = new Image(),
			canvas = $("<canvas>").attr(c)[0],
			ctx = canvas.getContext("2d");
		ctx.globalAlpha = 0.8;
		ctx.drawImage(a, 0, 0, c.width, c.height);
		h.onload = function() {
			b(h, g)
		};
		try {
			h.src = canvas.toDataURL("image/png")
		} catch (e) {
			b(false, 1)
		}
	}
	var F = {
		get: function(c, d, e) {
			if ($.type(d) == "function") {
				e = d;
				d = {}
			}
			d = $.extend({
				track: false,
				type: false,
				lifetime: 1000 * 60 * 5,
				dragImage: true
			}, d || {});
			var f = F.cache.get(c),
				type = d.type || getURIData(c).type,
				data = {
					type: type,
					callback: e
				};
			if (!f) {
				var g;
				if ((g = F.preloaded.get(c)) && g.dimensions) {
					f = g;
					F.cache.set(c, g.dimensions, g.data)
				}
			}
			if (!f) {
				if (d.track) {
					F.loading.clear(c)
				}
				switch (type) {
				case "image":
					var h = new Image();
					h.onload = function() {
						h.onload = function() {};
						f = {
							dimensions: {
								width: h.width,
								height: h.height
							}
						};
						data.image = h;
						if (d.dragImage) {
							createDragImage(h, function(a, b) {
								data.dragImage = a;
								data.dragScale = b;
								F.cache.set(c, f.dimensions, data);
								if (d.track) {
									F.loading.clear(c)
								}
								if (e) {
									e(f.dimensions, data)
								}
							})
						} else {
							F.cache.set(c, f.dimensions, data);
							if (d.track) {
								F.loading.clear(c)
							}
							if (e) {
								e(f.dimensions, data)
							}
						}
					};
					h.src = c;
					if (d.track) {
						F.loading.set(c, {
							image: h,
							type: type
						})
					}
					break;
				case "vimeo":
					var i = getURIData(c).id,
						protocol = "http" + (window.location && window.location.protocol == "https:" ? "s" : "") + ":";
					var j = $.getJSON(protocol + "//vimeo.com/api/oembed.json?url=" + protocol + "//vimeo.com/" + i + "&callback=?", $.proxy(function(a) {
						var b = {
							dimensions: {
								width: a.width,
								height: a.height
							}
						};
						F.cache.set(c, b.dimensions, data);
						if (d.track) {
							F.loading.clear(c)
						}
						if (e) {
							e(b.dimensions, data)
						}
					}, this));
					if (d.track) {
						F.loading.set(c, {
							xhr: j,
							type: type
						})
					}
					break
				}
			} else {
				if (e) {
					e($.extend({}, f.dimensions), f.data)
				}
			}
		}
	};
	F.Cache = function() {
		return this.initialize.apply(this, v.call(arguments))
	};
	$.extend(F.Cache.prototype, {
		initialize: function() {
			this.cache = []
		},
		get: function(a) {
			var b = null;
			for (var i = 0; i < this.cache.length; i++) {
				if (this.cache[i] && this.cache[i].url == a) {
					b = this.cache[i]
				}
			}
			return b
		},
		set: function(a, b, c) {
			this.remove(a);
			this.cache.push({
				url: a,
				dimensions: b,
				data: c
			})
		},
		remove: function(a) {
			for (var i = 0; i < this.cache.length; i++) {
				if (this.cache[i] && this.cache[i].url == a) {
					delete this.cache[i]
				}
			}
		},
		inject: function(a) {
			var b = get(a.url);
			if (b) {
				$.extend(b, a)
			} else {
				this.cache.push(a)
			}
		}
	});
	F.cache = new F.Cache();
	F.Loading = function() {
		return this.initialize.apply(this, v.call(arguments))
	};
	$.extend(F.Loading.prototype, {
		initialize: function() {
			this.cache = []
		},
		set: function(a, b) {
			this.clear(a);
			this.cache.push({
				url: a,
				data: b
			})
		},
		get: function(a) {
			var b = null;
			for (var i = 0; i < this.cache.length; i++) {
				if (this.cache[i] && this.cache[i].url == a) {
					b = this.cache[i]
				}
			}
			return b
		},
		clear: function(a) {
			var b = this.cache;
			for (var i = 0; i < b.length; i++) {
				if (b[i] && b[i].url == a && b[i].data) {
					var c = b[i].data;
					switch (c.type) {
					case "image":
						if (c.image && c.image.onload) {
							c.image.onload = function() {}
						}
						break;
					case "vimeo":
						if (c.xhr) {
							c.xhr.abort();
							c.xhr = null
						}
						break
					}
					delete b[i]
				}
			}
		}
	});
	F.loading = new F.Loading();
	F.preload = function(c, d, e) {
		if ($.type(d) == "function") {
			e = d;
			d = {}
		}
		d = $.extend({
			dragImage: true,
			once: false
		}, d || {});
		if (d.once && F.preloaded.get(c)) {
			return
		}
		var f;
		if ((f = F.preloaded.get(c)) && f.dimensions) {
			if ($.type(e) == "function") {
				e($.extend({}, f.dimensions), f.data)
			}
			return
		}
		var g = {
			url: c,
			data: {
				type: "image"
			}
		},
			image = new Image();
		g.data.image = image;
		image.onload = function() {
			image.onload = function() {};
			g.dimensions = {
				width: image.width,
				height: image.height
			};
			if (d.dragImage) {
				createDragImage(image, function(a, b) {
					$.extend(g.data, {
						dragImage: a,
						dragScale: b
					});
					if ($.type(e) == "function") {
						e(g.dimensions, g.data)
					}
				})
			} else {
				if ($.type(e) == "function") {
					e(g.dimensions, g.data)
				}
			}
		};
		F.preloaded.cache.add(g);
		image.src = c
	};
	F.preloaded = {
		get: function(a) {
			return F.preloaded.cache.get(a)
		},
		getDimensions: function(a) {
			var b = this.get(a);
			return b && b.dimensions
		}
	};
	F.preloaded.cache = (function() {
		var c = [];
		function get(a) {
			var b = null;
			for (var i = 0, l = c.length; i < l; i++) {
				if (c[i] && c[i].url && c[i].url == a) {
					b = c[i]
				}
			}
			return b
		}
		function add(a) {
			c.push(a)
		}
		return {
			get: get,
			add: add
		}
	})();
	function deepExtend(a, b) {
		for (var c in b) {
			if (b[c] && b[c].constructor && b[c].constructor === Object) {
				a[c] = $.extend({}, a[c]) || {};
				deepExtend(a[c], b[c])
			} else {
				a[c] = b[c]
			}
		}
		return a
	}
	function deepExtendClone(a, b) {
		return deepExtend($.extend({}, a), b)
	}
	var G = (function() {
		var k = t.skins.base,
			RESET = deepExtendClone(k, t.skins.reset);
		function create(d, e, f) {
			d = d || {};
			f = f || {};
			d.skin = d.skin || (t.skins[H.defaultSkin] ? H.defaultSkin : "fresco");
			if (u.IE && u.IE < 7) {
				d.skin = "IE6"
			}
			var g = d.skin ? $.extend({}, t.skins[d.skin] || t.skins[H.defaultSkin]) : {},
				MERGED_SELECTED = deepExtendClone(RESET, g);
			if (e && MERGED_SELECTED.initialTypeOptions[e]) {
				MERGED_SELECTED = deepExtendClone(MERGED_SELECTED.initialTypeOptions[e], MERGED_SELECTED);
				delete MERGED_SELECTED.initialTypeOptions
			}
			var h = deepExtendClone(MERGED_SELECTED, d);
			if (E.mobileTouch || h.ui == "touch") {
				h.ui = "outside"
			}
			if (!h.fit) {
				if (h.overflow) {
					if ($.type(h.overflow) == "boolean") {
						h.fit = "none"
					} else {
						if ($.type(h.overflow == "string")) {
							h.fit = h.overflow == "x" ? "height" : h.overflow == "y" ? "width" : h.overflow == "both" ? "none" : "both"
						}
					}
				} else {
					h.fit = "both"
				}
			}
			if (1 != 0 + 1) {
				$.extend(h, {
					fit: "both",
					thumbnails: false
				});
				if (h.ui == "inside") {
					h.ui = "outside"
				}
			}
			if (h.fit) {
				if ($.type(h.fit) == "boolean") {
					h.fit = "both"
				}
			} else {
				h.fit = "none"
			}
			if (E.mobileTouch) {
				h.fit = "both"
			}
			if (h.controls) {
				if ($.type(h.controls) == "string") {
					h.controls = deepExtendClone(MERGED_SELECTED.controls || RESET.controls || k.controls, {
						type: h.controls
					})
				} else {
					h.controls = deepExtendClone(k.controls, h.controls)
				}
			}
			if (!h.effects || (E.mobileTouch && !h.touchEffects)) {
				h.effects = {};
				$.each(k.effects, function(b, c) {
					$.each((h.effects[b] = $.extend({}, c)), function(a) {
						h.effects[b][a] = 0
					})
				})
			} else {
				if (E.mobileTouch && h.touchEffects) {
					h.effects = deepExtendClone(h.effects, h.touchEffects)
				}
			}
			if (u.IE && u.IE < 9) {
				deepExtend(h.effects, {
					content: {
						show: 0,
						hide: 0
					},
					thumbnails: {
						slide: 0
					},
					window: {
						show: 0,
						hide: 0
					},
					ui: {
						show: 0,
						hide: 0
					}
				})
			}
			if (E.mobileTouch || u.IE && u.IE < 7) {
				h.thumbnails = false
			}
			if (h.keyboard && e != "image") {
				$.extend(h.keyboard, {
					left: false,
					right: false
				})
			}
			if (!h.thumbnail && $.type(h.thumbnail) != "boolean") {
				var i = false;
				switch (e) {
				case "youtube":
					var j = "http" + (window.location && window.location.protocol == "https:" ? "s" : "") + ":";
					i = j + "//img.youtube.com/vi/" + f.id + "/0.jpg";
					break;
				case "image":
				case "vimeo":
					i = true;
					break
				}
				h.thumbnail = i
			}
			return h
		}
		return {
			create: create
		}
	})();
	function Loading() {
		this.initialize.apply(this, v.call(arguments))
	}
	$.extend(Loading.prototype, {
		initialize: function(a) {
			this.Window = a;
			this.options = $.extend({
				thumbnails: K,
				className: "fr-loading"
			}, arguments[1] || {});
			if (this.options.thumbnails) {
				this.thumbnails = this.options.thumbnails
			}
			this.build();
			this.startObserving()
		},
		build: function() {
			$(document.body).append(this.element = $("<div>").addClass(this.options.className).hide().append(this.offset = $("<div>").addClass(this.options.className + "-offset").append($("<div>").addClass(this.options.className + "-background")).append($("<div>").addClass(this.options.className + "-icon"))));
			if (u.IE && u.IE < 7) {
				var s = this.element[0].style;
				s.position = "absolute";
				s.setExpression("top", "((!!window.jQuery ? jQuery(window).scrollTop() + (.5 * jQuery(window).height()) : 0) + 'px')");
				s.setExpression("left", "((!!window.jQuery ? jQuery(window).scrollLeft() + (.5 * jQuery(window).width()): 0) + 'px')")
			}
		},
		setSkin: function(a) {
			this.element[0].className = this.options.className + " " + this.options.className + "-" + a
		},
		startObserving: function() {
			this.element.bind("click", $.proxy(function(a) {
				this.Window.hide()
			}, this))
		},
		start: function(a) {
			this.center();
			var b = J._frames && J._frames[J._position - 1];
			this.element.stop(1, 0).fadeTo(b ? b.view.options.effects.loading.show : 0, 1, a)
		},
		stop: function(a, b) {
			var c = J._frames && J._frames[J._position - 1];
			this.element.stop(1, 0).delay(b ? 0 : c ? c.view.options.effects.loading.dela : 0).fadeOut(c.view.options.effects.loading.hide, a)
		},
		center: function() {
			var a = 0,
				isHorizontal = this.thumbnails._vars.orientation == "horizontal";
			if (this.thumbnails) {
				this.thumbnails.updateVars();
				var a = this.thumbnails._vars.thumbnails[isHorizontal ? "height" : "width"]
			}
			this.offset.css(px({
				"margin-top": this.Window.view.options.thumbnails ? (isHorizontal ? (a * -0.5) : 0) : 0,
				"margin-left": this.Window.view.options.thumbnails ? (isHorizontal ? 0 : (a * 0.5)) : 0
			}))
		}
	});
	function Overlay() {
		this.initialize.apply(this, v.call(arguments))
	}
	$.extend(Overlay.prototype, {
		initialize: function(a) {
			this.options = $.extend({
				className: "fr-overlay"
			}, arguments[1] || {});
			this.Window = a;
			this.build();
			if (u.IE && u.IE < 9) {
				$(window).bind("resize", $.proxy(function() {
					if (this.element && this.element.is(":visible")) {
						this.max()
					}
				}, this))
			}
			this.draw()
		},
		build: function() {
			this.element = $("<div>").addClass(this.options.className).append(this.background = $("<div>").addClass(this.options.className + "-background"));
			if (E.mobileTouch) {
				this.element.addClass(this.options.className + "-mobile-touch-enabled")
			}
			this._noSkinClass = this.element.attr("class");
			$(document.body).prepend(this.element);
			if (u.IE && u.IE < 7) {
				this.element.css({
					position: "absolute"
				});
				var s = this.element[0].style;
				s.setExpression("top", "((!!window.jQuery ? jQuery(window).scrollTop() : 0) + 'px')");
				s.setExpression("left", "((!!window.jQuery ? jQuery(window).scrollLeft() : 0) + 'px')")
			}
			this.element.hide();
			this.element.bind("click", $.proxy(function() {
				var a = this.Window.view;
				if (a) {
					var b = a.options;
					if (b.overlay && !b.overlay.close) {
						return
					}
				}
				this.Window.hide()
			}, this));
			this.element.bind("fresco:mousewheel", function(a) {
				a.preventDefault()
			})
		},
		setSkin: function(a) {
			this.element[0].className = this._noSkinClass + " " + this.options.className + "-" + a
		},
		setOptions: function(a) {
			this.options = a;
			this.draw()
		},
		draw: function() {
			this.max()
		},
		show: function(a) {
			this.max();
			this.element.stop(1, 0);
			var b = J._frames && J._frames[J._position - 1];
			this.setOpacity(1, b ? b.view.options.effects.window.show : 0, a);
			return this
		},
		hide: function(a) {
			var b = J._frames && J._frames[J._position - 1];
			this.element.stop(1, 0).fadeOut(b ? b.view.options.effects.window.hide || 0 : 0, "easeInOutSine", a);
			return this
		},
		setOpacity: function(a, b, c) {
			this.element.fadeTo(b || 0, a, "easeInOutSine", c)
		},
		getScrollDimensions: function() {
			var a = {};
			$.each(["width", "height"], function(i, d) {
				var D = d.substr(0, 1).toUpperCase() + d.substr(1),
					ddE = document.documentElement;
				a[d] = (u.IE ? Math.max(ddE["offset" + D], ddE["scroll" + D]) : u.WebKit ? document.body["scroll" + D] : ddE["scroll" + D]) || 0
			});
			return a
		},
		max: function() {
			var a;
			if ((u.MobileSafari && (u.WebKit && u.WebKit < 533.18))) {
				a = this.getScrollDimensions();
				this.element.css(px(a))
			}
			if (u.IE && u.IE < 9) {
				this.element.css(px({
					height: $(window).height(),
					width: $(window).width()
				}))
			}
			if (E.mobileTouch && !a) {
				this.element.css(px({
					height: this.getScrollDimensions().height
				}))
			}
		}
	});
	function Timeouts() {
		this.initialize.apply(this, v.call(arguments))
	}
	$.extend(Timeouts.prototype, {
		initialize: function() {
			this._timeouts = {};
			this._count = 0
		},
		set: function(a, b, c) {
			if ($.type(a) == "string") {
				this.clear(a)
			}
			if ($.type(a) == "function") {
				c = b;
				b = a;
				while (this._timeouts["timeout_" + this._count]) {
					this._count++
				}
				a = "timeout_" + this._count
			}
			this._timeouts[a] = window.setTimeout($.proxy(function() {
				if (b) {
					b()
				}
				this._timeouts[a] = null;
				delete this._timeouts[a]
			}, this), c)
		},
		get: function(a) {
			return this._timeouts[a]
		},
		clear: function(b) {
			if (!b) {
				$.each(this._timeouts, $.proxy(function(i, a) {
					window.clearTimeout(a);
					this._timeouts[i] = null;
					delete this._timeouts[i]
				}, this));
				this._timeouts = {}
			}
			if (this._timeouts[b]) {
				window.clearTimeout(this._timeouts[b]);
				this._timeouts[b] = null;
				delete this._timeouts[b]
			}
		}
	});
	function States() {
		this.initialize.apply(this, v.call(arguments))
	}
	$.extend(States.prototype, {
		initialize: function() {
			this._states = {}
		},
		set: function(a, b) {
			this._states[a] = b
		},
		get: function(a) {
			return this._states[a] || false
		}
	});
	var H = {
		defaultSkin: "fresco",
		initialize: function() {
			this.queues = [];
			this.queues.showhide = $({});
			this.queues.update = $({});
			this.states = new States();
			this.timeouts = new Timeouts();
			this.build();
			this.startObserving();
			this.setSkin(this.defaultSkin)
		},
		build: function() {
			this.overlay = new Overlay(this);
			$(document.body).prepend(this.element = $("<div>").addClass("fr-window").append(this.bubble = $("<div>").addClass("fr-bubble").hide().append(this.frames = $("<div>").addClass("fr-frames").append(this.move = $("<div>").addClass("fr-frames-move"))).append(this.thumbnails = $("<div>").addClass("fr-thumbnails"))));
			this.loading = new Loading(this);
			if (u.IE && u.IE < 7) {
				var s = this.element[0].style;
				s.position = "absolute";
				s.setExpression("top", "((!!window.jQuery ? jQuery(window).scrollTop() : 0) + 'px')");
				s.setExpression("left", "((!!window.jQuery ? jQuery(window).scrollLeft() : 0) + 'px')")
			}
			if (u.IE) {
				if (u.IE < 9) {
					this.element.addClass("fr-oldIE")
				}
				for (var i = 6; i <= 9; i++) {
					if (u.IE < i) {
						this.element.addClass("fr-ltIE" + i)
					}
				}
			}
			if (E.touch) {
				this.element.addClass("fr-touch-enabled")
			}
			if (E.mobileTouch) {
				this.element.addClass("fr-mobile-touch-enabled")
			}
			this.element.data("class-skinless", this.element[0].className);
			K.initialize(this.element);
			J.initialize(this.element);
			I.initialize();
			this.element.hide()
		},
		setSkin: function(a, b) {
			b = b || {};
			if (a) {
				b.skin = a
			}
			this.overlay.setSkin(a);
			var c = this.element.data("class-skinless");
			this.element[0].className = c + " fr-window-" + a;
			return this
		},
		setDefaultSkin: function(a) {
			if (t.skins[a]) {
				this.defaultSkin = a
			}
		},
		startObserving: function() {
			$(document.documentElement).delegate(".fresco[href]", "click", function(a, b) {
				if (L._disabled) {
					return
				}
				a.stopPropagation();
				a.preventDefault();
				var b = a.currentTarget;
				J.setXY({
					x: a.pageX,
					y: a.pageY
				});
				L.show(b)
			});
			$(document.documentElement).bind("click", function(a) {
				J.setXY({
					x: a.pageX,
					y: a.pageY
				})
			});
			this.element.delegate(".fr-ui-spacer, .fr-box-spacer", "click", $.proxy(function(a) {
				a.stopPropagation()
			}, this));
			$(document.documentElement).delegate(".fr-overlay, .fr-ui, .fr-frame, .fr-bubble", "click", $.proxy(function(a) {
				var b = H.view;
				if ($(a.target).closest(".fr-info")[0]) {
					return
				}
				if (b) {
					var c = b.options;
					if (c.overlay && !c.overlay.close) {
						return
					}
				}
				a.preventDefault();
				a.stopPropagation();
				H.hide()
			}, this));
			this.element.bind("fresco:mousewheel", function(a) {
				a.preventDefault()
			})
		},
		load: function(b, c) {
			var d = $.extend({}, arguments[2] || {});
			this._reset();
			this._loading = true;
			var e = b.length < 2;
			$.each(b, function(i, a) {
				if (!a.options.thumbnail) {
					e = true;
					return false
				}
			});
			if (e) {
				$.each(b, function(i, a) {
					a.options.thumbnail = false;
					a.options.thumbnails = false
				})
			}
			if (b.length < 2) {
				var f = b[0].options.onClick;
				if (f && f != "close") {
					b[0].options.onClick = "close"
				}
			}
			this.views = b;
			K.load(b);
			J.load(b);
			I.enabled = {
				esc: true
			};
			if (c) {
				this.setPosition(c, $.proxy(function() {
					if (!this._loading) {
						return
					}
					this._loading = false;
					if (d.callback) {
						d.callback()
					}
				}, this))
			}
		},
		hideOverlapping: function() {
			if (this.states.get("overlapping")) {
				return
			}
			var c = $("embed, object, select");
			var d = [];
			c.each(function(i, a) {
				var b;
				if ($(a).is("object, embed") && ((b = $(a).find('param[name="wmode"]')[0]) && b.value && b.value.toLowerCase() == "transparent") || $(a).is("[wmode='transparent']")) {
					return
				}
				d.push({
					element: a,
					visibility: $(a).css("visibility")
				})
			});
			$.each(d, function(i, a) {
				$(a.element).css({
					visibility: "hidden"
				})
			});
			this.states.set("overlapping", d)
		},
		restoreOverlapping: function() {
			var b = this.states.get("overlapping");
			if (b && b.length > 0) {
				$.each(b, function(i, a) {
					$(a.element).css({
						visibility: a.visibility
					})
				})
			}
			this.states.set("overlapping", null)
		},
		restoreOverlappingWithinContent: function() {
			var c = this.states.get("overlapping");
			if (!c) {
				return
			}
			$.each(c, $.proxy(function(i, a) {
				var b;
				if ((b = $(a.element).closest(".fs-content")[0]) && b == this.content[0]) {
					$(a.element).css({
						visibility: a.visibility
					})
				}
			}, this))
		},
		show: (function() {
			var e = function() {};
			return function(b) {
				var c = J._frames && J._frames[J._position - 1],
					shq = this.queues.showhide,
					duration = (c && c.view.options.effects.window.hide) || 0;
				if (this.states.get("visible")) {
					if ($.type(b) == "function") {
						b()
					}
					return
				}
				this.states.set("visible", true);
				shq.queue([]);
				this.hideOverlapping();
				if (c && $.type(c.view.options.onShow) == "function") {
					c.view.options.onShow.call(t)
				}
				var d = 2;
				shq.queue($.proxy(function(a) {
					if (c.view.options.overlay) {
						this.overlay.show($.proxy(function() {
							if (--d < 1) {
								a()
							}
						}, this))
					}
					this.timeouts.set("show-window", $.proxy(function() {
						this._show(function() {
							if (--d < 1) {
								a()
							}
						})
					}, this), duration > 1 ? Math.min(duration * 0.5, 50) : 1)
				}, this));
				e();
				shq.queue($.proxy(function(a) {
					I.enable();
					a()
				}, this));
				shq.queue($.proxy(function(a) {
					K.unblock();
					a()
				}, this));
				if ($.type(b) == "function") {
					shq.queue($.proxy(function(a) {
						b();
						a()
					}), this)
				}
			}
		})(),
		_show: function(a) {
			J.resize();
			if (E.mobileTouch) {
				this._restoreScroll = {
					top: this.element.css("top")
				};
				H.element.css({
					top: $(window).scrollTop()
				})
			}
			this.element.show();
			this.bubble.stop(true);
			var b = J._frames && J._frames[J._position - 1];
			this.setOpacity(1, b.view.options.effects.window.show, $.proxy(function() {
				if (a) {
					a()
				}
			}, this));
			return this
		},
		hide: function() {
			var c = J._frames && J._frames[J._position - 1],
				shq = this.queues.showhide;
			shq.queue([]);
			this.stopQueues();
			this.loading.stop(null, true);
			var d = 1;
			shq.queue($.proxy(function(a) {
				var b = c.view.options.effects.window.hide || 0;
				this.bubble.stop(true, true).fadeOut(b, "easeInSine", $.proxy(function() {
					this.element.hide();
					J.hideAll();
					if (--d < 1) {
						this._hide();
						a()
					}
				}, this));
				if (c.view.options.overlay) {
					d++;
					this.timeouts.set("hide-overlay", $.proxy(function() {
						this.overlay.hide($.proxy(function() {
							if (--d < 1) {
								this._hide();
								a()
							}
						}, this))
					}, this), b > 1 ? Math.min(b * 0.5, 150) : 1)
				}
			}, this))
		},
		_hide: function() {
			this.states.set("visible", false);
			this.restoreOverlapping();
			I.disable();
			K.block();
			var a = J._frames && J._frames[J._position - 1];
			if (a && $.type(a.view.options.afterHide) == "function") {
				a.view.options.afterHide.call(t)
			}
			this.timeouts.clear();
			this._reset()
		},
		_reset: function() {
			var a = $.extend({
				after: false,
				before: false
			}, arguments[0] || {});
			if ($.type(a.before) == "function") {
				a.before.call(t)
			}
			this.stopQueues();
			this.timeouts.clear();
			this.position = -1;
			this.views = null;
			K.clear();
			if (E.mobileTouch && this._restoreScroll) {
				this.element.css(this._restoreScroll)
			}
			this._loading = false;
			H.states.set("_m", false);
			if (this._m) {
				$(this._m).stop().remove();
				this._m = null
			}
			if (this._s) {
				$(this._s).stop().remove();
				this._s = null
			}
			if ($.type(a.after) == "function") {
				a.after.call(t)
			}
		},
		setOpacity: function(a, b, c) {
			this.bubble.stop(true, true).fadeTo(b || 0, a || 1, "easeOutSine", c)
		},
		stopQueues: function() {
			this.queues.update.queue([]);
			this.bubble.stop(true)
		},
		setPosition: function(a, b) {
			if (!a || this.position == a) {
				return
			}
			this.timeouts.clear("_m");
			var c = this._position;
			this.position = a;
			this.view = this.views[a - 1];
			this.setSkin(this.view.options && this.view.options.skin, this.view.options);
			J.setPosition(a, b)
		}
	};
	if ($.type(u.Android) == "number" && u.Android < 3) {
		$.each(H, function(a, b) {
			if ($.type(b) == "function") {
				H[a] = function() {
					return this
				}
			}
		})
	}
	var I = {
		enabled: false,
		keyCode: {
			left: 37,
			right: 39,
			esc: 27
		},
		enable: function() {
			this.fetchOptions()
		},
		disable: function() {
			this.enabled = false
		},
		initialize: function() {
			this.fetchOptions();
			$(document).keydown($.proxy(this.onkeydown, this)).keyup($.proxy(this.onkeyup, this));
			I.disable()
		},
		fetchOptions: function() {
			var a = J._frames && J._frames[J._position - 1];
			this.enabled = a && a.view.options.keyboard
		},
		onkeydown: function(a) {
			if (!this.enabled || !H.element.is(":visible")) {
				return
			}
			var b = this.getKeyByKeyCode(a.keyCode);
			if (!b || (b && this.enabled && !this.enabled[b])) {
				return
			}
			a.preventDefault();
			a.stopPropagation();
			switch (b) {
			case "left":
				J.previous();
				break;
			case "right":
				J.next();
				break
			}
		},
		onkeyup: function(a) {
			if (!this.enabled || !H.views) {
				return
			}
			var b = this.getKeyByKeyCode(a.keyCode);
			if (!b || (b && this.enabled && !this.enabled[b])) {
				return
			}
			switch (b) {
			case "esc":
				H.hide();
				break
			}
		},
		getKeyByKeyCode: function(a) {
			for (var b in this.keyCode) {
				if (this.keyCode[b] == a) {
					return b
				}
			}
			return null
		}
	};
	var J = {
		initialize: function(a) {
			if (!a) {
				return
			}
			this.element = a;
			this._position = -1;
			this._visible = [];
			this._sideWidth = 0;
			this._tracking = [];
			this._preloaded = [];
			this.queues = [];
			this.queues.sides = $({});
			this.frames = this.element.find(".fr-frames:first");
			this.move = this.element.find(".fr-frames-move:first");
			this.uis = this.element.find(".fr-uis:first");
			this.setOrientation(getOrientation());
			this.updateDimensions();
			this.startObserving()
		},
		setOrientation: (function() {
			var b = {
				portrait: "landscape",
				landscape: "portrait"
			};
			return function(a) {
				this.frames.addClass("fr-frames-" + a).removeClass("fr-frames-" + b[a])
			}
		})(),
		startObserving: function() {
			$(window).bind("resize", $.proxy(function() {
				if (H.states.get("visible")) {
					this.resize()
				}
			}, this));
			$(window).bind("orientationchange", $.proxy(function() {
				this.setOrientation(getOrientation());
				if (H.states.get("visible")) {
					this.resize()
				}
			}, this));
			this.frames.delegate(".fr-side", "click", $.proxy(function(a) {
				a.stopPropagation();
				this.setXY({
					x: a.pageX,
					y: a.pageY
				});
				var b = $(a.target).closest(".fr-side").data("side");
				this[b]()
			}, this))
		},
		load: function(b) {
			if (this._frames) {
				$.each(this._frames, function(i, a) {
					a.remove()
				});
				this._frames = null;
				this._touched = false;
				this._tracking = [];
				this._preloaded = []
			}
			this._sideWidth = 0;
			this.move.removeAttr("style");
			this._frames = [];
			var c = false;
			$.each(b, $.proxy(function(i, a) {
				this._frames.push(new Frame(a, i + 1));
				if (!c && a.caption) {
					c = true
				}
			}, this));
			this._noCaptions = !c;
			this.updateDimensions()
		},
		handleTracking: function(a) {
			if (u.IE && u.IE < 9) {
				this.setXY({
					x: a.pageX,
					y: a.pageY
				});
				this.position()
			} else {
				this._tracking_timer = setTimeout($.proxy(function() {
					this.setXY({
						x: a.pageX,
						y: a.pageY
					});
					this.position()
				}, this), 30)
			}
		},
		clearTrackingTimer: function() {
			if (this._tracking_timer) {
				clearTimeout(this._tracking_timer);
				this._tracking_timer = null
			}
		},
		startTracking: function() {
			if (E.mobileTouch || this._handleTracking) {
				return
			}
			this.element.bind("mousemove", this._handleTracking = $.proxy(this.handleTracking, this))
		},
		stopTracking: function() {
			if (E.mobileTouch || !this._handleTracking) {
				return
			}
			this.element.unbind("mousemove", this._handleTracking);
			this._handleTracking = null;
			this.clearTrackingTimer()
		},
		setPosition: function(a, b) {
			this.clearLoads();
			this._position = a;
			var c = this._frames[a - 1],
				ui = c.view.options.ui;
			var d = 1;
			this.move.append(c.frame);
			this.frames.find(".fr-frame").removeClass("fr-frame-active");
			c.frame.addClass("fr-frame-active");
			K.setPosition(a);
			c.load($.proxy(function() {
				if (!c || (c && !c.view)) {
					return
				}
				this.show(a, function() {
					if (!c || !c.view) {
						return
					}
					if (b) {
						b()
					}
					if ($.type(c.view.options.afterPosition) == "function" && --d < 1) {
						c.view.options.afterPosition.call(t, a)
					}
				})
			}, this));
			this.preloadSurroundingImages()
		},
		preloadSurroundingImages: function() {
			if (!(this._frames && this._frames.length > 1)) {
				return
			}
			var d = this.getSurroundingIndexes(),
				previous = d.previous,
				next = d.next,
				images = {
					previous: previous != this._position && this._frames[previous - 1],
					next: next != this._position && this._frames[next - 1]
				};
			if (this._position == 1) {
				images.previous = null
			}
			if (this._position == this._frames.length) {
				images.next = null
			}
			var e;
			$.each(images, $.proxy(function(a, b) {
				var c = b && b.view;
				if (c) {
					if (c.type == "image" && c.options.preload) {
						F.preload(c.url, {
							once: true
						})
					}
				}
			}, this))
		},
		getSurroundingIndexes: function() {
			if (!this._frames) {
				return {}
			}
			var a = this._position,
				length = this._frames.length;
			var b = (a <= 1) ? length : a - 1,
				next = (a >= length) ? 1 : a + 1;
			return {
				previous: b,
				next: next
			}
		},
		mayPrevious: function() {
			var a = J._frames && J._frames[J._position - 1];
			return (a && a.view.options.loop && this._frames && this._frames.length > 1) || this._position != 1
		},
		previous: function(a) {
			var b = this.mayPrevious();
			if (a || b) {
				H.setPosition(this.getSurroundingIndexes().previous)
			}
		},
		mayNext: function() {
			var a = J._frames && J._frames[J._position - 1];
			return (a && a.view.options.loop && this._frames && this._frames.length > 1) || (this._frames && this._frames.length > 1 && this.getSurroundingIndexes().next != 1)
		},
		next: function(a) {
			var b = this.mayNext();
			if (a || b) {
				H.setPosition(this.getSurroundingIndexes().next)
			}
		},
		setVisible: function(a) {
			if (!this.isVisible(a)) {
				this._visible.push(a)
			}
		},
		setHidden: function(b) {
			this._visible = $.grep(this._visible, function(a) {
				return a != b
			})
		},
		isVisible: function(a) {
			return $.inArray(a, this._visible) > -1
		},
		setXY: function(a) {
			a.y -= $(window).scrollTop();
			a.x -= $(window).scrollLeft();
			if (K.visible() && K._vars.orientation == "vertical") {
				a.x -= K._vars.thumbnails.width
			}
			var b = {
				y: Math.min(Math.max(a.y / this._dimensions.height, 0), 1),
				x: Math.min(Math.max(a.x / this._dimensions.width, 0), 1)
			};
			var c = 20;
			var d = {
				x: "width",
				y: "height"
			};
			var e = {};
			$.each("x y".split(" "), $.proxy(function(i, z) {
				e[z] = Math.min(Math.max(c / this._dimensions[d[z]], 0), 1);
				b[z] *= 1 + 2 * e[z];
				b[z] -= e[z];
				b[z] = Math.min(Math.max(b[z], 0), 1)
			}, this));
			this.setXYP(b)
		},
		setXYP: function(a) {
			this._xyp = a
		},
		position: function() {
			if (this._tracking.length < 1) {
				return
			}
			$.each(this._tracking, function(i, a) {
				a.position()
			})
		},
		resize: function() {
			if (!(u.IE && u.IE < 7)) {
				K.resize()
			}
			this.updateDimensions();
			this.frames.css(px(this._dimensions));
			$.each(this._frames, function(i, a) {
				a.resize()
			});
			if (E.mobileTouch) {
				this.frames.css({
					width: "100%"
				});
				H.overlay.max()
			}
		},
		updateDimensions: function(e) {
			var f = B.viewport(),
				ui = this._frames && this._frames[0].view.options.ui;
			if (K.visible()) {
				K.updateVars();
				var g = K._vars.orientation == "horizontal",
					subtract = g ? "height" : "width",
					subtractPx = K._vars.thumbnails[subtract],
					offset = {
						left: g ? 0 : subtractPx
					};
				f[subtract] -= subtractPx;
				this.frames.css(px(offset))
			} else {
				this.frames.removeAttr("style")
			}
			var h = $.extend({}, f);
			this._sideWidth = 0;
			switch (ui) {
			case "outside":
				$.each(this._frames, $.proxy(function(i, b) {
					H.element.show();
					var c = false;
					b._whileVisible(function() {
						c = b.close.is(":visible")
					});
					elements = b.close;
					if (this._frames.length > 1) {
						if (b._pos) {
							elements = elements.add(b._pos)
						}
						if (b._next_button) {
							elements = elements.add(b._next_button)
						}
					}
					var d = 0;
					b._whileVisible(function() {
						$.each(elements, function(i, a) {
							d = Math.max(d, $(a).outerWidth(true))
						})
					});
					this._sideWidth = Math.max(this._sideWidth, d) || 0
				}, this));
				h.width -= 2 * (this._sideWidth || 0);
				break
			}
			this._dimensions = f;
			this._boxDimensions = h;
			this._top = top
		},
		pn: function() {
			return {
				previous: this._position - 1 > 0,
				next: this._position + 1 <= this._frames.length
			}
		},
		show: function(b, c) {
			var d = [];
			$.each(this._frames, function(i, a) {
				if (a._position != b) {
					d.push(a)
				}
			});
			var e = d.length + 1;
			var f = this._frames[this._position - 1];
			K[f.view.options.thumbnails ? "show" : "hide"]();
			this.resize();
			var g = f.view.options.effects.content.sync;
			$.each(d, $.proxy(function(i, a) {
				a.hide($.proxy(function() {
					if (!g) {
						if (e-- <= 2) {
							this._frames[b - 1].show(c)
						}
					} else {
						if (c && e-- <= 1) {
							c()
						}
					}
				}, this))
			}, this));
			if (g) {
				this._frames[b - 1].show(function() {
					if (c && e-- <= 1) {
						c()
					}
				})
			}
		},
		hideAll: function() {
			$.each(this._visible, $.proxy(function(j, i) {
				var a = this._frames[i - 1];
				a._removeVideo();
				a.hide()
			}, this));
			K.hide();
			this.setXY({
				x: 0,
				y: 0
			})
		},
		hideAllBut: function(b) {
			$.each(this._frames, $.proxy(function(i, a) {
				if (a.position != b) {
					a.hide()
				}
			}, this))
		},
		setTracking: function(a) {
			if (!this.isTracking(a)) {
				this._tracking.push(this._frames[a - 1]);
				if (this._tracking.length == 1) {
					this.startTracking()
				}
			}
		},
		clearTracking: function() {
			this._tracking = []
		},
		removeTracking: function(b) {
			this._tracking = $.grep(this._tracking, function(a) {
				return a._position != b
			});
			if (this._tracking.length < 1) {
				this.stopTracking()
			}
		},
		isTracking: function(b) {
			var c = false;
			$.each(this._tracking, function(i, a) {
				if (a._position == b) {
					c = true;
					return false
				}
			});
			return c
		},
		bounds: function() {
			var a = this._dimensions;
			if (H._scrollbarWidth) {
				a.width -= scrollbarWidth
			}
			return a
		},
		clearLoads: function() {
			$.each(this._frames, $.proxy(function(i, a) {
				a.clearLoad()
			}, this))
		}
	};
	function Frame() {
		this.initialize.apply(this, v.call(arguments))
	}
	$.extend(Frame.prototype, {
		initialize: function(a, b) {
			this.view = a;
			this._position = b;
			this._dimensions = {};
			this.build()
		},
		remove: function() {
			this.clearUITimer();
			if (this._track) {
				J.removeTracking(this._position);
				this._track = false
			}
			this._removeVideo();
			this._reset();
			this.frame.remove();
			this.frame = null;
			if (this.ui) {
				this.ui.remove();
				this.ui = null
			}
			this.view = null;
			this._dimensions = {};
			this.clearLoad()
		},
		build: function() {
			var b = this.view.options.ui,
				positions = H.views.length;
			J.move.append(this.frame = $("<div>").addClass("fr-frame").append(this.box = $("<div>").addClass("fr-box").addClass("fr-box-has-ui-" + b).addClass("fr-box-has-type-" + this.view.type)));
			this.box.append(this.box_spacer = $("<div>").addClass("fr-box-spacer").append(this.box_padder = $("<div>").addClass("fr-box-padder").append(this.box_outer_border = $("<div>").addClass("fr-box-outer-border").append(this.box_wrapper = $("<div>").addClass("fr-box-wrapper")))));
			if (this.view.type == "image" && b != "touch") {
				this.download_image = $("<div>").addClass("fr-download-image")
			}
			this.frame.show();
			var c = this.view.options.onClick;
			if (this.view.type == "image" && ((c == "next" && (this.view.options.loop || (!this.view.options.loop && this._position != H.views.length))) || c == "close")) {
				this.frame.addClass("fr-frame-onclick-" + c.toLowerCase())
			}
			if (b == "outside") {
				this.frame.prepend(this.ui = $("<div>").addClass("fr-ui fr-ui-outside"))
			} else {
				this.frame.append(this.ui = $("<div>").addClass("fr-ui fr-ui-inside"))
			}
			this.box_spacer.bind("click", $.proxy(function(a) {
				if (a.target == this.box_spacer[0] && this.view.options.overlay && this.view.options.overlay.close) {
					H.hide()
				}
			}, this));
			if (this.view.options.ui == "outside") {
				this.ui.append(this.ui_wrapper = $("<div>").addClass("fr-ui-wrapper-outside"))
			} else {
				this.ui.append(this.ui_spacer = $("<div>").addClass("fr-ui-spacer").append(this.ui_padder = $("<div>").addClass("fr-ui-padder").append(this.ui_outer_border = $("<div>").addClass("fr-ui-outer-border").append(this.ui_toggle = $("<div>").addClass("fr-ui-toggle").append(this.ui_wrapper = $("<div>").addClass("fr-ui-wrapper"))))));
				if (this.download_image) {
					this.ui_wrapper.append(this.download_image.clone())
				}
			}
			if (positions > 1) {
				this.ui_wrapper.append(this._next = $("<div>").addClass("fr-side fr-side-next").append(this._next_button = $("<div>").addClass("fr-side-button").append($("<div>").addClass("fr-side-button-icon"))).data("side", "next"));
				if (this._position == positions && !this.view.options.loop) {
					this._next.addClass("fr-side-disabled");
					this._next_button.addClass("fr-side-button-disabled")
				}
				this.ui_wrapper.append(this._previous = $("<div>").addClass("fr-side fr-side-previous").append(this._previous_button = $("<div>").addClass("fr-side-button").append($("<div>").addClass("fr-side-button-icon"))).data("side", "previous"));
				if (this._position == 1 && !this.view.options.loop) {
					this._previous.addClass("fr-side-disabled");
					this._previous_button.addClass("fr-side-button-disabled")
				}
			}
			if (this.download_image && this.view.options.ui == "inside") {
				this.ui_wrapper.find(".fr-side").prepend(this.download_image.clone())
			}
			this.frame.addClass("fr-no-caption");
			if (this.view.caption || (this.view.options.ui == "inside" && !this.view.caption)) {
				this[this.view.options.ui == "inside" ? "ui_wrapper" : "frame"].append(this.info = $("<div>").addClass("fr-info fr-info-" + this.view.options.ui).append(this.info_background = $("<div>").addClass("fr-info-background")).append(this.info_padder = $("<div>").addClass("fr-info-padder")))
			}
			if (this.view.caption) {
				this.frame.removeClass("fr-no-caption").addClass("fr-has-caption");
				this.info_padder.append(this.caption = $("<div>").addClass("fr-caption").html(this.view.caption))
			}
			if (positions > 1 && this.view.options.position) {
				var d = this._position + " / " + positions;
				this.frame.addClass("fr-has-position");
				var b = this.view.options.ui;
				this[b == "inside" ? "info_padder" : "ui_wrapper"][b == "inside" ? "prepend" : "append"](this._pos = $("<div>").addClass("fr-position").append($("<div>").addClass("fr-position-background")).append($("<span>").addClass("fr-position-text").html(d)))
			}
			this.ui_wrapper.append(this.close = $("<div>").addClass("fr-close").bind("click", function() {
				H.hide()
			}).append($("<span>").addClass("fr-close-background")).append($("<span>").addClass("fr-close-icon")));
			if (this.view.type == "image" && this.view.options.onClick == "close") {
				this[this.view.options.ui == "outside" ? "box_wrapper" : "ui_padder"].bind("click", function(a) {
					if ($(a.target).closest(".fr-info")[0]) {
						return
					}
					a.preventDefault();
					a.stopPropagation();
					H.hide()
				})
			}
			this.frame.hide()
		},
		_getInfoHeight: function(a) {
			if (!this.view.caption) {
				return 0
			}
			if (this.view.options.ui == "outside") {
				a = Math.min(a, J._boxDimensions.width)
			}
			var b, info_pw = this.info.css("width");
			this.info.css({
				width: a + "px"
			});
			b = parseFloat(this.info.css("height"));
			this.info.css({
				width: info_pw
			});
			return b
		},
		_whileVisible: function(b, c) {
			var d = [];
			var e = H.element.add(H.bubble).add(this.frame).add(this.ui);
			if (c) {
				e = e.add(c)
			}
			$.each(e, function(i, a) {
				d.push({
					visible: $(a).is(":visible"),
					element: $(a).show()
				})
			});
			b();
			$.each(d, function(i, a) {
				if (!a.visible) {
					a.element.hide()
				}
			})
		},
		getLayout: function() {
			this.updateVars();
			var d = this._dimensions.max,
				ui = this.view.options.ui,
				fit = this._fit,
				i = this._spacing,
				border = this._border;
			var e = C.within(d, {
				fit: fit,
				ui: ui,
				border: border
			});
			var f = $.extend({}, e),
				contentPosition = {
					top: 0,
					left: 0
				};
			if (border) {
				f = C.within(f, {
					bounds: e,
					ui: ui
				});
				e.width += 2 * border;
				e.height += 2 * border
			}
			if (i.horizontal || i.vertical) {
				var g = $.extend({}, J._boxDimensions);
				if (border) {
					g.width -= 2 * border;
					g.height -= 2 * border
				}
				g = {
					width: Math.max(g.width - 2 * i.horizontal, 0),
					height: Math.max(g.height - 2 * i.vertical, 0)
				};
				f = C.within(f, {
					fit: fit,
					bounds: g,
					ui: ui
				})
			}
			var h = {
				caption: true
			},
				cfitted = false;
			if (ui == "outside") {
				var i = {
					height: e.height - f.height,
					width: e.width - f.width
				};
				var j = $.extend({}, f),
					noCaptionClass = this.caption && this.frame.hasClass("fr-no-caption");
				var k;
				if (this.caption) {
					k = this.caption;
					this.info.removeClass("fr-no-caption");
					var l = this.frame.hasClass("fr-no-caption");
					this.frame.removeClass("fr-no-caption");
					var m = this.frame.hasClass("fr-has-caption");
					this.frame.addClass("fr-has-caption")
				}
				H.element.css({
					visibility: "visible"
				});
				this._whileVisible($.proxy(function() {
					var a = 0,
						attempts = 2;
					while ((a < attempts)) {
						h.height = this._getInfoHeight(f.width);
						var b = 0.5 * (J._boxDimensions.height - 2 * border - (i.vertical ? i.vertical * 2 : 0) - f.height);
						if (b < h.height) {
							f = C.within(f, {
								bounds: $.extend({}, {
									width: f.width,
									height: Math.max(f.height - h.height, 0)
								}),
								fit: fit,
								ui: ui
							})
						}
						a++
					}
					h.height = this._getInfoHeight(f.width);
					var c = B.viewport();
					if (((c.height <= 320 && c.width <= 568) || (c.width <= 320 && c.height <= 568)) || (h.height >= 0.5 * f.height) || (h.height >= 0.6 * f.width)) {
						h.caption = false;
						h.height = 0;
						f = j
					}
				}, this), k);
				H.element.css({
					visibility: "visible"
				});
				if (l) {
					this.frame.addClass("fr-no-caption")
				}
				if (m) {
					this.frame.addClass("fr-has-caption")
				}
				var n = {
					height: e.height - f.height,
					width: e.width - f.width
				};
				e.height += (i.height - n.height);
				e.width += (i.width - n.width);
				if (f.height != j.height) {
					cfitted = true
				}
			} else {
				h.height = 0
			}
			var o = {
				width: f.width + 2 * border,
				height: f.height + 2 * border
			};
			if (h.height) {
				e.height += h.height
			}
			if (ui == "inside") {
				h.height = 0
			}
			var p = {
				spacer: {
					dimensions: e
				},
				padder: {
					dimensions: o
				},
				wrapper: {
					dimensions: f,
					bounds: o,
					margin: {
						top: 0.5 * (e.height - o.height) - (0.5 * h.height),
						left: 0.5 * (e.width - o.width)
					}
				},
				content: {
					dimensions: f
				},
				info: h
			};
			if (ui == "outside") {
				p.info.top = p.wrapper.margin.top;
				h.width = Math.min(f.width, J._boxDimensions.width)
			}
			var g = $.extend({}, J._boxDimensions);
			if (ui == "outside") {
				p.box = {
					dimensions: {
						width: J._boxDimensions.width
					},
					position: {
						left: 0.5 * (J._dimensions.width - J._boxDimensions.width)
					}
				}
			}
			p.ui = {
				spacer: {
					dimensions: {
						width: Math.min(e.width, g.width),
						height: Math.min(e.height, g.height)
					}
				},
				padder: {
					dimensions: o
				},
				wrapper: {
					dimensions: {
						width: Math.min(p.wrapper.dimensions.width, g.width - 2 * border),
						height: Math.min(p.wrapper.dimensions.height, g.height - 2 * border)
					},
					margin: {
						top: p.wrapper.margin.top + border,
						left: p.wrapper.margin.left + border
					}
				}
			};
			return p
		},
		updateVars: function() {
			var a = $.extend({}, this._dimensions.max);
			var b = parseInt(this.box_outer_border.css("border-top-width"));
			this._border = b;
			if (b) {
				a.width -= 2 * b;
				a.height -= 2 * b
			}
			var c = this.view.options.fit;
			if (c == "smart") {
				if (a.width > a.height) {
					c = "height"
				} else {
					if (a.height > a.width) {
						c = "width"
					} else {
						c = "none"
					}
				}
			} else {
				if (!c) {
					c = "none"
				}
			}
			this._fit = c;
			var d = {
				none: "both",
				width: "y",
				height: "x",
				both: "none"
			};
			var e = this.view.options.spacing[d[this._fit]];
			this._spacing = e
		},
		clearLoadTimer: function() {
			if (this._loadTimer) {
				clearTimeout(this._loadTimer);
				this._loadTimer = null
			}
		},
		clearLoad: function() {
			if (this._loadTimer && this._loading && !this._loaded) {
				this.clearLoadTimer();
				this._loading = false
			}
		},
		load: function(p, q) {
			if (this._loaded || this._loading) {
				if (this._loaded) {
					this.afterLoad(p)
				}
				return
			}
			if (!q && !(F.cache.get(this.view.url) || F.preloaded.getDimensions(this.view.url))) {
				H.loading.start()
			}
			this._loading = true;
			this._loadTimer = setTimeout($.proxy(function() {
				this.clearLoadTimer();
				switch (this.view.type) {
				case "image":
					var n = this.view.options.ui;
					F.get(this.view.url, {
						dragImage: n != "touch"
					}, $.proxy(function(g, h) {
						if (!this.view) {
							return
						}
						this._dimensions._max = g;
						this._dimensions.max = g;
						this._loaded = true;
						this._loading = false;
						this.updateVars();
						var j = this.getLayout();
						this._dimensions.spacer = j.spacer.dimensions;
						this._dimensions.content = j.content.dimensions;
						this.content = $("<img>").attr({
							src: this.view.url
						}).addClass("fr-content fr-content-image");
						this.box_wrapper.append(this.content);
						if (n == "touch") {
							this.content.bind("dragstart", function(a) {
								a.preventDefault()
							})
						}
						var k;
						this.box_wrapper.append(k = $("<div>").addClass("fr-content-image-overlay"));
						if (this.download_image) {
							k.append(this.download_image.clone())
						}
						var l;
						if (this.view.options.ui == "outside" && ((l = this.view.options.onClick) && l == "next" || l == "previous-next")) {
							var m = this.view.options.loop;
							if ((this._position != J._frames.length) || m) {
								this.box_wrapper.append($("<div>").addClass("fr-onclick-side fr-onclick-next").data("side", "next"))
							}
							if (l == "previous-next" && (this._position != 1 || m)) {
								this.box_wrapper.append($("<div>").addClass("fr-onclick-side fr-onclick-previous").data("side", "previous"))
							}
							if (this.download_image) {
								this.box_wrapper.find(".fr-onclick-side").each($.proxy(function(i, a) {
									var b = $(a).data("side");
									$(a).prepend(this.download_image.clone().data("side", b))
								}, this))
							}
							this.frame.delegate(".fr-onclick-side", "click", function(a) {
								var b = $(a.target).closest(".fr-onclick-side").data("side");
								J[b]()
							});
							this.frame.delegate(".fr-onclick-side", "mouseenter", $.proxy(function(a) {
								var b = $(a.target).closest(".fr-onclick-side").data("side"),
									button = b && this["_" + b + "_button"];
								if (!button) {
									return
								}
								this["_" + b + "_button"].addClass("fr-side-button-active")
							}, this)).delegate(".fr-onclick-side", "mouseleave", $.proxy(function(a) {
								var b = $(a.target).data("side"),
									button = b && this["_" + b + "_button"];
								if (!button) {
									return
								}
								this["_" + b + "_button"].removeClass("fr-side-button-active")
							}, this))
						}
						this.frame.find(".fr-download-image").each($.proxy(function(i, d) {
							var e = $("<img>").addClass("fr-download-image").attr({
								src: this.view.url
							}).css({
								opacity: 0
							}),
								side = $(d).data("side");
							if (u.IE && u.IE < 9) {
								var f = parseInt(H.element.css("z-index")) || 0;
								e.css({
									"z-index": f
								});
								$(d).parents().css({
									"z-index": f
								});
								if (/^(x|both)$/.test(this.view.options.overflow || "")) {
									e.hide()
								}
							}
							if (h.dragImage && !E.mobileTouch) {
								e.add(this.content).bind("dragstart", $.proxy(function(a) {
									if (this.view.options.ui == "touch") {
										a.preventDefault();
										return
									}
									var b = a.originalEvent,
										dt = b.dataTransfer || {};
									if (h.dragImage && dt.setDragImage) {
										var x = b.pageX || 0,
											y = b.pageY || 0;
										var c = this.content.offset();
										x = Math.round(x - c.left);
										y = Math.round(y - c.top);
										if (h.dragScale < 1) {
											x *= h.dragScale;
											y *= h.dragScale
										}
										dt.setDragImage(h.dragImage, x, y)
									} else {
										if (dt.addElement) {
											dt.addElement(this.content[0])
										} else {
											a.preventDefault()
										}
									}
								}, this))
							}
							if (side) {
								e.data("side", side)
							}
							$(d).replaceWith(e)
						}, this));
						this.afterLoad(p, q)
					}, this));
					break;
				case "youtube":
					var o = {
						width: this.view.options.width,
						height: this.view.options.height
					};
					if (this.view.options.youtube && this.view.options.youtube.hd) {
						this.view._data.quality = (o.width > 720) ? "hd1080" : "hd720"
					}
					this._movieLoaded(o, p);
					break;
				case "vimeo":
					var o = {
						width: this.view.options.width,
						height: this.view.options.height
					};
					F.get(this.view.url, $.proxy(function(a, b) {
						if (!this.view) {
							return
						}
						var c = o.width,
							dh = o.height,
							bw = a.width,
							bh = a.height,
							oneDimension = false;
						if ((oneDimension = (c && !dh) || (dh && !c)) || c && dh) {
							if (oneDimension) {
								if (c && !dh) {
									o.height = c * bh / bw
								} else {
									o.width = dh * bw / bh
								}
							}
							o = C.within(a, {
								bounds: o
							})
						} else {
							o = a
						}
						this._movieLoaded(o, p)
					}, this));
					break
				}
			}, this), 10)
		},
		_movieLoaded: function(a, b) {
			this._dimensions._max = a;
			this._dimensions.max = a;
			this._loaded = true;
			this._loading = false;
			this.updateVars();
			var c = this.getLayout();
			this._dimensions.spacer = c.spacer.dimensions;
			this._dimensions.content = c.content.dimensions;
			this.box_wrapper.append(this.content = $("<div>").addClass("fr-content fr-content-" + this.view.type));
			if (this.view.options.ui == "touch" && (this.view.type == "youtube" || this.view.type == "vimeo")) {
				this.resize();
				if ((this.view.type == "youtube" && !! window.YT) || (this.view.type == "vimeo" && E.postMessage)) {
					this.show()
				}
			}
			this.afterLoad(b)
		},
		afterLoad: function(a) {
			var b = this.view.options.ui;
			this.resize();
			if (b == "inside") {
				this.ui_outer_border.bind("mouseenter", $.proxy(this.showUI, this)).bind("mouseleave", $.proxy(this.hideUI, this))
			}
			if (this.ui) {
				if (!E.mobileTouch) {
					this.ui.delegate(".fr-ui-padder", "mousemove", $.proxy(function() {
						if (!this.ui_wrapper.is(":visible")) {
							this.showUI()
						}
						this.startUITimer()
					}, this))
				} else {
					this.box.bind("click", $.proxy(function() {
						if (!this.ui_wrapper.is(":visible")) {
							this.showUI()
						}
						this.startUITimer()
					}, this))
				}
			}
			var c;
			if (J._frames && (c = J._frames[J._position - 1]) && (c.view.url == this.view.url || c.view.options.ui == "touch")) {
				H.loading.stop()
			}
			if (a) {
				a()
			}
		},
		resize: function() {
			if (this.content) {
				var a = this.getLayout();
				var b = this.view.options.ui;
				this._dimensions.spacer = a.spacer.dimensions;
				this._dimensions.content = a.content.dimensions;
				this.box_spacer.css(px(a.spacer.dimensions));
				if (b == "inside") {
					this.ui_spacer.css(px(a.ui.spacer.dimensions))
				}
				this.box_wrapper.add(this.box_outer_border).css(px(a.wrapper.dimensions));
				var c = 0;
				if (this.view.options.ui == "outside" && a.info.caption) {
					c = a.info.height
				}
				this.box_outer_border.css({
					"padding-bottom": c + "px"
				});
				this.box_padder.css(px({
					width: a.padder.dimensions.width,
					height: a.padder.dimensions.height + c
				}));
				if (a.spacer.dimensions.width > (this.view.options.ui == "outside" ? a.box.dimensions.width : B.viewport().width)) {
					this.box.addClass("fr-prevent-swipe")
				} else {
					this.box.removeClass("fr-prevent-swipe")
				}
				switch (b) {
				case "outside":
					if (this.caption) {
						this.info.css(px({
							width: a.info.width
						}))
					}
					break;
				case "inside":
					this.ui_wrapper.add(this.ui_outer_border).add(this.ui_toggle).css(px(a.ui.wrapper.dimensions));
					this.ui_padder.css(px(a.ui.padder.dimensions));
					var d = 0;
					if (this.caption) {
						var e = this.frame.hasClass("fr-no-caption"),
							has_hascap = this.frame.hasClass("fr-has-caption");
						this.frame.removeClass("fr-no-caption");
						this.frame.addClass("fr-has-caption");
						var d = 0;
						this._whileVisible($.proxy(function() {
							d = this.info.outerHeight()
						}, this), this.ui_wrapper.add(this.caption));
						var f = B.viewport();
						if (d >= 0.45 * a.wrapper.dimensions.height || ((f.height <= 320 && f.width <= 568) || (f.width <= 320 && f.height <= 568))) {
							a.info.caption = false
						}
						if (e) {
							this.frame.addClass("fr-no-caption")
						}
						if (!has_hascap) {
							this.frame.removeClass("fr-has-caption")
						}
					}
					break
				}
				if (this.caption) {
					var g = a.info.caption;
					this.caption[g ? "show" : "hide"]();
					this.frame[(!g ? "add" : "remove") + "Class"]("fr-no-caption");
					this.frame[(!g ? "remove" : "add") + "Class"]("fr-has-caption")
				}
				this.box_padder.add(this.ui_padder).css(px(a.wrapper.margin));
				var h = J._boxDimensions,
					spacer_dimensions = this._dimensions.spacer;
				this.overlap = {
					y: spacer_dimensions.height - h.height,
					x: spacer_dimensions.width - h.width
				};
				this._track = this.view.options.overflow != "none" && (this.overlap.x > 0 || this.overlap.y > 0);
				J[(this._track ? "set" : "remove") + "Tracking"](this._position);
				if (u.IE && u.IE < 8 && this.view.type == "image") {
					this.content.css(px(a.wrapper.dimensions))
				}
				if (/^(vimeo|youtube)$/.test(this.view.type)) {
					var i = a.wrapper.dimensions;
					if (this.player) {
						this.player.setSize(i.width, i.height)
					} else {
						if (this.player_iframe) {
							this.player_iframe.attr(i)
						}
					}
				}
			}
			this.position()
		},
		position: function() {
			if (!this.content) {
				return
			}
			var a = J._xyp;
			var b = J._boxDimensions,
				spacer_dimensions = this._dimensions.spacer;
			var c = {
				top: 0,
				left: 0
			};
			var d = this.overlap;
			if (d.y > 0) {
				c.top = 0 - a.y * d.y
			} else {
				c.top = b.height * 0.5 - spacer_dimensions.height * 0.5
			}
			if (d.x > 0) {
				c.left = 0 - a.x * d.x
			} else {
				c.left = b.width * 0.5 - spacer_dimensions.width * 0.5
			}
			if (E.mobileTouch) {
				if (d.y > 0) {
					c.top = 0
				}
				if (d.x > 0) {
					c.left = 0
				}
				this.box_spacer.css({
					position: "relative"
				})
			}
			this._style = c;
			this.box_spacer.css({
				top: c.top + "px",
				left: c.left + "px"
			});
			var e = $.extend({}, c);
			if (e.top < 0) {
				e.top = 0
			}
			if (e.left < 0) {
				e.left = 0
			}
			var f = this.view.options.ui;
			switch (f) {
			case "outside":
				var g = this.getLayout();
				this.box.css(px(g.box.dimensions)).css(px(g.box.position));
				if (this.view.caption) {
					var h = c.top + g.wrapper.margin.top + g.wrapper.dimensions.height + this._border;
					if (h > J._boxDimensions.height - g.info.height) {
						h = J._boxDimensions.height - g.info.height
					}
					var i = J._sideWidth + c.left + g.wrapper.margin.left + this._border;
					if (i < J._sideWidth) {
						i = J._sideWidth
					}
					if (i + g.info.width > J._sideWidth + g.box.dimensions.width) {
						i = J._sideWidth
					}
					this.info.css({
						top: h + "px",
						left: i + "px"
					})
				}
				break;
			case "inside":
				this.ui_spacer.css({
					left: e.left + "px",
					top: e.top + "px"
				});
				break
			}
		},
		setDimensions: function(a) {
			this.dimensions = a
		},
		insertYoutubeVideo: function() {
			var a = u.IE && u.IE < 8,
				layout = this.getLayout(),
				lwd = layout.wrapper.dimensions;
			var b = $.extend({}, this.view.options.youtube || {});
			var c = "http" + (window.location && window.location.protocol == "https:" ? "s" : "") + ":";
			var d = $.param(b);
			this.content.append(this.player_iframe = $("<iframe webkitAllowFullScreen mozallowfullscreen allowFullScreen>").attr({
				src: c + "//www.youtube.com/embed/" + this.view._data.id + "?" + d,
				height: lwd.height,
				width: lwd.width,
				frameborder: 0
			}))
		},
		insertVimeoVideo: function() {
			var a = this.getLayout(),
				lwd = a.wrapper.dimensions;
			var b = $.extend({}, this.view.options.vimeo || {});
			if (this.view.options.ui == "touch") {
				b.autoplay = 0
			}
			var c = "http" + (window.location && window.location.protocol == "https:" ? "s" : "") + ":";
			var d = w() + "vimeo";
			b.player_id = d;
			b.api = 1;
			var e = $.param(b);
			this.content.append(this.player_iframe = $("<iframe webkitAllowFullScreen mozallowfullscreen allowFullScreen>").attr({
				src: c + "//player.vimeo.com/video/" + this.view._data.id + "?" + e,
				id: d,
				height: lwd.height,
				width: lwd.width,
				frameborder: 0
			}))
		},
		_preShow: function() {
			switch (this.view.type) {
			case "youtube":
				this.insertYoutubeVideo();
				break;
			case "vimeo":
				this.insertVimeoVideo();
				break
			}
		},
		show: function(a) {
			if (this.view.options.ui == "touch") {
				if (this._shown) {
					if (a) {
						a()
					}
					return
				}
				this._shown = true
			}
			this._preShow();
			J.setVisible(this._position);
			this.frame.stop(1, 0);
			if (this.ui) {
				this.ui.stop(1, 0);
				this.showUI(null, true)
			}
			if (this._track) {
				J.setTracking(this._position)
			}
			this.setOpacity(1, Math.max(this.view.options.effects.content.show, u.IE && u.IE < 9 ? 0 : 10), $.proxy(function() {
				if (a) {
					a()
				}
			}, this))
		},
		_postHide: function(a) {
			if (!this.view || !this.content) {
				return
			}
			if (this.view.options.ui == "touch") {
				return
			}
			this._removeVideo()
		},
		_removeVideo: function() {
			this._playing = false;
			if (this.player_iframe) {
				this.player_iframe[0].src = "//about:blank";
				this.player_iframe.remove();
				this.player_iframe = null
			}
			if (this.view.type == "youtube" || this.view.type == "vimeo") {
				if (this.content) {
					this.content.html("")
				}
			}
		},
		_reset: function(a) {
			J.removeTracking(this._position);
			J.setHidden(this._position);
			this._postHide(a)
		},
		hide: function(a) {
			if (this.view.options.ui == "touch") {
				if (a) {
					a()
				}
				return
			}
			var b = Math.max(this.view.options.effects.content.hide || 0, u.IE && u.IE < 9 ? 0 : 10);
			var c = this.view.options.effects.content.sync ? "easeInQuad" : "easeOutSine";
			this.frame.stop(1, 0).fadeOut(b, c, $.proxy(function() {
				this._reset();
				if (a) {
					a()
				}
			}, this))
		},
		setOpacity: function(a, b, c) {
			var d = this.view.options.effects.content.sync ? "easeOutQuart" : "easeInSine";
			this.frame.stop(1, 0).fadeTo(b || 0, a, d, c)
		},
		showUI: function(a, b) {
			if (!this.ui) {
				return
			}
			if (!b) {
				this.ui_wrapper.stop(1, 0).fadeTo(b ? 0 : this.view.options.effects.ui.show, 1, "easeInSine", $.proxy(function() {
					this.startUITimer();
					if ($.type(a) == "function") {
						a()
					}
				}, this))
			} else {
				this.ui_wrapper.show();
				this.startUITimer();
				if ($.type(a) == "function") {
					a()
				}
			}
		},
		hideUI: function(a, b) {
			if (!this.ui || this.view.options.ui == "outside") {
				return
			}
			if (!b) {
				this.ui_wrapper.stop(1, 0).fadeOut(b ? 0 : this.view.options.effects.ui.hide, "easeOutSine", function() {
					if ($.type(a) == "function") {
						a()
					}
				})
			} else {
				this.ui_wrapper.hide();
				if ($.type(a) == "function") {
					a()
				}
			}
		},
		clearUITimer: function() {
			if (this._ui_timer) {
				clearTimeout(this._ui_timer);
				this._ui_timer = null
			}
		},
		startUITimer: function() {
			this.clearUITimer();
			this._ui_timer = setTimeout($.proxy(function() {
				this.hideUI()
			}, this), this.view.options.effects.ui.delay)
		},
		hideUIDelayed: function() {
			this.clearUITimer();
			this._ui_timer = setTimeout($.proxy(function() {
				this.hideUI()
			}, this), this.view.options.effects.ui.delay)
		}
	});
	function View() {
		this.initialize.apply(this, v.call(arguments))
	}
	$.extend(View.prototype, {
		initialize: function(a) {
			var b = arguments[1] || {};
			var c = {};
			if ($.type(a) == "string") {
				a = {
					url: a
				}
			} else {
				if (a && a.nodeType == 1) {
					var d = $(a);
					a = {
						element: d[0],
						url: d.attr("href"),
						caption: d.data("fresco-caption"),
						group: d.data("fresco-group"),
						extension: d.data("fresco-extension"),
						type: d.data("fresco-type"),
						options: (d.data("fresco-options") && eval("({" + d.data("fresco-options") + "})")) || {}
					}
				}
			}
			if (a) {
				if (!a.extension) {
					a.extension = detectExtension(a.url)
				}
				if (!a.type) {
					var c = getURIData(a.url);
					a._data = c;
					a.type = c.type
				}
			}
			if (!a._data) {
				a._data = getURIData(a.url)
			}
			if (a && a.options) {
				a.options = $.extend(true, $.extend({}, b), $.extend({}, a.options))
			} else {
				a.options = $.extend({}, b)
			}
			a.options = G.create(a.options, a.type, a._data);
			$.extend(this, a);
			return this
		}
	});
	var K = {
		initialize: function(a) {
			this.element = a;
			this._thumbnails = [];
			this._vars = {
				orientation: "horizontal",
				thumbnail: {
					height: 0,
					width: 0
				},
				thumbnail_frame: {
					height: 0,
					width: 0
				},
				thumbnails: {
					height: 0,
					width: 0
				}
			};
			this.thumbnails = this.element.find(".fr-thumbnails:first");
			this.build();
			this.block();
			this.hide();
			this.startObserving()
		},
		build: function() {
			this.thumbnails.append(this.wrapper = $("<div>").addClass("fr-thumbnails-wrapper").append(this._slider = $("<div>").addClass("fr-thumbnails-slider").append(this._previous = $("<div>").addClass("fr-thumbnails-side fr-thumbnails-side-previous").append(this._previous_button = $("<div>").addClass("fr-thumbnails-side-button").append($("<div>").addClass("fr-thumbnails-side-button-background")).append($("<div>").addClass("fr-thumbnails-side-button-icon")))).append(this._thumbs = $("<div>").addClass("fr-thumbnails-thumbs").append(this._slide = $("<div>").addClass("fr-thumbnails-slide"))).append(this._next = $("<div>").addClass("fr-thumbnails-side fr-thumbnails-side-next").append(this._next_button = $("<div>").addClass("fr-thumbnails-side-button").append($("<div>").addClass("fr-thumbnails-side-button-background")).append($("<div>").addClass("fr-thumbnails-side-button-icon"))))));
			this.measure = $("<div>").addClass("fr-thumbnails fr-thumbnails-horizontal").append($("<div>").addClass("fr-thumbnails-side fr-thumbnails-side-previous")).append($("<div>").addClass("fr-thumbnail")).append($("<div>").addClass("fr-thumbnails-side fr-thumbnails-side-next"))
		},
		startObserving: function() {
			this._slider.delegate(".fr-thumbnail", "click", $.proxy(function(a) {
				a.stopPropagation();
				var b = $(a.target).closest(".fr-thumbnail")[0];
				var c = b && $(b).data("fr-position");
				if (c) {
					this.setActive(c);
					H.setPosition(c)
				}
			}, this));
			this._slider.bind("click", function(a) {
				a.stopPropagation()
			});
			this._previous.bind("click", $.proxy(this.previousPage, this));
			this._next.bind("click", $.proxy(this.nextPage, this))
		},
		load: function(b) {
			this.clear();
			this._thumbnails = [];
			if (b.length < 2) {
				return
			}
			var c = false;
			$.each(b, $.proxy(function(i, a) {
				if (a.options.ui == "touch") {
					c = true;
					return false
				}
			}, this));
			if (c) {
				return
			}
			var d = "horizontal";
			$.each(b, $.proxy(function(i, a) {
				if (a.options.thumbnails == "vertical") {
					d = "vertical"
				}
			}, this));
			this._vars.orientation = d;
			this.setOrientationClass(d);
			$.each(b, $.proxy(function(i, a) {
				this._thumbnails.push(new Thumbnail(this._slide, a, i + 1))
			}, this));
			if (!(u.IE && u.IE < 7)) {
				this.resize()
			}
		},
		clear: function() {
			$.each(this._thumbnails, function(i, a) {
				a.remove()
			});
			this._thumbnails = [];
			this._position = -1;
			this._page = -1
		},
		setOrientationClass: function(a) {
			this.thumbnails.removeClass("fr-thumbnails-horizontal fr-thumbnails-vertical").addClass("fr-thumbnails-" + a)
		},
		flipMargins: function(b) {
			$.each(b, $.proxy(function(i, a) {
				this.flipMargin(a)
			}, this))
		},
		flipMargin: function(a) {
			var b = a["margin-left"],
				right = a["margin-right"];
			a["margin-left"] = 0;
			a["margin-right"] = 0;
			a["margin-top"] = b;
			a["margin-bottom"] = right
		},
		flipDimensions: function(a) {
			var b = a.width;
			a.width = a.height;
			a.height = b
		},
		flipMultiple: function(b) {
			$.each(b, $.proxy(function(i, a) {
				this.flipDimensions(a)
			}, this))
		},
		updateVars: function() {
			var a = H.element,
				bubble = H.bubble,
				vars = this._vars,
				orientation = vars.orientation,
				viewport = B.viewport();
			var b = a.is(":visible");
			if (!b) {
				a.show()
			}
			var c = bubble.is(":visible");
			if (!c) {
				bubble.show()
			}
			this.thumbnails.before(this.measure);
			var d = this.measure.find(".fr-thumbnails-side-previous:first"),
				next = this.measure.find(".fr-thumbnails-side-next:first"),
				thumbnail = this.measure.find(".fr-thumbnail:first");
			var e = this.measure.innerHeight(),
				padding = parseInt(this.measure.css("padding-top")) || 0;
			$.extend(vars.thumbnails, {
				height: e,
				padding: padding
			});
			var f = e - (2 * padding),
				margin = parseInt(thumbnail.css("margin-left"));
			$.extend(vars.thumbnail, {
				height: f,
				width: f
			});
			$.extend(vars.thumbnail_frame, {
				width: f + (margin * 2),
				height: e
			});
			vars.sides = {
				previous: {
					dimensions: {
						width: d.innerWidth(),
						height: e
					},
					margin: {
						"margin-top": 0,
						"margin-bottom": 0,
						"margin-left": (parseInt(d.css("margin-left")) || 0),
						"margin-right": (parseInt(d.css("margin-right")) || 0)
					}
				},
				next: {
					dimensions: {
						width: next.innerWidth(),
						height: e
					},
					margin: {
						"margin-top": 0,
						"margin-bottom": 0,
						"margin-left": (parseInt(next.css("margin-left")) || 0),
						"margin-right": (parseInt(next.css("margin-right")) || 0)
					}
				}
			};
			var g = viewport[orientation == "horizontal" ? "width" : "height"],
				thumbnail_outerZ = vars.thumbnail_frame.width,
				thumbs = this._thumbnails.length;
			vars.thumbnails.width = g;
			vars.sides.enabled = (thumbs * thumbnail_outerZ) / g > 1;
			var h = g,
				vs = vars.sides,
				vs_previous = vs.previous,
				vs_next = vs.next,
				sides_width = vs_previous.margin["margin-left"] + vs_previous.dimensions.width + vs_previous.margin["margin-right"] + vs_next.margin["margin-left"] + vs_next.dimensions.width + vs_next.margin["margin-right"];
			if (vars.sides.enabled) {
				h -= sides_width
			}
			h = Math.floor(h / thumbnail_outerZ) * thumbnail_outerZ;
			var i = thumbs * thumbnail_outerZ;
			if (i < h) {
				h = i
			}
			var j = h + (vars.sides.enabled ? sides_width : 0);
			vars.ipp = h / thumbnail_outerZ;
			this._mode = "page";
			if (vars.ipp <= 1) {
				h = g;
				j = g;
				vars.sides.enabled = false;
				this._mode = "center"
			}
			vars.pages = Math.ceil((thumbs * thumbnail_outerZ) / h);
			vars.wrapper = {
				width: j + 1,
				height: e
			};
			vars.thumbs = {
				width: h,
				height: e
			};
			vars.slide = {
				width: (thumbs * thumbnail_outerZ) + 1,
				height: e
			};
			if (orientation == "vertical") {
				this.flipMultiple([vars.thumbnails, vars.wrapper, vars.thumbs, vars.slide, vars.thumbnail_frame, vars.thumbnail, vars.sides.previous.dimensions, vars.sides.next.dimensions]);
				this.flipMargins([vars.sides.previous.margin, vars.sides.next.margin])
			}
			this.measure.detach();
			if (!c) {
				bubble.hide()
			}
			if (!b) {
				a.hide()
			}
		},
		disable: function() {
			this._disabled = true
		},
		enable: function() {
			this._disabled = false
		},
		enabled: function() {
			return !this._disabled
		},
		show: function() {
			if (this._thumbnails.length < 2) {
				return
			}
			this.enable();
			this.thumbnails.show();
			this._visible = true
		},
		hide: function() {
			this.disable();
			this.thumbnails.hide();
			this._visible = false
		},
		visible: function() {
			return !!this._visible
		},
		resize: function() {
			this.updateVars();
			var b = this._vars,
				isHorizontal = this._vars.orientation == "horizontal";
			var c = b.thumbnails;
			this.thumbnails.css({
				width: c.width + "px",
				height: c.height + "px",
				"min-height": "none",
				"max-height": "none",
				"min-width": "none",
				"max-width": "none",
				padding: 0
			});
			$.each(this._thumbnails, function(i, a) {
				a.resize()
			});
			this._previous[b.sides.enabled ? "show" : "hide"]().css(px(b.sides.previous.dimensions)).css(px(b.sides.previous.margin));
			this._next[b.sides.enabled ? "show" : "hide"]().css(px(b.sides.next.dimensions)).css(px(b.sides.next.margin));
			if (u.IE && u.IE < 9) {
				H.timeouts.clear("ie-resizing-thumbnails");
				H.timeouts.set("ie-resizing-thumbnails", $.proxy(function() {
					this.updateVars();
					this._thumbs.css(px(b.thumbs));
					this._slide.css(px(b.slide))
				}, this), 500)
			}
			this._thumbs.css(px(b.thumbs));
			this._slide.css(px(b.slide));
			var d = $.extend({}, px(b.wrapper));
			d["margin-" + (isHorizontal ? "left" : "top")] = Math.round(-0.5 * b.wrapper[isHorizontal ? "width" : "height"]) + "px";
			d["margin-" + (!isHorizontal ? "left" : "top")] = 0;
			this.wrapper.css(d);
			if (this._position) {
				this.moveTo(this._position, true)
			}
		},
		moveToPage: function(a) {
			if (a < 1 || a > this._vars.pages || a == this._page) {
				return
			}
			var b = this._vars.ipp * (a - 1) + 1;
			this.moveTo(b)
		},
		previousPage: function() {
			this.moveToPage(this._page - 1)
		},
		nextPage: function() {
			this.moveToPage(this._page + 1)
		},
		adjustToViewport: function() {
			var a = B.viewport();
			return a
		},
		setPosition: function(a) {
			if (u.IE && u.IE < 7) {
				return
			}
			var b = this._position < 0;
			if (a < 1) {
				a = 1
			}
			var c = this._thumbnails.length;
			if (a > c) {
				a = c
			}
			this._position = a;
			this.setActive(a);
			if (this._mode == "page" && this._page == Math.ceil(a / this._vars.ipp)) {
				return
			}
			this.moveTo(a, b)
		},
		moveTo: function(a, b) {
			this.updateVars();
			var c, isHorizontal = this._vars.orientation == "horizontal",
				vp_z = B.viewport()[isHorizontal ? "width" : "height"],
				vp_center = vp_z * 0.5,
				t_width = this._vars.thumbnail_frame[isHorizontal ? "width" : "height"];
			if (this._mode == "page") {
				var d = Math.ceil(a / this._vars.ipp);
				this._page = d;
				c = -1 * (t_width * (this._page - 1) * this._vars.ipp);
				var e = "fr-thumbnails-side-button-disabled";
				this._previous_button[(d < 2 ? "add" : "remove") + "Class"](e);
				this._next_button[(d >= this._vars.pages ? "add" : "remove") + "Class"](e)
			} else {
				c = vp_center + (-1 * (t_width * (a - 1) + t_width * 0.5))
			}
			var f = J._frames && J._frames[J._position - 1];
			var g = {},
				animateCSS = {};
			g[!isHorizontal ? "left" : "top"] = 0;
			animateCSS[isHorizontal ? "left" : "top"] = c + "px";
			this._slide.stop(1, 0).css(g).animate(animateCSS, b ? 0 : (f ? f.view.options.effects.thumbnails.slide : 0), $.proxy(function() {
				this.loadCurrentPage()
			}, this))
		},
		block: function() {
			this._blocked = true
		},
		unblock: function() {
			this._blocked = false;
			if (this._thumbnails.length > 0) {
				this.loadCurrentPage()
			}
		},
		loadCurrentPage: function() {
			var a = false;
			if (this._blocked) {
				a = true
			}
			var b, max;
			if (!this._position || !this._vars.thumbnail_frame.width || this._thumbnails.length < 1) {
				return
			}
			if (this._mode == "page") {
				if (this._page < 1) {
					return
				}
				b = (this._page - 1) * this._vars.ipp + 1;
				max = Math.min((b - 1) + this._vars.ipp, this._thumbnails.length)
			} else {
				var c = this._vars.orientation == "horizontal";
				var d = Math.ceil(this._vars.thumbnails[c ? "width" : "height"] / this._vars.thumbnail_frame[c ? "width" : "height"]);
				b = Math.max(Math.floor(Math.max(this._position - d * 0.5, 0)), 1);
				max = Math.ceil(Math.min(this._position + d * 0.5));
				if (this._thumbnails.length < max) {
					max = this._thumbnails.length
				}
			}
			for (var i = b; i <= max; i++) {
				this._thumbnails[i - 1][a ? "build" : "load"]()
			}
		},
		setActive: function(a) {
			this._slide.find(".fr-thumbnail-active").removeClass("fr-thumbnail-active");
			var b = a && this._thumbnails[a - 1];
			if (b) {
				b.activate()
			}
		},
		refresh: function() {
			if (this._position) {
				this.setPosition(this._position)
			}
		}
	};
	function Thumbnail() {
		this.initialize.apply(this, v.call(arguments))
	}
	$.extend(Thumbnail.prototype, {
		initialize: function(a, b, c) {
			this.element = a;
			this.view = b;
			this._dimension = {};
			this._position = c;
			this.preBuild()
		},
		preBuild: function() {
			this.thumbnail = $("<div>").addClass("fr-thumbnail").data("fr-position", this._position)
		},
		build: function() {
			if (this.thumbnail_frame) {
				return
			}
			var a = this.view.options;
			this.element.append(this.thumbnail_frame = $("<div>").addClass("fr-thumbnail-frame").append(this.thumbnail.append(this.thumbnail_wrapper = $("<div>").addClass("fr-thumbnail-wrapper"))));
			if (this.view.type == "image") {
				this.thumbnail.addClass("fr-load-thumbnail").data("thumbnail", {
					view: this.view,
					src: a.thumbnail || this.view.url
				})
			}
			var b = a.thumbnail && a.thumbnail.icon;
			if (b) {
				this.thumbnail.append($("<div>").addClass("fr-thumbnail-icon fr-thumbnail-icon-" + b))
			}
			var c;
			this.thumbnail.append(c = $("<div>").addClass("fr-thumbnail-overlay").append($("<div>").addClass("fr-thumbnail-overlay-background")).append(this.loading = $("<div>").addClass("fr-thumbnail-loading").append($("<div>").addClass("fr-thumbnail-loading-background")).append($("<div>").addClass("fr-thumbnail-loading-icon"))).append($("<div>").addClass("fr-thumbnail-overlay-border")));
			this.thumbnail.append($("<div>").addClass("fr-thumbnail-state"));
			this.resize()
		},
		remove: function() {
			if (this.thumbnail_frame) {
				this.thumbnail_frame.remove();
				this.thumbnail_frame = null;
				this.thumbnail_image = null
			}
			this._loading = false;
			this._removed = true
		},
		load: function() {
			if (this._loaded || this._loading || !K.visible() || this._removed) {
				return
			}
			if (!this.thumbnail_wrapper) {
				this.build()
			}
			this._loading = true;
			var b = this.view.options.thumbnail;
			var c = (b && $.type(b) == "boolean") ? this.view.url : b || this.view.url;
			this._url = c;
			if (c) {
				if (this.view.type == "vimeo") {
					if (c == b) {
						F.preload(this._url, {
							type: "image"
						}, $.proxy(this._afterLoad, this))
					} else {
						var d = "http" + (window.location && window.location.protocol == "https:" ? "s" : "") + ":";
						$.getJSON(d + "//vimeo.com/api/oembed.json?url=" + d + "//vimeo.com/" + this.view._data.id + "&callback=?", $.proxy(function(a) {
							if (a && a.thumbnail_url) {
								this._url = a.thumbnail_url;
								F.preload(this._url, {
									type: "image"
								}, $.proxy(this._afterLoad, this))
							} else {
								this._loaded = true;
								this._loading = false;
								this.loading.stop(1, 0).delay(this.view.options.effects.thumbnails.delay).fadeTo(this.view.options.effects.thumbnails.load, 0)
							}
						}, this))
					}
				} else {
					F.preload(this._url, {
						type: "image"
					}, $.proxy(this._afterLoad, this))
				}
			}
		},
		_afterLoad: function(a, b) {
			if (!this.thumbnail_frame || !this._loading) {
				return
			}
			this._loaded = true;
			this._loading = false;
			this._dimensions = a;
			this.image = $("<img>").attr({
				src: this._url
			});
			this.thumbnail_wrapper.prepend(this.image);
			this.resize();
			this.loading.stop(1, 0).delay(this.view.options.effects.thumbnails.delay).fadeTo(this.view.options.effects.thumbnails.load, 0)
		},
		resize: function() {
			if (!this.thumbnail_frame) {
				return
			}
			this.thumbnail_frame.css(px(K._vars.thumbnail_frame));
			var a = K._vars.orientation == "horizontal";
			this.thumbnail_frame.css(px({
				top: a ? 0 : K._vars.thumbnail_frame.height * (this._position - 1),
				left: a ? K._vars.thumbnail_frame.width * (this._position - 1) : 0
			}));
			if (!this.thumbnail_wrapper) {
				return
			}
			var b = K._vars.thumbnail;
			this.thumbnail.css(px({
				width: b.width,
				height: b.height,
				"margin-top": Math.round(-0.5 * b.height),
				"margin-left": Math.round(-0.5 * b.width),
				"margin-bottom": 0,
				"margin-right": 0
			}));
			if (!this.image) {
				return
			}
			var c = {
				width: b.width,
				height: b.height
			};
			var d = Math.max(c.width, c.height);
			var e;
			var f = $.extend({}, this._dimensions);
			if (f.width > c.width && f.height > c.height) {
				e = C.within(f, {
					bounds: c
				});
				var g = 1,
					scaleY = 1;
				if (e.width < c.width) {
					g = c.width / e.width
				}
				if (e.height < c.height) {
					scaleY = c.height / e.height
				}
				var h = Math.max(g, scaleY);
				if (h > 1) {
					e.width *= h;
					e.height *= h
				}
				$.each("width height".split(" "), function(i, z) {
					e[z] = Math.round(e[z])
				})
			} else {
				e = C.within((f.width < c.width || f.height < c.height) ? {
					width: d,
					height: d
				} : c, {
					bounds: this._dimensions
				})
			}
			var x = Math.round(c.width * 0.5 - e.width * 0.5),
				y = Math.round(c.height * 0.5 - e.height * 0.5);
			this.image.css(px($.extend({}, e, {
				top: y,
				left: x
			})))
		},
		activate: function() {
			this.thumbnail.addClass("fr-thumbnail-active")
		}
	});
	var L = {
		_disabled: false,
		_fallback: true,
		initialize: function() {
			H.initialize()
		},
		show: function(c) {
			if (this._disabled) {
				this.showFallback.apply(L, v.call(arguments));
				return
			}
			var d = arguments[1] || {},
				position = arguments[2];
			if (arguments[1] && $.type(arguments[1]) == "number") {
				position = arguments[1];
				d = {}
			}
			var e = [],
				object_type;
			switch ((object_type = $.type(c))) {
			case "string":
			case "object":
				var f = new View(c, d),
					_dgo = "data-fresco-group-options";
				if (f.group) {
					if (_.isElement(c)) {
						var g = $('.fresco[data-fresco-group="' + $(c).data("fresco-group") + '"]');
						var h = {};
						g.filter("[" + _dgo + "]").each(function(i, a) {
							$.extend(h, eval("({" + ($(a).attr(_dgo) || "") + "})"))
						});
						g.each(function(i, a) {
							if (!position && a == c) {
								position = i + 1
							}
							e.push(new View(a, $.extend({}, h, d)))
						})
					}
				} else {
					var h = {};
					if (_.isElement(c) && $(c).is("[" + _dgo + "]")) {
						$.extend(h, eval("({" + ($(c).attr(_dgo) || "") + "})"));
						f = new View(c, $.extend({}, h, d))
					}
					e.push(f)
				}
				break;
			case "array":
				$.each(c, function(i, a) {
					var b = new View(a, d);
					e.push(b)
				});
				break
			}
			if (!position || position < 1) {
				position = 1
			}
			if (position > e.length) {
				position = e.length
			}
			if (!J._xyp) {
				J.setXY({
					x: 0,
					y: 0
				})
			}
			H.load(e, position, {
				callback: function() {
					H.show(function() {})
				}
			})
		},
		showFallback: (function() {
			function getUrl(a) {
				var b, type = $.type(a);
				if (type == "string") {
					b = a
				} else {
					if (type == "array" && a[0]) {
						b = getUrl(a[0])
					} else {
						if (_.isElement(a) && $(a).attr("href")) {
							var b = $(a).attr("href")
						} else {
							if (a.url) {
								b = a.url
							} else {
								b = false
							}
						}
					}
				}
				return b
			}
			return function(a) {
				if (!this._fallback) {
					return
				}
				var b = getUrl(a);
				if (b) {
					window.location.href = b
				}
			}
		})()
	};
	$.extend(t, {
		show: function(a) {
			L.show.apply(L, v.call(arguments));
			return this
		},
		hide: function() {
			H.hide();
			return this
		},
		disable: function() {
			L._disabled = true;
			return this
		},
		enable: function() {
			L._disabled = false;
			return this
		},
		fallback: function(a) {
			L._fallback = a;
			return this
		},
		setDefaultSkin: function(a) {
			H.setDefaultSkin(a);
			return this
		}
	});
	if (($.type(u.Android) == "number" && u.Android < 3) || (u.MobileSafari && ($.type(u.WebKit) == "number" && u.WebKit < 533.18))) {
		t.show = L.showFallback
	}
	
	function getURIData(c) {
		var d = {
			type: "image"
		};
		$.each(N, function(i, a) {
			var b = a.data(c);
			if (b) {
				d = b;
				d.type = i;
				d.url = c
			}
		});
		return d
	}
	function detectExtension(a) {
		var b = (a || "").replace(/\?.*/g, "").match(/\.([^.]{3,4})$/);
		return b ? b[1].toLowerCase() : null
	}
	var N = {
		image: {
			extensions: "bmp gif jpeg jpg png",
			detect: function(a) {
				return $.inArray(detectExtension(a), this.extensions.split(" ")) > -1
			},
			data: function(a) {
				if (!this.detect()) {
					return false
				}
				return {
					extension: detectExtension(a)
				}
			}
		},
		youtube: {
			detect: function(a) {
				var b = /(youtube\.com|youtu\.be)\/watch\?(?=.*vi?=([a-zA-Z0-9-_]+))(?:\S+)?$/.exec(a);
				if (b && b[2]) {
					return b[2]
				}
				b = /(youtube\.com|youtu\.be)\/(vi?\/|u\/|embed\/)?([a-zA-Z0-9-_]+)(?:\S+)?$/i.exec(a);
				if (b && b[3]) {
					return b[3]
				}
				return false
			},
			data: function(a) {
				var b = this.detect(a);
				if (!b) {
					return false
				}
				return {
					id: b
				}
			}
		},
		vimeo: {
			detect: function(a) {
				var b = /(vimeo\.com)\/([a-zA-Z0-9-_]+)(?:\S+)?$/i.exec(a);
				if (b && b[2]) {
					return b[2]
				}
				return false
			},
			data: function(a) {
				var b = this.detect(a);
				if (!b) {
					return false
				}
				return {
					id: b
				}
			}
		}
	};
	$(document).ready(function(a) {
		L.initialize()
	});
	return t
}));
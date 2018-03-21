/*
Script: 	
	JVEqualHeight - Equal elements height.

License:
	Proprietary - PHPKungfu Club members only

Copyright:
	Copyright (C) PHPKungfu. All rights reserved.
*/




var JVEqualHeight = function(selectors){
	var maxHeight = 0;
	$$(selectors).each(function(selector){
		maxHeight = Math.max(maxHeight, selector.getCoordinates().height);
	});
	$$(selectors).each(function(selector){
		selector.setStyle(window.ie6 ? 'height' : 'min-height', maxHeight);
	});
};


/*
Script: 	
	JVEffects - JV Effects such as background color.

License:
	Proprietary - PHPKungfu Club members only

Copyright:
	Copyright (C) PHPKungfu. All rights reserved.
*/

var JVEffects = new Class({
    Implements: [Options],	
	options:{		
		fxDuration: 350,
		fxTransition: Fx.Transitions.linear,
		wait: false
	},
	
    initialize: function(selectors, fxPropertiesFrom, fxPropertiesTo, options){
        this.setOptions(options);        
        $$(selectors).each(function(selector, index){
            var selectorFx = new Fx.Styles(selector, this.options);            
			selector.addEvents({
				'mouseenter': function(){
					selectorFx.stop().start(fxPropertiesFrom);
				},
				'mouseleave': function(){
					selectorFx.stop().start(fxPropertiesTo);
				}
			});
        });
    }
});

jQuery(function($){	
	 $('body').bind('refresh', function(){
		var selectors = $$('.block.eheight');	
		if(selectors){
			selectors.each(function(el){
				if(el){
					var childs = el.getElements(".position");
					
					if(childs){
						var maxHeight = 0;
						
						childs.each(function(child){
							maxHeight = Math.max(maxHeight, child.getCoordinates().height);
						});
						
						childs.each(function(child){
							child.setStyle(window.ie6 ? 'height' : 'min-height', maxHeight);
						});
					}				
				}	
				
			});		
		}
	 });
	 
	 $('body').trigger('refresh');

});

/*
Script: 	
	JVLazyLoad - Lazy loading.

License:
	Proprietary - PHPKungfu Club members only

Copyright:
	Copyright (C) PHPKungfu. All rights reserved.
*/

var JVLazyLoad = new Class({
    Implements: [Options],
	options: {
		replacer: 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==',
		selectors: 'img',
		duration: 750
	},
	
    initialize: function(options){		
		this.setOptions(options);
		this.selectors = $$(this.options.selectors);
		if(!this.selectors.length){
			this.selectors = $$(this.options.selectors);
		}
		this.selectors.each(function(selector){
            selector.osrc = selector.src;
			selector.src = this.options.replacer;
        }.bind(this));
		
		window.addEvent('scroll', this.initLoad.bind(this));
		this.initLoad();
    },
	
	initLoad: function(){
		var that = this;
		this.selectors.each(function(selector){
			if(selector.getCoordinates().top < window.getHeight() + window.getScrollTop()){
				if(!selector.loaded){
					selector.loaded = true;
					
					new Asset.image(selector.osrc, {
						onload: function(){
							selector.src = selector.osrc;
							new Fx.Morph(selector, {duration: that.options.duration}).set({opacity: 0}).start({opacity: 1});
						}
					});
				}
			}
		});	
	}
});

/*
Script: 	
	JVTop - Scroll to top effect.

License:
	Proprietary - PHPKungfu Club members only

Copyright:
	Copyright (C) PHPKungfu. All rights reserved.
*/

var JVTop = new Class({
    Implements: [Options],
	options:{		
		fxDuration: 350,
		fxTransition: Fx.Transitions.linear,
		wait: false
	},
	
    initialize: function(options){
        this.setOptions(options);        
        var topElement = new Element('div', {
			'id': 'toTop',
            'html': '' 
		}).inject(document.body);
        topElement.addEvent('click', function(){
            new Fx.Scroll(window).toTop();
        });
		var topFx = new Fx.Morph(topElement, this.options).set({'opacity': 0});
		window.addEvent('scroll', function(){
			if(window.getScrollTop() != 0){
				topFx.cancel().start({'opacity': 1});
			}
			else{
				topFx.cancel().start({'opacity': 0});
			}
		});
    }
});		


var JVFwResponsive = (function ($) {	
	var JVFwResponsive = {
			width  : $(window).width(),
			screenAction: function (size, action, defaultAction) {
				if(JVFwResponsive.width <= size){
					action();
				}else{
					if(defaultAction){
						defaultAction();
					}
				}				
				
				$(window).resize(function(){
					var width = $(window).width();
					
					if(width <= size){
						action();
					}else{
						if(defaultAction){
							defaultAction();
						}
					}	
				});					
			}
		};
	
	return JVFwResponsive;	
	
})(jQuery);

var JVScroll = (function($){
	var Scroll = function(arg){
		var properties = {					
			init: function(){
				this.scroll  = $('<div/>', {'class':'jv-scroll'}).css({'position': 'relative'});
				this.inner   = $('<div/>', {'class':'scroll-inner'}).css({'position': 'absolute', 'width': 2000});
				this.btnnext = $('<a/>'  , {'class':'next', 'text': '>>'}).css({'position': 'absolute', 'cursor': 'pointer'});
				this.btnprev = $('<a/>'  , {'class':'prev', 'text': '<<'}).css({'position': 'absolute', 'cursor': 'pointer'});	
				
				if($('body').css('direction') == 'rtl'){
					this.btnnext.css('left', 0);
					this.btnprev.css('right', 0);
				}else{
					this.btnprev.css('left', 0);
					this.btnnext.css('right', 0);
				}
				
				var self = this;
				
				this.inner.appendTo(this.scroll);				
				this.btnprev.click(function(){
					self.prev();
				})
				.appendTo(this.scroll);
				
				this.btnnext.click(function(){
					self.next();
				})
				.appendTo(this.scroll);
			},
			
			content: function(el){
				this.init();
				this.inner.html(el)
				return this.scroll;
			},
			
			next: function(){	
				var step = 75;		
				
				if($('body').css('direction') == 'rtl'){
					$(this.inner).animate({	
						left : '+='+step,
					    right: '-='+step
					  }, 300, function() {						  
					});
					
					return;
				}
				
				$(this.inner).animate({				  
				    left  : '-='+step,
				    right : '+='+step
				  }, 300, function() {
					  
				});
						
				
			},
			
			prev: function(){	
				var step = 75;
				
				if($('body').css('direction') == 'rtl'){
					$(this.inner).animate({				  
					    left  : '-='+step,
					    right : '+='+step
					  }, 300, function() {
						  
					});
					
					return;
				}
				
				$(this.inner).animate({	
					left : '+='+step,
				    right: '-='+step
				  }, 300, function() {
					  
				});
			},
						
			display: function(el){
				el.html(this.scroll);
			}
		};	
		
		$.extend(this, properties);
		
		return this;
	};
	
	return Scroll;
	
})(jQuery);
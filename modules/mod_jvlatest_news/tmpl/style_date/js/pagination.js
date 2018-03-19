/**
 * @class: jvlatestnews
 * @description: Display contents in tabs 
 * @version: 1.0 
 */
var $defined = function(obj){
    return (obj != undefined);
};
var jvlatestnews = new Class({
    Implements: [Chain, Events, Options],
	options: {
		width: '100%',
		newsHandler: 'jvlatestnews-pagination',
		newsContainer: 'jvlatestnews-container',		
		currentNewsHandlerClass: 'jvlatestnews-pagination-selected',		
		currentNewsContentClass: 'jvlatestnews-pagination-selected',		
		currentIndex: 0,	
		loaderURL: 'modules/mod_jvlatest_news/tmpl/default/images/ajax-loader.gif',
		autoRun: 0,	
		ajax: 1,
		ajaxMethod: 'get',
		direction: 1,
		forceWaiting: 0,
		fx: 'fade',
		transition: Fx.Transitions.Expo.easeInOut,				
		duration: 1000,		
		timer: null,
		newsTimer: 5000,
		container: null,
		handlers: null,
		contents: null		
	},
	
	initialize: function(selector, options){	
		this.setOptions(options);
		this.initNews(selector);
	},
	
	initNews: function(selector){
		var that = this;
		var selector = $(selector);
		if(!selector) return;
		selector.setStyles({
			'width': that.options.width
		});	
        
        if(!selector.getElement('.' + that.options.newsHandler)){
            return;
        }
		that.options.handlers = selector.getElement('.' + that.options.newsHandler).getElements('a');
		that.options.handlers = that.options.handlers.filter(function(el){
			return !el.hasClass('start') && !el.hasClass('next') && !el.hasClass('prev') && !el.hasClass('end')
		});
			
		if(!that.options.handlers.length) return;
		that.options.currentIndex = Math.min(that.options.currentIndex, that.options.handlers.length - 1);
		that.options.container = selector.getElement('.' + that.options.newsContainer);
		that.fx = new Fx.Morph(that.options.container, {
			duration: that.options.duration,
			transition: that.options.transition,
			wait: false
		});
		
		that.options.contents = that.options.container.getChildren();						
		if(that.options.fx == 'slideWidth'){
			that.options.contents.each(function(content, index){
				content.setStyle('position', 'absolute');
				content.setStyle('left', -1 * that.options.contents[0].getSize().x);			
			});		
		}
		else if(that.options.fx == 'slideHeight'){
			that.options.contents.each(function(content, index){
				content.setStyle('position', 'absolute');
				content.setStyle('top', -1 * that.options.contents[0].getSize().y);			
			});		
		}				
		else if(that.options.fx == 'fade'){
			that.options.contents.each(function(content, index){
				content.setStyles({
					'position': 'absolute',
					'top': 0,
					'opacity': 0
				});			
			});	
		}
		else{
			that.options.fx = 'showHide';
			that.options.contents.each(function(content, index){
				content.setStyles({
					'position': 'absolute',
					'top': 0,
					'display': 'none'
				});			
			});	
		}		
		that.options.handlers.each(function(handler, index){
			if(handler.hasClass(that.options.currentNewsHandlerClass)){
				that.options.currentIndex = index;
			}
			handler.removeEvents('click').addEvent('click', function(e){
               if(e) e.stop();
				if(!that.options.forceWaiting){					
					if(that.options.ajax == 1 && !this.ajaxcalled){
						if(this.req) this.req.cancel();
						this.req = new Request({
							url: handler.href,
							method: that.options.ajaxMethod,
							data: {
								'jvlatestnews-ajax': 1
							},
							onComplete: function(response){
								if(response !== '0')
								that.options.contents[index].set('html', response);
								var imgTags = that.options.contents[index].getElements('img');
								if(imgTags.length){
									var imgSrcs = imgTags.map(function(imgTag){
										return imgTag.src;
									});
									new Asset.images(imgSrcs, {
										onComplete: function(){
											handler.ajaxcalled = true;
											handler.fireEvent('click');
										}
									});
								}
								else{
									handler.ajaxcalled = true;
									handler.fireEvent('click');
								}
							}
						}).send();
						return;
					}
					if(that.options.autoRun == 1){
						clearTimeout (that.options.timer);						
						that.options.timer = setInterval(function(){
							nextLink.fireEvent('click');
						}, that.options.newsTimer);
					}                    
					that[that.options.fx](index);
                   

				}
			});
		});
		var startLink = selector.getElement('.' + that.options.newsHandler).getElement('a.start');
		if(startLink){ 
			startLink.removeEvent('click').addEvent('click', function(e){
                                //e.stop();
				that.options.handlers[0].fireEvent('click');
                                return false;
			});
		}
		var prevLink = selector.getElement('.' + that.options.newsHandler).getElement('a.prev');
		if(prevLink){
			prevLink.removeEvent('click').addEvent('click', function(e){
                                //e.stop();
				that.options.handlers[that.options.currentIndex > 0 ? that.options.currentIndex - 1 : 0].fireEvent('click');	
                                return false;
			});
		}
		var nextLink = selector.getElement('.' + that.options.newsHandler).getElement('a.next');
		if(nextLink){
			nextLink.removeEvent('click').addEvent('click', function(e){
                                //e.stop();
				that.options.handlers[that.options.currentIndex < that.options.handlers.length - 1 ? that.options.currentIndex + 1 : 0].fireEvent('click');	
                                return false;
			});
		}		
		var lastLink = selector.getElement('.' + that.options.newsHandler).getElement('a.end');
		if(lastLink){
			lastLink.removeEvent('click').addEvent('click', function(e){
                                //e.stop();
				that.options.handlers[that.options.handlers.length - 1].fireEvent('click');	
                                return false;
			});
		}
		
		that.options.handlers[that.options.currentIndex].fireEvent('click');		
		if(that.options.autoRun == 1){
			that.options.timer = setInterval(function(){
				nextLink.fireEvent('click');
			}, that.options.newsTimer);
		}			
	},
	
	slideWidth: function(index){
		var that = this;		
		var currentContent = that.options.contents[that.options.currentIndex];		
		var currentHandler = that.options.handlers[that.options.currentIndex];
		if($defined(index)){
			if(that.options.currentIndex != index){
				if(that.options.currentIndex > index){
					that.options.direction = 0;				
				}
				else{
					that.options.direction = 1;
				}
				that.options.currentIndex = index;
			}
		}
		else{
			that.findTab();
		}
		var newContent = that.options.contents[that.options.currentIndex];
		if(that.options.direction == 0){
			var currentX = that.options.container.getSize().x;		

		}
		else{
			var currentX = (-1 * that.options.container.getSize().x);			
		}
		if(!currentContent.h){
			currentContent.setStyle('width', that.options.container.getParent().getSize().x);
			currentContent.h = currentContent.getSize().y;
		}
		if(!newContent.h){
			newContent.setStyle('width', that.options.container.getParent().getSize().x);
			newContent.h = newContent.getSize().y;
		}
		var newHandler = that.options.handlers[that.options.currentIndex];
		newHandler.getParent().addClass(that.options.currentNewsHandlerClass);
		var contentShow = new Fx.Morph(newContent, {
			duration: that.options.duration,
			transition: that.options.transition,
			wait: false,
			onStart: function(){
				that.options.forceWaiting = true;
			},
			onComplete: function(){
				that.options.forceWaiting = false;
			}
		});
		contentShow.start({
			'left': [0],
			'opacity': [0, 1]
		});
		that.fx.start({
			'height': [currentContent.h, newContent.h]
		});
		newContent.addClass(that.options.currentNewsContentClass);		
		if(currentContent != newContent){		
			var contentHide = new Fx.Morph(currentContent, {
				duration: that.options.duration,
				transition: that.options.transition,
				wait: false
			});
			currentHandler.getParent().removeClass(that.options.currentNewsHandlerClass);			
			contentHide.start({
				'left': [currentX],
				'opacity': [1, 0]
			});
			currentContent.removeClass(that.options.currentNewsContentClass);
		}
	},
	
	slideHeight: function(index){
		var that = this;		
		var currentContent = that.options.contents[that.options.currentIndex];		
		var currentHandler = that.options.handlers[that.options.currentIndex];
		if($defined(index)){
			if(that.options.currentIndex != index){
				if(that.options.currentIndex > index){
					that.options.direction = 0;				
				}
				else{
					that.options.direction = 1;
				}
				that.options.currentIndex = index;
			}
		}
		else{
			that.findTab();
		}
		var newContent = that.options.contents[that.options.currentIndex];
		if(that.options.direction == 0){
			var currentY = that.options.container.getSize().y;			


		}
		else{
			var currentY = (-1 * that.options.container.getSize().y);			
		}
		if(!currentContent.h){
			currentContent.h = currentContent.getCoordinates().height;
		}
		if(!newContent.h){
			newContent.h = newContent.getCoordinates().height;


		}
		var newHandler = that.options.handlers[that.options.currentIndex];
		newHandler.getParent().addClass(that.options.currentNewsHandlerClass);
		var contentShow = new Fx.Morph(newContent, {
			duration: that.options.duration,
			transition: that.options.transition,
			wait: false,
			onStart: function(){
				that.options.forceWaiting = true;
			},
			onComplete: function(){
				that.options.forceWaiting = false;
			}
		});		
		contentShow.start({
			'top': [0],
			'opacity': [0, 1]
		});
		that.fx.start({
			'height': [currentContent.h, newContent.h]
		});
		newContent.addClass(that.options.currentNewsContentClass);		
		if(currentContent != newContent){		
			var contentHide = new Fx.Morph(currentContent, {
				duration: that.options.duration,
				transition: that.options.transition,
				wait: false
			});
			currentHandler.getParent().removeClass(that.options.currentNewsHandlerClass);			
			contentHide.start({
				'top': [0, -currentY],
				'opacity': [1, 0]
			});
			currentContent.removeClass(that.options.currentNewsContentClass);
		}
	},	
	
	fade: function(index){
		var that = this;		
		var currentContent = that.options.contents[that.options.currentIndex];		
		var currentHandler = that.options.handlers[that.options.currentIndex];
		if($defined(index)){
			if(that.options.currentIndex != index){				
				that.options.currentIndex = index;
			}
		}
		else{
			that.findTab();
		}
		var newContent = that.options.contents[that.options.currentIndex];		
		var newHandler = that.options.handlers[that.options.currentIndex];
		newHandler.getParent().addClass(that.options.currentNewsHandlerClass);
		var contentShow = new Fx.Morph(newContent, {
			duration: that.options.duration,
			transition: that.options.transition,
			wait: false,
			onStart: function(){
				that.options.forceWaiting = true;
			},
			onComplete: function(){
				that.options.forceWaiting = false;
			}
		});		
		contentShow.start({
			'opacity': [0, 1]
		});
		that.fx.start({
			'height': [currentContent.getCoordinates().height, newContent.getCoordinates().height]
		});
		newContent.addClass(that.options.currentNewsContentClass);		
		if(currentContent != newContent){		
			var contentHide = new Fx.Morph(currentContent, {
				duration: that.options.duration,
				transition: that.options.transition,
				wait: false
			});
			currentHandler.getParent().removeClass(that.options.currentNewsHandlerClass);			
			contentHide.start({
				'opacity': [1, 0]
			});
			currentContent.removeClass(that.options.currentNewsContentClass);
		}
	},
	
	showHide: function(index){
		var that = this;		
		var currentContent = that.options.contents[that.options.currentIndex];		
		var currentHandler = that.options.handlers[that.options.currentIndex];
		if($defined(index)){
			if(that.options.currentIndex != index){				
				that.options.currentIndex = index;
			}
		}
		else{
			that.findTab();
		}
		var newContent = that.options.contents[that.options.currentIndex];		
		var newHandler = that.options.handlers[that.options.currentIndex];
		newHandler.getParent().addClass(that.options.currentNewsHandlerClass);
		newContent.setStyle('display', '');
		that.fx.start({
			'height': [currentContent.getCoordinates().height, newContent.getCoordinates().height]
		});
		newContent.addClass(that.options.currentNewsContentClass);				
		if(currentContent != newContent){	
			currentHandler.getParent().removeClass(that.options.currentNewsHandlerClass);			
			currentContent.setStyle('display', 'none');
			currentContent.removeClass(that.options.currentNewsContentClass);
		}
	},
	
	findTab: function(){
		var that = this; 
		var len = that.options.contents.length;
		if(that.options.direction == 1){
			if(that.options.currentIndex < len - 1){
				that.options.currentIndex++;
			}
			else{
				that.options.currentIndex = 0;
			}
		}
		else{
			if(that.options.currentIndex > 0){
				that.options.currentIndex--;
			}
			else{
				that.options.currentIndex = len - 1;
			}
		}
		
	}
});
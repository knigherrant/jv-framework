                                                                   

var JVMenu = (function($){
	var 
		menu = function (selector, ops) {
			selector = $(selector);
			ops = $.extend({},menu.options,ops);
			selector.removeClass('cssmenu');
			var 
				$window = $(window).resize(function(){
					if($window.width() < ops.responsive){ 
						isTouch || $this.trigger('change',[isTouch = true]);
					}else{
						isTouch && $this.trigger('change',[isTouch = false])
					}
				}),
				isTouch = $window.width() < ops.responsive,
				$this = $(this).bind('change',function(e,bol){
					bol ? 
						selector.addClass('fxmenu-touch').removeClass('fxmenu') 
						: 
						selector.removeClass('fxmenu-touch').addClass('fxmenu');
				})
			;
			$this.trigger('change',[isTouch]);
			(function(){
				var
					root = selector.parent(),
					toggleMenu = $('.flexMenuToggle'),
                    wrapper = $('#wrapper'),
                    menuPanel = $('#block-mainnav'),
					hideMenu = function(){
                        wrapper.stop().animate({translateX: 0},{
                            duration: ops.main.duration,
                            step: function(val){
                                menuPanel.css('translateX',val - 280);
                            },
                            complete: function(){
                                $body.removeClass('showmenu');
                            }
                        });
					},
					showMenu = function(){
						$body.addClass('showmenu');
                        wrapper.stop().animate({translateX: 280},{
                            duration: ops.main.duration,
                            step: function(val){
                                menuPanel.css('translateX',val - 280);
                            }
                        });
					}
				;
				toggleMenu.click(function(){
				    if ($body.hasClass('showmenu')) hideMenu();
					else showMenu();
				});
				selector.find('.iconsubmenu').each(function(){
					$(this).click(function(){						
						var 
							li = $(this).parent('li'),
							ul = li.parent()
						;
                        isTouch?(function(){
                            li.hasClass('li-group-title')?(function(){
                                    !li.hasClass('hide-sub')?li.children('ul').hide(ops.sub.duration,function(){ 
                                        li.addClass('hide-sub');
                                    }):li.removeClass('hide-sub').children('ul').show(ops.sub.duration);
                                })():(function(){    
                                var
                                    newLi = li.clone(true),
                                    newUl = $('<ul>',{'class':'fxmenu-touch fxmenu-clonesub'}).append(newLi),
                                    newDiv = $('<div>').append(newUl),
                                    btnBack = newLi.children('.iconsubmenu').unbind('click').click(function(){
                                        lastNode.animate({translateX: '+=280'},ops.sub.duration,function(){
                                            newDiv.remove();
                                        });
                                    });
                                ;
                                var lastNode = root.parent().children(':last');
                                lastNode.after(newDiv.css({
                                    translateX: lastNode.css('translateX') + 280
                                }));
                                lastNode.push(newDiv[0]);
                                lastNode.animate({translateX: '-=280'},ops.sub.duration);
                            })();
                        }).apply(this,arguments):(function(){
                            
                        }).apply(this,arguments);
                    });
				})
				
				var $body  = $('body');
				$doc = $(document).bind({
					swiperight: function(){
						if(isTouch && !$body.hasClass('showmenu')) showMenu();
					},
					swipeleft: function(){
						if(isTouch && $body.hasClass('showmenu')) hideMenu();
					}
				});
				//.bind('vmousedown',vEvent.down);
			var setUp = function(s,ops){
				s = $(s);
				var 
					sub = s.children('.fx-subitem'),
					timeOut
				;
				if(!sub.length) return;
				s.hover(function(){
					if(isTouch) return;
					clearTimeout(timeOut);
					timeOut = setTimeout(function(){
						if(!sub.is(':visible')){
							sub.css({
								visibility: 'hidden',
								display: 'block',
								left: ''
							});
							var 
								of = sub.offset(),
								width = sub.outerWidth()
							;
							if(of.left + width > $(window).width() ){
								sub.css({
									left: - width + ( sub.parent().width() - sub.position().left)
								});
								of = sub.offset();
								if(of.left < 0) sub.css('left', sub.position().left - of.left);
							}
							sub.css({
								visibility: '',
								display: 'none'
							});
						}
						menu.effects[ops.effect](sub,ops,'show');
					},ops.delay);
				},function(){
					if(isTouch) return;
					clearTimeout(timeOut);
					timeOut = setTimeout(function(){
						menu.effects[ops.effect](sub,ops,'hide');
					},ops.delay);
				})
			};
			
			
			selector.children('li').each(function(){
				setUp(this,ops.main);
				$(this).find('.fxsubmenu').each(function(){
					setUp(this,ops.sub);
				});
			});
		})();
	}

	menu.effects = {
		fade: function(s,ops,mode){
			if(mode === 'show'){
				if(s.is(':visible')){
					if(parseFloat(s.css('opacity')) == 1) return;
					s.stop().animate({opacity:1},ops.duration);
				}else{
					s.css({
						display: 'block',
						opacity: 0
					}).animate({opacity:1},ops.duration);
				}
				return;
			}
			if(!s.is(':visible')) return;
			s.stop().animate({opacity:0},ops.duration,function(){
				s.hide();
			});			
		},
		slide: function(s,ops,mode){
			var createrP = function(){
				s.css({
					display:'block',
					visibility: 'hidden'
				});
				var 
					p = $('<div>').addClass('fx-p').css({ overflow: 'hidden'}),
					props = {}
				;
				$.each(['left','top','position'],function(){
					props[this.toString()] = s.css(this.toString());
				})
				p.css(props);
				s.after(p);
				p.append(s.css({
					position : 'relative',
					top: 0,
					left: 0,
					visibility: ''
				}));
				
				p.css({
					width: p.width(),
					height: p.height()
				});
				
				p.data().restore = function(){
					p.after(s.css(props)).remove();
				}
				
				return p;
			}
		
		
			if(mode === 'show'){
				if(s.is(':visible')){
					var p = s.parent();
					if(p.is(':not(.fx-p)')) return;
					console.log('');
					s.stop().animate({left: 0},ops.duration,function(){
						p.data().restore();
					});
				}else{
					var p = createrP();
					s.css({
						left: - p.width()
					}).animate({left: 0},ops.duration,function(){
						p.data().restore();
					});
				}
				return;
			}
			
			if(!s.is(':visible')) return;
			var p = s.parent();
			if(p.is(':not(.fx-p)')) p = createrP();
			s.stop().animate({left: - p.width()},ops.duration,function(){
				p.data().restore();
				s.hide();
			});
		}
	}
		
	menu.options = {
		main: {
			delay: 300,
			duration: 350,
			effect: 'fade',
			easing: ''
		},
		sub: {
			delay: 300,
			duration: 350,
			effect: 'fade',
			easing: ''
		},
		responsive: 1023
	}
	return menu;
})(jQuery);

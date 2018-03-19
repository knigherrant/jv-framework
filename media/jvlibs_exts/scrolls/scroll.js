var JVScrolla = (function($){
    return $.extend(function(el,ops){
        el = $(el);
        if(!el.length) return;
        var 
            $this = $(this),
            elData = el.data(),
            self = arguments.callee, 
            This = this
        ;
        if(elData.JVScroll) return elData.JVScroll;
        elData.JVScroll = this;
        ops = $.extend({},self.options,ops);
        el.addClass('jvScroll-panel');
        ops.fixWidth && el.width(ops.fixWidth);
        ops.fixHeight && el.height(ops.fixHeight);
        var
            tmpl = function(){
                var 
                    panel = $('<div>',{'class':'jvScroll'}),
                    scroll = $('<div>'),
                    first = $('<button>',{type:'button', 'class': 'btn-first'}),
                    last = $('<button>',{type:'button', 'class': 'btn-last'}),
                    slide = $('<div>',{'class': 'slide'}),
                    move = $('<span>',{type:'button', 'class': 'btn-move'})
                ;
                panel.append(scroll.append(first,last,slide.append(move)))
                return {
                    panel: panel,
                    scroll: scroll,
                    first: first,
                    last: last,
                    slide: slide,
                    move: move
                };
            },
            sx = ops.scrollX?tmpl():false,
            sy = ops.scrollX?tmpl():false,
            isDrag = false,
            step = 100,
            resetX = function(){
                sx.size = el[0].scrollWidth;
                sx.panelSize = el.width();
                sx.slideSize = sx.slide.width();
                sx.percent = sx.slideSize / sx.size;
                sx.btnSize = sx.percent * sx.panelSize;
                sx.move.width(sx.btnSize);
            },
            resetY = function(){
                sy.panel.css({
                    height: el.height()
                }).position({
                    at: 'right top',
                    my: 'right top',
                    of: el
                });
                
                sy.size = el[0].scrollHeight;
                sy.panelSize = el.height();
                sy.slideSize = sy.slide.height();
                sy.percent = sy.slideSize / sy.size;
                sy.btnSize = sy.percent * sy.panelSize;
                sy.move.height(sy.btnSize);
                sy.to = el.scrollTop();
                el.scroll();
            }
        ;
        //-----------------------------------------------------------------------
        sx &&
            $(window).bind('resize load',resetX) && 
            el.scroll(function(){
                if(isDrag) return;
                sx.move.css('top', sx.percent * el.scrollLeft());
            }).hover(function(){
                sx.panel.addClass('hover');
            },function(){
                sx.panel.removeClass('hover');
            })//.mousewheel(function(e,dir){});
        ;
        
        //-----------------------------------------------------------------------
        if(sy){
            sy.panel.addClass('vertical').insertAfter(el);
            $(window).bind('resize load',resetY);
            el.scroll(function(){
                if(isDrag) return;
                sy.move.css('top', Math.ceil(sy.percent * el.scrollTop()));
            }).hover(function(){
                sy.panel.addClass('hover');
            },function(){
                sy.panel.removeClass('hover');
            }).mousewheel(function(e,dir){
                var top = el.scrollTop();
                if(dir < 0){
                    if(sy.size - sy.panelSize < top + 2) return;
                    This.toTop(sy.to += step);
                }else{
                    if(top <= 0 ) return;
                    This.toTop(sy.to -= step);
                }
                return false;
            });
            
            
            sy.move.draggable({
                axis: 'y',
                containment: 'parent',
                start: function(){
                    isDrag = true;
                },
                drag: function(e,ui){
                    el.scrollTop(ui.position.top/sy.percent);
                },
                stop: function(){
                    isDrag = false;
                }
            });
            
            if(ops.yNav != 'none'){
                sy.panel.addClass('nav-' + ops.yNav)
                sy.last.click(function(){
                    This.toTop(sy.to += step);
                });
                sy.first.click(function(){
                    This.toTop(sy.to -= step);
                })
            } 
        }
        
        //-----------------------------------------------------------------------
        
        switch(ops.visible){
            case 'hover': 
                el.hover(function(){
                    sy.panel.fadeIn(300);
                },function(){ 
                    sy.panel.fadeOut(300);
                });
                break;
            case 'active':
                break;
        }
        $.extend(this,{
            toTop: function(i){
                if($.type(i) == 'number'){
                    el.stop().animate({scrollTop: i},300,function(){
                        sy.to = el.scrollTop();
                    });
                }
            },
            toLeft: function(i){
                
            }
            
        });
        
        return;
        
        var
            isShow = false,
            button = $('<a>',{'class':'btn btn-toggle'}).append(ops.title).attr('style',(ops.btnCss || []).join(';')),
            body = $('<div>',{'class': 'jvdock-body'}).append(el).css({
                width: ops.width,
                height: ops.height
            }),
            content = $('<div>',{'class': 'jvdock ' + ops.display}).append(button,body).appendTo(document.body),
            pos = (function(){
                var poss = 'top left right bottom'.split(' ');
                for(var x = 0; x < poss.length; x ++) 
                    if(new RegExp('^'+poss[x]+'\-.+').test(ops.display)) return poss[x];
            })(),
            align = (function(){
                var aligns = 'top left right bottom'.split(' ');
                for(var x = 0; x < aligns.length; x ++) 
                    if(new RegExp('.+\-' + aligns[x] + '$').test(ops.display)) return aligns[x];
            })(),
            cssEffect = {show:{},hide:{}},
            initPosition = function(){
                
                // init button
                var 
                    buttonCss = {},
                    contentCss = {}
                ;
                
                switch(pos){
                    case 'top': 
                        buttonCss['bottom'] = -button.outerHeight() + 1;
                        contentCss['width'] = ops.width;
                        break;
                    case 'left': 
                        buttonCss['right'] = -button.outerWidth() + 1;
                        contentCss['height'] = ops.height;
                        break;
                    case 'bottom': 
                        buttonCss['top'] = -button.outerHeight() + 1;
                        contentCss['width'] = ops.width;
                        break;
                    case 'right': 
                        buttonCss['left'] = -button.outerWidth() + 1;
                        contentCss['height'] = ops.height;
                }
                contentCss[align] = ops.margin;
                
                button.css(buttonCss);
                content.css(contentCss);
                
                cssEffect.show['margin-'+pos] = body.css('margin-'+pos);
                
                var marginEff;
                if(/left|right/.test(pos)) marginEff = body.outerWidth();
                else marginEff = body.outerHeight();
                
                cssEffect.hide['margin-'+pos] = - marginEff;
                body.css(cssEffect.hide);
            },
            initAction = function(){
                var 
                    timeOut
                    show = function(){
                        if(!isShow){
                            clearTimeout(timeOut);
                            timeOut = setTimeout(This.show,ops.delay);
                        }
                    },
                    hide = function(){
                        if(isShow){
                            clearTimeout(timeOut);
                            timeOut = setTimeout(This.hide,ops.delay);
                        }
                    }
                ;
                
                switch(ops.openOn){
                    case 'click': button.click(show);
                        break;
                    case 'mouseenter': content.mouseenter(show);
                }
                switch(ops.closeOn){
                    case 'click': button.click(hide);
                        break;
                    case 'mouseleave': content.mouseleave(hide);
                }
            }
        ;
        initPosition();
        initAction();
        var hideOnCancel = function(e){
            if(isShow && !$(e.target).parents('.jvdock:first').is(content)) This.hide();
        }
        $.extend(this,{
            options: ops,
            show: function(){
                if(isShow) return;
                isShow = true;
                body.stop().animate(cssEffect.show,{
                    duration: ops.duration
                });
                if(ops.hideOnCancel) $(document).bind('click',hideOnCancel);
            },
            hide: function(){
                if(!isShow) return;
                isShow = false;
                body.stop().animate(cssEffect.hide,{
                    duration: ops.duration
                });
                if(ops.hideOnCancel) $(document).unbind('click',hideOnCancel);
            }
        });
    },{
        options:{
            scrollX: 'bottom',
            scrollY: 'right',
            visible: 'alway',
            fixWidth: false,
            fixHeight: false,
            duration: 500,
            nav: false
        }
    });
})(jQuery);
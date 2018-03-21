var JVDock = (function($){
    return $.extend(function(el,ops){
        var $this = $(this), self = arguments.callee, This = this;
        el = $(el);
        if(!el.length) return;
        ops = $.extend({},self.options,ops);
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
                    timeOut,
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
            delay: 300,
            openOn: 'click',
            closeOn: 'click',
            transition: 500,
            display: 'top-right',
            title: 'JV Dock',
            width: 100,
            height: 100,
            margin: 100
        }
    });
})(jQuery);
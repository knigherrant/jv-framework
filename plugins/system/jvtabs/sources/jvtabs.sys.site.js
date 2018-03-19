var JVTab = (function($){
    return $.extend(function(el, ops){
        var self = arguments.callee, This = this;
        ops = $.extend({},self.options,ops);
        el = $(el).tab();
        /^[0-9]+$/.test(ops.minHeight) && (ops.minHeight = parseInt(ops.minHeight));
        /^[0-9]+$/.test(ops.maxHeight) && (ops.maxHeight = parseInt(ops.maxHeight));
        
        var 
            $this = $(this),
            nav = el.children('.JVTab-nav'),
            headTabs = nav.find('ul'),
            contents = el.children('.JVTab-content'),
            tabs = []
        ;
        nav.find('a[href^=#]').each(function(i){
            var
                tab = $(this),
                id = tab.attr('href'),
                content = contents.children(id)
            ;
            var tabData = {
                index: i,
                tab: tab,
                id: id.substring(1),
                content: content
            }
            tabs.push(tabData);
            tab.click(function(){
                changeTab(i);
                return false;
            }).data('jvtabs',tabData);
        });
        if(!tabs.length) return;
        
        ops.load == 'cache' && (function(){
            var caches = {},overlay = $('<div>',{'class': 'JVTab-overlay'}).append($('<div>',{'class':'loading'}));
            $this.bind('change',function(e,from,to){
                if(!caches[to.id]){
                    e.stopImmediatePropagation();
                    if(caches[to.id] === 0) return false;
                    from.content.append(overlay.stop().animate({opacity: 0.7},300));
                    var cache = ops.cache[to.id];
                    $(JVAjaxCall).one('scriptloaded',function(){
                        caches[to.id] = true;
                        to.content.append(cache.content).imagesLoaded(function(){
                            changeTab(to.index);
                            overlay.stop().animate({opacity: 0},300,function(){overlay.remove();});
                        });
                    });
                    JVAjaxCall.assign(cache);
                    caches[to.id] = 0;
                    return false;
                }
            });
        })(); 
        // method
        var
            activeIndex = -1,
            changeTab = function(i){
                if(i === activeIndex) return;
                var lastActive = tabs[activeIndex]||{tab: $('<div>'),content:$('<div>')};
                var tab = tabs[i];
                if(!tab) return;
                if($this.triggerHandler('change',[lastActive,tab]) === false) return;
                
                lastActive.tab.parent().removeClass('active');
                tab.tab.parent().addClass('active');
                var tabsBtns = headTabs.children();
                var hideTo = tabsBtns.index(lastActive.tab.parent()) < tabsBtns.index(tab.tab.parent())?-1:1;
                var showFrom = hideTo < 0 ? 1:-1;
                
                var hideContent = lastActive.content;
                var showContent = tab.content
                
                var effect = self.effects[ops.effect] || self.effects.fade;
                
                //hideContent[0].posisionTab = 0;
                hideContent.stop().removeClass('active').addClass('animating').animate({posisionTab: hideTo},{
                    duration: ops.duration,
                    step: function(i){
                        effect.call(hideContent,i,showContent,hideContent);
                    },
                    complete: function(){
                        hideContent.removeClass('animating')
                    }
                });
                
                showContent.is(':animated') || (showContent[0].posisionTab = showFrom);
                showContent.stop().animate({posisionTab: 0},{
                    duration: ops.duration,
                    step: function(i){
                        effect.call(showContent,i,showContent,hideContent);
                    },
                    complete: function(){
                        $this.triggerHandler('changed',[lastActive,tab]);
                        showContent.addClass('active').removeClass('animating');
                    }
                }).addClass('animating');
                
                activeIndex = i;
            }
        ;
        
        (function(){
            var refresh = function(){},glideTo,setVisible,nextNav,prevNav,events = {},
                panel = headTabs.parent(),
                btnNext = $('<a>',{'class':'nav-next', href: 'javascript:void(0)'}).appendTo(nav).append($('<span>')),
                btnPrev = $('<a>',{'class':'nav-prev', href: 'javascript:void(0)'}).prependTo(nav).append($('<span>'))
            ;
            var buildFn = function(){
                if(ops.navPos == 'top' || ops.navPos == 'bottom'){                
                    var rtl = el.css('direction') == 'rtl';
                    refresh = function(){
                        var width = 0;
                        headTabs.children().each(function(){
                            var $this = $(this);
                            width += $this.width();
                            width += parseInt($this.css('margin-left')) || 0;
                            width += parseInt($this.css('margin-right')) || 0;
                        });
                        headTabs.width(width);
                        if(width > nav.width()){
                            el.addClass('nav-slide');
                        }else{
                            el.removeClass('nav-slide');
                        }
                    };
                    glideTo = function(node){
                        if(!node) return;
                        node = node.tab.parent();
                        var
                            nodeWidth = node.width(),
                            pos = node.position().left,
                            saiso = rtl?panel.prop('scrollWidth') - panel.width():0,
                            scrollLeft = panel.scrollLeft() + saiso
                        ;
                        if(pos < scrollLeft){
                            panel.stop().animate({scrollLeft: pos - saiso},300,setVisible);
                        }else if(pos + nodeWidth > scrollLeft + panel.width()){
                            panel.stop().animate({scrollLeft: pos - panel.width() + nodeWidth - saiso},300,setVisible);
                        }
                    };
                    setVisible = rtl?function(){
                        if(panel.scrollLeft() == 0){
                            btnPrev.addClass('disabled');
                        }else{
                            btnPrev.removeClass('disabled');
                        }
                        if(panel.scrollLeft() <= -(panel[0].scrollWidth - panel.width())){
                            btnNext.addClass('disabled');
                        }else{
                            btnNext.removeClass('disabled');
                        }
                    }:function(){
                        if(panel.scrollLeft() == 0){
                            btnPrev.addClass('disabled');
                        }else{
                            btnPrev.removeClass('disabled');
                        }
                        if(panel.scrollLeft() == panel[0].scrollWidth - panel.width()){
                            btnNext.addClass('disabled');
                        }else{
                            btnNext.removeClass('disabled');
                        }
                    };
                    prevNav = rtl?function(){
                        var toLeft = panel.scrollLeft() + panel.width();
                        toLeft = toLeft > 0? 0:toLeft;
                        panel.animate({scrollLeft: toLeft },300,setVisible);
                        
                    }:function(){
                        var toLeft = panel.scrollLeft() - panel.width();
                        toLeft = toLeft < 0? 0:toLeft;
                        panel.animate({scrollLeft: toLeft },300,setVisible);
                    };
                    nextNav = rtl?function(){
                        var
                            width = panel.width(),
                            scrollWidth = panel[0].scrollWidth,
                            scrollLeft = panel.scrollLeft(),                    
                            toLeft = scrollLeft - width
                        ;
                        toLeft = toLeft < -(scrollWidth - width)?-(scrollWidth - width):toLeft;
                        panel.animate({scrollLeft: toLeft },300,setVisible);
                    }:function(){
                        var
                            width = panel.width(),
                            scrollWidth = panel[0].scrollWidth,
                            scrollLeft = panel.scrollLeft(),                    
                            toLeft = scrollLeft + width
                        ;
                        toLeft = toLeft > scrollWidth - width?scrollWidth - width:toLeft;
                        panel.animate({scrollLeft: toLeft },300,setVisible);
                    };
                    events = {change: function(e,from,to){ glideTo(to);}}
                }else{
                    refresh = function(){
                        if(headTabs.height() > nav.height()){
                            el.addClass('nav-slide');
                        }else{
                            el.removeClass('nav-slide');
                        }
                    };
                    glideTo = function(tab){
                        if(!tab) return;
                        var
                            node = tab.tab.parent(),
                            nodeHeight = node.height(),
                            pos = node.position().top,
                            scrollTop = panel.scrollTop()
                        ;
                        if(pos < scrollTop){
                            panel.stop().animate({scrollTop: pos},300,setVisible);
                        }else if(pos + nodeHeight > scrollTop + panel.height()){
                            panel.stop().animate({scrollTop: pos - panel.height() + nodeHeight},300,setVisible);
                        }
                    };
                    setVisible = function(){
                        if(panel.scrollTop() == 0){
                            btnPrev.addClass('disabled');
                        }else{
                            btnPrev.removeClass('disabled');
                        }
                        if(panel.scrollTop() == panel[0].scrollHeight - panel.height()){
                            btnNext.addClass('disabled');
                        }else{
                            btnNext.removeClass('disabled');
                        }
                    };
                    prevNav = function(){
                        var toTop = panel.scrollTop() - panel.height();
                        toTop = toTop < 0? 0:toTop;
                        panel.animate({scrollTop: toTop},300,setVisible);
                    };
                    nextNav = function(){
                        var
                            height = panel.height(),
                            scrollHeight = panel[0].scrollHeight,
                            scrollTop = panel.scrollTop(),                    
                            toTop = scrollTop + height
                        ;
                        toTop = toTop > scrollHeight - height?scrollHeight - height:toTop;
                        panel.animate({scrollTop: toTop},300,setVisible);
                    };
                    var timeOut;
                    events = {
                        changed: function(e,from,to){
                            setTimeout(refresh,0);
                            clearTimeout(timeOut);
                            timeOut = setTimeout(function(){
                                glideTo(to);
                            },300);
                        },
                        change: function(e,from,to){
                            if(headTabs.height() < to.content.height()) el.removeClass('nav-slide');
                        }
                    }
                }
            };
            
            
            var reset = function(){
                if(ops.navSlide){
                    el.removeClass('nav-top nav-right nav-bottom nav-left h-nav v-nav');
                    $this.unbind(events);
                    btnNext.unbind('click',nextNav);
                    btnPrev.unbind('click',prevNav);
                    
                    el.addClass('nav-'+ops.navPos);
                    if(ops.navPos == 'top' || ops.navPos == 'bottom'){
                        el.addClass('h-nav');
                    }else{
                        el.addClass('v-nav');
                    }
                    
                    buildFn();
                    $this.bind(events);
                    btnNext.bind('click',nextNav);
                    btnPrev.bind('click',prevNav);
                    refresh();
                    setVisible();
                    $(window).resize(function(){
                        refresh();
                        glideTo(tabs[activeIndex]);
                    }).load(function(){
                        refresh();
                        setVisible();
                        glideTo(tabs[activeIndex]);
                    });
                }else{
                    $(window).unbind({
                        resize : refresh,
                        load: refresh
                    });
                    if(ops.navPos == 'left' || ops.navPos == 'right'){
                        refresh = function(){
                            var
                                maxHeight = ops.maxHeight;
                                minHeight = ops.minHeight
                            ;
                            var scrollHeight = headTabs.parent()[0].scrollHeight;
                            contents.children().css({
                                'min-height': '',
                                'max-height': ''
                            });
                            
                            if(minHeight < scrollHeight){
                                minHeight = scrollHeight;
                                if(maxHeight != 'none' && maxHeight < minHeight){
                                    maxHeight = minHeight;
                                }
                            }
                            contents.children().css({
                                'min-height': minHeight,
                                'max-height': maxHeight
                            });
                        }
                        refresh();
                        $(window).resize(refresh).load(refresh);
                    }
                }
            }
            reset();
            if((ops.navPos == 'left' || ops.navPos == 'right')){
                var 
                    defaultPos = ops.navPos,
                    changeSize = function(){
                        if(el.width() <= 520){
                            if(ops.navPos == 'top') return;
                            ops.navPos = 'top';
                        }else{
                            if(ops.navPos == defaultPos) return;
                            ops.navPos = defaultPos;
                        }
                        reset();
                    }
                ;
                changeSize();
                $(window).resize(changeSize);
            }            
        })();
        
        
        
        
        (function(){
            var
                maxHeight = ops.maxHeight,
                minHeight = ops.minHeight,
                timeOut
            ;
            contents.children().css({
                'min-height': minHeight,
                'max-height': maxHeight
            });
            
            $this.bind('change',function(e,from,to){
                var 
                    fromHeight = contents.height(),
                    toHeight = to.content.outerHeight()
                ;
                contents.height(fromHeight);
                clearTimeout(timeOut);
                if(fromHeight == toHeight) return timeOut = setTimeout(function(){
                    contents.css('height','');
                },ops.duration + 50);
                contents.stop().animate({height: toHeight},{
                    duration: ops.duration,
                    complete: function(){ contents.css('height','');}
                });
            });
        })();
        ops.auto && (function(){
            var 
                timeOut, isPause = false,
                mouseenter = function(){isPause = true;},
                mouseleave = function(){isPause = false; play()},
                play = function(){
                    clearTimeout(timeOut);
                    timeOut = setTimeout(function(){
                        if(isPause) return;
                        changeTab((activeIndex + 1) % tabs.length);
                    },ops.auto);
                }
            ;
            $.extend(This,{
                pause: function(){
                    $this.unbind('changed',play);
                    el.unbind({
                        'mouseenter': mouseenter,
                        'mouseleave': mouseleave
                    });
                    clearTimeout(timeOut);
                },
                play: function(){
                    $this.bind('changed',play);
                    el.bind({
                        'mouseenter': mouseenter,
                        'mouseleave': mouseleave
                    });
                    play();
                }
            });
            This.play();
        })();
        
        changeTab(ops.active);
        $.extend(this,{
            next: function(){},
            prev: function(){}
        });
    },{
        options:{
            active: 0,
            effect: 'fade',
            height: 'auto',
            navSlide: true,
            navPos: 'top',
            navSlide: true,
            duration: 500
        },
        effects:{
            fade : function(i){ this.css('opacity',1 - Math.abs(i));},
            hslide: function(i){
                this.css('translateX',this.outerWidth() * i);
            },
            vslide: function(i,show,hide){
                if(this === show){
                    if(i>0){
                        this.css('translateY',hide.outerHeight() * i);
                    }else{
                        this.css('translateY',show.outerHeight() * i);
                    }
                }else{
                    if(i<0){
                        this.css('translateY',hide.outerHeight() * i);
                    }else{
                        this.css('translateY',show.outerHeight() * i);
                    }
                }
            },
            hdrop: function(i,show,hide){
                this.css({
                    translateX: this.outerWidth() * i,
                    opacity: 1 - Math.abs(i)
                });
            },
            vdrop: function(i,show,hide){
                if(this === show){
                    if(i>0){
                        this.css('translateY',hide.outerHeight() * i);
                    }else{
                        this.css('translateY',show.outerHeight() * i);
                    }
                }else{
                    if(i<0){
                        this.css('translateY',hide.outerHeight() * i);
                    }else{
                        this.css('translateY',show.outerHeight() * i);
                    }
                }
                this.css('opacity',1 - Math.abs(i));
            }
        }
    });
})(jQuery);
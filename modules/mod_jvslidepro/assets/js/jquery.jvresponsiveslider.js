
var JVResponsiveSlide = (function ($) {
    return $.extend(function (selector,options) {
        selector = $(selector);
        if(selector.data('JVResponsiveSlide')) return selector.data('JVResponsiveSlide');
        selector.data('JVResponsiveSlide',this); 
        var self = arguments.callee;
        options.buttons = $.extend({},options.buttons,self.options.buttons)
        
        options = $.extend({}, self.options, options);

        var
            This = this,
            $this = $(this),
            ul = selector.find('ul.items:first'), 
            items = ul.children('li'),
            resbon = selector.find('.resbon'),
            rtl = selector.css('direction') == 'rtl'? -1 : 1
        ;
        items.each(function (i) {
            this.toSlideIndex = i;
        })
        // property
        var
            panelWidth,panelHeight, panelCenter, slideCenter, slideWidth,
            direction = 'next',
            loop = options.loop,
            curent = this.at = options.active,
            waitTo = curent,
            effects = {
                slide: {
                    css3: true,
                    action: function (i, x) {
                        var
                            $this = $(this),
                            left = (x - i) * slideWidth + panelCenter - slideCenter
                        ;
                        $this.css('translateX',left);
                    }
                },
                vslide: {
                    css3: true,
                    action: function (i, x){
                        i = i * rtl;
                        x = x * rtl;
                        var
                            $this = $(this),
                            top = (x - i) * panelHeight
                        ;
                        $this.css('translateY',top);
                    }
                },
                flow: {
                    css3: true,
                    action: function(pos, x){
                        var 
                            at = x - pos,
                            absAt = Math.abs(at),
                            scale = 1 - absAt /3,
                            scaleWidth = scale * slideWidth,
                            $this = $(this),
                            left = panelCenter - slideCenter + at * slideWidth - at * slideWidth / 6.1
                        ;
                        $this.css({
                            translateX: left,
                            scale: scale,
                            opacity: scale,
                            zIndex: Math.floor(scale * items.length * 10)
                        });
                    }
                },
                flow2: {
                    css3: true,
                    action: function(pos, x){
                        var 
                            at = x - pos,
                            absAt = Math.abs(at),
                            scale = 1 - absAt /3,
                            scaleWidth = scale * slideWidth,
                            $this = $(this),
                            left = panelCenter - slideCenter + at * slideWidth - at * slideWidth / 6.1
                        ;
                        $this.css({
                            translateX: left,
                            scale: scale,
                            zIndex: Math.floor(scale * items.length * 10)
                        });
                    }
                },
                child: {
                    css3: true,
                    effect: function(at){
                        var
                            $this = $(this),
                            random = function(from,to){
                                return Math.round((Math.random()*to)+from);
                            },
                            props = {}
                        ;
                        $.each({
                            translateX: $this.width() > 100 ? $this.outerWidth() : 100,
                            translateY: $this.height() > 100 ? $this.outerHeight(): 100,
                            rotateX: 1,
                            rotateY: 1,
                            rotateZ: 1,
                            scaleX: 1,
                            scaleY: 1
                        },function(i,val){
                            if(random(0,1)) return;
                            var dir = random(0,1)?1:-1;
                            
                            props[i] = function(at){
                                return dir * at * val;
                            }
                        });
                        if(random(0,1)){ props['scale'] = function(at){return 1 - at + 0.00000001}}
                        if(random(0,1)|| !props['scale']){ props['opacity'] = function(at){return 1 - at}}
                        
                        return function(at){
                            var thisProps = {};
                            $.each(props,function(index, val){
                                thisProps[index] = val(at);
                            });
                            $this.css(thisProps);
                        };
                    },
                    init: function(){
                        items.each(function(){
                            this.childs = $(this).find('p');
                            if(!this.childs.length) this.childs = $(this).children();
                            if(!this.childs.length) this.childs = $(this);
                        });
                    },
                    action: function(pos, x){
                        var 
                            at = x - pos,
                            absAt = Math.abs(at),
                            fixAt = absAt * 2,
                            childs = this.childs,
                            $this = $(this)
                        ;
                        if(fixAt < 1){
                            $this.show();
                            childs.each(function(i){
                                var 
                                    $child = $(this),
                                    delay = 1 / 3 / (childs.length),
                                    thisAt = 1 / 3 * fixAt + fixAt - delay * i
                                ;
                                thisAt = thisAt < 0 ? 0 : thisAt;
                                thisAt = thisAt > 1 ? 1: thisAt;
                                
                                this.jvrseffect = this.jvrseffect || effects.child.effect.call(this,thisAt);
                                this.jvrseffect(thisAt);
                            });
                        }else if($this.css('visibility') == 'hidden'){
                            $this.css('visibility','');
                            childs.each(function(){
                                if(this.jvrseffect){
                                    this.jvrseffect(0);
                                    this.jvrseffect = null;
                                }
                            });
                        } 
                    }
                },
                fade: {
                    action: function(pos, x){
                        var 
                            at = Math.abs(x - pos),
                            $this = $(this)
                        ;
                        if(at >= 1 || at <= -1){
                            $this.css('visibility','hidden');
                        }else{
                            $this.css({
                                visibility: '',
                                opacity: 1 - at
                            });
                        }
                    }
                },
                circle: {
                    action: function(pos, x){
                        var 
                            at = Math.abs(x - pos),
                            $this = $(this)
                        ;
                        $this.css({
                            visibility: '',
                            rotateZ: -(x - pos)/1.5,
                            scale:  1 - at /4,
                            zIndex: Math.floor((1 - at) * 10)
                        });
                    }
                },
                circle2: {
                    action: function(pos, x){
                        var 
                            at = Math.abs(x - pos),
                            $this = $(this)
                        ;
                        $this.css({
                            visibility: '',
                            rotateZ: -(x - pos)/1.5,
                            zIndex: Math.floor((1 - at) * 10)
                        });
                    }
                },
                slider: {
                    css3: true,
                    init: function(){
                        var left = 0;
                        items.each(function(){
                            var $this= $(this);
                            this.resHSlider = {left: left};
                            console.log(this);
                            left += $this.outerWidth();
                            this.resHSlider.right = left;
                        });
                    },
                    action: function (i, x) {
                        //console.log(this.resHSlider.left);
                        var
                            $this = $(this),
                            left = (x - i) * $this.width() + panelCenter - $this.width()/2
                        ;
                        $this.css('translateX',left);
                    }
                }
            },
            lastType,
            changeType = function(type){
                var df = function (i, x) {
                    var
                        $this = $(this),
                        left = (x - i) * slideWidth + panelCenter - slideCenter
                    ;
                    $this.css('left',left);
                }
                if(!self.css3('transform') && effects[type].css3) return df;
                
                lastType && lastType.destroy && lastType.destroy();
                lastType = effects[type];
                if(!lastType) return changeType('flow');
                lastType.init && lastType.init();
                if(!lastType.action) return df;
                return lastType.action;
            },
            setProps = changeType(options.type)
        ;
        // action
        var
            reset = function () { 
                panelWidth = ul.innerWidth();
                resbon.height(options.height)
                panelCenter = panelWidth / 2;
                
                panelHeight = 0;
                items.each(function(){
                    var thisHeight = $(this).outerHeight();
                    panelHeight = thisHeight > panelHeight?thisHeight:panelHeight;
                });
                resbon.height(panelHeight);
                var firstChild = items.first();
                slideWidth = firstChild.outerWidth();
                slideCenter = slideWidth / 2;
                
                loop = options.loop;
                to(curent);
				ul.children().eq(curent).addClass('active')
            },
            next = function () { direction = 'next'; glideTo(waitTo + 1); },
            prev = function () { direction = 'prev'; glideTo(waitTo - 1); },
            isNext,
            lastI = curent,
            to = function (i) {
                This.at = i
                if($this.triggerHandler('to',[i]) === false) return false;
                if(loop) {
                    var arr = Array.prototype;
                    if (isNext) {
                        while(This.at - items[0].toSlideIndex > items.length / 2){
                            var first = arr.shift.call(items);
                            arr.push.call(items, first);
                            first.toSlideIndex += items.length;
                        }
                    } else{
                        while(items[items.length - 1].toSlideIndex - i > items.length / 2){
                            var last = arr.pop.call(items);
                            arr.unshift.call(items, last);
                            last.toSlideIndex -= items.length;
                        }
                    }
                }else{
                    This.at = This.at > items.length - 1?items.length - 1 : This.at;
                    This.at = This.at < 0 ? 0 : This.at;
                }
                isNext = lastI < This.at;
                lastI = This.at;
                ;
                items.each(function () {
                    setProps.call(this,This.at * rtl, this.toSlideIndex* rtl);
                });
            },
            glideTo = function (i) {
                if (i === waitTo) return;
                if (!loop && (i > items.length - 1 || i < 0)) return;
                $this.trigger('animate',[(i%items.length + items.length) % items.length,i]);
                waitTo = i;
                $this.stop().animate({ at: i }, {
                    easing: options.easing,
                    duration: options.duration,
                    step: to,
                    complete: function () {
                        curent = i;
                        $this.trigger('animated',[(i%items.length + items.length) % items.length,i]);
                    }
                });
                 
                        
            },
            playTimeout,
            paused = false,
            play = function(){
                clearTimeout(playTimeout);
                playTimeout = setTimeout(function(){
                    if(selector.is('.paused')) return;
                    if($this.is(':animated') || selector.is(':hover')) return play();
                    direction == 'next'?next():prev();
                },options.auto);
            }
        ;
        selector
            .delegate('[data-togger=next]','click',next)
            .delegate('[data-togger=prev]','click',prev)
            .delegate('[data-togger=play]','click',function(){
                if(selector.is('paused')) This.play();
                else This.pause();
            })
            .delegate('[data-togger=to]','click',function(){
                This.glideTo(parseInt($(this).data('index')));
            });
        $.each(options.buttons,function(i,val){
            if(typeof val === 'string') options.buttons[i] = selector.find(val);
        });
        options.buttons.next.click(next);
        options.buttons.prev.click(prev);
        options.buttons.play.click(function(){
            if(selector.is('paused')) This.play();
            else This.pause();
        });
        $this.bind('animated',function(e,i){
            var 
                childs = ul.children(),
                lastActive = childs.filter('.active'),
                active = childs.eq(i)
            ;
            if(!active.is(lastActive)){
                $this.triggerHandler('changed');
                active.addClass('active');
                lastActive.removeClass('active')
            }
        });
        if(options.auto){
            play();
            $this.bind('animated',function(e,i,x){
                play();
            });
        }
        options.mousewheel && selector.mousewheel(function(e,d){ d>0?prev():next(); return false;});
        options.nav && (function(){
            var 
                nav = $('<div>',{'class':'nav'}),
                resbon = $('<div>',{'class':'resbon'}),
                ul = $('<ul>',{'class':'items icon'})
            ;
            selector.append(nav.append(resbon,ul));
            items.each(function(i){
                var slide = this;
                $('<li>').append($('<a>',{href: '#'}).append($('<span>',{text:i }))
                    .click(function () {
                        glideTo(slide.toSlideIndex);
                        return false 
                    }))
                    .appendTo(ul);
            });
            var btns = ul.children();
            $this.bind('animated',function(e,i){
                btns.filter('.active').removeClass('active');
                btns.eq(i).addClass('active');
            });
            options.navCfg.thumbs && ul.removeClass('icon').addClass('thumbs') && items.each(function(i){
                var thumb = $('<img>',{src:  $(this).data('thumb') || $(this).find('img:first').attr('src')});
                btns.eq(i).children('a').append(thumb)
            });
            options.navCfg.title && ul.addClass('title') && items.each(function(i){
                var title = $('<div>',{'class': 'title'}).append($(this).find('.title:first').html());
                btns.eq(i).children('a').append(title)
            });
            btns.eq(curent).addClass('active');
            if(!(options.navCfg.slide + '') || options.navCfg.slide == 'none') return;
            nav.addClass('slide ' + options.navCfg.slide);
            var navControl = new JVResponsiveSlide(nav,{nav:0,auto: 0,loop: 0,hotkey:0,type:options.navCfg.slide,active: options.active});
            $(navControl).bind('to',function(e,i){
                if(i < options.navCfg['break']) navControl.at = options.navCfg['break'];
                else if(i > btns.length - options.navCfg['break'] - 1) navControl.at =  btns.length - 1 - options.navCfg['break'];
            });
            $this.bind('animate',function(e,i){
                //if(i < options.navCfg['break']) i = options.navCfg['break'];
//                else if(i > btns.length - options.navCfg['break'] - 1) i =  btns.length - 1 - options.navCfg['break'];
                navControl.glideTo(i);
            });
        })();
        
        
        
        items.each(function(){
            var $this = $(this).addClass('waiting');
            $this.imagesLoaded(function(){
                $this.removeClass('waiting');
                reset();
            });
            var fn = self.initSlides[$this.data('type')];
            fn && fn.call(this,options,This);
        });
        reset();
        $(window).load(reset).resize(reset);
        if(options.touch){
            var startPos,di, isScroll;
            ul.swipe({
                swipeStatus:function(event, phase, dir, distance, duration, fingers)
                {
                    if(isScroll === undefined && (dir == 'up' || dir == 'down')){
                        ul.swipe("option", "allowPageScroll", 'auto');
                        isScroll = true;
                    }else if(isScroll === undefined &&(dir == 'left' || dir == 'right')){
                        isScroll = false;
                        ul.swipe("option", "allowPageScroll", 'none' );
                    }
                    if(phase == 'start'){
                        startPos = This.at;
                        $this.stop();           
                        di = 0;
                        isScroll = undefined;
                        ul.swipe("option", "allowPageScroll", 'auto' );
                    }else if(isScroll === false && phase == 'move'){
                        di = (dir == 'left'?1:-1) * rtl; 
                        var x = startPos + distance / slideWidth * di;
                        to(x);
                    }else if(phase !== 'move'){
                        if(di == 0 || duration > 500 && panelWidth/distance > 2){
                            di = waitTo;
                            waitTo = null;
                        }
                        glideTo(waitTo + di);
                        
                        ul.swipe("option", "allowPageScroll", 'auto');
                        isScroll = undefined;
                    }
                },   
                threshold:200, 
                allowPageScroll: 'auto',
                fingers:1,
                fallbackToMouseEvents: options.drag,
				moveIn: 'html'
            });
        }
        
        if(options.hotkey){
            selector.hotkey('left',function(){
                This.prev();
                return false;
            }).hotkey('right',function(){
                This.next();
                return false;
            });
        }
        $.extend(this, {
            next: next,
            prev: prev,
            play: function(){
                if(!options.auto) return;
                selector.removeClass('paused');
                play();
            },
            pause: function(){
                selector.addClass('paused');
            },
            auto: 1000,
            to: to,
            glideTo: function(i){
                i = i % items.length;
                var 
                    curent = this.at % items.length,
                    loopCount = (this.at - curent) / items.length
                ;
                if(loop){
                    curent = curent < 0 ? curent + items.length: curent;
                    if(curent - i > items.length/2) loopCount ++;
                    else if(i - curent > items.length/2) loopCount --;
                }
                glideTo(loopCount * items.length + i);
            },
            reset: reset,
            type: changeType
        });
    }, {
        options: {
            duration: 300,
            active: 1,
            hotkey: true,
            loop: true,
            mousewheel: true,
            buttons: {
                next: '.next',
                prev: '.prev',
                play: '.play'
            },
            auto: 3000,
            easing: 'linear',
            type : 'slide',
            drag: false,
            navCfg:{}
        },
        css3: (function () {
            var div = document.createElement('div'),
               vendors = 'Khtml Ms O Moz Webkit'.split(' '),
               len = vendors.length;

            return function (prop) {
                if (prop in div.style) return prop;

                prop = prop.replace(/^[a-z]/, function (val) {
                    return val.toUpperCase();
                });
                len = vendors.length;
                while (len--) {
                    var cssProp = vendors[len] + prop;
                    if ( cssProp in div.style)  return cssProp;
                }
                return false;
            };
        })(),
        initSlides: {
            youtube: function(ops,This){
                var self = arguments.callee;
                if(!self.addScript){
                    self.addScript = true;
                    $('<script>',{'src': 'https://www.youtube.com/iframe_api'}).appendTo('head');
                    self.count = 0;
                }
                var 
                    $this = $(this),
                    params = $this.data('params'), player,
                    init = false, pPanel, selector = $this.parents('.jvresslide'),
                    btnPlay = $('<a>',{href:"javascript:void('Play')",'class':'jtbtnplay'}).append($('<span>',{text: 'Play'}))
                        .click(function(){
                            if(init){
                                player.playVideo();
                                return;
                            }
                            //if(!window.YT || !YT.Player) return;
                            init = true;
                            btnPlay.addClass('loading');
                            var pid = 'ytp' + self.count ++;
                            var panel = $('<iframe>',{
                                id: pid,
                                src: "https://www.youtube.com/embed/"+ params.id +"?enablejsapi=1&autoplay=1",
                                width: '100%',
                                height: '100%',
                                frameborder: 0
                            });
                            pPanel = $('<div>',{'class': 'ytplayer'}).append(panel).addClass('playing');
                            $this.parent().parent().append(pPanel);
                            var timeOut,lastState;
                            new YT.Player(pid, {
                                  events: {
                                    onReady: function(e){
                                        player = e.target;
                                        btnPlay.removeClass('loading');
                                    },
                                    onError: function(){
                                        setTimeout(function(){ pPanel.removeClass('playing');},1000);
                                    },
                                    onYouTubePlayerReady: function(){
                                        console.log(arguments);
                                    },
                                    onStateChange: function(e){
                                        switch(e.data){
                                            case 1: 
                                                This.pause();
                                                pPanel.addClass('playing');
                                                break;
                                            case 2: 
                                                if(lastState == 2 || lastState == 3){
                                                    clearTimeout(timeOut);
                                                    break;
                                                }
                                                timeOut = setTimeout(function(){
                                                    isSeek = false;
                                                    This.play();
                                                    pPanel.removeClass('playing');
                                                },300);
                                                break; 
                                            case 3:
                                                break;
                                            case 0:
                                            case 5:
                                                This.play();
                                                pPanel.removeClass('playing');
                                                break;
                                        }
                                        lastState = e.data;
                                    }
                                  }
                            });
                        })
                ;
                $this.addClass('youtube').append(btnPlay);
            }
        }
    });
})(jQuery);
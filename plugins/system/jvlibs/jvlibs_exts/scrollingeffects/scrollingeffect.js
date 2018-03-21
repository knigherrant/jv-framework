var JVScrolling = (function($){
    return $.extend(function(ops){
        var
            self = arguments.callee,
            This = this,
            $this = $(this),
            $doc = $(document),
            $win = $(window)
        ;
        ops = $.extend({},self.options,ops);
        var
            boxs, interval, scrolled = true,
            start = function(){ 
                boxs = $(ops.selector);
                if(!boxs.length) return;
                if (disabled()) {
                    return resetStyle();
                } else {
                    boxs.each(function(){
                        applyStyle($(this), true);
                    });
                    $(window).bind('scroll resize',scrollHandler);
                    return interval = setInterval(scrollCallback, 50);
                }
            },
            stop = function(){
                $(window).unbind('scroll resize',scrollHandler);
                return clearInterval(interval);
            },
            show = function(box) {
                applyStyle(box);
                effect = box.data('effect') || ops.effect
                box.addClass(effect);
            },
            applyStyle = function (box, hidden) {
                var 
                    delay = (box.data('delay') || ops.delay) + 'ms',
                    duration = (box.data('duration') || ops.duration) + 'ms',
                    iteration = (box.data('iteration') || ops.iteration)
                ;
                //box.addClass(effect);
                return animate((function (_this) {
                    return function () {
                        return customStyle(box, hidden, duration, delay, iteration);
                    };
                })(this));
            },
            animate = (function () {
                if ('requestAnimationFrame' in window) {
                    return function (callback) {
                        return window.requestAnimationFrame(callback);
                    };
                } else {
                    return function (callback) {
                        return callback();
                    };
                }
            })(),
            resetStyle = function () {
                $.each(boxes,function(){
                    this.setAttribute('style', 'visibility: visible;');
                });
            },
            customStyle = function (box, hidden, duration, delay, iteration) {
                box.css({
                    'visibility': hidden ? 'hidden' : 'visible',
                    'animation-duration': duration,
                    'animation-delay': delay,
                    'animation-iteration-count': iteration
                });
            },
            isVisible = function(box) {
                if(!box.is(':visible')) return false;
                var 
                    offset = box.data('offset') || ops.offset,
                    viewTop = window.pageYOffset,
                    viewBottom = viewTop + $win.height() - offset,
                    top = box.offset().top,
                    bottom = top + box[0].clientHeight
                ;
                return top >= viewTop&& bottom <= viewBottom ;
            },
            disabled = function() {
                return !ops.mobile && this.util().isMobile(navigator.userAgent);
            },
            scrollHandler = function(){scrolled = true;},
            scrollCallback = function () {
                var box;
                if (scrolled) {
                    scrolled = false;
                    boxs = (function(){
                        var clone = $();
                        boxs.each(function(i){
                            var box = $(this);
                            if(isVisible(box)){
                                show(box);
                                return;
                            }
                            clone.push(this);
                        });
                        return clone;
                    })();
                    
                    if (!boxs.length) {
                        return stop();
                    }
                }
            }
        ;
        
        start();
        $.extend(this,{
            
        });
    },{
        options:{
            selector: '.jvscrolling',
            mobile: true,
            duration: 500,
            offset: 0,
            delay: 0,
            iteration: 0,
            effect: 'ease'
        }
    });
})(jQuery);
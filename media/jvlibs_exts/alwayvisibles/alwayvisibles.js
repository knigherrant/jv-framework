var JVAlwayVisibles = (function($){
    return $.extend(function(els,ops){
        var $this = $(this), self = arguments.callee, This = this;
        els = els.append?els:$(els);
        if(!els.length) return;
        ops = $.extend({},self.options,ops);
        var visibleAt = $(window);
        
        var
            hideWith = $(ops.hideWith).first(),
            csss = ['position','top','width','height'],
            waitTo = function(fn,calback,delay){
                delay = delay || 100;
                var timeOut;
                (function(){
                    if(fn()) return calback();
                    timeOut = setTimeout(arguments.callee,delay);
                })();
                return{
                    clear: function(){
                        clearTimeout()
                    }
                }
            },
            refresh = function(){
                els.each(function(){
                    var 
                        $this = $(this),
                        data = $this.data().vsbs
                    ;
                    if(data){
                        data.mask && data.mask.remove();
                        $this.attr('style',data.lastStyle)
                    }
                });
                
                els.sort(function(a,b){ 
                    var $a = $(a);
                    if($a.is(':hidden')) return;
                    var $b = $(b);
                    return $a.offset().top > $b.offset().top;
                });
                var margins = {
                    x: ops.margin,
                    y: ops.margin
                }
                els.each(function(){
                    var $this = $(this);
                    if($this.is(':hidden')) return waitTo(function(){return $this.is(':visible');},refresh,1000);
                    var
                        data = $this.data().vsbs = {
                            offset: $this.offset(),
                            width: $this.width(),
                            height: $this.height(),
                            margin: $.extend({},margins)
                        },
                        mask = data.mask = $this.clone().empty().css({height: data.height});
                    ;
                    if(!ops.hideNext){
                        margins.x += data.width;
                        margins.y += data.height;
                    }
                    
                });
                
                
                if(ops.hideWith){
                    var data = hideWith.data().vsbsh = {
                        offset: hideWith.offset(),
                        width: hideWith.width(),
                        height: hideWith.height()
                    }
                }
                visibleAt.trigger('scroll');
            }
        ;
        $(window).load(refresh);
        visibleAt.scroll(function(){
            var sTop = visibleAt.scrollTop();
            els.each(function(i){
                var
                    $this = $(this),
                    data = $this.data().vsbs
                ;
                if(!data) return 0;
                if(sTop + data.margin.y > data.offset.top){
                    if(!data.fixed){
                        data.fixed = true;
                        data.lastCss = {};
                        $this.before(data.mask);
                        data.lastStyle = $this.attr('style') || '';
                        $this.css({position: 'fixed',top: data.margin.y ,width: $this.width(),height: $this.height()});
                    }else{
                        var toTop;
                        if(ops.hideNext){
                            var next = els[i+1];
                            if(next){
                                next = $(next);
                                var 
                                    dtNext = next.data().vsbs
                                ;
                                toTop = dtNext.offset.top - sTop - data.height
                                toTop = toTop > data.margin.y?data.margin.y:toTop;
                            }
                        }
                        
                        if(ops.hideWith){
                            var 
                                vsbsh = hideWith.data().vsbsh,
                                isHiden = vsbsh.offset.top + vsbsh.height - sTop - data.height
                            ;
                            isHiden = isHiden > data.margin.y?data.margin.y:isHiden;
                            toTop = toTop || data.margin.y;
                            toTop = toTop < isHiden ? toTop : isHiden ;
                            console.clear();
                            console.log(toTop);
                        }
                        if(toTop != undefined) $this.css('top',toTop);
                    }
                }else{
                    if(!data.fixed) return;
                    data.fixed = false;
                    data.mask.remove();
                    $this.attr('style',data.lastStyle);
                }
            });
        }).resize(function(){
            refresh();
        });
        refresh();
        
        
        $.extend(this,{
            refresh: refresh
        });
    },{
        options:{
            margin: 0,
            hideNext: true,
            hideWith: false
        }
    });
})(jQuery);
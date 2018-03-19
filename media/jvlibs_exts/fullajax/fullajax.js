var JVFullAjax = (function($){
    var fullajax = $.extend(function(selector,ops){
        var 
            self = arguments.callee,
            This = this,
            body = $(document),
            applyto, resultHtml, getFrom
        ;
        ops = $.extend({},self.options,ops);
        ops.deny = ops.deny.join(',');
		ops.alow = ops.alow.join(',');
		
        var
            thisSite = location.href.split('//')[1].split('/')[0],
            isThisSite = function(first,href){
                return href.indexOf(first) !== 0 || href.replace(first,'').indexOf(thisSite) === 0;
            },
            isBreak = function(href){
                return !href || this[0].onclick ||
                    this.is('[data-toggle],[href^=#],[href^=javascript:],[target=_blank]') || 
                    !(isThisSite('http://',href) && isThisSite('//',href) && isThisSite('https://',href));
            },
            exec = function(href,data,post){
                $.extend(JVAjaxCall.options,{
                    href: href,
                    post: post
                }); 
                data = $.extend({jvfullajax:1},data);
				var overlay = $('<div>',{'class':'fullajax-overlay'}).css({
					position: 'absolute',
					background: 'black',
					opacity: 0.7,
					display: 'none',
					zIndex: 999999,
					width: applyto.outerWidth(),
					height: applyto.outerHeight()
				}).append($('<div>',{'class':'loading'}));
				applyto.after(overlay);
				overlay.css(applyto.position()).fadeIn(300);
                JVAjaxCall.call(data,function(rs){
                    state = setState(applyto);
                    History.pushState({},resultHtml.filter('title:first').text(),href);
                   
                    ops.post = false;
					var scripts = [],scriptText = [];
                    var fn = function(){
                        var 
                            $this = $(this),
                            src = $this.attr('src')
                        ;
                        if(src){
                            scripts.push({src: src, cache: true});
                        }else{
                            scriptText.push(this.innerHTML);
                        }
                        $this.remove();
                    };
					getFrom.filter('script').each(fn);
                    getFrom.find('script').each(fn);
                    state.cache.append(applyto.children());
                    var content = getFrom.children();
                    applyto.append(content);
                    content.data('historystate',History.getState());                    
					JVAjaxCall.assign({scripts: scripts, script: scriptText});
					isCall = false;
					overlay.fadeOut(300,function(){overlay.remove();})
                });
				isCall = true;
            },
			regsNoCache = {}
        ;
		$.each(ops.nocache,function(i,v){
			var reg = false;
			try{
				reg = new RegExp(v, "i");
			}catch(e){}
			regsNoCache[v] = reg
		});
        $(JVAjaxCall).bind('ajaxsuccess',function(e,rs){
			$.each(ops.nocache,function(i,v){
				$.each(rs.scripts,function(){
					if(this.src.indexOf(v) > -1 || !!regsNoCache[v] && this.src.match(regsNoCache[v])){
						this.cache = false;
						return false;
					}
				});
			});
            resultHtml = $(rs.customs.jvfullajax);
            getFrom = resultHtml.find(ops.getfrom);
            return !!getFrom.length;
        });
        
        body.on('click',selector + ' a',function(e){
			var $this = $(this);
            applyto = $(selector + ' ' + ops.applyto);
            if(!applyto.length) return;
            if($this.is(ops.deny)) return;
            var href = $this.attr('href');
            if(isBreak.call($this,href)) return;
			var data = $this.data().jvfullajax = $this.data().jvfullajax || {};
			if(data.isBreak || data.lastHit > e.timeStamp - 200) return false;
			data.lastHit = e.timeStamp;
            exec(href);
            return false;
        });
		var handleTuchEnd = function(e){
			$(this).trigger('click');
		}		
		body.on('touchstart',selector + ' a',function(e){
			var $this = $(this)
				.unbind('touchend',handleTuchEnd)
				.one('touchend',handleTuchEnd)
				.one('touchmove',function(){ 
					$this.unbind('touchend',handleTuchEnd);
				});
			setTimeout(function(){
				$this.unbind('touchend',handleTuchEnd);
			},100);
        });
        body.on('submit',selector + ' form',function(e){
            applyto = $(selector + ' ' + ops.applyto);
            if(!applyto.length) return;
            
            var $this = $(this);
            if(ops.alow && !$this.is(ops.alow)) return;
            if(ops.deny && $this.is(ops.deny)) return;
            var href = $this.attr('action');
            if(isBreak.call($this,href)) return;
			var data = $this.data().jvfullajax = $this.data().jvfullajax || {};
			if(data.isBreak || data.lastHit > e.timeStamp - 500) return false;
			data.lastHit = e.timeStamp;
			
            var data = {};
            $.each($this.serializeArray(),function(k,v){
                data[this.name] = this.value;
            });
            exec(href,data,$this.attr('method').toLowerCase() == 'post');
            return false;
        });
    },{
        options:{
            getfrom: 'body',
            applyto: 'body',
            deny: [],
            alow: [],
			nocache: []
        }
    });
    
   var 
        historyCache = {},
        setState = function(obj){
            var content = obj.children();
            var thisState = content.data('historystate') || History.getState();
            
            historyCache[thisState.id] = {
                content: obj.children(),
                apply: obj,
                cache: $('<div>'),
                id: thisState.id
            };
            content.data('fullajaxcache',historyCache[thisState.id]);
            return historyCache[thisState.id];
        },
		isCall = false;
   ;
    $(window).bind('statechange',function(){
        var 
            thisState = History.getState(),
            obj = historyCache[thisState.id]
        ;
        if(!obj) return !isCall && location.reload();
        state = setState(obj.apply);
        state.cache.append(obj.apply.children());
        obj.apply.append(obj.content);
    });
    
    return function(args){
        $(function(){
            $.each(args,function(){
                new fullajax(this.assign,this);
            });
        });
    }
})(jQuery);
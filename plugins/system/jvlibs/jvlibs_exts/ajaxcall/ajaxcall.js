var JVAjaxCall = (function($){
    
    var 
        timeOut,
        ops = {
            delay: 30,
            href: location.href,
            debug: false,
            callback: false
        },
        waitModals = [],
        jaxcall = {},
        $jax = $(jaxcall),
        params = {},
        callAjax = function(data,fn){
            clearTimeout(timeOut);
            if(!data) return callAjax({},fn);
            
            if(typeof data === 'function') return callAjax({},data);
            else if(!fn) return callAjax(data,function(){});
            
            data = $.extend({ jvjax: 1},params,data);
            if($jax.triggerHandler('ajaxstart',[data]) === false) return false;
            var success = function(rs){
                if($jax.triggerHandler('ajaxsuccess',[rs]) === false) return false;
                jaxcall.assign(rs);
                fn(rs.customs);
            };
			$.isReady = false;
            if(ops.post) var xhr = $.ajax({
                type: 'POST',
                dataType: 'json',
                data: data,
                success: success
            });
            else var xhr = $.getJSON(ops.href,data,success);
            xhr.always(function() {
                clearTimeout(timeOut);
                if(ops.delay) timeOut = setTimeout(callAjax,ops.delay * 1000);
            });
            return xhr;
        },
        shiftObject = function(obj){
            for(var x in obj){
                var item = {k:x,v:obj[x]};
                delete obj[x];
                return item;
            }
        },
        head = $('head'),
        styleLoaded = {},
        loadStyles = function(styles){
            if(!styles || !styles.length) return;
            $.each(styles,function(k,v){
				if(!v) return;
                if($.type(v) == 'string'){
                    head.append($('<style>',{html:v})[0].outerHTML);
                }else if(!v.cache || !styleLoaded[v.src]){
                    head.append($('<link/>',{type:"text/css", rel:"stylesheet", href: v.src}));
                    styleLoaded[v.src] = true;
                } 
            });
        },
        scriptLoaded = {},
        scriptLoading = [],
		timeout,
        loadScripts = function(){
            if(!scriptLoading.length){
				clearTimeout(timeout);
				timeout = setTimeout(function(){
					$jax.triggerHandler('scriptloaded');
				},10);
				return;
			}
            var script = scriptLoading.shift();
            if(script.cache && scriptLoaded[script.src]) return loadScripts();
            $.getScript(script.src).done(function(){
                scriptLoaded[script.src] = true;
                loadScripts();
            }).fail(function(){
				loadScripts();
			});
        },
        scriptEvaling = [],
        evalScripts = function(){
            if(!scriptEvaling.length) {
				clearTimeout(timeout);
				timeout = setTimeout(function(){
					$jax.triggerHandler('scriptsuccess');
				},10);
				return;
			}
            var script = scriptEvaling.shift();
            try{
				eval.call(window,script);
                evalScripts();
            }catch(e){
                switch(ops.debug){
                    case 'debug': throw e;
                        break;
                    case 'notice': console.error(e);
                        break;
                    case 'log': console.log(e);
                }
                evalScripts();
            }
        },
        countModals = 0,
        createModal = function(obj){
            var 
                label = $('<h3>'),
                btnClose = $('<button>',{type: 'button', 'class': 'close', 'data-dismiss':'modal', text:'x'}),
                head = $('<div>',{'class': 'modal-header'}).append(label),
                body = $('<div>',{'class':'modal-body dialog-findscript'}),
                footer = $('<div>',{'class': 'modal-footer'}),
                modal = $('<div>',{'class':"modal hide fade",id: obj.id}).append(head,btnClose,body,footer).appendTo('body'),
                set = function(obj){
                    obj.title?label.html(obj.title):head.hide();
                    body.empty().append(obj.content);
                    if(obj.buttons === false){
                        footer.hide();
                    }else{
                        obj.buttons = obj.buttons || [{
                            inner:['text:Close'],
                            callback: function(){ 
                                modal.modal('hide')
                            }}
                        ];
                        obj.redirect && obj.buttons.push({
                            inner: ['text:Redirect'],
                            callback: function(){
                                location.href = obj.redirect;
                            }
                        });
                        footer.show().empty();
                        $.each(obj.buttons,function(k,This){
                            if($.type(This.callback) == 'string') eval('This.callback ='+ This.callback);
                            var btn = $('<a>',{href:'#','class':'btn'}).click(function(){
                                This.callback.call(modal);
                                return false;
                            });
                            this.inner = $.isArray(this.inner)?this.inner:[this.inner];
                            $.each(this.inner,function(k,v){
                                var p = v.split(/:/);
                                if(p[0] == 'icon') btn.append($('<i>',{'class': p[1]}));
                                else if(p[0] == 'text')  btn.append(p[1]);
                                else btn.append(v); 
                            });
                            footer.append(btn);
                        });
                    }
                    modal.modal({backdrop: true, keyboard: true, show: false});
                    return modal;
                }
            ;
            modal.setProps = set;
            return set(obj);
        },
        getModal = function(obj){
            var ms = getModal[obj.type] = getModal[obj.type] || $.extend([],{count: 0});
            for(var x = 0; x < ms.length; x++){
                var m = ms[x];
                if(m.hidden) return m.set(obj);
            }
            obj.id = 'jaxcall_' + obj.type + '_' + ms.count ++;
            var modal = createModal(obj);

            var mObj = {modal: modal, set: modal.setProps};
            modal.on('hidden',function(){ 
                getModal.curent = null;
                mObj.hidden = true;
                countModals --;
            }).on('show',function(){
                getModal.curent = mObj;
                mObj.hidden = false;
                countModals ++;
            });
            ms.push(mObj);
            return modal;
        },
        showMsgs = function(){
            if(!waitModals.length) return;
            if(getModal.curent) return;
            var modal = waitModals.shift();
            modal.modal('show');
            modal.one('hidden',function(){
                showMsgs();
            });
        }
    ;
    $(function(){
		setTimeout(function(){
			$('script[src]').each(function(){ scriptLoaded[$(this).attr('src')] = true; });
			$('link[href]').each(function(){ styleLoaded[$(this).attr('href')] = true; });
		},10);
    });
    $jax.bind('scriptloaded',function(){setTimeout(evalScripts,0);});
	
	//overide com_joomsocial and Moototls
	
    (function(){
        var handle = function(){
            if(!window.joms) return;
            $jax.unbind('scriptsuccess',handle);
			if(joms.jvajaxcall) return;
			$jax.bind('ajaxstart',function(){joms.jQuery.isReady = false;});
			$jax.bind('scriptsuccess',function(){
				joms.jQuery.isReady = true;
				joms.jQuery(document).ready();
				setTimeout(function(){
					joms.jQuery(window).load();
				},100);
			});
        }
        $jax.bind('scriptsuccess',handle);
		$(handle);
    })();
	//override Mootools
    (function(){// return;
        var handle = function(){
            if(!window.MooTools) return;
			$doc = $(document);
            $jax.unbind('scriptsuccess',handle);
            setTimeout(function(){
				$.extend({
					domready: {onAdd: function(a) {
						var This = this;
						$doc.ready(function(){
							a.call(This);
						});
					}}
				});
				
				$jax.bind('scriptsuccess',function(){
					setTimeout(function(){
						window.fireEvent('load');
					},100)
				});
            },100);
        }
        $jax.bind('scriptsuccess',handle);
        $(handle);
    })();
	
	
    return $.extend(jaxcall,{
        params: params,
        options: ops,
        setLoaded: function(ops){
            ops = ops ||{};
            $.extend(scriptLoaded,ops.scripts);
            $.extend(styleLoaded,ops.styles);
        },
        bind: function(name, handle){ $jax.bind(name, handle) },
        unbind: function(name, handle){$jax.unbind(name, handle) },
        call: callAjax,
        modal: createModal,
        addScript: function(scripts){
            if(!scripts) return;
            if(!$.isArray(scripts)) return this.addScript([scripts]);
            var isStop = !scriptLoading.length;
            $.each(scripts,function(){
                scriptLoading.push(this);
            });
            isStop && loadScripts();
        },
        addScriptEval: function(scripts){
            if(!scripts) return;
            if(!$.isArray(scripts)) return this.addScriptEval([scripts]);
            $.each(scripts,function(i,text){
                scriptEvaling.push(text);
            });
        },
        assign: function(rs){
            loadStyles(rs.styles);
            $jax.one('scriptsuccess',function(e){
                if(rs.msgs) $.each(rs.msgs,function(){
                    waitModals.push(getModal(this));
                });
                setTimeout(function(){
					$.isReady = true;
                    $(document).ready();
					setTimeout(function(){
						$(window).load();
					},100);
                    showMsgs();
                },0);
            });
            $.isReady = false;
            this.addScriptEval(rs.script);
            this.addScript(rs.scripts);
            rs.events && $.each(rs.events,function(key){
                $jax.triggerHandler(key,[this]);
            });
            $jax.triggerHandler('success',[rs.customs]);
            $.extend(ops,rs.options);
            clearTimeout(timeOut);
            if(ops.delay) timeOut = setTimeout(callAjax,ops.delay * 1000);
        }
    }); 
})(jQuery);
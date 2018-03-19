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
            $jax.triggerHandler('ajaxstart',[data]);
            return $.getJSON(ops.href,data,function(rs){
                $jax.triggerHandler('ajaxsuccess',[rs]);
                jaxcall.assign(rs);
                fn(rs.customs);
            }).always(function() {
                clearTimeout(timeOut);
                if(ops.delay) timeOut = setTimeout(callAjax,ops.delay * 1000);
            });
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
                if($.type(v) == 'string'){
                    head.append($('<style>',{html:v})[0].outerHTML);
                }else if(!v.cache || !styleLoaded[v.src]){
                    head.append($('<link/>',{type:"text/css", rel:"stylesheet", href: v.src}));
                    styleLoaded[v.src] = true;
                } 
            });
        },
        scriptLoaded = {},
        loadScripts = function(scripts){
            if(!scripts || !scripts.length) return $jax.triggerHandler('scriptloaded');
            var script = scripts.shift();
            if(script.cache && scriptLoaded[script.src]) return loadScripts(scripts);
            $.getScript(script.src, function(){
                scriptLoaded[script.src] = true;
                loadScripts(scripts);
            });
        },
        evalScripts = function(scripts){
            if(!scripts || !scripts.length) return $jax.triggerHandler('scriptsuccess');
            var script = scripts.shift();
            try{
                eval(script);
                evalScripts(scripts);
            }catch(e){
                switch(ops.debug){
                    case 'debug': throw e;
                        break;
                    case 'notice': console.error(e);
                        break;
                    case 'log': console.log(e);
                }
                evalScripts(scripts);
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
    $(window).load(function(){
        $('script[src]').each(function(){ scriptLoaded[$(this).attr('src')] = true; });
        $('link[href]').each(function(){ styleLoaded[$(this).attr('herf')] = true; });
        $.fn.ready = function(fn){
            return this.one('ready',fn);
        }
    });
    
    
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
        assign: function(rs){
            loadStyles(rs.styles);
            $jax.one('scriptloaded',function(){
                $jax.one('scriptsuccess',function(){
                    if(rs.msgs) $.each(rs.msgs,function(){
                        waitModals.push(getModal(this));
                    });
                    setTimeout(function(){
                        $(document).trigger('ready');
                        showMsgs();
                    },0);
                });
                evalScripts(rs.script);
            });
            loadScripts(rs.scripts);
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
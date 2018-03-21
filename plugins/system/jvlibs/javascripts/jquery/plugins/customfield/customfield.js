window.CustomField = window.CustomField || window.jQuery ? (function ($) {   
    var
        counteditor = 0,
        custom = function (config) {
            if ($.type(config) !== 'object') return false;
            if (config.use) {
                var 
                    use = fieldLoops[config.use],
                    item = use.item
                ;
                config = $.extend({},use, config);
                use.item = item;
                config.item = item;
            }
            if (config.loop) {
                fieldLoops[config.loop] = config;
                delete config.loop;
            }
            if (!config.field) {
                config = { field: 'panel', item: config }
            }
            var fn = custom[config.field];
            if (!fn) {
                console.log("not support field " + config.field);
                return false;
            };
            //config.valid = config.valid || 
            
            var field = fn.call(config).addClass('ct');
            var fData = field.data();
            fData.config = config;
            if(fData.data){
                var fn = fData.data;
                fData.data = function(val){
                    if(val != undefined) return fn(val);
                    val = fn();
                    state(val).field = config.field;
                    return val;
                }
            }
            field.bind(config.events);
            field.triggerHandler('ct_created',[field]);
            return field;
        },
        parseDataType = function(type,value){
            return parseDataType[type](value);
        },
        formfield = function () {
            var 
                This = this,
                label = addAttrs.call(this, $('<label>')),
                field = $('<' + this.field +(this.pProps||'') + '/>'),
                datatype = this.datatype || (this.value !== undefined? typeof this.value:'string')
            ;
            if(this.label) label.append($('<span>').text(this.label));
            else label.addClass('nolabel');
            label.append(field);
            label = (this.type || '').toLowerCase() == 'hidden' ? field : label;

            // data function            
            //field.bind(this.events);
            this.value != undefined && field.val(this.value);
            var valid;
            if(this.validates) valid = new validate(field, $.extend({},this.validates));
            $.extend(label.data(),{
                validate: function(){
                    if(valid){
                        valid.check();
                        var errors = valid.countErrors();
                        if(errors) label.triggerHandler('ct_errors',valid.getMsg());
                        return errors;
                    }
                    return 0;
                },
                data: function (val) {
                    if (val != undefined) {
                        if(val === true) val = 1;
                        else if(val === false) val = 0;
                        field.val(val);
                        label.data().lastdata = val;
                        return;
                    }
                    return parseDataType(datatype, field.val());
                },
                clear: function(){
                    field.val(This.value != undefined?This.value:'');
                    field.change();
                }
            });
            if(this.title || this.tooltip){
				field.tooltip($.extend({
					html: true,
					title: this.title,
					placement: 'top'
				},this.tooltip));
			}
            return label;
        },
        countTab = 0,
        attrs = {
            'style': 'style',
            'class': 'class',
            'id': 'id',
            'alt':'alt',
            'rel': 'rel'
        },
        fieldLoops = {},
        eventLoops = {},
        addAttrs = function (item) {
            var This = this;
            $.each(attrs, function (index, val) {
                if (This[val]) item.attr(index, This[val]);
            });
            return item;
        },
        expandToDialog = function(to,drag){
            var 
                field = this,
                isOpen = false,
                modal
            ;
            to.append($('<a>').attr({'href': 'javascript:void(0)','class': 'ct-btn-expand btn btn-mini'})
            .append($('<span>').addClass('icon-fullscreen'))
            .click(function(){
                if(isOpen){
                    modal.modal('hide');
                }else{
                    isOpen = true;
                    var parent = field.parent();
                    modal = $('<div>',{'class':"modal hide fade ct-modal"}).append(field).modal({backdrop: false});
                    modal.bind('hidden',function(){
                        isOpen = false;
                        parent.append(field);
                        modal.draggable('destroy').remove();
                    }).draggable({
                        handle:drag,
                        containment: 'parent',
                        start: function(){
                            modal.removeClass('fade');
                        },
                        stop: function(){
                            modal.addClass('fade');
                        }
                    });
                }
                
                return false;
            }));
        },
        setToggle = function(toggle,click,isToggle){
            if(isToggle == undefined) return;
            isToggle?toggle.show():toggle.hide();
            click.click(function(e){
                toggle.slideToggle(300);
            });
            this.bind('ct_errors',function(){
                if(toggle.css('display') == 'none') {
                    toggle.show();
                }
            });
        },
        reSetToggle = function(toggle, data, isToggle){
            isToggle == undefined || state(data).toggle == undefined || state(data).toggle?toggle.show():toggle.hide();
        },
        state = function(data){
            return data['@state'] = data['@state'] || {};
        }
        
    ;
    $.extend(parseDataType,{
        'boolean': function(val){
            return !!parseInt(val);
        },
        'number':function(val){
            return parseFloat(val) || 0;
        },
        'string': function(val){
            return ""+val;
        }
    });
    
    var validate = $.extend(function(el,ops){
        el = $(el);
        if(el.length == 0) return;
        if(el.length > 1){
            var vs = [];
            el.each(function(){
                vs.push(new arguments.callee(this,ops));
            });
            return vs;
        }
        var hasValid = el.data().validate;
        if(hasValid) return hasValid.options(ops || {});
        if(!ops.rules) ops = {rules: ops};
        var 
            self = arguments.callee,
            This = this,
            $this = $(this),
            rules = {},
            errorTypes = [],
            errorsMsgs = [],
            setRule = $.extend(function(name,val){
                if(setRule[name]) rules[name] = setRule[name](val);
                else{
                    if($.type(val) == 'object') rules[name] = val;
                    else rules[name] = {val: val};
                } 
                rules[name]['class'] = rules[name]['class'] || self.classRules[name];
            },{
                reg: function(val){ return val.reg? reg:{reg: val}},
                equal: function(val){return val.callback?val:{equal: val } }
            }),
            getMsg = $.extend(function(name){
                var msg;
                if(getMsg[name]) msg = getMsg[name](name);
                else{
                    msg = rules[name].msg || self.msgs[name];
                }
                msg = self.formatMsg(msg,rules[name]);
                return msg;
            },{}),
            getValue = $.extend(function(val,call){
                if($.type(val) == 'function') return val.call(call||This);
                return val;
            },{}),
            check = {
                required: function(){ return $.trim(el.val()).length > 0},
                minlength: function(){ return el.val() == '' || $.trim(el.val()).length >= this.val },
                maxlength: function(){ return el.val() == '' || $.trim(el.val()).length <= this.val},
                rangelength: function(){var val = $.trim(el.val()); return el.val() == '' || val.length <= this.max && val.length >= this.min},
                min: function(){return el.val() == '' || parseFloat($.trim(el.val())) >= this.val},
                max: function(){return el.val() == '' || parseFloat($.trim(el.val())) <= this.val},
                range: function(){var val = parseFloat($.trim(el.val())); return el.val() == '' || val <= this.max && val >= this.min},
                email: function(){return el.val() == '' || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(el.val())},
                url: function(){return el.val() == '' || /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(el.val())},
                date: function(){return el.val() == '' || !/Invalid|NaN/.test(new Date(el.val()).toString())},
                number: function(){return el.val() == '' || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(el.val());},
                digits: function(){ return el.val() == '' || /^\d+$/.test(el.val())},
                creditcard: function(){
                    var value = el.val();
                    if(value == '') return true;
                    if ( /[^0-9 \-]+/.test(value) ) {
                        return false;
                    }
                    var nCheck = 0,
                        nDigit = 0,
                        bEven = false;

                    value = value.replace(/\D/g, "");

                    for (var n = value.length - 1; n >= 0; n--) {
                        var cDigit = value.charAt(n);
                        nDigit = parseInt(cDigit, 10);
                        if ( bEven ) {
                            if ( (nDigit *= 2) > 9 ) {
                                nDigit -= 9;
                            }
                        }
                        nCheck += nDigit;
                        bEven = !bEven;
                    }

                    return (nCheck % 10) === 0;
                },
                equal: function(){return el.val() == getValue(this.equal)},
                reg: function(){
                    return this.reg.test(el.val())
                }
            }
        ;
        ops = $.extend({},self.options,ops);
        
        var
            msgAction = $.type(ops.msgAction) == 'object'?ops.msgAction:self.msgActions[ops.msgAction],
            assign = getValue(ops.assign,el),
            initEvent = function(fn){
                var nfn = function(){
                    clearTimeout(nfn.timeout);
                    var This = this;
                    nfn.timeout = setTimeout(function(){
                        fn.apply(This,arguments);
                    },ops.delay);
                }
                return nfn;
            },
            isSuccess
        ;
        
        el.bind(ops.checkOn,initEvent(function(){
            This.check();
        })).bind(ops.showStateOn,initEvent(function(){
            This.showState();
        })).bind(ops.hideStateOn,initEvent(function(){
            This.hideState();
        })).bind(ops.showMsgOn,initEvent(function(){
            This.showMsg();
        })).bind(ops.hideMsgOn,initEvent(function(){
            This.hideMsg();
        }));
        
        $.extend(this,{
            options: function(newOps){
                if(!newOps) return ops;
                $.extend(ops,newOps);
                if(newOps.rules) this.add(newOps.rules);
                return this;
            },
            valid: function(){ return errorsMsgs.length == 0},
            showState: function(){
                this.hideState();
                $.each(errorTypes,function(){
                    assign.addClass(rules[this]['class']);
                });
                return this;
            },
            hideState: function(){
                $.each(rules,function(){
                    assign.removeClass(this['class']);
                });
                return this;
            },
            showMsg: function(){return msgAction.show.call(assign,errorsMsgs), this;},
            hideMsg: function(){return msgAction.hide.call(assign),this;},
            getMsg: function(){return errorsMsgs;},
            check: function(){
                var stateChange = false, newStates = [],i=0;
                errorsMsgs = [];
                $.each(rules,function(name,ops){
                    var fn = check[name];
                    if(fn && !fn.call(ops)){
                        errorsMsgs.push(getMsg(name));
                        newStates.push(name);
                        if(errorTypes[i] != name) stateChange = true;
                        i++;
                    }
                });
                stateChange = stateChange || errorTypes.length !== newStates.length;
                errorTypes = newStates;
                if(stateChange) el.triggerHandler('validchange',[newStates]);
                if(isSuccess !== (newStates.length == 0)){
                    isSuccess = newStates.length == 0;
                    isSuccess?el.triggerHandler('validsuccess',[newStates]):el.triggerHandler('validerrors',[newStates]);
                }
                
                
                return errorsMsgs.length == 0;
            },
            countErrors: function(){return errorsMsgs.length},
            add: function(name,ops){
                if($.type(name) == 'object') $.each(name,function(name,ops){
                    setRule(name,ops);
                });
                else setRule(name,ops);
                return this;
            },
            destroy: function(){
                this.hideState().hideMsg();
                el.unbind(
                    ops.checkOn + ' ' + 
                    ops.showStateOn + ' ' + 
                    ops.hideStateOn + ' ' + 
                    ops.showMsgOn + ' ' + 
                    ops.hideMsgOn
                );
            }
        });
        this.add(ops.rules);
    },{
        options:{
            assign: function(){
                return $(this).parent();
            },
            msgAction: 'tooltip',
            checkOn: 'focusout keyup change',
            showStateOn: 'validerrors',
            hideStateOn: 'validsuccess',
            showMsgOn: 'validchange',
            hideMsgOn: 'validsuccess focusin',
            delay: 100
        },
        msgs: {
            required: "This field is required.",
            minlength: "Please enter at least {val} characters.",
            maxlength: "Please enter no more than {val} characters.",
            rangelength: "Please enter a value between {min} and {max} characters long.",
            range: "Please enter a value between {min} and {max}.",
            min: "Please enter a value greater than or equal to {val}.",
            max: "Please enter a value less than or equal to {val}.",
            email: "Please enter a valid email address.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            number: "Please enter a valid number.",
            digits: "Please enter only digits.",
            creditcard: "Please enter a valid credit card number.",
            equal: "Please enter the same value again.",
            reg: "Please enter the same value again."
        },
        classRules: {
            required: "error",
            minlength: "error",
            maxlength: "error",
            rangelength: "error",
            range: "error",
            min: "error",
            max: "error",
            email: "error",
            url: "error",
            date: "error",
            number: "error",
            digits: "error",
            creditcard: "error",
            equal: "error",
            reg: "error"
        },
        formatMsg: function(msg,ops){
            $.each(msg.match(/\{(.+?)\}/g) || [],function(i,val){
                var key = val.slice(1,val.length - 1);
                var reg = new RegExp(val,'g');
                msg = msg.replace(reg,ops[key]);
            });
            return msg;
        },
        msgActions: {
            tooltip: {
                clear: function(){},
                show: function(msgs){
                    var 
                        $this = $(this),
                        self = arguments.callee,
                        field = $this.children('input,select,textarea,.ct-select2-input')
                    ;
                    if(msgs.length > 0){
                        var popover = field.data().popover,ul,
                        tips = self.tips = self.tips || [],tip;
                        if(!popover){
                            ul = $('<ul>',{'class': 'valid-errorlist'});
                            field.popover({
                                content: ul,
                                trigger: '',
                                placement: 'top'
                            });
                            popover = field.data().popover;
                            popover.show();
                            tip = popover.tip();
                            popover.validData = {
                                offset: tip.offset(),
                                width: tip.outerWidth(), 
                                height: tip.outerHeight()
                            }
                            tips.push(field);
                        }
                        tip = popover.tip()
                        ul = popover.getContent().empty();
                        $.each(msgs,function(i,val){
                            ul.append($('<li>').append(val));
                        });
                        popover.show();
                        tip.click(function(){
                            popover.hide();
                            $this.find('input,textarea,select').filter(':visible').first().focusin();
                        });
                        var addLeft = 0;
                        $.each(tips,function(){
                            var thisPopover = this.data().popover; 
                            if(!this.is(':visible') || thisPopover.tip().is(tip)) return;
                            var thisData = thisPopover.validData, tipData = popover.validData;
                            
                            if(
                                thisData.offset.top > tipData.offset.top + tipData.height || 
                                tipData.offset.top > thisData.offset.top + thisData.height ||
                                thisData.offset.left > tipData.offset.left + tipData.width || 
                                tipData.offset.left > thisData.offset.left + thisData.width
                            ) return;
                            
                            var addLeft0 = thisData.offset.left + thisData.width - tipData.offset.left + 1;
                                tipData.offset.left += addLeft0;
                                addLeft += addLeft0;
                                
                            if((thisData.offset.left + thisData.width) / 2 > (tipData.offset.left + tipData.width) / 2){
                                
                            }else{
                                
                            }
                        });
                        tip.css('left',tip.position().left + addLeft);
                    }
                },
                hide: function(){
                    var popover = $(this).data().popover;
                    popover && popover.hide();
                }
            },
            inline: {}
        }
    })
    $.extend(custom, {
        multi: function () {
            // html
            var 
                This = this,
                head = $('<div>').addClass('ct-multi-head').append($('<span>').append(this.label)),
                btnAdd = $('<a>').attr('href', 'javascript:void(0)').addClass('ct-multi-btnAdd btn')
                .append($('<i>').addClass('icon-plus'),(this.addlabel || 'Add')).click(function () { 
                    addLine().hide().slideDown(300); 
                }),
                items = $('<div>').addClass('ct-multi-items'),
                body = $('<div>').addClass('ct-multi-body').append(items, btnAdd),
                html = addAttrs.call(this, $('<div>')).addClass('ct-multi ct-round').append(head, body),
                addLine = function (data) {
                    var 
                        item = new custom(This.item),
                        btnDelete = $('<a>').attr('href', 'javascript:void(0)').addClass('ct-multi-btnDelete btn btn-mini').click(function () {
                            if(!html.triggerHandler('ct_removeline', [item])  === false) return;
                            line.slideUp(300,function(){
                                line.remove();
                            });
                        }).append($('<i>').addClass('icon-remove')),
                        controlers = $('<div>').addClass('ct-multi-line-controlers btn-group').append(btnDelete).mousemove(function () { return false }),
                        controlPanel = $('<div>').addClass('ct-multi-line-controler').append(controlers),
                        head = $('<div>').addClass('ct-multi-line-head').append($('<span>').addClass('icon-move')),
                        linebody = $('<div>').addClass('ct-multi-line-body').append(item),
                        line = $('<div>').addClass('ct ct-multi-line ct-round blue').append(head, linebody,controlPanel)
                        .mouseover(function () {
                            line.addClass('mouseenter');
                            return false;
                        }).mouseout(function () {
                            line.removeClass('mouseenter');
                        })
                    ;
                    $.extend(line.data(),item.data());
                    data && line.data().data(data);
                    if(html.triggerHandler('ct_addline', [line,item, data]) === false) return;
                    return line.appendTo(items);
                }
            ;
            this.buttons && $.each(this.buttons,function(){
                var This = this;
                var btn  = addAttrs.call(this,$('<a>',{'href': 'javascript:void(0)'})).addClass('btn');
                this.icon && btn.append($('<i>').addClass(this.icon));
                this.label && btn.append(this.label);
                this.callback && btn.click(function(){
                    This.callback.call(html.data());
                });
                body.append(btn);
            });
            // event                
            this.sortable && items.sortable({ distance: 15, handle: ".ct-multi-line-head", connectWith: this.connect + ">.ct-multi-body>.ct-multi-items", update: function(){ html.triggerHandler('ct_sortchange',[])} });
            if(This.filter != undefined){
                var checkAll = $('<a>').attr('href', 'javascript:void(0)').addClass('ct-multi-btnCheckAll btn btn-mini')
                .append($('<i>',{'class':'icon-ok'})).click(function () {
                    checkAll.toggleClass('active');
                    var check = checkAll.hasClass('active');
                    items.children().each(function(){
                        $(this).data().check(check);
                    });
                    return false;
                });
                head.append(checkAll);
                html.bind('ct_addline', function(e,line,item){
                    var 
                        isCheck = This.filter,
                        btn = $('<a>').attr('href', 'javascript:void(0)')
                        .addClass('ct-multi-line-btnFilter btn btn-mini').click(function () { 
                            check(!isCheck);
                            return false;
                        }).append($('<i>').addClass('icon-ok')),
                        check = function(val){
                            if (val != undefined) {
                                if(isCheck != val){
                                    btn.toggleClass('active');
                                    html.triggerHandler('ct_checkedchange', [item, val]);
                                    isCheck = val;
                                }
                                return val;
                            }
                            return isCheck;
                        }
                    ;
                    line.children('.ct-multi-line-controler').find('.btn-group').prepend(btn);
                    isCheck && btn.addClass('active');
                    $.extend(line.data(),{check: check});
                });
            }

            // data function
            
            $.extend(html.data(),{
                data: function (val) {
                    if(val){
                        $.each(val['@data']|| val, function (index, data) {
                            addLine(data);
                        });
                        
                        if(This.filter){
                            var checks = state(val).checks || [];
                            items.children().each(function(i){
                                $(this).data().check(checks[i]);
                            });
                        }
                        return;
                    }
                    var data = []
                    items.children().each(function () {
                        data.push($(this).data().data());
                    });
                    data = {'@data':data}
                    if(This.filter){
                        var checks = state(data).checks = [];
                        items.children().each(function(i){
                            checks.push($(this).data().check());
                        });
                    }
                    if(This.toggle) state(data).toggle = body.css('display') !== 'none';
                    return data;
                },
                add: addLine,
                validate: function(){
                    var errors = 0;
                    items.children().each(function () {
                        errors += $(this).data().validate();
                    });
                    errors && html.triggerHandler('ct_errors',errors);
                    return errors;
                },
                clear: function(){
                    items.empty();
                },
                fields: function(i){ 
                    return i == undefined?items.children():items.children(':eq('+i+')');
                }
            });
            this.value && html.data().data(this.value);
            this.newwin && expandToDialog.call(html,head,head);
            setToggle.call(html,body,head,this.toggle);
            
            return html;
        },
        group: function () {
            var 
                toggle = this.toggle,
                config = $.extend({}, this, { field: 'panel', 'class':'',id:'' }),
                label = $('<span>').addClass('ct-group-label').append(this.label),
                head = $('<div>').addClass('ct-group-head').append(label),
                body = new custom(config),
                html = addAttrs.call(this, $('<div>')).addClass('ct-group ct-round').append(head, body)
            ;
            var titlefield;
            if (this.titlefield) {

                titlefield = body;
                var fs = this.titlefield.split('.');
                $.each(fs, function (index, val) {
                    if (!titlefield.data().fields()) {
                        titlefield = false;
                        return false;
                    }
                    titlefield = titlefield.data().fields(val);
                    if (!titlefield) return false;
                });
                if (titlefield) {
                    titlefield = titlefield.find('input,textarea,select').first().change(function () {
                        label.html(titlefield.val());
                    });
                    label.html(titlefield.val());
                }
            } 
            //data function
            $.extend(html.data(),body.data(),{
                data: function (val) {
                    if (val) {
                        reSetToggle(body,val,toggle);
                        body.data().data(val);
                        titlefield && titlefield.change();
                        return;
                    }
                    var data = body.data().data();
                    if(toggle !== undefined) state(data).toggle = (body.css('display') !== 'none');
                    return data;
                },
                validate: function(){
                    var errors = body.data().validate();
                    errors && html.triggerHandler('ct_errors',errors);
                    return errors;
                }
            });   
            this.value && html.data().data(this.value); 
                     
            this.newwin && expandToDialog.call(html,head,head);
            setToggle.call(html,body,head,this.toggle);
            return html;
        },
        panel: function () {
            var 
                This = this,
                body = $('<div>').addClass('ct-panel-body'),
                head = $('<div>').addClass('ct-panel-head ct-round').append(this.label),
                html = addAttrs.call(this, $('<div>')).addClass('ct-panel ct-round').append(head,body),
                fields = {},
                check
            ;
            if (this.filter != undefined) {
                check = $('<a>',{href: 'javascript:void(0)','class': 'btn btn-mini'}).append($('<i>', { 'class': 'icon-ok'})).click(function(){ html.toggleClass('ct-panel-disabled');});
                head.prepend(check);
                body.click(function(){
                    html.hasClass('ct-panel-disabled') && html.removeClass('ct-panel-disabled');
                });
                this.filter || html.addClass('ct-panel-disabled');
                head.css('padding-left',35);
            }
            check || this.label || head.remove();
            $.each(this.item || {}, function (index, val) {
                var field = new custom(val);
                if (!field) return;
                if(field.data('data')){
                    fields[index] = field;
                    field.data().fieldname = index;
                }
                body.append(field);
            }); 
            this.sortable && body.sortable({distance: 15, update: function(){ html.triggerHandler('ct_sortchange',[])} });
            // data function
            $.extend(html.data(),{
                data: function (val) {
                    if(val){
                        check && state(val).checked || html.addClass('ct-panel-disabled');
                        var data = {};
                        $.each(fields, function (index, field) {
                            field && field.data().data(val[index]);
                        });
                        html.data().lastdata = val;
                        if(This.sortable){
                            $.each(state(val).sortable || [],function(i,val){
                                body.append(fields[val]);
                            });
                        }
                        return;
                    }
                    var data = {};
                    $.each(fields, function (index, field) {
                        if(field) data[index] = field.data().data();
                    });
                    if(This.sortable){
                        var sort = state(data).sortable = [];
                        body.children().each(function(){
                            sort.push($(this).data().fieldname);
                        });
                    }
                    if(check && !html.hasClass('ct-panel-disabled')) state(val).checked = true;
                    return data;
                },
                fields: function(name,field){
                    if(name && field) {
                        fields[name]? fields[name].after(field).remove(): body.append(field);
                        fields[name] = field;
                        return;
                    }else if(name) return fields[name];
                    var fs = $();
                    $.each(fields,function(){ fs.add(this) });
                    return fs;
                },
                validate: function(){
                    var errors = 0;
                    $.each(fields, function (index, field) {
                        if(field.data().validate) errors += field.data().validate();
                    });
                    errors && html.triggerHandler('ct_errors',errors);
                    return errors;
                },
                clear: function(){
                    $.each(fields,function(){
                        this.data().clear();
                    });
                }
            });
            this.value && html.data().data(this.value);
            return html;
        },
        tabs: function () {
            this.position = this.position || 'top';
            var 
                ul = $('<ul>',{'class':'ct-tabs-head nav nav-tabs'}),
                content = $('<div>',{'class': 'ct-tabs-content tab-content'}),
                tabs = addAttrs.call(this, $('<div>')).addClass('tabbable ct-tabs ct-round').append(ul,content),
                fields = {},
                heads = {},
                count = 0,
                This = this
            ;
            if(this.filter != undefined){
                tabs.bind('ct_addfield',function(e,li,field){
                   var 
                        isCheck = This.filter,
                        btn = $('<a>').attr({'href':'javascript:void(0)','class':'ct-tabcheck'})
                        .addClass('btn btn-mini').click(function () { 
                            check(!isCheck);
                            return false;
                        }).append($('<i>').addClass('icon-ok')),
                        check = function(val){
                            if (val != undefined) {
                                if(isCheck != val){
                                    btn.toggleClass('active');
                                    tabs.triggerHandler('ct_checkedchange', [field, val]);
                                    isCheck = val;
                                }
                                return val;
                            }
                            return isCheck;
                        }
                    ;
                    li.prepend(btn);
                    isCheck && btn.addClass('active');
                    $.extend(field.data(),{check: check});
                });
            }
            
            $.each(this.item || {}, function (index, config) {
                var panel = new custom(config);
                var  
                    id = panel.attr('id') || 'ct_tabs_' + index + '_' + countTab++,
                    li = $('<li>').append(
                        $('<a>',{href: '#'+id, 'data-toggle': 'tab','class': 'ct-tablabel'})
                        .append(config.label || 'Tabs ' + (++count))
                    )
                ;
                panel.attr('id',id);
                ul.append(li);
                content.append(panel.addClass('tab-pane'));
                li.data().tabname = index;
                fields[index] = panel;
                heads[index] = li;
                tabs.triggerHandler('ct_addfield',[li,panel]);
            });
            this.active = this.active || 0;
            ul.find('a:eq('+this.active+')').tab('show');
            content.children(':eq('+ this.active +')').addClass('active');
            this.sortable && ul.sortable({distance: 15, update: function(){ tabs.triggerHandler('ct_sortchange',[])} });
            //data action
            $.extend(tabs.data(),{
                fields: function(name,field){
                    if(name && field) {
                        fields[name]? fields[name].after(field).remove(): body.append(field);
                        fields[name] = field;
                        return;
                    }else if(name) return fields[name];
                    var fs = $();
                    $.each(fields,function(){ fs.add(this) });
                    return fs;
                },
                data: function (val) {
                    if (val) {
                        $.each(fields, function (index, field) {
                            if(field) field.data().data(val[index]);
                        });
                        tabs.data().lastdata = val;
                        if(This.sortable){
                            $.each(state(val).sortable || [],function(i,val){
                                ul.append(heads[val]);
                            });
                        }
                        ul.children().eq(state(val).active).children('a').tab('show');
                        return;
                    }
                    var data = {};
                    $.each(fields, function (index, field) {
                        if(field) data[index] = field.data().data();
                    });
                    if(This.sortable){
                        var sort = state(data).sortable = [];
                        ul.children().each(function(){
                            sort.push($(this).data().tabname);
                        });
                    }
                    state(data).active = ul.children('.active').index();
                    return data;
                },
                validate: function(){
                    var errors = 0;
                    $.each(fields, function (index, field) {
                        var thisErrs = field.data().validate();
                        if(thisErrs){
                           heads[index].children('a').tab('show');
                        }
                        errors += thisErrs;
                    });
                    errors && tabs.triggerHandler('ct_errors',errors);
                    return errors;
                },
                clear: function(){
                    $.each(fields,function(){
                        this.data().clear();
                    });
                }
            });    
            this.newwin && expandToDialog.call(tabs,ul,ul);
            return tabs;
        },
        filter: function () {
            var 
                This = this, tabselect,
                changeTab = function(name,notToggle){
                    if(tabselect == name || !fields[name]) return;
                    tabselect = name;
                    select.val(name);
                    select.triggerHandler('change');
                    $.each(fields, function (index) {
                        this.removeClass('active');
                    });
                    var selected = fields[name];
                    selected && selected.addClass('active');
                    html.triggerHandler('ct_changed',[selected,name]);
                    notToggle || body.is(':visible') || body.slideDown(300);
                },
                label = $('<span>').append(this.label),
                select = $('<select>').change(function () {
                    changeTab(select.val());
                }),
                head = $('<div>').addClass('ct-filter-head'),
                body = $('<div>').addClass('ct-filter-body'),
                html = addAttrs.call(this, $('<div>')).addClass('ct-filter ct-round').append(head, body),
                fields = {}
            ;
            
            this.newwin && expandToDialog.call(html,head,head);
            head.append(label, select);
            $.each(this.item || {}, function (index, val) {
                var 
                    panel = new custom(val)
                ;
                if (!panel) return;
                fields[index] = panel;
                var op = $('<option value="' + index + '">').text(val.label || index);
                select.append(op);
                body.append(panel);
            });
            $.extend(html.data(),{
                fields: function(name,field){
                    if(name && field) {
                        fields[name]? fields[name].after(field).remove(): body.append(field);
                        fields[name] = field;
                        return;
                    }else if(name) return fields[name];
                    var fs = $();
                    $.each(fields,function(){ fs.add(this) });
                    return fs;
                },
                data: function (val) {
                    var selected;
                    if ($.type(val) === 'object') {
                        selected = state(val).selected;
                        $.each(fields, function (index, field) {
                            if(field) field.data().data(val[index]);
                        });
                        selected && changeTab(selected,true);
                        reSetToggle(body,val,This.toggle);
                        html.data().lastdata = val;
                        return;
                    }
                    var data = {};
                    $.each(fields, function (index, field) {
                        if(field) data[index] = field.data().data();
                    });
                    $.extend(state(data),{
                        selected: select.val(),
                        toggle: body.is(':visible')
                    });
                    return data;
                },
                validate: function(){
                    var errors =  fields[select.val()].data().validate();
                    errors && html.triggerHandler('ct_errors',errors);
                    return errors;
                },
                clear: function(){
                    $.each(fields,function(){
                        this.data().clear();
                    });
                },
                select: changeTab
            });   
            this.selected && select.val(this.selected);
            changeTab(select.val());
			select.select2();
			select.click(false);
            setToggle.call(html,body,head,this.toggle);
            return html;
        },
        textarea: function () {                          
            var 
                field = formfield.call(this).addClass('ct-textarea'),
                lastHeight
            ; 
            
            this.newwin && expandToDialog.call(field,field.children(':first'),field.children(':first'));
            if(this.autoHeight){
                var 
                    text = field.find('textarea'),
                    clone = $('<pre>').appendTo(field)
                ;
                text.focusin(function(){
                    clone.width(text.width());
                    text.height(clone.height());
                }).focusout(function(){
                    text.height('');
                }).keydown(function(){
                    setTimeout(function(){
                        clone.text(text.val()+'\n');
                        text.height(clone.height());
                    })
                });
                var fn = field.data().data;
                field.data().data = function(val){
                    val = fn(val);
                    clone.text(text.val()+'\n');
                    return val;
                }
            }
            return field;
        },
        input: function () { 
            this.type = this.type || 'text';
            this.pProps = (function(props){
                var ps = '';
                $.each(['type','placeholder'],function(i,index){
                    if(index in props) ps += ' '+index + '="'+props[index]+'"';
                });
                return ps;
            })(this);
            var field = formfield.call(this).addClass('ct-input'); 
            if(this.type == 'checkbox'){
                field.addClass('checkbox');
                
                var check = field.children('input').change(function(){
                    check.is(':checked')?
                    button.addClass('ct-checked'):
                    button.removeClass('ct-checked');
                });
                
                var 
                    cBtn = $('<a>',{href:'javascript:void(0)', 'class' : 'btn ct-transition'}).append($('<span>').addClass('ct-transition').append(
                        $('<span>',{text: 'On'}).addClass('ct-on'),
                        $('<span>',{text: 'Off'}).addClass('ct-off')
                    )),
                    button = $('<a>',{href:'javascript:void(0)', 'class' : 'btn ct-checkbox ct-transition'})
                    .append(cBtn).click(function(){
                        check.attr('checked',!check.is(':checked')).change();
                        return false;
                    })
                ;
				if(this.title || this.tooltip){
                    button.tooltip($.extend({
                        html: true,
                        title: this.title,
                        placement: 'top'
                    },this.tooltip));
                }
                check.before(button);
                field.data().data = function(val){
                    if(val != undefined){
                        var lastVal = check.is(':checked');
                        if(!!val == lastVal) return;
                        check.attr('checked', val);
                        check.triggerHandler('change');
                        return;
                    }
                    return check.is(':checked');
                }
                this.value && check.attr('checked',true);
                check.triggerHandler('change');
            }
            return field;
        },
        select: function () {
            var 
                field = formfield.call(this),
                select = field.children('select'),
                dataFn = field.data().data,
                buidOptions = function(data){
                    var ops = $();
                    $.each(data, function (index, val) {
                        if($.type(val) == 'object'){
                            ops.push($('<optgroup >',{label: index}).append(buidOptions(val)));
                            return;
                        }
                        ops.push($('<option value="' + index + '">' + val + '</option>')[0]);
                    });
                    return ops;
                }
            ;
            select.append(buidOptions(this.item || {}));
            field.data().data = function(val){
                var value = dataFn(val);
                if(val != undefined) select.triggerHandler('change');
                return value;
            }
            return field.addClass('ct-select');
        },
        select2: function(){
            var 
                This = this,
                field = formfield.call($.extend({},this,{field: 'input',type: 'text'})),
                input = field.find('input').addClass('ct-select2-input')
            ;
            
            if(this.item){
                var parse = function(dt){
                    var data = [];
                    $.each(dt,function(k,v){
                        if($.type(v) == 'object'){
                            data.push({
                                text: k,
                                children: parse(v)
                            });
                        }else{
                            data.push({
                                id: k,
                                text: v
                            });
                        }
                    });
                    return data;
                }
                this.data = parse(This.item || {});
            }
            if(this.multicheck){
                $.extend(this,{
                    formatResult: function(state,cont){
                        var 
                            check = $('<i>',{'class':'icon-ok'}),
                            label = $('<span>',{text: state.text})
                        ;
                        cont.mousedown(function(e){
                            cont.parent().toggleClass('ct-checked').parents('li.ct-checked').removeClass('ct-checked');
                        }).append(check,label);
                    },
                    formatSelection: function(){
                        return 'a';
                    }
                });
                var options = {};
                input.bind({
                    'select2-selecting':  false
                });
            }
            
            input.select2(this);
            field.find('ul').addClass('ct-round');
            $.extend(field.data(),{
                data: function(val){
                    if(val) {
                        input.select2('data',state(val).data);
                        return;
                    }
                    val = {
                        '@data': input.select2('val'),
                        '@state': {
                            data: input.select2('data')
                        }
                    }
                    return val;
                }
            });
			if(this.title || this.tooltip){
				input.prev().tooltip($.extend({
					html: true,
					title: this.title,
					placement: 'top'
				},this.tooltip));
			}
            return field.addClass('ct-select2');
        },
        html: function(){
            var html = addAttrs.call(this,$('<div>').append(this.content)).addClass('ct-html');
            $.extend(html.html(this.html).data(),{
                data: function(data){
                    return html.find('input,select,textarea').val(data);
                },
                clear: function(){}
            });
            return html;
        },
        datetime: function(){
            var
                field = formfield.call({field:'input',label: this.label}),
                input = field.children('input').datepicker(this)
            ;
            return field.addClass('ct-input');
        },
        color: function(){
            
            var 
                fo = $.extend({},this,{field: 'input'}),
                field = formfield.call(fo),
                input = field.children('input').colorpicker(),
                fn = field.data().data
            ;
            field.data().data = function(data){
                if(data) input.val(data).colorpicker('update');
                return fn();
            }
            return field.addClass('ct-input');
        },
        separate: function(){
            var 
                line = $('<hr>'),
                label = this.label? $('<span>').append(this.label):!1,
                html = $('<div>',{'class': 'ct-separate'}).append(line,label)
            ;
            return html;
        }
    });
    return custom;
})(jQuery) : (function () {
    alert('Not supported jquery, please import jQuery to use custom params');
    return arguments.callee;
})();

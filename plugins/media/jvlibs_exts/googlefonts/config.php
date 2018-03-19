<?php JFormFieldJVCustom::import('assignment');?>
(function($){ return {
    name: 'Google fonts',
    version: '1.0.0',
    config: {
        config: {
            label: 'Google fonts',
            field: 'multi',
            filter: true,
            'class': 'none',
            buttons:[{
                icon: 'icon-refresh',
                label: 'Refresh fonts',
                callback: function(){
                    $.each(this.fields(),function(){
                        $(this).data().fields('font').children('.select2-offscreen').trigger('select2-selecting');
                    });
                }
            }],
            item: {
                font:{
                    label: 'Font family',
                    field: 'select2',
                    minimumInputLength: 1,
                    validates: {
                        required: true
                    },
                    events: {
                        'select2-selecting': function(e){
                            var 
                                self = arguments.callee,
                                input = $(this)
                            ;
                            if(!input.is('input')) return;
                            self._gFonts = self._gFonts || {};
                            setTimeout(function(){
                                var font = input.val();
                                if(!self._gFonts[font]){
                                    self._gFonts[font] = true;
                                    $('head').append( $('<link/>',{rel:'stylesheet', type: 'text/css',href: 'http://fonts.googleapis.com/css?family=' + font}));
                                }
                                input.prev().css('font-family',font);
                            },0);
                        }
                    },
                    formatResult: function(state){
                        if (!state.id) return state.text;
                        
                        var 
                            line = $('<div>').css('font-family',state.id),
                            label = $('<span>').addClass('icon').append(state.text)
                        ;
                        return line.append(label);
                    },
                    query: function(ops){
                        var 
                            self = arguments.callee,
                            This = this
                        ;
                        if(self._gfontInit) return;
                        if(!self._gfontData){
                            self._gfontInit = true;
                            $.getJSON('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCWonrDW2amTWX30frvUf2Aq6Vl9w-E49I&callback=?').done(function( data ) {
                                    self._gfontData = data;
                                    delete self._gfontInit;
                                    self.call(This,ops);
                              });
                            return;
                        }
                        var data = [];
                        $.each(self._gfontData.items,function(){
                            if(ops.matcher(ops.term,this.family)) data.push({
                                id: this.family,
                                text: this.family
                            });
                        });
                        ops.callback({results: data});
                    }
                },
                assign: {
                    label: 'Assign to selector',
                    field: 'select2',
                    selectOnBlur: true,
                    validates: {
                        required: true
                    },
                    tags:[],
                    tokenSeparators: [',']
                },
                assignmenu: {
                    field: 'assignment',
                    label: 'Menu Assignment',
                    multicheck: true,
                    data: {results: CustomField.datas.menus},
                    validates: {required: true}
                }
            }
        }
    }
}})(jQuery)
(function($){
    $.extend($.fn, {
        iaction: function(o){
            return this.each(function(){
                var c = $(this);
                c.on({
                    'change.iaction': function(){
                        c.trigger(this.value);
                    },
                    'add-iaction': function(){
                        SqueezeBox.open(JV.imedia, {
                            handler: 'iframe', size: {x: 800, y: 500},
                            onOpen: function(){
                                
                                var self = this;
                                $(this.asset).on({
                                    'load.iframe': function(){
                                        
                                        var wi = self.asset.contentWindow,
                                            wij = wi.jQuery,
                                            fields = wij('[id="f_url"]').attr('name', 'f_url[]')
                                        ;
                                        
                                        fields.closest('.control-group').removeClass('span6').addClass('span');
                                        
                                                                                
                                        $.extend(self.asset.contentWindow.ImageManager, {
                                            populateFields: function(file) {
                                                file = [wi.image_base_path, file].join('');
                                                fields = wij('[id="f_url"]');
                                                var afield = 0;
                                                fields.each(function(){
                                                    if(file == this.value) {
                                                        afield = 1;
                                                        return;
                                                    }
                                                });
                                                if(afield) {
                                                    return ;
                                                }
                                                if(fields.length == 1 && !fields.val()) {
                                                    fields.val(file);
                                                    return ;
                                                }
                                                
                                                $('<input>', {
                                                    id: 'f_url', 
                                                    name: 'f_url[]', 
                                                    type: 'text', 
                                                    value: file
                                                }).insertAfter(fields.last()); 
                                            }    
                                        });
                                        
                                        wij('[onclick*="window.parent.jInsertFieldValue"]').each(function(){
                                            var $this = $(this);
                                            $this.removeAttr('onclick').on({
                                                'click.insert-field-value': function(){
                                                    var fields = wij('[id="f_url"]');
                                                    !fields.length || $.each(fields, function(){
                                                        o.uimage.trigger('create-item', [
                                                            this.value, 
                                                            o.himage
                                                            .replace(/\{src\}/, [JV.bmedia, this.value].join(''))
                                                            .replace(/\{path\}/, this.value)
                                                        ]);     
                                                    }); 
                                                    self.close();  
                                                }
                                            });
                                        });      
                                    }
                                });
                            },
                            onClose: function(){
                                c.trigger('reset-iaction');        
                            }
                        });
                    },
                    'checkall-iaction': function(){
                        o.uimage.trigger('checkall-item');    
                        c.trigger('reset-iaction');
                    },
                    'uncheck-iaction': function(){
                        o.uimage.trigger('uncheck-item');    
                        c.trigger('reset-iaction');
                    },
                    'remove-iaction': function(){
                        o.uimage.trigger('remove-item');    
                        c.trigger('reset-iaction');
                    },
                    'reset-iaction': function(){
                        c.val('').trigger('liszt:updated.chosen'); 
                    }
                }) 
            });
        }
    })
})(jQuery);

jQuery(function($){
    var uimage = $('.f-images .items');
    $('[data-iaction]').iaction({
        uimage: uimage.sortable({containment: '.f-images'}).on({
            'create-item': function(e, path, tag){
                uimage.find('[name="jform_image[]"]').filter('[value="'+path+'"]').length || uimage.append(tag);
            },
            'checkall-item': function(){
                uimage.find('[name="jform_image[]"]').each(function(){
                    $(this).attr('checked', true)
                });   
            },
            'uncheck-item': function(){
                uimage.find('[name="jform_image[]"]').each(function(){
                    $(this).removeAttr('checked');
                });    
            },
            'remove-item': function(){
                uimage.find('[name="jform_image[]"]').each(function(){
                    var $this = $(this);
                    !$this.is(':checked') || $this.closest('.imgOutline').remove();
                });    
            }
        }), 
        himage: $('[data-tmpl="himage"]').html()
    });
    
    // event form
    window.Joomla.submitbutton = function(task)
    {
        var form = document.getElementById('item-form'),
            $form = $(form);
       if (task == 'item.cancel') {
           window.Joomla.submitform(task, form);
       }
       else {
           
           if (task != 'item.cancel' && document.formvalidator.isValid(form)) {
               
               var path = [];
               $.each($form.find('[name="jform_image[]"]'), function(){
                    path.push(this.value) ;
               });
               $form.find('#jform_image').val(path.join(','));

               var d = {};

                $form.find( '[data-group]' ).each( function() {

                    var e = $( this )
                        index = e.attr( 'data-group' )
                    ;

                    d[ index ] = {};

                    e.children( '.control-group' ).each( function() {

                        var i = $( this )
                            ,label = i.find( '[data-field="label"]' ).attr( { disabled: true } ).val()
                            ,value = i.find( '[data-field="value"]' ).attr( { disabled: true } ).val()
                        ;

                        d[ index ][ label ] = value;

                    } );

                } );

                d = JSON.stringify( d );

                $form.append( $( '<input>', { 
                    type: 'hidden', name: 'jform[extrafields]', value: d 
                } ) );
                
               window.Joomla.submitform(task, form);
           }
           else {
               alert(window.Joomla.JText._('JGLOBAL_VALIDATION_FORM_FAILED'));
           }
       }
    };
});
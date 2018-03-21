(function($){
    $.extend($.fn, {
        pfVote: function(o){
            o = $.extend({event: 'click.com_jvportfolio'}, o);
            return this.delegate('[data-pfvote]', o.event, function(e){
                var target = $(this), v = target.data('pfview') || '> *';
                if(target.hasClass('process')) return false;
                $.ajax({
                    url: target.attr('href') || target.data('href'),
                    type: 'POST',
                    dataType: 'json',
                    cache: false, 
                    beforeSend: function(){target.addClass('process')},
                    success: function(rs) {
                        if(!$.isNumeric(rs.data)) {
                            return false;
                        };
                        target.find(v).each(function(){
                            $(this).html(['&nbsp;',rs.data].join(''));
                        });
                    },
                    complete: function(){target.removeClass('process')}
                });
                return false; 
            });
        },
        pfQuickView: function(o){
            o = $.extend({event: 'click.com_jvportfolio'}, o);
            return this.delegate('[data-qview="lightbox"]', o.event, function(){
                
                var 
					e 		= $(this)
					,imgs 	= e.data('imgs')
					,index 	= e.data( 'qv-index' ) || 0;
                
                if(!imgs) {
                    return false;    
                }
                
                Fresco.show(imgs, index + 1 );
                
                return false;
            });
        },
        asort: function(o){
            return this.each(function(){
                $(this).on({
                    'change.asort': function(){
                        var col = this.value,
                            sort = {
                            by: function(el){
                                return el.data(col)
                            }
                        };
                        o.pf.shuffle('sort', sort);     
                    }
                }); 
            });
        }
    });
})(jQuery);
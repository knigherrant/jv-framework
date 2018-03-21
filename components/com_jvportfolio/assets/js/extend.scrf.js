(function($){
    $.extend($.fn, {
        extendScrfBtn: function(o){
            var pf = this;
            o.doc.ajaxSuccess(function(e, response, dsend, rs){
                if(dsend.url.match(/format=hfetch/) || dsend.url.match(/format=xhfetch/)){
                    if(pf.data('infinitescroll').options.state.currPage >= o.maxPage) {
                        o.mark.hide(0);   
                    }       
                }
            }).ajaxError(function(){
                o.mark.hide(0);
            });
            pf.infinitescroll('unbind');
            o.mark.on({
                'click.fetch': function(){
                    pf.infinitescroll('retrieve');  
                }
            }); 
            return pf;
        },
        extendScrfNav: function(o){
            var pf = this;
            pf.infinitescroll('unbind');    
            pf.infinitescroll('update', {
                appendCallback: false,
                callback: function(oScr, data, path){
                    var d = pf.data('shuffle');
                    pf.prepend(data);
                    pf.shuffle('remove', d['$items']); 
                    pf.one({
                        'removed.shuffle': function(){
                            pf.shuffle('appended', data);      
                        }
                    });                          
                }
            });
            function extendResultPage(a,b) {
                var page  = $('#pfo-rs-page'),
                    total = $('#pfo-rs-total');
                if (page.length) {
                    page.html(a);
                };
                if (total.length) {
                    total.html(b);
                }
            }
            o.pagination = $.extend(o.pagination, {
                selectOnClick: true,
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>',
                onPageClick: function(p){
                    pf.infinitescroll('update', {state: {currPage: p-1}});
                    pf.infinitescroll('retrieve');  
                    extendResultPage(o.mark.pagination('getCurrentPage'),o.mark.pagination('getPagesCount'));
                },
                onInit: function() {
                    extendResultPage(o.mark.pagination('getCurrentPage'),o.mark.pagination('getPagesCount'))
                }
            }); 
            o.mark.pagination(o.pagination);
            
            return pf;
        }
    })
})(jQuery);
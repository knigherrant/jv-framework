;
(function ($) {
    
    function buildUrl(u){
        return u
        .replace(/option=com_virtuemart/, 'o')
        .replace(/view=virtuemart/, 'oview');
    }
    
    // Remove item in cart
    $(function(){
        var cprefix = "#vmCartModule", wcart = $(cprefix),
        releaseCart = function(rs){
            var ncart = $(rs.data).filter(cprefix);
            if(!ncart.length) {
                return false;
            }
            wcart.find('.moduleMiniCart').html(ncart.find('.moduleMiniCart').html());
            wcart.find('.view_cart_link').html(ncart.find('.view_cart_link').html());
        };
        
        wcart.on({
            'fetch-cart': function(){
                var $this = $(this);

                $.ajaxSetup({ cache: false });
                var params = {
                    option: 'com_ajax',
                    module: 'virtuemart_carte',
                    method: 'getData',
                    format: 'json'
                };
                $.getJSON(buildUrl(location.href), params,function (rs, textStatus) {
                    releaseCart(rs);                                
                });
            }
        });
        
        // remove item in cart
        $(document).delegate('[data-miniaction="rcart"]', 'submit.removeItem', function(){
            
            wcart.addClass('process');           
            $.post(buildUrl(location.href), $(this).serialize(), function(rs){  
                releaseCart(rs);
            }).done(function(){
                wcart.removeClass('process');
            });
            
            return false;     
        });
        
        // ajax add
        window.Virtuemart = $.extend(window.Virtuemart, {
            cartEffect: function (form) {
            
                if(usefancy){ $.fancybox.showActivity(); }

                $.ajax({
                    type: "POST",
                    cache: false,
                    dataType: "json",
                    url: window.vmSiteurl + "index.php?option=com_virtuemart&nosef=1&view=cart&task=addJS&format=json"+vmLang,
                    data: form.serialize(),
                    beforeSend: function(){
                        wcart.addClass('process');
                    },
                    complete: function(){
                        wcart.removeClass('process');
                    }
                }).done(function(datas, textStatus) {

                    if(datas.stat ==1){

                        var txt = datas.msg;
                    } else if(datas.stat ==2){
                        var txt = datas.msg +"<H4>"+form.find(".pname").val()+"</H4>";
                    } else {
                        var txt = "<H4>"+vmCartError+"</H4>"+datas.msg;
                    }        
                    if(usefancy){
                        $.fancybox({
                            "titlePosition" :     "inside",
                            "transitionIn"    :    "fade",
                            "transitionOut"    :    "fade",
                            "changeFade"    :   "fast",
                            "type"            :    "html",
                            "autoCenter"    :   true,
                            "closeBtn"      :   false,
                            "closeClick"    :   false,
                            "content"       :   txt
                        });
                    } else {
                        $.facebox.settings.closeImage = closeImage;
                        $.facebox.settings.loadingImage = loadingImage; 
                        $.facebox({ text: txt }, 'my-groovy-style');
                    }

                    // update cart
                    wcart.trigger('fetch-cart');
                });
            }     
        });
    });

})(jQuery);   
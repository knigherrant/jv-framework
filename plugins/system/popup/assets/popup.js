(function($){
    $(document).ready(function(){
        // Add Modal 
        $('body').append('<div class=\"modal fade form-wrapper jv-popup-product\" id=\"popup-product\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\"><div class=\"modal-dialog modal-lg\" role=\"document\"><div class=\"modal-content\"><div class=\"modal-body \"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button><span class="popup-product-load"><i class="fa fa-spinner fa-pulse"></i></span><div id=\"jv-popup-detail\"></div></div></div></div></div>');

        var popup     = $('#popup-product'),
            wrapper     = $('#jv-popup-detail'),
            button      = $('.btn-popup'),
            loading     = $('.popup-product-load');
            
        //Popup Action
        button.each(function(){
            var el          = $(this),
                product_id  = el.data('id');
            el.click(function(e){
                e.preventDefault();
                popup.modal('show');
                loading.fadeIn();
                wrapper.fadeOut();
                $.ajax({
                    url: 'index.php?action=getproduct',
                    type: 'get',
                    data: 'product_id=' + product_id,
                    success: function(data) {
                        loading.fadeOut();
                        wrapper.html(data);
                        wrapper.fadeIn();
                        var product     = $('.product'),
                            imageswap   = $('.imagesProduct'),
                            images      = imageswap.find('.vmFullImage'),
                            thumbs      = imageswap.find(".additional-images-wrapper"),
                            tooltip     = $('[data-toggle="tooltip"]'),
                            links       = $('.link-modal'),
                            productform = $("form.js-recalculate");

                        // Images Product  
                        images.each(function(){
                            var el = $(this), thumb = thumbs;
                            el.owlCarousel({
                                direction : $("body").hasClass( "rtl" )?'rtl':'ltr',
                                singleItem:true,
                                pagination:false,
                                autoHeight:true,
                                navigation: true,
                                navigationText: ["<i class=\"fa fa-angle-left\"></i>","<i class=\"fa fa-angle-right\"></i>"]
                            });

                            thumb.owlCarousel({
                                direction : $("body").hasClass( "rtl" )?'rtl':'ltr',
                                items : 4,
                                itemsDesktop      : [1199,4],
                                itemsDesktopSmall : [979,4],
                                itemsTablet       : [768,4],
                                itemsMobile       : [479,4],
                                pagination:false,
                                responsiveRefreshRate : 100,
                                navigation: false,
                                afterInit : function(el){
                                  el.find(".owl-item").eq(0).addClass("synced");
                                }
                            });

                            function syncPosition(el){
                                var current = this.currentItem;
                                thumb
                                  .find(".owl-item")
                                  .removeClass("synced")
                                  .eq(current)
                                  .addClass("synced")
                                if(thumb.data("owlCarousel") !== undefined){
                                  center(current)
                                }
                              }
                     
                            thumb.on("click", ".owl-item", function(e){
                                e.preventDefault();
                                var number = $(this).data("owlItem");
                                el.trigger("owl.goTo",number);
                            });
                         
                            function center(number){
                                var sync2visible = thumb.data("owlCarousel").owl.visibleItems;
                                var num = number;
                                var found = false;
                                for(var i in sync2visible){
                                  if(num === sync2visible[i]){
                                    var found = true;
                                  }
                                }

                                if(found===false){
                                  if(num>sync2visible[sync2visible.length-1]){
                                    thumb.trigger("owl.goTo", num - sync2visible.length+2)
                                  }else{
                                    if(num - 1 === -1){
                                      num = 0;
                                    }
                                    thumb.trigger("owl.goTo", num);
                                  }
                                } else if(num === sync2visible[sync2visible.length-1]){
                                  thumb.trigger("owl.goTo", sync2visible[1])
                                } else if(num === sync2visible[0]){
                                  thumb.trigger("owl.goTo", num-1)
                                }

                            }
                        });
                        
                        // Tooltip link modal
                        tooltip.tooltip();

                        // Popup modal: PDF, Print, Email
                        links.each(function(){
                            var el =$(this);
                                el.magnificPopup({
                                type: 'iframe',
                                mainClass: 'my-mfp-zoom-in',
                                removalDelay: 160
                            });
                        });

                        Virtuemart.product(jQuery("form.product"));
                        productform.each(function(){
                            if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
                                var id= $(this).find('input[name="virtuemart_product_id[]"]').val();
                                Virtuemart.setproducttype($(this),id);
                            }
                        });
                        $('.jvcompare a, .jvWishlist a').click(function(){
                            var a = $(this);
                            if(usefancy) jQuery.fancybox.showActivity();
                            $.ajax({
                                url : window.vmSiteurl + "index.php?option=com_jvvmhelper&task="+ $(this).attr('data-task') +"&Itemid="+$(this).attr('data-itemid')+"&catid="+$(this).attr('data-catid')+"&product_id="+$(this).attr('data-id')+vmLang,
                                dataType : 'json'
                            }).done(function(data){
                                a.addClass('jadded');
                                var jvtext = data.msg;
                                if(usefancy){
                                    jQuery.fancybox({
                                            "titlePosition" :   "inside",
                                            "transitionIn"  :   "fade",
                                            "transitionOut" :   "fade",
                                            "changeFade"    :   "fast",
                                            "type"          :   "html",
                                            "autoCenter"    :   true,
                                            "closeBtn"      :   false,
                                            "closeClick"    :   false,
                                            "content"       :   jvtext
                                        }
                                    );
                                } else {
                                            jQuery.facebox.settings.closeImage = closeImage;
                                            jQuery.facebox.settings.loadingImage = loadingImage;
                                            //$.facebox.settings.faceboxHtml = faceboxHtml;
                                            jQuery.facebox({ text: jvtext }, 'my-groovy-style');
                                }
                            })
                        });
                        $(".popupProduct select").chosen({disable_search_threshold: 10});
                        return false;
                    }
                });
            });
        });
        
        // Hide modal
        popup.on('hidden.bs.modal', function (e) {
          wrapper.html('');
        })
    }); 
})(jQuery);
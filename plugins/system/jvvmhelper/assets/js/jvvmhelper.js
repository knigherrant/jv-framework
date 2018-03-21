$JVCOMPARE = jQuery.noConflict();
$JVCOMPARE(function($){
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
                            "titlePosition" : 	"inside",
                            "transitionIn"	:	"fade",
                            "transitionOut"	:	"fade",
                            "changeFade"    :   "fast",
                            "type"			:	"html",
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
});
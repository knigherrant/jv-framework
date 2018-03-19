jQuery(function($) {
	var Headeroom = $(".headroom");
	function headerFix(){
		Headeroom.each(function(){
			var el = $(this), 
				hTop = $('.header-top'),
				top = el.parent().offset().top;
				if (hTop.length) {
					var hTopNum = hTop.offset().top,
						hTopHeight = hTop.outerHeight();
					top = hTopNum + hTopHeight;
				};
			el.headroom({
				"offset": top,
				"tolerance": 5
			});
		});
	}
	headerFix();

	var nav = $(".block-mainnav"),
		responsive = nav.data('responsive');
	$(window).on("resize", function () {
		headerFix();
		if ( JVMenu.getViewport("x") <= responsive) {
			nav.insertBefore( "#mainsite" );
		}
		else{        
			$(".block-mainnav-wrapper").append(nav);
		}
		
	}).trigger("resize");
	$(window).on("load", function () {
		$(window).trigger("resize");
	});
});

(function($){
	function injector(t, splitter, klass, after) {
		var text = t.text(), a = text.split(splitter), inject = '';
		if (a.length) {
			$(a).each(function(i, item) {inject += '<span class="'+klass+(i+1)+'" aria-hidden="true">'+item+'</span>'+after;});
			t.attr('aria-label',text).empty().append(inject)
		}
	}
	var methods = {
		init : function() {
			return this.each(function() {
				injector($(this), '', 'char', '');
			});
		},
		words : function() {
			return this.each(function() {
				injector($(this), ' ', 'word', ' ');
			});
		},
		lines : function() {
			return this.each(function() {
				var r = "eefec303079ad17405c889e092e105b0";
				injector($(this).children("br").replaceWith(r).end(), r, 'line', '');
			});
		}
	};
	$.fn.lettering = function( method ) {
		if ( method && methods[method] ) {
			return methods[ method ].apply( this, [].slice.call( arguments, 1 ));
		} else if ( method === 'letters' || ! method ) {
			return methods.init.apply( this, [].slice.call( arguments, 0 ) ); 
		}
		$.error( 'Method ' +  method + ' does not exist on jQuery.lettering' );
		return this;
	};

})(jQuery);

jQuery(document).ready(function() {
	if (jQuery('div.modal').length > 0) {
		jQuery('div.modal').appendTo('body');
	};
	if (jQuery('.avAudio').length) {
		jQuery('.avAudio').each(function(){
			var el = jQuery(this);
			el.parents('.post-image').find('.popup-modal').find('.fa').removeClass('fa-play').addClass('fa-music');
		});
	};
	jQuery(".catItemVote h5").lettering('words').children('.word1').lettering();
	jQuery(".catCounter").lettering('words').children('.word2').lettering();

	// JV Cusstom
	jQuery('.jvcustom').each(function(){
		var el = jQuery(this),
			parentBackground = el.data('parent');
			parentElement ="";
			switch(parentBackground) {
			    case 1: parentElement =el.parent('*');
			        break;
			    case 2: parentElement =el.parent('*').parent('*');
			        break;
			    case 3: parentElement =el.parent('*').parent('*').parent('*');
			        break;
			    case 4: parentElement =el.parent('*').parent('*').parent('*').parent('*');
			        break;
			    case 5: parentElement =el.parent('*').parent('*').parent('*').parent('*').parent('*');
			        break;
			    case 6: parentElement =el.parent('*').parent('*').parent('*').parent('*').parent('*').parent('*');
			        break;
			    case 7: parentElement =el.parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*');
			        break;
			    case 8: parentElement =el.parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*');
			        break;
			    case 9: parentElement =el.parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*');
			        break;
			    case 10: parentElement =el.parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*').parent('*');
			        break;
			}
			if (parentBackground !="") {
				parentElement.addClass('parentBackground')
							.attr({"data-stellar-background-ratio":el.data('stellar-background-ratio'), "data-stellar-horizontal-offset":el.data('stellar-horizontal-offset'), "data-stellar-vertical-offset":el.data('stellar-vertical-offset'),  "style": el.attr("style")})
							.append('<div class="jvoverlay" style="background-color:'+el.data('coloroverlay')+'; opacity:'+el.data('opacityoverlay')+';"></div>');
				el.removeAttr("data-stellar-background-ratio").removeAttr("data-stellar-horizontal-offset").removeAttr("data-stellar-vertical-offset").removeAttr("style");
			} else {
				el.append('<div class="jvoverlay" style="background-color:'+el.data('coloroverlay')+'; opacity:'+el.data('opacityoverlay')+';"></div>');
			}
			jQuery('.background').show();			
	});
	
	/**
     * Parallax background
     * @constructor
     */
    function OsParallax() {
        jQuery(window).stellar({
            scrollProperty: 'scroll',
            positionProperty: 'transform',
            horizontalScrolling: false,
            verticalScrolling:true,
            responsive: true,
            parallaxBackgrounds: true
        });
    }   

    jQuery(window).on("resize load", function () {
		OsParallax();		
	})


	// Carousel ============================
	jQuery(".carouselOwl").each(function(){ 

		var el = jQuery(this),

			items = 			(el.data('items') != "")?parseInt(el.data('items')):5,
	        itemsCustom = 		(el.data('itemscustom') != "")?el.data('itemscustom'):true,
	        itemsDesktop = 		(el.data('itemsdesktop') != "")?parseInt(el.data('itemsdesktop')):4,
	        itemsDesktopSmall = (el.data('itemsdesktopsmall') != "")?parseInt(el.data('itemsdesktopsmall')):4,
	        itemsTablet = 		(el.data('itemstablet') != "")?parseInt(el.data('itemstablet')):2,
	        itemsTabletSmall = 	(el.data('itemstabletsmall') != "")?parseInt(el.data('itemstabletsmall')):2,
	        itemsMobile = 		(el.data('itemsmobile') != "")?parseInt(el.data('itemsmobile')):1,
	        singleItem = 		(el.data('singleitem') != "")?el.data('singleitem'):false,
	        
	        slideSpeed = 		(el.data('slidespeed') != "")?el.data('slidespeed'):200,
	        paginationSpeed = 	(el.data('paginationspeed') != "")?el.data('paginationspeed'):800,
	        rewindSpeed = 		(el.data('rewindspeed') != "")?el.data('rewindspeed'):1000,

	        autoPlay = 			(el.data('autoplay') != "")?el.data('autoplay'):false,
	        stopOnHover = 		(el.data('stoponhover') != "")?el.data('stoponhover'):false,

	        navigation = 		(el.data('navigation') != "")?el.data('navigation'):false,
	        navigationText = 	["<i class=\"fa fa-angle-left\"></i>","<i class=\"fa fa-angle-right\"></i>"],
	        rewindNav = 		(el.data('rewindnav') != "")?el.data('rewindnav'):true,
	        scrollPerPage = 	(el.data('scrollperpage') != "")?el.data('scrollperpage'):false,

	        pagination = 		(el.data('pagination') == "") ? el.data('pagination') : true,
	        paginationNumbers = (el.data('paginationnumbers') != "")?el.data('paginationnumbers'):false,
	        transitionStyle = (el.data('transition') != "")?el.data('transition'):false,
	        addClassActive = (el.data('addactive') != "")?el.data('addactive'):false;

	    el.imagesLoaded(function(){
			el.owlCarousel({
				direction: jQuery("body").hasClass("rtl") ? 'rtl' : 'ltr',
				items : items,
		        itemsCustom : itemsCustom,
		        itemsDesktop : [1199, itemsDesktop],
		        itemsDesktopSmall : [991, itemsDesktopSmall],	        
		        itemsTablet : [768, itemsTablet],
		        itemsTabletSmall : [560, itemsTabletSmall],
		        itemsMobile : [479, itemsMobile],
		        singleItem : singleItem,

		        slideSpeed : slideSpeed,
		        paginationSpeed : paginationSpeed,
		        rewindSpeed : rewindSpeed,

		        autoPlay : autoPlay,
		        stopOnHover : stopOnHover,

		        navigation : navigation,
		        navigationText : navigationText,
		        rewindNav : rewindNav,
		        scrollPerPage : scrollPerPage,

		        pagination : pagination,
		        paginationNumbers : paginationNumbers,

		        addClassActive: addClassActive,
		        transitionStyle : transitionStyle
			});
		});
	});
});



(function($){
	$(document).ready(function(){
		$(".demo-headers").each(function(){
			var el = $(this);
				el.find("li:first-child").addClass("active");
				el.find("a").attr("target","_blank");
		});
		function isEmpty( el ){
		    return !$.trim(el.html())
		}
		$('.blog-featured').each(function(){
			var el = $(this);
				if (isEmpty(el)) {
					$('#block-main').css('padding','0');
				};
		});
		/* Back to Top */
	
		var offset = 220;
		var duration = 500;
		
		$('.backtotop, .btn-showmenu').click(function(event) {
			event.preventDefault();
			jQuery('html, body').animate({scrollTop: 0}, duration);
			return false;
		})

		$('.btn-addcart').each(function(){
			var el = $(this);
			el.click(function(){
				el.parents('.vmProduct').find('.addtocart-button').click();
			});
		});

		
	
		/* and Back to Top */
		$('.image-modal').each(function(){
			var el = $(this);
				el.magnificPopup({
				type: 'image',
				mainClass: 'my-mfp-zoom-in',
				removalDelay: 160
			});
		});
		$('.link-modal').each(function(){
			var el = $(this);
				el.magnificPopup({
				type: 'iframe',
				mainClass: 'my-mfp-zoom-in',
				removalDelay: 160
			});
		});
		$('.edit-modal').each(function(){
			var el = $(this);
				el.magnificPopup({
				type: 'iframe',
				mainClass: 'my-mfp-zoom-in edit-modal',
				removalDelay: 160
			});
		});

		$('.popup-modal').each(function(){
			var el = $(this);
			var product = el.data("product")
			el.magnificPopup({
				type: 'inline',
				preloader: false,
				mainClass: 'my-mfp-zoom-in edit-modal',
			});
		});
		$('.sigProThumb').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'my-mfp-zoom-in mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			}
		});

		$('[data-toggle="tooltip"]').tooltip();

		$('.panel-heading a').each(function(){
			var el 			= $(this);			
			el.click(function(){
				var group_id	= el.data("parent"),
				content 	= el.parents('.panel'),
				contents 	= $(group_id).find('.panel');
				if (content.hasClass('active')) {
					contents.removeClass('active');
				} else {
					contents.removeClass('active');
					content.addClass('active');
				}
			});
		});

		

		// Scroll to Element
		var jump=function(e){
		   if (e){
		       e.preventDefault();
		       var target = $(this).attr("href");
		   }else{
		       var target = location.hash;
		   }
		   var el = $(this);
		   // not([data-toggle="collapse"], [data-toggle="tab"], .popup-modal, .sigProThumb, .link-modal, .image-modal )
		   if ( !( (el.data('toggle') == "collapse") || (el.data('toggle') == "tab") || el.hasClass("popup-modal") || el.hasClass("sigProThumb") || el.hasClass("link-modal") || el.hasClass("sigProThumb") || el.hasClass("image-modal") ) ) {
		   		$('html,body').animate({
			       scrollTop: $(target).offset().top
			   },1000);
		   }

		}
		$('a[href^=#]').bind('click', jump);

		if (location.hash){
	        setTimeout(function(){
	            jump();
	        }, 0);
	    }

	    var pcanvasOpen 	= $(".pcanvas-btn-show"),
	    	pcanvasClose 	= $(".pcanvas-overlay, .pcanvas-close"),
	    	pcanvas 		= $('.pcanvas');
	    function showCanvas(){
	    	if ( pcanvas.hasClass('open') ) {
				pcanvas.removeClass('open');
			} else {
				pcanvas.addClass('open');
			}
	    }
	    pcanvasOpen.each(function(){
	    	$(this).click(function(){
    			showCanvas();
    		});
	    });
	    pcanvasClose.each(function(){
	    	$(this).click(function(){
    			showCanvas();
    		});
	    });


	});	
})(jQuery);

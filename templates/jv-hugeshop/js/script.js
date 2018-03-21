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
	$(window).on("load resize", function () {
		headerFix();
		if ($('#mainsite').length) {
			if ( JVMenu.getViewport("x") <= responsive) {
				nav.insertBefore( "#mainsite" );
			}
			else{        
				$(".block-mainnav-wrapper").append(nav);
			}
		};		
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
    jQuery(window).on("load resize", function () {
		OsParallax();
	});
    


	// Carousel ============================
	jQuery(".carouselOwl").each(function(){ 

		var el = jQuery(this),

			ditems = 			(el.data('items') != "")?parseInt(el.data('items')):5,
	        ditemsCustom = 		(el.data('itemscustom') != "")?el.data('itemscustom'):true,
	        ditemsDesktop = 		(el.data('itemsdesktop') != "")?parseInt(el.data('itemsdesktop')):4,
	        ditemsDesktopSmall = (el.data('itemsdesktopsmall') != "")?parseInt(el.data('itemsdesktopsmall')):4,
	        ditemsTablet = 		(el.data('itemstablet') != "")?parseInt(el.data('itemstablet')):2,
	        ditemsTabletSmall = 	(el.data('itemstabletsmall') != "")?parseInt(el.data('itemstabletsmall')):2,
	        ditemsMobile = 		(el.data('itemsmobile') != "")?parseInt(el.data('itemsmobile')):1,
	        dsingleItem = 		(el.data('singleitem') != "")?el.data('singleitem'):false,
	        
	        dslideSpeed = 		(el.data('slidespeed') != "")?el.data('slidespeed'):200,
	        dpaginationSpeed = 	(el.data('paginationspeed') != "")?el.data('paginationspeed'):800,
	        drewindSpeed = 		(el.data('rewindspeed') != "")?el.data('rewindspeed'):1000,

	        dautoPlay = 			(el.data('autoplay') != "")?el.data('autoplay'):false,
	        dstopOnHover = 		(el.data('stoponhover') != "")?el.data('stoponhover'):false,

	        dautoHeight = 		(el.data('autoheight') && el.data('autoheight') != "")?el.data('autoheight'):false,

	        dnavigation = 		(el.data('navigation') != "")?el.data('navigation'):false,
	        dnavigationNext = 	(el.data('navnexttext') && el.data('navnexttext') != "")?"<span>"+el.data('navnexttext')+"</span>":'',
	        dnavigationPrev = 	(el.data('navprevtext') && el.data('navprevtext') != "")?"<span>"+el.data('navprevtext')+"</span>":'',
	        dnavigationText = 	["<i class=\"fa fa-angle-left\"></i>" + dnavigationPrev,dnavigationNext + "<i class=\"fa fa-angle-right\"></i>"],
	        drewindNav = 		(el.data('rewindnav') != "")?el.data('rewindnav'):true,
	        dscrollPerPage = 	(el.data('scrollperpage') != "")?el.data('scrollperpage'):false,

	        dpagination = 		(el.data('pagination') == "") ? el.data('pagination') : true,
	        dpaginationNumbers = (el.data('paginationnumbers') != "")?el.data('paginationnumbers'):false,
	        dtransitionStyle = (el.data('transition') != "")?el.data('transition'):false,
	        daddClassActive = (el.data('addactive') != "")?el.data('addactive'):false;

	    el.imagesLoaded(function(){
			el.owlCarousel({
				direction: jQuery("body").hasClass("rtl") ? 'rtl' : 'ltr',
				items : ditems,
		        itemsCustom : ditemsCustom,
		        itemsDesktop : [1199, ditemsDesktop],
		        itemsDesktopSmall : [991, ditemsDesktopSmall],	        
		        itemsTablet : [768, ditemsTablet],
		        itemsTabletSmall : [560, ditemsTabletSmall],
		        itemsMobile : [479, ditemsMobile],
		        singleItem : dsingleItem,

		        slideSpeed : dslideSpeed,
		        paginationSpeed : dpaginationSpeed,
		        rewindSpeed : drewindSpeed,

		        autoPlay : dautoPlay,
		        stopOnHover : dstopOnHover,

		        autoHeight: dautoHeight,

		        navigation : dnavigation,
		        navigationText : dnavigationText,
		        rewindNav : drewindNav,
		        scrollPerPage : dscrollPerPage,

		        pagination : dpagination,
		        paginationNumbers : dpaginationNumbers,

		        addClassActive: daddClassActive,
		        transitionStyle : dtransitionStyle
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

		if ($('[data-toggle="tooltip"]').length) {
			$('[data-toggle="tooltip"]').tooltip();
		};
		$('.header-topmenu .mod_currency').on({
			"click":function(e){
		      e.stopPropagation();
		    }
		});

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
			       scrollTop: ($(this).attr("href") != "#")?$(target).offset().top:0
			   },1000);
		   }

		}
		$('a[href^="#"]').bind('click', jump);

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

	    var GSfadeHome = function(){
	        var fadeStart = 100;
	        var fadeEnd = 600;
	        var fadeRange = fadeEnd - fadeStart;
	        $(window).on('scroll', function () {
	            var posiNow = $(window).scrollTop();
	            var opa = function(){
	                if(posiNow <= fadeStart)
	                    return 1;
	                else if(posiNow >= fadeEnd)
	                    return 0;
	                else
	                    return 1 - (posiNow - fadeStart) / fadeRange;
	            };
	            $('.gs-home-slider').css('opacity', opa);
	        });
	    };
	    GSfadeHome();

	    /**
	     * Section Video
	     */
	    var GSsectionVideo = function() {
	        var sectionVideo = document.getElementById('gs-section-video');
	        var stt = 0;
	        var $playButton = $('#gs-play-section-video');
	        var $overlay = $('#gs-video-overlay');

	        var playV = function() {
	            sectionVideo.play();
	            $playButton.addClass('gs-played');
	            $overlay.addClass('gs-video-played');
	            stt = 1;
	        };

	        var pauseV = function() {
	            sectionVideo.pause();
	            $playButton.removeClass('gs-played');
	            $overlay.removeClass('gs-video-played');
	            stt = 0;
	        };

	        $overlay.on('click', function(event) {
	            // $(this).css('background', 'red');
	            if (stt === 0 && $playButton.hasClass('gs-played')) {
	                playV();
	            }
	            else {
	                pauseV();
	            }
	            event.preventDefault();
	        });

	        $playButton.on('click', function(event) {
	            $(this).addClass('gs-played');
	            event.preventDefault();
	        });

	    };

	    GSsectionVideo();

	    /** 
	    * Menu header 3 
	    **/
	    var GSHeaderMenu = function() {
	    	var $button = $('#gs-nav-static');
	    	var $wrapper = $('.header-inner');
	    		$button.on('click', function(event) {
	    			$wrapper.toggleClass('open');
	    		});
	    };
	    GSHeaderMenu();

	    function OsNavMainMenu() {

	        var $nav_MainMenu = $(".position-left-menu");

	        $nav_MainMenu.find("a[href='#'], .parent > a").on('click', function (event) {
	            event.preventDefault();
	        });

	        $nav_MainMenu.each(function () {
	            $(this).find(".parent > a, .parent > span").each(function () {
	                $(this).siblings('.divsubmenu').hide();
	                $(this).on("click", function (event) {
	                    event.preventDefault();
	                    menu_DropdownTrigger(this);
	                });
	            });

	            function menu_DropdownTrigger(selector) {
	                if ($(selector).hasClass('menu-trigger')) {
	                    $(selector).parent('li')
	                        .find('a, span')
	                        .removeClass('menu-trigger')
	                        .parent('li')
	                        .children('.divsubmenu')
	                        .slideUp(400);
	                } else {
	                    $(selector)
	                        .addClass('menu-trigger')
	                        .parent('li')
	                        .siblings()
	                        .find('a, span')
	                        .removeClass('menu-trigger')
	                        .parent('li')
	                        .children('.divsubmenu')
	                        .slideUp(400);

	                    $(selector)
	                        .siblings('.divsubmenu').slideDown(400);
	                }
	            }
	        });
	    }

	    OsNavMainMenu();

	    function JvHeightLeftMenu() {
	    	var header = $('.header-7'),
	    		footer = $('.blk-footer'),
	    		footerTop = $('.blk-footer-top'),
	    		buttomb = $('.blk-buttomb'),
	    		leftmenu = $('.left-menu'),
	    		leftmenuinner = $('.left-menu-inner'),
	    		leftbottom = $('.position-left-bottom'),
	    		lmBottom = 0,
	    		lfBottom = 0;
	    		if (footer.length) {
	    			lmBottom += footer.outerHeight();
	    		};
	    		if (buttomb.length) {
	    			lmBottom += buttomb.outerHeight();
	    		};
	    		if (leftbottom.length) {
	    			lfBottom += leftbottom.outerHeight();
	    		};
	    		if (header.length && footerTop.length) {
	    			lmBottom += footerTop.outerHeight();
	    		};
	    		leftmenu.css('bottom', lmBottom);
	    		leftmenuinner.css('bottom', lfBottom + 65);
	    }
	    $(window).on("load resize", function () {
			JvHeightLeftMenu();
		});

		function JvMenuCenter(){
			var headerStyle = $('.header-content-14'),
				logo 		= $('.header-logo'),
				header 		= $('.header-inner'),
				menu 		= $('#block-mainnav .fxmenu'),
				item 		= menu.find('li.level1'),
				banner 		= $('.header-banner'),
				tool 		= $('.header-topmenu'),
				container 	= $('.header-content .container'),
				fxcolumns   = $('.level1.cols4 > .fxcolumns, .level1.cols5 > .fxcolumns, .level1.cols6 > .fxcolumns'),
				logoWidth 	= logo.outerWidth() / 2,
				toolWidth 	= tool.outerWidth() / 2,
				bannerWidth = banner.outerWidth() / 2,
				conWidth	= (container.outerWidth() - 30) / 2,
				headerWidth = header.outerWidth() /2, 
				itemNumber 	= item.length,
				number 		= Math.ceil(itemNumber / 2) - 1,
				width 		= 0,
				i 			= 0;
				if (headerStyle.length) {
					if (banner.length && tool.length) {
						number 		+= 1;
					};
					// make out menu item center
					if (itemNumber > 1) {
						item.eq(number).addClass('menu-center').css({"margin-right": logoWidth}).next('li').css({"margin-left": logoWidth});
					};
					// calculate margin left header inner
					item.each(function(){
						if (i <= number) {
							width += item.eq(i).outerWidth(true) + 5;
						};
						i++;
					});
					var marginNunber 	= ( headerWidth - width - ( ( (container.outerWidth() -30) - header.outerWidth() ) /2 ) ),
						margin 			= "",
						translate 		= "";
					if ($('body.ltr').length) {
						translate = "translate("+ (width - 4)*(-1) +"px, 0)";
						margin = "margin-right:" + marginNunber + "px";
					} else {
						translate = "translate("+ (width - 4) +"px, 0)";
						margin = "margin-left:" + marginNunber + "px";
					};
					fxcolumns.attr({"style":margin});
					header.attr({"style": "visibility: visible; transform: "+ translate +";-webkit-transform: "+ translate +";-ms-transform: "+ translate +";-o-transform: "+ translate +";"});					
				};
		}		
		$(window).on("load resize", function () {
			JvMenuCenter();
		});
	});	
})(jQuery);

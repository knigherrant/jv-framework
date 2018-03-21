 jQuery(document).ready(function ($) {
	// Enable sliders
	$('.jvsc-slider').each(function(){
		
		$(this).owlCarousel({
			singleItem: true,
			transitionStyle : 'fade',
			autoPlay : $(this).data('autoplay'),
			slideSpeed : $(this).data('slide-speed'),
			navigation : $(this).data('navigation'),
			pagination : $(this).data('pagination') != false,
			paginationNumbers : $(this).data('pagination') == 'number',
			navigationText: ['',''],
			lazyLoad: true
		});
	});
     $('.jv-lightbox').each(function(){
         var type = $(this).data('mfp-type');
         $(this).magnificPopup({
             type : type
         });
     });

 });
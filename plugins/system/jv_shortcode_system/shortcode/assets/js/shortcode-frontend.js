jQuery(document).ready(function ($) {
	// Tabs
	$('body:not(.jv-other-shortcodes-loaded) .jv-tabs-nav span').on('click',  function (e) {
		var $tab = $(this),
			index = $tab.index(),
			is_disabled = $tab.hasClass('jv-tabs-disabled'),
			$tabs = $tab.parent('.jv-tabs-nav').children('span'),
			$panes = $tab.parents('.jv-tabs').find('.jv-tabs-pane'),
			$gmaps = $panes.eq(index).find('.jv-gmap:not(.jv-gmap-reloaded)');
		// Check tab is not disabled
		if (is_disabled) return false;
		// Hide all panes, show selected pane
		$panes.hide().eq(index).show();
		// Disable all tabs, enable selected tab
		$tabs.removeClass('jv-tabs-current').eq(index).addClass('jv-tabs-current');
		// Reload gmaps
		if ($gmaps.length > 0) $gmaps.each(function () {
			var $iframe = $(this).find('iframe:first');
			$(this).addClass('jv-gmap-reloaded');
			$iframe.attr('src', $iframe.attr('src'));
		});
		// Set height for vertical tabs
		tabs_height();
		e.preventDefault();
	});

	// Activate tabs
	$('.jv-tabs').each(function () {
		var active = parseInt($(this).data('active')) - 1;
		$(this).children('.jv-tabs-nav').children('span').eq(active).trigger('click');
		tabs_height();
	});

	// Activate anchor nav for tabs and spoilers
	anchor_nav();
	
	function tabs_height() {
		$('.jv-tabs-vertical, .jv-tabs-vertical-right').each(function () {
			var $tabs = $(this),
				$nav = $tabs.children('.jv-tabs-nav'),
				$panes = $tabs.find('.jv-tabs-pane'),
				height = 0;
			$panes.css('min-height', $nav.outerHeight(true));
		});
	}
	function anchor_nav() {
		// Check hash
		if (document.location.hash === '') return;
		// Go through tabs
		$('.jv-tabs-nav span[data-anchor]').each(function () {
			if ('#' + $(this).data('anchor') === document.location.hash) {
				var $tabs = $(this).parents('.jv-tabs');
					 
				// Activate tab
				$(this).trigger('click');
				// Scroll-in tabs container
				window.setTimeout(function () {
					$(window).scrollTop($tabs.offset().top - 10);
				}, 100);
			}
		});
		// Go through spoilers
		$('.jv-spoiler[data-anchor]').each(function () {
			if ('#' + $(this).data('anchor') === document.location.hash) {
				var $spoiler = $(this);
				// Activate tab
				if ($spoiler.hasClass('jv-spoiler-closed')) $spoiler.find('.jv-spoiler-title:first').trigger('click');
				// Scroll-in tabs container
				window.setTimeout(function () {
					$(window).scrollTop($spoiler.offset().top  - 10);
				}, 100);
			}
		});
	}

	if ('onhashchange' in window) $(window).on('hashchange', anchor_nav);
	
	/**
	 * Accordion
	 */
	$('.jv-accordion .jv-spoiler-content').hide();
	$('.jv-accordion').each(function(){
		if($(this).data('active-first') == 'yes'){
			$(this).find('.jv-spoiler').eq(0).addClass('jv-spoiler-opened').children('.jv-spoiler-content').show();
		}
	});
	$('.jv-spoiler-title').click(function(e){
		var $spoiler = $(this).parent();
		var $accordion = $spoiler.parent();
		$accordion.find('.jv-spoiler-opened .jv-spoiler-content').stop();
		if($spoiler.hasClass('jv-spoiler-opened')){
		
			$spoiler.removeClass('jv-spoiler-opened');
			$(this).next('.jv-spoiler-content').slideUp(300);
			
		}else{
			$accordion.find('.jv-spoiler-opened .jv-spoiler-content').slideUp(300);
			$accordion.find('.jv-spoiler').removeClass('jv-spoiler-opened');
			$spoiler.addClass('jv-spoiler-opened');
			$(this).next('.jv-spoiler-content').slideDown(300);
		}
		
	});
	
	//$('body').addClass('jv-other-shortcodes-loaded');
});
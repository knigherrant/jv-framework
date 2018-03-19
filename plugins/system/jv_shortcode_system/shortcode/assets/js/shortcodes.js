	
jQuery(document).ready(function ($) {
	// Tabs
	$('body:not(.jv-other-shortcodes-loaded)').on('click', '.jv-tabs-nav span', function (e) {
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
				var $tabs = $(this).parents('.jv-tabs'),
					bar = ($('#wpadminbar').length > 0) ? 28 : 0;
				// Activate tab
				$(this).trigger('click');
				// Scroll-in tabs container
				window.setTimeout(function () {
					$(window).scrollTop($tabs.offset().top - bar - 10);
				}, 100);
			}
		});
		// Go through spoilers
		$('.jv-spoiler[data-anchor]').each(function () {
			if ('#' + $(this).data('anchor') === document.location.hash) {
				var $spoiler = $(this),
					bar = ($('#wpadminbar').length > 0) ? 28 : 0;
				// Activate tab
				if ($spoiler.hasClass('jv-spoiler-closed')) $spoiler.find('.jv-spoiler-title:first').trigger('click');
				// Scroll-in tabs container
				window.setTimeout(function () {
					$(window).scrollTop($spoiler.offset().top - bar - 10);
				}, 100);
			}
		});
	}

	if ('onhashchange' in window) $(window).on('hashchange', anchor_nav);
	
	
	$('body').addClass('jv-other-shortcodes-loaded');
	
});
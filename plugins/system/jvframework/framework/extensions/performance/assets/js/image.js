(function($){
	$(document).ready(function(){
		fleximage($(window).width());
	 });
	
	$(window).resize(function() {
		fleximage($(window).width());
     });
	
	function fleximage($width) {
		$("img.fleximg").each(function(){
			var $this = $(this);
			$this.removeClass('hidden').data('original', '?fleximg=1&s='+$width+'&src='+ $this.data('url')).show();
			this.loaded = false;			
		});				
		$("img.fleximg").lazyload({ failure_limit : 10, threshold : 200, skip_invisible : false});
	}
})(jQuery)
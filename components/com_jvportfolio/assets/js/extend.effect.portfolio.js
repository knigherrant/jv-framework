(function($){
    var animationDelay = Modernizr.prefixed('animationDelay');
    $.extend($.fn, {
        pfoEffect: function(name){
            
            var fn = {
                'after-imagesLoaded': function(e, delay){
                    return this.each(function(i){
                        var t = ((i + 1) * delay) + 'ms',
                            $this = $(this); 
                        $this.find($this.data('box-effect')).css({animationDelay: t}).addClass(e);
                    });
                }
            };
            
            return fn[name].apply(this, Array.prototype.slice.call(arguments, 1))
        } 
    });
})(jQuery);
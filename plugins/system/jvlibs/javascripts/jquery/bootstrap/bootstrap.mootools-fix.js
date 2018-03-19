(function($){
    var timeOut = setInterval(function(){
        if(!window.MooTools) return;
        clearInterval(timeOut);
         var mHide = Element.prototype.hide;
            var mShow = Element.prototype.show;
            var mSlide = Element.prototype.slide;
            var isBs = function(data){
                return false;
                for(var x in data){
                    if(x.indexOf('bs.') === 0) return true;
                }
            }

            Element.implement({
                hide: function () {
                    //console.log(this);
                    //if(isBs($(this).data())) return this;
                    return mHide.apply(this, v);
                },
                show: function (v) {
                    if(isBs($(this).data())) return this;
                    return mShow.apply(this, v);
                },
                slide: function (v) {
                    if(isBs($(this).data())) return this;
                    return mSlide.apply(this, v);
                }
            });
    },100);
})(jQuery);
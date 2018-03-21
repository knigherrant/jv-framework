(function() {
    var triggerBttn = document.getElementById( 'trigger-overlay' ),
        overlay = document.querySelector( 'div.menuoverlay' ),
        body = document.querySelector( 'body' ),
        closeBttn = overlay.querySelector( 'button.overlay-close' );
        transEndEventNames = {
            'WebkitTransition': 'webkitTransitionEnd',
            'MozTransition': 'transitionend',
            'OTransition': 'oTransitionEnd',
            'msTransition': 'MSTransitionEnd',
            'transition': 'transitionend'
        },
        transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
        support = { transitions : Modernizr.csstransitions };

    function toggleOverlay() {
        if( classie.has( overlay, 'open' ) ) {
            classie.remove( overlay, 'open' );
            classie.remove( body, 'openOverlay' );
            classie.add( overlay, 'off' );
            var onEndTransitionFn = function( ev ) {
                if( support.transitions ) {
                    if( ev.propertyName !== 'visibility' ) return;
                    this.removeEventListener( transEndEventName, onEndTransitionFn );
                }
                classie.remove( overlay, 'off' );
            };
            if( support.transitions ) {
                overlay.addEventListener( transEndEventName, onEndTransitionFn );
            }
            else {
                onEndTransitionFn();
            }
        }
        else if( !classie.has( overlay, 'off' ) ) {
            classie.add( overlay, 'open' );
            classie.add( body, 'openOverlay' );
        }
    }

    triggerBttn.addEventListener( 'click', toggleOverlay );
    closeBttn.addEventListener( 'click', toggleOverlay );
})();


(function($){
    $(document).ready(function(){
        $('.menu .parent > span, .menu .parent > a').click(
        function(event) {
            var el = $(this); 
            event.preventDefault();               
            if (el.next('.divsubmenu').is(':hidden')) {
                el.parents('.menu').find('.divsubmenu:visible').slideUp(120,'linear');
                el.next('.divsubmenu').slideDown(120,'linear');
            } else{
                el.next('.divsubmenu').slideUp(120,'linear');
            }
        });
    }); 
})(jQuery);
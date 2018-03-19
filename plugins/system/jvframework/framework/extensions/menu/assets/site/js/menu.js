var JVMenu = (function($) {

    // based on http://responsejs.com/labs/dimensions/
    function getViewport(axis) {
        var client, inner, docElem = document.documentElement;
        if (axis === 'x') {
            client = docElem['clientWidth'];
            inner = window['innerWidth'];
        } else if (axis === 'y') {
            client = docElem['clientHeight'];
            inner = window['innerHeight'];
        }

        return client < inner ? inner : client;
    }

    var

        menu = function(selector, ops) {

        selector = $(selector).removeClass('cssmenu');

        ops = $.extend({}, menu.options, ops);

        //selector.removeClass('cssmenu');

        var

            $window = $(window).resize(function() {

                if ( /*$window.width()*/ getViewport('x') <= ops.responsive) {

                    isMobile || $this.trigger('change', [isMobile = true]);

                } else {

                    isMobile && $this.trigger('change', [isMobile = false]);

                }

            }),

            rtl = selector.css('direction') == 'rtl',

            isMobile = /*$window.width()*/ getViewport('x') <= ops.responsive,

            $this = $(this).bind('change', function(e, touch) {

                if (touch) {

                    selector.addClass('fxmenu-touch').removeClass('fxmenu');

                    subs.each(function() {

                        var

                            $this = $(this),

                            data = $this.data(),

                            parent = data._parent

                        ;

                        selector.after($this.addClass('fxmenu-touch'));

                        data._btnBack = $('<a>', {
                            'class': 'touch-btnBack',
                            href: 'javascript:void(0)'
                        }).click(function() {

                            $this.removeClass('show');

                            parent.parents('.show-item:first').removeClass('show-item');

                        }).append($('<span>', {
                            'class': 'btn-icon'
                        }), $('<span>', {
                            'class': 'btn-text'
                        }).append(parent.find('.fx-title').text()));

                        $this.prepend(data._btnBack);

                    });

                    menuPanel.attr('id', 'block-mainnav-mobile');

                } else {

                    selector.removeClass('fxmenu-touch').addClass('fxmenu');

                    subs.each(function() {

                        var

                            $this = $(this),

                            data = $this.data(),

                            parent = data._parent

                        ;

                        parent.append($this.removeClass('fxmenu-touch'));

                        data._btnBack && data._btnBack.remove();

                    });



                    menuPanel.attr('id', 'block-mainnav');

                }

            }),

            toggleMenu = $('.flexMenuToggle'),

            wrapper = $('#wrapper'),

            menuPanel = $('#block-mainnav'),

            menuAfter = menuPanel.next(),

            mainSite = $('#mainsite')

        ;

        $this.bind('change', function(e, isMobile) {

            if (isMobile) {

                wrapper.prepend(menuPanel);

            } else {

                menuAfter.before(menuPanel);

            }

        });

        var TouchOpens = $();

        $(document).bind('touchstart', function() {

            TouchOpens.filter('.hover').trigger('mouseleave');

            TouchOpens = $();

        });



        /**/



        var setUp = function(s, ops) {

            s = $(s);

            var

                sub = s.children('.fx-subitem'),

                timeOut

            ;

            if (!sub.length) return;

            s.hover(function() {

                if (isMobile) return;

                clearTimeout(timeOut);

                timeOut = setTimeout(function() {

                    if (!sub.is(':visible')) {

                        sub.css({

                            visibility: 'hidden',

                            display: 'block',

                            left: '',

                            right: ''

                        });

                        var

                            of = sub.offset(),

                            width = sub.outerWidth()

                        ;

                        if (rtl) {

                            if (of.left < 0) {

                                sub.css({

                                    left: -width + (sub.parent().width() - sub.position().left),

                                    right: 'auto'

                                });

                                of = sub.offset();

                                if (of.left + width > $(window).width()) sub.css('left', sub.position().left - of.left);

                            }

                        } else {

                            if (of.left + width > $(window).width()) {

                                sub.css({

                                    left: -width + (sub.parent().width() - sub.position().left)

                                });

                                of = sub.offset();

                                if (of.left < 0) sub.css('left', sub.position().left - of.left);

                            }

                        }

                        sub.css({

                            visibility: '',

                            display: 'none'

                        });

                    }

                    TouchOpens.push(s.addClass('hover')[0]);

                    menu.effects[ops.effect](sub, ops, 'show');

                }, ops.delay);

            }, function() {

                if (isMobile) return;

                clearTimeout(timeOut);

                timeOut = setTimeout(function() {

                    if (!sub.is(':visible')) return;

                    menu.effects[ops.effect](sub, ops, 'hide');

                    s.removeClass('hover');

                }, ops.delay);

            })

        };

        selector.children('.fxsubmenu').each(function() {

            setUp(this, ops.main);

            $(this).find('.fxsubmenu').each(function() {

                setUp(this, ops.sub);

            });

        });



        var subs = selector.find('.fx-subitem').each(function() {

            var $this = $(this);

            var li = $this.data()._parent = $this.parent();

            return;

            li.bind('touchstart', function(e) {

                //e.preventDefault();

                if (isMobile || li.hasClass('hover')) return;

                TouchOpens.push(li[0]);

                li.trigger('mouseenter')

                li.parent().children('.hover').trigger('mouseleave').find('li.hover').trigger('mouseleave');

                return false;

            });

        });

        (function() {

            var

                root = selector.parent(),

                hideMenu = function() {

                    $body.removeClass('show-items');

                    mainSite.one('webkitTransitionEnd transitionend OTransitionEnd', function() {

                        $body.is('.showmenu.hidemenu') && $body.removeClass('hidemenu showmenu');

                    });

                    $body.addClass('hidemenu');

                },

                showMenu = function() {

                    $body.addClass('showmenu');

                    mainSite.one('webkitTransitionEnd transitionend OTransitionEnd', function() {

                        $body.addClass('show-items');

                    });

                }

            ;

            toggleMenu.click(function() {

                if ($body.hasClass('showmenu')) hideMenu();

                else showMenu();

            });

            var $body = $('body');



            selector.find('.iconsubmenu').each(function() {

                var

                    button = $(this),

                    li = button.parent('li'),

                    sub = li.children('.fx-subitem'),

                    panel = li.parents('.fx-subitem:first'),

                    level = button.parents('.hasChild').length - button.parents('.li-group-title').length

                ;

                if (!panel.length) panel = li.parent();

                button.click(li.is('.li-group-title') ? function() {

                    li.toggleClass('hide-item');

                } : function() {

                    button;

                    sub.addClass('show');

                    panel.addClass('show-item');

                });

            })

        })();

        $this.trigger('change', [isMobile]);

    }





    menu.effects = {

        fade: function(s, ops, mode) {

            if (mode === 'show') {

                if (s.is(':visible')) {

                    if (parseFloat(s.css('opacity')) == 1) return;

                    s.stop().animate({
                        opacity: 1
                    }, ops.duration);

                } else {

                    s.css({

                        display: 'block',

                        opacity: 0

                    }).animate({
                        opacity: 1
                    }, ops.duration);

                }

                return;

            }

            if (!s.is(':visible')) return;

            s.stop().animate({
                opacity: 0
            }, ops.duration, function() {

                s.css({
                    'display': '',
                    'opacity': ''
                });

            });

        },

        slide: function(s, ops, mode) {

            var createrP = function() {

                s.css({

                    display: 'block',

                    visibility: 'hidden'

                });

                var

                    p = $('<div>').addClass('fx-p').css({
                        overflow: 'hidden'
                    }),

                    props = {}

                ;

                $.each(['left', 'top', 'position'], function() {

                    props[this.toString()] = s.css(this.toString());

                })

                p.css(props);

                s.after(p);

                p.append(s.css({

                    position: 'relative',

                    top: 0,

                    left: 0,

                    visibility: ''

                }));



                p.css({

                    width: p.width(),

                    height: p.height()

                });



                p.data().restore = function() {

                    p.after(s.css(props)).remove();

                }



                return p;

            }





            if (mode === 'show') {

                if (s.is(':visible')) {

                    var p = s.parent();

                    if (p.is(':not(.fx-p)')) return;

                    console.log('');

                    s.stop().animate({
                        left: 0
                    }, ops.duration, function() {

                        p.data().restore();

                    });

                } else {

                    var p = createrP();

                    s.css({

                        left: -p.width()

                    }).animate({
                        left: 0
                    }, ops.duration, function() {

                        p.data().restore();

                    });

                }

                return;

            }



            if (!s.is(':visible')) return;

            var p = s.parent();

            if (p.is(':not(.fx-p)')) p = createrP();

            s.stop().animate({
                left: -p.width()
            }, ops.duration, function() {

                p.data().restore();

                s.hide();

            });

        }

    }

    menu.getViewport = getViewport;



    return menu;

})(jQuery);

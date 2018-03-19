(function ($) {
    var touchSlide = function (el, ops) {
        ops = $.extend({}, touchSlide.options, ops);
        el = $(el);
        var
            aniObj = { x: 0, y: 0 },
            $doc = $(document),
            timeout = null,
            moveEvents = [],
            startEvent = null,
            events = {
                start: function (e) {
                    clearTimeout(timeout);
                    endEvent = null;
                    startEvent = {
                        clientX: e.clientX,
                        clientY: e.clientY,
                        timeStamp: $.now()
                    }
                    moveEvents = [startEvent];
                    $doc.mousemove(events.move).mouseup(events.end);
                    //e.preventDefault();
                    return ops.mousedown();
                },
                move: function (e) {
                    moveEvents.push({
                        clientX: e.clientX,
                        clientY: e.clientY,
                        timeStamp: $.now()
                    });
                    var obj = {
                        x: e.clientX - startEvent.clientX,
                        y: e.clientY - startEvent.clientY
                    }
                    return ops.drag(obj);
                },
                end: function (e) {
                    $doc
                    .unbind('mousemove', events.move)
                    .unbind('mouseup', events.end);
                    calculator();
                    return false;
                }
            },
            calculator = function () {
                var 
                    lastMove = moveEvents[moveEvents.length - 2 - ops.callLast] || moveEvents.shift(),
                    endEvent = moveEvents.pop()
                ;
                
                if(moveEvents.length < 2) return ops.end();
                var t = endEvent.timeStamp - lastMove.timeStamp
                if (t > ops.breackTime) return ops.end();

                var
                    s = {
                        x: endEvent.clientX - lastMove.clientX,
                        y: endEvent.clientY - lastMove.clientY
                    }
                ;
                if(ops.distance(s) == false)  return ops.end();
                var
                    v = {
                        x: s.x / t * ops.hackSpeed,
                        y: s.y / t * ops.hackSpeed
                    }
                ;
                (function (v) {
                    var
                        a = {
                            x: (v.x > 0 ? -1 : 1) * ops.friction,
                            y: (v.y > 0 ? -1 : 1) * ops.friction
                        },
                        tm = {
                            x: -v.x / a.x,
                            y: -v.y / a.y
                        }
                    ;
                    

                    var step = function () {
                        var t = $.now() - endEvent.timeStamp; 
                        if (t > tm.x && t > tm.y) {
                            return ops.end();
                        } 
                        var s = {
                            x: -(a.x * t * t / 2 + v.x * t),
                            y: -(a.y * t * t / 2 + v.y * t)
                        }
                        if(ops.step(s,t) == false) return;
                        timeout = setTimeout(step, 1000 / ops.fps);
                    }
                        
                    if (ops.start(a, tm) === false) return ops.end();
                    step();
                })(v);
            }
        ;
        ops.mouse && el.mousedown(events.start);
        var getTouch = function (e) {
            var touches = e.originalEvent.touches;
            if (touches.length > 1) return false;
            var touch = touches[0];
            touch.timeStamp = e.timeStamp;
            return touch;
        }
        
        var evtsTouch = {
            start: function (e) {
                var touch = getTouch(e);
                if (!touch) return;
                $doc
                .unbind('touchstart',evtsTouch.end)
                .one('touchstart',evtsTouch.end)
                .bind('touchmove', evtsTouch.move)
                .bind('touchend', evtsTouch.end);
                return events.start(touch);;
            },
            move: function (e) {
                var touch = getTouch(e);
                return events.move(touch);
            },
            end: function (e) {

                $doc
                .unbind('touchstart',evtsTouch.end)
                .unbind('touchmove', evtsTouch.move)
                .unbind('touchend', evtsTouch.end);
                events.end();
            }
        }

        el.bind('touchstart', evtsTouch.start);
    }
    touchSlide.options = {
        friction: 0.01,
        callLast: 15,
        breackTime: 500,
        fps: 60,
        hackSpeed: 2,
        mouse: true,
        mousedown: function () { },
        distance: function(){},
        drag: function(){},
        step: function () { },
        start: function () { },
        end: function () { }
    }

    $.fn.touchSlide = function (ops) {
        return new touchSlide(this,ops);
    };
})(jQuery);
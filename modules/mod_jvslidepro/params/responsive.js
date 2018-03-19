/**
# mod_jvslidepro - JV Slide Pro
# @versions: 1.5.x,1.6.x,1.7.x,2.5.x
# ------------------------------------------------------------------------
# author    Open Source Code Solutions Co
# copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.joomlavi.com
# Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

var JVJSlideParams = window.JVJSlideParams || {};
;(function(){
    JVJSlideParams.responsive = {
        field: 'panel',
        item: {
            type: {
                field: 'select2',
                label: 'Effect',
                value: 'flow',
                title: 'Use slide effect with type',
                item:{
                    slide: 'Slide',
                    vslide: 'Vertical slide',
                    flow: 'Flow',
                    flow2: 'Flow 2',
                    fade: 'Fade',
                    child: 'Children effect',
                    slider: 'Slider'
                }
            },
            itemWidth: {
                field: 'input',
                label: 'Item width(%,px)',
                title: 'Width of silde item<br> accept % or px <br> default: 100%',
                value: '100%'
            },
            duration: {
                field: 'input',
                label: 'Duration (ms)',
                title: 'Duration on effect change slide item',
                value: 700
            },
            active: {
                field: 'input',
                label: 'Start at',
                title: 'Begin slide active slide at index',
                value: 0
            },
            auto: {
                field: 'input',
                label: 'Auto time (ms)',
                title: 'Integer ms for auto play, <br> 0 to disable auto play',
                value: 0
            },
            easing:{
                field: 'select2',
                label: 'Easing',
                value: 'linear',
                item: {       
                    linear : 'linear',
                    easeInQuad : 'easeInQuad',
                    easeOutQuad : 'easeOutQuad',
                    easeInOutQuad : 'easeInOutQuad',
                    easeInCubic : 'easeInCubic',
                    easeOutCubic : 'easeOutCubic',
                    easeInOutCubic : 'easeInOutCubic',
                    easeInQuart : 'easeInQuart',
                    easeOutQuart : 'easeOutQuart',
                    easeInOutQuart : 'easeInOutQuart',
                    easeInQuint : 'easeInQuint',
                    easeOutQuint : 'easeOutQuint',
                    easeInOutQuint : 'easeInOutQuint',
                    easeInSine : 'easeInSine',
                    easeOutSine : 'easeOutSine',
                    easeInOutSine : 'easeInOutSine',
                    easeInExpo : 'easeInExpo',
                    easeOutExpo : 'easeOutExpo',
                    easeInOutExpo : 'easeInOutExpo',
                    easeInCirc : 'easeInCirc',
                    easeOutCirc : 'easeOutCirc',
                    easeInOutCirc : 'easeInOutCirc',
                    easeInElastic : 'easeInElastic',
                    easeOutElastic : 'easeOutElastic',
                    easeInOutElastic : 'easeInOutElastic',
                    easeInBack : 'easeInBack',
                    easeOutBack : 'easeOutBack',
                    easeInOutBack : 'easeInOutBack',
                    easeInBounce : 'easeInBounce',
                    easeOutBounce : 'easeOutBounce',
                    easeInOutBounce : 'easeInOutBounce'
                }
            },
            hotkey: {
                field: 'input',
                type: 'checkbox',
                label: 'Hotkey',
                value: true
            },
            loop: {
                field: 'input',
                type: 'checkbox',
                label: 'Loop slides',
                value: true
            },
            touch: {
                field: 'input',
                type: 'checkbox',
                label: 'Touch swipe',
                title: 'Use touch to change slide',
                value: true
            },
            drag: {
                field: 'input',
                type: 'checkbox',
                label: 'Mouse drag',
                title: 'Use mouse drag to change slide on PC',
                value: true
            },
            mousewheel: {
                field: 'input',
                type: 'checkbox',
                label: 'Mouse wheel',
                title: 'Use mouse wheel to change slide',
                value: true
            },
            nav: {
                field: 'input',
                type: 'checkbox',
                label: 'Nav',
                title: 'Enable navigation buttons',
                value: true
            },
            navCfg: {
                field: 'panel',
                label: 'Nav config',
                item: {
                    thumbs: {
                        field: 'input',
                        type: 'checkbox',
                        label: 'Nav with thumbs',
                        title: 'Show navigation with thumnails of first image on slide',
                        value: true
                    },
                    title: {
                        field: 'input',
                        type: 'checkbox',
                        label: 'Nav with title',
                        title: 'Show navigation with title',
                        value: false
                    },
                    'break': {
                        field: 'input',
                        label: 'Slide break',
                        title: 'Min and max slide item',
                        value: 0
                    }, 
                    slide: {
                        field: 'select2',
                        type: 'checkbox',
                        label: 'Nav with Slide',
                        title: 'Show navigation with slide',
                        value: 'none',
                        item:{
                            none: 'No slide',
                            slide: 'Slide horizontal',
                            flow: 'Flow',
                            flow2: 'Flow 2',
                            vslide: 'Slide vertical',
                            circle: 'Circle',
                            circle2: 'Circle 2'
                            
                        }
                    }
                }
            },
            theme: {
                field: 'select2',
                label: 'Theme',
                item:{
                    'default': 'Default'
                },
                value: 'default'
            }
        }
    }
})(); 
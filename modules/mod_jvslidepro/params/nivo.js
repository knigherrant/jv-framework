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
    JVJSlideParams.nivo = {
        effect: {
            value: 'random',
            field: 'select2',
            label: 'Choose effect',
            item: {
                'random':'random',
                'sliceDown' : 'sliceDown',
                'sliceDownLeft':'sliceDownLeft',
                'sliceUp':'sliceUp',
                'sliceUpLeft':'sliceUpLeft',
                'sliceUpDown':'sliceUpDown',
                'sliceUpDownLeft':'sliceUpDownLeft',
                'fold':'fold',
                'fade':'fade',
                'slideInRight': 'slideInRight',
                'slideInLeft': 'slideInLeft',
                'boxRandom':'boxRandom',
                'boxRain':'boxRain',
                'boxRainReverse':'boxRainReverse',
                'boxRainGrow':'boxRainGrow',
                'boxRainGrowReverse':'boxRainGrowReverse'
            }
        },
        slices: {
            label: 'Slides',
            value: 15,
            field: 'input',
            type: 'text'
        },
        boxCols: {
            label: 'Box columns',
            value: 8,
            field: 'input',
            type: 'text'
        },
        boxRows: {
            label: 'Box rows',
            value: 4,
            field: 'input',
            type: 'text'
        },
        animSpeed: {
            label: 'Animate speed',
            value: 500,
            field: 'input',
            type: 'text'
        },
        pauseTime: {
            label: 'Pause time',
            value: 3000,
            field: 'input',
            type: 'text'
        },
        startSlide: {
            label: 'Start slide',
            value: 0,
            field: 'input',
            type: 'text'
        },
        captionOpacity: {
            label: 'Caption opacity',
            value: 0.8,
            field: 'input',
            type: 'text'
        },
        prevText: {
            label: 'Prev text',
            value: 'Prev',
            field: 'input',
            type: 'text'
        },
        nextText: {
            label: 'Next text',
            value: 'Next',
            field: 'input',
            type: 'text'
        },
        directionNav: {
            label: 'Direction nav',
            value: true,
            field: 'input',
            type: 'checkbox'
        },
        controlNav: {
            label: 'Control nav',
            value: true,
            field: 'input',
            type: 'checkbox'
        },
        controlNavThumbs: {
            label: 'Nav thumbnails',
            value: false,
            field: 'input',
            type: 'checkbox'
        },
        keyboardNav: {
            label: 'Keyboard nav',
            value: true,
            field: 'input',
            type: 'checkbox'
        },
        pauseOnHover: {
            label: 'Pause on hover',
            value: true,
            field: 'input',
            type: 'checkbox'
        },
        manualAdvance: {
            label: 'Manual advance',
            value: false,
            field: 'input',
            type: 'checkbox'
        },
        theme: {
            label: 'Theme',
            value: 'default',
            field: 'select',
            item:{
                ''      : 'None',
                'default': 'Default',
                'bar'   : 'Bar',
                'dark'  : 'Dark',
                'light' : 'Light'
            }
        }
    }
})(); 
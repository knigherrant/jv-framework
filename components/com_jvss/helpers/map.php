<?php

/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */
defined('_JEXEC') or die;

class JvssFrontendMap {
    
    public static function transit() {
        return array(
            'movexin'               => 'x',
            'moveyin'               => 'y',
            'movezin'               => 'z',
            'rotationxin'           => 'rotationX',
            'rotationyin'           => 'rotationY',
            'rotationzin'           => 'rotationZ',
            'scalexin'              => 'scaleX',
            'scaleyin'              => 'scaleY',
            'skewxin'               => 'skewX',
            'skewyin'               => 'skewY',
            'captionopacityin'      => 'opacity',
            'captionperspectivein'  => 'transformPerspective',
            'originin'              => 'transformOrigin',
            'movexout'              => 'x',
            'moveyout'              => 'y',
            'movezout'              => 'z',
            'rotationxout'          => 'rotationX',
            'rotationyout'          => 'rotationY',
            'rotationzout'          => 'rotationZ',
            'scalexout'             => 'scaleX',
            'scaleyout'             => 'scaleY',
            'skewxout'              => 'skewX',
            'skewyout'              => 'skewY',
            'captionopacityout'     => 'opacity',
            'captionperspectiveout' => 'transformPerspective',
            'originout'             => 'transformOrigin',
        );
    }
    
    public static function config(){
        return array(
            'auto_height'                   => 'autoHeight',   
            'delay'                         => 'delay',   
            'background_dotted_overlay'     => 'dottedOverlay',   
            'drag_block_vertical'           => 'drag_block_vertical',   
            'force_full_width'              => 'forceFullWidth',   
            'fullScreen'                    => 'fullScreen',   
            'full_screen_align_force'       => 'fullScreenAlignForce',   
            'fullscreen_offset_size'        => 'fullScreenOffset',   
            'fullscreen_offset_container'   => 'fullScreenOffsetContainer',   
            'fullWidth'                     => 'fullWidth',   
            'hide_all_layers_under'         => 'hideAllCaptionAtLimit',   
            'hide_arrows_on_mobile'         => 'hideArrowsOnMobile',   
            'hide_bullets_on_mobile'        => 'hideBulletsOnMobile',   
            'hide_slider_under'             => 'hideCaptionAtLimit',   
            'hide_thumbs_delay_mobile'      => 'hideNavDelayOnMobile',   
            'hide_slider_under'             => 'hideSliderAtLimit',   
            'hide_thumbs'                   => 'hideThumbs',   
            'hide_thumbs_on_mobile'         => 'hideThumbsOnMobile',   
            'hide_thumbs_under_resolution'  => 'hideThumbsUnderResoluition',   
            'show_timerbar'                 => 'hideTimerBar',   
            'isJoomla'                      => 'isJoomla',   
            'keyboard_navigation'           => 'keyboardNavigation',   
            'fullscreen_min_height'         => 'minFullScreenHeight',   
            'min_height'                    => 'minHeight',   
            'navigation_arrows'             => 'navigationArrows',   
            'navigaion_align_hor'           => 'navigationHAlign',   
            'navigaion_offset_hor'          => 'navigationHOffset',   
            //''=>'navigationInGrid',   
            'navigation_style'              => 'navigationStyle',   
            'navigaion_type'                => 'navigationType',   
            'navigaion_align_vert'          => 'navigationVAlign',   
            'navigaion_offset_vert'         => 'navigationVOffset',   
            'next_slide_on_window_focus'    => 'nextSlideOnWindowFocus',   
            'stop_on_hover'                 => 'onHoverStop',   
            //''=>'panZoomDisableOnMobile',   
            'use_parallax'                  => 'parallax',   
            'parallax_bg_freeze'            => 'parallaxBgFreeze',   
            'disable_parallax_mobile'       => 'parallaxDisableOnMobile',   
            'parallaxLevels'                => 'parallaxLevels',   
            //''=>'parallaxOpacity',   
            'shadow_type'                   => 'shadow',   
            //''=>'simplifyAll',   
            'leftarrow_offset_hor'          => 'soloArrowLeftHOffset',   
            'leftarrow_align_hor'           => 'soloArrowLeftHalign',   
            'leftarrow_offset_vert'         => 'soloArrowLeftVOffset',   
            'leftarrow_align_vert'          => 'soloArrowLeftValign',   
            'rightarrow_offset_hor'         => 'soloArrowRightHOffset',   
            'rightarrow_align_hor'          => 'soloArrowRightHalign',   
            'rightarrow_offset_vert'        => 'soloArrowRightVOffset',   
            'rightarrow_align_vert'         => 'soloArrowRightValign',   
            'use_spinner'                   => 'spinner',   
            'start_js_after_delay'          => 'startDelay',   
            'width'                         => 'startwidth',   
            'height'                        => 'startheight', 
            'stop_slider'                   => 'stopLoop',  
            'stop_after_loops'              => 'stopAfterLoops',   
            'stop_at_slide'                 => 'stopAtSlide',   
            'swipe_min_touches'             => 'swipe_min_touches',   
            'swipe_velocity'                => 'swipe_treshold',
            'shuffle'                       => 'shuffle',
            'thumb_amount'                  => 'thumbAmount',   
            'thumb_height'                  => 'thumbHeight',   
            'thumb_width'                   => 'thumbWidth',   
            'touchenabled'                  => 'touchenabled',
            'start_with_slide'              => 'startWithSlide'   
        );
    }
    
    public static function cparse() {
        
        return array(
            'delay'                         => 'intval',
            'startwidth'                    => 'intval',
            'startheight'                   => 'intval',
            'navigationHOffset'             => 'intval',
            'shadow'                        => 'intval',
            'startWithSlide'                => 'intval',
            'navigationVOffset'             => 'intval',
            'soloArrowLeftHOffset'          => 'intval',
            'soloArrowLeftVOffset'          => 'intval',
            'soloArrowRightHOffset'         => 'intval',
            'soloArrowRightVOffset'         => 'intval',
            'swipe_min_touches'             => 'intval',
            'hideAllCaptionAtLimit'         => 'intval',
            'hideSliderAtLimit'             => 'intval',
            'hideNavDelayOnMobile'          => 'intval',
            'hideThumbs'                    => 'intval',
            'hideThumbsUnderResoluition'    => 'intval',
            'minHeight'                     => 'intval',
            'startDelay'                    => 'intval',
            'thumbAmount'                   => 'intval',
            'minHeight'                     => 'intval',
            'thumbHeight'                   => 'intval',
            'swipe_treshold'                => 'floatval'
        );
    }

    public static function loop(){
        return array(
            'rs-pendulum'   => 'rs_pendulum',
            'rs-rotate'     => 'rs_rotate',
            'rs-slideloop'  => 'rs_slideloop',
            'rs-pulse'      => 'rs_pulse',
            'rs-wave'       => 'rs_wave'
        );
    }
    
    public static function kenburn() {
        
        return array(
            'bgpositionend'  => 'data-bgpositionend',
            'kenburns'       => 'data-kenburns',
            'bgfitstart'     => 'data-bgfit',
            'bgfitend'       => 'data-bgfitend',
            'duration'       => 'data-duration',
            'ease'           => 'data-ease'
        );
    }
    
    public static function video() {
        return array(
            'youtube'   => 'ytid',
            'vimeo'     => 'vimeoid',
            'html5'     => 'html5',
            'urlPoster' => 'videoposter',
            'urlMp4'    => 'videomp4',
            'urlWebm'   => 'videowebm',
            'urlOgv'    => 'videoogv'
        );
    }
    
    public static function html5() {
        return array( 'urlMp4', 'urlWebm', 'urlOgv' );
    }
}
?>
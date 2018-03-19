<?php
  class JvssMap {
    
    public static function config(){
        return array(
            'slider_type', 
            'fullscreen_offset_container', 
            'fullscreen_min_height', 
            'full_screen_align_force', 
            'auto_height', 
            'force_full_width', 
            'width', 
            'height', 
            'responsitive_w1', 
            'responsitive_sw1', 
            'responsitive_w2', 
            'responsitive_sw2', 
            'responsitive_w3', 
            'responsitive_sw3', 
            'responsitive_w4', 
            'responsitive_sw4', 
            'responsitive_w5', 
            'responsitive_sw5', 
            'responsitive_w6', 
            'responsitive_sw6', 
            'delay', 
            'shuffle', 
            'lazy_load', 
            'use_wpml', 
            'stop_slider', 
            'stop_after_loops', 
            'stop_at_slide', 
            'position', 
            'shadow_type', 
            'show_timerbar', 
            'background_color', 
            'background_dotted_overlay', 
            'use_parallax', 
            'parallax_type', 
            'parallax_bg_freeze', 
            'parallax_level_1', 
            'parallax_level_2', 
            'parallax_level_3', 
            'parallax_level_4', 
            'parallax_level_5', 
            'parallax_level_6', 
            'parallax_level_7', 
            'parallax_level_8', 
            'parallax_level_9', 
            'parallax_level_10', 
            'use_spinner', 
            'spinner_color', 
            'stop_on_hover', 
            'keyboard_navigation', 
            'navigation_style', 
            'navigaion_type', 
            'navigation_arrows', 
            'navigaion_always_on', 
            'hide_thumbs', 
            'navigaion_align_hor', 
            'navigaion_align_vert', 
            'navigaion_offset_hor', 
            'navigaion_offset_vert', 
            'leftarrow_align_hor', 
            'leftarrow_align_vert', 
            'leftarrow_offset_hor', 
            'leftarrow_offset_vert', 
            'rightarrow_align_hor', 
            'rightarrow_align_vert', 
            'rightarrow_offset_hor', 
            'rightarrow_offset_vert', 
            'thumb_width', 
            'thumb_height', 
            'thumb_amount', 
            'touchenabled', 
            'swipe_velocity', 
            'swipe_min_touches', 
            'swipe_max_touches', 
            'drag_block_vertical', 
            'disable_on_mobile', 
            'hide_slider_under', 
            'hide_defined_layers_under', 
            'hide_all_layers_under', 
            'hide_arrows_on_mobile', 
            'hide_bullets_on_mobile', 
            'hide_thumbs_on_mobile', 
            'hide_thumbs_under_resolution', 
            'hide_thumbs_delay_mobile', 
            'loop_slide', 
            'start_with_slide', 
            'first_transition_type', 
            'first_transition_duration', 
            'first_transition_slot_amount', 
            'reset_transitions', 
            'reset_transition_duration'
        );
    }
    
    public static function slide(){
        return array(
            'title'                 => 'title',    
            'state'                 => 'state',    
            'slide_transition'      => 'transition',    
            'slot_amount'           => 'slotamount',    
            'transition_rotation'   => 'rotate',    
            'transition_duration'   => 'masterspeed',    
            'delay'                 => 'delay',    
            'slide_bg_color'        => 'slide_bg_color',    
            'bg_fit'                => 'bgfit',      
            'bg_repeat'             => 'bgrepeat',    
            'bg_position'           => 'bgposition',    
            'bg_end_position'       => 'bgpositionend',     
            'kenburn_effect'        => 'kenburns',    
            'kb_start_fit'          => 'bgfitstart',    
            'kb_end_fit'            => 'bgfitend',    
            'kb_duration'           => 'duration',    
            'kb_easing'             => 'ease', 
            'class_attr'            => 'zclass'
        );
    } 
    
    public static function layer(){
        return array(
            'left'              => 'x',
            'top'               => 'y',    
            'animation'         => 'animationin',
            'easing'            => 'easing',
            'split'             => 'splitin',
            'endsplit'          => 'splitout',
            'splitdelay'        => 'splitdelayin',
            'endsplitdelay'     => 'splitdelayout',
            'max_height'        => 'mh',
            'max_width'         => 'mw', 
            'whitespace'        => 'ws',
            'speed'             => 'speedin',
            'endspeed'          => 'speedout',
            'align_hor'         => 'align_hor',
            'align_vert'        => 'align_vert',
            'style'             => 'zstyle',
            'endanimation'      => 'animationout',
            'endeasing'         => 'easingout',   
            'attrID'            => 'zid',
            'attrClasses'       => 'zclass',
            'time'              => 'start',
            'splitdelay'        => 'splitdelayin',
            'endsplitdelay'     => 'splitdelayout',
            'video_type'        => 'video_type',
            'video_width'       => 'video_width',
            'video_height'      => 'video_height',
            'video_image_url'   => 'urlPoster',
            'parallax_level'    => 'parallax_level'
        );
    }

    public static function origin(){
        return array( 'originx', 'originy' );
    }
    
    public static function loop() {
        return array(
            'rs_pendulum'=>array(
                'loop_startdeg'     => 'startdeg',
                'loop_enddeg'       => 'enddeg',
                'loop_xorigin'      => 'xorigin',
                'loop_yorigin'      => 'yorigin',
            ),
            'rs_rotate'=>array(
                'loop_startdeg'     => 'startdeg',
                'loop_enddeg'       => 'enddeg',
                'loop_xorigin'      => 'xorigin',
                'loop_yorigin'      => 'yorigin',
            ),
            'rs_slideloop'=>array(
                'loop_xstart'       => 'xstart',
                'loop_xend'         => 'xend',
                'loop_ystart'       => 'ystart',
                'loop_yend'         => 'yend',
            ),
            'rs_pulse'=>array(
                'loop_zoomstart'    => 'zoomstart',
                'loop_zoomend'      => 'zoomend',
            ),
            'rs_wave' => array(
                'loop_angle'        => 'angle',
                'loop_radius'       => 'radius',
                'loop_xorigin'      => 'xorigin',
                'loop_yorigin'      => 'yorigin',
            )
        );
    }

    public static function loopType() {
        return array(
            'rs-pendulum'   => 'rs_pendulum',
            'rs-rotate'     => 'rs_rotate',
            'rs-slideloop'  => 'rs_slideloop',
            'rs-pulse'      => 'rs_pulse',
            'rs-wave'       => 'rs_wave'
        );
    }
    
    public static function position(){
        return array(
            'left'      => 'l',
            'center'    => 'c',
            'right'     => 'r',
            'top'       => 't',
            'middle'    => 'c',
            'bottom'    => 'b'
        );
    }
    
    public static function video() {
        return array(
            'autoplay',
            'autoplayonlyfirsttime',
            'nextslide',
            'forcerewind',
            'fullwidth',
            'videoloop',
            'controls',
            'mute',
            'cover',
            'dotted',
            'ratio',
        );
    }   
  }
?>

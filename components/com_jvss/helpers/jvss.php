<?php

/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */
defined('_JEXEC') or die;
defined( 'DS' ) or define( 'DS', DIRECTORY_SEPARATOR );

if( !class_exists( 'JvssFrontendMap' ) ) {
    require_once( dirname( __FILE__) . DS . "map.php" );
}

if( !class_exists( 'JvssFrontendFilter' ) ) {
    require_once( dirname( __FILE__) . DS . "filters.php" );
}

class JvssFrontendHelper {

    public static $DEFAULT_YT_ARGUMENTS = 'hd=1&amp;wmode=opaque&amp;showinfo=0;version=3&amp;enablejsapi=1&amp;html5=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;api=1';
    public static $DEFAULT_VIMEO_ARGUMENTS = 'title=0&byline=0&portrait=0;api=1';
    
    public static function getSS($id = 0)
	{
		if(!$id) { return false; }
		
		$rs =  JFactory::getDbo()
		->setQuery("SELECT id, name, params, customcss, sconfig FROM `#__jvss_items` where state = 1 AND id='{$id}'")
		->loadObject();
		
		if(!$rs) { return false; }
		
		$rs->params = json_decode($rs->params, true);
        $rs->sconfig = json_decode($rs->sconfig);
		
		return $rs;
	}
    
    public static function getPrefixSlider(){
        return md5( rand( 0, 1000 ) );    
    }
    
    public static function getObject($item, $k, $d = ''){
        return property_exists( $item, $k) ? $item->{$k} : $d;
    }
    public static function getArr($item = array(), $k, $d = ''){
        return isset( $item[ $k ] ) ? $item[ $k ] : $d;
    }
    
    public static function getWrapperClass($config, $type = 'wrapper'){
        $c = 'rev_slider_wrapper';
        if( $type == 'wrapper') {
            
            switch($config->slider_type) {
                case 'fixed':  
                case "responsitive":
                    return $c;
                break;
                
                case 'fullwidth':
                    return "{$c} fullwidthbanner-container";
                break;
                
                case 'fullscreen':
                    return "{$c} fullscreen-container";
                break;
            }
            return $c; 
               
        }
        
               
        $c = 'rev_slider';
        switch($config->slider_type) {
            case 'fixed':  
            case 'responsitive':
                return $c;
            break;
            
            case 'fullwidth':
                return "{$c} fullwidthabanner";
            break;
            
            case 'fullscreen':
                return "{$c} fullscreenbanner";
            break;
        }
        return $c; 
    }
    
    public static function getCssInlineWrapper($config, $type = 'wrapper') {
        $bgColor = self::getObject($config, 'background_color', '#E9E9E9'); 
        $w = self::getObject($config, 'width', '960'); 
        $h = self::getObject($config, 'height', '350'); 
        $size = "height:{$h}px;width:{$w}px;";
        if( in_array( $config->slider_type, array('fullscreen') ) ) { $size = ""; }
        if( in_array( $config->slider_type, array('fullwidth') ) ) {
            
            if( $type === 'wrapper' ) { $size = "max-height:{$h}px;"; }
            else { $size = "max-height:{$h}px;height:{$h}px;"; }
        }
        return $type === 'wrapper' ? 
        "background-color:{$bgColor};{$size}" : $size;    
    } 
    
    public static function getConfig($config, $numSlides = 0 ){
        
        $c = $config;                          
        
        // map key
        self::mapConfig( $c );
        
        // add option slider type
        $c->fullWidth   = in_array( $c->slider_type, array('fullwidth') ) ? 'on' : 'off';
        $c->fullScreen  = in_array( $c->slider_type, array('fullscreen') ) ? 'on' : 'off'; 
        
        // add option CMS
        $c->isJoomla    = 1;
        
        // add option parallax 
        if(in_array( self::getObject( $c, 'parallax', 'off'), array('on') )) { 
            
            if( property_exists( $c, 'parallax_type' ) ) {
            
                $c->parallax = $c->parallax_type;

            }

            $c->parallaxLevels = array(
                intval( $c->parallax_level_1 ),
                intval( $c->parallax_level_2 ),
                intval( $c->parallax_level_3 ),
                intval( $c->parallax_level_4 ),
                intval( $c->parallax_level_5 ),
                intval( $c->parallax_level_6 ),
                intval( $c->parallax_level_7 ),
                intval( $c->parallax_level_8 ),
                intval( $c->parallax_level_9 ),
                intval( $c->parallax_level_10 ),
            );
        }
        
        // filter key
        self::filterConfig($c);
        
        $c->spinner         = "spinner" . self::getObject( $c, 'spinner', '0');
        $c->simplifyAll     = self::getObject( $c, 'simplify_ie8_ios4', 'off');
        
        //get stop slider options
        $stopSlider         = self::getObject( $c, "stop_slider", "off" );
        $stopAfterLoops     = intval( self::getObject( $c, "stop_after_loops", "0" ) );
        $stopAtSlide        = intval( self::getObject( $c, "stop_at_slide", "2" ) );

        if( $stopSlider == "off" ){
            $stopAfterLoops = -1;
            $stopAtSlide    = -1;
        }

        $oneSlideLoop = self::getObject( $c, "loop_slide", "loop" );
        if( $oneSlideLoop == 'noloop' ){
            $stopAfterLoops = 0;
            $stopAtSlide    = 0;
        }                            
        $c->stopAfterLoops  = $stopAfterLoops;
        $c->stopAtSlide     = $stopAtSlide;
        
        $c->nextSlideOnWindowFocus = self::getObject( $c, 'nextSlideOnWindowFocus', 'off' );
        if( self::getObject( $c, "touchenabled", "on" ) == 'on' ){
            
            $c->swipe_threshold         = self::getObject( $c, 'swipe_velocity', 0.7 );
            $c->swipe_min_touches       = self::getObject( $c, 'swipe_min_touches', 1 );                   
            $c->drag_block_vertical     = self::getObject( $c, 'drag_block_vertical', 'false' ) == 'true' ? 1 : 0;                   
        
        }
        
        $c->hideThumbsUnderResolution = self::getObject( $c, "hide_thumbs_under_resolution", 0 );
        
        $hideCaptionAtLimit             =  self::getObject( $c, "hideCaptionAtLimit", 0 );
        if( !empty( $hideCaptionAtLimit ) ) { $hideCaptionAtLimit++; }
        $c->hideCaptionAtLimit          = $hideCaptionAtLimit;
        
        $hideAllCaptionAtLimit          =  self::getObject( $c, "hideAllCaptionAtLimit", 0 );
        if( !empty( $hideAllCaptionAtLimit ) ) { $hideAllCaptionAtLimit++; }
        $c->hideAllCaptionAtLimit       = $hideAllCaptionAtLimit;
        
        // parse to number
        self::toNum( $c );

        // start with slide
            
        $startWithSlide = $c->startWithSlide;
        if(is_numeric($startWithSlide)){
            $startWithSlide = (int)$startWithSlide - 1;
            if($startWithSlide < 0)
                $startWithSlide = 0;
                
            if($startWithSlide >= $numSlides)
                $startWithSlide = 0;
            
        }else
            $startWithSlide = 0;

        $c->startWithSlide = $startWithSlide;
        
        return json_encode($c);   
    }
    
    public static function toNum( &$c = object ){
        
        foreach( JvssFrontendMap::cparse() as $col => $type ) {
            
            !property_exists( $c, $col ) || $c->{ $col } = call_user_func( $type, $c->{ $col } );
                                                                                              
        }   
    }
    
    public static function mapConfig(&$c){
        
        foreach( JvssFrontendMap::config() as $k => $v) {
            
            if( isset( $c->{ $k } ) ) { 
                
                $c->{ $v } = $c->{ $k };
                
                if( $k === $v ) { continue; }
                
                unset( $c->{ $k } );
            } 
        }           
    }
    
    public static function filterConfig(&$c){
        
        $keys = array_values( JvssFrontendMap::config() );
        
        foreach($c as $k => $v) {
            
            if( !in_array( $k, $keys ) ) { unset( $c->{ $k } ); }
            
        }           
    }
    
    public static function getLayerClass($layer = array(), &$video_data = array(), $config ){
        $classes = array(
            "tp-caption",
            $layer['zclass'],
            $layer['zstyle'],
            $layer['animationin'],
            $layer['animationout'],
            "tp-resizeme"
        );

        //parallax part
        if( property_exists( $config, 'use_parallax' ) ) {

            if( $config->use_parallax == 'on' ){
                
                $slide_level = self::getArr( $layer, 'parallax_level', '-' );
                
                if($slide_level !== '-') {

                    array_push( $classes, "rs-parallaxlevel-{$slide_level}" );
                }

            }

        }

        // video part
        $video_data['hasVideo'] = isset( $layer[ 'video_type' ] ) 
        && ( $vtype = $layer[ 'video_type' ] )
        && isset( $layer[ $vtype ] )
        && ( $vid = $layer[ $vtype ] );
        
        if( isset( $vtype ) && $vtype === 'html5' ) {
            foreach( JvssFrontendMap::html5() as $itype ) {
                
                if( isset( $layer[ $itype ] ) && !empty( $layer[ $itype ] ) ) {
                    $video_data['hasVideo'] = 1;
                    break;            
                }
            }
        }
        
        $mvideo = JvssFrontendMap::video();
        
        if( $video_data['hasVideo'] ) {
            
            array_push( $classes, 'tp-videolayer' );
            $video_data['vkey'] = $mvideo[ $vtype ];
            
            if( isset( $vid ) ) {
                
                $video_data['vid'] = $vid;
            
            }                         
            
            if( isset( $layer[ 'fullwidth' ] ) && intval( $layer[ 'fullwidth' ] ) ) {
            
                $video_data['fullwidth'] = 1;
                array_push( $classes, 'fullscreenvideo' );                        
                
            }
        }
        $classes = array_filter( $classes );
        return join( " ", $classes );
    }
    
    public static function getLayerTime($layer, $config){
        
        if( !isset( $layer[ "timeline" ] ) ) { return ""; }
        
        $timeline = explode(";", $layer[ "timeline" ]); 
        $str = " data-speed='{$layer['speedin']}'";
        $str .= " data-start='{$timeline[0]}'";
        
        if( $speedout = intval($layer['speedout']) ) {
            $str .= " data-endspeed='{$speedout}'";
        }
        return $str;
    }
    
    public static function getLayerStyle( $layer ){
        $zIndex = !isset( $layer['zIndex'] ) || !$layer['zIndex'] ? 1 : $layer['zIndex'];
        $str    = "z-index: {$zIndex}";
        
        if( isset( $layer['mw'] ) ) {
            
            $str .= "; max-width: {$layer['mw']}";    
        }
        if( isset( $layer['mh'] ) ) {
            
            $str .= "; max-height: {$layer['mh']}";    
        }
        if( isset( $layer['ws'] ) ) {
            
            $str .= "; white-space: {$layer['ws']}";    
        }
        return $str;
    }
    
    public static function getTimebarPosition($config){
        
        switch( self::getObject( $config, "show_timerbar", "top" ) ) {
            case "top":
                return "";
            break;
            case "bottom":
                return "tp-bottom";
            break;
            case "hide":
                return "hidden";
            break;
        }
        
        return "";
    }
    
    public static function getStyle( $types = array() ){
        
        if( !count($types) ) { return false; }
        
        $types = array_unique( $types );
        $handles = "";
        foreach( $types as $item ) {
            $handles .= "'{$item}',";     
        }
        $handles = rtrim( $handles, ',');
        
        $styles = JFactory::getDbo()
        ->setQuery("SELECT handle, params FROM `#__jvss_css` where handle in ( {$handles} );")
        ->loadObjectList();
        
        if( $styles && count($styles) ) {
            
            $str = "";
            foreach( $styles as $sitem ) {
                $str .= sprintf("%s { %s }\n", $sitem->handle, self::obj2Css( json_decode( $sitem->params ) ) );
            }  
            
            return $str;  
        }
        
        return false;
    }
    
    public static function obj2Css( $arr = array() ){
        $str = ""; 
        foreach( $arr as $k => $v ) {
            $str .= "{$k}:{$v};";    
        }
        return $str;   
    }
    
    public static function getLoop( $loop = array(), $do_loop = '' ) {
        
        $key    = str_replace( '-', '_', $do_loop );
        $layer  = self::getArr( $loop, $do_loop, false );
        
        if( !$layer ) { return ""; }

        $loop_data = "";
        
        switch($do_loop){
            case 'rs-pendulum':
                $loop_data.= ' data-easing="'.self::getArr($loop,"loop_easing","Power3.easeInOut").'"';
                $loop_data.= ' data-startdeg="'.self::getArr($layer,"{$key}_startdeg","-20").'"';
                $loop_data.= ' data-enddeg="'.self::getArr($layer,"{$key}_enddeg","20").'"';
                $loop_data.= ' data-speed="'.self::getArr($loop,"speed","2").'"';
                $loop_data.= ' data-origin="'.self::getArr($layer,"{$key}_xorigin","50").'% '.self::getArr($layer,"{$key}_yorigin","50").'%"';
            break;
            case 'rs-rotate':
                $loop_data.= ' data-easing="'.self::getArr($loop,"loop_easing","Power3.easeInOut").'"';
                $loop_data.= ' data-startdeg="'.self::getArr($layer,"{$key}_startdeg","-20").'"';
                $loop_data.= ' data-enddeg="'.self::getArr($layer,"{$key}_enddeg","20").'"';
                $loop_data.= ' data-speed="'.self::getArr($loop,"speed","2").'"';
                $loop_data.= ' data-origin="'.self::getArr($layer,"{$key}_xorigin","50").'% '.self::getArr($layer,"{$key}_yorigin","50").'%"';
            break;
            
            case 'rs-slideloop':
                $loop_data.= ' data-easing="'.self::getArr($loop,"loop_easing","Power3.easeInOut").'"';
                $loop_data.= ' data-speed="'.self::getArr($loop,"speed","1").'"';
                $loop_data.= ' data-xs="'.self::getArr($layer,"{$key}_xstart","0").'"';
                $loop_data.= ' data-xe="'.self::getArr($layer,"{$key}_xend","0").'"';
                $loop_data.= ' data-ys="'.self::getArr($layer,"{$key}_ystart","0").'"';
                $loop_data.= ' data-ye="'.self::getArr($layer,"{$key}_yend","0").'"';
            break;
            case 'rs-pulse':
                $loop_data.= ' data-easing="'.self::getArr($loop,"loop_easing","Power3.easeInOut").'"';
                $loop_data.= ' data-speed="'.self::getArr($loop,"speed","1").'"';
                $loop_data.= ' data-zoomstart="'.self::getArr($layer,"{$key}_zoomstart","1").'"';
                $loop_data.= ' data-zoomend="'.self::getArr($layer,"{$key}_zoomend","1").'"';
            break;
            case 'rs-wave':
                $loop_data.= ' data-speed="'.self::getArr($loop,"speed","1").'"';
                $loop_data.= ' data-angle="'.self::getArr($layer,"{$key}_angle","0").'"';
                $loop_data.= ' data-radius="'.self::getArr($layer,"{$key}_radius","10").'"';
                $loop_data.= ' data-origin="'.self::getArr($layer,"{$key}_xorigin","50").'% '.self::getArr($layer,"{$key}_yorigin","50").'%"';
            break;
        }

        return $loop_data;
    }
    
    public static function getSlideTransition( $slide = array(), $config = object, $indexSlide = 0 ){
        
        $fstransition = self::getObject( $config, 'first_transition_type', 'fade' );
        $transition = self::getArr( $slide, 'transition', 'fade' );
        $str = !$indexSlide ? " data-fstransition='{$fstransition}'" : "";
                                                          
        if( is_array( $transition ) ) {
            
            if( in_array( 'random-selected', array_values( $transition ) ) 
                && count( $transition ) > 2 ) {
                
                $str .= " data-randomtransition='on'"; 
                    
            }
            
            $transition = implode(" ", $transition );
            $transition = preg_replace('/random-selected/', '', $transition);
            $transition = trim( $transition, ' ' );
        }
        
        $str .= " data-transition='{$transition}'";
        
        return $str;
    }

    public static function getTransitCustom( $layer = array(), $t = 'in' ) {
        
        if( !preg_match( '/customin|customout/', $layer[ "animation{$t}" ] ) ) {
            return false;
        }
        
        if( !isset( $layer[ "animationcustom{$t}" ] ) ) { return ""; }
        
        $map            = JvssFrontendMap::transit();
        $keysPercent    = array( 'scalexin', 'scaleyin', 'scalexout', 'scaleyout');
        
        $rs = "";
        
        foreach( $layer[ "animationcustom{$t}" ] as $k => $v ) {

            if( $v === '' ) { continue; }
            
            if( in_array( $k, $keysPercent ) ) {
                
                if( ( $toNum = doubleval( $v ) ) && $toNum > 1 ) {
                    
                    $v = $toNum / 100;
                    
                }
            }

            $rs .= sprintf("%s:%s;", self::getArr( $map, $k, $k ), $v );
        }

        return $rs;
    }

    public static function getResponsitiveValues( $config = object ){
        
        $sliderWidth    = intval( self::getObject( $config, 'width', 0) );
        $sliderHeight   = intval( self::getObject( $config, 'height', 0) );

        $percent = $sliderHeight / $sliderWidth;

        $w1 = intval( self::getObject( $config, 'responsitive_w1', 0) );
        $w2 = intval( self::getObject( $config, 'responsitive_w2', 0) );
        $w3 = intval( self::getObject( $config, 'responsitive_w3', 0) );
        $w4 = intval( self::getObject( $config, 'responsitive_w4', 0) );
        $w5 = intval( self::getObject( $config, 'responsitive_w5', 0) );
        $w6 = intval( self::getObject( $config, 'responsitive_w6', 0) );

        $sw1 = intval( self::getObject( $config, 'responsitive_sw1', 0) );
        $sw2 = intval( self::getObject( $config, 'responsitive_sw2', 0) );
        $sw3 = intval( self::getObject( $config, 'responsitive_sw3', 0) );
        $sw4 = intval( self::getObject( $config, 'responsitive_sw4', 0) );
        $sw5 = intval( self::getObject( $config, 'responsitive_sw5', 0) );
        $sw6 = intval( self::getObject( $config, 'responsitive_sw6', 0) );

        $arrItems = array();

        //add main item:
        array_push( $arrItems, array(
            "maxWidth"      => -1,
            "minWidth"      => $w1,
            "sliderWidth"   => $sliderWidth,
            "sliderHeight"  => $sliderHeight
        ));

        //add item 1:
        if( $w1 ) {

            array_push( $arrItems, array(
                "maxWidth"      => $w1 - 1,
                "minWidth"      => $w2,
                "sliderWidth"   => $sw1,
                "sliderHeight"  => floor( $sw1 * $percent )
            )); 
        }

        

        //add item 2:
        if( $w2 ) {

            array_push( $arrItems, array(
                "maxWidth"      => $w2 - 1,
                "minWidth"      => $w3,
                "sliderWidth"   => $sw2,
                "sliderHeight"  => floor( $sw2 * $percent )
            ));
        }

        

        //add item 3:
        if( $w3 ) {

            array_push( $arrItems, array(
                "maxWidth"      => $w3 - 1,
                "minWidth"      => $w4,
                "sliderWidth"   => $sw3,
                "sliderHeight"  => floor( $sw3 * $percent )
            ));
        }

        //add item 4:
        if( $w4 ) {
            
            array_push( $arrItems, array(
                "maxWidth"      => $w4 - 1,
                "minWidth"      => $w5,
                "sliderWidth"   => $sw4,
                "sliderHeight"  => floor( $sw4 * $percent )
            ));
        }

        

        //add item 5:
        if(  $w5 ) {

            array_push( $arrItems, array(
                "maxWidth"      => $w5 - 1,
                "minWidth"      => $w6,
                "sliderWidth"   => $sw5,
                "sliderHeight"  => floor( $sw5 * $percent )
            ));
        }

        //add item 6:
        if( $w6 ) {
            
            array_push( $arrItems, array(
                "maxWidth"      => $w6 - 1,
                "minWidth"      => 0,
                "sliderWidth"   => $sw6,
                "sliderHeight"  => floor( $sw6 * $percent )
            ));
        }

        return($arrItems);
    }
    
    public static function getSplitDelay( $layer = array() ){
        
        $elementdelay       = intval( self::getArr( $layer, 'splitdelayin', 0 ) );
        $endelementdelay    = intval( self::getArr( $layer, 'splitdelayout', 0 ) );
        $rs                 = "";
        
        if( $elementdelay > 0 ) { 
            
            $elementdelay /= 100;
            $rs .= "\ndata-elementdelay='{$elementdelay}'";
        }
        if( $endelementdelay > 0 ) {
          
            $endelementdelay /= 100;
            $rs .= "\ndata-endelementdelay='{$endelementdelay}'\n";
        };    
        
        return $rs;
    }
    
    public static function getPosition( $layer = array(), $video_data = array() ){
        
        $pos        = self::getArr( $layer, 'pos', 'lt' );
        $alignHor   = 'l';
        $alignVert  = 't';
        $left       = self::getArr( $layer, 'x', 0 );
        $top        = self::getArr( $layer, 'y', 0 );
        
        if( !empty( $pos ) ) {
            
            $alignHor = substr( $pos, 0, 1 );
            $alignVert = substr( $pos, 1, 1 );
        }

        $htmlPosX = "";
        $htmlPosY = "";
        
        switch($alignHor){
            default:
            case "l":
                $htmlPosX = "data-x='{$left}'";
            break;
            case "c":
                $htmlPosX = "data-x='center' data-hoffset='{$left}'";
            break;
            case "r":
                $left = (int)$left*-1;
                $htmlPosX = "data-x='right' data-hoffset='{$left}'";
            break;
        }

        switch($alignVert){
            default:
            case "t":
                $htmlPosY = "data-y='{$top}'";
            break;
            case "c":
                $htmlPosY = "data-y='center' data-voffset='{$top}'";
            break;
            case "b":
                $top = (int)$top * -1;
                $htmlPosY = "data-y='bottom' data-voffset='{$top}'";
            break;
        }
        
        if( isset( $video_data[ 'fullwidth' ] ) && $video_data[ 'fullwidth' ] ) {
            $htmlPosX = 'data-x="0"';
            $htmlPosY = 'data-y="0"';
        }
        
        return "\n{$htmlPosX} \n{$htmlPosY}";
    }
    
    
    public static function getKenburn( $slide = array() ) {
        
        $run = isset( $slide[ 'kenburns' ] ) && in_array( $slide[ 'kenburns' ], array( 'on' ) );
        
        $str = "\ndata-bgposition='{$slide['bgposition']}'";
        
        if( !$run ) { 
            
            $str .= "\ndata-bgfit='{$slide['bgfit']}'";
            return $str; 
        }
                  
        foreach( JvssFrontendMap::kenburn() as $mk => $mv ) {
            
            $v = isset( $slide[ $mk ] ) ? $slide[ $mk ] : false;
            !$v || $str .= "\n{$mv}='{$v}'"; 
        }
        
        return $str;
    }
    
    public static function getVideoData( $layer = array(), $video_data = array() ) {
        
        $w          = trim( self::getArr( $layer, 'video_width', '' ) );
        $h          = trim( self::getArr( $layer, 'video_height', '' ) );
        $controls   = intval( self::getArr( $layer, 'controls', 0 ) );
        
        $attr = intval( self::getArr( $layer, 'forcerewind', 0 ) ) ? "\ndata-forcerewind='on'" : '';
        
        if( $video_data[ 'fullwidth' ] ){ $w = $h = "100%"; }
        
        $attr .= "\ndata-videowidth='{$w}'";
        $attr .= "\ndata-videoheight='{$h}'";
        $autoplay = intval( self::getArr( $layer, 'autoplay', 0 ) ) ? 'true' : 'false';
                       
        switch( $video_data['vkey' ] ){
            case "ytid":
                
                $videoArgs = self::$DEFAULT_YT_ARGUMENTS;
                $videoArgs.=';origin='. JUri::root() . ';';
                if( $autoplay )
                {
                    $videoArgs.=';autoplay=1';
                }
                $videospeed = self::getArr( $layer, "videospeed", '1' );
                                                           
                $attr .= "\ndata-ytid='{$video_data['vid']}'";
                $attr .= "\ndata-videoattributes='{$videoArgs}'";
                $attr .= "\ndata-videorate='{$videospeed}'";
                $attr .= "\ndata-videocontrols='". ( $controls ? 'none' : 'controls' ) . "'";
            break;
            case "vimeoid":
                $videoArgs = self::$DEFAULT_VIMEO_ARGUMENTS;
                if( $autoplay )
                {
                    $videoArgs.=';autoplay=1';
                }
                $attr .= "\ndata-vimeoid='{$video_data['vid']}' data-videoattributes='{$videoArgs}'";
                
            break;
            case "html5":
                
                $attr .= "\ndata-videocontrols='". ( $controls ? 'none' : 'controls' ) . "'";
                $mkeys = JvssFrontendMap::video();
                
                foreach( JvssFrontendMap::html5() as $vkey ) {
                    
                    $vv = self::getArr( $layer, $vkey, '' );
                    
                    if( isset( $mkeys[ $vkey ] ) ) { $vkey = $mkeys[ $vkey ]; }
                    
                    if( empty( $vv ) ) { continue; }
                    
                    $attr .= "\ndata-{$vkey}='{$vv}'";
                }                                

                if( $videopreload  = self::getArr( $layer, 'preload', '' ) ) { $attr .= " data-videopreload='{$videopreload}'"; }
                
                $videoloop = self::getArr( $layer, 'videoloop', 'none' );
                $attr .= "\ndata-videoloop='{$videoloop}'";
                
            break;                                                            
        }
        
        if( intval( self::getArr( $layer, 'cover', 0 ) ) ){
            
            $attr .=  "\ndata-forceCover='1'";
            $dotted = self::getArr( $layer, 'dotted', '' );
            
            if($dotted !== 'none') { $attr .= "\ndata-dottedoverlay='{$dotted}'"; }
            if( $ratio = self::getArr( $layer, 'ratio', '' ) ) { $attr .= "\ndata-aspectratio='{$ratio}'"; }
            
        }                                                                       

        $attr .= intval( self::getArr( $layer, 'mute', '' ) ) ? "\ndata-volume='mute'" : '';
        
        $attr .= "\ndata-autoplay='{$autoplay}'";

        $videoAutoplayOnlyFirstTime = intval( self::getArr( $layer, "autoplayonlyfirsttime", 0 ) ) && $autoplay === 'true' ? 'true' : 'false';
        $attr .= "\ndata-autoplayonlyfirsttime='{$videoAutoplayOnlyFirstTime}'";

        if( intval( self::getArr( $layer, "nextslide", 0 ) ) ) {
            $attr .= "\ndata-nextslideatend='true'";
        }
        
        $disable_on_mobile  = intval( self::getArr( $layer, 'disable_on_mobile', 0 ) );
                                                    
        if( $urlPoster = self::getArr( $layer, 'urlPoster', '' ) ){
            
            $attr .= "\ndata-videoposter='{$urlPoster}'";
            $posterOff = $disable_on_mobile ? 'on' : 'off';
            $attr .= "\ndata-posterOnMObile='{$posterOff}'";
            
        }
        
        $attr .= $disable_on_mobile ? "\ndata-disablevideoonmobile='1'" : '';
        
        return $attr;
    }

    public static function fexists( $l = '' ) {

        return @getimagesize( $l ) ? 1 : 0;

    }

    public static function getMainImage( $slide = array(), $config ) {

        $attr = '';

        if( isset( $slide['bgsrc'] ) && ( $bgsrc = $slide['bgsrc'] ) ) {

            $bgsrc = JvssFrontendFilter::toLinkImage( $bgsrc );
            
            $lazyLoad = property_exists( $config, 'lazy_load' ) ? $config->lazy_load : 'off';

            if( $lazyLoad == "on" ){

                $attr .= "\ndata-lazyload='{$bgsrc}'";
                $attr .= "\nsrc='" . JUri::root() . JvssFrontendFilter::$udump . "'";
                
            }else{
                $attr .= "\nsrc='{$bgsrc}'";
            }

        }
        
        return $attr;
    }
}   
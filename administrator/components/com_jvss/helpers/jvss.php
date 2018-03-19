<?php

/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */
// No direct access
defined('_JEXEC') or die;

if( !class_exists( 'JvssMap' ) ) {
    require_once( dirname( __FILE__ ) . "/map.php" );
}
if( !class_exists( 'JvssFrontendFilter' ) ) {
    require_once( JPATH_SITE . "/components/com_jvss/helpers/filters.php" );
}

/**
 * Jvss helper.
 */
class JvssHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_JVSS_TITLE_ITEMS'),
			'index.php?option=com_jvss&view=items',
			$vName == 'items'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_jvss';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
    
    public static function getArray( $arr, $key, $default = '' ){
        
        return isset( $arr[ $key ] ) ? $arr[ $key ] : $default;
         
    }
    
    public static function filterParams( $params = array(), $type = 'config', $mapKey = 0 ) {
        
        $map = call_user_func( "JvssMap::{$type}" );
        
        if( !$map ) { return false; }
        
        if( $mapKey ) { $map = array_keys( $map ); }
        
        foreach( $params as $k => $v ) {
            if( !in_array( $k, $map ) || !is_string( $k ) ) {
                unset( $params[ $k ] );
            }
        }
        
        return $params;        
    }
    
    public static function getLayerType( $layer = array() ){
        
        switch( self::getArray( $layer, 'type', 'text' ) ) {
            case 'text':
                return self::getArray( $layer, 'text', '' );
            break;
            
            case 'image':
                $src = JUri::root() . "images/" . self::getArray( $layer, 'image_url', '' );
                $alt = self::getArray( $layer, 'text', '' );
                $width = self::getArray( $layer, 'width', '' );
                $height = self::getArray( $layer, 'height', '' );
                $attribs = array( 'width' => $width, 'height' => $height );
                return JHtml::image( $src, $alt, $attribs );
            break;
            
            case 'video': 
                
                $vw = self::getArray( $layer, 'video_width', '320' );
                $vh = self::getArray( $layer, 'video_height', '240' );
                
                return "<iframe src='//player.vimeo.com/76127035?title=0&byline=0&portrait=0;api=1' width='{$vw}' height='{$vh}'></iframe>";
                
            break;
        }
        
        return "";
    }
    
    public static function getState( $state = '' ) {
        return $state === 'published' ? 1 : 0; 
    }
    
    public static function mapKey( $arr, $type = '' ) {
        
        $map = call_user_func( "JvssMap::{$type}" );
        
        if( !$map ) { return false; }
        
        $nattr = array();
        
        foreach( $map as $k => $v ) {
            
            if( isset( $arr[ $k ] ) ) {
                
                $nattr[ $v ] = $arr[ $k ];
            }    
            
        }
        
        return $nattr;     
    }
    
    public static function getTimer( $item = array() ) {
        
        $start  = self::getArray( $item, 'time', 500 );
        $end    = self::getArray( $item, 'realEndTime', 9000 );
        
        return "{$start};{$end}";
    }
    
    public static function getPosition( $layer = array() ) {
        
        $alignHor   = self::getArray( $layer,"align_hor","left" );
        $alignVert  = self::getArray( $layer, "align_vert","top" );
        $xy         = JvssMap::position();
        
        return "{$xy[ $alignHor ]}{$xy[ $alignVert ]}";
    }
    
    public static function getAttrBg( $source = array(),  $target = array() ) {
        
        $bgFit = self::getArray( $source, 'bg_fit', 'cover' ); 
        if( $bgFit === 'percentage' ) {
                
            $bgFitX = intval( self::getArray( $source, "bg_fit_x", "100" ) );
            $bgFitY = intval( self::getArray( $source, "bg_fit_y", "100" ) );
            
            $target[ 'bgfit' ] = "{$bgFitX}% {$bgFitY}%";
        }else {
            
            $target[ 'bgfit' ] = $bgFit;
        }
        
        $bgPosition = self::getArray( $source, 'bg_position', 'center top' ); 
        if( $bgPosition === 'percentage' ) {
                
            $bgPositionX = intval( self::getArray( $source, "bg_position_x", "0" ) );
            $bgPositionY = intval( self::getArray( $source, "bg_position_y", "0" ) );
            
            $target[ 'bgposition' ] = "{$bgPositionX}% {$bgPositionY}%";
        }else {
            
            $target[ 'bgposition' ] = $bgPosition;
        }
        
        $isKenburn = self::getArray( $source, 'kenburn_effect', 'off' ) === 'on';
        
        if( !$isKenburn ) { return $target; }
        
        $bgEndPosition = self::getArray( $source, 'bg_end_position', 'center top' ); 
        if( $bgPosition === 'percentage' ) {
                
            $bgEndPositionX = intval( self::getArray( $source, "bg_end_position_x", "0" ) );
            $bgEndPositionY = intval( self::getArray( $source, "bg_end_position_y", "0" ) );
            
            $target[ 'bgpositionend' ] = "{$bgEndPositionX}% {$bgEndPositionY}%";
        }else {
            
            $target[ 'bgpositionend' ] = $bgEndPosition;
        }                 
                                
        return $target;
        
    }
    
    public static function buildAnimationCustom( $acustom = array() ) {
        
        if( !count( $acustom ) ) { return array(); }
        
        $rs = array();
        
        foreach( $acustom as $item ) {
            
            $id     = self::getArray( $item, 'id', false );         
            
            if( $id === false ) { continue; }
            
            $rs[ $id ] = self::getArray( $item, 'params', array() );
        }
        
        return $rs;
    }
    
    public static function getAnimationCustomType( $item = array() ) {
        
        $rs         = array();
        $names     = array(
            'in'    => self::getArray( $item, 'animation', false ),
            'out'   => self::getArray( $item, 'endanimation', false )
        );                    
        
        foreach( $names as $t => $name ) {
            
            if( $name === false ) { continue; }      
            
            preg_match( '/\d+$/', $name, $matches );
            
            if( !count( $matches ) ) { continue; }
            
            $rs[ $t ] = array_shift( $matches );
        }
        
        return $rs;
    }
    
    public static function getAnimationCustomParams( $params = array(), $t = false ) {
        
        if( !$t || !count( $params ) ) { return array(); }    
        
        $rs     = array();
        $origin = "";

        foreach( $params as $k => $v ) {
            
            if( in_array( $k, JvssMap::origin() ) ) {

                if( !preg_match( '/%$/', $v ) ) {
                    $v .= '% ';
                }
                
                $origin .= $v;
                
                continue;

            }

            $rs[ "{$k}{$t}"] = $v;    
        }

        $origin = trim( $origin );
        
        if( !$origin ) { return $rs; }

        $rs[ "origin{$t}" ] = $origin;

        return $rs;
    }
    
    public static function getAnimationCustom( $acustom = array(), $types = array(), $out = array() ){
    
        if( !count( $types ) ) { return $out; }
        
        foreach( $types as $t => $tid ) {
            
            $params = self::getArray( $acustom, $tid, false );
            
            if( $params === false ) { continue; }
            
            $out[ "animationcustom{$t}" ] = self::getAnimationCustomParams( $params, $t );

            if( !isset( $out[ "animation{$t}" ] ) ) { continue; }

            $out[ "animation{$t}" ] = trim( preg_replace( '/-\d+$/', '', $out[ "animation{$t}" ] ) );
        }
        
        return $out;
            
    }
    
    public static function array_merge_recursive_replace() {
        $arrays = func_get_args();
        $base = array_shift($arrays);
        foreach ($arrays as $array) {
            reset($base);
            while (list($key, $value) = @each($array)) {
                if (is_array($value) && @is_array($base[$key])) {
                    $base[$key] = self::array_merge_recursive_replace($base[$key], $value);
                } else {
                    $base[$key] = $value;
                }
            }
        }
        return $base;
    }
    
    public static function parse_string( $data = '' ) {
        
        if( !$data ) { return false; }
        
        $rs = array( );
        
        $data = explode( '&', $data );
        
        foreach( $data as $item ) {
            
            parse_str( $item, $out );
            
            $rs = self::array_merge_recursive_replace( $rs, $out );
        }
        
        return count( $rs ) ? $rs : false;
    }
    
    public static function toCustomAnimate( $v = '' ) {
        
        if( !preg_match( '/customin|customout/', $v ) ) { return $v; }
        
        return preg_replace( '/-\d+$/', '', $v );
    }
    
    public static function theContent( $arr = array() ) {
        
        foreach( $arr as $sid => $slide ) {
            
            if( isset( $slide[ 'bgsrc' ] ) ) {
                
                $arr[ $sid ][ 'bgsrc' ] = JvssFrontendFilter::toLinkImage( $slide[ 'bgsrc' ] );
                
            }
                
            if( !isset( $slide[ 'items' ] ) ) { continue; }
            
            foreach( $slide[ 'items' ] as $id => $item ) {
                
                if( isset( $item[ 'animationin' ] ) ) { 
                    
                    $arr[ $sid ][ 'items' ][ $id ][ 'animationin' ] = self::toCustomAnimate( $item[ 'animationin' ] );
                             
                }
                if( isset( $item[ 'animationout' ] ) ) { 
                    
                    $arr[ $sid ][ 'items' ][ $id ][ 'animationout' ] = self::toCustomAnimate( $item[ 'animationout' ] );
                    
                }
                
                if( !isset( $item[ 'content' ] ) ) { continue; }
                
                $arr[ $sid ][ 'items' ][ $id ][ 'content' ] = JvssFrontendFilter::theContent( $item[ 'content' ] );
            }   
        }
        
        return $arr;
        
    }
    
    public static function bool2Num( $v ) {
        
        return is_bool( $v ) ? ( $v ? 1 : 0 ) : $v;
        
    }
    
    public static function getVideoData( &$source = array(), $data ) {
        
        foreach( JvssMap::video() as $key ) {
            
            if( !property_exists( $data, $key ) ) { continue; }
            
            $source[ $key ] = self::bool2Num( $data->{$key} );
        }
        
        if( property_exists( $data, 'video_type' ) && property_exists( $data, 'id' ) ) {
            
            $source[ $data->video_type ] = $data->id;
        }
    }

    public static function getLoop( $data, &$out ) {
        
        $mloo_type = JvssMap::loopType();
        $loop_type = self::getArray( $data, 'loop_animation', 'none' );
        $loop = array(
            'loop_type' => $loop_type,
            'loop_easing' => self::getArray( $data, 'loop_easing', 'Power4.easeInOut' ),
            'speed' => self::getArray( $data, 'loop_speed', '0.5' ),
        );

        $ltk = self::getArray( $mloo_type, $loop_type, false );

        if( !$ltk ) { return false; }
        
        $ltv    = array();
        $mloop  = self::getArray( JvssMap::loop(), $ltk, false );

        if( !$mloop ) { return false; }

        foreach( $mloop as $k => $kv ) {

            $v = self::getArray( $data, $k, false );

            if( $v === '' ) { continue; }

            $ltv[ "{$ltk}_{$kv}"] = $v;
            
        }

        $loop[ $loop_type ] = $ltv;

        $out[ 'loop' ] = $loop;

    }
    
    public static function get_the_image_src( $content = '' )
    {
        if( !function_exists( 'str_get_html' ) )
        {
            require_once( JPATH_ADMINISTRATOR . '/components/com_jvss/helpers/simple_html_dom.php' );
        }
        
        $content    = str_get_html( $content );
        $rs         = array();
        
        if( $content )
        {
            foreach( $content->find( 'img' ) as $img )
            {
                array_push( $rs, $img->src );
            }
        }   
        
        return $rs;
    }
    
    public static function get_the_image_path( $src = '' )
    {
        $rs = false;
        
        $info = parse_url( $src );
        
        if( isset( $info[ 'path' ] ) )
        {
            $items = explode( '/', ltrim( $info[ 'path' ], '/' ) );
            
            foreach( $items as $i => $item )
            {                                     
                $path = JPATH_SITE . '/' . implode( '/', $items );
                
                if( file_exists( $path ) )
                {
                    $rs = $path;
                    
                    break;            
                }                     
                unset( $items[ $i ] );  
            }
        }
        
        
        return $rs;
    }
}

<?php

/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */
 defined('_JEXEC') or die;
 
  class JvssFrontendFilter {
    
	public static $udump = 'components/com_jvss/assets/img/dummy.png';
	
    public static function toLinkImage( $l = '' ) {
        
        $d = parse_url( $l );
        
        if( !isset( $d[ 'path' ] ) || !$d[ 'path' ] ) { return JUri::root() . self::$udump;  }
             
        $p = $d[ 'path' ];  
        $p = str_replace( "\\", '/', $p );
        $p = ltrim( $p, '/' );
        
        if( file_exists( JPATH_SITE . DS . $p ) ) { return JUri::root().$p; }
        
        $p = explode( '/', $p );
        
        foreach( $p as $index => $i ) {
            
            unset( $p[ $index ] );
            
            if( file_exists( JPATH_SITE . DS . implode( DS, $p ) ) ) { 
                
                $l = JUri::root() . implode( '/', $p );
                
                break;
            }
        }
        return $l;
        
    }
    
    public static function theContent( $c = '' ) {
        
        $c = stripslashes( $c );    
        $c = htmlspecialchars( $c );
                                                                                
        if( !preg_match( '/(<|&lt;)img[^>]+/', $c, $tags ) ) { 
            
            return htmlspecialchars_decode( $c );
            
        }   
        
        foreach( $tags as $tag ) {   
            
            $tag = str_replace( '&quot;', "", $tag );
            
            if( !preg_match( '/src=(.+)(\.\w+)/', $tag, $src ) ) { continue; }
            
            if( is_array( $src ) ) { $src = array_shift( $src ); }
            
            $src    = str_replace( 'src=', '', $src );
            $c      = str_replace( $src, self::toLinkImage( trim( $src, '/' ) ), $c );
        }
        
        return htmlspecialchars_decode($c);          
    }
    
    
  }
?>

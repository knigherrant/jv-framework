<?php
/*
 # Module		JV Demo Module
 # @version		3.0.1
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright © 2008-2012 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );


class modJVDemoHelper
{
    public static function getStyle(){
        $styles = array(
            'wide' => 'Wide',
            'boxed' => 'Boxed',
            'framed' => 'Framed',
            'rounded' => 'Rounded'
        );
       return $styles;
    }
    public static function getOptions(){
        $JV = JV::getInstance ();
        return $JV['option'];
    }

    public static function getBackground(){
        
        $template = JPATH_ROOT . '/templates/' . JFactory::getApplication()->getTemplate();
        $path  = JV::helper('path');
        $path->addPath($template, 'theme');
        $files = JFolder::files($template . '/images/background/thumb/');	
        $list = array();
        foreach ($files as $f){
            $list[$f] = self::getValue($f, true);
        }
        return $list;
    }
    
    public static function getValue($file, $up = false){
        $f = explode('.', $file);
        if($up) return ucfirst ($f[0]);
        return $f[0];
    }
}

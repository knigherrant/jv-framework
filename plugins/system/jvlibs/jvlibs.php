<?php
   /**
# plugin system jvlibs - JV Libraries
# @versions: 1.6.x,1.7.x,2.5.x,3.x
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
# @license - http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL or later.
# Websites: http://www.phpkungfu.club
# Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
class plgSystemJVLibs extends JPlugin{
    private $define;
    private $replace = false;
    private $replace_at = 'none';
    private $loaded = array();
    function __construct($subject,$config){
        define('JVLIBS_PATH',JPATH_SITE.'/plugins/system/jvlibs/');
        define('JVLIBS_URI',JUri::root(true).'/plugins/system/jvlibs/');
        define('JVLIBSEXTS_PATH',JVLIBS_PATH.'jvlibs_exts/');
        define('JVLIBSEXTS_URI',JVLIBS_URI.'jvlibs_exts/');
        require_once(JVLIBS_PATH.'libs.php');
        JVLibs::init($subject, json_decode($config['params']));
    }
}
?>

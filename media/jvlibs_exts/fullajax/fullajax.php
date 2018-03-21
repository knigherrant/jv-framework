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
if(JFactory::getApplication()->isAdmin()) return;
class JVFullAjax extends JPlugin{
    private $config;
    private static $isCall,$ops;
    function __construct($subject,$config){
        if(JFactory::getApplication()->isAdmin()) return;
        self::$ops = $config;
        if(!JVLibs::checkExt('AjaxCall','Full ajax')) return;
        $_SESSION['jvfullajax'] = self::$isCall = JVAjaxCall::isCall() && (JRequest::getBool('jvfullajax') || @$_SESSION['jvfullajax']);
        parent::__construct($subject,$config);            
    }

    public function onBeforeRender(){ 
        if(self::$isCall) return;
        JVJSLib::add('jquery.plugins.history');
        JFactory::getDocument()->addScript(JVLIBSEXTS_URI.'fullajax/fullajax.js');
        $ops = self::$ops;
        JFactory::getDocument()->addScriptDeclaration("JVFullAjax({$ops->applys})");
        
    }
    function JVAjaxCallBeforRender(){
        $_SESSION['jvfullajax'] = false;
        if(!self::$isCall) return;
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();
        foreach($doc->_scripts as $k => $script) JVAjaxCall::addScript($k);
        foreach($doc->_script as $script) JVAjaxCall::addScriptDeclaration($script);
        foreach($doc->_styleSheets as $k => $style) JVAjaxCall::addStyleSheet($k);
        foreach($doc->_style as $k => $style) JVAjaxCall::addStyleDeclaration($style);
        JVAjaxCall::custom('jvfullajax',$app->getBody());
    }
}
?>

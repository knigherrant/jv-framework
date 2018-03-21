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
class JVLoadContent extends JPlugin{
    private $config;
    private static $ops;
    function __construct($subject,$config){
        self::$ops = $config;
        if(!JVLibs::checkExt('AjaxCall','Load content')) return;
        parent::__construct($subject,$config);
    }
    public function onAfterRoute(){
        $call = JRequest::getVar('jvloadcontent');
        if(!$call) return;
        self::load($call);
    }
    public function onBeforeRender(){ JFactory::getDocument()->addScript(JVLIBSEXTS_URI.'loadcontent/loadcontent.js'); }
    
    static function load($call){
        $key = substr($call,0,4);
        if(!in_array($key,array('mod_','com_','plg_','exe:'))) $call = 'exe:'.$call;
        $args = json_decode(JRequest::getVar('args','[]'));
        $doc = JFactory::getDocument();
        $doc->_script = array();
        $doc->_scripts = array();
        $doc->_style = array();
        $doc->_styleSheets = array();
        $key = substr($call,0,4);
        switch($key){
            case 'mod_': $data = self::loadMod($call, $args);
                break;
            case 'com_': $data = self::loadCom($call, $args);
                break;
            case 'plg_': $data = self::loadPlg($call, $args);
                break;
            case 'exe:': $data = self::execute($call, $args);
        }
        foreach($doc->_scripts as $k => $script)  JVAjaxCall::addScript($k);
        foreach($doc->_script as $script) JVAjaxCall::addScriptDeclaration($script);
        foreach($doc->_styleSheets as $k => $style) JVAjaxCall::addStyleSheet($k);
        foreach($doc->_style as $k => $style) JVAjaxCall::addStyleDeclaration($style);
        $data && JVAjaxCall::custom('jvloadcontent',$data);
    }
    static function loadMod($name,$args){
        $module = JModuleHelper::getModule($name);
        $contents = JModuleHelper::renderModule($module);
        return array('title' => $module->title, 'content' => $contents);
    }
    static function loadPlg($name,$args){
        return array();
    }
    static function loadCom($name,$args){
        $contents = JComponentHelper::renderComponent($name);
        return array('title' => $name, 'content' => $contents);
    }
    static function execute($name,$args){
        $name = substr($name,4);
        if(!self::access($name)){
            return array('title' => 'Error!', 'content' => 'Not permission!');
        }
        $name = explode("::",$name);
        if(!is_callable($name)){
            return array('title' => 'Error!', 'content' => 'Function is not suported!');
        }
        
        ob_start();
        $data = array();
        $content = call_user_func_array($name, $args);
        if(is_string($content)) $data['content'] = $content;
        else if(is_object($content) && isset($content->title) && isset($content->content)) $data = $content;
        else if(is_array($content) && isset($content['title']) && isset($content['content'])) $data = $content;
        else $data['content'] = ob_get_contents();
        ob_end_clean();
        return $data;
    }
    private static function access($name){
        foreach(self::$ops->access as $item){
            if($item->get('call') == $name && in_array((int) $item->get('access'), JFactory::getUser()->getAuthorisedViewLevels())) return true;
        }
        return false;
    }
    
    static function example(){
        return array('content' => 'This is method example content', 'title'=>'Example') ;
    }
}
?>

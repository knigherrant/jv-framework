<?php
class JVAjaxCall extends JPlugin{
    private static $doc,$isCall,$config, $register;
    function __construct($subject, $config){
        if(JFactory::getApplication()->isAdmin()) return;
        $options = array('options' => array());
        self::$doc = new JVDataObject($options);
        @session_start();
        if(!isset($_SESSION['jvajaxcall']))  $_SESSION['jvajaxcall'] = array();
        self::$register = &$_SESSION['jvajaxcall'];
        self::$register['_iscall'] = self::$isCall = !!JRequest::getVar('jvjax') || @self::$register['_iscall'];
        self::$config = $config;
        parent::__construct($subject, $config);
    }
    public function onBeforeRender(){
        if(self::$isCall) return;
        JVJSLib::add('jquery,jquery.bootstrap');
        $doc = JFactory::getDocument(); 
        $doc->addScript(JVLIBSEXTS_URI.'ajaxcall/ajaxcall.js');
        self::options(self::$config);
        
        $doc = JFactory::getDocument();
        $loadedScripts = array();
        $loadedStyles = array();
        foreach($doc->_scripts as $k => $script)  $loadedScripts[$k] = true;
        foreach($doc->_styleSheets as $k => $style) $loadedStyles[$k] = true;
        $loaded = json_encode(array('scripts' => $loadedScripts, 'styles' => $loadedStyles));
        
        $doc->addScriptDeclaration("JVAjaxCall.setLoaded({$loaded})");
        $doc->addScriptDeclaration('jQuery(window).load(function(){ JVAjaxCall.assign('.JVAjaxCall::render().'); });');
    }
    public function onAfterRender(){self::out();}
    private static function compress($data){
        $accept = $_SERVER["HTTP_ACCEPT_ENCODING"];
        $encoding = false;
        if( strpos($accept, 'x-gzip') !== false ) $encoding = 'x-gzip'; 
        else if( strpos($accept,'gzip') !== false ) $encoding = 'gzip';
        
        if( $encoding ) {
            $_temp = strlen($data);
            if ($_temp < 2048) die($data); 
            else { 
                header('Content-Encoding: '.$encoding); 
                print("\x1f\x8b\x08\x00\x00\x00\x00\x00"); 
                $data = gzcompress($data, 2); 
                $data = substr($data, 0, $_temp); 
            } 
        }
        return $data;
    }
    static function register($name,$timeout){
        if(!isset(self::$register[$name])) self::$register[$name] = array('last' => 0);
        self::$register[$name]['timeout'] = $timeout;
    }
    static function isCall($name = null){
        if($name && self::$isCall){
            if(!isset(self::$register[$name])) return false;
            $obj = &self::$register[$name];
            $now = time();
            $last = $obj['last'];
            $obj['last'] = $now;
            return $now - $last >= $obj['timeout'];
        }
        return self::$isCall;
    }
    static function options($opts){
        return self::$doc->options->extend($opts);
    }
    static function addScript($url, $cache = true){
        self::$doc['scripts.'] = array('src' => $url, "cache" => $cache);
    }
    static function addScriptDeclaration($script){
        self::$doc['script.'] = $script;
    }
    static function addStyleSheet($url,$cache = true){
        self::$doc['styles.'] = array('src' => $url, "cache" => $cache);
    }
    static function addStyleDeclaration($css){
        self::$doc['styles.'] = $css;
    }
    static function trigger($name,$obj){
        if(!isset(self::$doc["events.{$name}"])) self::$doc["events.{$name}"] = array();
        self::$doc["events.{$name}."] = $obj;
    }
    static function msg($title,$content,$config = array()){
        $newmsg = self::$doc["msgs."] = new JVDataObject();
        $newmsg->extend($config,array(
            'title' => $title,
            'content' => $content,
            'type' => 'info'
        ));
        return $newmsg;
    }
    static function custom($name,$value = array()){
        
        $custom = self::$doc["customs.{$name}"];
        if(!isset($custom)){
            self::$doc["customs.{$name}"] = $value;
            $custom = self::$doc["customs.{$name}"];
        }
        return $custom;
    }
    
    static function render(){
        JDispatcher::getInstance()->trigger('JVAjaxCallBeforRender');
        return (string) self::$doc;
    }
    
    static function out(){
        self::$register['_iscall'] = false;
        if(self::$isCall){
            $data = JVAjaxCall::render();
            if(($callback = JRequest::getVar('callback',false)) && self::$config->get('jsonp',false)) $data = $callback.'('.$data.')';
            JDispatcher::getInstance()->trigger('JVAjaxCallBeforCompress');
            $data = self::compress($data);
            die($data);
        }
    }
}
?>

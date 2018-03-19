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
class JVLibs{
    static $config,$downloadLink = "http://www.phpkungfu.club/joomla-extensions/";
    
    static function init($subject, $config){
        self::$config = new JVCustomParam($config);
        new JVJSLib(self::$config);
        JVLibs::loadExts();
    }
    static function checkExt($name,$msg = false){
        if(class_exists('JV'.$name)) return true;
        $msg && JError::raiseError(null,
            'Make sure "'.$name.'" extention is enable to user "'.$msg.'".<br/>
            Please check your JV Libraries plugin at "Basic Options" has enabled "'. $name .'" extension.<br/>
            If you not found it in your config, please click <a href="'.self::$downloadLink.$name.'">here</a> to download "'. $name .'" extension for your JV Libraries plugin');
        return false;
    }
    
    private static function getExts(){
        jimport('joomla.filesystem.folder');
        return is_dir(JVLIBSEXTS_PATH)?JFolder::folders(JVLIBSEXTS_PATH):array();
    }
    static function loadExts(){
        $subject = JDispatcher::getInstance();
        $configs = self::$config->get('configs');
        if(!isset($configs)) return;
        if(!method_exists($configs,'state')) return;
        $sorts = $configs->state('sortable');
        if(empty($sorts)) return;
        foreach( $sorts as $name){
            $config = $configs->get($name);
            if(!$config->get('active',false)) continue;
            $extFile = JVLIBSEXTS_PATH.$name.'/'.$name.'.php';
            $className = 'JV'.$name;
            if(is_file($extFile)){
                require_once($extFile);
                if(class_exists($className)) new $className($subject,$config);
            }
        }
    }
    static function loadExtConfig($params = true){
        $exts = self::getExts();
        $doc = JFactory::getDocument();
        $doc->addScriptDeclaration('JVLibsExts = {};');
        foreach($exts as $ext){
            $extFile = JVLIBSEXTS_PATH.$ext.'/config.php';
            if(is_file($extFile)){
                $config = self::getConfigFrom($extFile);
                $doc->addScriptDeclaration('JVLibsExts["'.$ext.'"] = '.JVCustomParam::parseParams($config).';');
            }else{
                $doc->addScriptDeclaration('JVLibsExts["'.$ext.'"] = {}');
            }
        }
    }
    
    static function getConfigFrom($file){
        ob_start();
        include($file);
        $config = ob_get_contents();
        ob_end_clean();
        return $config;
    }
}
class JVDataObject extends ArrayObject{
    private $__val;
    public function __construct($data = array()){
        parent::__construct(array(),2);
        $this->apply($data);
    }
    
    public static function create($data = array()){ return new $this($data);}
    
    public function apply($data = array()){
        if(!is_array($data) && !is_object($data)) return $this->__val = $data;
        foreach(func_get_args() as $data){
            foreach($data as $k => $item){
                $this[$k] = $item;
            }
        }
        return $this;
    }
    public function extend($data = array()){
        if(!is_array($data) && !is_object($data)) return $this->__val = $data;
        foreach(func_get_args() as $data){
            foreach($data as $k => $item){
                if((is_array($item) || is_object($item)) && isset($this[$k])){
                    $this[$k]->extend($item);
                }else $this[$k] = $item;
            }
        }
        return $this;
    }
    public function get($key, $default = null){
        $val = $this[$key];
        return isset($val)?$val:$default;
    }
    
    public function set($name,$obj){
        return $this[$name] = $obj;
    }
    
    public function offsetGet($name) {
        $root = $this;
        foreach(explode('.',$name) as $key){
            if(!$root->pExists($key)) return;
            $root = $root->pGet($key);
        }
        return $root;
    } 
    public function offsetSet($name,$val) {
        $root = $this;
        $keys = explode('.',$name);
        $count = count($keys) - 1;
        $lastKey = $keys[$count];
        
        for($i = 0; $i < $count; $i++ ){
            $k = $keys[$i];
            if(!$root->pExists($k)){
                $k = $k === ''? null: $k;
                $new = new $this();
                $root->pSet($k, $new);
                $root = $new;
            }else $root = $root->pGet($k);
        }
        $lastKey = $lastKey ===''?null:$lastKey;
        if(
            is_array($val) || 
            (is_object($val) && get_class($val) != get_class($this))
        ) $val = new $this($val);
        $root->pSet($lastKey, $val);
        return $val;
    } 
    public function offsetExists($name) {
        $root = $this;
        $names = explode('.',$name);
        $last = array_pop($names);
        foreach($names as $val){
            if(!$root->pExists($val)) return false;
            $root = $root->pGet($val);
        }
        return $root->pExists($last);
    } 
    public function offsetUnset($name) {
        $root = $this;
        $names = explode('.',$name);
        $last = array_pop($names);
        foreach($names as $val){
            if(!isset($root[$val])) return false;
            $root = &$root[$val];
        } 
        return $root->pUnset($last);
    }
    public function __toString(){
        if($this->__val) return $this->__val;
        return json_encode($this->restore());
    }
    public function restore($assoc = false){
        if($this->__val) return $this->__val;
        $data = array();
        $toObject = false;
        foreach($this as $k => $item){
            if(is_object($item)){
                $item = $item->restore($assoc);
            }
            if(is_numeric($k)) $k = (int) $k;
            else $toObject = true;
            $data[$k] = $item;
        }
        if(!$assoc && $toObject) $data = (object) $data;
        return $data;
    }
    
    private function pGet($name){ return parent::offsetGet($name); }
    private function pSet($name,$val){return parent::offsetSet($name,$val); }
    private function pExists($name){ return parent::offsetExists($name); }
    private function pUnset($name){ return parent::offsetUnset($name); }
}
 
require_once(JVLIBS_PATH.'javascripts/jvjslib.php');
require_once(JVLIBS_PATH.'customfield/customfield.php');
?>

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
class JVReplaceScripts extends JPlugin{
    private $config;

    function __construct($subject,$config){
        $config = $config->config;
        $app = JFactory::getApplication();
        if($app->isAdmin() || !$config->count()) return;
        $this->config = $config;
        parent::__construct($subject,$config);
    }
    public function onBeforeRender(){        
        $doc = JFactory::getDocument();
        $count = 0;
        $scripts = $doc->_scripts;
        $doc->_scripts = array();
        
        
        foreach($this->config as $i => $obj){
            if(!JFormFieldJVCustom::checkMenuAssign($obj->assignmenu)){
                unset($this->config[$i]); 
                continue;
            }
            if(empty($obj->from)) {
                unset($this->config[$i]);
                continue;
            }
            $obj->from = '/'.$obj->from.'/';
        }
        
        foreach($scripts as $script => $ops){
            foreach($this->config as $obj){
                if(preg_match($obj->from,$script)){
                    unset($scripts[$script]);
                    if(!empty($obj->to)) $doc->_scripts[$obj->to] = $ops;
                }else{
                    $doc->_scripts[$script] = $ops;
                }
            }
        }
    }
}
?>

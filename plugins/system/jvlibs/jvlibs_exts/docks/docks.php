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
class JVDocks extends JPlugin{
    private $config,$html;
    function __construct($subject,$config){
        $config = $config->config;
        if(!$config->count()) return;
        $this->config = $config;
        parent::__construct($subject,$config);
    }
    public function onBeforeRender(){
        $doc = JFactory::getDocument();
        $html = '';
        $configs = array();
        
        foreach($this->config as $dock){
            
            if($dock->content->state('selected') == 'position'){
                $pos = (string) $dock->content;
                $modules = JModuleHelper::getModules($pos);
                if(!count($modules)) break;
                $html .= '<div id="jvdock_'.$pos.'">';
                foreach($modules as &$module){
                    $html .= JModuleHelper::renderModule($module);
                }
                $html .= '</div>';
                $dock->selector = '#jvdock_'.$pos;
            }else $dock->selector = $pos;
            $configs[] = $dock->restore();
        }
        if(!count($configs)) return;
        $this->html = empty($html)?'':'<div id="jvdocks">'.$html.'</div>';
        
        $doc->addStyleSheet(JVLIBSEXTS_URI.'docks/docks.css');
        $doc->addScript(JVLIBSEXTS_URI.'docks/docks.js');
        $doc->addScriptDeclaration("jQuery(function($){
            $.each(". json_encode($configs) .",function(){
                new JVDock(this.selector, this);
            });
        })");
    }
    
     public function onAfterRender(){
         if(!empty($this->html)) JResponse::setBody(JResponse::getBody() . $this->html);
     }
}
?>

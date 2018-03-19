<?php
   /**
# plugin system jvlibs - JV Libraries
# @versions: 1.6.x,1.7.x,2.5.x,3.x
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL or later.
# Websites: http://www.joomlavi.com
# Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
class JVScrolls extends JPlugin{
    private $config;
    function __construct($subject,$config){
        $config = $config->config;
        if(JFactory::getApplication()->isAdmin() || !$config->count()) return;
        $this->config = $config;
        parent::__construct($subject,$config);
    }
    public function onBeforeRender(){
        $doc = JFactory::getDocument();
        JVJSLib::add('jquery.plugins.colorpicker');
        $doc->addScript(JVLIBSEXTS_URI.'scrolls/jquery.nicescroll.js');
        $doc->addScriptDeclaration("jQuery(function($){
            $.each(". $this->config .",function(){
                $(this.selector).niceScroll(this);
            });
        })");
    }
}
?>

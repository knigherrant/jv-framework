<?php
/**
 # JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );	

class JVFrameworkExtensionScrolling extends JVFrameworkExtension{

	function afterRender() {
        if(JFactory::getApplication()->isAdmin()) return;
        $config = new JVCustomParam($this['option']->get('scrolling'));
        if(!count($config)) return;
        $doc = JFactory::getDocument();
        JVJSLib::add('jquery');
        $doc->addScript($this['path']->url('extensions::scrolling/assets/scrollingeffect.js'));
        $doc->addScript($this['path']->url('extensions::scrolling/assets/jquery.easypiechart.min.js'));
        $doc->addStyleSheet($this['path']->url('extensions::scrolling/assets/animate.css'));
        $doc->addScriptDeclaration(" jQuery(function($){ $.each({$config},function(){this.effect = this.effect.toString(); new JVScrolling(this);});});");
	}
}
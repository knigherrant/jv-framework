<?php
class JVScrollingEffects extends JPlugin{
    private static $doc,$isCall,$config, $register;
    function __construct($subject, $config){
        if(JFactory::getApplication()->isAdmin()) return;
        $doc = JFactory::getDocument();
        JVJSLib::add('jquery');
        $doc->addScript(JVLIBSEXTS_URI.'scrollingeffects/scrollingeffect.js');
        $doc->addStyleSheet(JVLIBSEXTS_URI.'scrollingeffects/animate.css');
        $doc->addScriptDeclaration(" jQuery(function($){ $.each({$config->applys},function(){this.effect = this.effect.toString(); new JVScrolling(this);});});");
    }
}
?>

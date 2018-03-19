<?php
   /**
# plugin system jvslidepro_article - JV Slide Article
# @versions: 1.6.x,1.7.x,2.5.x,3.x
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL or later.
# Websites: http://www.joomlavi.com
# Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
class plgSystemJVTabs extends JPlugin{
    private static $loaded = array();
    function __construct($subject,$config){
        $action = JRequest::getVar('jvtabaction');
        if($action) $this->{$action}();
        parent::__construct($subject,$config);
    }
    function find_article(){
        $keySearch = trim(JRequest::getVar('term'));
        $keySearch = str_replace("'","\'",$keySearch);
        $filterID = "";
        if(is_numeric($keySearch)) $filterID = "or id LIKE '$keySearch%'";
        $sql = "SELECT id,title as text FROM #__content where title LIKE '%$keySearch%' ".$filterID." LIMIT 0,10";
        $db = JFactory::getDbo();
        $db->setQuery($sql);
        $list = $db->loadObjectList();
        die(json_encode($list));
    }
    function find_k2(){
        is_dir(JPATH_SITE.'/components/com_k2') or die(json_encode(array(array('text' => 'Please install K2 Article'))));
        $keySearch = trim(JRequest::getVar('term'));
        $keySearch = str_replace("'","\'",$keySearch);
        $filterID = "";
        if(is_numeric($keySearch)) $filterID = "or id LIKE '$keySearch%'";
        $sql = "SELECT id,title as text FROM #__k2_items where title LIKE '%$keySearch%' ".$filterID." LIMIT 0,10";
        $db = JFactory::getDbo();
        $db->setQuery($sql);
        $list = $db->loadObjectList();
        die(json_encode($list));
    }
    
    function addButton($ops){
        $doc = JFactory::getDocument();
        $doc->addScript(JUri::root(true).'/plugins/system/jvtabs/sources/jvtabs.sys.admin.js');
        $admincss = JUri::root(true).'/plugins/system/jvtabs/sources/jvtabs.sys.admin.css';
        $doc->addStyleSheet($admincss);
        $doc->addScriptDeclaration("
            ;(function($){
                $(window).load(function(){
                    var editor = tinyMCE.get('{$ops['editor']}');
                    $(editor.getDoc().getElementsByTagName('head')[0])
                        .append($('<link>',{rel:'stylesheet', href:'{$admincss}'}));
                    new JVTabsAdmin({
                        button: '{$ops['button']}',
                        editor: editor
                    });
                });
            })(jQuery);
        ");
        JVJSLib::add('jquery.plugins.customfield');
        JFormFieldJVCustom::import('positions');
    }
    
    function createTab($params){
        if(!$params) return;
        require_once(JPATH_BASE.'/plugins/system/jvtabs/sources/source.php');
        $tab = new JVTabs(new JVCustomParam(json_decode($params)));
        return $tab->render();
    }
    
    function applyTabs($text,$null = false){
        $pattern =  '<a class="jvtabs\b[^>]*>(.*?)<\/a>';
        preg_match_all('/'.$pattern.'/',$text,$matches);
        foreach($matches[1] as $i => $params){
            $text = str_replace($matches[0][$i],$null?'':$this->createTab($params),$text);
        }
        return $text;
    }
    
    function onContentPrepareForm($form,$data){
        if($form->getName() == 'com_content.article'){
            $this->addButton(array(
                'button' => '#editor-xtd-buttons',
                'editor' => 'jform_articletext'
            ));
        }else if($form->getName() == 'com_modules.module' && @$data->module == 'mod_custom'){
            $this->addButton(array(
                'button' => '#editor-xtd-buttons',
                'editor' => 'jform_content'
            ));
        }
    }
    function onRenderAdminForm(&$item, $type, $tab = ''){
        if($tab !== 'content') return;
        $this->addButton(array(
            'button' => '#editor-xtd-buttons',
            'editor' => 'text'
        ));
    }
    
    function onContentPrepare($key, $item){
        if(!in_array($key,array(
            'com_content.featured',
            'com_content.article',
            'mod_custom.content',
            'com_content.category',
            'com_k2.item'
        ))) return;
        $com = explode('.',$key);
        $com = $com[0];
        $makeNull = false;
        if(!isset($item->id)) $item->id = md5($item->text);
        if(isset(self::$loaded[$com][$item->id])){$makeNull = true;}
        if(!isset(self::$loaded[$com])) self::$loaded[$com] = array();
        self::$loaded[$com][$item->id] = true;
        switch($key){
            case 'com_content.featured':
            case 'com_content.category':
            case 'com_content.article':
            case 'mod_custom.content': $item->text = $this->applyTabs($item->text,$makeNull); break;
            case 'com_k2.item': $item->fulltext = $this->applyTabs($item->fulltext,$makeNull); break;
        }
    }
    function onBeforeRender(){
        if(!JFactory::getApplication()->isAdmin()) return;
        $doc = JFactory::getDocument();
        foreach($doc->_scripts as $i => $script){
            if($i === '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js'){ 
                unset($doc->_scripts[$i]);
                JVJSLib::add('jquery.ui.widget');
                return;
            }
        }
    }
}

?>

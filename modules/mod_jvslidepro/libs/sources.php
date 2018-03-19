<?php
/**
# mod_jvslidepro - JV Slide Pro
# @versions: 1.5.x,1.6.x,1.7.x,2.5.x
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.joomlavi.com
# Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');
class JVJSlideProSource{
    private $ouputData = array();
    function __construct($params){
        foreach($params as $item){
            $fn = $item->state('selected');
            if(method_exists($this,'from_'.$fn)){
                $this->ouputData = array_merge($this->ouputData,$this->{'from_'.$fn}($item));
            }else{
                $sourcepath = dirname(__FILE__).'/sources/'.$fn.'.php';
                if(is_file($sourcepath)){
                    require_once($sourcepath);
                    $class = 'JVJSlideProSource'.$fn;
                    if(class_exists($class)){
                         $obj = new $class($item);
                         $this->ouputData = array_merge($this->ouputData,$obj->data());
                    }
                }
            }
            
        }
    }
    private function from_input($item){
        $item->path = trim($item->path);
        $item->thumb = trim($item->thumb);
        if(strpos('://',$item->path) === false) $item->path = JUri::root(true) .'/'.$item->path;
        if($item->thumb && strpos('://',$item->thumb) === false) $item->thumb = JUri::root(true) .'/'.$item->thumb;
        return array($item);
    }
    private function from_youtube($item){
        $url = explode('?',$item->url);
        $params = $url[1];
        $params = explode('&',$params);
        foreach($params as $p){
            $p = explode('=',$p);
            if($p[0] === 'v') {
                $item->params = array('id' => $p[1]);
            } 
        }
        unset($item->url);
        $item->type="youtube";
        return array($item);
    }
    private function from_article($cf){
        $sql = "SELECT id,title,introtext,images,access,alias,catid FROM #__content where id = {$cf->from} AND state = 1";
        $db = JFactory::getDbo();
        $db->setQuery($sql);
        $item = $db->loadObject();
        if(empty($item)) return;
        JPluginHelper::importPlugin('content');
        $item->text = $item->introtext;
        JDispatcher::getInstance()->trigger('onContentPrepare', array ('com_content.article', &$item, &$item->params, 0));
        $obj = array(
            'title' => $item->title,
            'content' => $item->text,
            'type'  => 'article'
        );
        if($cf->readmore){
            require_once JPATH_SITE . '/components/com_content/helpers/route.php'; 
            $access = !JComponentHelper::getParams('com_content')->get('show_noauth');
            $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
            if($access || in_array($item->access, $authorised)){
                $obj['link'] = JRoute::_(ContentHelperRoute::getArticleRoute($item->id.':'.$item->alias, $item->catid));
            }else{
                $obj['link'] = JRoute::_('index.php?option=com_users&view=login');
            }
        }
        $cf->path = (string)$cf->path;
        $item->images = json_decode($item->images);
        if($cf->path != 'none'){
            if($cf->path == 'full' && !empty($item->images->image_fulltext)){
                $obj['path'] = $item->images->image_fulltext;
            }else if(!empty($item->images->image_intro)){
                $obj['path'] = $item->images->image_intro;
            }
        }
        if($cf->thumb){
            $obj['thumb'] = $item->images->image_intro;
        }
        return array($obj);
    }
    private function from_k2article($cf){
        $sql = "SELECT id,title,introtext,access,alias,catid FROM #__k2_items where id = {$cf->from} AND published = 1";
        $db = JFactory::getDbo();
        $db->setQuery($sql);
        
        $item = $db->loadObject();
        if(!$item) return;
        
        JPluginHelper::importPlugin('k2');
        $item->text = $item->introtext;
        JDispatcher::getInstance()->trigger('onContentPrepare', array ('com_k2.item', &$item, &$item->params, 0));
        
        require_once(JPATH_BASE.'/components/com_k2/helpers/route.php');
        $component = JComponentHelper::getComponent('com_k2');
        $params = class_exists('JParameter') ? new JParameter($component->params) : new JRegistry($component->params);
        $obj = array(
            'title' => $item->title,
            'content' => $item->text,
            'type'  => 'k2'
        );
        if($cf->readmore){
            require_once JPATH_SITE . '/components/com_content/helpers/route.php'; 
            $access = !JComponentHelper::getParams('com_content')->get('show_noauth');
            $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
            if($access || in_array($item->access, $authorised)){
                $link = K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid);
                $obj['link'] = urldecode(JRoute::_($link));
            }else{
                $obj['link'] = JRoute::_('index.php?option=com_users&view=login');
            }
            $obj['readmore'] = $cf->readmore;
        }
        $cf->path = (string)$cf->path;
        if($cf->path !== 'none'){
            if($cf->path  == 'full' && JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg')){
                
                 $obj['path'] = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg';
                if($params->get('imageTimestamp')){
                    $obj['path'] = $item->images->image_fulltext;
                }
            }else if(JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg')){
                $obj['path'] = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';
                if ($params->get('imageTimestamp'))
                {
                    $obj['path'] .= $timestamp;
                }                  
            }
        }
        if($cf->thumb && JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg')){
            $obj['thumb'] = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';
            if ($params->get('imageTimestamp'))
            {
                $obj['thumb'] .= $timestamp;
            }
        }
        return array($obj);
    }
    
    private function from_folder($param){
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
        $dir = str_replace(array('./',JUri::root().'/'),JPATH_SITE.'/',$param->path);
        if(strrpos($dir,'/') != strlen($dir) -1) $dir .= '/';
        $path = str_replace(JPATH_SITE.'/',JUri::root('true').'/',$dir);
        $files = JFolder::files($dir,$param->filter);
        $accept = $param->accept->restore();
        $outFiles = array();
        $i = 0;
       if(count($files)) foreach($files as $file){
            $lastDot = strrpos($file,'.') + 1;
            $ext = substr($file,$lastDot);
            if(in_array(strtoupper($ext),$accept)){
                $item = new stdClass();
                $item->path = $path.$file;
                $outFiles[] = $item;
                $i++;
            } 
        }
        return $outFiles;
    }
    function data(){
        return new JVCustomParam($this->ouputData);
    }
    
}
?>

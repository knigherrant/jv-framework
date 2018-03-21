<?php
/**
 # mod_jvnews - JV News
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');
require_once JPATH_SITE.'/components/com_content/helpers/route.php';
require_once JPATH_SITE.'/components/com_content/helpers/query.php';
require_once dirname(__FILE__).'/../related.php';
require_once dirname(__FILE__).'/helper.php';
class j2Content extends RelatedContent {
    
    function getItems($options = array()){
        $items  = array();
        $items     = $this->getArticles($this->limitstart, $this->limit);
        if(count($items)) $items = $this->prepare($items); 
        return $items;     
    } 
    
    function prepare($items){
        $intros   = $links = array(); 
        if(count($items)){
            foreach ($items as $index => $item) {
		$item->slug    = $item->id.':'.$item->alias;
                $item->catslug = $item->catid.':'.$item->category_alias;    
                $item->linkcat = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid));
                $item->link    = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
                $item->text    = $item->introtext.$item->fulltext;  
                $item->emailLink  = JURI::base().ContentHelperRoute::getArticleRoute($item->slug, $item->catslug);
                if ($index < ($this->num_intro)){
                    
                    if((bool)$this->params->intro_thumbnail){      
                        $thumbnail_width  = (int) $this->params->intro_thumbnail_width;
                        $thumbnail_height = (int) $this->params->intro_thumbnail_height;   
                        $images = json_decode($item->images);
                        if($images->image_intro){
                            $path = $this->createPath();
                            $item->thumbnails = $this->createThumb($images->image_intro, $path, $thumbnail_width, $thumbnail_height,'resize');
                        }else{
                            $item->thumbnails =  $this->getThumbnails($item->text, 'resize', $thumbnail_width, $thumbnail_height, 'inside');
                        }
                        if(!$item->thumbnails) $item->thumbnails = JURI::root().'modules/mod_jvlatest_news/tmpl/default/images/noImage.png';
                    }else{
                        //$images = json_decode($item->image);
                        //$item->thumbnails = $images[0];
                    }
                    
                    if($this->params->cut_intro > 0){
                        $item->text =  cut_html_string($item->text,(int)$this->params->cut_intro);
                    }else{
                        $item->text =  $this->clearContentImage( $item->introtext );
                    }
                    $dispatcher = JDispatcher::getInstance();
    	            $dispatcher->trigger('onPrepareContent', array(&$item, &$params, 0));
                    $intros[]   = $item;
                } elseif($this->nums_link > 0 ){
                    $links[] = $item;
                }
    		    
            }
        }
        $items = new stdClass;
        $items->intros   = $intros;
        $items->links    = $links;
        return $items;
    }        
            
  
    function getArticles($offset = 0, $limit = 0){
        $db		= JFactory::getDbo();
        $app		= JFactory::getApplication();
        $id             = $this->params->article->id;
        $catid          = $this->params->article->catid;
        $user		= JFactory::getUser();
        $userId		= (int) $user->get('id');
        $groups		= implode(',', $user->getAuthorisedViewLevels());
        $nullDate	= $db->getNullDate();
        $related	= array();
        $query		= $db->getQuery(true);
        $date           = JFactory::getDate();
        $now            = $date->toSQL();

        // select the meta keywords from the item
        $query->select('metakey');
        $query->from('#__content');
        $query->where('id = ' . (int) $id);
        $db->setQuery($query);

        if ($metakey = trim($db->loadResult())){
                // explode the meta keys on a comma
                $keys = explode(',', $metakey);
                $likes = array ();
                // assemble any non-blank word(s)
                foreach ($keys as $key){
                        $key = trim($key);
                        if ($key) {
                                $likes[] = ',' . $db->getEscaped($key) . ','; // surround with commas so first and last items have surrounding commas
                        }
                }
        }     
                
        // select other items based on the metakey field 'like' the keys found
        $query->clear();
        $query->select('
                a.*
        ');

        $query->select('DATE_FORMAT(a.created, "%Y-%m-%d") as created');
        $query->select('cc.title AS category_title, cc.alias AS category_alias');
        $query->select('cc.access AS cat_access');
        $query->select('cc.published AS cat_state');
        $query->select('CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug');
        $query->select('CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug');
        $query->from('#__content AS a');
        $query->leftJoin('#__content_frontpage AS f ON f.content_id = a.id');
        $query->leftJoin('#__categories AS cc ON cc.id = a.catid');
        $query->where('a.id != ' . (int) $id);
        $query->where('a.state = 1');
        $query->where('a.access IN (' . $groups . ')');
       
        $query->where('a.catid IN (' . $catid . ')');
        $query->where('(a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).')');
        $query->where('(a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).')');

        // Filter by language
        if ($app->getLanguageFilter()) {
                $query->where('a.language in (' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
        }
        $db->setQuery($query, $offset, $limit);
        $temp = $db->loadObjectList();

        if (count($temp)) {
                foreach ($temp as $row) {
                        if ($row->cat_state == 1){
                                $row->route = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug));
                                $related[] = $row;
                        }
                }
        }
        unset ($temp);
        return $related;
    }     
   
   
}

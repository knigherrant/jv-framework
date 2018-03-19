<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2013 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');
require_once JPATH_SITE.'/components/com_content/helpers/route.php';
require_once JPATH_SITE.'/components/com_content/helpers/query.php';
require_once dirname(__FILE__).'/helper.php';

class modJVLNewsContent extends modJVLatestNewsHelper {
    public $sp_content = array();
    function getItems($options = array()){
        $items  = array();
	$this->setOption($options);
        switch($this->source){
            case 'content':
                $ids = $this->getSPId('article');
                
                if(count($ids) > 0 && $this->limitstart < 1){
                    $this->sp_content = $ids;
                    $sp_condition = $this->buildConditionSP($ids);
                    $limitsp = (count($ids) > $this->limit)? $this->limit:count($ids);
                    $spArt      = $this->getArticles($this->limitstart,$limitsp , $sp_condition);
                    $spArt = $this->shortItems($spArt, $ids);
                    $limit = $this->limit - count($spArt);
                    $condition = $this->buildCondition();
                    if($limit > 0) $items      = $this->getArticles($this->limitstart, $limit, $condition);
                    if($spArt) $items = array_merge ((array)$spArt,(array)$items);
                }else {
                    $condition = $this->buildCondition();
                    $items     = $this->getArticles($this->limitstart, $this->limit, $condition);
                }
            break;
        }
        
        if($this->params->get('group_cat')){
            $items = $this->groupByCategory($items);
            foreach ($items as $catid=>&$item)  $item = $this->prepare($item); 
        }else{
            if(count($items)) $items = $this->prepare($items); 
        }

        return $items;     
    } 
    
    function shortItems($items, $ids){
		$data = array();
                if(!isset($items)) return $data;
		foreach ($ids as $i=>$id){
			foreach ($items as $item){
				if($id == $item->id){
					$data[] = $item;
				}
			}
		}
		return $data;
	}
	
    function getCategories(){
        $catid = (array) $this->params->get('catid', '0');
        $db = JFactory::getDbo();
        return $db->setQuery('SELECT * FROM #__categories WHERE id IN (' . implode(',', $catid) . ' ) ORDER BY rgt')->loadObjectList();
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
                    
                    if((bool)$this->params->get('intro_thumbnail')){      
                        $thumbnail_width  = (int) $this->params->get('intro_thumbnail_width', 64);
                        $thumbnail_height = (int) $this->params->get('intro_thumbnail_height', 64);   
                        $images = json_decode($item->images);

                        if(@$images->image_intro){
                            $path = $this->createPath();
                            $item->thumbnails = $this->createThumb($images->image_intro, $path, $thumbnail_width, $thumbnail_height,$this->params->get('intro_thumbnail'));
                        }else{
                            $item->thumbnails =  $this->getThumbnails($item->text, $this->params->get('intro_thumbnail'), $thumbnail_width, $thumbnail_height, $this->params->get('intro_thumbnail_position') == 'inside');
                        }
                        if(!$item->thumbnails) $item->thumbnails = JURI::root().'modules/mod_jvlatest_news/tmpl/default/images/noImage.png';
                    }else{
                        //$images = json_decode($item->image);
                        //$item->thumbnails = $images[0];
                    }
                    
                    if($this->params->get('cut_intro') > 0){
                        $item->text =  cut_html_string($this->clearContentImage( $item->introtext ) ,(int)$this->params->get('cut_intro'));
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
            
    function getCategory($id){
        $db	   = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('c.*');
        $query->select('CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as slug');
        $query->from('#__categories as c');
        $query->where('(c.extension='.$db->Quote('com_content').' OR c.extension='.$db->Quote('system').')');
        $query->where('c.published = 1');
        $query->where('c.id = ' .$id);
        $query->order('c.lft');
        $db->setQuery($query);
        $item = $db->loadObject();
        $item->link = JRoute::_(ContentHelperRoute::getCategoryRoute($item->slug));
        return $item;        
    }
    
    function getPagination($total = null, $limit = null, $limitstart = null){   
        $limitstart = $limitstart != null ? $limitstart : $this->limitstart;
        $limit      = $limit != null ? $limit : $this->limit;
        $total      = $total != null ? $total : $this->getTotal();   
        $pagination = new JVLNewPagination($total, $limitstart, $limit);
        return $pagination;
    }
    
    function getTotal(){
        $total = 0;
        //Build condition
        
        //if($this->sp_content) $condition = self::buildConditionSP($this->sp_content);
        $condition = self::buildCondition();
        $total  = count($this->getArticles(0, 0 , $condition)) + count($this->sp_content);
        return $total;
    }
    
    function getArticles($offset = 0, $limit = 0, $condition){
        $db    = JFactory::getDBO();        
    	$query =' SELECT a.id, a.fulltext, a.title,a.images, a.alias, a.introtext, a.checked_out, a.checked_out_time, a.catid, a.created, a.created_by, a.created_by_alias,' .
                ' CASE WHEN a.modified = 0 THEN a.created ELSE a.modified END as modified, a.modified_by, uam.name as modified_by_name,'.
                ' CASE WHEN a.publish_up = 0 THEN a.created ELSE a.publish_up END as publish_up, '.
                ' a.publish_down, a.attribs, a.metadata, a.metakey, a.metadesc, a.access, a.hits, a.xreference, a.featured, LENGTH(a.fulltext) AS readmore ,'.
                ' CASE WHEN badcats.id is not null THEN 0 ELSE a.state END AS state,c.title AS category_title, c.path AS category_route, c.access AS category_access, c.alias AS category_alias,'.
                ' CASE WHEN a.created_by_alias > " " THEN a.created_by_alias ELSE ua.name END AS author,ua.email AS author_email,contact.id as contactid,parent.title as parent_title, '.
                ' parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias,ROUND( v.rating_sum / v.rating_count ) AS rating, v.rating_count as rating_count,c.published, '.
                ' CASE WHEN badcats.id is null THEN c.published ELSE 0 END AS parents_published'.				
                ' FROM #__content AS a' .			
                ' LEFT JOIN #__categories AS c ON c.id = a.catid' .
                ' LEFT JOIN #__users AS ua ON ua.id = a.created_by' .
                ' LEFT JOIN #__users AS uam ON uam.id = a.modified_by'.
                ' LEFT JOIN #__contact_details AS contact on contact.user_id = a.created_by'.
                ' LEFT JOIN #__categories as parent ON parent.id = c.parent_id'.
                ' LEFT JOIN #__content_rating AS v ON a.id = v.content_id'.
                ' LEFT OUTER JOIN (SELECT cat.id as id FROM #__categories AS cat '.
                ' JOIN #__categories AS parent ON cat.lft BETWEEN parent.lft AND parent.rgt WHERE parent.extension = "com_content" AND parent.published != 1 GROUP BY cat.id ) AS badcats ON badcats.id = c.id '
                . $condition
        ;
        $db->setQuery($query, $offset, $limit);      
        $articles = $db->loadObjectList();
        if(!$articles)return;
        return $articles;
    }                            
        
    function buildConditionSP($ids){
        $catids  = isset($this->options['catids'])  ? (array) $this->options['catids'] : (array) $this->params->get('catid', '0');
        $condition = ' ';  
        $where     = array();  
        $where[]    = "a.id in (".implode(',', $ids).")";
        $where[]    = "a.state > 0";
        $where[]    = "c.published = 1";
        $condition .= ' WHERE '.implode(" AND ", $where). ' ' ;
        return $condition;      
    }
  
    function buildCondition(){
        $catids  = isset($this->options['catids'])  ? (array) $this->options['catids'] : (array) $this->params->get('catid', '0');
        $order     = $this->buildContentOrderBy();
        $condition = ' ';  
        $where     = array();  
        $catids    = $catids != null ? (array) $catids : (array) $this->params->get('catid', '0');
        $typeContent = $this->params->get('type_content',0);
        if($typeContent == '1'){
            $condition .= 	'JOIN #__content_frontpage AS fp ON fp.content_id = a.id';
        }
        if($this->sp_content) $where[]     = "a.id not in (".implode(',', $this->sp_content).")";
        if($typeContent == '1') $where[]    = "a.featured = 1"; //only
        if($typeContent == '2') $where[]    = "a.featured = 0";
        if($catids)$where[]    = "c.id in (".implode(',', $catids).")";
        $where[]    = "a.state > 0";
        $where[]    = "c.published = 1";
        $condition .= ' WHERE '.implode(" AND ", $where). ' ' .$order;
        return $condition;      
    }
    
    function buildContentOrderBy(){   
        $orderby        = array();
        $orderby_sec	= $this->params->def('orderby_sec', 'rdate');
            if($orderby_sec	== 'random'){
            return ' ORDER BY RAND() ';
        }else{
            $orderby_sec	= ($orderby_sec == 'front') ? '' : $orderby_sec;
            $orderby_pri	= $this->params->def('orderby_pri', '');
            $orderby[]		= ContentHelperQuery::orderbySecondary($orderby_sec);
            $orderby[]		= ContentHelperQuery::orderbyPrimary($orderby_pri);
            $orderby = array_filter($orderby);
            if(!count($orderby)){
               $orderby[] = 'a.created DESC';
            }
            return ' ORDER BY ' . implode(',', $orderby);
        }
    }          
}

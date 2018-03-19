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

if(file_exists(JPATH_SITE.'/components/com_k2/helpers/route.php')){
    require_once(JPATH_SITE.'/components/com_k2/helpers/route.php');    
}
if(file_exists(JPATH_SITE.'/components/com_k2/helpers/utilities.php')){
    require_once(JPATH_SITE.'/components/com_k2/helpers/utilities.php');    
}

if(file_exists(JPATH_SITE.'/components/com_k2/models/item.php')){
    JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_k2/models', 'K2Model');
}

require_once JPATH_SITE.'/components/com_content/helpers/query.php';

require_once dirname(__FILE__).'/helper.php';

class modJVLNewsK2Content extends modJVLatestNewsHelper {
    public $sp_content = array();
    function getItems($options = array()){
        $items  = array();
        $this->setOption($options);

        switch($this->source){
            case 'k2content':
                $ids = $this->getSPItems();
				
                if(count($ids) > 0 && $this->limitstart < 1){
                    $this->sp_content = $ids;
                    $sp_condition = $this->buildConditionSP($ids);
                    $limitsp = (count($ids) > $this->limit)? $this->limit:count($ids);
                    $spArt      = $this->getArticles($this->limitstart, $limitsp, $sp_condition);
					$spArt = $this->shortItems($spArt, $ids);

                    $limit = $this->limit - count($spArt);
                    $condition = $this->buildCondition();
                    if($limit > 0) $items      = $this->getArticles($this->limitstart, $limit, $condition);
                    if($spArt) $items = array_merge ((array)$spArt,(array)$items);
                }else{
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
        return $db->setQuery('SELECT *, name as title FROM #__k2_categories WHERE id IN (' . implode(',', $catid) . ' ) ORDER BY ordering')->loadObjectList();
     }   
        
    function prepare($items){
        $intros = $links  = array();

        if(count($items)) :
            foreach ($items as $index => $item) {
                $item->slug    = $item->id.':'.urlencode($item->alias);
                $item->catslug = $item->catid.':'.urlencode($item->category_alias);
                $item->link = JRoute::_(K2HelperRoute::getItemRoute($item->slug, $item->catslug));
                $item->linkcat = JRoute::_(K2HelperRoute::getCategoryRoute($item->catid));
                $item->text    = $item->introtext.$item->fulltext;
                $item->emailLink  = JURI::base().K2HelperRoute::getItemRoute($item->slug, $item->catslug);

              if ($index < ($this->num_intro)){
                    if((bool)$this->params->get('intro_thumbnail')){      
                        $thumbnail_width  = (int) $this->params->get('intro_thumbnail_width', 64);
                        $thumbnail_height = (int) $this->params->get('intro_thumbnail_height', 64);   
                        $images = JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_L.jpg';
                        if(JFile::exists($images)){
                            $images = 'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_L.jpg';
                            $path = $this->createPath();
                            $item->thumbnails = $this->createThumb($images, $path, $thumbnail_width, $thumbnail_height,$this->params->get('intro_thumbnail'));
                        }else{
                            $item->thumbnails =  $this->getThumbnails($item->text, $this->params->get('intro_thumbnail'), $thumbnail_width, $thumbnail_height, $this->params->get('intro_thumbnail_position') == 'inside');
                        }
                        if(!$item->thumbnails) $item->thumbnails = JURI::root().'modules/mod_jvlatest_news/tmpl/default/images/noImage.png';
                    }else{
                        //$images = json_decode($item->image);
                        //$item->thumbnails = $images[0];
                    }
                    
                    if($this->params->get('cut_intro') > 0){
                        $item->text =  cut_html_string($this->clearContentImage( $item->introtext ),(int)$this->params->get('cut_intro'));
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
        endif;
        $items = new stdClass;
        $items->intros   = $intros;
        $items->links    = $links;
        return $items;
    }

    function getCategory($id){
        $db	   = JFactory::getDbo();
        $query = $db->getQuery(true);

        // right join with c for category
        $query->select('c.name as title, c.*');
        $query->from('#__k2_categories as c');
        $query->where('c.published = 1');
        $query->where('c.id = ' .$id);
        $query->order('c.parent');

        // Get the results
        $db->setQuery($query);
        $item = $db->loadObject();
        $item->link = JRoute::_(K2HelperRoute::getCategoryRoute($item->id.':'.urlencode($item->alias)));
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
        if($this->source == 'relatedk2'){
            $option	= JRequest::getCmd('option');
            $view	= JRequest::getCmd('view');
            $temp	= JRequest::getString('id');
            $temp	= explode(':', $temp);
            $id		= $temp[0];

            if ($option == 'com_k2' && $view == 'item' && $id){
                //Get pagination
                $total  = count(self::getRelatedItemsById($id, 0, 0));
            }
        }else{
            //Build condition
            $condition = self::buildCondition();
            //Get pagination
            $total  = count($this->getArticles(0, 0 , $condition)) + count($this->sp_content);
        }
        return $total;
    }

    function getArticles($offset = 0, $limit = 0, $condition){
        $db    = JFactory::getDBO();
        $query =' SELECT a.id, a.fulltext,a.params, a.title, a.alias, a.introtext, a.checked_out, a.checked_out_time, a.catid, a.created, a.created_by, a.created_by_alias,' .
            ' CASE WHEN a.modified = 0 THEN a.created ELSE a.modified END as modified, a.modified_by, uam.name as modified_by_name,'.
            ' CASE WHEN a.publish_up = 0 THEN a.created ELSE a.publish_up END as publish_up, '.
            ' a.publish_down, a.metadata, a.metakey, a.metadesc, a.access, a.hits, a.featured, LENGTH(a.fulltext) AS readmore ,'.
            ' a.published AS state,c.name AS category_title, c.alias AS category_route, c.access AS category_access, c.alias AS category_alias,'.
            ' CASE WHEN a.created_by_alias > " " THEN a.created_by_alias ELSE ua.name END AS author,ua.email AS author_email,contact.id as contactid,parent.name as parent_title, '.
            ' parent.id as parent_id, parent.alias as parent_route, parent.alias as parent_alias,ROUND( v.rating_sum / v.rating_count ) AS rating, v.rating_count as rating_count,c.published, '.
            ' c.published AS parents_published'.
            ' FROM #__k2_items AS a' .
            ' LEFT JOIN #__k2_categories AS c ON c.id = a.catid' .
            ' LEFT JOIN #__users AS ua ON ua.id = a.created_by' .
            ' LEFT JOIN #__users AS uam ON uam.id = a.modified_by'.
            ' LEFT JOIN #__contact_details AS contact on contact.user_id = a.created_by'.
            ' LEFT JOIN #__k2_categories as parent ON parent.id = c.parent'.
            ' LEFT JOIN #__k2_rating AS v ON a.id = v.itemID'.
            $condition
        ;

        $db->setQuery($query, $offset, $limit);
        $articles = $db->loadObjectList();
        if(!$articles){
            return;
        }
        return $articles;
    }


    public function getArticleById($id = null){
        $id = $id != null ? $id : (int) $this->params->get('leading_item');

        if(!$id) return;
        $db = JFactory::getDBO();
        $query	= $db->getQuery(true);
        //get k2 item
        $query->select('a.*');
        $query->from('#__k2_items AS a');
        $query->where('a.published=1');
        $query->where('a.trash=0');
        $query->where('a.id='.$id);
        //join category
        $query->select('cat.alias AS category_alias');
        $query->join('LEFT', '#__k2_categories AS cat ON cat.id = a.catid');
        $query->where('cat.published=1');
        $query->where('cat.trash=0');
        $db->setQuery($query, 0, 1);
        $item = $db->loadObject();

        if($item->id != ''){
            $item->slug    = $item->id.':'.urlencode($item->alias);
            $item->catslug = $item->catid.':'.urlencode($item->category_alias);
            $item->link      = JRoute::_(K2HelperRoute::getItemRoute($item->slug, $item->catslug));
            $item->emailLink = JURI::base().K2HelperRoute::getItemRoute($item->slug, $item->catslug);
            $item->text      = $item->introtext.$item->fulltext;

            if((bool)$this->params->get('article_thumbnail') || (bool) $this->params->get('hide_leading_image')){
                $thumbnail_width  = (int) $this->params->get('article_thumbnail_width', 150);
                $thumbnail_height = (int) $this->params->get('article_thumbnail_height', 100);
                $item->thumbnails = self::getThumbnails($item->text, $this->params->get('article_thumbnail_mode', 'adaptiveresize'), $thumbnail_width, $thumbnail_height, $this->params->get('article_thumbnail_position') == 'inside', (bool) $this->params->get('hide_article_image'));
            }

            if($this->params->get('article_maxchars', 400) == 0){
                $item->text =  $this->params->get('hide_article_image') ? modJVLatestNewsHelper::clearContentImage( $item->introtext ) : $item->introtext;
            }else{
                $item->text =  cut_html_string($item->text,(int) $this->params->get('article_maxchars', 400));
            }

            $dispatcher =& JDispatcher::getInstance();
            $dispatcher->trigger('onContentPrepare', array('com_k2.item', &$item, &$params, 0));

            return $item;
        }

        return;
    }

    
     function buildConditionSP($ids){
       
        $condition = ' ';  
        $where     = array();  
        $where[]    = "a.id in (".implode(',', $ids).")";
        $where[]    = "a.published = 1";
        $where[]    = "a.trash = 0";
        $where[]    = "c.published = 1";
        $condition .= ' WHERE '.implode(" AND ", $where). ' ';
        
        return $condition;
    }
    

    function buildCondition(){
        $catids  = isset($this->options['catids'])  ? (array) $this->options['catids'] : (array) $this->params->get('k2catid', '0');
        $aticles = isset($this->options['aticles']) ? (array) $this->options['aticles'] : (array) $this->params->get('item', '0');
        $order     = $this->buildContentOrderBy();
        $condition = ' ';
        $where     = array();
        $catids    = $catids != null ? (array) $catids : (array) $this->params->get('k2catid', '0');
        $typeContent = $this->params->get('type_content',0);
        if($typeContent == '1') $where[]    = "a.featured = 1";
        if($typeContent == '2') $where[]    = "a.featured = 0";
        if($catids) $where[]    = "c.id in (".implode(',', $catids).")";
        if($this->sp_content) $where[]     = "a.id not in (".implode(',', $this->sp_content).")";
        $where[]    = "a.published = 1";
        $where[]    = "a.trash = 0";
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

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

class k2Content extends RelatedContent {
    function getItems($options = array()){
        $items  = array();
        
        $condition = $this->buildCondition();
        $items     = $this->getArticles($this->limitstart, $this->limit, $condition);

        if(count($items)){
            $items = $this->prepare($items);
        }
        return $items;
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
                            $item->thumbnails = $this->createThumb($images, $path, $thumbnail_width, $thumbnail_height,'resize');
                        }else{
                            $item->thumbnails =  $this->getThumbnails($item->text, 'resize', $thumbnail_width, $thumbnail_height, $this->params->get('intro_thumbnail_position') == 'inside');
                        }
                        if(!$item->thumbnails) $item->thumbnails = JURI::root().'modules/mod_jvlatest_news/tmpl/default/images/noImage.png';
                    }else{
                        //$images = json_decode($item->image);
                        //$item->thumbnails = $images[0];
                    }
                    
                    if($this->params->get('cut_intro') > 0){
                        $item->text =  cut_html_string($item->text,(int)$this->params->get('cut_intro'));
                    }else{
                        $item->text =  $this->clearContentImage( $item->introtext );
                    }
                    $dispatcher =& JDispatcher::getInstance();
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



}

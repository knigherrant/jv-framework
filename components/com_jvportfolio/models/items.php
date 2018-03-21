<?php

/**
 * @version     1.0.0
 * @package     com_jvportfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Jvportfolio records.
 */
class JvportfolioModelItems extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'name', 'a.name',
                'image', 'a.image',
                'desc', 'a.desc',
                'link', 'a.link',
                'tag', 'a.tag',
                'cate', 'a.cate',
                'ordering', 'a.ordering',
                'created_by', 'a.created_by',
                'date_created', 'a.date_created',

            );
        }
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $app = JFactory::getApplication();
        $this->setState('list.limit', $app->input->getInt('limit', 20));
        $this->setState('list.start', $app->input->getInt('limitstart', 0));

        
		if(empty($ordering)) {
			$ordering = 'a.ordering';
		}
        
        if(($menu = $app->getMenu()->getActive())) {
            if($menu->params->get('filter', 0)) {
                if(($tags = $menu->params->get('tags', 0)) && count($tags)) {
                    $this->setState('a.tag', implode(',', $tags));     
                }
                if(($cate = $menu->params->get('cate', 0)) && count($cate)) {
                    $this->setState('a.cate', implode(',', $cate));     
                }                                             
            }
            
            $this->setState('isize', $menu->params->get('isize', '0x0'));    
        }

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $uid = JvportfolioFrontendHelper::getUid();
        $query->select(
            array(
                $this->getState('list.select', 'DISTINCT a.*'),
                "(select count(*) from #__jvportfolio_liked as l where l.pfid = a.id) as cliked",
                "(select count(*) from #__jvportfolio_liked as l where l.u = '{$uid}') as lactive"
            )
        );

        $query->from('`#__jvportfolio_item` AS a');
        
        // Order
        $query ->order('a.id DESC');
        
        // Filter with tag 
        if($tag = $this->getState('a.tag', 0)) {
            $tag = trim($tag, ',');
            $query->where("a.tag in ({$tag})");
        }
        // Filter with cate 
        if($cate = $this->getState('a.cate', 0)) {
            $cate = trim($cate, ',');
            $query->where("a.cate in ({$cate})");
        }
        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        if(!$items) return false;
		$tags = array();
        foreach($items as &$item){
	        if ( !isset($item->tag) ) continue;
			$tags = array_merge($tags, explode(',', $item->tag));
            JvportfolioFrontendHelper::build($item, $this->getState('isize', '0x0'));
		}
        return array('items'=>$items, 'tags'=>$tags);
	}             
}

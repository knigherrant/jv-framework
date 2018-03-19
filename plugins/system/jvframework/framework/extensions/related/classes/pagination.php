<?php
/**
 # mod_jvnews - JV News
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class JVNewPagination extends JPagination {
    
    /**
	 * Create and return the pagination data object
	 *
	 * @access	public
	 * @return	object	Pagination data object
	 * @since	1.5
	 */
	function _buildDataObject()
	{
		// Initialize variables
		$data = new stdClass();
        $modid = $this->get('modid');
        $Itemid = JRequest::getInt('Itemid');
        
		$data->all	= new JPaginationObject(JText::_('View All'));
		if (!$this->_viewall) {
			$data->all->base	= '0';
			$data->all->link	= JRoute::_("&mid={$modid}&Itemid=$Itemid&limit-start");
		}

		// Set the start and previous data objects
		$data->start	= new JPaginationObject('Start');
		$data->previous	= new JPaginationObject('Prev');

		if ($this->get('pages.current') > 1)
		{
			$page = ($this->get('pages.current') -2) * $this->limit;

			$page = $page == 0 ? '' : $page; //set the empty for removal from route

			$data->start->base	= '0';
			$data->start->link	= JRoute::_("&mid={$modid}&Itemid=$Itemid&limit-start=");
			$data->previous->base	= $page;
			$data->previous->link	= JRoute::_("&mid={$modid}&Itemid=$Itemid&limit-start=".$page);
		}

		// Set the next and end data objects
		$data->next	= new JPaginationObject('Next');
		$data->end	= new JPaginationObject('End');

		if ($this->get('pages.current') < $this->get('pages.total'))
		{
			$next = $this->get('pages.current') * $this->limit;
			$end  = ($this->get('pages.total') -1) * $this->limit;

			$data->next->base	= $next;
			$data->next->link	= JRoute::_("&mid={$modid}&Itemid=$Itemid&limit-start=".$next);
			$data->end->base	= $end;
			$data->end->link	= JRoute::_("&mid={$modid}&Itemid=$Itemid&limit-start=".$end);
		}

		$data->pages = array();
		$stop = $this->get('pages.stop');
		for ($i = $this->get('pages.start'); $i <= $stop; $i ++)
		{
			$offset = ($i -1) * $this->limit;

			$offset = $offset == 0 ? '' : $offset;  //set the empty for removal from route

			$data->pages[$i] = new JPaginationObject($i);
			if ($i != $this->get('pages.current') || $this->_viewall)
			{
				$data->pages[$i]->base	= $offset;
				$data->pages[$i]->link	= JRoute::_("&mid={$modid}&Itemid=$Itemid&limit-start=".$offset);
			}
		}
		return $data;
	}
    
    /**
	 * Create and return the pagination page list string, ie. Previous, Next, 1 2 3 ... x
	 *
	 * @access	public
	 * @return	string	Pagination page list string
	 * @since	1.0
	 */
	function getPagesLinks($theme = null)
	{
		$mainframe = JFactory::getApplication();

		$lang =& JFactory::getLanguage();
        $modid = $this->get('modid');
        
		// Build the page navigation list
		$data = $this->_buildDataObject();

		$list = array();

		$itemOverride = false;
		$listOverride = false;
        
        $themePath  = JPATH_ROOT.'/modules/mod_jvnews/tmpl/pagination.php';
		$tPath = JPATH_THEMES.'/'.$mainframe->getTemplate().'/html/pagination.php';
	    if(isset($themePath)){
	       $chromePath = $themePath;
	    }else{
	       $chromePath = $tPath;
	    }
   
		if (file_exists($chromePath))
		{
			require_once ($chromePath);
			if (function_exists('jvnew_pagination_item_active') && function_exists('jvnew_pagination_item_inactive')) {
				$itemOverride = true;
			}
			if (function_exists('jvnew_pagination_list_render')) {
				$listOverride = true;
			}
		}

		// Build the select list
		if ($data->all->base !== null) {
			$list['all']['active'] = true;
            $data->all->modid = $modid;
			$list['all']['data'] = ($itemOverride) ? jvnew_pagination_item_active($data->all) : $this->_item_active($data->all);
		} else {
			$list['all']['active'] = false;
            $data->all->modid = $modid;
			$list['all']['data'] = ($itemOverride) ? jvnew_pagination_item_inactive($data->all) : $this->_item_inactive($data->all);
		}

		if ($data->start->base !== null) {
			$list['start']['active'] = true;
            $data->start->modid = $modid;
			$list['start']['data'] = ($itemOverride) ? jvnew_pagination_item_active($data->start) : $this->_item_active($data->start);
		} else {
			$list['start']['active'] = false;
            $data->start->modid = $modid;
			$list['start']['data'] = ($itemOverride) ? jvnew_pagination_item_inactive($data->start) : $this->_item_inactive($data->start);
		}
		if ($data->previous->base !== null) {
			$list['previous']['active'] = true;
            $data->previous->modid = $modid;
			$list['previous']['data'] = ($itemOverride) ? jvnew_pagination_item_active($data->previous) : $this->_item_active($data->previous);
		} else {
			$list['previous']['active'] = false;
            $data->previous->modid = $modid;
			$list['previous']['data'] = ($itemOverride) ? jvnew_pagination_item_inactive($data->previous) : $this->_item_inactive($data->previous);
		}

		$list['pages'] = array(); //make sure it exists
		foreach ($data->pages as $i => $page)
		{
			if ($page->base !== null) {
				$list['pages'][$i]['active'] = true;
                $page->modid = $modid;
				$list['pages'][$i]['data'] = ($itemOverride) ? jvnew_pagination_item_active($page) : $this->_item_active($page);
			} else {			    
				$list['pages'][$i]['active'] = false;
                $page->modid = $modid;
				$list['pages'][$i]['data'] = ($itemOverride) ? jvnew_pagination_item_inactive($page) : $this->_item_inactive($page);
			}
		}

		if ($data->next->base !== null) {
			$list['next']['active'] = true;
            $data->next->modid = $modid;
			$list['next']['data'] = ($itemOverride) ? jvnew_pagination_item_active($data->next) : $this->_item_active($data->next);
		} else {
			$list['next']['active'] = false;
            $data->next->modid = $modid;
			$list['next']['data'] = ($itemOverride) ? jvnew_pagination_item_inactive($data->next) : $this->_item_inactive($data->next);
		}
		if ($data->end->base !== null) {
			$list['end']['active'] = true;
            $data->end->modid = $modid;
			$list['end']['data'] = ($itemOverride) ? jvnew_pagination_item_active($data->end) : $this->_item_active($data->end);
		} else {
			$list['end']['active'] = false;
            $data->end->modid = $modid;
			$list['end']['data'] = ($itemOverride) ? jvnew_pagination_item_inactive($data->end) : $this->_item_inactive($data->end);
		}

		if($this->total > $this->limit){
			return ($listOverride) ? jvnew_pagination_list_render($list) : $this->_list_render($list);
		}
		else{
			return '';
		}
	}
}
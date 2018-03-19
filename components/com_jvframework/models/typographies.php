<?php
/**
 # com_jvframework - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist' );
jimport('joomla.database.databasequery' );

class JVFrameworkModelTypographies extends JModelList{
    
    protected function populateState($ordering = null, $direction = null) {
        parent::populateState('a.ordering', 'asc');
		$this->state->set('list.start', 0);
		$this->state->set('list.limit', 0);
    }
        
    protected function _getListQuery() { 
        $order = $this->_buildContentOrderBy();
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__jv_typos as a');
        
        // Filter by search in title
		$search = $this->getState($this->context.'.filter_search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(a.title LIKE '.$search.')');
			}
		}	
		$query->where('a.published > 0');
		$query->order($order);
		
        return (string) $query;
    }
        
    protected function attributeLabels() {
		return array(
			'id'    => array('a', 'ID'),
            'title' => array('a', 'COM_JVFRAMEWORK_TYPOGRAPHYS_TITLE'),
            'tag'   => array('a', 'COM_JVFRAMEWORK_TYPOGRAPHYS_TAG'),
            'replacement' => array('a', 'COM_JVFRAMEWORK_TYPOGRAPHYS_REPLACEMENT'),
            'example'    => array('a', 'COM_JVFRAMEWORK_TYPOGRAPHYS_EXAMPLE'),
			'published'  => array('a', 'COM_JVFRAMEWORK_PUBLISHED'),
		);
	}  
	public function getLabels() {
		$labels = new stdClass ();
		$atts = $this->attributeLabels ();
		$filter_order_Dir = $this->getState ( 'list.direction' );
		$filter_order = $this->getState ( 'list.ordering' );
	
		foreach ( $atts as $key => $att ) {
			if (isset ( $att [2] ) && ! $att [2]) {
				$labels->$key = JText::_ ( $att [1] );
			} else {
				$labels->$key = JHtml::_ ( 'grid.sort', JText::_ ( $att [1] ), $att [0] . '.' . $key, $filter_order_Dir, $filter_order );
			}
		}
	
		return $labels;
	}
	protected function _buildContentOrderBy() {
		$orderby = '';
		$filter_order_Dir = $this->getState ( 'list.direction' );
		$filter_order = $this->getState ( 'list.ordering' );
	
		/* Error handling is never a bad thing */
		if (! empty ( $filter_order ) && ! empty ( $filter_order_Dir )) {
			$orderby .= $filter_order . ' ' . $filter_order_Dir;
		}
	
		return $orderby;
	}
    
}


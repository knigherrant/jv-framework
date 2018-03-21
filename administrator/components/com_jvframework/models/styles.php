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
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.modellist' );
jimport ( 'joomla.database.databasequery' );
class JVFrameworkManagerModelStyles extends JModelList {
	protected $option = 'com_jvframework';
	
	/**
	 * Constructor.
	 *
	 * @param
	 *        	array	An optional associative array of configuration settings.
	 * @see JController
	 * @since 1.6
	 */
	public function __construct($config = array()) {
		if (empty ( $config ['filter_fields'] )) {
			$config ['filter_fields'] = array (
					'id',
					'a.id',
					'title',
					'a.title',
					'theme',
					'a.theme',
					'home',
					'a.home' 
			);
		}
		
		parent::__construct ( $config );
	}
	protected function populateState($ordering = null, $direction = null) {
		$search = $this->getUserStateFromRequest ( $this->context . '.filter.search', 'filter_search' );
		$this->setState ( 'filter.search', $search );
		parent::populateState ( 'a.theme', 'desc' );
	}
	protected function _getListQuery() {
		$order = $this->_buildContentOrderBy ();
		$db = JFactory::getDBO ();
		$query = $db->getQuery ( true );
		$query->select ( 'a.*' );
		$query->from ( '#__jv_theme_styles as a' );
		
		// Filter by search in title
		$search = $this->getState ( 'filter.search' );
		if (! empty ( $search )) {
			if (stripos ( $search, 'id:' ) === 0) {
				$query->where ( 'a.id = ' . ( int ) substr ( $search, 3 ) );
			} else {
				$search = $db->Quote ( '%' . $db->escape ( $search, true ) . '%' );
				$query->where ( '(a.theme LIKE ' . $search . ')' );
			}
		}
		if ($order)
			$query->order ( $order );
		
		return ( string ) $query;
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
	public function getItems() {
		$items = parent::getItems ();
		
		if ( is_array($items) ) {
			foreach ( $items as &$item ) {
				$item->assign = $this->isAssign ( $item->id );
			}
		}
		
		return $items;
	}
	function isAssign($pk) {
		$db = & JFactory::getDBO ();
		$db->setQuery ( " SELECT menuid 
                        FROM #__jv_theme_assign 
                        WHERE themeid='" . $pk . "'" );
		
		return $db->loadResult ();
	}
	protected function attributeLabels() {
		return array (
				'id' => array (
						'a',
						'ID' 
				),
				'title' => array (
						'a',
						'COM_JVFRAMEWORK_MANAGER_STYLES_TITLE' 
				),
				'home' => array (
						'a',
						'COM_JVFRAMEWORK_THEMES_HOME' 
				),
				'assign' => array (
						'',
						'COM_JVFRAMEWORK_THEMES_ASSIGNED',
						false 
				),
				'theme' => array (
						'a',
						'COM_JVFRAMEWORK_THEMES_TITLE' 
				),
				'params' => array (
						'a',
						'COM_JVFRAMEWORK_THEMES_ASSIGNED' 
				),
				'published' => array (
						'a',
						'COM_JVFRAMEWORK_THEMES_HOME' 
				) 
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
}

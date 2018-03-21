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
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class FlexMenu {
	
	protected $active;
	protected $items;
	protected $children;
	protected $params;
	protected $startLevel;
	protected $endLevel;
	
	public function __construct($params) {
		$menus = JFactory::getApplication()->getMenu ();
		$this->items = $menus->getItems ( 'menutype', $params->get ( 'menutype', 'mainmenu' ) );
		$this->active = $menus->getActive () ? $menus->getActive () : $menus->getDefault ();
		$this->params = $params;
        $this->startLevel = $this->params->get ( 'startLevel', 0 );
        $this->endLevel = $this->params->get ( 'endLevel', 0 );
		$this->prepare ();
	}
	
	public function prepare() {
		if (! count ( $this->items ))
			return;
		
		$items = $children = array();
                
		foreach ( $this->items as $item ) {
			$pt   = isset ( $item->parent_id ) ? $item->parent_id : 0;
			$list =  isset($children [$pt]) ? $children [$pt] : array ();

			array_push ( $list, $item ); $children [$pt] = $list;

            if(in_array($item->id, $this->active->tree)){
                $item->active = true;
            }

			$items [$item->id] = $item;
		}

		$this->items = $items;
		$this->children = $children;
		unset($items); unset($children);
	}
	
	public function render() {
		$html = '';
		$html .= $this->beginMenu ();
        $html .= $this->genMenuItems ( 1, $this->startLevel );
		$html .= $this->endMenu ();
		
		return $html;
	}
	
	protected function genMenuItems($pid, $level, $numchild = 0, $column = false) {
		$html = array ();
		
               
                
		if (isset ( $this->children [$pid] )) {
                        $s=1;
			for($i = 0; $i < count ( $this->children [$pid] ); $i ++) {
				$item = $this->children [$pid] [$i];
				$hasChild = isset ( $this->children [$item->id] );
				$menuItem = $this->getItem ( $item, $level, $i, $hasChild, $numchild, $column );
				$html [] = $menuItem->begin ($s);
				$html [] = $menuItem->getHtml ();
				if ($level < $this->endLevel || $this->endLevel == 0) {
					if ($hasChild) {
						$html [] = $menuItem->beginSub ();
						$html = array_merge ( $html, ( array ) $this->genMenuItems ( $item->id, $level + 1, count ( $this->children [$item->id] ), $menuItem->getParam ( 'fxmenu_column' ) ) );
						$html [] = $menuItem->endSub ();
					}
				}
				$s++;
				$html [] = $menuItem->end ($s);
			}
		}
		return implode ( "\n", $html );
	}
	
	protected function getItem($item, $level, $index, $hasChild, $numchild, $column = false) { 
		$menuItem = null;		
		
		$item->index = $index;
		$item->haschild = $hasChild;
		$item->level = $level;
		$item->column = $column;
		$item->numchild = $numchild;
                
               
                
		if($item->column && $item->numchild >= 1){
			$item->colbreak = round($item->numchild / $item->column); 
			//if($item->column%2==0 && $item->numchild % $item->column && $item->colbreak < ($item->numchild / $item->column)){
			//	$item->colbreak += 1; 
			//}
		}			 
		if($item->params->get('fxmenu_item')){
			$item->oldtype = $item->type;
			$item->type = $item->params->get('fxmenu_item');
		}
		
		$class = "FlexMenuItem" . $item->type;
    
		if ($this->loadItem ( $item->type )) {
			$menuItem = new $class ( $item );
		
		} else {
			$this->loadItem ( 'component' );
			$menuItem = new FlexMenuItemComponent ( $item );
		}
		
		return $menuItem;
	}
	
	function loadItem($type) {
		$path = dirname ( __FILE__ ) . "/items/{$type}.php"; 
		if (is_file ( $path )) {
			require_once $path;
			
			return true;
		}
		
		return false;
	}
	
	function beginMenu() {		
		$class = $this->params->get ( 'menu_class' );	
		return '<ul id="'.$this->params->get ( 'menu_id' ).'" class="'.$class.'">';
	}
	
	function endMenu() {
		return '</ul>';
	}
}

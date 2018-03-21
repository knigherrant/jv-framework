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
require_once dirname ( dirname ( __FILE__ ) ) . '/menuitem.php';

class FlexMenuItemGroup extends FlexMenuItem {
	
	public function begin($s=1) {
		//JFactory::getDocument()->addStyleDeclaration( "#fx-item{$this->item->id}{ width: " . $this->getParam ( 'fxmenu_width' ) . ";}" );
                if ($this->getParam ( 'fxmenu_width' ) != '') $style = "style='width:".$this->getParam ( 'fxmenu_width' )."'";
		else $style='';
		if ($this->item->column && $this->item->column > 1) {
			if ($this->index == 1) {
				$html [] = $this->beginRow ( 'fx',$s );
			}
			$html [] = $this->beginCol ( $this->item->column, $this->getClass (),$s ,$style);
	
		} else
			$html [] = "<li $style id='fx-item{$this->item->id}' class='fx-item" . ($this->index) . " group " . $this->getClass () . "'>";
	
		return implode ( '', $html );
	}
	
	function getLink($flink = null) {
		if(isset($this->item->oldtype) && $this->item->oldtype == 'url'){
			return $this->item->link;
		}
		$flink = $this->item->link;
		
		$router = JSite::getRouter ();
		if ($router->getMode () == JROUTER_MODE_SEF) {
			$flink = 'index.php?Itemid=' . $this->item->id;
		} else {
			$flink .= '&Itemid=' . $this->item->id;
		}
		
		return parent::getLink ( $flink );
	}
	
	function getHtml() {

        $html = $class = $attributes = array ();
		if($this->item->params->get ( 'fxmenu_titlelink', 0 )){
			$attributes [] = "href='{$this->getLink()}'";
		}else{
			$attributes [] = "href='javascript:void(0)'";
		}
         $desc = $this->item->params->get('fxmenu_description');
        if($desc) $class[] = 'fx-desc';
        $level = 'level'.$this->item->level;
        if($this->item->level > 1) $class[] = 'levelsub';
        $class[] = $level;
        //$this->item->title = htmlspecialchars ( $this->item->title );
        if ($this->item->params->get ( 'menu-anchor_css', '' )) {
            $class [] = htmlspecialchars ( $this->item->params->get ('menu-anchor_css') );
        }

        if ($this->item->params->get ( 'menu_image' )  && $this->item->params->get ( 'menu_image' ) != -1){
            if($this->item->params->get ( 'menu_image_type', 'img' ) == 'img'){
                $class [] = "iconImage";
            }else{
                $class [] = "iconBackground";
            }
        }
        $attributes[] = 'data-hover="'.$this->item->title.'"';
        if($class){
            $attributes [] = 'class="group-title ' . implode(' ',$class) . '" ';
        }
		
		if ($this->item->params->get ( 'menu-anchor_title', '' )) {
			$attributes [] = 'title="' . htmlspecialchars ( $this->item->params->get ( 'menu-anchor_title' ) ) . '" ';
		}
		
		if ($this->item->browserNav == 1) {
			$attributes [] = 'target="_blank"';
		}
		
		if ($this->item->browserNav == 2) {
			$attributes [] = "onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;\"";
		}
		
		if($this->item->params->get ( 'fxmenu_title', 1 )){		
                         if($this->haschild) $html [] = '<span class="iconsubmenu"></span>';
			$html [] = "<a " . implode ( ' ', $attributes ) . ">";
			$html [] = $this->getTitle();
			$html [] = "</a>";

		}
		
		return implode ( '', $html );
	}
	
	public function getClass() {
		$class = array ();
		$class [] = 'level'.$this->level;
		$class [] = $this->getParam ( 'fxmenu_group' ) ? 'group' : '';
		$class [] = $this->haschild ? 'hasChild' : '';
		$class [] = $this->getParam ( 'fxmenu_column' ) > 1 ? 'cols' . $this->getParam ( 'fxmenu_column' ) : '';
		$class [] = 'fx' . $this->getParam ( 'fxmenu_submenu', 'submenu' );
		if($this->active){
			$class [] = 'active';
		}
	
		return implode ( ' ', $class );
	}
	
	public function beginSub() {
		$html = array ();
		if ($this->getParam ( 'fxmenu_column' ) > 1 ) {
			$html [] = '<div class="group-content clearfix">';
		}else {
			$html [] = '<ul class="group-content clearfix">';
		}
		
	
		return implode ( '', $html );
	}
	
	public function endSub() {
		$html = array ();	
		if ($this->getParam ( 'fxmenu_column' ) > 1 ) {
			$html [] = '</div>';
		}else{
			$html [] = '</ul>';
		}
		
		return implode ( '', $html );
	}
}
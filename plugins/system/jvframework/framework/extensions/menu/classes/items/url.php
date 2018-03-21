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

class FlexMenuItemUrl extends FlexMenuItem {
	
	function getLink($flink = null) {
		return $this->item->link;
	}
	
	function getHtml() {
		$html = $class = $attributes = array ();
		$attributes [] = "href='{$this->getLink()}'";
		
		//$this->item->title = htmlspecialchars ( $this->item->title );
        if ($this->item->params->get ( 'menu-anchor_css', '' )) {
            $class [] = htmlspecialchars ( $this->item->params->get ('menu-anchor_css') );
        }
        
        $desc = $this->item->params->get('fxmenu_description');
        if($desc) $class[] = 'fx-desc';
        
        $level = 'level'.$this->item->level;
        if($this->item->level > 1) $class[] = 'levelsub';
        $class[] = $level;
        if ($this->item->params->get ( 'menu_image' )  && $this->item->params->get ( 'menu_image' ) != -1){
            if($this->item->params->get ( 'menu_image_type', 'img' ) == 'img'){
                $class [] = "iconImage";
            }else{
                $class [] = "iconBackground";
            }
        }
        $attributes[] = 'data-hover="'.$this->item->title.'"';
        if($class){
            $attributes [] = 'class="' . implode(' ',$class) . '" ';
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


		

		if ($this->getParam ( 'fxmenu_submenu', 'submenu' ) == 'submenu' || $this->getParam ( 'fxmenu_group' )) {
			 if($this->haschild) $html [] = '<span class="iconsubmenu"></span>';
                        $html [] = "<a " . implode ( ' ', $attributes ) . ">";
			$html [] = $this->getTitle();		
			$html [] = "</a>";
		}
		
		return implode ( '', $html );
	}
}
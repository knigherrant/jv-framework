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
require_once dirname ( dirname ( __FILE__ ) ) .'/menuitem.php';

class FlexMenuItemSeparator extends FlexMenuItem {
	
	function getHtml() {
        $html = $class = $attributes = array ();
        if($this->getLink()) $attributes [] = "href='{$this->getLink()}'";

        //$this->item->title = htmlspecialchars ( $this->item->title );
        $class [] = "separator";
        $desc = $this->item->params->get('fxmenu_description');
        if($desc) $class[] = 'fx-desc';
        $level = 'level'.$this->item->level;
        if($this->item->level > 1) $class[] = 'levelsub';
        $class[] = $level;
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
            $attributes [] = 'class="' . implode(' ',$class) . '" ';
        }
		 if($this->haschild) $html [] = '<span class="iconsubmenu"></span>';
		$html [] = "<span " . implode ( ' ', $attributes ) . ">".$this->getTitle()."</span>";
		
		return implode ( '', $html );
	}
}

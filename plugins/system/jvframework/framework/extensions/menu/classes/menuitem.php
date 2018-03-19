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

abstract class FlexMenuItem {
	protected $index;
	protected $active;
	protected $level;
	protected $item;
	protected $haschild;
	protected static $col = 0;
	
	public function __construct($item) {
		$this->item = $item;
		$this->level = $item->level;
		$this->index = $item->index + 1;
		$this->haschild = $item->haschild;
		$this->active = @$item->active;
	}
	
	public function getLink($flink = null) {		
		$flink = $flink == null ? $this->item->link : $flink;
		
		if (strcasecmp ( substr ( $flink, 0, 4 ), 'http' ) && (strpos ( $flink, 'index.php?' ) !== false)) {
			$flink = JRoute::_ ( $flink, true, $this->item->params->get ( 'secure' ) );
		} else {
			$flink = JRoute::_ ( $flink );
		}
		return $flink;
	}
	
	public function getHtml() {
		return '';
	}	
	
	function getTitle() {		
		$html = array ();		
		$desc = $this->getParam ( 'fxmenu_description' );		
		
		if ($this->item->params->get ( 'menu_image' )  && $this->item->params->get ( 'menu_image' ) != -1) {
                $src = htmlspecialchars ( JURI::base(). $this->item->params->get ( 'menu_image' ) );
                if($this->item->params->get ( 'menu_image_type', 'img' ) == 'img'){
                    $icon = "<img alt='{$this->item->title}' class='icon' title='{$this->item->title}' src='{$src}' />";
                }else{
                    $info = @pathinfo($this->item->params->get ( 'menu_image' ));
                    $classname  = 'fxicon';
                    $classname .= isset($info['filename']) ? '-'. str_replace(' ', '_', $info['filename']) : '';
                    JFactory::getDocument()->addStyleDeclaration(".{$classname} { background: url('{$src}') no-repeat }");
                    $icon = '<span class="icon '.$classname.'"></span>';
                }

			if ($this->item->params->get ( 'menu_text', 1 )) {
				$html [] = $icon;
				//$html [] = $desc ? "<span class='hasDesc'>" : "<span>";
				$html [] = "<span class='fx-title'>{$this->item->title}</span>";
			} else {
				$html [] = $icon;
				//$html [] = $desc ? "<span class='hasDesc'>" : "<span>";
			}
				
		} else {
			//$html [] = $desc ? "<span class='hasDesc'>" : "<span>";
			$html [] = "<span class='fx-title'>{$this->item->title}</span>";
		}
		if($desc)
			$html [] = "<span class='fx-desc'>$desc</span>";
		
		//$html [] = '</span>';
		
		return implode ( '', $html );
	}		
	
	public function beginSub() {
		$html = array ();
		
		if ($this->getParam ( 'fxmenu_column' ) > 1 ) {
			$html [] = "<div class='fx-subitem fxcolumns  cols" . $this->getParam ( 'fxmenu_column' ) . " '>";
			$html [] = "<div class='insubitem  clearfix'>";
		} else {	
			$html [] = "<div class='fx-subitem fxcolumns  cols" . $this->getParam ( 'fxmenu_column' ) . " '>";
			$html [] = "<div class='insubitem clearfix'>";		
			$html [] = "<ul class='fxcolumn column1 clearfix'>";
		}

		//if ($this->getParam ( 'fxmenu_subwidth' ) != '') {
			//JFactory::getDocument()->addStyleDeclaration( " #fx-item{$this->item->id} > .fx-subitem{ width: " . $this->getParam ( 'fxmenu_subwidth' ) . ";}" );
		//}
		
		return implode ( '', $html );
	}
	
	public function endSub() {
		$html = array ();
		
		
		if ($this->getParam ( 'fxmenu_column' ) > 1 ) {
			$html [] = '</div>';
			$html [] = '</div>';
		} else{			
			$html [] = '</ul>';					
			$html [] = '</div>';
			$html [] = '</div>';			
		}	
			
		
		return implode ( '', $html );
	}
	
	public function getClass() {
		$class = array ();
		$class [] = 'level'.$this->level;
		$class [] = $this->haschild ? 'hasChild' : '';
		$class [] = $this->getParam ( 'fxmenu_column' ) > 1 ? 'cols' . $this->getParam ( 'fxmenu_column' ) : '';
		$class [] = 'fx' . $this->getParam ( 'fxmenu_submenu', 'submenu' );
		if($this->active){
			$class [] = 'active';	 
		}
		
		return implode ( ' ', $class );
	}
	
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
			$html [] = "<li $style id='fx-item{$this->item->id}' class='fx-item" . ($this->index) . " " . $this->getClass () . "'>";
		
		return implode ( '', $html );
	}
	
	public function end($s=1) {
		if ($this->item->column && $this->item->column > 1) {
			$html [] = $this->endCol ();
			//if($this->item->colbreak < 1) $this->item->colbreak = 1;
			//if ($this->index > 0 && $this->index % $this->item->colbreak == 0 && $this->index != $this->item->numchild) {
				//$html [] = $this->endRow ();
				//$html [] = $this->beginRow ( 'fx',$s );
			//}
			
			if ($this->index == $this->item->numchild) {
				$html [] = $this->endRow ();
			}
		
		} else
			$html [] = '</li>';
		
		return implode ( '', $html );
	}
	
	public function beginRow($class = '',$s=1) {
		self::$col ++;$first='';
		return "<ul class='clearfix'>";
	}
	
	public function endRow() {
		return "</ul>";
	}
	
	public function beginCol($numcol, $class = '',$s=1 , $style ='') {
                $first = '';
                if( ($s-1)%$this->item->column==0) $first=" first";
                if($this->item->type=='group') $class .= ' li-group-title';
                
		return "<li $style id='fx-item{$this->item->id}' class='{$class} fxcolumn column".$s."$first'>";
	}
	
	public function endCol() {
		return "</li>";
	}
	
	public function getParam($key, $default = '') {
		return $this->item->params->get ( $key, $default );
	}
}

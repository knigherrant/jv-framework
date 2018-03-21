<?php
/**
 # JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JVFrameworkHelperXTemplate extends JVFrameworkHelper {
	protected $_name = 'xtemplate';
	protected $_alias = array();
	protected $_unloads = array();
	public    $document = null;
	
	public function __construct() {
		parent::__construct();
		$this->document =& JFactory::getDocument();
	}
	
	public function render($name, $params = array()) {
		if(strripos($name, '.php')){
			return $this['template']->render(substr($name, 0, (strlen($name) - 4)), $params);
		}
		
		if(isset($this->_unloads[$name])){
			return false;
		}
		
		if(isset($this->_alias[$name])){
			$name = $this->_alias[$name];
		}
		
		if (strpos($name, '::')){
			list ( $type, $name ) = explode ( '::', $name );
		}
		if(!isset($type)){
			$type = 'layouts';
		}
				
		$path = $this['path']->findPath($name.'.xml', $type);
		$html = '';
		
		if(is_file($path)){
			$content = file_get_contents($path);	
			$content = $this['bbcode']->replace($content);
			
			$doc = phpQuery::newDocumentHTML($content);
			
			// Include layout
			foreach (pq('template') as $template){
				$temp = pq($template);
				$name = $temp->attr('name');
				
				$subcontent = $this->render($name);
				if($subcontent)
					$temp->before($subcontent);
				$temp->remove();
			}			
			$html = $doc->html();
		}
		
		return $html;
	}
	
	public function alias ($name, $alias){
		$this->_alias[$name] = $alias;
	}
	
	public function unLoad ($name){
		if(isset($this->_alias[$name])){
			$name = $this->_alias[$name];
		}
		$this->_unloads[$name] = 1;
	}	
}
?>
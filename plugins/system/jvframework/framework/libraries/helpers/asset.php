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

class JVFrameworkHelperAsset extends JVFrameworkHelper {
	protected $_name = 'asset';
	protected $_stylesheets = array ();
	protected $_styles = array ();
	protected $_scripts = array ();
	protected $_script = array ();
	protected $_readyScript = array ();
	protected $_css = null;
	protected $_js = null;
	public function addScript($url, $attribute = array()) {
		if ($url != '')
			$this->_scripts [$url] = $attribute;
	}
	public function addInlineScript($data) {
		$this->_script [] = $data;
	}
	public function addDomReadyScript($data) {
		$this->_readyScript [] = $data;
	}
	public function addStyle($url, $attribute = array()) {
		if ($url != '') $this->_stylesheets [$url] = $attribute;
	}
        
        public function addLess($file, $attribute = array(), $theme = 'theme::css') {
                if($this['option']->get('global.devmode') && $url = $this['path']->urlLess($file , $theme) ){
                    $this['lessc']->buildCss($url, $attribute);
                }else{
                    $this->addStyle($this['path']->url($theme . '/'.$file . '.css'), $attribute);
                }
	}
        
	public function addInlineStyle($data) {
		$this->_styles [] = $data;
	}
	public function reset($options = array('stylesheet', 'inlinestyle', 'script', 'inlinescript', 'css', 'js' )) {
		if (in_array ( 'stylesheet', $options ))
			$this->_stylesheets = array ();
		
		if (in_array ( 'inlinestyle', $options ))
			$this->_styles = array ();
		
		if (in_array ( 'script', $options )){
			$this->_scripts = array ();
		}		
		
		if (in_array ( 'inlinescript', $options ))
			$this->_script = array ();
		
		if (in_array ( 'css', $options ))
			$this->_css = array ();
		
		if (in_array ( 'js', $options ))
			$this->_js = array ();
	}
	
	public function Mootool($more = false) {
		JHtml::_ ( 'behavior.framework', $more );
	}
	
	public function hasjQuery() {
		$jquery = array ();
		
		$doc = JFactory::getDocument ();
		$head = $doc->getHeadData ();
		
		foreach ( $head ['scripts'] as $key => $val ) { 
			if (strpos ( $key, 'jquery' )) {
				$jquery [] = $key;
			}
		}
		
		return count ( $jquery );
	}
	public function hasMootool() {
		$jquery = array ();
		
		$doc = JFactory::getDocument ();
		$head = $doc->getHeadData ();
		
		foreach ( $head ['scripts'] as $key => $val ) {
			if (strpos ( $key, 'mootools' )) {
				$jquery [] = $key;
			}
		}
		
		return count ( $jquery );
	}
	public function reverse($options = array('stylesheet', 'script' )) {
		if (in_array ( 'stylesheet', $options ))
			$this->_stylesheets = array_reverse ( $this->_stylesheets );
		
		if (in_array ( 'script', $options ))
			$this->_scripts = array_reverse ( $this->_scripts );			
	}
	public function toHead($reverse = true) {
		// Support compression
		if ($reverse) $this ['asset']->reverse ();
		
		$scripts = $this ['asset']->get ( 'script' );
		$styles = $this ['asset']->get ( 'stylesheet' );
		$inlinescript = $this ['asset']->get ( 'inlinescript' );
		$inlinestyle = $this ['asset']->get ( 'inlinestyle' );
		
                
   
                foreach ( $styles as $key => $value ) {
                    if ($key) $this ['template']->document->addStyleSheet ( $key, 'text/css', null, $value );
                }
                foreach ( $scripts as $key => $value ) {
                    $this ['template']->document->addScript ( $key);
                }
                
		
		foreach ( $inlinescript as $key => $value ) {
			$this ['template']->document->addScriptDeclaration ( $value );
		}
		
		foreach ( $inlinestyle as $key => $value ) {
			$this ['template']->document->addStyleDeclaration ( $value );
		}
                
	}
	
	public function get($type) {
		switch ($type) {
			case 'stylesheet' :
				return $this->_stylesheets;
				break;
			case 'inlinestyle' :
				return array_unique($this->_styles);
				break;
			case 'inlinescript' :
				return array_unique($this->_script);
				break;
			case 'script' :
				return $this->_scripts;
				break;
			case 'readyscript' :
				return $this->_readyScript;
				break;
			case 'css' :
				return $this->_css;
			break;
			case 'js' :
				return $this->_js;
				break;
			default :
				break;
		}
	}	
	
	public function getAssetName($type = 'style') {
		if($type == 'script'){
			$doc  = JFactory::getDocument();
			
			$name = array();
			
			foreach ($doc->_scripts as $key => $val) {
				$name[] = $key;
			}
			
			foreach ($doc->_script as $script){
				//$name[] = $script;
			} 
			
			foreach ($this->get('script') as $key => $val){
				$name[] = $key;
			}
			
			foreach ($this->get('inlinescript') as $key => $val){
				$name[] = $val;
			}
			
			return md5(implode('',$name));
			
		}else{
			$doc  = JFactory::getDocument();
			
			$name = array();
				
			foreach ($doc->_styleSheets as $key => $val) {
				$name[] = $key;
			}
			
			foreach ($doc->_style as $style){
				$name[] = $style;
			}			
			
			foreach ($this->get('stylesheet') as $key => $val){
				$name[] = $key;
			}
				
			foreach ($this->get('inlinestyle') as $key => $val){
				$name[] = $val;
			}
			
			return md5(implode('',$name));			
		}		
	}
		
	public function join($items, $type = 'stylesheet') {
		$data = array ();
		foreach ( $items as $item => $attribute ) {	
			$site = true;
			
			if (preg_match ( '#http(s?):\/\/#', $item )) {				
				if (preg_match ( '/' . preg_quote ( JURI::root (), '/' ) . '/', $item )) {
					$item = str_replace ( JURI::root (), JPATH_ROOT . '/', $item );
				} else{
					$site = false;
				}							
				$content = @file_get_contents ( $item );
				
			} else {				
				$path = JPATH_ROOT . preg_replace ( "#" . JURI::root ( true ) . "#", '', $item, 1 );				
				if (is_file ( $path ))
					$content = file_get_contents ( $path );
			}
			
			if ($type == 'stylesheet') {
				if($site)
					$content = Minify_CSS_UriRewriter::rewrite ( $content, $this->getCssDir ( str_replace ( JPATH_ROOT, JURI::root(true), $item ) ) );
								
				if (isset ( $attribute ['media'] ) && $attribute ['media'] == 'print') {
					$content = '@media ' . $attribute ['media'] . '{' . $content . '}';
				}	

				$data [] = "\n";
			}
			
			if ($type == 'script') {
				$data [] = ';';
			}
					
			$data [] = $content;
		}
		
		
		return implode ( '', $data );
	}
	public function getCssDir($csslink) {
		$styleSheet = str_replace ( '/', DIRECTORY_SEPARATOR, $csslink );
		$filePath = JPATH_ROOT . substr ( $styleSheet, strlen ( JURI::base ( true ) ), strlen ( $styleSheet ) );
		
		if (file_exists ( $filePath )) {
			$pathInfo = pathinfo ( $filePath );
			$csslink = isset ( $pathInfo ['dirname'] ) ? $pathInfo ['dirname'] : $csslink;
		}
		
		return $csslink;
	}
	public function buildCss($selector, $attributes = array(), $customCss = '') {
		$css = array ();
		foreach ( $attributes as $key => $value ) {
			if ($value)
				array_push ( $css, "{$key}:{$value};" );
		}
		
		if ($css || $customCss) {
			array_unshift ( $css, '{' );
			array_unshift ( $css, $selector );
			array_push ( $css, $customCss );
			array_push ( $css, '}' );
		}
		return implode ( '', $css );
	}
	
	public function deferLoading($url) {
		$this->addInlineScript("window.deferLoad=function(func){if(window.addEventListener)window.addEventListener('load',func,false);else if(window.attachEvent)window.attachEvent('onload',func);else window.onload=func}");		
		$this->addInlineScript("window.deferLoad(function(){var element=document.createElement('script');element.src='{$url}';document.head.appendChild(element)})");
	}
}
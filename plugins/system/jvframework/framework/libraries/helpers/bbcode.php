<?php
/**
 # JV Framework
 # @version		2.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JVFrameworkHelperBBcode extends JVFrameworkHelper {
	protected $_name = 'bbcode';
	protected $replacements = array();
	
	public function setReplacement($replacements){		
		foreach ($replacements as $replacement){
			$this->replacements[$replacement->tag] = $replacement;
		}
	}
	
	public function replace($text) {
		// Match all tag
		$regex = '#\[\w*(\=)?(.*?)\](.*?)\[\/(\w*?)\]#is';
		preg_match_all($regex, $text, $matches, PREG_SET_ORDER);
		
		if(!$matches){
			return $text;
		}
		
		foreach ($matches as $matche) {
			list($replace, $tmp, $option, $param, $tag) = $matche;
			$class = 'BBcodePlugin'.$tag;
			if(class_exists($class)){
				$replacer = new $class();
				$text = $replacer->replace($text, $option, $param);
				
			}else{
				if(isset($this->replacements[$tag])){
					$replacer = $this->replacements[$tag];					
					$replacer->replacement = str_replace ( array ('{option}', '{param}' ), array ('$2', '$3' ), $replacer->replacement );
						
					$regex = '/\[' . $tag . '(\=)?(.*?)\](.*?)\[\/' . $tag . '\]/is';
					$text = preg_replace ( $regex, $replacer->replacement, $text );
				}
			}
		}
		
		return $text;
	}
}

class BBcodePluginOption {
 	protected $regex = '/\[option(\=)?(.*?)\](.*?)\[\/option\]/is';
	
	public function replace($text) {		
		$text = preg_replace_callback( $this->regex, array($this, '_replace'), $text );		
		return $text;
	}
	
	protected function _replace($match) {
		if(isset($match[3])){
			return JV::helper('option')->get($match[3]);
		}
		
		return '';
	}
}
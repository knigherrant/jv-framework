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

class JVFrameworkExtensionTypo extends JVFrameworkExtension{
	protected static $replacements = array();
	
	public function beforeRender(){
		if ($this ['option']->isRTL ()) {
			$this['asset']->addLess('assets/css/typo.rtl', array() ,'extensions::typo');
		}else{
			$this['asset']->addLess('assets/css/typo', array() ,'extensions::typo');
		}		
	}
	
	/**
	 * Framework Typography
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0) {
		$bbcode = JV::helper('bbcode');
		$bbcode->setReplacement($this->getReplacement ());

		$article->text = $bbcode->replace ( $article->text );	
	}	

	/**
	 * Framework Typography replacement
	 */
	protected function getReplacement() {
		if(!self::$replacements){
			$db = JFactory::getDbo ();
			$db->setQuery ( 'SELECT * FROM #__jv_typos WHERE published = 1' );
			self::$replacements = $db->loadObjectList ();
		}
		
		return self::$replacements;
		
	}
}
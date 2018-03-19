<?php
/**
 # JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JVFrameworkHelperCache extends JVFrameworkHelper {
	protected $_name = 'cache';
	protected $_cache;
	
	public function __construct() {
		parent::__construct ();
		
		$conf    = JFactory::getConfig();
		
		$options = array(
				'cachebase'     => JPATH_SITE . '/cache',
				'defaultgroup'  => 'jv',
				'lifetime'      => $conf->get('config.cachetime') * 60,
				// minutes to seconds
				'handler'       => $conf->get('cache_handler'),
				'caching'       => false,
				'language'      => $conf->get('config.language'),
				'storage'       => 'file'
		);
		
		$this->_cache  = JCache::getInstance('callback', $options);
		$this->_cache->setCaching($this['option']->get('global.cache'));
		
		return $this->_cache;
	}
	
	public function cache(){
		return $this->_cache;
	}
	
}
?>
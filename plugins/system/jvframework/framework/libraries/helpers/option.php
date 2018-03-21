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

JVFrameworkLoader::import ( 'joomlib.registry.registry' );

class JVFrameworkHelperOption extends JVFrameworkHelper {
	protected $_name = 'option';
	protected $_option;
	protected $_config;
	
	public function __construct() {
		parent::__construct();		

		// Template config
		$this->_option = JFactory::getApplication()->getTemplate(true)->params;
                
		$data = (string) $this->_option ;
		
		if(!$this->_option){
			$this->_option = new JRegistry();
		}
		
		// Joomla config
		$this->_config = JFactory::getConfig();
		
		if($data == '{}' || $data == ''){
			$param = JPATH_ROOT.'/templates/'.JFactory::getApplication()->getTemplate().'/params.json';
			if(is_file($param)){
				$data = file_get_contents(JPATH_ROOT.'/templates/'.JFactory::getApplication()->getTemplate().'/params.json');
				$this->_option->loadString($data);
			}
		}
		
		if(get_magic_quotes_gpc()){
            $this->_option->loadArray($this->transcribe($this->_option->toArray()));
         }
		
		// Merge Joomla Config
		$this->_option->merge($this->_config);				
	}
	
	public function getOptions() {
		return $this->_option;
	}
	
	public function getParam($key, $default = ''){
		return $this->get($key, $default);
	}
	
	public function get($key, $default = ''){		
		return $this->_option->get($key, $default);
	}
	
	public function set($key, $value){		
		return $this->_option->set($key, $value);
	}
	
	public function setConfig($key, $value){
		return $this->_config->set($key, $value);
	}
	
	public function def($key, $value){
		return $this->_option->def($key, $value);
	}
    
    public static $isRTL = null;
	/**
	 * isRTL
	 *
	 * @access public
	 * @return string Current user agent view site.
	 */
	public function isRTL() {
	    if(is_null(self::$isRTL)){
            self::$isRTL = $this->get('global.direction', false);
            $doc = JFactory::getDocument();
            if(self::$isRTL == 'auto') self::$isRTL = $doc->direction;
                if(self::$isRTL =='rtl'){
                    $this['template']->document->direction = 'rtl';
                    $this->set('template.body.class', $this->get('template.body.class') ? $this->get('template.body.class').' rtl' : 'rtl');
                }else{
                    self::$isRTL = false;
                    $this->set('template.body.class', $this->get('template.body.class') ? $this->get('template.body.class').' ltr' : 'ltr');
                }
            }
            return self::$isRTL;
	}
	
	public function transcribe($aList, $aIsTopLevel = true) {
		$gpcList = array();
		$isMagic = get_magic_quotes_gpc();
	   
		foreach ($aList as $key => $value) {
		    if (is_array($value)) {
		        $decodedKey = ($isMagic && !$aIsTopLevel)?stripslashes($key):$key;
		        $decodedValue = $this->transcribe($value, false);
		    } else {
		        $decodedKey = stripslashes($key);
		        $decodedValue = ($isMagic)?stripslashes($value):$value;
		    }
		    $gpcList[$decodedKey] = $decodedValue;
		}
		return $gpcList;
	} 
}
?>

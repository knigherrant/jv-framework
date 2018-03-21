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
		
if (! class_exists ( 'Mobile_Detect' )) {
	require_once dirname ( dirname ( __FILE__ ) ) . '/classes/devices.php';
}

class JVFrameworkHelperBrowser extends JVFrameworkHelper {
	protected $_name = 'browser';
	protected $_browser;
	
	public function __construct() {
		parent::__construct ();
		$this->_browser = new Mobile_Detect();
	}
	
	public function isiPhone() {
		return $this->_browser->isiPhone();
	}
        
        public function isAndroidOS() {
		return $this->_browser->isAndroidOS();
	}
	
	public function isMobile() {
		return $this->_browser->isMobile();
	}
	
	public function isTablet() {		
		return 	$this->_browser->isTablet();
	}
	
	public function isRobot() {
		//return $this->_browser->isRobot();
	}
	
	public function getBrowser() {
		return $this->_browser->getBrowser();
	}
}
?>
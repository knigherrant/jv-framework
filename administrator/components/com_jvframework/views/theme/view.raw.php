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
jimport ( 'joomla.application.component.view' );
class JVFrameworkManagerViewTheme extends JViewLegacy {
	public function display($tpl = null) {
		$this->item = $this->get ( 'item' );
		
		include_once dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/libraries/elfinder-2.0-rc1/php/elFinderConnector.class.php';
		include_once dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/libraries/elfinder-2.0-rc1/php/elFinder.class.php';
		include_once dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/libraries/elfinder-2.0-rc1/php/elFinderVolumeDriver.class.php';
		include_once dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/libraries/elfinder-2.0-rc1/php/elFinderVolumeLocalFileSystem.class.php';
		
		$opts = array (
				// 'debug' => true,
				'roots' => array (
						array (
								'driver' => 'LocalFileSystem',
								'path' => JPATH_ROOT . "/templates/" . $this->item->element 
						),
						'URL' => JV::_ ( 'path.toURL', JPATH_ROOT . "/templates/" . $this->item->theme ) 
				) 
		);
				
		// run elFinder
		$connector = new elFinderConnector ( new elFinder ( $opts ) );
		$connector->run ();
	}
}
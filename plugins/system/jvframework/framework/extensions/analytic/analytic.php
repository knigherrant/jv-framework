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

class JVFrameworkExtensionAnalytic extends JVFrameworkExtension{
	
	public function beforeRender(){
		$this['position']->register( 'analytic', 'analytic');
	}
	
	public function html($options = array()){
		return $this['template']->render('extensions::analytic/html');
	}	
}

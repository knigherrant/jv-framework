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

class JVFrameworkExtensionCopyright extends JVFrameworkExtension{
	
	public function beforeRender(){

		if(	$this['option']->get('global.copyright.enable') || 
			$this['option']->get('global.copyright.joomlacopyright') || 
			$this['option']->get('global.copyright.fwcopyright')){
			$this['position']->register( 'copyright', 'footer');
		}
	}
	
	public function html($options = array()) {
		return $this['template']->render('extensions::copyright/html');
	}
}
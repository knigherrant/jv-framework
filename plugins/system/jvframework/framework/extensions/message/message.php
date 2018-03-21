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

class JVFrameworkExtensionMessage extends JVFrameworkExtension{
	
	public function beforeRender(){
		$this['position']->register('message', $this['option']->get('extension.message.position', 'message'));	
	}
	
	public function html(){
		return '<jdoc:include type="message" />';
	} 
}


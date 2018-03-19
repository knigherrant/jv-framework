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

class JVFrameworkHelperModule extends JVFrameworkHelper {
	protected $_name = 'module';
	protected static $modules = array();
	
	public function render(&$module, &$options = array()) {
     
		$style = isset($options['style']) ? $options['style'] : 'jvxhtml';
		if($style == 'none'){
			$style = 'raw';
		}
		
		if(!isset($module->parameter)){
			$module->parameter = new JRegistry($module->params);
		}
		$params = $module->parameter;

		return $this['template']->render("module", compact('module', 'style', 'params', 'options'));		
	}	
}
?>
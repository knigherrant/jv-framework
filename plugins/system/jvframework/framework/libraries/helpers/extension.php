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
JVFrameworkLoader::import ( 'helpers.template' );

class JVFrameworkHelperExtension extends JVFrameworkHelperTemplate {
	protected 			$_name = 'extension';
	protected static $extensions = null;
	
	public function render($name, $options = array (),$k = null) {
		if(isset($options['content'])){
			return $options['content'];
		}
		
		$options['extension'] = $name;
		$html =  $this['cache']->cache()->call(array($this ['event'], 'fireEvent'), 'html.'.$name, $options);		
		
		return $html[0];
	}
	
	public function init(){
		$extensions = $this->getExtensionList();
		$lang = JFactory::getLanguage();
		
		foreach ($extensions as $extension => $xml){
			$class = 'JVFrameworkExtension'.$extension;
			
			if(!class_exists($class)){
				$path = $this['path']->findPath($extension.'/'.$extension.'.php', 'extensions');
			
				if(is_file($path)){
					$lang->load("ext_{$extension}", JPATH_ROOT);
					require_once $path;
				}
			}
			
			if(class_exists($class)){				
				$this['event']->addObserver( new $class, $extension);
			}
		}
	}

	public function getExtensionList() {
		if(!self::$extensions){
			self::$extensions = array();
			jimport('joomla.filesystem.folder');	
			jimport('joomla.form.form');	
			$paths = $this['path']->getPath('extensions');			
			
			foreach ($paths as $path){
				if(is_dir($path)){
					$folders = JFolder::folders($path);
					if(is_array($folders)){
						foreach ($folders as $folder) {				
							JForm::addFieldPath("{$path}/{$folder}/fields");
							self::$extensions[$folder] = $this['path']->findPath($folder.'/config.xml', 'extensions');
						}
					}
				}
				
			}
		}
	
		return self::$extensions;
	}
}
?>
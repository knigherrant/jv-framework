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

class JVFrameworkExtensionMobile extends JVFrameworkExtension{

	public function beforeRender(){
		$head = JFactory::getDocument();
		if(!$this['browser']->isMobile() || $this['browser']->isTablet()) return;
		// Theme path
		$basePath  = current($this['path']->getPath('basetheme'));
		$themePath = JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate();
		
		if($this['option']->get('global.mobile.allmobile.enable') == 1){
			// Mobile path
			$this['path']->addPath($basePath.'/layouts/mobiles', 'theme');			
			$this['path']->addPath($themePath.'/layouts/mobiles', 'theme');
			$this['path']->addPath($basePath.'/layouts/mobiles', 'layouts');
			$this['path']->addPath($themePath.'/layouts/mobiles', 'layouts');
			$this['path']->addPath($basePath.'/layouts/mobiles/html', 'override');
			$this['path']->addPath($themePath.'/layouts/mobiles/html', 'override');
   
                        if($this['browser']->isiPhone()){
                                // Mobile path
                                $this['path']->addPath($themePath.'/layouts/mobiles/iphone', 'theme');
                                $this['path']->addPath($themePath.'/layouts/mobiles/iphone', 'layouts');
                                $this['path']->addPath($themePath.'/layouts/mobiles/iphone/html', 'override');
                        }
			
			

                        if($this['browser']->isAndroidOS()){
                                // Mobile path
                                $this['path']->addPath($themePath.'/layouts/mobiles/android', 'theme');
                                $this['path']->addPath($themePath.'/layouts/mobiles/android', 'layouts');
                                $this['path']->addPath($themePath.'/layouts/mobiles/android/html', 'override');
                        }
			
		}
		
		// Position Alias
		$positions = $this['option']->get('global.mobile.allmobile.positions');		
		if(is_object($positions)){
			foreach ($positions as $position => $option) {
				if($option->alias){
					$this['position']->alias($position, $option->alias);
					$this['option']->set('position.'.$option->alias, $option);
				}else{
					$this['option']->set('position.'.$position, $option);
				}				
			}			
		}		
		
	}
}
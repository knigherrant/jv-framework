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

class JVFrameworkExtensionLogo extends JVFrameworkExtension{
		
	public function beforeRender(){		
		$params = $this['option'];		
		$this['position']->register('logo', $params->get('extension.logo.position', 'logo'));
	}
	
	public function html($options){
            
		ob_start();
		if ($this['option']->get('extension.logo.type', 'text') == 'text'):?> 
				<a id="logo" href="<?php echo JURI::base(true); ?>" title="<?php echo $this['option']->get('sitename'); ?>">
					<span class="text"><?php echo $this['option']->get('extension.logo.text', $this['option']->get('sitename')); ?></span>
					<span class="slogan"><?php echo $this['option']->get('extension.logo.slogan'); ?></span>
				</a>
		<?php else : ?>
				<a id="logo" class="logo-<?php if($this['option']->get('extension.logo.image')) { echo 'image';} else echo 'bg';?>"  href="<?php echo JURI::base(true); ?>" title="<?php echo $this['option']->get('sitename'); ?>">				
				<?php if($this['option']->get('extension.logo.image')) :?>
					<img src="<?php echo JRoute::_($this['option']->get('extension.logo.image')); ?>" alt="<?php echo $this['option']->get('sitename'); ?>"/>
				<?php endif;?>
				</a>
		<?php
		endif;
		
		return ob_get_clean();
	
	}
	
}


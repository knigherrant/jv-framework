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

class JVFrameworkExtensionFontsizer extends JVFrameworkExtension{

	public function beforeRender(){
		
		if($this['option']->get('extension.fontsizer.enable')){
			$this['asset']->addScript($this['path']->url('extensions::fontsizer/assets/js/fonsizer.js'));
			$this['position']->register('fontsizer', $this['option']->get('extension.fontsizer.position', 'top'));
			$this['asset']->addInlineScript( "
				jQuery(document).ready(function(){
					jvFontsizer.init(".$this['option']->get('extension.fontsizer.zoomlevel', '3').", '".$this['option']->get('extension.fontsizer.selector', 'body')."');
				});	
			");
		}
	}
	
	public function html($options = array()) {
		ob_start();?>
			<div class="font-size">
           		<a title="<?php echo JText::_('JVFRAMEWORK_EXTENSION_FONTSIZE_TITLE_RESET_SIZE');?>" href="javascript:jvFontsizer.resetLetter()" class="reset"></a>
                <a title="<?php echo JText::_('JVFRAMEWORK_EXTENSION_FONTSIZE_TITLE_INCREASE_SIZE');?>" href="javascript:jvFontsizer.to(1)" class="bigger">A</a>
                <a title="<?php echo JText::_('JVFRAMEWORK_EXTENSION_FONTSIZE_TITLE_DECREASE_SIZE');?>" href="javascript:jvFontsizer.to(-1)" class="smaller">a</a>
			</div>
		<?php 
		return ob_get_clean();		
	}
}
?>
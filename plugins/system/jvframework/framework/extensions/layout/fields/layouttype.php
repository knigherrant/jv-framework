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

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */

class JFormFieldLayouttype extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Layouttype';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 * @since   11.1
	 */
	protected function getInput()
	{
		JHtml::_('jquery.framework');
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration("
			jQuery(document).ready(function(){
				value = jQuery('#{$this->id}').val();
				jQuery('img[alt='+value+']').css('border','2px solid #8fd110');
				jQuery('.imagelayouttype').click(function(){
					jQuery('#{$this->id}').val(jQuery(this).attr('alt'));
					jQuery('.imagelayouttype').css('border','none');
					jQuery(this).css('border','2px solid #8fd110');
				});
				
			});
		");
				
		ob_start();
		?>		
			<img class="imagelayouttype hasTip" title="Sidebar A - Content" src="<?php echo JV::_('path.url', 'extensions::layout/assets/images/layout4.png');?>" alt="sb-c"/>
			<img class="imagelayouttype hasTip" title="Content - Sidebar B" src="<?php echo JV::_('path.url', 'extensions::layout/assets/images/layout5.png');?>" alt="c-sb"/>
			<img class="imagelayouttype hasTip" title="Sidebar A - Content - Sidebar B" src="<?php echo JV::_('path.url', 'extensions::layout/assets/images/layout1.png');?>" alt="sb-c-sb"/>
			<img class="imagelayouttype hasTip" title="Sidebar A- Sidebar B - Content" src="<?php echo JV::_('path.url', 'extensions::layout/assets/images/layout2.png');?>" alt="sb-sb-c"/>
			<img class="imagelayouttype hasTip" title="Content - Sidebar A- Sidebar B" src="<?php echo JV::_('path.url', 'extensions::layout/assets/images/layout3.png');?>" alt="c-sb-sb"/>
			<input type="hidden" name="<?php echo $this->name;?>" id="<?php echo $this->id;?>" value="<?php echo $this->value;?>"/>
		<?php 
		$html = ob_get_clean();
		return $html;		
	}
}



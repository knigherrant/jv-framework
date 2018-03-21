<?php
/**
 * @package     Joomla.Platform
* @subpackage  Form
*
* @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE
*/

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a one line text field.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @link        http://www.w3.org/TR/html-markup/input.text.html#input.text
 * @since       11.1
 */
class JFormFieldBackground extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 *
	 * @since  11.1
	 */
	protected $type = 'background';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{	
		$model = JModelLegacy::getInstance('Style', 'JVFrameworkManagerModel');
		$item  = $model->getItem();
		$template = JPATH_ROOT . '/templates/' . $item->template;

		$class = 'class="bg hidden"';
		$path  = JV::helper('path');
		$path->addPath($template, 'theme');
		
		$files = JFolder::files($template . '/images/background/');
		//$options = array ();
		$html='';
		if (isset ( $files ) && count ( $files )) {
			$i = 0;
			foreach ( $files as $val ) {
				$cls = '';
                                if($val == 'custom') continue;
				if ($val == $this->value || ($this->value == '' && $i == 0)) {
					$cls = 'bgactive';
				}
				$i ++;
				
				$html .='<span title="'.str_replace('_', ' ', $val).'" class="bg-list ' . $cls . '" style="background: url(\'' . $path->url("theme::images/background/{$val}") . '\')  center">'.$val.'</span>';
			}	
		} else {
			$files = JFolder::folders($template . '/images/background/');
				
			if (isset ( $files ) && count ( $files )) {
		
				foreach ( $files as $i => $option ) {
                                        if($val == 'custom') continue;
					$val = $val = str_replace ( '.css', '', $option );
						
					$cls = '';
					if ($val == $this->value || ($this->value == '' && $i == 0)) {
						$cls = 'bgactive';
					}
					
					$html .='<span title="'.str_replace('_', ' ', $val).'" class="bg-list ' . $cls . '" style="background: url(\'' . $path->url("theme::images/background/{$val}") . '\')  center">'.$val.'</span>';
				}
			}
		}

		JFactory::getDocument ()->addStyleDeclaration ( "
			.tab-content .fields label.radiobtn { width: 50px; height: 50px; height: auto; float: left; clear: none}
			.tab-content .fields span.bg-list {padding:10px; border: 2px solid #CCCCCC; width: 70px; height: 70px; float: left; text-indent: -999em; font-size: 0; color: #fff; margin-right: 10px; }
			.tab-content .fields span.bgactive {  border-color:#62C022; }
		" );
		
		JFactory::getDocument ()->addScriptDeclaration ( "
			jQuery(function(){
				jQuery('span.bg-list').each(function(){
					jQuery(this).click(function(){
                                            jQuery('span.bg-list').removeClass('bgactive');
                                            jQuery(this).addClass('bgactive');
                                            jQuery('#{$this->id}').val(jQuery(this).text());
                                        })		
				});		
			});
		" );
		
		$html .= '<input type="hidden" name="'.$this->name.'" id="'.$this->id.'" value="'.$this->value.'"/>';
		
		return $html;
		
	}
}

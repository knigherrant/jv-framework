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
class JFormFieldAssign extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 *
	 * @since  11.1
	 */
	protected $type = 'Assign';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		$item = JModelLegacy::getInstance('Style', 'JVFrameworkManagerModel');
		$this->item = $item->getItem();
		
		// Initiasile related data.
		require_once JPATH_ADMINISTRATOR.'/components/com_menus/helpers/menus.php';
		$menuTypes = MenusHelper::getMenuLinks();
		$user = JFactory::getUser();
		if($this->item->home) return 'You cannot assign for default template! ';
		ob_start();?>
		
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_TEMPLATES_MENUS_ASSIGNMENT'); ?></legend>
				
				<button type="button" class="jform-rightbtn" onclick="$$('.chk-menulink').each(function(el) { el.checked = !el.checked; });">
					<?php echo JText::_('JGLOBAL_SELECTION_INVERT'); ?>
				</button>
				<div class="clr"></div>
				<div id="menu-assignment">
				
				<?php echo JHtml::_('tabs.start', 'module-menu-assignment-tabs', array('useCookie'=>1));?>				
				<?php foreach ($menuTypes as &$type) :
						echo JHtml::_('tabs.panel', $type->title ? $type->title : $type->menutype, $type->menutype.'-details');
				?>
				
					<dl class="menu-links">
						<h3><?php echo $type->title ? $type->title : $type->menutype; ?></h3>
						<?php foreach ($type->links as $link) :?>
						<dt class="menu-link">
							<input type="checkbox" name="<?php echo $this->name; ?>" 
							value="<?php echo (int) $link->value;?>" 
							id="link<?php echo (int) $link->value;?>"
							<?php if ($link->template_style_id == $this->item->id):?> 
							checked="checked"<?php endif;?>
							<?php if ($link->checked_out && $link->checked_out != $user->id):?> 
							disabled="disabled"<?php else:?> 
							class="chk-menulink "<?php endif;?> />
							<label for="link<?php echo (int) $link->value;?>" >
								<?php echo $link->text; ?>
							</label>
						</dt>
						<?php endforeach; ?>
					</dl>
				<?php endforeach; ?>
				<?php echo JHtml::_('tabs.end');?>
				</div>

		</fieldset>
		
		<?php 
		return ob_get_clean();
	}
	
	protected function getLabel(){
		return '';
	}
	
}

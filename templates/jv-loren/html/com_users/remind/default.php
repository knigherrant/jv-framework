<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<div class="remind <?php echo $this->pageclass_sfx?>">
	<div class="remind-inner">
		<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=remind.remind'); ?>" method="post" class="form-validate">
			<div class="form-group">
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
							<?php echo $field->label; ?><?php echo $field->input; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
			</div>
			<p><small><?php echo JText::_($fieldset->label); ?></small></p>
			<button type="submit" class="btn btn-darker btn-sm btn-block text-normal" ><?php echo JText::_('JSUBMIT'); ?></button>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
</div>

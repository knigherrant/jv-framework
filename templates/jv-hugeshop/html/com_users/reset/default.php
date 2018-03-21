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
<div class="reset <?php echo $this->pageclass_sfx?>">
	<div class="reset-inner">
		<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>" method="post" class="form-validate">
			<div class="form-group">
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
					<?php echo $field->label; ?><?php echo str_replace('aria-required', 'data-aria-required', $field->input); ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
			</div>
			<div class="clearfix">
				<p><small><?php echo JText::_($fieldset->label); ?></small></p>
				<button type="submit" class="btn btn-dark btn-outline btn-radius btn-block"><?php echo JText::_('JSUBMIT'); ?></button>
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</form>
	</div>
</div>

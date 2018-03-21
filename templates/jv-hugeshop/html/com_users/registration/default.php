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
JHtml::_('formbehavior.chosen', 'select');
$document 	= JFactory::getDocument();
$style = $this->pageclass_sfx;
if ($style) {
	$js = '';

	if ($style == 'register-2' || $style == 'register-3' || $style == 'register-4' || $style == 'register-6') {
		$js = '
			var label = $(".registration-inner label");
				label.each(function(){
					var el = $(this),
						placeholder = el.html();
						placeholder = placeholder.replace("	", "");
						placeholder = placeholder.replace("<span class=\"star\">&nbsp;*</span>", "");
						el.next().attr("placeholder", placeholder);
				});
		';
	}
	if ($style == 'register-6') {
		$js .= '
			var button = $(".register-6 .btn-primary");
				button.text("'.JText::_('TPL_SIGNUP').'");
		';
	}
	$document->addScriptDeclaration('
		(function($){
			$(function(){
				'.$js.'		
			});
		})(jQuery);	
	');
}
?>
<div class="registration <?php echo $this->pageclass_sfx?>">
	<div class="registration-inner">
		<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate">
			<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
				<?php $fields = $this->form->getFieldset($fieldset->name);?>
				<?php if (count($fields)):?>
						<?php foreach ($fields as $field) :// Iterate through the fields in the set and display them.?>

							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
								<?php echo $field->input;?>
							<?php else:?>
								<?php if ($field->type != 'Spacer'): ?>
								<div class="form-group <?php echo $field->fieldname;?>">
									<?php echo $field->label; ?>
									<?php //echo $field->input;?>
									<?php echo str_replace('aria-required', 'data-aria-required', $field->input); ?>
								</div>
								<?php endif;?>
							<?php endif;?>
						<?php endforeach;?>
				<?php endif;?>
			<?php endforeach;?>
			<div class="form-group">
				<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
					<?php $fields = $this->form->getFieldset($fieldset->name);?>
					<?php if (count($fields)):?>
						<?php foreach ($fields as $field) :// Iterate through the fields in the set and display them.?>
							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php else:?>
								<?php if ($field->type == 'Spacer'): ?>
									<?php echo $field->label; ?>
								<?php endif;?>
							<?php endif;?>
						<?php endforeach;?>
					<?php endif;?>
				<?php endforeach;?>
			</div>
			<button type="submit" class="btn btn-dark btn-outline btn-radius btn-block"><?php echo JText::_('TPL_CREATE_ACCOUNT');?></button>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<?php echo JHtml::_('form.token');?>
		</form>
	</div>
</div>

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
$document 	= JFactory::getDocument();
if (($this->params->get('login_image') != '')) {
	$document->addScriptDeclaration('
		(function($){
			$(function(){
				var wrap = $("#block-main");
			   	if (wrap.length > 0) {
			   		wrap.attr("style", "background-image: url('.JURI::base(true).'/'.$this->escape($this->params->get('login_image')).')");
			   	}
		});
		})(jQuery);
	');
}
?>
<div class="login<?php echo $this->pageclass_sfx; echo ($this->escape($this->params->get('login_image')) !='')?' background':''; ?>">
	<div class="login-inner">
		<?php if ($this->params->get('logindescription_show') == 1) : ?>
			<div class="login-desc"><?php echo $this->params->get('login_description'); ?></div>
		<?php endif; ?>

		<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
			<?php foreach ($this->form->getFieldset('credentials') as $field) : ?>
				<?php if (!$field->hidden) : ?>
					<div class="form-group">
						<div class="control-label">
							<?php echo $field->label; ?>
						</div>
						<div>
							<?php // echo $field->input; ?>
							<?php echo str_replace('aria-required', 'data-aria-required', $field->input); ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
				
			<div class="form-group clearfix">
					<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
					<div class="ui checkbox pull-right pt-5">
						<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"/><label for="remember" class="text-headings"><?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME') ?></label>
					</div>
					<?php endif; ?>
					<button type="submit" class="btn btn-dark btn-radius btn-outline pull-left"><?php echo JText::_('JLOGIN'); ?></button>
			</div>
			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
		<ul class="list-unstyled">
			<li >
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
				<?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
			</li>
			<li >
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
				<?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
			</li>
			<?php
			$usersConfig = JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) : ?>
			<li >
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
					<?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
			</li>
			<?php endif; ?>
		</ul>
	</div>
</div>


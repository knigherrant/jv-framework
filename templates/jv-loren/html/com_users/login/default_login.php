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
?>
<div class="login-page" style="background-image: url(<?php echo JURI::base(true).'/'.$this->escape($this->params->get('login_image')); ?>)">
	<div class="login-inner">
		<div class="row">
			<div class="col-md-6 login-right">
				<div class="login-content">
					<h4 class="text-uppercase mt-0 text-bold text-center"><?php echo JText::_('TPL_LOGIN') ?></h4>
					<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
						<?php foreach ($this->form->getFieldset('credentials') as $field) : ?>
							<?php if (!$field->hidden) : ?>
								<div class="form-group">
									<div class="control-label">
										<?php echo $field->label; ?>
									</div>
									<div>
										<?php echo $field->input; ?>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>						
						<div class="form-group clearfix">
								
								<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
								<div class="ui checkbox pull-right pt-10">
									<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"/><label for="remember"><?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME') ?></label>
								</div>
								<?php endif; ?>
								<button type="submit" class="btn btn-darker btn-xs pull-left text-normal"><?php echo JText::_('JLOGIN'); ?></button>
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
					</ul>
				</div>
			</div>
			<div class="col-md-6 login-left">
				<?php if ($this->params->get('logindescription_show') == 1) : ?>
					<div class="login-desc"><?php echo $this->params->get('login_description'); ?></div>
				<?php endif; ?>
				<?php
					$usersConfig = JComponentHelper::getParams('com_users');
					if ($usersConfig->get('allowUserRegistration')) : ?>
					<div class="divtable">
						<div class="divtablecell">
							<h4 class="text-uppercase mt-0 text-bold mb-30"><?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></h4>
							<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-sm btn-outline btn-white"><?php echo JText::_('TPL_JOIN_US'); ?></a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>


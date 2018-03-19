<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_users/helpers/route.php';

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>
<form action="<?php echo JRoute::_(htmlspecialchars(JUri::getInstance()->toString()), true, $params->get('usesecure')); ?>" method="post" id="login-form" class="<?php echo ($params->get('moduleclass_sfx'))?$params->get('moduleclass_sfx'):''; ?>">
<?php if ($params->get('pretext')) : ?>
            <div class="pretext">
              <p><?php echo $params->get('pretext'); ?></p>
            </div>
          <?php endif; ?>
          <div class="userdata">
            <div id="form-login-username" class="form-group">
                <?php if (!$params->get('usetext')) : ?>
                  <div class="ico">
                      <span class="fa fa-user hasTooltip" title="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>"></span>
                    <input id="modlgn-username" type="text" name="username" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
                  </div>
                <?php else: ?>
                  <label for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
                  <input id="modlgn-username" type="text" name="username" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
                <?php endif; ?>
            </div>
            <!-- End form-group -->
            <div id="form-login-password" class="form-group">
                <?php if (!$params->get('usetext')) : ?>
                  <div class="ico">
                      <span class="fa fa-lock hasTooltip" title="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"></span>
                    <input id="modlgn-passwd" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
                  </div>
                <?php else: ?>
                  <label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
                  <input id="modlgn-passwd" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
                <?php endif; ?>
            </div>
            <!-- End form-group -->
            <?php if (count($twofactormethods) > 1): ?>
            <div id="form-login-secretkey" class="form-group">
                <?php if (!$params->get('usetext')) : ?>
                    <span class="fa fa-star hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>"></span>
                    <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
                <?php else: ?>
                  <label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
                  <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div id="form-login-submit" class="form-group clearfix">
            	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
	            <div id="form-login-remember" class="form-group checkbox mt-0">
	              <label for="modlgn-remember"> <input id="modlgn-remember" type="checkbox" name="remember" value="yes"/> <?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
	            </div>
	            <?php endif; ?>
	            <button type="submit" tabindex="0" name="Submit" class="btn btn-darker btn-sm btn-block"><?php echo JText::_('JLOGIN') ?></button>
            </div>
		<?php
			$usersConfig = JComponentHelper::getParams('com_users'); ?>
			<ul class="list-unstyled">
			<?php if ($usersConfig->get('allowUserRegistration')) : ?>
				<li>
					<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration&Itemid=' . UsersHelperRoute::getRegistrationRoute()); ?>">
					<?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
				</li>
			<?php endif; ?>
				<li>
					<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind&Itemid=' . UsersHelperRoute::getRemindRoute()); ?>">
					<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
				</li>
				<li>
					<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
					<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
				</li>
			</ul>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<?php if ($params->get('posttext')) : ?>
		<div class="posttext">
			<p><?php echo $params->get('posttext'); ?></p>
		</div>
	<?php endif; ?>
</form>

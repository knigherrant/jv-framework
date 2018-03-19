<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');
?>

<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="login-form form-inline">
  <?php if ($params->get('pretext')) : ?>
  <div class="pretext">
    <p><?php echo $params->get('pretext'); ?></p>
  </div>
  <?php endif; ?>
  <div class="userdata">
    <?php if (!$params->get('usetext')) : ?>

    <label>
      <input id="modlgn-username" type="text" name="username"  tabindex="0" size="25" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
	</label>
    <?php else: ?>
    <label for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
    <input id="modlgn-username" type="text" name="username"  tabindex="0" size="25" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
    <?php endif; ?>
    <?php if (!$params->get('usetext')) : ?>
    <label> 
      <input id="modlgn-passwd" type="password" name="password"  tabindex="0" size="25" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
	</label>
    <?php else: ?>
    <label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
    <input id="modlgn-passwd" type="password" name="password" class="input-small" tabindex="0" size="25" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
    <?php endif; ?>
    <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>

      <label class="control-label"> 
      
	  <input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/> 
	  <?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?>
      
      </label>

    <?php endif; ?>
    <div id="form-login-submit" class="control-group">
      <button type="submit" tabindex="0" name="Submit" ><?php echo JText::_('JLOGIN') ?></button>
    </div>
    <?php
			$usersConfig = JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) : ?>
    <ul class="unstyled">
      <li> <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"> <?php echo JText::_('MOD_LOGIN_REGISTER'); ?> </a> </li>
      <li> <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"> <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a> </li>
      <li> <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a> </li>
    </ul>
    <?php endif; ?>
    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="user.login" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHtml::_('form.token'); ?> </div>
  <?php if ($params->get('posttext')) : ?>
  <div class="posttext">
    <p><?php echo $params->get('posttext'); ?></p>
  </div>
  <?php endif; ?>
</form>

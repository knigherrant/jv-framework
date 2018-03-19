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
$usersConfig = JComponentHelper::getParams('com_users');
?>

<button class="btn btn-login btn-dark" data-toggle="modal" data-target="#login-modal-<?php echo $module->id; ?>"><i class="fa fa-user"></i><span> <?php echo JText::_('JLOGIN') ?></span></button>

<div class="modal fade modal-login" id="login-modal-<?php echo $module->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="form">
          <?php if ($params->get('pretext')) : ?>
            <div class="pretext">
              <?php echo $params->get('pretext'); ?>
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
                  <input id="modlgn-passwd" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
                <?php endif; ?>
            </div>
            <!-- End form-group -->
            <?php if (count($twofactormethods) > 1): ?>
            <div id="form-login-secretkey" class="form-group">
                <?php if (!$params->get('usetext')) : ?>
                  <div class="forom-group">
                      <span class="fa fa-star hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>"></span>
                    <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
                    <span class="input-group-btn">
                      <span class="btn btn-default width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
                        <i class="fa fa-question"></i>
                      </span>
                    </span>
                </div>
                <?php else: ?>
                  <label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
                  <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
                  <span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
                    <span class="icon-help"></span>
                  </span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div id="form-login-submit" class="form-group clearfix mt-20">
              <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                <div class="form-remember">                  
                  <div id="form-login-remember" class="ui checkbox pull-right pt-10">
                    <input id="modlgn-remember" type="checkbox" name="remember" value="yes"/> <label for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
                  </div>
                </div>
              <?php endif; ?>
              <button type="submit" tabindex="0" name="Submit" class="btn btn-primary"><?php echo JText::_('JLOGIN') ?></button>
            </div>
            <?php
               ?>
              <ul class="list-unstyled mb-0">
                <li>
                  <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind&Itemid=' . UsersHelperRoute::getRemindRoute()); ?>">
                  <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
                </li>
                <li>
                  <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
                  <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
                </li>
                <?php if ($usersConfig->get('allowUserRegistration')) : ?>
                  <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration&Itemid=' . UsersHelperRoute::getRegistrationRoute()); ?>">
                    <?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
                  </li>
                <?php endif; ?>
              </ul>
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo JHtml::_('form.token'); ?>
          </div>
          <?php if ($params->get('posttext')) : ?>
            <div class="posttext">
              <?php echo $params->get('posttext'); ?>
            </div>
          <?php endif; ?>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


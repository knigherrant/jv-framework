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
?>
<!-- Split button -->
<div class="logout-form dropdown inline-block">
  <button type="button" class="btn btn-logout dropdown-toggle btn-default" data-toggle="dropdown">
  	<i class="gs-man-people-streamline-user ico-mobile"></i>
  	<span class="name">
  	<?php if ($params->get('greeting')) : ?>
		<?php if ($params->get('name') == 0) : {
			echo str_replace(",", "", JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name'))));
		} else : {
			echo str_replace(",", "", JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username'))));
		} endif; ?>
	<?php endif; ?>
	<i class="fa fa-angle-down"></i>
	</span>	
  </button>
  <div class="dropdown-menu dropdown-menu-right" role="menu">
  	<?php
		jimport('joomla.application.module.helper');
		$modules = JModuleHelper::getModules('usermenu'); 
		foreach($modules as $module)
		{
			echo JModuleHelper::renderModule($module);
		}
		if (count($modules)) {
			echo '<div class="divider"></div>';
		}
  	?>
  	
  	<ul class="menu list-unstyled mb-5">
		<li>
			<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="login-form form-vertical ml-20">
	        <button type="submit" class="btn btn-default btn-sm"><?php echo JText::_('JLOGOUT'); ?> </button>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.logout" />
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHtml::_('form.token'); ?>
			</form>
		</li>
	</ul>
  </div>
</div>



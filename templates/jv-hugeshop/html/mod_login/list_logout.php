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
$document = JFactory::getDocument();
$document->addScriptDeclaration("
	jQuery(function($){
		var moduletitle = $('.header-topmenu .list-logout').parent('.contentmod').prev('.title-module');
			title 		= $('.header-topmenu .list-logout .title-module'),
			text  		= title.html();
			moduletitle.html(text);
			title.remove();
	});
");
?>
<!-- Split button -->
<div class="list-logout logout-form dropdown inline-block">
  	<h4 class="title-module">
  	<?php if ($params->get('greeting')) : ?>
		<?php if ($params->get('name') == 0) : {
			echo str_replace(",", "", JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name'))));
		} else : {
			echo str_replace(",", "", JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username'))));
		} endif; ?>
	<?php endif; ?>
	</h4>	
  	<?php
		jimport('joomla.application.module.helper');
		$modules = JModuleHelper::getModules('usermenu'); 
		foreach($modules as $module)
		{
			echo JModuleHelper::renderModule($module);
		}
  	?>
  	
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="login-form">
        <button type="submit" class="btn btn-login"><?php echo JText::_('JLOGOUT'); ?> </button>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>



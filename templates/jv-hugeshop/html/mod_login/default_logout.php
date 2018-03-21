<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="mod-login">
<?php if ($params->get('greeting')) : ?>
	<?php
		$email = $user->get('email');
		$default = "404";
		$size = 80;
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
		if (preg_match("|200|", $grav_url[0])) {
			$grav_url = JUri::base().'templates/jv-huge/images/avatar.png';
		}
	?>				
	<div class="logout-avatar"><img src="<?php echo $grav_url; ?>" alt="<?php echo $user->get('name');?>" width="66" onError="this.src='<?php echo JUri::base(); ?>templates/jv-huge/images/avatar.png';"  /> </div>
	<div class="login-greeting">
		<?php if ($params->get('name') == 0) : {
			echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
		} else : {
			echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
		} endif; ?>
	</div>
<?php endif; ?>
	<div class="logout-button">
		<input type="submit" name="Submit" class="btn btn-primary btn-sm" value="<?php echo JText::_('JLOGOUT'); ?>" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="profile<?php echo $this->pageclass_sfx?>">
<?php if (JFactory::getUser()->id == $this->data->id) : ?>
	<div class="profile-toolbar clearfix">
	<?php
		$email = $this->data->get('email');
		$default = "404";
		$size = 80;
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
		if (preg_match("|200|", $grav_url[0])) {
			$grav_url = JUri::base().'templates/jv-loren/images/avatar.png';
		}
	?>				
	<div class="profile-avatar pull-left"><img src="<?php echo $grav_url; ?>" alt="<?php echo $this->data->get('name');?>" width="66" onError="this.src='<?php echo JUri::base(); ?>templates/jv-loren/images/avatar/default.jpg';"  /> </div>
	<div class="profile-text"><?php echo JText::sprintf('COM_USERS_PROFILE_WELCOME', $this->data->get('name'));?></div>
	<a class="btn btn-primary btn-xs" href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id);?>">
		<?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?>
	</a>
</div>
<?php endif; ?>
<?php echo $this->loadTemplate('core'); ?>

<?php echo $this->loadTemplate('params'); ?>

<?php echo $this->loadTemplate('custom'); ?>

</div>

<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document 	= JFactory::getDocument();
if (($this->params->get('logout_image') != '')) {
	$document->addScriptDeclaration('
		(function($){
			$(function(){
				var wrap = $("#block-main");
			   	if (wrap.length > 0) {
			   		wrap.attr("style", "background-image: url('.JURI::base(true).'/'.$this->escape($this->params->get('logout_image')).')");
			   	}
		});
		})(jQuery);
	');
}
?>
<div class="logout<?php echo $this->pageclass_sfx;  echo ($this->escape($this->params->get('logout_image')) !='')?' background':''; ?>">
	<div class="logout-inner">
		<?php if ($this->params->get('logoutdescription_show') == 1) : ?>
			<div class="logout-desc">
			<?php echo $this->params->get('logout_description'); ?>
			</div>
		<?php endif; ?>

		<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post">
			<div class="clearfix">
				<?php
					$email = $this->user->get('email');
					$default = "404";
					$size = 80;
					$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
					if (preg_match("|200|", $grav_url[0])) {
						$grav_url = JUri::base().'templates/jv-huge/images/avatar.png';
					}
				?>				
				<div class="logout-avatar"><img src="<?php echo $grav_url; ?>" alt="<?php echo $this->user->get('name');?>" width="66" onError="this.src='<?php echo JUri::base(); ?>templates/jv-loren/images/avatar/default.jpg';"  /> </div>
				<div class="logout-content">
					<div class="logout-text"><?php echo JText::sprintf('COM_USERS_PROFILE_WELCOME', '<strong>'.$this->user->get('name').'</strong>');?></div>
					<button type="submit" class="btn btn-darker btn-xs"></span> <?php echo JText::_('JLOGOUT'); ?></button>
				</div>
				
			</div>
			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
</div>

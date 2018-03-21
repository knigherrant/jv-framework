<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
?>

<div class="post-block post-leave-comment">
	<h4 class="mb-40 title-icon text-uppercase"><?php echo JText::_('TPL_POST_A_COMMENT') ?></h4>
	<?php if($this->params->get('commentsFormNotes')): ?>
	<p class="itemCommentsFormNotes">
		<small>
			<?php if($this->params->get('commentsFormNotesText')): ?>
			<?php echo nl2br($this->params->get('commentsFormNotesText')); ?>
			<?php else: ?>
			<?php echo JText::_('K2_COMMENT_FORM_NOTES') ?>
			<?php endif; ?>
		</small>
	</p>
	<?php endif; ?>
	<form action="<?php echo JURI::root(true); ?>/index.php" method="post" id="comment-form" class="form-validate">
		
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<label for="userName"><?php echo JText::_('TPL_FULL_NAME'); ?></label>
					<input class="form-control" type="text" name="userName" id="userName" value=""  />
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group ">
					<label for="commentEmail"><?php echo JText::_('TPL_EMAIL_ADDRESS'); ?></label>
					<input class="form-control" type="text" name="commentEmail" id="commentEmail" value="" />
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group ">
					<label for="commentURL"><?php echo JText::_('TPL_YOUR_WEBSITE'); ?></label>
					<input class="form-control" type="text" name="commentURL" id="commentURL" value="" />
				</div>
			</div>
		</div>

		<div class="form-group mb-30">
			<div class="row">
				<div class="col-md-12">
					<label for="commentText"><?php echo JText::_('TPL_YOUR_WEBSITE'); ?></label>
					<textarea rows="6" cols="10" class="form-control" name="commentText" id="commentText"></textarea>
				</div>
			</div>
		</div>

		<?php if($this->params->get('recaptcha') && ($this->user->guest || $this->params->get('recaptchaForRegistered', 1))): ?>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label class="formRecaptcha"><?php echo JText::_('K2_ENTER_THE_TWO_WORDS_YOU_SEE_BELOW'); ?></label>
					<div id="recaptcha"></div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-12 clearfix">
				<input type="submit" class="btn btn-primary btn-block btn-radius" id="submitCommentButton" value="<?php echo JText::_('TPL_POST_COMMENT'); ?>" />
				<span id="formLog"></span>
			</div>
		</div>

		<input type="hidden" name="option" value="com_k2" />
		<input type="hidden" name="view" value="item" />
		<input type="hidden" name="task" value="comment" />
		<input type="hidden" name="itemID" value="<?php echo JRequest::getInt('id'); ?>" />
		<?php echo JHTML::_('form.token'); ?>
	</form>

</div>
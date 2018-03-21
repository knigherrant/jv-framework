<?php
/**
 * @version		$Id: item_comments_form.php 1992 2013-07-04 16:36:38Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<h3><?php echo JText::_('K2_LEAVE_A_COMMENT') ?></h3>

<?php if($this->params->get('commentsFormNotes')): ?>
<p class="itemCommentsFormNotes">
	<?php if($this->params->get('commentsFormNotesText')): ?>
	<?php echo nl2br($this->params->get('commentsFormNotesText')); ?>
	<?php endif; ?>
</p>
<?php endif; ?>

<form action="<?php echo JURI::root(true); ?>/index.php" method="post" id="comment-form" class="form-validate">
	
    
    <div class="row">
    <div class="col-sm-5 col-md-5">

	

	<input class="inputbox" type="text" name="userName" id="userName" placeholder="<?php echo JText::_('K2_ENTER_YOUR_NAME'); ?>"  />

	
	<input  class="inputbox" type="text" name="commentEmail" id="commentEmail" placeholder="<?php echo JText::_('K2_ENTER_YOUR_EMAIL_ADDRESS'); ?>"  />

	
	<input class="inputbox" type="text" name="commentURL" id="commentURL" placeholder="<?php echo JText::_('K2_ENTER_YOUR_SITE_URL'); ?>"  />


    
    </div>
        <div class="col-sm-7 col-md-7"><textarea rows="20" cols="10"  placeholder="<?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?>"    name="commentText" id="commentText"></textarea></div>
    </div>
    
    	<?php if($this->params->get('recaptcha') && ($this->user->guest || $this->params->get('recaptchaForRegistered', 1))): ?>
	<label class="formRecaptcha"><?php echo JText::_('K2_ENTER_THE_TWO_WORDS_YOU_SEE_BELOW'); ?></label>
	<div id="recaptcha"></div>
	<?php endif; ?>

	<input type="submit"  id="submitCommentButton" value="<?php echo JText::_('K2_SUBMIT_COMMENT'); ?>" />

	<span id="formLog"></span>

	<input type="hidden" name="option" value="com_k2" />
	<input type="hidden" name="view" value="item" />
	<input type="hidden" name="task" value="comment" />
	<input type="hidden" name="itemID" value="<?php echo JRequest::getInt('id'); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>

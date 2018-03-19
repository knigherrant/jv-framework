<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');
?>
<div class="contact-page<?php echo $this->pageclass_sfx?>">
	<?php if ($this->contact->name && $this->params->get('show_name')) : ?>
		<div class="">
			<h2 class="titlePage">
				<span class="contact-name"><?php echo $this->contact->name; ?></span>
			</h2>
		</div>
	<?php endif;  ?>
	<?php if ($this->params->get('show_contact_category') == 'show_no_link') : ?>
		<h3>
			<span class="contact-category"><?php echo $this->contact->category_title; ?></span>
		</h3>
	<?php endif; ?>
	<?php if ($this->params->get('show_contact_category') == 'show_with_link') : ?>
		<?php $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid);?>
		<h3>
			<span class="contact-category"><a href="<?php echo $contactLink; ?>">
				<?php echo $this->escape($this->contact->category_title); ?></a>
			</span>
		</h3>
	<?php endif; ?>
	<?php if ($this->params->get('show_contact_list') && count($this->contacts) > 1) : ?>
		<form action="#" method="get" name="selectForm" id="selectForm">
			<?php echo JText::_('COM_CONTACT_SELECT_CONTACT'); ?>
			<?php echo JHtml::_('select.genericlist',  $this->contacts, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'name', $this->contact->link);?>
		</form>
	<?php endif; ?>

	<?php if ($this->params->get('show_tags', 1) && !empty($this->item->tags)) : ?>
		<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
	<?php endif; ?>

	<?php  if ($this->params->get('presentation_style') == 'sliders'):?>
		<div class="panel-group" id="accordionContact" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="head-basic-details">
					<h3 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordionContact" href="#basic-details" aria-expanded="true" aria-controls="basic-details">
						<?php echo JText::_('COM_CONTACT_DETAILS');?>
						</a>
					</h3>
				</div>
				<div id="basic-details" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="head-basic-details">
					<div class="panel-body">
	<?php endif; ?>
	<?php if ($this->params->get('presentation_style') == 'plain'):?>
		<?php  echo '<h3>' . JText::_('COM_CONTACT_DETAILS') . '</h3>';  ?>
	<?php endif; ?>
	<?php if ($this->contact->image && $this->params->get('show_image')) : ?>
	<div class="pull-right col-xs-12 col-sm-2 text-center">
		<div class="thumbnail">
			<?php echo JHtml::_('image', $this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array()); ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if ($this->contact->con_position && $this->params->get('show_position')) : ?>
		<dl class="contact-address dl-horizontal col-xxs-8 col-xs-9 col-sm-10 pl-0">
			<dd>
				<?php echo $this->contact->con_position; ?>
			</dd>
		</dl>
	<?php endif; ?>

	<?php echo $this->loadTemplate('address'); ?>

	<?php if ($this->params->get('allow_vcard')) :	?>
		<?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS');?>
			<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id='.$this->contact->id . '&amp;format=vcf'); ?>">
			<?php echo JText::_('COM_CONTACT_VCARD');?></a>
	<?php endif; ?>
	<?php if ($this->params->get('presentation_style') == 'sliders'):?>
					</div>
				</div>
			</div>
			
	<?php endif; ?>
	<?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>

		<?php if ($this->params->get('presentation_style') == 'sliders'):?>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="head-display-form">
					<h3 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordionContact" href="#display-form" aria-expanded="false" aria-controls="display-form">
						<?php echo JText::_('COM_CONTACT_EMAIL_FORM');?>
						</a>
					</h3>
				</div>
				<div id="display-form" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head-display-form">
					<div class="panel-body">
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style') == 'plain'):?>
			<?php  echo '<h3>'. JText::_('COM_CONTACT_EMAIL_FORM').'</h3>';  ?>
		<?php endif; ?>
		<?php  echo $this->loadTemplate('form');  ?>
		<?php if ($this->params->get('presentation_style') == 'sliders'):?>
					</div>
				</div>
			</div>
			
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_links')) : ?>
		<?php echo $this->loadTemplate('links'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>
			<?php if ($this->params->get('presentation_style') == 'sliders'):?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordionContact" href="#display-articles"  aria-expanded="false">
						<?php echo JText::_('JGLOBAL_ARTICLES');?>
						</a>
					</h3>
				</div>
				<div id="display-articles" class="panel-collapse collapse"  aria-expanded="false">
					<div class="panel-body">
			<?php endif; ?>
			<?php if  ($this->params->get('presentation_style') == 'plain'):?>
			<?php echo '<h3>'. JText::_('JGLOBAL_ARTICLES').'</h3>'; ?>
			<?php endif; ?>
			<?php echo $this->loadTemplate('articles'); ?>
			<?php if ($this->params->get('presentation_style') == 'sliders'):?>
					</div>
				</div>
			</div>
			
			<?php endif; ?>
	<?php endif; ?>
	<?php if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>
		<?php if ($this->params->get('presentation_style') == 'sliders'):?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordionContact" href="#display-profile"  aria-expanded="false">
					<?php echo JText::_('COM_CONTACT_PROFILE');?>
					</a>
				</h3>
				</div>
				<div id="display-profile" class="panel-collapse collapse"  aria-expanded="false">
					<div class="panel-body">
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style') == 'plain'):?>
			<?php echo '<h3>'. JText::_('COM_CONTACT_PROFILE').'</h3>'; ?>
		<?php endif; ?>
		<?php echo $this->loadTemplate('profile'); ?>
		<?php if ($this->params->get('presentation_style') == 'sliders'):?>
					</div>
				</div>
			</div>
			
		<?php endif; ?>
	<?php endif; ?>
	<?php if ($this->contact->misc && $this->params->get('show_misc')) : ?>
		<?php if ($this->params->get('presentation_style') == 'sliders'):?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3  class="panel-title">
						<a data-toggle="collapse" data-parent="#accordionContact" href="#display-misc" aria-expanded="false">
						<?php echo JText::_('COM_CONTACT_OTHER_INFORMATION');?>
						</a>
					</h3>
				</div>
				<div id="display-misc" class="panel-collapse collapse" aria-expanded="false">
					<div class="panel-body">
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style') == 'plain'):?>
			<?php echo '<h3>'. JText::_('COM_CONTACT_OTHER_INFORMATION').'</h3>'; ?>
		<?php endif; ?>
				<div class="contact-miscinfo">
					<?php echo $this->contact->misc; ?>
				</div>
		<?php if ($this->params->get('presentation_style') == 'sliders'):?>
					</div>
				</div>
			</div>
			
		</div>

		<?php endif; ?>
	<?php endif; ?>
	<?php if ($this->params->get('presentation_style') == 'sliders'):?>
		</div>
	<?php endif; ?>

<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Create a shortcut for params.
$canEdit = $this->item->params->get('access-edit');
$params = &$this->item->params;
$images = json_decode($this->item->images);
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;

?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
<div class="system-unpublished">
<?php endif; ?>




<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $this->item->event->beforeDisplayContent; ?>

<?php // to do not that elegant would be nice to group the params ?>


	<div class="post-body clearfix mb-50" itemscope>

		<?php  if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
			<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
		<?php endif; ?>

		<?php if ($params->get('show_title')) : ?>
			<h5 class="post-title mt-20 mb-0 text-uppercase text-semi-bold">
				<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
					<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
					<?php echo $this->escape($this->item->title); ?></a>
				<?php else : ?>
					<?php echo $this->escape($this->item->title); ?>
				<?php endif; ?>
			</h5>
		<?php endif; ?>

		<?php $useDefList = (($params->get('show_author')) 
					or ($params->get('show_category')) 
					or ($params->get('show_parent_category'))
					or ($params->get('show_create_date')) 
					or ($params->get('show_modify_date')) 
					or ($params->get('show_publish_date'))
					or ($params->get('show_hits'))
					or $params->get('show_print_icon') 
					or $params->get('show_email_icon')
				); ?>
				<?php if ($useDefList) : ?>
				<div class="post-tools mb-30">
					<!-- Info -->
					<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params)); ?>
					<!-- Icon tools -->
					<?php if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
						<?php echo JLayoutHelper::render('joomla.content.icons', array('item' => $this->item, 'params' => $params)); ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>


		<?php echo $this->item->introtext; ?>

		<?php if ($params->get('show_readmore') && $this->item->readmore) :
			if ($params->get('access-view')) :
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
			else :
				$menu = JFactory::getApplication()->getMenu();
				$active = $menu->getActive();
				$itemId = $active->id;
				$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
				$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug));
				$link = new JUri($link1);
				$link->setVar('return', base64_encode($returnURL));
			endif;
		?>
				<div class="post-readmore mt-20">
					<a href="<?php echo $link; ?>">
						<?php if (!$params->get('access-view')) :
							echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
						elseif ($readmore = $this->item->alternative_readmore) :
							echo $readmore;
							if ($params->get('show_readmore_title', 0) != 0) :
								echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
							endif;
						elseif ($params->get('show_readmore_title', 0) == 0) :
							echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
						else :
							echo JText::_('COM_CONTENT_READ_MORE');
							echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
						endif; ?></a>
				</div>
		<?php endif; ?>
	</div>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>

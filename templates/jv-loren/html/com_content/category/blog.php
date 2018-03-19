<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die; 

$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::addIncludePath(JPATH_THEMES .'/'.JFactory::getApplication()->getTemplate(). '/html/com_content');
JHtml::_('behavior.caption');

$cparams = JComponentHelper::getParams('com_media');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<section class="blog<?php echo $this->pageclass_sfx;?>">

<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc clearfix mb-40">
	<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
		<div class="thumbnail col-sm-2">
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
		</div>
	<?php endif; ?>
	<?php if ($this->params->get('show_description') && $this->category->description) : ?>
		<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
		</br>
	<?php endif; ?>
	</div>
<?php endif; ?>


<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
	<?php if ($this->params->get('show_no_articles', 1)) : ?>
		<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>
<?php endif; ?>

<div class="blog-posts">
	<!-- Leading -->
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
	<div class="items-leading post post-large">
		<?php foreach ($this->lead_items as &$item) : ?>
				<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
			<?php $leadingcount++; ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<!-- / leading -->

	<!-- intro -->
	<?php
		$introcount = (count($this->intro_items));
		$counter = 0;
	?>
	<?php if (!empty($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<?php $rowcount = ((int) $counter % (int) $this->columns) + 1; ?>
			<?php if ($rowcount == 1) : ?>
				<?php $row = $counter / $this->columns; ?>
			<div class="items-row row post">
			<?php endif; ?>
				<div class="col-sm-<?php echo round((12 / $this->columns));?>">
					<div class="item column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>" >
						<?php
						$this->item = &$item;
						echo $this->loadTemplate('item');
					?>
					</div><!-- end item -->
					<?php $counter++; ?>
				</div><!-- end span -->
				<?php if (($rowcount == $this->columns) or ($counter == $introcount)) : ?>			
			</div><!-- end row -->
				<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	<!-- / intro -->

	<!-- Links -->
	<?php if (!empty($this->link_items)) : ?>
		<?php echo $this->loadTemplate('links'); ?>
	<?php endif; ?>
	<!-- / Lisks -->
	<?php if (is_array($this->children[$this->category->id]) && count($this->children[$this->category->id]) > 0 && $this->params->get('maxLevel') != 0) : ?>
		<div class="cat-children">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3 class="mt-0">
					<?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?>
				</h3>
			<?php endif; ?>
			<?php echo $this->loadTemplate('children'); ?>
		</div>
	<?php endif; ?>

	<?php   $pagesTotal = isset($this->pagination->pagesTotal) ? $this->pagination->pagesTotal : $this->pagination->get('pages.total');
	if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($pagesTotal > 1)) : ?>
		<div class="pagination-wrap">
			<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
			<div class="counter pull-left"> <?php echo $this->pagination->getPagesCounter(); ?></div>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php  endif; ?>

</div>
</section>

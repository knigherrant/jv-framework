<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
$lang	= JFactory::getLanguage();

if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) :
?>
<div class="panel-group accordion accordion-7 accordion-primary" id="accordion-<?php echo $this->parent->id;?>"  role="tablist" aria-multiselectable="true">
	<?php foreach($this->items[$this->parent->id] as $id => $item) : ?>
		<?php
		if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
		?>
		<div class="panel  panel-primary">
			<div class="panel-heading" id="heading-<?php echo $item->id;?>">
				<h4 class="panel-title">
					<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id));?>"> <?php echo $this->escape($item->title); ?></a>
				</h4>
				<?php if ($this->params->get('show_description_image') ||  $item->getParams()->get('image') || (count($item->getChildren()) > 0) ) : ?>
				<a class="accordion-icon accordion-iconplus collapsed" data-group="av" data-toggle="collapse" data-parent="#accordion-<?php echo $this->parent->id;?>" href="#collapse-<?php echo $item->id;?>" aria-expanded="false">
				  <span></span><span></span>
				</a>
			<?php endif; ?> 
			</div>
			<div id="collapse-<?php echo $item->id;?>" class="panel-collapse collapse" aria-expanded="false" style="display: block; height: 0px;" role="tabpanel">
				<div class="panel-body">
					<div class="row clearfix"> 
							<?php if ($this->params->get('show_description_image') && $item->getParams()->get('image')) : ?>
								<div class="col-sm-2 pull-left">
									<div class="thumbnail">
										<img src="<?php echo $item->getParams()->get('image'); ?>"/>
									</div>
								</div>
							<?php endif; ?>
							<?php if ($this->params->get('show_subcat_desc_cat') == 1) :?>
								<?php if ($item->description) : ?>
									<div class="category-desc <?php echo ($this->params->get('show_description_image') && $item->getParams()->get('image'))?'col-sm-10':'col-sm-12'?>">
										<?php echo JHtml::_('content.prepare', $item->description, '', 'com_content.categories'); ?>
									</div>
								<?php endif;  ?>
							<?php endif; ?>
						</div>
						<?php if (count($item->getChildren()) > 0) :?>
							<div>
								<?php
								$this->items[$item->id] = $item->getChildren();
								$this->parent = $item;
								$this->maxLevelcat--;
								echo $this->loadTemplate('items');
								$this->parent = $item->getParent();
								$this->maxLevelcat++;
								?>
							</div>
						<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
<?php endif; ?>

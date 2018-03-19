<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();
?>
<form id="searchForm" action="<?php echo JRoute::_('index.php?option=com_search');?>" method="post">
	<div class="panel panel-default">
		<div class="form-group panel-heading">
			<div class="input-group pull-left">
				<input type="text" name="searchword" placeholder="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" id="search-searchword" size="30" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>" class="form-control" />
				<div class="input-group-btn">
					<button name="Search" onclick="this.form.submit()" class="btn btn-primary hasTooltip" title="<?php echo JHtml::tooltipText('COM_SEARCH_SEARCH');?>"><span class="fa fa-search"></span> <?php echo JHtml::tooltipText('COM_SEARCH_SEARCH');?></button>
				</div>
			</div>
			<input type="hidden" name="task" value="search" />
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="searchintro<?php echo $this->params->get('pageclass_sfx'); ?>">
				<?php if (!empty($this->searchword)):?>
				<p><?php echo JText::plural('COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', '<span class="badge badge-info">'. $this->total. '</span>');?></p>
				<?php endif;?>
			</div>
			<div class="row">
			<?php $col= ($this->params->get('search_areas', 1))?"6":"12"?>
			<fieldset class="phrases col-md-<?php echo $col;?>">
				<legend><?php echo JText::_('COM_SEARCH_FOR');?>
				</legend>
					<div class="phrases-box radio">
						<?php echo $this->lists['searchphrase']; ?>
					</div>
					<div class="ordering-box">
					<label for="ordering" class="ordering">
						<?php echo JText::_('COM_SEARCH_ORDERING');?>
					</label>
					<?php echo $this->lists['ordering'];?>
					</div>
			</fieldset>
			<?php if ($this->params->get('search_areas', 1)) : ?>
				<fieldset class="only col-md-6">
					<legend class="pt-sm-20"><?php echo JText::_('COM_SEARCH_SEARCH_ONLY');?></legend>
						<?php foreach ($this->searchareas['search'] as $val => $txt) :
							$checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : '';
						?>
							<div class="checkbox">
								<label for="area-<?php echo $val;?>">
									<input type="checkbox" name="areas[]" value="<?php echo $val;?>" id="area-<?php echo $val;?>" <?php echo $checked;?> >
									<?php echo JText::_($txt); ?>
								</label>
							</div>
						<?php endforeach; ?>
				</fieldset>
			<?php endif; ?>
			</div>
		</div>
	</div>
<?php if ($this->total > 0) : ?>
	<div class="form-group panel panel-default">
		<div class="panel-body">
				<?php  if ($this->pagination->getPagesCounter() !="") : ?>
				<p class="counter pull-right">
							<?php echo $this->pagination->getPagesCounter(); ?>
						</p>
				<?php endif; ?>
			
			<div class="form-limit form-inline">
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

</form>

<?php
/**
 # com_jvframwork - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
//no direct access
defined( '_JEXEC' ) or die( 'Retricted Access' );

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'a.ordering';


?>

<?php
		// Display the submenu position modules
		$this->submenumodules = JModuleHelper::getModules('submenu');
		foreach ($this->submenumodules as $submenumodule) {
			$output = JModuleHelper::renderModule($submenumodule);
			$params = new JRegistry;
			$params->loadString($submenumodule->params);
			echo $output;
		}
	?>
	
<form action="<?php echo JRoute::_('index.php?option=com_jvframework');?>" method="post" name="adminForm" id="adminForm">
	<div id="filter-bar">
		<div class="filter-search fltlft input-append">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('Search'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter_search')); ?>"/>
			<button class="btn" type="submit"><?php echo JText::_('Submit'); ?></button>
			<button class="btn" type="button" onclick="$('filter_search').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
		</div>
	</div>
	<div class="clr"> </div>
	<br/>
	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" 	name="toggle" value="" onclick="Joomla.checkAll(this);" />
				</th>
				<th width="20%"><?php echo $this->labels->title; ?></th>
                <th width="30%"><?php echo $this->labels->example; ?></th>
                <th width="6%"><?php echo $this->labels->tag; ?></th>       
                <th width="10%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
					<?php if ($saveOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'typographies.saveorder'); ?>
					<?php endif; ?>
				</th>
                <th width="6%"><?php echo $this->labels->published; ?></th>
                <th width="1%"><?php echo $this->labels->id; ?></th>
                
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($this->items as $i => $item) :
			$ordering	= ($listOrder == 'a.ordering');
			?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="center">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td>
                        <a href="<?php echo JRoute::_('index.php?option=com_jvframework&task=typography.edit&id='.$item->id);?>">
    						<?php echo $this->escape($item->title); ?>
                        </a>
					</td>	                    
                    <td align="left">
                    	<?php foreach (explode("\n", $item->example) as $example):?>
                    	<pre><?php echo $this->escape($example); ?></pre>
                    	<?php endforeach;?>
					</td>
					<td align="left">
                        <?php echo $item->tag; ?>
					</td>
					<td class="order">
						<?php if ($saveOrder) :?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, true, 'typographies.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'typographies.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php elseif ($listDirn == 'desc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, true, 'typographies.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'typographies.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
						
					</td>
					 <td align="center">
						<?php echo $published = JHTML::_('grid.published',$item, $i, 'tick.png', 'publish_x.png', 'typographies.');?>
					</td>
					<td align="center">
                        <?php echo (int) $item->id; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
        
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
	<div>
		<input type="hidden" name="task" value="" />	
        <input type="hidden" name="view" value="typographies" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
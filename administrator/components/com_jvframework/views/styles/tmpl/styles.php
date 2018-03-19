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
  ------------------------------------------------------------------------- 
  */
//no direct access
defined('_JEXEC') or die('Retricted Access');

$listOrder = $this->state->get('filter_order');
$listDirn = $this->state->get('filter_order_Dir');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jvframework'); ?>" method="post" name="adminForm">

    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('Search'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>"/>
            <button type="submit"><?php echo JText::_('Submit'); ?></button>
            <button type="button" onclick="$('filter_search').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
        </div>
    </fieldset>
    <div class="clr"> </div>
    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">
                    <input type="checkbox" 	name="toggle" value="" onclick="checkAll(<?php echo count($this->items) ?>);" />
                </th>
                <th width="62%">
                    <?php echo $this->labels->title; ?>
                </th>  
                <th width="62%">
                    <?php echo $this->labels->theme; ?>
                </th>
                <th width="3%">
                    <?php echo $this->labels->home; ?>
                </th>                
                <th width="3%">
                    <?php echo $this->labels->assign; ?>
                </th>
                <th width="1%" class="nowrap">
                    <?php echo $this->labels->id; ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(is_array($this->items)) foreach ($this->items as $i => $item) :
                $link = JRoute::_('index.php?option=com_jvframework&task=style.edit&id=' . $item->id);
                ;
                $link2 = "javascript:void(0)";
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center">
   						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td align="left" valign="middle">  
                        <a href="<?php if (is_numeric($item->id))
								        	echo $link; 
								        else
								        	echo $link2; ?>" class="theme" > 
                            <?php if (isset($item->theme)) { ?>
        			<img src="<?php echo JURI::root() . 'templates/' . $this->getTemplate($item->theme) . '/themes/' . $item->theme . '/thumbnail.jpg' ?>"/>
                                <span class="desc"><?php echo $item->title; ?></span>
                        <?php } ?>                
                        </a>
                    </td>	
                    <td class="center">						
                        <?php echo $item->theme; ?>
                    </td>
                    <td align="center">
                         <?php if ($item->home) { ?>
                            <img src="<?php echo JURI::base() . 'components/com_jvframework/assets/images/default_small.png' ?>" title="<?php echo JText::_('DEFAULT') ?>" /> 
                        <?php } ?>
                    </td>   
                    <td align="center">
                         <?php if ($item->assign): ?>
                            <img src="<?php echo JURI::base() . 'components/com_jvframework/assets/images/tick.png' ?>" title="<?php echo JText::_('ASSIGNED') ?>" />
                        <?php endif; ?>
                    </td>
                   
                    <td class="center">						
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
        <input type="hidden" name="view" value="styles" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
    </div>
</form>
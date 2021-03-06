<?php
/**
 * @version     1.0.0
 * @package     mod_portfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */
// no direct access
defined('_JEXEC') or die;
?>
<?php if($items):?>
<div class="<?php echo $params->get('moduleclass_sfx', ''); ?>">
    <div class="pfo-mini-recent">    
        <div class="row">        
            <?php foreach($items as $item):?>
    		<div class="col-xs-<?php echo $column?>" data-groups='[<?php echo $item->aliasTags?>]' data-name="<?php echo strtolower($item->name)?>" data-date="<?php echo strtotime($item->date_created)?>" data-like="<?php echo $item->cliked?>">
                <a class="pfo-image" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}&Itemid={$page_detail_id}")?>" style="background-image: url(<?php echo $item->image ?>);">
    			     <img alt="<?php echo $item->name?>" src="<?php echo $item->image ?>" class="hidden">
                </a>	  
    		</div>
    		<?php endforeach;?>     
        </div> 
        <?php if ($params->get('more_link')) {?>
            <div class="pfo-more-link">
                <a target="_blank" href="<?php echo $params->get('more_link');?>" title="<?php echo JText::_('TPL_VIEW_MORE');?>"><?php echo JText::_('TPL_VIEW_MORE');?> <i class="fa fa-angle-double-right text-primary"></i></a>    
            </div>            
        <?php }?>     
    </div>
</div>
<?php endif;?>
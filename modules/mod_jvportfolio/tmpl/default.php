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
$isFilter = (intval($params->get('filter')));                                                                
$isSort = intval($params->get('sort', 0));
$prefixCol = JvportfolioFrontendHelper::getPrefixCol($column);   
$ncol = intval($column)*2;
$qview = JvportfolioFrontendHelper::getActionQView("col-md-{$column}", "col-md-{$ncol}");   
?>
<?php if($items):?>
<div id="<?php echo "mod-frm-portfolio-{$module->id}"?>" class="<?php echo implode(' ', array($params->get('moduleclass_sfx', ''), $prefixCol))?>">
    <?php if($isFilter+$isSort):?>
   <div class="clearfix topPortfolio">
            <?php if($isSort): ?>
                <?php require ModJvPortfolioHelper::loadTemplate('_csort'); ?>
            <?php endif;?>
            <?php if($isFilter):?>
                <?php require ModJvPortfolioHelper::loadTemplate('_cfilter'); ?>
            <?php endif;?> 
        </div>
    <?php endif;?>
    
    <div class="row">
    <div class="box-portfolio <?php echo($isFilter ? 'portfolioContainer': '')?> ">        
        <?php foreach($items as $item):?>
		<div id="pfo-item-<?php echo $item->id?>" class="pfo-item col-md-<?php echo $column?>" data-groups='[<?php echo $item->aliasTags?>]' data-name="<?php echo strtolower($item->name)?>" data-date="<?php echo strtotime($item->date_created)?>" data-like="<?php echo $item->cliked?>">
		   <div class="pfo-item-img">
                <?php if($params->get('showQuickview', 0) || $params->get('showDetail', 1) ):?>
                <div class="overaly">
                    <div class="pfo-inner">
                      <div class="pfo-inner2">
                        <?php if($params->get('showQuickview', 0)):?>
                           <?php if($item->gallery && count($item->gallery)):?>
                           <a class="btn btn-default btn-sm" href="#"  data-imgs='<?php echo json_encode($item->gallery)?>' data-qview="lightbox" title="<?php echo JText::_("COM_JVPORTFOLIO_QUICK_VIEW"); ?>"><?php echo JText::_("COM_JVPORTFOLIO_QUICK_VIEW"); ?></a>
                           <?php endif;?>
                        <?php endif;?>
                        <?php if($params->get('showDetail', 1)):?>
                           <a class="btn btn-default btn-sm" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}&Itemid=".$params->get('pfomenu', 0)); ?>" title="<?php echo JText::_("COM_JVPORTFOLIO_DETAIL"); ?>"><?php echo JText::_("COM_JVPORTFOLIO_DETAIL"); ?></a>
                        <?php endif;?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
			     <img alt="<?php echo $item->name?>" src="<?php echo $item->image ?>">
		   </div>
		   <div class="portfolio-item-description p-item-description">
			  <?php if($params->get('showLiked', 0)):?>
			   <a class="likeheart pull-right"  href="<?php echo JUri::root()?>?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid=<?php echo $item->id?>" data-pfvote="<?php echo $item->id?>"><i class="<?php echo ($item->lactive ? 'active' : '')?> fa fa-heart pull-right">&nbsp;<?php echo $item->cliked?></i></a>
			   <?php endif;?>

			  <?php if($params->get('hasTitle', 0)):?>
                <?php if($params->get('hasTitleLink', 1)) {?>
			     <a class="pfo-title h4" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}&Itemid=".$params->get('pfomenu', 0)); ?>" title="<?php echo $item->name?>"><?php echo $item->name?></a>
                 <?php } else { ?>
                 <span class="pfo-title h4"><?php echo $item->name?></span>
                 <?php } ?>
			  <?php endif;?>

			  <?php if($params->get('hasTag', 0)):?>
			  <div class="pfo-tags"><?php echo $item->tag?></div>
			  <?php endif;?>
			  <?php if($params->get('hasDate', 0)):?>
			  <div class="pfo-date"><?php echo date(JText::_("COM_JVPORTFOLIO_DATE_FORMAT"), strtotime($item->date_created))?></div>
			  <?php endif;?>
		   </div>
		</div>
		<?php endforeach;?>        
        <div class="pf-load">
            <div class="box">
                <img src="<?php echo "{$com_assets}/images/load-yellow.gif"?>" alt="loading"/>
                <div><?php echo JText::_('COM_JVPORTFOLIO_LOADING')?></div>
            </div>
        </div>    
    </div>
    </div>
    <?php if($total):?>
    <?php require ModJvPortfolioHelper::loadTemplate('_nav')?>
    <?php endif;?>
</div>
<?php endif;?>
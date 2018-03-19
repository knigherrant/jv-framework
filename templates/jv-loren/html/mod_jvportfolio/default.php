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
<div id="<?php echo "mod-frm-portfolio-{$module->id}"?>" class="portfolio-default portfolio<?php echo number_format(12/$column, 0)?> <?php echo implode(' ', array($params->get('moduleclass_sfx', '')))?>">
    <?php if($isFilter+$isSort):?>
   <div class="clearfix topPortfolio">
            <?php if($isSort):?>
                <?php require ModJvPortfolioHelper::loadTemplate('_csort')?>
            <?php endif;?>
            <?php if($isFilter):?>
                <?php require ModJvPortfolioHelper::loadTemplate('_cfilter')?>
            <?php endif;?> 
        </div>
    <?php endif;?>
    
    <div class="row">
    <div class="box-portfolio <?php echo($isFilter ? 'portfolioContainer': '')?> ">
        
        <?php foreach($items as $item):?>
		 <div id="pfo-item-<?php echo $module->id.'-'.$item->id?>" class="pfo-item col-xxs-12 col-xs-6 col-sm-<?php echo ($column !=6)?'4':'6'; ?> col-md-<?php echo $column?>" data-groups='[<?php echo $item->aliasTags?>]' data-name="<?php echo strtolower($item->name)?>" data-date="<?php echo strtotime($item->date_created)?>" data-like="<?php echo $item->cliked?>">
          <div class="pfo-body">
            <div class="pfo-image">
              <div class="pfo-overlay">
                   <?php if($item->gallery):?> 
                   <a class="link-quick" href="#" data-imgs='<?php echo json_encode($item->gallery)?>' data-qview="lightbox" title="<?php echo $item->name?>"></a>
                   <?php endif?>
                   <a class="link-detail" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>" title="<?php echo $item->name?>"></a>               
              </div>
               <div class="img" style="background-image: url(<?php echo $item->image ?>)"><img class="hidden" src="<?php echo $item->image ?>" alt="<?php echo $item->name?>"></div>
            </div>
            <!-- end img  -->
            <div class="pfo-content">            

              <?php if($params->get('hasTitle', 0)):?>
              <a  class="pfo-title" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>"><?php echo $item->name?></a>
              <?php endif;?>
              <?php if($params->get('hasTag', 0)):?>
              <span class="pfo-hasTag"><?php echo $item->tag?></span>
              <?php endif;?>
              <?php if($params->get('showLiked', 0)):?>
               <a class="pfo-like pull-right" href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$item->id}"?>" data-pfvote="<?php echo $item->id?>"><i class="<?php echo ($item->lactive ? 'active' : '')?> fa fa-heart-o">&nbsp;<?php echo $item->cliked?></i></a> 
               <?php endif;?>
              <?php if($params->get('hasDate', 0)):?>
              <span class="pfo-date pull-right"><?php echo date('F d, Y', strtotime($item->date_created))?></span>
              <?php endif;?>
            </div>
            <!-- end content -->
          </div>
          <!-- end body -->
        </div>
        <!-- end item -->
		<?php endforeach;?>
        
        <div class="pf-load">
            <div class="box">
                <img src="<?php echo "{$com_assets}/images/load-yellow.gif"?>" alt="loading"/>
                <div class=""><?php echo JText::_('TPL_PORTFOLIO_LOAD_NEXT')?></div>
            </div>
        </div>    
    </div>
    </div>
    <?php if($total):?>
    <?php require ModJvPortfolioHelper::loadTemplate('_nav');?>
    <?php endif;?>
</div>
<?php endif;?>
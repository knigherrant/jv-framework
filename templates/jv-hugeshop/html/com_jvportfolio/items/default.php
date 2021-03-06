<?php
/**
 * @version     1.0.0
 * @package     com_portfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */
// no direct access
defined('_JEXEC') or die;   
$isFilter = (intval($this->mparams->get('filter')));                                                                
$isSort = intval($this->mparams->get('sort', 0));
$column = $this->mparams->get('column', 3);          
$prefixCol = JvportfolioFrontendHelper::getPrefixCol($column);
?>
<?php if($this->items):?>
<div id="frm-portfolio" class="portfolio-style portfolio<?php echo number_format(12/$column, 0)?>">
    <?php if($isFilter+$isSort):?>
        <div class="clearfix topPortfolio mb-50">

            <?php if($isSort):?>
                <?php echo $this->loadTemplate('csort')?>
            <?php endif;?>
            <?php if($isFilter):?>
                <?php echo $this->loadTemplate('cfilter')?>
            <?php endif;?> 

        </div>
        <!-- end navigation -->
    <?php endif;?>
    <div class="box-portfolio row <?php echo($isFilter ? 'portfolioContainer': '')?>">  
        <?php foreach($this->items as $item):?>
        <div id="pfo-item-<?php echo $item->id?>" class="pfo-item col-xxs-12 col-xs-6 col-sm-<?php echo ($column !=6)?'4':'6'; ?> col-md-<?php echo ($column == 2)?'3 col-lg-'.$column:$column; ?>" data-groups='[<?php echo $item->aliasTags?>]' data-name="<?php echo strtolower($item->name)?>" data-date="<?php echo strtotime($item->date_created)?>" data-like="<?php echo $item->cliked?>">
          <div class="pfo-body">
            <div class="pfo-image">
               <div class="img" style="background-image: url(<?php echo $item->image ?>)"></div>
            </div>
            <!-- end img  -->
            <div class="pfo-content">
              <div class="pfo-content-table">
                <div class="pfo-content-table-cell">
                  <div class="pfo-links">
                    <?php if($this->mparams->get('showQuickview', 1) && $item->gallery):?> 
                    <a class="link-quick" href="javascript:void(0)" data-imgs='<?php echo json_encode($item->gallery)?>' data-qview="lightbox" title="<?php echo JText::_('TPL_PORTFOLIO_ZOOM'); ?>"><i class="huge-eye"></i></a>
                   <?php endif?>
                   <?php if($this->mparams->get('showDetail', 1)):?>
                    <a class="link-detail" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>" title="<?php echo JText::_('TPL_PORTFOLIO_VIEW'); ?>"><i class="huge-link"></i></a>               
                   <?php endif?>
                  </div>
                  <?php if($this->mparams->get('hasTitle', 0)):?>
                    <?php if($this->mparams->get('hasTitleLink', 1)) { ?>
                        <a class="pfo-title text-uppercase" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>" title="<?php echo $item->name?>"><?php echo $item->name?></a>
                    <?php } else { ?>
                        <span class="pfo-title text-uppercase"><?php echo $item->name?></span>
                    <?php } ?>
                  <?php endif;?>
                  <?php if($this->mparams->get('hasTag', 0)):?>
                    <span class="pfo-hasTag text-uppercase"><?php echo str_replace(',', ' /', $item->tag); ?></span>
                  <?php endif;?>
                  <?php if($this->mparams->get('hasDate', 0)):?>
                    <span class="pfo-date text-uppercase"><?php echo date(JText::_('TPL_DATE_FORMAT_06'), strtotime($item->date_created))?></span>
                  <?php endif;?>
                  <?php if($this->mparams->get('showLiked', 0)):?>
                    <a class="pfo-like" href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$item->id}"?>" data-pfvote="<?php echo $item->id?>"><i class="<?php echo ($item->lactive ? 'active' : '')?> fa fa-heart-o">&nbsp;<?php echo $item->cliked?></i></a> 
                  <?php endif;?>
                  
                </div>
              </div>
            </div>
            <!-- end content -->
          </div>
          <!-- end body -->
        </div>
        <!-- end item -->
        <?php endforeach;?>
        <div class="pf-load">
            <div class="box">
                <img src="<?php echo "{$this->assets}/images/load-yellow.gif"?>" alt="loading"/>
                <div class=""><?php echo JText::_('TPL_PORTFOLIO_LOAD_NEXT')?></div>
            </div>
        </div>    
        <!-- end load -->
    </div>
    <?php if($this->pagination->pagesTotal):?>
    <?php echo $this->loadTemplate('nav')?>
    <!-- end pagination -->
    <?php endif;?>
</div>
<?php endif;?>
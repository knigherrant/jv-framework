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
<div id="frm-portfolio" class="portfolio<?php echo $column?>">
    <?php if($isFilter+$isSort):?>
        <div class="clearfix topPortfolio">
            <?php if($isSort):?>
                <?php echo $this->loadTemplate('csort')?>
            <?php endif;?>
            <?php if($isFilter):?>
                <?php echo $this->loadTemplate('cfilter')?>
            <?php endif;?> 
        </div>
    <?php endif;?>
    <div class="box-portfolio row <?php echo($isFilter ? 'portfolioContainer': '')?>">  
      <?php foreach($this->items as $item):?>
        <div id="pfo-item-<?php echo $item->id?>" class="pfo-item col-xs-6 col-sm-<?php echo ($column !=6)?'4':'6'; ?> col-md-<?php echo $column?>" data-groups='[<?php echo $item->aliasTags?>]' data-name="<?php echo strtolower($item->name)?>" data-date="<?php echo strtotime($item->date_created)?>" data-like="<?php echo $item->cliked?>">
           <div class="pfo-item-img">
              <?php if($this->mparams->get('showQuickview', 0) || $this->mparams->get('showDetail', 0)):?>
              <div class="overaly">
                <div class="pfo-inner">
                  <div class="pfo-inner2">
                    <?php if($this->mparams->get('showQuickview', 0) && $item->gallery):?> 
                     <span><a class="btn btn-default btn-sm" href="#" data-imgs='<?php echo json_encode($item->gallery)?>' data-qview="lightbox" title="<?php echo JText::_("COM_JVPORTFOLIO_QUICK_VIEW"); ?>"><?php echo JText::_("COM_JVPORTFOLIO_QUICK_VIEW"); ?></a></span>
                    <?php endif?>
                    <?php if($this->mparams->get('showDetail', 0)):?> 
                    <a class="btn btn-default btn-sm" target="_blank" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>" title="<?php echo JText::_("COM_JVPORTFOLIO_DETAIL"); ?>"><?php echo JText::_("COM_JVPORTFOLIO_DETAIL"); ?></a>
                    <?php endif?>
                  </div>
                </div>                  
              </div>
              <!-- end overlay -->
              <?php endif?>
              <img src="<?php echo $item->image ?>" alt="<?php echo $item->name?>" >
           </div>
           <!-- end image wrapper -->
           <div class="portfolio-item-description p-item-description">
              <?php if($this->mparams->get('showLiked', 0)):?>
              <a class="pfo-likeheart pull-right" href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$item->id}"?>" data-pfvote="<?php echo $item->id?>"><i class="<?php echo ($item->lactive ? 'active' : '')?> fa fa-heart">&nbsp;<?php echo $item->cliked?></i></a> 
               <?php endif;?>
              <?php if($this->mparams->get('hasTitle', 0)):?>
                <?php if($this->mparams->get('hasTitleLink', 1)) {?>
                  <a class="pfo-title h4" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>" title="<?php echo $item->name?>"><?php echo $item->name?></a>
                <?php } else { ?>
                  <span class="pfo-title h4"><?php echo $item->name?></span>
                <?php } ?>
              <?php endif;?>
              <?php if($this->mparams->get('hasTag', 0)):?>
              <div class="pfo-tags"><?php echo $item->tag?></div>
              <?php endif;?>
              <?php if($this->mparams->get('hasDate', 0)):?>
              <div class="pfo-date"><?php echo date(JText::_('COM_JVPORTFOLIO_DATE_FORMAT'), strtotime($item->date_created))?></div>
              <?php endif;?>
           </div>
           <!-- end description -->
        </div>
        <!-- end pfo-item -->
      <?php endforeach;?>
      <div class="pf-load">
        <div class="box">
          <img src="<?php echo "{$this->assets}/images/load-yellow.gif"?>" alt="loading"/>
          <div><?php echo JText::_('COM_JVPORTFOLIO_LOADING')?></div>
        </div>
      </div> 
      <!-- end load -->
    </div>
    <?php if($this->pagination->pagesTotal):?>
    <?php echo $this->loadTemplate('nav')?>
    <?php endif;?>
</div>
<?php endif;?>
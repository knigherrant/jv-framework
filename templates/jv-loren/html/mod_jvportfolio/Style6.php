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

$numItems = number_format(12/$column, 0);
if (strpos($params->get('moduleclass_sfx'), 'pfo-five') !== false) {
  $numItems = 5;
}
$numItemsdesktop = $numItems;
$numItemsdesktopsmall = ($numItemsdesktop > 1)?($numItemsdesktop-1):$numItemsdesktop;
$numItemstablet = ($numItemsdesktopsmall > 1)?($numItemsdesktopsmall-1):$numItemsdesktopsmall;
$numItemstabletsmall = ($numItemstablet > 1)?($numItemstablet-1):$numItemstablet;
$numItemsmobile = ($numItemstabletsmall > 1)?($numItemstabletsmall-1):$numItemstabletsmall;
?>
<?php if($items):?>
<div class="pfo-module portfolio-style6 portfolio<?php echo number_format(12/$column, 0)?> <?php echo implode(' ', array($params->get('moduleclass_sfx', '')))?>">

        <div class="box-portfolio carouselOwl" 
          data-items="<?php echo $numItems; ?>" 
          data-itemsdesktop="<?php echo $numItemsdesktop; ?>" 
          data-itemsdesktopsmall="<?php echo $numItemsdesktopsmall; ?>" 
          data-itemstablet="<?php echo $numItemstablet; ?>"
          data-itemstabletsmall="<?php echo $numItemstabletsmall; ?>"
          data-itemsmobile="<?php echo $numItemsmobile; ?>" 
          data-pagination="false" 
          data-navigation="true"
        >
          <?php foreach($items as $key => $item):?>
            <div class="pfo-carouse">
      		    <div class="pfo-body">
                    <div class="pfo-image">
                      <div class="pfo-overlay">
                          <?php if($item->gallery):?> 
                           <a class="link-quick" href="#" data-imgs='<?php echo json_encode($item->gallery)?>' data-qview="lightbox" title="<?php echo $item->name?>"><i class="fa fa-search"></i></a>
                           <?php endif?>
                           <a class="link-detail" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>" title="<?php echo $item->name?>"><i class="fa fa-link"></i></a>               
                      </div>
                      <div class="pfo-content">
                        
                        <div class="pfo-inner">
                          <div class="pfo-inner2">
                            <?php if($params->get('hasTitle', 0)):?>
                            <a  class="h6 pfo-title text-uppercase text-bold mt-0" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>"><?php echo $item->name?></a>
                            <?php endif;?>                      
                            <?php if($params->get('hasDate', 0)):?>
                            <span class="pfo-date"><?php echo date('F d, Y', strtotime($item->date_created))?></span>
                            <?php endif;?>
                            
                            <?php if($params->get('showLiked', 0)):?>
                             <a class="pfo-like" href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$item->id}"?>" data-pfvote="<?php echo $item->id?>"><i class="<?php echo ($item->lactive ? 'active' : '')?> fa fa-heart-o">&nbsp;<?php echo $item->cliked?></i></a> 
                             <?php endif;?> 
                             <?php if($params->get('hasTag', 0)):?>
                             <div class="pfo-hasTag"><?php echo str_replace(', ', '<span>/</span>', $item->tag); ?></div>
                          <?php endif;?>   
                          </div> 
                        </div>                 
                      </div>
                      <!-- end content --> 
                       <div class="img" style="background-image: url(<?php echo $item->image ?>)"><img class="hidden" src="<?php echo $item->image ?>" alt="<?php echo $item->name?>"></div>
                    </div>
                    <!-- end img  -->
              </div>
              <!-- end body -->
            </div>
    		  <?php endforeach;?>
        </div>
</div>
<?php endif;?>
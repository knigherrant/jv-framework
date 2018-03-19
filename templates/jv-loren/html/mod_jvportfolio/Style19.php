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


$document   = JFactory::getDocument();
$document->addScriptDeclaration('
  (function($){
    $(function(){
      $("#pfo-mod-'.$module->id.' .box-portfolio").imagesLoaded( function() {
        var  $grid = $("#pfo-mod-'.$module->id.' .box-portfolio"),
          $sizer = $grid.find(".pfo-item-2");
          $grid.shuffle({
            itemSelector: \'.pfo-item\',
            sizer: $sizer
          });
      });     
    });
  })(jQuery); 
');   

?>
<?php if($items):?>
<div id="pfo-mod-<?php echo $module->id;?>" class="portfolio-style19 portfolio<?php echo number_format(12/$column, 0); echo (count($items) >=8)?" pfo-multi":''?> <?php echo implode(' ', array($params->get('moduleclass_sfx', '')))?>">
    <div class="row">
    <div class="box-portfolio <?php echo($isFilter ? 'portfolioContainer': '')?> ">
        
      <?php foreach($items as $key => $item):?>
      <?php 
        $cols = '';
        $cols = 'col-xxs-12 col-xs-6 col-sm-6 col-md-'.$column.' pfo-item-'.($key + 1);
        if ( (($key+1) == 1) && ( number_format(12/$column, 0) == 4) ) {
           $cols = 'col-xxs-12 col-xs-6 col-sm-6 col-md-6 pfo-item-'.($key + 1);
        }
      ?>
		  <div class="pfo-item <?php echo $cols;?>" data-groups='[<?php echo $item->aliasTags?>]' data-name="<?php echo strtolower($item->name)?>" data-date="<?php echo strtotime($item->date_created)?>" data-like="<?php echo $item->cliked?>">
          <div class="pfo-body">
            <div class="pfo-image">
               <div class="img" style="background-image: url(<?php echo $item->image ?>)"><img class="hidden" src="<?php echo $item->image ?>" alt="<?php echo $item->name?>"></div>
            </div>
            <!-- end img  -->
            <div class="pfo-content">            
              <div class="pfo-content-table">
                <div class="pfo-content-table-cell">
                  <?php if($params->get('hasDate', 0)):?>
                  <span class="pfo-date"><?php echo date('F d, Y', strtotime($item->date_created))?></span>
                  <?php endif;?>
                  <?php if($params->get('hasTitle', 0)):?>
                  <a  class="pfo-title" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>"><?php echo $item->name?></a>
                  <?php endif;?>
                  <?php if($params->get('hasTag', 0)):?>
                  <span class="pfo-hasTag"><?php echo str_replace(', ', '<span> / </span>', $item->tag); ?></span>
                  <?php endif;?>
                  <?php if($params->get('showLiked', 0)):?>
                  <a class="pfo-like" href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$item->id}"?>" data-pfvote="<?php echo $item->id?>"><i class="<?php echo ($item->lactive ? 'active' : '')?> fa fa-heart-o">&nbsp;<?php echo $item->cliked?></i></a> 
                  <?php endif;?>
                  <div class="pfo-overlay">
                       <?php if($item->gallery):?> 
                       <a class="link-quick btn btn-sm btn-white btn-outline-thin" href="#" data-imgs='<?php echo json_encode($item->gallery)?>' data-qview="lightbox" title="<?php echo $item->name?>"><?php echo JText::_('TPL_PORTFOLIO_ZOOM')?></a>
                       <?php endif?>
                       <a class="link-detail btn btn-sm btn-white btn-outline-thin" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$item->id}")?>" title="<?php echo $item->name?>"><?php echo JText::_('TPL_PORTFOLIO_VIEW')?></a>               
                  </div>
                </div>
              </div>
            </div>
            <!-- end content -->
          </div>
          <!-- end body -->
        </div>
        <!-- end item -->
		<?php endforeach;?>
    </div>
    </div>
    <?php if($total):?>
    <?php require ModJvPortfolioHelper::loadTemplate('_nav');?>
    <?php endif;?>
</div>
<?php endif;?>
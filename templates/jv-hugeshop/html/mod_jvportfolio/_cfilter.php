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
   
   if($tag || $cate) {
      if ($cate) {
        $tags = JvportfolioFrontendHelper::getCateTags($cate, $tag);
      } else {
        $tags = JvportfolioFrontendHelper::getTags($tag);
      }
   }else {
        $tags = JvportfolioFrontendHelper::getAllTag();    
   }
?>
   <?php 
   if($tags && count($tags)):?>
  <div class="portfolioFilter">
      <div class="filter-link">
         <a class="current" data-filter="all" href="javascript:"><?php echo JText::_('TPL_K2_TAG_ALL')?></a> 
      </div>
      <?php foreach($tags as $item):?>
      <div class="filter-link">
         <a class="" data-filter="<?php echo $item->alias?>" href="javascript:"><?php echo $item->title?></a> 
      </div>
      <?php endforeach;?>
   </div>
<?php endif;?>
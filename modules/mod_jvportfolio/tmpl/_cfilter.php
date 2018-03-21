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
      <a class="current btn btn-default btn-sm" data-filter="all" href="javascript:" title="<?php echo JText::_('MOD_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_TAG_ALL')?>"><?php echo JText::_('MOD_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_TAG_ALL')?></a> 
      <?php foreach($tags as $item):?>
        <a class="btn btn-default btn-sm" data-filter="<?php echo $item->alias?>" href="javascript:" title="<?php echo $item->title?>"><?php echo $item->title?></a> 
      <?php endforeach;?>
   </div>
<?php endif;?>
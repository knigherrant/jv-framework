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
   $tag = $this->state->get('a.tag', 0);
   $cate = $this->state->get('a.cate', 0);
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
   <?php if(isset($tags) && !is_null($tags)):?>
  <div class="portfolioFilter hidden-xs">
      <a class="current btn btn-default" data-filter="all" href="javascript:"><?php echo JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_TAG_ALL')?></a> 
      <?php foreach($tags as $item):?>
         <a class="btn btn-default" data-filter="<?php echo $item->alias?>" href="javascript:"><?php echo $item->title?></a> 
      <?php endforeach;?>
   </div>
<?php endif;?>
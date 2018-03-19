<?php
   /**
    * @version     1.0.0
    * @package     com_jvportfolio
    * @copyright   Copyright (C) 2014. All rights reserved.
    * @license     GNU General Public License version 2 or later; see LICENSE.txt
    * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
    */
   // no direct access
   defined('_JEXEC') or die;    
   ?>
<?php if ($this->item) : ?>
<div class="portfolio-detail-default portfolio-detail-style2 clearfix">
  <div class="row">
    <?php if ($this->item->pfo_v) { ?>
      <div class="col-sm-12 mb-50">
        <div class="pfo-detail-video">
          <?php echo $this->item->pfo_v;?>
        </div>
      </div>
    <?php } else { ?>
      <?php if ($this->item->gallery) { ?>
      <div class="col-sm-12 mb-50">
        <div class="carouselOwl pfo-detail-gallery" 
          data-singleitem="true" 
          data-navigation="true"
        >
          <?php foreach($this->item->gallery as $i=>$path):?>
            <div>
              <img src="<?php echo $path?>" alt="<?php echo $this->item->name?>"> 
            </div>
          <?php endforeach;?>
        </div>
      </div>
      <!-- end col -->

      <?php } ?>
    <?php } ?>
  </div>
  <div class="row">
    <div class="col-sm-8">
        <h2 class="pfo-detail-title mt-0 pull-left"><?php echo $this->item->name?></h2>
        <div class="pfo-detail-info pull-right">
          <div class="pfo-detail-like" data-href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$this->item->id}"?>" data-pfvote="<?php echo $this->item->id?>" data-pfview="> h5">
            <i class="fa fa-heart"></i>
            <h5><?php echo $this->item->cliked?></h5>
          </div>
          <div class="pfo-detail-share"><?php echo $this->params->get( 'btnsocial', '' ); ?></div>
        </div>
        <div class="clearfix"></div>
        <div class="pfo-detail-desc pt-20 mb-40 "><?php echo $this->item->desc?></div>
    </div>
    <div class="col-sm-4">
      <div class="pfo-detail-body">        
        <div class="pfo-detail-info mb-30">
          <h6 class="mt-0"><?php echo JText::_('Clients: ')?></h6>
          <div><?php echo $this->item->created_by_name?></div>
        </div>
        <div class="pfo-detail-info mb-30">
          <h6 class="mt-0"><?php echo JText::_('Date: ')?></h6>
          <div><?php echo date('F d, Y', strtotime($this->item->date_created))?></div>
        </div>
        <div class="pfo-detail-info mb-30">
          <h6 class="mt-0"><?php echo JText::_('Categories: ')?></h6>
          <div><?php echo $this->item->cate; ?></div>
        </div>
        <div class="pfo-detail-info mb-30">
          <h6 class="mt-0"><?php echo JText::_('Tags: ')?></h6>
          <div><?php echo $this->item->tag; ?></div>
        </div>
        
      </div>
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->
   <div class="field">
      <?php if(  $extrafields = JvportfolioFrontendHelper::getExtraField( $this->item ) ) : ?>
      <?php foreach( $extrafields as $gid => $controls ) : ?>
        <?php foreach( $controls as $label => $value ) : ?>
          <div class="extrafields">
            <label for=""><?php echo $label; ?></label>
            <div><?php echo $value; ?></div>
          </div>
        <?php endforeach;?>
      <?php endforeach; ?>
    <?php endif; ?>
   </div>
   <!-- end div.col-md -->
   <?php 
    JPluginHelper::importPlugin('portfolio');
    $dispatcher = JDispatcher::getInstance();
    ?>
    <?php if( ( $citems = $dispatcher->trigger('onNav', array( $this->item->id ) ) ) && is_array( $citems ) && count( $citems ) ) : ?>
    <?php $citems = array_shift($citems); ?>
    <div class="pfo-detail-navigation mt-20 pt-30 clearfix">
          <?php if( $citems->prev ) : ?>
            <a href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$citems->prev}")?>" class="pull-left">
              <i class="fa fa-angle-left"></i>
            </a>
          <?php endif; ?>
          <?php if( $citems->next ) : ?>
            <a href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$citems->next}")?>" class="pull-right">
              <i class="fa fa-angle-right"></i>
            </a>
          <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php
else:
   echo JText::_('COM_JVPORTFOLIO_ITEM_NOT_LOADED');
endif;
?>


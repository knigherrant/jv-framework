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
  $document   = JFactory::getDocument();
  $document->addScriptDeclaration('
    (function($){
      $(function(){
        $(".gallery-inner").imagesLoaded( function() {
          var $grid = $(".gallery-inner"),
            $sizer = $grid.find(".col-md-3");

            $grid.shuffle({
              itemSelector: \'.masonry-item\',
              sizer: $sizer
            });
        });     
      });
    })(jQuery); 
  ');   
?>
<?php if ($this->item) : ?>
<div class="portfolio-detail-default portfolio-detail-masonry clearfix">
  <div class="row">
    <?php if ($this->item->pfo_v) { ?>
      <div class="col-sm-12">
        <div class="pfo-detail-video mb-30">
          <?php echo $this->item->pfo_v;?>
        </div>
      </div>
    <?php } else { ?>
      <?php if ($this->item->gallery) { ?>
        <div class="col-sm-12 pfo-masonry mb-30 gallery style-3">
          <div class="gallery-inner row sigProThumb">
            <?php foreach($this->item->gallery as $i=>$path):?>
              <?php $cols = (($i+1) == 1)?'col-xxs-12 col-xs-6 col-sm-6 col-md-6':'col-xxs-6 col-xs-3 col-sm-3 col-md-3';?>
              <div class="masonry-item <?php echo $cols;?>">
                <div class="image style-3">
                  <div class="image-inner">
                    <a href="<?php echo $path?>" title="">
                      <i class="fa fa-search"></i>
                      <img src="<?php echo $path?>" alt="">
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach;?>
          </div>            
        </div>
        <!-- end col -->
        <?php } ?>

    <?php } ?>
    <div class="col-sm-12">
      <div class="pfo-detail-body">
        <div class="row">
          <div class="col-xs-12 col-sm-9">
            <div class="clearfix">
              <h2 class="pfo-detail-title mt-0 pull-left"><?php echo $this->item->name?></h2>
              <div class="pfo-detail-info pull-right">
                <div class="pfo-detail-like" data-href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$this->item->id}"?>" data-pfvote="<?php echo $this->item->id?>" data-pfview="> h5">
                  <i class="fa fa-heart"></i>
                  <h5><?php echo $this->item->cliked?></h5>
                </div>
                <div class="pfo-detail-share"><?php echo $this->params->get( 'btnsocial', '' ); ?></div>
              </div>
            </div>            
            <div class="pfo-detail-desc pt-20 mb-40"><?php echo $this->item->desc?></div>
            <div class="field">
              <?php if(  $extrafields = JvportfolioFrontendHelper::getExtraField( $this->item ) ) : ?>
              <hr />
              <?php foreach( $extrafields as $gid => $controls ) : ?>
                <?php foreach( $controls as $label => $value ) : ?>
                  <div class="extrafields">
                    <label for="" class="text-bold"><?php echo $label; ?></label> <?php echo $value; ?>
                  </div>
                <?php endforeach;?>
              <?php endforeach; ?>
              <hr />
            <?php endif; ?>
           </div>
          </div> 
          <div class="col-xs-12 col-sm-3">
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
      </div>
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->
   
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



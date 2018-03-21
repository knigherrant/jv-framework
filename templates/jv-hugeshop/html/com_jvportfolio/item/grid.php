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
  jimport( 'joomla.plugin.helper' );
  jimport( 'joomla.html.html' );
  
  if( !class_exists( 'ModJvPortfolioHelper' ) )
  {
    require_once JPATH_SITE.'/modules/mod_jvportfolio/helper.php';
  }
  $show_title   = $this->params->get( 'show_title', '1' );
  $show_desc    = $this->params->get( 'show_desc', '1' );
  $show_date    = $this->params->get( 'show_date', '1' );
  $show_cat     = $this->params->get( 'show_cat', '1' );
  $show_client  = $this->params->get( 'show_client', '1' );
  $show_tag     = $this->params->get( 'show_tag', '1' );
  $show_link    = $this->params->get( 'show_link', '0' );
  $show_vote    = $this->params->get( 'show_vote', '1' );
  $show_related = $this->params->get( 'show_related', '0' );
?>
<?php if ($this->item) : ?>
<div class="portfolio-detail-default portfolio-detail-grid clearfix">
  <div class="row">
    <?php if ($this->item->pfo_v) { ?>
      <div class="col-sm-12">
        <div class="pfo-detail-video mb-30">
          <?php echo $this->item->pfo_v;?>
        </div>
      </div>
    <?php } else { ?>
      <?php if ($this->item->gallery) { ?>
        <div class="col-sm-12 pfo-grid mb-30 sigProThumb">
          <div class="row">
            <?php foreach($this->item->gallery as $i=>$path):?>
              <div class="col-xs-4">
                <div class="pfo-detail-image" style="background-image: url(<?php echo $path?>);">
                  <a href="<?php echo $path?>"><i class="fa fa-search"></i></a>
                </div>
              </div>
            <?php endforeach;?>
          </div>            
        </div>
        <!-- end col -->
        <?php } ?>
    <?php } ?>
    <div class="col-sm-12">
        <h2 class="pfo-title"><?php echo JText::_("TPL_PORTFOLIO_ABOUT_THIS_PROJECT"); ?></h2>
        <div class="row">
          <div class="col-xs-12 col-sm-8">
            <div class="pfo-detail-top">
              <?php if ($show_title) : ?>
              <h4 class="pfo-detail-title text-uppercase"><?php echo $this->item->name?></h4>
              <?php endif; ?>
              <?php if ($show_client && !empty($this->item->created_by_name)) : ?>
                <div class="pfo-detail-by text-uppercase">
                  <span class="pfo-label"><?php echo JText::_('TPL_PORTFOLIO_POST_BY')?></span>
                  <span><?php echo $this->item->created_by_name?></span>
              </div>
              <!-- end col -->
              <?php endif; ?>
            </div>          
            <?php if ($show_desc && !empty($this->item->desc)) : ?>  
            <div class="pfo-detail-desc pt-20 mb-40"><?php echo $this->item->desc?></div>
            <?php endif; ?>
          </div> 
          <div class="col-xs-12 col-sm-4">
            <div class="pfo-detail-body">
              <div class="row">
                <?php if(  $extrafields = JvportfolioFrontendHelper::getExtraField( $this->item ) ) : ?>
                  <?php foreach( $extrafields as $gid => $controls ) : ?>
                    <?php foreach( $controls as $label => $value ) : ?>
                      <div class="col-md-12">
                        <div class="pfo-detail-info">
                          <h6 class="mt-0"><?php echo $label; ?>:</h6>
                          <div><?php echo $value; ?></div>
                        </div>
                      </div>
                      <!-- end col -->
                    <?php endforeach;?>
                  <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($show_cat && !empty($this->item->cate)) : ?>
                <div class="col-xs-12">
                  <div class="pfo-detail-info">
                    <h6 class="mt-0"><?php echo JText::_('TPL_PFO_CATEGORIES')?></h6>
                    <div><?php echo $this->item->cate; ?></div>
                  </div>
                </div>
                <!-- end col -->
                <?php endif; ?>
                <?php if ($show_date) : ?>
                <div class="col-xs-12">
                  <div class="pfo-detail-info">
                    <h6 class="mt-0"><?php echo JText::_('TPL_PFO_DATE')?></h6>
                    <div><?php echo date(JText::_('TPL_DATE_FORMAT_03'), strtotime($this->item->date_created))?></div>
                  </div>
                </div>
                <!-- end col -->
                <?php endif; ?>
                <?php endif; ?>
                <?php if ($show_link && !empty($this->item->link)) : ?>
                <div class="col-xs-12">
                  <div class="pfo-detail-info">
                    <h6 class="mt-0"><?php echo JText::_('TPL_PORTFOLIO_LIVE_DEMO')?>:</h6>
                    <div><a href="<?php echo $this->item->link; ?>" target="_blank" title="<?php echo $this->item->link; ?>"><?php echo $this->item->link; ?></a></div>
                  </div>
                </div>
                <?php endif; ?>
                 <?php if ($show_tag && !empty($this->item->tag)) : ?>
                <div class="col-xs-12">
                  <div class="pfo-detail-info">
                    <h6 class="mt-0"><?php echo JText::_('TPL_PFO_TAGS')?></h6>
                    <div><?php echo $this->item->tag; ?></div>
                  </div>
                </div>
                <!-- end col -->          
              </div>
              <!-- end row -->
              <?php if ($show_vote || (!empty($this->params->get( 'btnsocial', '' ))) ) : ?>
              <div class="pfo-bottom-info mt-40">
                <?php if ($show_vote) : ?>
                <div class="pfo-detail-like" data-href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$this->item->id}"?>" data-pfvote="<?php echo $this->item->id?>" data-pfview="> h5">
                  <i class="fa fa-heart"></i>
                  <h5><?php echo $this->item->cliked?></h5>
                </div>
                <?php endif; ?>
                <?php if (!empty($this->params->get( 'btnsocial', '' ))) : ?>
                <div class="pfo-detail-share"><?php echo $this->params->get( 'btnsocial', '' ); ?></div>
                <?php endif; ?>
              </div>
              <?php endif; ?>
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
    <?php if( 
      property_exists( $this->item, 'tags_id')
      && $show_related 
      && ( $tags_id = $this->item->tags_id ) 
      && ( $tags_id = explode( ',', $tags_id ) ) 
      && ( $rItems = ModJvPortfolioHelper::getItems( 0 , $tags_id, 0, 10 ) )
      && property_exists( $rItems, 'items' )
      && count($rItems->items) > 1
    ) : ?>
    <hr class="mt-40" />
    <div class="pfo-related pt-20 portfolio-style portfolio4"> 
      <div class="heading-style1 mb-40">
        <h3 class="heading-cont text-bold text-uppercase"><?php echo  JText::_('TPL_PORTFOLIO_RELATED');?></h3>
      </div>
      <div class="pfo-related-items box-portfolio row">
        <div class="carouselOwl" 
            data-items="4" 
            data-itemsdesktop="4" 
            data-itemsdesktopsmall="3" 
            data-itemstablet="3" 
            data-itemstabletsmall="2" 
            data-itemsmobile="1" 
        >
          <?php $cid = $this->item->id; ?>
          <?php $rlen = 0; ?>
          <?php foreach( $rItems->items as $ri => $ritem ) : ?>
            <?php if( $ritem->id != $cid ) :?>
              <div class="col-xs-12">
                <div class="pfo-item mb-0" style="position:static;opacity: 1;">
                  <div class="pfo-body">
                    <div class="pfo-image">
                      <div class="img" style="background-image:url(<?php echo JURI::root().$ritem->image; ?>);"><img class="hidden" src="<?php echo JURI::root().$ritem->image; ?>" alt="<?php echo $ritem->name; ?>"></div>
                    </div>
                    <div class="pfo-content">
                      <div class="pfo-content-table">
                        <div class="pfo-content-table-cell">
                          <div class="pfo-links">
                            <?php if($ritem->gallery):?> 
                              <a class="link-quick" href="javascript:void(0)" data-imgs='<?php echo json_encode($ritem->gallery)?>' data-qview="lightbox" title="<?php echo JText::_("TPL_PORTFOLIO_ZOOM"); ?>"><i class="huge-eye"></i></a>
                            <?php endif?>
                            <a class="link-detail" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$ritem->id}")?>" title="<?php echo JText::_("TPL_PORTFOLIO_VIEW"); ?>"><i class="huge-link"></i></a> 
                          </div>
                          <a class="pfo-title text-uppercase mb-0" href="<?php echo JRoute::_("index.php?option=com_jvportfolio&view=item&id={$ritem->id}")?>"> 
                            <?php echo $ritem->name; ?>
                          </a>  
                           <span class="pfo-hasTag text-uppercase"><?php echo $ritem->tag; ?></span>  
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>              
              <?php $rlen ++; ?>
            <?php endif; ?>
          <?php endforeach; ?>        
        </div>
      </div>      
      <!-- end list -->
    </div>
  <?php endif; ?>
</div>
<?php
else:
   echo JText::_('COM_JVPORTFOLIO_ITEM_NOT_LOADED');
endif;
?>



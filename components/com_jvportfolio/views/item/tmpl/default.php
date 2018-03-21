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
  $show_link    = $this->params->get( 'show_link', '1' );
  $show_vote    = $this->params->get( 'show_vote', '1' );
  $show_related = $this->params->get( 'show_related', '1' );
  $show_details = 1;
?>
<?php if ($this->item) : ?>
<div class="item_fields clearfix">
   <div data-portfolio-detail="" class="gallery">
         <?php foreach($this->item->gallery as $i=>$path):?>
         <div class="item <?php echo(!$i ? 'active' : '')?>">
            <img src="<?php echo $path?>" alt="<?php echo $this->item->name?>"> 
         </div>
         <hr />
         <?php endforeach;?>
   </div>
   <div class="content">
      <?php if ($show_title) : ?>
      <h2><?php echo $this->item->name?></h2>
      <?php endif; ?>
      <?php if ($show_desc && !empty($this->item->desc)) : ?>
      <div class="desc">
         <label class=""><?php echo JText::_('COM_JVPORTFOLIO_DESCRIPTION')?></label>
         <p><?php echo $this->item->desc?></p>
      </div>
      <?php endif; ?>
   </div>
   <div class="field">
      <?php if ($show_date) : ?>
      <p>
         <label class=""><?php echo JText::_('COM_JVPORTFOLIO_DATE')?></label>
          <span><?php echo date(JText::_('COM_JVPORTFOLIO_DATE_FORMAT'), strtotime($this->item->date_created))?></span>
      </p>
      <?php endif; ?>
      <?php if ($show_client && !empty($this->item->created_by_name)) : ?>
      <p>
         <label class=""><?php echo JText::_('COM_JVPORTFOLIO_CLIENTS')?></label>
         <?php echo $this->item->created_by_name?>
      </p>
      <?php endif;?>
      <?php if ($show_cat && !empty($this->item->cate)) : ?>
      <p>
         <label class=""><?php echo JText::_('COM_JVPORTFOLIO_CATEGORIES')?></label>
         <?php echo $this->item->cate?>
      </p>
      <?php endif;?>
      <?php if ($show_tag && !empty($this->item->tag)) : ?>
      <p>
         <label class=""><?php echo JText::_('COM_JVPORTFOLIO_TAGS')?></label>
         <?php echo $this->item->tag?>
      </p>
      <?php endif;?>
      <?php if ($show_link && !empty($this->item->link)) : ?>
      <p>
         <label class=""><?php echo JText::_('COM_JVPORTFOLIO_EXTEND_LINK')?></label>
         <?php echo $this->item->link?>
      </p>
      <?php endif;?>
      <?php if (!empty($this->params->get( 'btnsocial', '' )) || $show_vote) : ?>
      <div class="social">
          <?php if (!empty($this->params->get( 'btnsocial', '' ))) : ?>
          <div class="itemPortfolioToolsItem pull-right"><?php echo $this->params->get( 'btnsocial', '' ); ?></div>
          <?php endif;?>
          <?php if ($show_vote) : ?>
          <div class="itemPortfolioToolsItem"><div class="likeheart" data-href="<?php echo JUri::root()."?option=com_jvportfolio&amp;task=items.toggleVote&amp;pfid={$this->item->id}"?>" data-pfvote="<?php echo $this->item->id?>" data-pfview="> h5"><i class="fa fa-heart"></i><h5 style="display: inline; margin: 0;"> <?php echo $this->item->cliked?></h5></div></div>
          <?php endif;?>
      </div>
      <?php endif;?>
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
</div>
<?php
else:
   echo JText::_('COM_JVPORTFOLIO_ITEM_NOT_LOADED');
endif;
?>

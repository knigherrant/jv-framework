<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2013 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------
*/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$thumbnail = $item->thumbnails;
if( ($columns > 6) ){
	$columns = 6;
}else if($columns==5){
	$columns = 4;	
}

?>
<li class="<?php if($columns > 1){ echo 'span'.(12/$columns); echo ' column'.($count)%$columns; }?> ">
        <!-- Before title -->       
        <?php if($index%2 === 0){ ?>
            <?php if($thumbnail != '' && $params->get('intro_thumbnail', 1) && $params->get('intro_thumbnail_position') == 'before' ){?>
                    <a class="thumbnail pull-<?php echo $params->get('intro_thumbnail_align', 'none'); ?> before <?php echo $params->get('intro_thumbnail_align'); ?>" href="<?php echo $item->link; ?>">
                        <img src="<?php echo $thumbnail ?>" alt="<?php echo $item->title; ?>" title="<?php echo $item->title; ?>" />
                    </a>
            <?php }?>
        <?php }?>
        
        <!-- Title -->   
        <?php if($params->get('show_title_intro', 1)) { ?>       
                <?php if((bool)$params->get('title_link_intro', '0')){?>
                	<a class="intro-title" href="<?php echo $item->link; ?>">
                    	<?php echo $item->title; ?>  
                    </a>     
                <?php } else { ?>
						<span class="intro-title"><?php echo $item->title; ?></span>
                <?php } ?>                
                
                
                
        <?php } ?>
        <!-- Published details -->
        <?php if (($params->get('show_intro_author')) || $params->get('show_intro_date')) : ?>
            <div class="intro-detail">
           
            <?php if (($params->get('show_intro_author')) && ($item->author != "")) : ?>            
                <span class="detail-author">
                    <?php echo JText::_( 'Written by '.$item->author ); ?>
                </span>            
            <?php endif; ?>
            <?php if ($params->get('show_intro_date')) : ?>
                <span class="detail-date">
                    <?php echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3')) ?>
            	</span>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        
        
        <!-- After title -->
        <?php if($index%2 === 0){ ?>
            <?php if($thumbnail != '' && $params->get('intro_thumbnail', 1) && $params->get('intro_thumbnail_position') == 'after' ){?>
                    <a class="thumbnail pull-<?php echo $params->get('intro_thumbnail_align', 'none'); ?> after <?php echo $params->get('intro_thumbnail_align'); ?>" href="<?php echo $item->link; ?>">
                        <img src="<?php echo $thumbnail ?>" alt="<?php echo $item->title; ?>" title="<?php echo $item->title; ?>" />
                    </a>
            <?php }?> 
        <?php }?> 
        
        <!-- Content -->
        <?php if($params->get('show_content_intro', 1)){  ?>
            <div class="content_intro"><?php echo $item->text; ?>...</div>
        <?php } ?>

        <!-- Before Content -->       
        <?php if($thumbnail != '' && $params->get('intro_thumbnail', 1) && $params->get('intro_thumbnail_position') == 'aftercontent' ){?>
                <a class="thumbnail pull-<?php echo $params->get('intro_thumbnail_align', 'none'); ?> before <?php echo $params->get('intro_thumbnail_align'); ?>" href="<?php echo $item->link; ?>">
                    <img src="<?php echo $thumbnail ?>" alt="<?php echo $item->title; ?>" title="<?php echo $item->title; ?>" />
                </a>
        <?php }?>
        
        <!-- Readmore -->
        <?php if($params->get('show_readmore_intro', 1)){?>
        <div class="readmore">
            <a class="intro-readmore" href="<?php echo $item->link; ?>" title="<?php echo $params->get('readmore_text', JText::_('MOD_JVLATEST_NEWS_READMORE'));?>">
                <span><?php echo $params->get('readmore_text', JText::_('MOD_JVLATEST_NEWS_READMORE'));?></span>
            </a>
        </div>    
        <?php } ?>
</li>

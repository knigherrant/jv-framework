<?php
/**
 * @version   $Id: default.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package   K2
 * @author    JoomlaWorks http://www.joomlaworks.net
 * @copyright Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="post-highlight<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">

    <?php if($params->get('itemPreText')): ?>
    <p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
    <?php endif; ?>

    <?php if(count($items)): ?>
        <div class="row">
            <?php foreach ($items as $key => $item):  ?>
                <?php $cols = ($key == 0)?'col-md-12 col-lg-6 highlight-first':'col-md-6 col-lg-3 highlight-default'; ?>
                <div class="<?php echo $cols; ?>">
                    <div class="highlight-item">
                            <?php if( ($params->get('itemImage') && isset($item->image)) ): ?>
                            <div class="post-image">
                                <a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;" style="background-image: url(<?php echo $item->image; ?>)">
                                  <img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
                                </a>
                            </div>
                            <!-- end image -->
                            <?php endif; ?>
                            <div class="post-content">
                                <div class="content-table">
                                    <div class="content-tablecell">
                                        <?php if($params->get('itemTitle')): ?>
                                        <h4 class="post-title mt-0">
                                            <a class="moduleItemTitle" title="<?php echo $item->title; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
                                        </h4>
                                        <?php endif; ?>
                                        <div class="post-meta">
                                            <?php if($params->get('itemAuthor')): ?>
                                            <span>
                                            <?php if(isset($item->authorLink)): ?>
                                            <a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><?php echo JText::_('TPL_BLOG_BY'); ?> <?php echo $item->author; ?></a>
                                            <?php else: ?>
                                            <span><?php echo JText::_('TPL_BLOG_BY'); ?> <?php echo $item->author; ?></span>
                                            <?php endif; ?>
                                            </span>
                                            <?php endif; ?>
                                            <?php if($params->get('itemDateCreated')): ?>
                                            <span>
                                            <span><?php echo JHTML::_('date', $item->created, 'M d, Y'); ?></span>
                                            </span>
                                            <?php endif; ?>

                                            <?php if($params->get('itemCategory')): ?>
                                            <span>
                                            <a class="moduleItemCategory" href="<?php echo $item->categoryLink; ?>"><?php echo JText::_('TPL_BLOG_IN'); ?>  <?php echo $item->categoryname; ?></a>  
                                            </span>           
                                            <?php endif; ?>
                                        </div>

                                        <?php if($params->get('itemReadMore') && ($key == 0) ): ?>
                                            <div class="post-readmore">
                                            <a class="btn btn-outline-thin btn-radius btn-white btn-sm" href="<?php echo $item->link; ?>">
                                                <?php echo JText::_('K2_READ_MORE'); ?>
                                            </a>
                                            </div>
                                        <?php endif; ?>  
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    <?php endif; ?>

    <?php if($params->get('itemCustomLink')): ?>
        <div class="text-center pt-70">
            <a class="btn btn-default btn-outline" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?></a>
        </div>
    
    <?php endif; ?>
    <?php if($params->get('feed')): ?>
    <div class="k2FeedIcon">
        <a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
        <span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
        </a>
        <div class="clr"></div>
    </div>
    <?php endif; ?>
</div>

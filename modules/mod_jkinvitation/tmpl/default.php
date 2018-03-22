<?php
/*
# JK Invitation
# @version		1.0.0
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2014 phpkungfu.club. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.phpkungfu.club
# Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="wd_about_infobox wd_toppadder20">
                                    <div class="wd_about_infobox_img">
                                            <span><img src="<?php echo JURI::root(); ?>modules/mod_jkinvitation/assets/images/line.png" alt="Line" class="img-responsive"></span>
                                            <?php if($params->get('man_image')){ ?>
                                                <img src="<?php echo JURI::root() . $params->get('man_image'); ?>" alt="Groom" class="img-responsive">
                                            <?php } ?>
                                    </div>
                                    <?php if($params->get('man_name')){ ?><h2><?php echo $params->get('man_name'); ?></h2><?php } ?>
                                    <?php if($params->get('man_surname')){ ?><p><?php echo $params->get('man_surname'); ?></p><?php } ?>
                                    <?php if($params->get('man_fb') || $params->get('man_tw') || $params->get('man_ins')){ ?>
                                    <ul>
                                             <?php if($params->get('man_fb')){ ?><li><a href="<?php echo $params->get('man_fb'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li><?php } ?>
                                             <?php if($params->get('man_tw')){ ?><li><a href="<?php echo $params->get('man_tw'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li><?php } ?>
                                             <?php if($params->get('man_ins')){ ?><li><a href="<?php echo $params->get('man_ins'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li><?php } ?>
                                    </ul>
                                    <?php } ?>
                            </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-21 col-xs-12 col-lg-push-4 col-md-push-4 col-sm-push-0">
                            <div class="wd_about_infobox wd_toppadder20">
                                    <div class="wd_about_infobox_img">
                                            <span><img src="<?php echo JURI::root(); ?>modules/mod_jkinvitation/assets/images/line.png" alt="Line" class="img-responsive"></span>
                                            <?php if($params->get('woman_image')){ ?>
                                                <img src="<?php echo JURI::root() . $params->get('woman_image'); ?>" alt="Groom" class="img-responsive">
                                            <?php } ?>
                                    </div>
                                    <?php if($params->get('woman_name')){ ?><h2><?php echo $params->get('woman_name'); ?></h2><?php } ?>
                                    <?php if($params->get('woman_surname')){ ?><p><?php echo $params->get('woman_surname'); ?></p><?php } ?>
                                    <?php if($params->get('woman_fb') || $params->get('woman_tw') || $params->get('woman_ins')){ ?>
                                    <ul>
                                             <?php if($params->get('woman_fb')){ ?><li><a href="<?php echo $params->get('woman_fb'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li><?php } ?>
                                             <?php if($params->get('woman_tw')){ ?><li><a href="<?php echo $params->get('woman_tw'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li><?php } ?>
                                             <?php if($params->get('woman_ins')){ ?><li><a href="<?php echo $params->get('woman_ins'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li><?php } ?>
                                    </ul>
                                    <?php } ?>
                            </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-pull-4 col-md-pull-4 col-sm-pull-0">
                            <div class="wd_about_infobox">
                                    <?php if($params->get('name')){ ?><h1><?php echo $params->get('name'); ?></h1><?php } ?>
                                    <div class="wd_about_infobox_date">
                                            <?php if($params->get('desc')){ ?><p><?php echo $params->get('desc'); ?></p><?php } ?>
                                            <?php if($params->get('day')){ ?><h3><?php echo $params->get('day'); ?></h3><?php } ?>
                                            <?php if($params->get('date')){ ?><h2><?php echo JHTML::_('date',$params->get('date'), JText::_('TPL_DATE_FORMAT_03')); ?></h2><?php } ?>
                                            <?php if($params->get('location')){ ?><p><?php echo $params->get('location'); ?></p><?php } ?>
                                    </div>
                                    <div class="wd_btn wd_single_index_menu_rsvp">
                                            <?php if($params->get('rsvp')){ ?><a href="<?php echo $params->get('rsvp'); ?>">rsvp</a><?php } ?>
                                    </div>
                            </div>
                    </div>
                   